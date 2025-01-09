<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapitulasiPenerimaanPerUserController extends Controller
{
    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        $this->trnkbService = $trnkbService;
    }

    public function showForm()
    {
        $page_title = 'Rekapitulasi Penerimaan Harian Per User';

        $kdLokasi = Auth::user()->kd_lokasi;

        $prefix = substr($kdLokasi, 0, 2);

        // Fetch all lokasi starting with the prefix
        $lokasi = Lokasi::on(\Auth::user()->kd_wilayah)->where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        $action = 'form_laporan';

        return view('page.laporan.rekapitulasi-penerimaan-user.index', compact('page_title', 'action', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.rekapitulasi-penerimaan-user.data', [
            'page_title' => $data['page_title'],
            'data_rekap' => $data['data_rekap'],
            'tanggal' => $data['tanggal'],
            'lokasi' => $data['lokasi'],
            'kd_lokasi' => $data['kd_lokasi'],
            'dataPenerimaanOpsen' => $data['dataPenerimaanOpsen'],
            'dataRekeningWilayah' => $data['dataRekeningWilayah'],
            'dataTotal' => $data['dataTotal'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = 'Rekapitulasi Penerimaan (Ringkas) Tanggal ' . $data['tanggal'] . ' di ' . $data['lokasi']->nm_lokasi;
        $pdf = Pdf::loadView('page.laporan.rekapitulasi-penerimaan-user.export-pdf', [
            'page_title' => $data['page_title'],
            'data_rekap' => $data['data_rekap'],
            'tanggal' => $data['tanggal'],
            'lokasi' => $data['lokasi'],
            'kd_lokasi' => $data['kd_lokasi'],
            'dataPenerimaanOpsen' => $data['dataPenerimaanOpsen'],
            'dataRekeningWilayah' => $data['dataRekeningWilayah'],
            'dataTotal' => $data['dataTotal'],
        ]);
        return $pdf->stream($file_name . '.pdf');
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $lokasi = $this->getLokasi($kd_lokasi);

        $data_rekap = $this->trnkbService->getRekapharianUser($tanggal, $kd_lokasi);

        $dataPenerimaanOpsen = $this->trnkbService->getDataPenerimaanOpsen($tanggal, $kd_lokasi);

        $dataRekeningWilayah = [
            "001" => '701500048',
            "002" => '501500011',
            "003" => '601500019',
            "004" => '401560009',
            "005" => '201500017',
            "006" => '301500017',
            "007" => '611500025',
            "008" => '711500014',
            "009" => '801560008',
            "010" => '901500045',
            "011" => '301500084',
        ];

        $dataTotal = $this->calculateTotals($data_rekap);

        return compact('page_title', 'data_rekap', 'dataRekeningWilayah', 'tanggal', 'lokasi', 'dataPenerimaanOpsen', 'dataTotal', 'kd_lokasi');
    }

    private function validateFormRequest(Request $request)
    {
        return $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
        ]);
    }

    private function getLokasi($kd_lokasi)
    {
        $lokasi = Lokasi::on(\Auth::user()->kd_wilayah)->find($kd_lokasi);

        if (!$lokasi) {
            $lokasiDefaults = [
                '01' => 'UPTD PPD SAMSAT KOTA JAMBI',
                '02' => 'UPTD PPD SAMSAT KAB. BATANGHAR',
                '03' => 'UPTD PPD SAMSAT KAB. TANJAB BARAT',
                '04' => 'UPTD PPD SAMSAT KAB. MERANGIN',
                '05' => 'UPTD PPD SAMSAT KAB. BUNGO',
                '06' => 'UPTD PPD SAMSAT KAB. KERINCI',
                '07' => 'UPTD PPD SAMSAT KAB. TANJAB TIMUR',
                '08' => 'UPTD PPD SAMSAT KAB. MUARO JAMBI',
                '09' => 'UPTD PPD SAMSAT KAB. SAROLANGUN',
                '10' => 'UPTD PPD SAMSAT KAB. TEBO',
            ];

            $nm_lokasi = $lokasiDefaults[$kd_lokasi] ?? 'SAMSAT PROVINSI JAMBI';
            $lokasi = (object) [
                'kd_lokasi' => $kd_lokasi,
                'nm_lokasi' => $nm_lokasi,
                'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                'rpthdr2' => $nm_lokasi,
                'rpthdr3' => '',
            ];
        }

        return $lokasi;

    }

    private function calculateTotals($data_rekap)
    {
        // Initialize totals for the entire dataset
        $total_bbn = 0;
        $total_pkb = 0;
        $total_swd = 0;
        $total_opsen_bbnkb = 0;
        $total_opsen_pkb = 0;
        $total_pnbp = 0;

        // Initialize an array to store totals for each individual element
        $totals_per_item = [];

        // Loop through the array and calculate totals
        foreach ($data_rekap as $item) {
            $item_total_bbn = $item->bbn_pok + $item->bbn_den;
            $item_total_pkb = $item->pkb_pok + $item->pkb_den;
            $item_total_swd = $item->swd_pok + $item->swd_den;
            $item_total_opsen_bbnkb = $item->opsen_bbn_pok + $item->opsen_bbn_den;
            $item_total_opsen_pkb = $item->opsen_pkb_pok + $item->opsen_pkb_den;
            $item_total_pnbp = $item->adm_stnk + $item->plat_nomor;
            $item_total_seluruh = $item_total_bbn + $item_total_pkb + $item_total_swd + $item_total_opsen_bbnkb + $item_total_opsen_pkb;

            // Add totals for the individual item to the array
            $totals_per_item[] = [
                'total_bbn' => $item_total_bbn,
                'total_pkb' => $item_total_pkb,
                'total_swd' => $item_total_swd,
                'total_pnbp' => $item_total_pnbp,
                'total_opsen_pkb' => $item_total_opsen_pkb,
                'total_opsen_bbnkb' => $item_total_opsen_bbnkb,
                'total_seluruh' => $item_total_seluruh,
            ];

            // Add individual totals to the overall totals
            $total_bbn += $item_total_bbn;
            $total_pkb += $item_total_pkb;
            $total_swd += $item_total_swd;
            $total_opsen_bbnkb += $item_total_opsen_bbnkb;
            $total_opsen_pkb += $item_total_opsen_pkb;
            $total_pnbp += $item_total_pnbp;
        }

        // Calculate the grand total for all items
        $total_seluruh = $total_bbn + $total_pkb + $total_swd + $total_opsen_bbnkb + $total_opsen_pkb;

        // Return the results
        return [
            'totals_per_item' => $totals_per_item, // Totals for each individual item
            'grand_totals' => [ // Grand totals for all items
                'total_bbn' => $total_bbn,
                'total_pkb' => $total_pkb,
                'total_swd' => $total_swd,
                'total_pnbp' => $total_pnbp,
                'total_opsen_pkb' => $total_opsen_pkb,
                'total_opsen_bbnkb' => $total_opsen_bbnkb,
                'total_seluruh' => $total_seluruh,
            ],
        ];

    }

}

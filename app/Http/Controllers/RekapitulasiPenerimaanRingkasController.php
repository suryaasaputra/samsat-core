<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapitulasiPenerimaanRingkasController extends Controller
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
        $page_title = 'Rekapitulasi Penerimaan Harian (Mendetail)';

        $kdLokasi = Auth::user()->kd_lokasi;

        $prefix = substr($kdLokasi, 0, 2);

        // Fetch all lokasi starting with the prefix
        $lokasi = Lokasi::on(\Auth::user()->kd_wilayah)->where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        $action = 'form_laporan';

        return view('page.laporan.rekapitulasi-penerimaan-ringkas.index', compact('page_title', 'action', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.rekapitulasi-penerimaan-ringkas.data', [
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
        $pdf = Pdf::loadView('page.laporan.rekapitulasi-penerimaan-ringkas.export-pdf', [
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

        $data_rekap = $this->trnkbService->getRekapharian($tanggal, $kd_lokasi);
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
        $total_bbn = $data_rekap->bbn1_pok + $data_rekap->bbn2_pok + $data_rekap->bbn1_den + $data_rekap->tgk_bbn1_pok + $data_rekap->tgk_bbn1_den + $data_rekap->tgk_bbn2_pok + $data_rekap->tgk_bbn2_den;
        $total_pkb = $data_rekap->pkb_pok + $data_rekap->pkb_den + $data_rekap->tgk_pkb_pok + $data_rekap->tgk_pkb_den;
        $total_swd = $data_rekap->swd_pok + $data_rekap->swd_den + $data_rekap->tgk_swd_pok + $data_rekap->tgk_swd_den;
        $total_opsen_bbnkb = $data_rekap->opsen_bbn_pok + $data_rekap->opsen_bbn_den + $data_rekap->tgk_opsen_bbn_pok + $data_rekap->tgk_opsen_bbn_den;
        $total_opsen_pkb = $data_rekap->opsen_pkb_pok + $data_rekap->opsen_pkb_den + $data_rekap->tgk_opsen_pkb_pok + $data_rekap->tgk_opsen_pkb_den;
        $total_pnbp = $data_rekap->adm_stnk + $data_rekap->plat_nomor;
        $total_seluruh = $total_bbn + $total_opsen_bbnkb + $total_pkb + $total_opsen_pkb + $total_swd;

        return [
            'total_bbn' => $total_bbn,
            'total_pkb' => $total_pkb,
            'total_swd' => $total_swd,
            'total_pnbp' => $total_pnbp,
            'total_opsen_pkb' => $total_opsen_pkb,
            'total_opsen_bbnkb' => $total_opsen_bbnkb,
            'total_seluruh' => $total_seluruh,
        ];
    }

}

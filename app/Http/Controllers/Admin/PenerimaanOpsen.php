<?php
namespace App\Http\Controllers\Admin;

use App\Exports\RekapOpsenExport;
use App\Exports\RincianPenerimaanOpsen;
use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenerimaanOpsen extends Controller
{
    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        $this->trnkbService = $trnkbService;
        $this->middleware('role:Admin|Monitoring|PIC Opsen Pajak Pemda Kab/Kota');
    }

    public function showForm()
    {
        $page_title = 'Penerimaan Opsen Kab/Kota';

        if (auth()->user()->hasRole('PIC Opsen Pajak Pemda Kab/Kota')) {
            $kd_wilayah_user = auth()->user()->kd_wilayah;
            $wilayah         = Wilayah::where('kd_wilayah', $kd_wilayah_user)->get();
        } else if (auth()->user()->hasRole('Admin|Monitoring')) {
            $wilayah = Wilayah::all();
        } else {
            $wilayah = collect([]); // Jika bukan role yang diizinkan, kosongkan opsi
        }

        // Fetch all wilayah for the dropdown

        $action = 'form_laporan_admin';

        return view('page.laporan.admin.penerimaan-opsen.index', compact('page_title', 'action', 'wilayah'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);
        // dd($data);

        return view('page.laporan.admin.penerimaan-opsen.data', [
            'page_title'     => $data['page_title'],
            'tanggal'        => $data['tanggal'],
            'tg_awal'        => $data['tg_awal'],
            'tg_akhir'       => $data['tg_akhir'],
            'kd_wilayah'     => $data['kd_wilayah'],
            'nm_wilayah'     => $data['nm_wilayah'],
            'dataRekapOpsen' => $data['dataRekapOpsen'],
            'dataTotals'     => $data['dataTotals'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = 'Rekapitulasi Penerimaan Opsen ' . $data['nm_wilayah'] . ' ' . $data['tg_awal'] . ' sd ' . $data['tg_akhir'];
        $pdf       = Pdf::loadView('page.laporan.admin.penerimaan-opsen.export-pdf', [
            'page_title'     => $data['page_title'],
            'tanggal'        => $data['tanggal'],
            'tg_awal'        => $data['tg_awal'],
            'tg_akhir'       => $data['tg_akhir'],
            'kd_wilayah'     => $data['kd_wilayah'],
            'nm_wilayah'     => $data['nm_wilayah'],
            'dataRekapOpsen' => $data['dataRekapOpsen'],
            'dataTotals'     => $data['dataTotals'],
        ]);
        return $pdf->stream($file_name . '.pdf');
    }

    public function exportToExcel(Request $request)
    {
        $data = $this->prepareData($request);

        $fileName = 'Rekapitulasi Penerimaan Opsen ' . $data['nm_wilayah'] . ' ' . $data['tg_awal'] . ' sd ' . $data['tg_akhir'] . '.xlsx';

        return Excel::download(new RekapOpsenExport($data), $fileName);
    }

    public function unduhRincian(Request $request)
    {
        $this->middleware('role:Admin|Monitoring');
        $validated = $request->validate([
            'tanggal'    => 'required|string',
            'kd_wilayah' => 'nullable|string',
        ]);

        $tanggal = $validated['tanggal'];

        list($tg_awal, $tg_akhir) = explode(' - ', $validated['tanggal']);

        // Convert the dates to Y-m-d format using Carbon
        $tg_awal  = Carbon::createFromFormat('m/d/Y', trim($tg_awal))->format('Y-m-d');
        $tg_akhir = Carbon::createFromFormat('m/d/Y', trim($tg_akhir))->format('Y-m-d');

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';
        $kd_wilayah = $validated['kd_wilayah'];
        $nm_wilayah = Wilayah::find($kd_wilayah)->nm_wilayah;

                                       // Define an array of wilayah codes from '001' to '010'
        $allDB         = range(1, 10); // Generates [1, 2, 3, ..., 10]
        $dataTransaksi = [];

        // $dataTransaksiInduk = $this->trnkbService->getLaporanTransaksiRentangWaktuByKdWilayahOnInduk($tg_awal, $tg_akhir, $kd_wilayah)->toArray();

        foreach ($allDB as $db) {
            // Convert to three-digit string (e.g., '001', '002')
            $kd_db = str_pad($db, 3, '0', STR_PAD_LEFT);

            // Get transaksi data for this wilayah
            $result = $this->trnkbService->getLaporanTransaksiRentangWaktuByKdWilayah($tg_awal, $tg_akhir, $kd_db, $kd_wilayah);

            // Merge the result into the combined dataTransaksi array
            $dataTransaksi = array_merge($dataTransaksi, $result->toArray());
        }

        $sumJumlah = $this->calculateSumJumlah($dataTransaksi);

        $fileName = 'Rincian_Penerimaan_' . $nm_wilayah . '_Tanggal_' . $tg_awal . '_sd_' . $tg_akhir . '.xlsx';

        return Excel::download(new RincianPenerimaanOpsen([
            'dataTransaksi' => $dataTransaksi,
            'tanggal'       => $tanggal,
            'tg_awal'       => $tg_awal,
            'tg_akhir'      => $tg_akhir,
            'kd_wilayah'    => $kd_wilayah,
            'nm_wilayah'    => $nm_wilayah,
            'sumJumlah'     => $sumJumlah,
        ]), $fileName);
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);
        $tanggal   = $validated['tanggal'];

        list($tg_awal, $tg_akhir) = explode(' - ', $validated['tanggal']);

        // Convert the dates to Y-m-d format using Carbon
        $tg_awal  = Carbon::createFromFormat('m/d/Y', trim($tg_awal))->format('Y-m-d');
        $tg_akhir = Carbon::createFromFormat('m/d/Y', trim($tg_akhir))->format('Y-m-d');

        $kd_wilayah = $validated['kd_wilayah'];
        $nm_wilayah = Wilayah::find($kd_wilayah)->nm_wilayah;
        $page_title = 'Penerimaan Opsen ' . $nm_wilayah . ' ' . $tanggal;

        $dataRekapOpsen = [];

        $allWilayahs = range(1, 10); // Generates [1, 2, 3, ..., 10]

        foreach ($allWilayahs as $wilayah) {
            // Convert to three-digit string (e.g., '001', '002')
            $kd_db       = str_pad($wilayah, 3, '0', STR_PAD_LEFT);
            $resultOpsen = $this->trnkbService->getDataPenerimaanOpsenRentangWaktuByKdWilayah($tg_awal, $tg_akhir, $kd_db, $kd_wilayah);
            // Merge the result into the combined dataTransaksi array
            $dataRekapOpsen = array_merge($dataRekapOpsen, $resultOpsen);
        }

        $dataTotals = $this->calculateTotalsOpsen($dataRekapOpsen);

        // $dataTotal = $this->calculateTotals($data_rekap);
        // dd($data_rekap, $dataPenerimaanOpsen, $dataTotal);

        return compact('page_title', 'tanggal', 'tg_awal', 'tg_akhir', 'kd_wilayah', 'nm_wilayah', 'dataRekapOpsen', 'dataTotals');
    }

    private function validateFormRequest(Request $request)
    {
        return $request->validate([
            'tanggal'    => 'required|string',
            'kd_wilayah' => 'nullable|string',
        ]);
    }

    private function calculateTotalsOpsen($data)
    {
        $totals = [
            'total_opsen_bbn_pokok' => 0,
            'total_opsen_bbn_denda' => 0,
            'total_opsen_pkb_pokok' => 0,
            'total_opsen_pkb_denda' => 0,
            'total_jumlah_trn'      => 0,
        ];

        foreach ($data as $item) {
            $totals['total_opsen_bbn_pokok'] += (float) $item->opsen_bbn_pokok;
            $totals['total_opsen_bbn_denda'] += (float) $item->opsen_bbn_denda;
            $totals['total_opsen_pkb_pokok'] += (float) $item->opsen_pkb_pokok;
            $totals['total_opsen_pkb_denda'] += (float) $item->opsen_pkb_denda;
            $totals['total_jumlah_trn'] += (int) $item->jumlah_trn;
        }

        return $totals;
    }

    private function calculateTotals($data_rekap)
    {
        $total_bbn         = $data_rekap->bbn_pok + $data_rekap->bbn_den;
        $total_pkb         = $data_rekap->pkb_pok + $data_rekap->pkb_den;
        $total_swd         = $data_rekap->swd_pok + $data_rekap->swd_den;
        $total_opsen_bbnkb = $data_rekap->opsen_bbn_pok + $data_rekap->opsen_bbn_den;
        $total_opsen_pkb   = $data_rekap->opsen_pkb_pok + $data_rekap->opsen_pkb_den;
        $total_pnbp        = $data_rekap->adm_stnk + $data_rekap->plat_nomor;
        $total_seluruh     = $total_bbn + $total_opsen_bbnkb + $total_pkb + $total_opsen_pkb + $total_swd;

        return [
            'total_bbn'         => $total_bbn,
            'total_pkb'         => $total_pkb,
            'total_swd'         => $total_swd,
            'total_pnbp'        => $total_pnbp,
            'total_opsen_pkb'   => $total_opsen_pkb,
            'total_opsen_bbnkb' => $total_opsen_bbnkb,
            'total_seluruh'     => $total_seluruh,
        ];
    }

    private function calculateSumJumlah($dataTransaksi)
    {
        $sumJumlah = [
            "bbn_pokok"       => 0,
            "bbn_denda"       => 0,
            "pkb_pokok"       => 0,
            "pkb_denda"       => 0,
            "swd_pokok"       => 0,
            "swd_denda"       => 0,
            "opsen_bbn_pokok" => 0,
            "opsen_bbn_denda" => 0,
            "opsen_pkb_pokok" => 0,
            "opsen_pkb_denda" => 0,
        ];

        foreach ($dataTransaksi as $item) {
            foreach ($sumJumlah as $key => &$value) {
                $value += $item->$key;
            }
        }

        return $sumJumlah;
    }

}
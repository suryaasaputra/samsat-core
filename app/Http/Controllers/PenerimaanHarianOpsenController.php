<?php

namespace App\Http\Controllers;

use App\Exports\PenerimaanOpsenExport;
use App\Models\Wilayah;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenerimaanHarianOpsenController extends Controller
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
        $page_title = 'Penerimaan Harian Opsen Kab/Kota';

        // Fetch all wilayah starting with the prefix
        $wilayah = Wilayah::all();

        // Fetch all wilayah for the dropdown

        $action = 'form_laporan';

        return view('page.laporan.penerimaan-harian-opsen.index', compact('page_title', 'action', 'wilayah'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.penerimaan-harian-opsen.data', [
            'page_title' => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal' => $data['tanggal'],
            'wilayah' => $data['wilayah'],
            'kd_wilayah' => $data['kd_wilayah'],
            'sumJumlah' => $data['sumJumlah'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = 'Laporan Penerimaan Opsen ' . $data['wilayah']->nm_wilayah . ' Tanggal ' . $data['tanggal'];
        $pdf = Pdf::loadView('page.laporan.penerimaan-harian-opsen.export-pdf', [
            'page_title' => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal' => $data['tanggal'],
            'wilayah' => $data['wilayah'],
            'kd_wilayah' => $data['kd_wilayah'],
            'sumJumlah' => $data['sumJumlah'],
        ])->setPaper('A4', 'landscape');

        return $pdf->stream($file_name . '.pdf');
    }

    public function exportToExcel(Request $request)
    {
        $data = $this->prepareData($request);

        $fileName = 'Laporan Penerimaan Opsen ' . $data['wilayah']->nm_wilayah . ' Tanggal ' . $data['tanggal'] . '.xlsx';

        return Excel::download(new PenerimaanOpsenExport($data), $fileName);
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);

        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_wilayah = $validated['kd_wilayah'];
        $wilayah = $this->getwilayah($kd_wilayah);
        $page_title = 'Daftar Penerimaan Harian Opsen  ' . $wilayah->nm_wilayah;
        $dataTransaksi = $this->trnkbService->getLaporanTransaksiHarianOpsen($tanggal, $kd_wilayah);
        $sumJumlah = $this->calculateSumJumlah($dataTransaksi);

        return compact('page_title', 'tanggal', 'kd_wilayah', 'wilayah', 'dataTransaksi', 'sumJumlah');
    }

    private function validateFormRequest(Request $request)
    {
        return $request->validate([
            'tanggal' => 'required|date',
            'kd_wilayah' => 'required|string',
        ]);
    }

    private function getwilayah($kd_wilayah)
    {
        $wilayah = wilayah::on(\Auth::user()->kd_wilayah)->find($kd_wilayah);

        if (!$wilayah) {
            $wilayahDefaults = [
                '001' => 'KOTA JAMBI',
                '002' => 'KAB. BATANGHARI',
                '003' => 'KAB. TANJAB BARAT',
                '004' => 'KAB. MERANGIN',
                '005' => 'KAB. BUNGO',
                '006' => 'KAB. KERINCI',
                '007' => 'KAB. TANJAB TIMUR',
                '008' => 'KAB. MUARO JAMBI',
                '009' => 'KAB. SAROLANGUN',
                '010' => 'KAB. TEBO',
                '011' => 'KOTA SUNGAI PENUH',
            ];

            $nm_wilayah = $wilayahDefaults[$kd_wilayah] ?? '';
            $wilayah = (object) [
                'kd_wilayah' => $kd_wilayah,
                'nm_wilayah' => $nm_wilayah,
            ];
        }

        return $wilayah;
    }

    private function calculateSumJumlah($dataTransaksi)
    {
        $sumJumlah = [
            "bbn_pokok" => 0,
            "bbn_denda" => 0,
            "pkb_pokok" => 0,
            "pkb_denda" => 0,
            "swd_pokok" => 0,
            "swd_denda" => 0,
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

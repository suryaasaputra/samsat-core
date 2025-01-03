<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaanHarianController extends Controller
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
        $page_title = 'Penerimaan Harian';

        $kdLokasi = Auth::user()->kd_lokasi;

        $prefix = substr($kdLokasi, 0, 2);

        // Fetch all lokasi starting with the prefix
        $lokasi = Lokasi::on(\Auth::user()->kd_wilayah)->where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        // Fetch all wilayah for the dropdown

        $action = 'form_laporan';

        return view('page.laporan.penerimaan-harian.index', compact('page_title', 'action', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.penerimaan-harian.data', [
            'page_title' => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal' => $data['tanggal'],
            'lokasi' => $data['lokasi'],
            'kd_lokasi' => $data['kd_lokasi'],
            'sumJumlah' => $data['sumJumlah'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = 'Laporan Penerimaan Tanggal ' . $data['tanggal'] . ' di ' . $data['lokasi']->nm_lokasi;
        $pdf = Pdf::loadView('page.laporan.penerimaan-harian.export-pdf', [
            'page_title' => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal' => $data['tanggal'],
            'lokasi' => $data['lokasi'],
            'kd_lokasi' => $data['kd_lokasi'],
            'sumJumlah' => $data['sumJumlah'],
        ])->setPaper('A4', 'landscape');

        return $pdf->stream($file_name . '.pdf');
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $lokasi = $this->getLokasi($kd_lokasi);
        $dataTransaksi = $this->trnkbService->getLaporanTransaksiHarian($tanggal, $kd_lokasi);
        $sumJumlah = $this->calculateSumJumlah($dataTransaksi);

        return compact('page_title', 'tanggal', 'kd_lokasi', 'lokasi', 'dataTransaksi', 'sumJumlah');
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
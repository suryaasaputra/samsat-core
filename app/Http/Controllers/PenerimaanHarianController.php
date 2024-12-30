<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Wilayah;
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
        $lokasi = Lokasi::where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        // Fetch all wilayah for the dropdown
        $wilayah = Wilayah::orderBy('kd_wilayah', 'asc')->get();
        $action = 'form_laporan';

        return view('page.laporan.penerimaan-harian.index', compact('page_title', 'action', 'wilayah', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
            'kd_wilayah' => 'required|string',
            'jenis' => 'required|string',
        ]);

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';

        // You can now use the validated data for further processing, e.g., saving to the database
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $kd_wilayah = $validated['kd_wilayah'];
        $jenis = $validated['jenis'];
        $lokasi = Lokasi::find($kd_lokasi);
        if (!$lokasi) {
            switch ($kd_lokasi) {
                case '01':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KOTA JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KOTA JAMBI',
                    ];
                    break;
                case '02':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. BATANGHAR',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. BATANGHARI',
                    ];
                    break;
                case '03':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TANJAB BARAT',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TANJAB BARAT',
                    ];
                    break;
                case '04':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. MERANGIN',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. MERANGIN',
                    ];
                    break;
                case '05':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. BUNGO',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. BUNGO',
                    ];
                    break;
                case '06':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. KERINCI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. KERINCI',
                    ];
                    break;
                case '07':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TANJAB TIMUR',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TANJAB TIMUR',
                    ];
                    break;
                case '08':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. MUARO JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. MUARO JAMBI',
                    ];
                    break;
                case '09':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. SAROLANGUN',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. SAROLANGUN',
                    ];
                    break;
                case '10':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TEBO',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TEBO',
                    ];
                    break;
                default:
                    $lokasi = (object) [
                        'kd_lokasi' => '00',
                        'nm_lokasi' => 'SAMSAT PROVINSI JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT PROVINSI JAMBI',
                    ];
            }
        }

        $dataTransaksi = $this->trnkbService->getLaporanTransaksiHarian($tanggal, $kd_lokasi, $kd_wilayah, $jenis);

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
            $sumJumlah["bbn_pokok"] += $item->bbn_pokok;
            $sumJumlah["bbn_denda"] += $item->bbn_denda;
            $sumJumlah["pkb_pokok"] += $item->pkb_pokok;
            $sumJumlah["pkb_denda"] += $item->pkb_denda;
            $sumJumlah["swd_pokok"] += $item->swd_pokok;
            $sumJumlah["swd_denda"] += $item->swd_denda;
            $sumJumlah["opsen_pkb_pokok"] += $item->opsen_pkb_pokok;
            $sumJumlah["opsen_pkb_denda"] += $item->opsen_pkb_denda;
            $sumJumlah["opsen_bbn_pokok"] += $item->opsen_bbn_pokok;
            $sumJumlah["opsen_bbn_denda"] += $item->opsen_bbn_denda;
        }

        return view('page.laporan.penerimaan-harian.data', compact('page_title', 'dataTransaksi', 'tanggal', 'lokasi', 'kd_wilayah', 'kd_lokasi', 'jenis', 'sumJumlah'));
    }

    public function exportToPdf(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
            'kd_wilayah' => 'required|string',
            'jenis' => 'required|string',
        ]);

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';

        // You can now use the validated data for further processing, e.g., saving to the database
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $kd_wilayah = $validated['kd_wilayah'];
        $jenis = $validated['jenis'];

        $lokasi = Lokasi::find($kd_lokasi);
        if (!$lokasi) {
            switch ($kd_lokasi) {
                case '01':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KOTA JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KOTA JAMBI',
                    ];
                    break;
                case '02':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. BATANGHAR',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. BATANGHARI',
                    ];
                    break;
                case '03':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TANJAB BARAT',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TANJAB BARAT',
                    ];
                    break;
                case '04':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. MERANGIN',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. MERANGIN',
                    ];
                    break;
                case '05':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. BUNGO',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. BUNGO',
                    ];
                    break;
                case '06':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. KERINCI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. KERINCI',
                    ];
                    break;
                case '07':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TANJAB TIMUR',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TANJAB TIMUR',
                    ];
                    break;
                case '08':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. MUARO JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. MUARO JAMBI',
                    ];
                    break;
                case '09':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. SAROLANGUN',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. SAROLANGUN',
                    ];
                    break;
                case '10':
                    $lokasi = (object) [
                        'kd_lokasi' => $kd_lokasi,
                        'nm_lokasi' => 'SAMSAT KAB. TEBO',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT KAB. TEBO',
                    ];
                    break;
                default:
                    $lokasi = (object) [
                        'kd_lokasi' => '00',
                        'nm_lokasi' => 'SAMSAT PROVINSI JAMBI',
                        'rpthdr1' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                        'rpthdr2' => 'SAMSAT PROVINSI JAMBI',
                    ];
            }
        }

        $dataTransaksi = $this->trnkbService->getLaporanTransaksiHarian($tanggal, $kd_lokasi, $kd_wilayah, $jenis);

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
            $sumJumlah["bbn_pokok"] += $item->bbn_pokok;
            $sumJumlah["bbn_denda"] += $item->bbn_denda;
            $sumJumlah["pkb_pokok"] += $item->pkb_pokok;
            $sumJumlah["pkb_denda"] += $item->pkb_denda;
            $sumJumlah["swd_pokok"] += $item->swd_pokok;
            $sumJumlah["swd_denda"] += $item->swd_denda;
            $sumJumlah["opsen_pkb_pokok"] += $item->opsen_pkb_pokok;
            $sumJumlah["opsen_pkb_denda"] += $item->opsen_pkb_denda;
            $sumJumlah["opsen_bbn_pokok"] += $item->opsen_bbn_pokok;
            $sumJumlah["opsen_bbn_denda"] += $item->opsen_bbn_denda;
        }

        $file_name = 'Laporan Penerimaan Tanggal ' . $tanggal . ' di ' . $lokasi->nm_lokasi;
        $pdf = Pdf::loadView('page.laporan.penerimaan-harian.export-pdf', compact('page_title', 'dataTransaksi', 'tanggal', 'kd_wilayah', 'lokasi', 'kd_lokasi', 'jenis', 'sumJumlah'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream($file_name . '.pdf');
    }

}

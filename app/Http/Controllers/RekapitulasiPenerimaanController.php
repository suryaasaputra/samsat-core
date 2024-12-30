<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapitulasiPenerimaanController extends Controller
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
        $page_title = 'Rekapitulasi Penerimaan';

        $kdLokasi = Auth::user()->kd_lokasi;

        $prefix = substr($kdLokasi, 0, 2);

        // Fetch all lokasi starting with the prefix
        $lokasi = Lokasi::where('kd_lokasi', 'like', $prefix . '%')
            ->orderBy('kd_lokasi', 'asc')
            ->get();

        $action = 'form_laporan';

        return view('page.laporan.rekapitulasi-penerimaan.index', compact('page_title', 'action', 'lokasi'));
    }
    public function handleFormSubmission(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
        ]);

        // You can now use the validated data for further processing, e.g., saving to the database
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];
        $page_title = 'Rekapitulasi Penerimaan';
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

        $data_rekap = $this->trnkbService->getRekapharian($tanggal, $kd_lokasi);

        $dataPenerimaanOpsen = $this->trnkbService->getDataPenerimaanOpsen($tanggal, $kd_lokasi);

        $total_bbn = $data_rekap->bbn1_pok + $data_rekap->bbn2_pok + $data_rekap->bbn1_den + $data_rekap->bbn2_pok + $data_rekap->tgk_bbn1_pok + $data_rekap->tgk_bbn1_den + $data_rekap->tgk_bbn2_pok + $data_rekap->tgk_bbn2_den;
        $total_pkb = $data_rekap->pkb_pok + $data_rekap->pkb_den + $data_rekap->tgk_pkb_pok + $data_rekap->tgk_pkb_den;

        $total_swd = $data_rekap->swd_pok + $data_rekap->swd_den + $data_rekap->tgk_swd_pok + $data_rekap->tgk_swd_den;

        $total_opsen_bbnkb = $data_rekap->opsen_bbn_pok + $data_rekap->opsen_bbn_den + $data_rekap->tgk_opsen_bbn_pok + $data_rekap->tgk_opsen_bbn_den;
        $total_opsen_pkb = $data_rekap->opsen_pkb_pok + $data_rekap->opsen_pkb_den + $data_rekap->tgk_opsen_pkb_pok + $data_rekap->tgk_opsen_pkb_den;
        $total_pnbp = $data_rekap->adm_stnk + $data_rekap->plat_nomor;
        $total_seluruh = $total_bbn + $total_opsen_bbnkb + $total_pkb + $total_opsen_pkb + $total_swd + $total_pnbp;

        $dataTotal = [
            'total_bbn' => $total_bbn,
            'total_pkb' => $total_pkb,
            'total_swd' => $total_swd,
            'total_pnbp' => $total_pnbp,
            'total_opsen_pkb' => $total_opsen_pkb,
            'total_opsen_bbnkb' => $total_opsen_bbnkb,
            'total_seluruh' => $total_seluruh,
        ];

        return view('page.laporan.rekapitulasi-penerimaan.data', compact('page_title', 'data_rekap', 'tanggal', 'lokasi', 'dataPenerimaanOpsen', 'dataTotal', 'kd_lokasi'));
    }

    public function exportToPdf(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kd_lokasi' => 'required|string',
        ]);

        // You can now use the validated data for further processing, e.g., saving to the database
        $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');
        $kd_lokasi = $validated['kd_lokasi'];

        $page_title = 'Rekapitulasi Penerimaan';
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

        $data_rekap = $this->trnkbService->getRekapharian($tanggal, $kd_lokasi);

        $dataPenerimaanOpsen = $this->trnkbService->getDataPenerimaanOpsen($tanggal, $kd_lokasi);

        $total_bbn = $data_rekap->bbn1_pok + $data_rekap->bbn2_pok + $data_rekap->bbn1_den + $data_rekap->bbn2_pok + $data_rekap->tgk_bbn1_pok + $data_rekap->tgk_bbn1_den + $data_rekap->tgk_bbn2_pok + $data_rekap->tgk_bbn2_den;
        $total_pkb = $data_rekap->pkb_pok + $data_rekap->pkb_den + $data_rekap->tgk_pkb_pok + $data_rekap->tgk_pkb_den;

        $total_swd = $data_rekap->swd_pok + $data_rekap->swd_den + $data_rekap->tgk_swd_pok + $data_rekap->tgk_swd_den;

        $total_opsen_bbnkb = $data_rekap->opsen_bbn_pok + $data_rekap->opsen_bbn_den + $data_rekap->tgk_opsen_bbn_pok + $data_rekap->tgk_opsen_bbn_den;
        $total_opsen_pkb = $data_rekap->opsen_pkb_pok + $data_rekap->opsen_pkb_den + $data_rekap->tgk_opsen_pkb_pok + $data_rekap->tgk_opsen_pkb_den;
        $total_pnbp = $data_rekap->adm_stnk + $data_rekap->plat_nomor;
        $total_seluruh = $total_bbn + $total_opsen_bbnkb + $total_pkb + $total_opsen_pkb + $total_swd + $total_pnbp;

        $dataTotal = [
            'total_bbn' => $total_bbn,
            'total_pkb' => $total_pkb,
            'total_swd' => $total_swd,
            'total_pnbp' => $total_pnbp,
            'total_opsen_pkb' => $total_opsen_pkb,
            'total_opsen_bbnkb' => $total_opsen_bbnkb,
            'total_seluruh' => $total_seluruh,
        ];
        $file_name = 'Rekapitulasi Penerimaan Tanggal ' . $tanggal . ' di ' . $lokasi->nm_lokasi;
        $pdf = Pdf::loadView('page.laporan.rekapitulasi-penerimaan.export-pdf', compact('page_title', 'data_rekap', 'tanggal', 'lokasi', 'dataPenerimaanOpsen', 'dataTotal', 'kd_lokasi'));
        return $pdf->stream($file_name . '.pdf');
    }

}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Wilayah;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapitulasiPenerimaanDetailController extends Controller
{
    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        $this->trnkbService = $trnkbService;
        $this->middleware('role:Admin|Monitoring');
    }

    public function showForm()
    {
        $page_title = 'Rekapitulasi Penerimaan (Mendetail)';

        $wilayah = Wilayah::where('kd_wilayah', '!=', '011')->get();

        // Fetch all wilayah for the dropdown

        $action = 'form_laporan_admin';

        return view('page.laporan.admin.rekapitulasi-penerimaan-detail.index', compact('page_title', 'action', 'wilayah'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.admin.rekapitulasi-penerimaan-detail.data', [
            'page_title'          => $data['page_title'],
            'data_rekap'          => $data['data_rekap'],
            'tanggal'             => $data['tanggal'],
            'tg_awal'             => $data['tg_awal'],
            'tg_akhir'            => $data['tg_akhir'],
            'lokasi'              => $data['lokasi'],
            'kd_wilayah'          => $data['kd_wilayah'],
            'kd_lokasi'           => $data['kd_lokasi'],
            'dataPenerimaanOpsen' => $data['dataPenerimaanOpsen'],
            'dataTotal'           => $data['dataTotal'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = $data['kd_wilayah'] . ' Rekapitulasi Penerimaan Tanggal ' . $data['tg_awal'] . ' sd ' . $data['tg_akhir'] . ' di ' . $data['lokasi']->nm_lokasi;
        $pdf       = Pdf::loadView('page.laporan.admin.rekapitulasi-penerimaan-detail.export-pdf', [
            'page_title'          => $data['page_title'],
            'data_rekap'          => $data['data_rekap'],
            'tanggal'             => $data['tanggal'],
            'tg_awal'             => $data['tg_awal'],
            'tg_akhir'            => $data['tg_akhir'],
            'lokasi'              => $data['lokasi'],
            'kd_wilayah'          => $data['kd_wilayah'],
            'kd_lokasi'           => $data['kd_lokasi'],
            'dataPenerimaanOpsen' => $data['dataPenerimaanOpsen'],
            'dataTotal'           => $data['dataTotal'],
        ]);
        return $pdf->stream($file_name . '.pdf');
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);
        $tanggal   = $validated['tanggal'];

        list($tg_awal, $tg_akhir) = explode(' - ', $validated['tanggal']);

        // Convert the dates to Y-m-d format using Carbon
        $tg_awal  = Carbon::createFromFormat('m/d/Y', trim($tg_awal))->format('Y-m-d');
        $tg_akhir = Carbon::createFromFormat('m/d/Y', trim($tg_akhir))->format('Y-m-d');

        $page_title = 'Rekapitulasi Penerimaan (Detail)';
        $kd_lokasi  = $validated['kd_lokasi'];
        $kd_wilayah = $validated['kd_wilayah'];

        if ($kd_wilayah == 0) {
            // Define an array of wilayah codes from '001' to '010'

            $data_rekap = [
                'pkb_pok'          => 0,
                'wp_pkb_pok'       => 0,
                'pkb_den'          => 0,
                'wp_pkb_den'       => 0,
                'bbn_pok'          => 0,
                'wp_bbn_pok'       => 0,
                'bbn_den'          => 0,
                'wp_bbn_den'       => 0,
                'swd_pok'          => 0,
                'wp_swd_pok'       => 0,
                'swd_den'          => 0,
                'wp_swd_den'       => 0,
                'adm_stnk'         => 0,
                'wp_adm_stnk'      => 0,
                'plat_nomor'       => 0,
                'wp_plat_nomor'    => 0,
                'opsen_pkb_pok'    => 0,
                'wp_opsen_pkb_pok' => 0,
                'opsen_pkb_den'    => 0,
                'wp_opsen_pkb_den' => 0,
                'opsen_bbn_pok'    => 0,
                'wp_opsen_bbn_pok' => 0,
                'opsen_bbn_den'    => 0,
                'wp_opsen_bbn_den' => 0,
                'jml_wp'           => 0,
            ];

            $dataPenerimaanOpsen = [];

            $allWilayahs = range(1, 10); // Generates [1, 2, 3, ..., 10]

            foreach ($allWilayahs as $wilayah) {
                // Convert to three-digit string (e.g., '001', '002')
                $kd_db       = str_pad($wilayah, 3, '0', STR_PAD_LEFT);
                $resultRekap = $this->trnkbService->getRekapRentangWaktu($tg_awal, $tg_akhir, $kd_db, $kd_lokasi);
                $resultOpsen = $this->trnkbService->getDataPenerimaanOpsenRentangWaktu($tg_awal, $tg_akhir, $kd_db, $kd_lokasi);

                $data_rekap['pkb_pok'] += $resultRekap->pkb_pok ?? 0;
                $data_rekap['wp_pkb_pok'] += $resultRekap->wp_pkb_pok ?? 0;
                $data_rekap['pkb_den'] += $resultRekap->pkb_den ?? 0;
                $data_rekap['wp_pkb_den'] += $resultRekap->wp_pkb_den ?? 0;
                $data_rekap['bbn_pok'] += $resultRekap->bbn_pok ?? 0;
                $data_rekap['wp_bbn_pok'] += $resultRekap->wp_bbn_pok ?? 0;
                $data_rekap['bbn_den'] += $resultRekap->bbn_den ?? 0;
                $data_rekap['wp_bbn_den'] += $resultRekap->wp_bbn_den ?? 0;
                $data_rekap['swd_pok'] += $resultRekap->swd_pok ?? 0;
                $data_rekap['wp_swd_pok'] += $resultRekap->wp_swd_pok ?? 0;
                $data_rekap['swd_den'] += $resultRekap->swd_den ?? 0;
                $data_rekap['wp_swd_den'] += $resultRekap->wp_swd_den ?? 0;
                $data_rekap['adm_stnk'] += $resultRekap->adm_stnk ?? 0;
                $data_rekap['wp_adm_stnk'] += $resultRekap->wp_adm_stnk ?? 0;
                $data_rekap['plat_nomor'] += $resultRekap->plat_nomor ?? 0;
                $data_rekap['wp_plat_nomor'] += $resultRekap->wp_plat_nomor ?? 0;
                $data_rekap['opsen_pkb_pok'] += $resultRekap->opsen_pkb_pok ?? 0;
                $data_rekap['wp_opsen_pkb_pok'] += $resultRekap->wp_opsen_pkb_pok ?? 0;
                $data_rekap['opsen_pkb_den'] += $resultRekap->opsen_pkb_den ?? 0;
                $data_rekap['wp_opsen_pkb_den'] += $resultRekap->wp_opsen_pkb_den ?? 0;
                $data_rekap['opsen_bbn_pok'] += $resultRekap->opsen_bbn_pok ?? 0;
                $data_rekap['wp_opsen_bbn_pok'] += $resultRekap->wp_opsen_bbn_pok ?? 0;
                $data_rekap['opsen_bbn_den'] += $resultRekap->opsen_bbn_den ?? 0;
                $data_rekap['wp_opsen_bbn_den'] += $resultRekap->wp_opsen_bbn_den ?? 0;
                $data_rekap['jml_wp'] += $resultRekap->jml_wp ?? 0;

                foreach ($resultOpsen as $row) {
                    $kdWilayah = $row->kd_wilayah;

                    // If the wilayah exists, sum up the numerical fields
                    if (isset($dataPenerimaanOpsen[$kdWilayah])) {
                        $dataPenerimaanOpsen[$kdWilayah]['opsen_bbn_pokok'] += (float) $row->opsen_bbn_pokok;
                        $dataPenerimaanOpsen[$kdWilayah]['opsen_bbn_denda'] += (float) $row->opsen_bbn_denda;
                        $dataPenerimaanOpsen[$kdWilayah]['opsen_pkb_pokok'] += (float) $row->opsen_pkb_pokok;
                        $dataPenerimaanOpsen[$kdWilayah]['opsen_pkb_denda'] += (float) $row->opsen_pkb_denda;
                    } else {
                        // Add a new wilayah entry
                        $dataPenerimaanOpsen[$kdWilayah] = [
                            'kd_wilayah'      => $row->kd_wilayah,
                            'nm_wilayah'      => $row->nm_wilayah,
                            'opsen_bbn_pokok' => (float) $row->opsen_bbn_pokok,
                            'opsen_bbn_denda' => (float) $row->opsen_bbn_denda,
                            'opsen_pkb_pokok' => (float) $row->opsen_pkb_pokok,
                            'opsen_pkb_denda' => (float) $row->opsen_pkb_denda,
                        ];
                    }
                }
            }

            $data_rekap = json_decode(json_encode($data_rekap));
        } else {
            $data_rekap          = $this->trnkbService->getRekapRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi);
            $dataPenerimaanOpsen = $this->trnkbService->getDataPenerimaanOpsenRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi);
        }

        $lokasi = $this->getLokasi($kd_lokasi);

        $dataTotal = $this->calculateTotals($data_rekap);
        // dd($data_rekap, $dataPenerimaanOpsen, $dataTotal);

        return compact('page_title', 'data_rekap', 'tanggal', 'tg_awal', 'tg_akhir', 'kd_lokasi', 'kd_wilayah', 'lokasi', 'dataPenerimaanOpsen', 'dataTotal');
    }

    private function validateFormRequest(Request $request)
    {
        return $request->validate([
            'tanggal'    => 'required|string',
            'kd_lokasi'  => 'nullable|string',
            'kd_wilayah' => 'nullable|string',
        ]);
    }

    private function getLokasi($kd_lokasi)
    {
        $lokasi = Lokasi::on(\Auth::user()->kd_wilayah)->find($kd_lokasi);

        if (! $lokasi) {
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
            $lokasi    = (object) [
                'kd_lokasi' => $kd_lokasi,
                'nm_lokasi' => $nm_lokasi,
                'rpthdr1'   => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
                'rpthdr2'   => $nm_lokasi,
                'rpthdr3'   => '',
            ];
        }

        return $lokasi;

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

}

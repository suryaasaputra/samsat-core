<?php
namespace App\Http\Controllers\Admin;

use App\Exports\PenerimaanExportAdmin;
use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Wilayah;
use App\Services\TrnkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenerimaanHarianController extends Controller
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
        $page_title = 'Penerimaan Harian';

        $wilayah = Wilayah::all();

        // Fetch all wilayah for the dropdown

        $action = 'form_laporan_admin';

        return view('page.laporan.admin.penerimaan-harian.index', compact('page_title', 'action', 'wilayah'));
    }
    public function handleFormSubmission(Request $request)
    {
        $data = $this->prepareData($request);

        return view('page.laporan.admin.penerimaan-harian.data', [
            'page_title'    => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal'       => $data['tanggal'],
            'tg_awal'       => $data['tg_awal'],
            'tg_akhir'      => $data['tg_akhir'],
            'lokasi'        => $data['lokasi'],
            'kd_wilayah'    => $data['kd_wilayah'],
            'kd_lokasi'     => $data['kd_lokasi'],
            'sumJumlah'     => $data['sumJumlah'],
        ]);
    }

    public function exportToPdf(Request $request)
    {
        $data = $this->prepareData($request);

        $file_name = 'Laporan_Penerimaan_Tanggal_' . $data['tg_awal'] . '_sd_' . $data['tg_akhir'] . '_di_' . $data['lokasi']->nm_lokasi;
        $pdf       = Pdf::loadView('page.laporan.admin.penerimaan-harian.export-pdf', [
            'page_title'    => $data['page_title'],
            'dataTransaksi' => $data['dataTransaksi'],
            'tanggal'       => $data['tanggal'],
            'tg_awal'       => $data['tg_awal'],
            'tg_akhir'      => $data['tg_akhir'],
            'lokasi'        => $data['lokasi'],
            'kd_wilayah'    => $data['kd_wilayah'],
            'kd_lokasi'     => $data['kd_lokasi'],
            'sumJumlah'     => $data['sumJumlah'],
        ])->setPaper('A4', 'landscape');

        return $pdf->stream($file_name . '.pdf');
    }

    public function exportToExcel(Request $request)
    {
        $data = $this->prepareData($request);

        $fileName = 'Laporan_Penerimaan_Tanggal_' . $data['tg_awal'] . '_sd_' . $data['tg_akhir'] . '_di_' . $data['lokasi']->nm_lokasi . '.xlsx';

        return Excel::download(new PenerimaanExportAdmin($data), $fileName);
    }

    private function prepareData(Request $request)
    {
        $validated = $this->validateFormRequest($request);

        $tanggal = $validated['tanggal'];

        list($tg_awal, $tg_akhir) = explode(' - ', $validated['tanggal']);

        // Convert the dates to Y-m-d format using Carbon
        $tg_awal  = Carbon::createFromFormat('m/d/Y', trim($tg_awal))->format('Y-m-d');
        $tg_akhir = Carbon::createFromFormat('m/d/Y', trim($tg_akhir))->format('Y-m-d');

        $page_title = 'Daftar Penerimaan Harian PKB dan BBNKB';
        $kd_wilayah = $validated['kd_wilayah'];
        $kd_lokasi  = $validated['kd_lokasi'];
        if ($kd_wilayah == 0) {
                                           // Define an array of wilayah codes from '001' to '010'
            $allWilayahs   = range(1, 10); // Generates [1, 2, 3, ..., 10]
            $dataTransaksi = [];

            foreach ($allWilayahs as $wilayah) {
                // Convert to three-digit string (e.g., '001', '002')
                $kd_wilayah = str_pad($wilayah, 3, '0', STR_PAD_LEFT);

                // Get transaksi data for this wilayah
                $result = $this->trnkbService->getLaporanTransaksiRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi);

                // Merge the result into the combined dataTransaksi array
                $dataTransaksi = array_merge($dataTransaksi, $result->toArray());
            }
        } else {
            // Single wilayah case
            $dataTransaksi = $this->trnkbService->getLaporanTransaksiRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi);
        }

        // Get lokasi for the current wilayah
        $lokasi = $this->getLokasi($kd_lokasi);
        // Calculate the sum of jumlah
        $sumJumlah = $this->calculateSumJumlah($dataTransaksi);

        return compact('page_title', 'tanggal', 'tg_awal', 'tg_akhir', 'kd_lokasi', 'kd_wilayah', 'lokasi', 'dataTransaksi', 'sumJumlah');
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

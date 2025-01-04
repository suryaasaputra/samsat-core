<?php

namespace App\Http\Controllers;

use App\Models\LogTrn;
use App\Models\LogTrnkb;
use App\Models\Monitor;
use App\Models\Tera;
use App\Models\Trnkb;
use App\Services\TrnkbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    protected $trnkbService;
    /**
     * PembayaranController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        // Apply the permission middleware
        $this->middleware('permission:bayar');
        $this->trnkbService = $trnkbService;

    }

    public function index()
    {

        return view('page.pembayaran.index', ["page_title" => "Pembayaran"]);
    }

    public function searchNopol(Request $request)
    {

        // Validate the incoming form data
        $validated = $request->validate([
            'no_polisi' => 'required|string|max:4',
            'seri' => 'nullable|string|max:3|regex:/^[A-Z]+$/', // optional but must be uppercase letters if provided
        ]);

        // Assemble the full no_polisi value by combining no_polisi and seri
        $noPolisi = 'BH ' . strtoupper($validated['no_polisi']) . " " . strtoupper($validated['seri']);

        $page_title = 'Rincian Pembayaran';
        $kodeStatus = '3 ';
        $kdWilayah = \Auth::user()->kd_wilayah;

        $trnkbData = $this->trnkbService->getDataTransaksi($noPolisi, $kodeStatus, $kdWilayah);

        if (!$trnkbData) {
            return redirect()
                ->back()
                ->with('error', 'Data Transaksi Kendaraan No Polisi ' . $noPolisi . ' Tidak Ditemukan');
        }

        // Get the current date
        $tahun = Carbon::now()->year;
        $tglskrng = Carbon::now()->format('Y-m-d'); // Format current date to 'md' (month and day)

        $tg_akhir_pkb_yl = $trnkbData->tg_akhir_pkb;

        if (is_null($trnkbData->tg_akhir_pkb)) {
            // If tg_akhir_pkb is null
            $potong_tg_akhir = substr($tglskrng, 4);
            $potong_tg_akhir_jr = substr($tglskrng, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;
            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_pkb_yl = Carbon::parse($trnkbData->tg_faktur)->addMonth()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        } else {
            // If tg_akhir_pkb is not null
            $potong_tg_akhir = substr($trnkbData->tg_akhir_pkb, 4);
            $potong_tg_akhir_jr = substr($trnkbData->tg_akhir_jr, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;

            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        }

        $bea = $this->trnkbService->sumPokokDanDenda($trnkbData);

        $data = [
            'page_title' => $page_title,
            'data_kendaraan' => $trnkbData,
            'bea' => $bea,
            'tg_akhir_pkb_yl' => $tg_akhir_pkb_yl,
            'tg_akhir_pkb' => $tg_akhir_pkb,
            'tg_akhir_swdkllj' => $tg_akhir_swdkllj,
        ];

        return view('page.pembayaran.detail-pembayaran', $data);

    }

    public function bayar(Request $request)
    {
        $validated = $request->validate([
            'no_polisi' => 'required|string',
            'no_trn' => 'required|string',
            'metode_bayar' => 'required|string',
        ]);
        $noPolisi = $validated['no_polisi'];
        $noTrn = $validated['no_trn'];
        $metodeBayar = $validated['metode_bayar'];
        $kdLokasi = \Auth::user()->kd_lokasi;
        $kdWilayah = \Auth::user()->kd_wilayah;

        $trnkbData = $this->trnkbService->getDataTransaksiByNoTransaksiAndNoPolisi($noTrn, $noPolisi, $kdWilayah);
        if (!$trnkbData) {
            return redirect()
                ->route('pembayaran')
                ->with('error', 'Data Transaksi Kendaraan No Polisi ' . $noPolisi . ' Tidak Ditemukan');
        }

        $bea = $this->trnkbService->sumPokokDanDenda($trnkbData);
        $jumlahPembayaran = $bea['total_seluruh'];
        $formattedNumber = number_format($jumlahPembayaran, 0, ',', '.');

        // Get the current date
        $tahun = Carbon::now()->year;
        $tglskrng = Carbon::now()->format('Y-m-d');

        $no_tera = $this->trnkbService->getNoTera($tglskrng, $kdWilayah);
        $cap_tera = "$noPolisi" . "*" . "$tglskrng" . "*" . "$formattedNumber";
        $term = "term" . "$kdLokasi" . "201";
        $tg_akhir_pkb_yl = $trnkbData->tg_akhir_pkb;
        $tg_akhir_swd_yl = $trnkbData->tg_akhir_jr;

        if (is_null($trnkbData->tg_akhir_pkb)) {
            // If tg_akhir_pkb is null
            $potong_tg_akhir = substr($tglskrng, 4);
            $potong_tg_akhir_jr = substr($tglskrng, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;
            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_pkb_yl = Carbon::parse($trnkbData->tg_faktur)->addMonth()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        } else {
            // If tg_akhir_pkb is not null
            $potong_tg_akhir = substr($trnkbData->tg_akhir_pkb, 4);
            $potong_tg_akhir_jr = substr($trnkbData->tg_akhir_jr, 4);
            $tg_akhir_now = $tahun . $potong_tg_akhir;
            $tg_akhir_jr_now = $tahun . $potong_tg_akhir_jr;

            // Use Carbon for date manipulation
            $tg_akhir_pkb = Carbon::parse($tg_akhir_now)->addYear()->format('Y-m-d');
            $tg_akhir_swdkllj = Carbon::parse($tg_akhir_jr_now)->addYear()->format('Y-m-d');
        }

        $dataUpdateTrnkb = [
            "kd_lokasi" => $kdLokasi,
            "kd_status" => '4 ',
            "tg_awal_pkb" => $tg_akhir_pkb_yl,
            "tg_akhir_pkb" => $tg_akhir_pkb,
            "tg_awal_jr" => $tg_akhir_swd_yl,
            "tg_akhir_jr" => $tg_akhir_swdkllj,
            "tg_bayar" => $tglskrng,
            "no_tera" => $no_tera,
            "user_id_bayar" => \Auth::user()->username,
            "kd_kasir" => 1,
            "kd_bayar" => 1,
        ];

        $dataLogTrn = [
            "no_trn" => $noTrn,
            "no_polisi" => $noPolisi,
            "tg_daftar" => $trnkbData->tg_daftar,
            "kd_lokasi" => $kdLokasi,
            "kd_proses" => '4 ',
            "kd_status" => 1,
            "jam_proses" => Carbon::now()->format('Y-m-d H:i:s'),
            "term_id" => $term,
            "user_id" => \Auth::user()->username,
        ];

        $logTrnkbLatest = (new LogTrnkb)
            ->setConnection($kdWilayah)
            ->where('no_trn', $noTrn)
            ->orderBy('jam_proses', 'desc')
            ->first();

        $dataLogTrnkb = [
            "no_trn" => $noTrn,
            "no_polisi" => $noPolisi,
            "nopol_lama" => $logTrnkbLatest->nopol_lama ?? $trnkbData->nopol_lama,
            "tg_daftar" => $logTrnkbLatest->tg_daftar ?? $trnkbData->tg_daftar,
            "kd_mohon" => $logTrnkbLatest->kd_mohon ?? $trnkbData->kd_mohon,
            "kd_proses" => '4 ',
            "jam_proses" => Carbon::now()->format('Y-m-d H:i:s'),
            "nm_merek_kb" => $logTrnkbLatest->nm_merek_kb ?? $trnkbData->nm_merek_kb,
            "nm_model_kb" => $logTrnkbLatest->nm_model_kb ?? $trnkbData->nm_model_kb,
            "nm_jenis_kb" => $logTrnkbLatest->nm_jenis_kb ?? $trnkbData->nm_jenis_kb,
            "th_rakitan" => $logTrnkbLatest->th_rakitan ?? $trnkbData->th_rakitan,
            "nilai_jual" => $logTrnkbLatest->nilai_jual ?? 0,
            "tg_akhir_pkb" => $tg_akhir_pkb,
            "pkb_pok" => $bea['pokok_pkb'],
            "pkb_den" => $bea['denda_pkb'],
            "bbn1_pok" => $bea['pokok_bbn1'],
            "bbn1_den" => $bea['denda_bbn1'],
            "bbn2_pok" => $bea['pokok_bbn2'],
            "bbn2_den" => $bea['denda_bbn2'],
            "swd_pok" => $bea['pokok_swdkllj'],
            "swd_den" => $bea['denda_swdkllj'],
        ];

        $dataTera = [

            "no_trn" => $noTrn,
            "no_polisi" => $noPolisi,
            "tg_daftar" => $trnkbData->tg_daftar,
            "kd_notice" => "PP",
            "user_id" => \Auth::user()->username,
            "kd_kasir" => '1',
            "jml_byr" => $jumlahPembayaran,
            "tg_tera" => $tglskrng,
            "no_tera" => $no_tera,
            "cap_tera" => $cap_tera,
            "flag_tera" => 1,

        ];

        $dataMonitor = [
            "no_trn" => $noTrn,
            "no_polisi" => $noPolisi,
            "tg_daftar" => $trnkbData->tg_daftar,
            "kd_lokasi" => $kdLokasi,
            'kd_upt' => substr($kdLokasi, 0, 2),
            'kd_proses' => '4',
            'tg_proses' => $tglskrng,
            'jam_proses' => Carbon::now()->format('Y-m-d H:i:s'),
            'jml_pkb' => $bea['total_pkb'],
            'jml_bbn1' => $bea['total_bbn1'],
            'jml_bbn2' => $bea['total_bbn2'],
            'jml_swd' => $bea['total_swdkllj'],
            'tg_bayar' => $tglskrng,
            'kd_status' => '4',
        ];

        // dd($dataUpdateTrnkb, $dataLogTrn, $dataLogTrnkb, $dataTera, $dataMonitor);
        DB::connection($kdWilayah)->beginTransaction();
        DB::connection('induk')->beginTransaction();
        try {

            Trnkb::on($kdWilayah)
                ->where('no_trn', $noTrn)
                ->where('no_polisi', $noPolisi)
                ->update($dataUpdateTrnkb);

            LogTrn::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn' => $noTrn,
                    'kd_proses' => '4 ',
                ], $dataLogTrn);

            LogTrnkb::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn' => $noTrn,
                    'kd_proses' => '4 ',
                ], $dataLogTrnkb);

            Tera::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn' => $noTrn,
                    'no_polisi' => $noPolisi,
                ], $dataTera);

            Monitor::on('induk')
                ->updateOrCreate([
                    'no_trn' => $noTrn,
                    'no_polisi' => $noPolisi,
                ], $dataMonitor);

            DB::connection($kdWilayah)->commit(); // Commit the transaction
            DB::connection('induk')->commit(); // Commit the transaction

            return redirect()->route('pembayaran')->with('success', 'Pembayaran Untuk No Polisi ' . $noPolisi . ' Berhasil');
        } catch (\Exception $e) {
            DB::connection($kdWilayah)->rollBack(); // Rollback the transaction on error
            DB::connection('induk')->rollBack(); // Rollback the transaction on error

            return redirect()->route('pembayaran')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function generateQris(Request $request)
    {
        $noPolisi = 'BH 4050 TQ';

        return redirect()->route('pembayaran')->with('success', 'QRIS Untuk No Polisi ' . $noPolisi . ' Berhasil Dibuat');

    }

}

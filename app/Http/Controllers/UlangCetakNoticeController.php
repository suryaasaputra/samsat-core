<?php
namespace App\Http\Controllers;

use App\Models\LogTrn;
use App\Models\LogTrnkb;
use App\Models\Monitor;
use App\Models\Notice;
use App\Models\Printer;
use App\Models\Trnkb;
use App\Models\TTDNotice;
use App\Services\TrnkbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UlangCetakNoticeController extends Controller
{
    protected $trnkbService;
    /**
     * CetakNoticeController constructor.
     */
    public function __construct(TrnkbService $trnkbService)
    {
        // Apply the permission middleware
        $this->middleware('permission:cetak-notice');
        $this->trnkbService = $trnkbService;

    }

    public function index()
    {
        $noNotice = Notice::on('induk')
            ->select('no_notice')
            ->where('user_id', \Auth::user()->username)
            ->where('kd_lokasi', \Auth::user()->kd_lokasi)
            ->orderBy('tg_cetak', 'DESC')
            ->orderBy('no_notice', 'DESC')
            ->first();
        $newNotice = is_null($noNotice)
        ? '0000001'
        : str_pad((int) substr($noNotice->no_notice, 6), 7, '0', STR_PAD_LEFT);

        $printer = \Auth::user()->printer_term;

        if (! $printer) {
            return redirect()->route('home')->with('error', 'Printer belum diatur, silahkan minta admin untuk mengatur printer.');
        }

        return view('page.ulang-cetak-notice.index', [
            "page_title" => "Cetak Notice",
            "no_notice"  => $newNotice,
        ]
        );
    }

    public function nopol(Request $request)
    {
        $validated = $request->validate([
            'no_notice' => 'required|string',
        ]);

        $no_notice = \Auth::User()->kd_lokasi . ' ' . $validated['no_notice'];

        return view('page.ulang-cetak-notice.nopol', [
            "page_title" => "Cetak Notice " . $no_notice,
            "no_notice"  => $no_notice,
        ]
        );
    }

    public function searchNopol(Request $request)
    {

        // Validate the incoming form data
        $validated = $request->validate([
            'no_notice' => 'required|string',
            'no_polisi' => 'required|string|max:4',
            'seri'      => 'nullable|string|max:3|regex:/^[A-Z]+$/', // optional but must be uppercase letters if provided
        ]);

        $noPolisi = 'BH ' . strtoupper($validated['no_polisi']) . " " . strtoupper($validated['seri']);

        $kodeStatus = '5 ';

        $trnkbData = $this->trnkbService->getDataTransaksi($noPolisi, $kodeStatus, \Auth::user()->kd_wilayah);

        if (! $trnkbData) {
            return redirect()
                ->back()
                ->with('error', 'Kendaraan No Polisi ' . $noPolisi . ' Belum Melakukan Cetak Notice');
        }

        $bea   = $this->trnkbService->sumPokokDanDendaNotice($trnkbData);
        $iwkbu = DB::connection(\Auth::user()->kd_wilayah)
            ->table('t_cek_iwkbu')
            ->where('no_trn', $trnkbData->no_trn)
            ->first();

        $data = [
            'page_title'     => 'Detail Cetak Notice ' . $validated['no_notice'] . ' No Polisi ' . $noPolisi,
            'data_kendaraan' => $trnkbData,
            'no_notice'      => $validated['no_notice'],
            'bea'            => $bea,
            'iwkbu'          => $iwkbu->jml_iwkbu ?? 0,
        ];

        return view('page.ulang-cetak-notice.detail-cetak-notice', $data);

    }

    public function cetak(Request $request)
    {
        $validated = $request->validate([
            'no_polisi' => 'required|string',
            'no_trn'    => 'required|string',
            'no_notice' => 'required|string',
        ]);
        $noPolisi = $validated['no_polisi'];
        $noTrn    = $validated['no_trn'];
        $noNotice = $validated['no_notice'];

        $kdLokasi  = \Auth::user()->kd_lokasi;
        $kdWilayah = \Auth::user()->kd_wilayah;

        $trnkbData = $this->trnkbService->getDataTransaksiByNoTransaksiAndNoPolisi($noTrn, $noPolisi, $kdWilayah);
        if (! $trnkbData) {
            return redirect()
                ->route('cetak-notice')
                ->with('error', 'Data Transaksi Kendaraan No Polisi ' . $noPolisi . ' Tidak Ditemukan');
        }

        $bea              = $this->trnkbService->sumPokokDanDendaNotice($trnkbData);
        $jumlahPembayaran = $bea['total_seluruh'];
        $formattedNumber  = number_format($jumlahPembayaran, 0, ',', '.');

        $ttd_dirlantas = TTDNotice::on($kdWilayah)->find('TTD-DIRLANTAS');
        $ttd_kacabjr   = TTDNotice::on($kdWilayah)->find('TTD-KACABJR');
        $ttd_kaban     = TTDNotice::on($kdWilayah)->find('TTD-KADISPENDA');
        $tglskrng      = Carbon::now()->format('Y-m-d');

        $parts_no_trn = explode("/", $trnkbData->no_trn);
        $rawDate      = $parts_no_trn[count($parts_no_trn) - 1]; // Assuming the date is always the last part
                                                                 // Reformat the date from yyyymmdd to ddmmyyyy
        $formattedDate = substr($rawDate, 6, 2) . substr($rawDate, 4, 2) . substr($rawDate, 0, 4);

        $no_urut = $parts_no_trn[0] . "/" . $formattedDate;

        $term = "term" . "$kdLokasi" . "201";

        $dataUpdateTrnkb = [
            "no_noticepp" => $noNotice,
            "kd_status"   => '5 ',
        ];

        $dataLogTrn = [
            "no_trn"     => $noTrn,
            "no_polisi"  => $noPolisi,
            "tg_daftar"  => $trnkbData->tg_daftar,
            "kd_lokasi"  => $kdLokasi,
            "kd_proses"  => '5 ',
            "kd_status"  => 1,
            "jam_proses" => Carbon::now()->format('Y-m-d H:i:s'),
            "term_id"    => $term,
            "user_id"    => \Auth::user()->username,
        ];

        $logTrnkbLatest = (new LogTrnkb)
            ->setConnection($kdWilayah)
            ->where('no_trn', $noTrn)
            ->orderBy('jam_proses', 'desc')
            ->first();

        $dataLogTrnkb = [
            "no_trn"       => $noTrn,
            "no_polisi"    => $noPolisi,
            "nopol_lama"   => $logTrnkbLatest->nopol_lama ?? $trnkbData->nopol_lama,
            "tg_daftar"    => $logTrnkbLatest->tg_daftar ?? $trnkbData->tg_daftar,
            "kd_mohon"     => $logTrnkbLatest->kd_mohon ?? $trnkbData->kd_mohon,
            "kd_proses"    => '5 ',
            "jam_proses"   => Carbon::now()->format('Y-m-d H:i:s'),
            "nm_merek_kb"  => $logTrnkbLatest->nm_merek_kb ?? $trnkbData->nm_merek_kb,
            "nm_model_kb"  => $logTrnkbLatest->nm_model_kb ?? $trnkbData->nm_model_kb,
            "nm_jenis_kb"  => $logTrnkbLatest->nm_jenis_kb ?? $trnkbData->nm_jenis_kb,
            "th_rakitan"   => $logTrnkbLatest->th_rakitan ?? $trnkbData->th_rakitan,
            "nilai_jual"   => $logTrnkbLatest->nilai_jual ?? 0,
            "tg_akhir_pkb" => $logTrnkbLatest->tg_akhir_pkb ?? $trnkbData->tg_akhir_pkb,
            "pkb_pok"      => $bea['pokok_pkb'],
            "pkb_den"      => $bea['denda_pkb'],
            "bbn1_pok"     => $bea['pokok_bbn1'],
            "bbn1_den"     => $bea['denda_bbn1'],
            "bbn2_pok"     => $bea['pokok_bbn2'],
            "bbn2_den"     => $bea['denda_bbn2'],
            "swd_pok"      => $bea['pokok_swdkllj'],
            "swd_den"      => $bea['denda_swdkllj'],
        ];

        $dataNotice = [
            'kd_lokasi'   => $kdLokasi,
            'no_notice'   => $noNotice,
            'no_polisi'   => $noPolisi,
            'no_trn'      => $noTrn,
            'tg_daftar'   => $trnkbData->tg_daftar,
            'no_urut_trn' => $trnkbData->no_urut_trn,
            'tg_cetak'    => $tglskrng,
            'kd_notice'   => 'PP',
            'jml_tetap'   => $jumlahPembayaran,
            'user_id'     => \Auth::user()->username,
            'flag_notice' => 'U',
            'catatan'     => 'Cetak Ulang',
        ];

        $dataMonitor = [
            "no_trn"     => $noTrn,
            "no_polisi"  => $noPolisi,
            "tg_daftar"  => $trnkbData->tg_daftar,
            "kd_lokasi"  => $kdLokasi,
            'kd_upt'     => substr($kdLokasi, 0, 2),
            'kd_proses'  => '5 ',
            'tg_proses'  => $tglskrng,
            'jam_proses' => Carbon::now()->format('Y-m-d H:i:s'),
            'jml_pkb'    => $bea['total_pkb'],
            'jml_bbn1'   => $bea['total_bbn1'],
            'jml_bbn2'   => $bea['total_bbn2'],
            'jml_swd'    => $bea['total_swdkllj'],
            'tg_bayar'   => $tglskrng,
            'kd_status'  => '5 ',
        ];

        $nm_user_penetapan = DB::connection(\Auth::user()->kd_wilayah)
            ->table('t_user')
            ->where('user_id', $trnkbData->user_id_tetap)
            ->first();
        $nm_user_korektor = DB::connection(\Auth::user()->kd_wilayah)
            ->table('t_user')
            ->where('user_id', $trnkbData->user_id_korektor)
            ->first();

        $iwkbu = DB::connection(\Auth::user()->kd_wilayah)
            ->table('t_cek_iwkbu')
            ->where('no_trn', $trnkbData->no_trn)
            ->first();

        $cap_tera = "$noPolisi" . "*" . "$tglskrng" . "*" . "$formattedNumber";

        $dataCetakNotice = [
            'user_id'           => \Auth::user()->username,
            'no_polisi'         => $noPolisi,
            'nopol_lama'        => $trnkbData->nopol_lama,
            'nm_pemilik'        => $trnkbData->nm_pemilik,
            'al_pemilik'        => $trnkbData->al_pemilik,
            'nik_pemilik'       => ($trnkbData->no_ktp === null || $trnkbData->no_ktp === "-")
            ? $trnkbData->izinang?->no_izin_ang ?? "-"
            : $trnkbData->no_ktp,
            'no_hp_pemilik'     => $trnkbData->no_hp->no_hp ?? "-",
            'nm_merek_kb'       => $trnkbData->nm_merek_kb,
            'nm_model_kb'       => $trnkbData->nm_model_kb,
            'nm_jenis_kb'       => $trnkbData->nm_jenis_kb,
            'nm_plat'           => $trnkbData->plat->nm_plat,
            'nm_bbm'            => $trnkbData->bbm->nm_bbm,
            'th_buatan'         => $trnkbData->th_buatan,
            'th_rakitan'        => $trnkbData->th_rakitan,
            'jumlah_cc'         => $trnkbData->kd_bbm != 5
            ? $trnkbData->jumlah_cc . ' cc'
            : $trnkbData->jumlah_cc . ' kWh',
            'jumlah_sumbu'      => $trnkbData->jumlah_sumbu,
            'warna_kb'          => $trnkbData->warna_kb,
            'no_chasis'         => $trnkbData->no_chasis,
            'no_mesin'          => $trnkbData->no_mesin,
            'tg_tetap'          => $trnkbData->tg_tetap,
            'no_bpkb'           => $trnkbData->no_bpkb,
            'kd_lokasi'         => $trnkbData->kd_lokasi,
            'no_trn'            => $trnkbData->no_trn,
            'no_urut'           => $no_urut,
            'no_kohir'          => $trnkbData->no_kohir,
            'no_skum'           => "",
            'no_daftar'         => $trnkbData->no_daftar,
            'nm_lokasi'         => $trnkbData->lokasi->nm_lokasi,
            'cap_tera'          => $trnkbData->tera->cap_tera ?? $cap_tera,
            'iwkbu'             => $iwkbu->jml_iwkbu ?? 0,

            'tg_awal_stnk'      => $trnkbData->tg_awal_stnk,
            'tg_akhir_stnk'     => $trnkbData->tg_akhir_stnk,
            'tg_awal_pkb'       => $trnkbData->tg_awal_pkb,
            'tg_akhir_pkb'      => $trnkbData->tg_akhir_pkb,
            'tg_awal_jr'        => $trnkbData->tg_awal_jr,
            'tg_akhir_jr'       => $trnkbData->tg_akhir_jr,

            'tg_tetap'          => $trnkbData->tg_tetap,

            'user_id_tetap'     => isset($nm_user_penetapan->nm_user) && $nm_user_penetapan->nm_user
            ? $nm_user_penetapan->nm_user
            : $trnkbData->user_id_tetap,
            'user_id_korektor'  => isset($nm_user_korektor->nm_user) && $nm_user_korektor->nm_user
            ? $nm_user_korektor->nm_user
            : $trnkbData->user_id_korektor,

            'bea_bbn_pok'       => $bea['pokok_bbnkb'],
            'bea_bbn_den'       => $bea['denda_bbnkb'],
            'bea_bbn'           => $bea['total_bbnkb'],

            'bea_pkb_pok'       => $bea['pokok_pkb'],
            'bea_pkb_den'       => $bea['denda_pkb'],
            'bea_pkb'           => $bea['total_pkb'],

            'bea_adm_stnk'      => $trnkbData->bea_adm_stnk,
            'bea_plat_nomor'    => $trnkbData->bea_plat_nomor,

            'bea_swdkllj_pok'   => $bea['pokok_swdkllj'],
            'bea_swdkllj_den'   => $bea['denda_swdkllj'],
            'bea_swdkllj'       => $bea['total_swdkllj'],

            'bea_opsen_bbn_pok' => $bea['pokok_opsen_bbnkb'],
            'bea_opsen_bbn_den' => $bea['denda_opsen_bbnkb'],
            'bea_opsen_bbn'     => $bea['total_opsen_bbnkb'],

            'bea_opsen_pkb_pok' => $bea['pokok_opsen_pkb'],
            'bea_opsen_pkb_den' => $bea['denda_opsen_pkb'],
            'bea_opsen_pkb'     => $bea['total_opsen_pkb'],

            'total_pokok'       => $bea['total_pokok'],
            'total_denda'       => $bea['total_denda'],
            'total_penetapan'   => $bea['total_seluruh'],

            'ttd_dirlantas'     => $ttd_dirlantas,
            'ttd_kacabjr'       => $ttd_kacabjr,
            'ttd_kaban'         => $ttd_kaban,

            'jam_skrg'          => Carbon::now()->format('H:i:s'),
        ];

        $urlNotice = $this->sendCetakNoticeRequest($dataCetakNotice);

        $dataPrinter = [
            'term_id'          => \Auth::user()->printer_term,
            'printer_terminal' => \Auth::user()->printer_term,
            'act'              => '1',
            'pdf_path'         => $urlNotice,
        ];

        DB::connection($kdWilayah)->beginTransaction();
        DB::connection('induk')->beginTransaction();
        try {
            Trnkb::on($kdWilayah)
                ->where('no_trn', $noTrn)
                ->where('no_polisi', $noPolisi)
                ->update($dataUpdateTrnkb);

            LogTrn::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn'    => $noTrn,
                    'kd_proses' => '5 ',
                ], $dataLogTrn);

            LogTrnkb::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn'    => $noTrn,
                    'kd_proses' => '5 ',
                ], $dataLogTrnkb);

            Notice::on($kdWilayah)
                ->updateOrCreate([
                    'no_trn'    => $noTrn,
                    'no_notice' => $noNotice,

                ], $dataNotice);
            Notice::on('induk')
                ->updateOrCreate([
                    'no_trn'    => $noTrn,
                    'no_notice' => $noNotice,

                ], $dataNotice);

            Monitor::on('induk')
                ->updateOrCreate([
                    'no_trn'    => $noTrn,
                    'no_polisi' => $noPolisi,
                ], $dataMonitor);

            Printer::on('induk')
                ->updateOrCreate([
                    'term_id' => \Auth::user()->printer_term,
                ], $dataPrinter);

            DB::connection($kdWilayah)->commit(); // Commit the transaction
            DB::connection('induk')->commit();    // Commit the transaction

            return redirect()->route('ulang-cetak-notice')->with('success', 'Berhasil Cetak Notice No Polisi ' . $noPolisi);
        } catch (\Exception $e) {
            DB::connection($kdWilayah)->rollBack(); // Rollback the transaction on error
            DB::connection('induk')->rollBack();    // Rollback the transaction on error

            return redirect()->route('ulang-cetak-notice')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function sendCetakNoticeRequest(array $dataCetakNotice)
    {
        // Read the URL from .env
        $appUrl = env('PRINT_URL') . '/printer/createPDF';

        // Send the POST request
        $response = Http::asForm()->post($appUrl, ['data' => json_encode($dataCetakNotice)]);

        return json_decode($response->body())->url;

    }

}
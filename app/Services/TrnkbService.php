<?php
namespace App\Services;

use App\Models\Trnkb;
use Illuminate\Support\Facades\DB;

class TrnkbService
{
    protected $trnkb;

    public function __construct(Trnkb $trnkb)
    {

        $this->trnkb = $trnkb;

    }

    public function getDataTransaksi($noPolisi, $kodeStatus, $kd_wilayah)
    {

        $query = $this->trnkb
            ->setConnection($kd_wilayah)
            ->where('no_polisi', $noPolisi)
            ->where('kd_status', $kodeStatus)
            ->orderBy('tg_daftar', 'desc');
        return $query->first();
    }

    public function getDataTransaksiTerakhirOnInduk($noPolisi)
    {
        $query = $this->trnkb
            ->where('no_polisi', $noPolisi)
            ->orderBy('tg_bayar', 'desc');

// Fetch the results as a collection
        $results = $query->get();

// Return the second row (index 1, since collections are zero-indexed)
        return $results->skip(1)->first();
    }

    public function getDataTransaksiByNoTransaksiAndNoPolisi($noTrn, $noPolisi, $kd_wilayah)
    {

        $query = $this->trnkb
            ->setConnection($kd_wilayah)
            ->where('no_trn', $noTrn)
            ->where('no_polisi', $noPolisi)
            ->orderBy('tg_daftar', 'desc');
        return $query->first();
    }

    public function updateByNoTrnAndNoPolisi($dataUpdateTrnkb, $noTrn, $noPolisi, $kd_wilayah)
    {
        return $this->trnkb
            ->setConnection($kd_wilayah)
            ->where('no_trn', $noTrn)
            ->where('no_polisi', $noPolisi)
            ->update($dataUpdateTrnkb);
    }

    public function getNoTera($tgl, $kd_wilayah)
    {
        $maxNoTera = $this->trnkb
            ->setConnection($kd_wilayah)
            ->where('tg_bayar', $tgl)
            ->max('no_tera');

        // If null, return 1; otherwise, return no_tera + 1
        return $maxNoTera ? $maxNoTera + 1 : 1;
    }

    public function getLaporanTransaksiHarian($tanggal, $kd_lokasi)
    {
        $query = DB::connection(\Auth::user()->kd_wilayah)->table(DB::raw('t_trnkb AS T'))
            ->select(
                DB::raw('T.no_polisi'),
                DB::raw('T.no_noticepp'),
                DB::raw('T.tg_bayar'),
                DB::raw('T.tg_awal_pkb'),
                DB::raw('T.tg_akhir_pkb'),
                DB::raw('T.kd_wilayah'),
                DB::raw('T.kd_mohon'),
                DB::raw('(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) as bbn_pokok'),
                DB::raw('(T.bea_bbn1_den + T.bea_bbn2_den + T.bea_bbn_den1 + T.bea_bbn_den2) as bbn_denda'),
                DB::raw('(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pokok'),
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2  + T.bea_pkb_den3  + T.bea_pkb_den4  + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw('T.bea_adm_stnk'),
                DB::raw('T.bea_plat_nomor'),
                DB::raw('T.user_id_bayar'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->leftJoin(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->where(DB::raw('T.tg_bayar'), $tanggal)
            ->where(DB::raw('T.kd_lokasi'), 'like', "%$kd_lokasi%")
            ->orderByRaw("T.no_noticepp ASC");

        return $query->get();

    }

    public function getLaporanTransaksiHarianByUser($tanggal, $user, $kd_lokasi)
    {
        $query = DB::connection(\Auth::user()->kd_wilayah)->table(DB::raw('t_trnkb AS T'))
            ->select(
                DB::raw('T.no_polisi'),
                DB::raw('T.no_noticepp'),
                DB::raw('T.tg_bayar'),
                DB::raw('T.tg_awal_pkb'),
                DB::raw('T.tg_akhir_pkb'),
                DB::raw('T.kd_wilayah'),
                DB::raw('T.kd_mohon'),
                DB::raw('(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) as bbn_pokok'),
                DB::raw('(T.bea_bbn1_den + T.bea_bbn2_den + T.bea_bbn_den1 + T.bea_bbn_den2) as bbn_denda'),
                DB::raw('(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pokok'),
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2  + T.bea_pkb_den3  + T.bea_pkb_den4  + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw('T.bea_adm_stnk'),
                DB::raw('T.bea_plat_nomor'),
                DB::raw('T.user_id_bayar'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->leftJoin(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->where(DB::raw('T.tg_bayar'), $tanggal)
            ->where(DB::raw('T.kd_lokasi'), 'like', "%$kd_lokasi%")
            ->where(DB::raw('T.user_id_bayar'), '=', "$user")
            ->orderByRaw("T.no_noticepp ASC");

        return $query->get();

    }

    public function getLaporanTransaksiRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi)
    {
        $query = DB::connection($kd_wilayah)->table(DB::raw('t_trnkb AS T'))
            ->select(
                DB::raw('T.no_polisi'),
                DB::raw('T.no_noticepp'),
                DB::raw('T.tg_bayar'),
                DB::raw('T.tg_awal_pkb'),
                DB::raw('T.tg_akhir_pkb'),
                DB::raw('T.kd_wilayah'),
                DB::raw('T.kd_lokasi'),
                DB::raw('T.kd_mohon'),
                DB::raw('(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) as bbn_pokok'),
                DB::raw('(T.bea_bbn1_den + T.bea_bbn2_den + T.bea_bbn_den1 + T.bea_bbn_den2) as bbn_denda'),
                DB::raw('(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pokok'),
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2  + T.bea_pkb_den3  + T.bea_pkb_den4  + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw('T.bea_adm_stnk'),
                DB::raw('T.bea_plat_nomor'),
                DB::raw('T.user_id_bayar'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->leftJoin(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->whereBetween(DB::raw('T.tg_bayar'), [$tg_awal, $tg_akhir])
            ->where(DB::raw('T.kd_lokasi'), 'like', "%$kd_lokasi%")
            ->orderByRaw("T.tg_bayar ASC")
            ->orderByRaw("T.no_noticepp ASC");

        return $query->get();

    }

    public function getLaporanTransaksiHarianOpsen($tanggal, $kd_wilayah)
    {
        $query = DB::connection(\Auth::user()->kd_wilayah)->table(DB::raw('t_trnkb AS T'))
            ->select(
                DB::raw('T.no_polisi'),
                DB::raw('T.no_noticepp'),
                DB::raw('T.tg_bayar'),
                DB::raw('T.tg_awal_pkb'),
                DB::raw('T.tg_akhir_pkb'),
                DB::raw('T.kd_lokasi'),
                DB::raw('T.kd_mohon'),
                DB::raw('(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) as bbn_pokok'),
                DB::raw('(T.bea_bbn1_den + T.bea_bbn2_den + T.bea_bbn_den1 + T.bea_bbn_den2) as bbn_denda'),
                DB::raw('(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pokok'),
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2  + T.bea_pkb_den3  + T.bea_pkb_den4  + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw('T.user_id_bayar'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->leftJoin(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->where(DB::raw('T.tg_bayar'), $tanggal)
            ->where(DB::raw('T.kd_wilayah'), 'like', "%$kd_wilayah%")
            ->orderByRaw("T.no_noticepp ASC");

        return $query->get();

    }

    public function getLaporanTransaksiHarianOpsenRentangWaktu($tg_awal, $tg_akhir, $kd_db, $kd_wilayah)
    {
        $query = DB::connection($kd_db)->table(DB::raw('t_trnkb AS T'))
            ->select(
                DB::raw('T.no_polisi'),
                DB::raw('T.no_noticepp'),
                DB::raw('T.tg_bayar'),
                DB::raw('T.tg_awal_pkb'),
                DB::raw('T.tg_akhir_pkb'),
                DB::raw('T.kd_lokasi'),
                DB::raw('T.kd_mohon'),
                DB::raw('(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) as bbn_pokok'),
                DB::raw('(T.bea_bbn1_den + T.bea_bbn2_den + T.bea_bbn_den1 + T.bea_bbn_den2) as bbn_denda'),
                DB::raw('(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pokok'),
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2  + T.bea_pkb_den3  + T.bea_pkb_den4  + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw('T.user_id_bayar'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->leftJoin(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->whereBetween(DB::raw('T.tg_bayar'), [$tg_awal, $tg_akhir])
            ->where(DB::raw('T.kd_wilayah'), 'like', "%$kd_wilayah%")
            ->orderByRaw("T.no_noticepp ASC");

        return $query->get();

    }

    public function getRekapharian($tanggal, $kd_lokasi)
    {
        $q = "SELECT
					SUM ( T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pok,
					COUNT (  CASE WHEN T.bea_pkb_pok != '0' THEN 1 END ) AS wp_pkb_pok,

					SUM ( T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_den3 + T.bea_pkb_den4 + T.bea_pkb_den5 + T.bea_denkas_pkb ) AS pkb_den,
					COUNT (  CASE WHEN T.bea_pkb_den != '0' THEN 1 END  ) AS wp_pkb_den,


					SUM ( T.bea_bbn1_pok + T.bea_bbn2_pok +  T.bea_bbn_tgk1 + T.bea_bbn_tgk2  ) AS bbn_pok,
					COUNT ( CASE WHEN T.bea_bbn1_pok != '0' THEN 1 END) AS wp_bbn_pok,

					SUM ( T.bea_bbn1_den + T.bea_denkas_bbn1 + T.bea_bbn2_den + T.bea_denkas_bbn2 + T.bea_bbn_den1 + T.bea_bbn_den2) AS bbn_den,
					COUNT (CASE WHEN T.bea_bbn1_den != '0' THEN 1 END  ) AS wp_bbn_den,


					SUM ( T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4 ) AS swd_pok,
					COUNT ( CASE WHEN T.bea_swdkllj_pok != '0' THEN 1 END  ) AS wp_swd_pok,

					SUM ( T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd ) AS swd_den,
					COUNT ( CASE WHEN T.bea_swdkllj_den != '0' THEN 1 END) AS wp_swd_den,

					SUM ( bea_adm_stnk ) AS adm_stnk,
					COUNT ( CASE WHEN T.bea_adm_stnk != '0' THEN 1 END ) AS wp_adm_stnk,

					SUM ( T.bea_plat_nomor ) AS plat_nomor,
					COUNT (CASE WHEN T.bea_plat_nomor != '0' THEN 1 END ) AS wp_plat_nomor,

					SUM ( C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5 ) AS opsen_pkb_pok,
					COUNT (CASE WHEN C.opsen_pkb_pok != '0' THEN 1 END ) AS wp_opsen_pkb_pok,

					SUM ( C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_den,
					COUNT ( CASE WHEN C.opsen_pkb_den != '0' THEN 1 END ) AS wp_opsen_pkb_den,

					SUM ( C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2 ) AS opsen_bbn_pok,
					COUNT ( CASE WHEN C.opsen_bbn1_pok != '0' THEN 1 END ) AS wp_opsen_bbn_pok,

					SUM ( C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2 ) AS opsen_bbn_den,
					COUNT ( CASE WHEN C.opsen_bbn1_den != '0' THEN 1 END) AS wp_opsen_bbn_den,

					COUNT ( T.bea_pkb_pok ) AS jml_wp

					FROM
						t_trnkb
					T LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
					WHERE
						T.tg_bayar = '$tanggal'
						AND T.kd_lokasi LIKE '%$kd_lokasi%'
						AND T.kd_status >= '4 '
						AND T.kd_kasir != 'X'
					";
        return DB::connection(\Auth::user()->kd_wilayah)->selectOne($q);
    }

    public function getRekapRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi)
    {
        $q = "SELECT
                SUM ( T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pok,
                COUNT (  CASE WHEN T.bea_pkb_pok != 0 THEN 1 END ) AS wp_pkb_pok,

                SUM ( T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_den3 + T.bea_pkb_den4 + T.bea_pkb_den5 + T.bea_denkas_pkb ) AS pkb_den,
                COUNT (  CASE WHEN T.bea_pkb_den != 0 THEN 1 END  ) AS wp_pkb_den,

                SUM ( T.bea_bbn1_pok + T.bea_bbn2_pok +  T.bea_bbn_tgk1 + T.bea_bbn_tgk2  ) AS bbn_pok,
                COUNT ( CASE WHEN T.bea_bbn1_pok != 0 THEN 1 END) AS wp_bbn_pok,

                SUM ( T.bea_bbn1_den + T.bea_denkas_bbn1 + T.bea_bbn2_den + T.bea_denkas_bbn2 + T.bea_bbn_den1 + T.bea_bbn_den2) AS bbn_den,
                COUNT (CASE WHEN T.bea_bbn1_den != 0 THEN 1 END  ) AS wp_bbn_den,

                SUM ( T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4 ) AS swd_pok,
                COUNT ( CASE WHEN T.bea_swdkllj_pok != 0 THEN 1 END  ) AS wp_swd_pok,

                SUM ( T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd ) AS swd_den,
                COUNT ( CASE WHEN T.bea_swdkllj_den != 0 THEN 1 END) AS wp_swd_den,

                SUM ( bea_adm_stnk ) AS adm_stnk,
                COUNT ( CASE WHEN T.bea_adm_stnk != 0 THEN 1 END ) AS wp_adm_stnk,

                SUM ( T.bea_plat_nomor ) AS plat_nomor,
                COUNT (CASE WHEN T.bea_plat_nomor != 0 THEN 1 END ) AS wp_plat_nomor,

                SUM ( C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5 ) AS opsen_pkb_pok,
                COUNT (CASE WHEN C.opsen_pkb_pok != 0 THEN 1 END ) AS wp_opsen_pkb_pok,

                SUM ( C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_den,
                COUNT ( CASE WHEN C.opsen_pkb_den != 0 THEN 1 END ) AS wp_opsen_pkb_den,

                SUM ( C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2 ) AS opsen_bbn_pok,
                COUNT ( CASE WHEN C.opsen_bbn1_pok != 0 THEN 1 END ) AS wp_opsen_bbn_pok,

                SUM ( C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2 ) AS opsen_bbn_den,
                COUNT ( CASE WHEN C.opsen_bbn1_den != 0 THEN 1 END) AS wp_opsen_bbn_den,

                COUNT ( T.bea_pkb_pok ) AS jml_wp

            FROM
                t_trnkb T
                LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
            WHERE
                T.tg_bayar BETWEEN ? AND ?
                AND T.kd_lokasi LIKE ?
                AND T.kd_status >= '4'
                AND T.kd_kasir != 'X'";

        return DB::connection($kd_wilayah)->selectOne($q, [$tg_awal, $tg_akhir, "%$kd_lokasi%"]);
    }
    public function getRekapRentangWaktuByKdWilayah($tg_awal, $tg_akhir, $kd_db, $kd_wilayah)
    {
        $q = "SELECT
                SUM ( T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pok,
                COUNT (  CASE WHEN T.bea_pkb_pok != 0 THEN 1 END ) AS wp_pkb_pok,

                SUM ( T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_den3 + T.bea_pkb_den4 + T.bea_pkb_den5 + T.bea_denkas_pkb ) AS pkb_den,
                COUNT (  CASE WHEN T.bea_pkb_den != 0 THEN 1 END  ) AS wp_pkb_den,

                SUM ( T.bea_bbn1_pok + T.bea_bbn2_pok +  T.bea_bbn_tgk1 + T.bea_bbn_tgk2  ) AS bbn_pok,
                COUNT ( CASE WHEN T.bea_bbn1_pok != 0 THEN 1 END) AS wp_bbn_pok,

                SUM ( T.bea_bbn1_den + T.bea_denkas_bbn1 + T.bea_bbn2_den + T.bea_denkas_bbn2 + T.bea_bbn_den1 + T.bea_bbn_den2) AS bbn_den,
                COUNT (CASE WHEN T.bea_bbn1_den != 0 THEN 1 END  ) AS wp_bbn_den,

                SUM ( T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4 ) AS swd_pok,
                COUNT ( CASE WHEN T.bea_swdkllj_pok != 0 THEN 1 END  ) AS wp_swd_pok,

                SUM ( T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd ) AS swd_den,
                COUNT ( CASE WHEN T.bea_swdkllj_den != 0 THEN 1 END) AS wp_swd_den,

                SUM ( bea_adm_stnk ) AS adm_stnk,
                COUNT ( CASE WHEN T.bea_adm_stnk != 0 THEN 1 END ) AS wp_adm_stnk,

                SUM ( T.bea_plat_nomor ) AS plat_nomor,
                COUNT (CASE WHEN T.bea_plat_nomor != 0 THEN 1 END ) AS wp_plat_nomor,

                SUM ( C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5 ) AS opsen_pkb_pok,
                COUNT (CASE WHEN C.opsen_pkb_pok != 0 THEN 1 END ) AS wp_opsen_pkb_pok,

                SUM ( C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_den,
                COUNT ( CASE WHEN C.opsen_pkb_den != 0 THEN 1 END ) AS wp_opsen_pkb_den,

                SUM ( C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2 ) AS opsen_bbn_pok,
                COUNT ( CASE WHEN C.opsen_bbn1_pok != 0 THEN 1 END ) AS wp_opsen_bbn_pok,

                SUM ( C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2 ) AS opsen_bbn_den,
                COUNT ( CASE WHEN C.opsen_bbn1_den != 0 THEN 1 END) AS wp_opsen_bbn_den,

                COUNT ( T.bea_pkb_pok ) AS jml_wp

            FROM
                t_trnkb T
                LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
            WHERE
                T.tg_bayar BETWEEN ? AND ?
                AND T.kd_wilayah = ?
                AND T.kd_status >= '4'
                AND T.kd_kasir != 'X'";

        return DB::connection($kd_db)->selectOne($q, [$tg_awal, $tg_akhir, $kd_wilayah]);
    }

    public function getRekapharianUser($tanggal, $kd_lokasi)
    {
        $query = "
        SELECT
            T.user_id_bayar AS user,
            L.nm_lokasi,
            L.kd_lokasi,
            SUM(T.bea_pkb_pok + T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5) AS pkb_pok,
            COUNT(CASE WHEN T.bea_pkb_pok != 0 THEN 1 END) AS wp_pkb_pok,

            SUM(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_den3 + T.bea_pkb_den4 + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_den,
            COUNT(CASE WHEN T.bea_pkb_den != 0 THEN 1 END) AS wp_pkb_den,

            SUM(T.bea_bbn1_pok + T.bea_bbn2_pok + T.bea_bbn_tgk1 + T.bea_bbn_tgk2) AS bbn_pok,
            COUNT(CASE WHEN T.bea_bbn1_pok != 0 THEN 1 END) AS wp_bbn_pok,

            SUM(T.bea_bbn1_den + T.bea_denkas_bbn1 + T.bea_bbn2_den + T.bea_denkas_bbn2 + T.bea_bbn_den1 + T.bea_bbn_den2) AS bbn_den,
            COUNT(CASE WHEN T.bea_bbn1_den != 0 THEN 1 END) AS wp_bbn_den,

            SUM(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pok,
            COUNT(CASE WHEN T.bea_swdkllj_pok != 0 THEN 1 END) AS wp_swd_pok,

            SUM(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_den,
            COUNT(CASE WHEN T.bea_swdkllj_den != 0 THEN 1 END) AS wp_swd_den,

            SUM(bea_adm_stnk) AS adm_stnk,
            COUNT(CASE WHEN T.bea_adm_stnk != 0 THEN 1 END) AS wp_adm_stnk,

            SUM(T.bea_plat_nomor) AS plat_nomor,
            COUNT(CASE WHEN T.bea_plat_nomor != 0 THEN 1 END) AS wp_plat_nomor,

            SUM(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pok,
            COUNT(CASE WHEN C.opsen_pkb_pok != 0 THEN 1 END) AS wp_opsen_pkb_pok,

            SUM(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_den,
            COUNT(CASE WHEN C.opsen_pkb_den != 0 THEN 1 END) AS wp_opsen_pkb_den,

            SUM(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pok,
            COUNT(CASE WHEN C.opsen_bbn1_pok != 0 THEN 1 END) AS wp_opsen_bbn_pok,

            SUM(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_den,
            COUNT(CASE WHEN C.opsen_bbn1_den != 0 THEN 1 END) AS wp_opsen_bbn_den,

            COUNT(T.bea_pkb_pok) AS jml_wp
        FROM
            t_trnkb T
            LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
            LEFT JOIN t_lokasi L ON T.kd_lokasi = L.kd_lokasi
        WHERE
            T.tg_bayar = ?
            AND T.kd_lokasi LIKE ?
            AND T.kd_status >= '4'
            AND T.kd_kasir != 'X'
        GROUP BY
            T.user_id_bayar, L.kd_lokasi
        ORDER BY
            L.kd_lokasi;
        ";

        $result = DB::connection(\Auth::user()->kd_wilayah)->select($query, [$tanggal, "%$kd_lokasi%"]);
        return $result;

    }

    public function getDataPenerimaanOpsen($tanggal, $kd_lokasi)
    {
        $q = "SELECT
			t_wilayah.kd_wilayah,
			t_wilayah.nm_wilayah,
			COALESCE(SUM(
				C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2
			), 0) AS opsen_bbn_pokok,
			COALESCE(SUM(
				C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2
			), 0) AS opsen_bbn_denda,
			COALESCE(SUM(
				C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5
			), 0) AS opsen_pkb_pokok,
			COALESCE(SUM(
				C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5
			), 0) AS opsen_pkb_denda,
            COUNT(T.no_trn) AS jumlah_trn
			FROM
			t_wilayah
			LEFT JOIN t_trnkb T ON T.kd_wilayah = t_wilayah.kd_wilayah
				AND T.tg_bayar = '$tanggal'
				AND T.kd_lokasi LIKE '%$kd_lokasi%'
			LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
			GROUP BY
			t_wilayah.kd_wilayah, t_wilayah.nm_wilayah
            ORDER BY t_wilayah.kd_wilayah ASC;";
        return DB::connection(\Auth::user()->kd_wilayah)->select($q);
    }

    public function getDataPenerimaanOpsenRentangWaktu($tg_awal, $tg_akhir, $kd_wilayah, $kd_lokasi)
    {
        $q = "SELECT
			t_wilayah.kd_wilayah,
			t_wilayah.nm_wilayah,
			COALESCE(SUM(
				C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2
			), 0) AS opsen_bbn_pokok,
			COALESCE(SUM(
				C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2
			), 0) AS opsen_bbn_denda,
			COALESCE(SUM(
				C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5
			), 0) AS opsen_pkb_pokok,
			COALESCE(SUM(
				C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5
			), 0) AS opsen_pkb_denda,
            COUNT(T.no_trn) AS jumlah_trn
			FROM
			t_wilayah
			LEFT JOIN t_trnkb T ON T.kd_wilayah = t_wilayah.kd_wilayah
				AND T.tg_bayar BETWEEN ? AND ?
				AND T.kd_lokasi LIKE ?
			LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
			GROUP BY
			t_wilayah.kd_wilayah, t_wilayah.nm_wilayah
            ORDER BY t_wilayah.kd_wilayah ASC;";
        return DB::connection($kd_wilayah)->select($q, [$tg_awal, $tg_akhir, "%$kd_lokasi%"]);
    }
    public function getDataPenerimaanOpsenRentangWaktuByKdWilayah($tg_awal, $tg_akhir, $kd_db, $kd_wilayah)
    {
        $q = "SELECT
    SUBSTRING(t_lokasi.kd_lokasi, 1, 2) AS kd_lokasi_group,
    CASE SUBSTRING(t_lokasi.kd_lokasi, 1, 2)
        WHEN '01' THEN 'UPTD PPD SAMSAT KOTA JAMBI'
        WHEN '02' THEN 'UPTD PPD SAMSAT KAB. BATANGHARI'
        WHEN '03' THEN 'UPTD PPD SAMSAT KAB. TANJAB BARAT'
        WHEN '04' THEN 'UPTD PPD SAMSAT KAB. MERANGIN'
        WHEN '05' THEN 'UPTD PPD SAMSAT KAB. BUNGO'
        WHEN '06' THEN 'UPTD PPD SAMSAT KAB. KERINCI'
        WHEN '07' THEN 'UPTD PPD SAMSAT KAB. TANJAB TIMUR'
        WHEN '08' THEN 'UPTD PPD SAMSAT KAB. MUARO JAMBI'
        WHEN '09' THEN 'UPTD PPD SAMSAT KAB. SAROLANGUN'
        WHEN '10' THEN 'UPTD PPD SAMSAT KAB. TEBO'
        ELSE 'UNKNOWN LOCATION'
    END AS nm_lokasi,
    COALESCE(SUM(
        C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2
    ), 0) AS opsen_bbn_pokok,
    COALESCE(SUM(
        C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2
    ), 0) AS opsen_bbn_denda,
    COALESCE(SUM(
        C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5
    ), 0) AS opsen_pkb_pokok,
    COALESCE(SUM(
        C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5
    ), 0) AS opsen_pkb_denda,
    COUNT(T.no_trn) AS jumlah_trn
FROM
    t_lokasi
LEFT JOIN t_trnkb T ON T.kd_lokasi = t_lokasi.kd_lokasi
LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
WHERE
    T.tg_bayar BETWEEN ? AND ?
    AND T.kd_wilayah = ?
GROUP BY
    SUBSTRING(t_lokasi.kd_lokasi, 1, 2),
    CASE SUBSTRING(t_lokasi.kd_lokasi, 1, 2)
        WHEN '01' THEN 'UPTD PPD SAMSAT KOTA JAMBI'
        WHEN '02' THEN 'UPTD PPD SAMSAT KAB. BATANGHARI'
        WHEN '03' THEN 'UPTD PPD SAMSAT KAB. TANJAB BARAT'
        WHEN '04' THEN 'UPTD PPD SAMSAT KAB. MERANGIN'
        WHEN '05' THEN 'UPTD PPD SAMSAT KAB. BUNGO'
        WHEN '06' THEN 'UPTD PPD SAMSAT KAB. KERINCI'
        WHEN '07' THEN 'UPTD PPD SAMSAT KAB. TANJAB TIMUR'
        WHEN '08' THEN 'UPTD PPD SAMSAT KAB. MUARO JAMBI'
        WHEN '09' THEN 'UPTD PPD SAMSAT KAB. SAROLANGUN'
        WHEN '10' THEN 'UPTD PPD SAMSAT KAB. TEBO'
        ELSE 'UNKNOWN LOCATION'
    END
ORDER BY
    kd_lokasi_group ASC;
";
        return DB::connection($kd_db)->select($q, [$tg_awal, $tg_akhir, $kd_wilayah]);
    }

    public function sumPokokDanDenda($t_trnkb)
    {
        $bbnPokKeys = ['bea_bbn1_pok', 'bea_bbn2_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbnDenKeys = ['bea_bbn1_den', 'bea_bbn2_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $bbn1PokKeys = ['bea_bbn1_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbn1DenKeys = ['bea_bbn1_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $bbn2PokKeys = ['bea_bbn2_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbn2DenKeys = ['bea_bbn2_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $opsenBbnPokKeys = ['opsen_bbn1_pok', 'opsen_bbn2_pok', 'opsen_bbn_tgk1', 'opsen_bbn_tgk2'];
        $opsenBbnDenKeys = ['opsen_bbn1_den', 'opsen_bbn2_den', 'opsen_bbn_den1', 'opsen_bbn_den2'];

        $pkbPokKeys = ['bea_pkb_pok', 'bea_pkb_tgk1', 'bea_pkb_tgk2', 'bea_pkb_tgk3', 'bea_pkb_tgk4', 'bea_pkb_tgk5'];
        $pkbDenKeys = ['bea_pkb_den', 'bea_pkb_den1', 'bea_pkb_den2', 'bea_pkb_den3', 'bea_pkb_den4', 'bea_pkb_den5'];

        $opsenPkbPokKeys = ['opsen_pkb_pok', 'opsen_pkb_tgk1', 'opsen_pkb_tgk2', 'opsen_pkb_tgk3', 'opsen_pkb_tgk4', 'opsen_pkb_tgk5'];
        $opsenPkbDenKeys = ['opsen_pkb_den', 'opsen_pkb_den1', 'opsen_pkb_den2', 'opsen_pkb_den3', 'opsen_pkb_den4', 'opsen_pkb_den5'];

        $swdklljPokKeys = ['bea_swdkllj_pok', 'bea_swdkllj_tgk1', 'bea_swdkllj_tgk2', 'bea_swdkllj_tgk3', 'bea_swdkllj_tgk4'];
        $swdklljDenKeys = ['bea_swdkllj_den', 'bea_swdkllj_den1', 'bea_swdkllj_den2', 'bea_swdkllj_den3', 'bea_swdkllj_den4'];

        // Calculate totals

        $bea_bbn1_pok = $this->calculateTotal($t_trnkb, $bbn1PokKeys);
        $bea_bbn1_den = $this->calculateTotal($t_trnkb, $bbn1DenKeys);
        $bea_bbn1     = $bea_bbn1_pok + $bea_bbn1_den;

        $bea_bbn2_pok = $this->calculateTotal($t_trnkb, $bbn2PokKeys);
        $bea_bbn2_den = $this->calculateTotal($t_trnkb, $bbn2DenKeys);
        $bea_bbn2     = $bea_bbn2_pok + $bea_bbn2_den;

        $bea_bbn_pok = $this->calculateTotal($t_trnkb, $bbnPokKeys);
        $bea_bbn_den = $this->calculateTotal($t_trnkb, $bbnDenKeys);
        $bea_bbn     = $bea_bbn_pok + $bea_bbn_den;

        $opsen = $t_trnkb->opsen;

        $bea_opsen_bbn_pok = $this->calculateTotal($opsen, $opsenBbnPokKeys);
        $bea_opsen_bbn_den = $this->calculateTotal($opsen, $opsenBbnDenKeys);
        $bea_opsen_bbn     = $bea_opsen_bbn_pok + $bea_opsen_bbn_den;

        $bea_pkb_pok = $this->calculateTotal($t_trnkb, $pkbPokKeys);
        $bea_pkb_den = $this->calculateTotal($t_trnkb, $pkbDenKeys);
        $bea_pkb     = $bea_pkb_pok + $bea_pkb_den;

        $bea_opsen_pkb_pok = $this->calculateTotal($opsen, $opsenPkbPokKeys);
        $bea_opsen_pkb_den = $this->calculateTotal($opsen, $opsenPkbDenKeys);
        $bea_opsen_pkb     = $bea_opsen_pkb_pok + $bea_opsen_pkb_den;

        $bea_swdkllj_pok = $this->calculateTotal($t_trnkb, $swdklljPokKeys);
        $bea_swdkllj_den = $this->calculateTotal($t_trnkb, $swdklljDenKeys);
        $bea_swdkllj     = $bea_swdkllj_pok + $bea_swdkllj_den;

        $bea_adm_stnk   = (float) $t_trnkb->bea_adm_stnk;
        $bea_plat_nomor = (float) $t_trnkb->bea_plat_nomor;

        // Final totals
        $total_pokok   = $bea_bbn_pok + $bea_opsen_bbn_pok + $bea_pkb_pok + $bea_opsen_pkb_pok + $bea_swdkllj_pok;
        $total_denda   = $bea_bbn_den + $bea_opsen_bbn_den + $bea_pkb_den + $bea_opsen_pkb_den + $bea_swdkllj_den;
        $total_seluruh = $bea_bbn + $bea_opsen_bbn + $bea_pkb + $bea_opsen_pkb + $bea_swdkllj;

        return [
            'pokok_bbnkb'       => $bea_bbn_pok,
            'denda_bbnkb'       => $bea_bbn_den,
            'total_bbnkb'       => $bea_bbn,

            'pokok_bbn1'        => $bea_bbn1_pok,
            'denda_bbn1'        => $bea_bbn1_den,
            'total_bbn1'        => $bea_bbn1,

            'pokok_bbn2'        => $bea_bbn2_pok,
            'denda_bbn2'        => $bea_bbn2_den,
            'total_bbn2'        => $bea_bbn2,

            'pokok_pkb'         => $bea_pkb_pok,
            'denda_pkb'         => $bea_pkb_den,
            'total_pkb'         => $bea_pkb,

            'pokok_swdkllj'     => $bea_swdkllj_pok,
            'denda_swdkllj'     => $bea_swdkllj_den,
            'total_swdkllj'     => $bea_swdkllj,

            'pokok_opsen_bbnkb' => $bea_opsen_bbn_pok,
            'denda_opsen_bbnkb' => $bea_opsen_bbn_den,
            'total_opsen_bbnkb' => $bea_opsen_bbn,

            'pokok_opsen_pkb'   => $bea_opsen_pkb_pok,
            'denda_opsen_pkb'   => $bea_opsen_pkb_den,
            'total_opsen_pkb'   => $bea_opsen_pkb,

            'bea_adm_stnk'      => $bea_adm_stnk,
            'bea_plat_nomor'    => $bea_plat_nomor,

            'total_pokok'       => $total_pokok,
            'total_denda'       => $total_denda,
            'total_seluruh'     => $total_seluruh,
        ];
    }

    public function sumPokokDanDendaNotice($t_trnkb)
    {
        $bbnPokKeys = ['bea_bbn1_pok', 'bea_bbn2_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbnDenKeys = ['bea_bbn1_den', 'bea_bbn2_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $bbn1PokKeys = ['bea_bbn1_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbn1DenKeys = ['bea_bbn1_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $bbn2PokKeys = ['bea_bbn2_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbn2DenKeys = ['bea_bbn2_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $opsenBbnPokKeys = ['opsen_bbn1_pok', 'opsen_bbn2_pok', 'opsen_bbn_tgk1', 'opsen_bbn_tgk2'];
        $opsenBbnDenKeys = ['opsen_bbn1_den', 'opsen_bbn2_den', 'opsen_bbn_den1', 'opsen_bbn_den2'];

        $pkbPokKeys = ['bea_pkb_pok', 'bea_pkb_tgk1', 'bea_pkb_tgk2', 'bea_pkb_tgk3', 'bea_pkb_tgk4', 'bea_pkb_tgk5'];
        $pkbDenKeys = ['bea_pkb_den', 'bea_pkb_den1', 'bea_pkb_den2', 'bea_pkb_den3', 'bea_pkb_den4', 'bea_pkb_den5'];

        $opsenPkbPokKeys = ['opsen_pkb_pok', 'opsen_pkb_tgk1', 'opsen_pkb_tgk2', 'opsen_pkb_tgk3', 'opsen_pkb_tgk4', 'opsen_pkb_tgk5'];
        $opsenPkbDenKeys = ['opsen_pkb_den', 'opsen_pkb_den1', 'opsen_pkb_den2', 'opsen_pkb_den3', 'opsen_pkb_den4', 'opsen_pkb_den5'];

        $swdklljPokKeys = ['bea_swdkllj_pok', 'bea_swdkllj_tgk1', 'bea_swdkllj_tgk2', 'bea_swdkllj_tgk3', 'bea_swdkllj_tgk4'];
        $swdklljDenKeys = ['bea_swdkllj_den', 'bea_swdkllj_den1', 'bea_swdkllj_den2', 'bea_swdkllj_den3', 'bea_swdkllj_den4'];

        // Calculate totals

        $bea_bbn1_pok = $this->calculateTotal($t_trnkb, $bbn1PokKeys);
        $bea_bbn1_den = $this->calculateTotal($t_trnkb, $bbn1DenKeys);
        $bea_bbn1     = $bea_bbn1_pok + $bea_bbn1_den;

        $bea_bbn2_pok = $this->calculateTotal($t_trnkb, $bbn2PokKeys);
        $bea_bbn2_den = $this->calculateTotal($t_trnkb, $bbn2DenKeys);
        $bea_bbn2     = $bea_bbn2_pok + $bea_bbn2_den;

        $bea_bbn_pok = $this->calculateTotal($t_trnkb, $bbnPokKeys);
        $bea_bbn_den = $this->calculateTotal($t_trnkb, $bbnDenKeys);
        $bea_bbn     = $bea_bbn_pok + $bea_bbn_den;

        $opsen = $t_trnkb->opsen;

        $bea_opsen_bbn_pok = $this->calculateTotal($opsen, $opsenBbnPokKeys);
        $bea_opsen_bbn_den = $this->calculateTotal($opsen, $opsenBbnDenKeys);
        $bea_opsen_bbn     = $bea_opsen_bbn_pok + $bea_opsen_bbn_den;

        $bea_pkb_pok = $this->calculateTotal($t_trnkb, $pkbPokKeys);
        $bea_pkb_den = $this->calculateTotal($t_trnkb, $pkbDenKeys);
        $bea_pkb     = $bea_pkb_pok + $bea_pkb_den;

        $bea_opsen_pkb_pok = $this->calculateTotal($opsen, $opsenPkbPokKeys);
        $bea_opsen_pkb_den = $this->calculateTotal($opsen, $opsenPkbDenKeys);
        $bea_opsen_pkb     = $bea_opsen_pkb_pok + $bea_opsen_pkb_den;

        $bea_swdkllj_pok = $this->calculateTotal($t_trnkb, $swdklljPokKeys);
        $bea_swdkllj_den = $this->calculateTotal($t_trnkb, $swdklljDenKeys);
        $bea_swdkllj     = $bea_swdkllj_pok + $bea_swdkllj_den;

        $bea_adm_stnk   = (float) $t_trnkb->bea_adm_stnk;
        $bea_plat_nomor = (float) $t_trnkb->bea_plat_nomor;
        // Final totals
        $total_pokok   = $bea_bbn_pok + $bea_opsen_bbn_pok + $bea_pkb_pok + $bea_opsen_pkb_pok + $bea_swdkllj_pok + $t_trnkb->bea_adm_stnk + $t_trnkb->bea_plat_nomor;
        $total_denda   = $bea_bbn_den + $bea_opsen_bbn_den + $bea_pkb_den + $bea_opsen_pkb_den + $bea_swdkllj_den;
        $total_seluruh = $bea_bbn + $bea_opsen_bbn + $bea_pkb + $bea_opsen_pkb + $bea_swdkllj + $bea_adm_stnk + $bea_plat_nomor;

        return [
            'pokok_bbnkb'       => $bea_bbn_pok,
            'denda_bbnkb'       => $bea_bbn_den,
            'total_bbnkb'       => $bea_bbn,

            'pokok_bbn1'        => $bea_bbn1_pok,
            'denda_bbn1'        => $bea_bbn1_den,
            'total_bbn1'        => $bea_bbn1,

            'pokok_bbn2'        => $bea_bbn2_pok,
            'denda_bbn2'        => $bea_bbn2_den,
            'total_bbn2'        => $bea_bbn2,

            'pokok_pkb'         => $bea_pkb_pok,
            'denda_pkb'         => $bea_pkb_den,
            'total_pkb'         => $bea_pkb,

            'pokok_swdkllj'     => $bea_swdkllj_pok,
            'denda_swdkllj'     => $bea_swdkllj_den,
            'total_swdkllj'     => $bea_swdkllj,

            'pokok_opsen_bbnkb' => $bea_opsen_bbn_pok,
            'denda_opsen_bbnkb' => $bea_opsen_bbn_den,
            'total_opsen_bbnkb' => $bea_opsen_bbn,

            'pokok_opsen_pkb'   => $bea_opsen_pkb_pok,
            'denda_opsen_pkb'   => $bea_opsen_pkb_den,
            'total_opsen_pkb'   => $bea_opsen_pkb,

            'bea_adm_stnk'      => $bea_adm_stnk,
            'bea_plat_nomor'    => $bea_plat_nomor,

            'total_pokok'       => $total_pokok,
            'total_denda'       => $total_denda,
            'total_seluruh'     => $total_seluruh,
        ];
    }

    public function calculateTotal($data, array $keys)
    {
        $total = 0;
        foreach ($keys as $key) {
            $total += $data->$key ?? 0;
        }
        return $total;
    }

}

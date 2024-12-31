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

    public function getDataTransaksi($noPolisi, $kodeStatus)
    {
        return $this->trnkb
            ->with('opsen')
            ->with('wilayah')
            ->with('lokasi')
            ->with('bbm')
            ->with('plat')
            ->with('fungsikb')
            ->with('jenismilik')
            ->where('no_polisi', $noPolisi)
            ->where('kd_status', $kodeStatus)
            ->orderBy('tg_daftar', 'desc')
            ->first();
    }

    public function getLaporanTransaksiHarian($tanggal, $kd_lokasi)
    {
        $query = DB::table(DB::raw('t_trnkb AS T'))
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
                DB::raw('(T.bea_pkb_den + T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_tgk3 + T.bea_pkb_den3 + T.bea_pkb_tgk4 + T.bea_pkb_den4 + T.bea_pkb_tgk5 + T.bea_pkb_den5 + T.bea_denkas_pkb) AS pkb_denda'),
                DB::raw('(T.bea_swdkllj_pok + T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4) AS swd_pokok'),
                DB::raw('(T.bea_swdkllj_den + T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 + T.bea_denkas_swd) AS swd_denda'),
                DB::raw('(C.opsen_bbn1_pok + C.opsen_bbn2_pok + C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS opsen_bbn_pokok'),
                DB::raw('(C.opsen_bbn1_den + C.opsen_bbn2_den + C.opsen_bbn_den1 + C.opsen_bbn_den2) AS opsen_bbn_denda'),
                DB::raw('(C.opsen_pkb_pok + C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5) AS opsen_pkb_pokok'),
                DB::raw('(C.opsen_pkb_den + C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5) AS opsen_pkb_denda'),
                DB::raw("CASE WHEN t_post_qris.nama IS NOT NULL THEN 'Non Tunai (QRIS)' ELSE 'Tunai' END AS metode_bayar")
            )
            ->join(DB::raw('cweb_t_opsen AS C'), DB::raw('T.no_trn'), '=', DB::raw('C.no_trn'))
            ->leftJoin(DB::raw('t_post_qris'), function ($join) {
                $join->on(DB::raw('T.no_polisi'), '=', DB::raw('t_post_qris.nama'))
                    ->where(DB::raw('t_post_qris.status_bayar'), '=', 'L');
            })
            ->where(DB::raw('T.tg_bayar'), $tanggal)
            ->where(DB::raw('T.kd_lokasi'), 'like', "%$kd_lokasi%")
            ->orderByRaw("CAST(split_part(T.no_noticepp, ' ', 2) AS INTEGER) ASC");

        return $query->get();

    }

    public function getRekapharian($tanggal, $kd_lokasi)
    {
        $q = "SELECT
					SUM ( T.bea_pkb_pok ) pkb_pok,
					COUNT ( T.bea_pkb_pok ) AS wp_pkb_pok,

					SUM ( T.bea_pkb_den + T.bea_denkas_pkb ) pkb_den,
					COUNT ( CASE WHEN T.bea_pkb_den != '0' OR T.bea_denkas_pkb != '0' THEN 1 END ) AS wp_pkb_den,

					SUM ( T.bea_pkb_tgk1 + T.bea_pkb_tgk2 + T.bea_pkb_tgk3 + T.bea_pkb_tgk4 + T.bea_pkb_tgk5 ) AS tgk_pkb_pok,
					COUNT ( CASE WHEN T.bea_pkb_tgk1 != '0' OR T.bea_pkb_tgk2 != '0' OR T.bea_pkb_tgk3 != '0' OR T.bea_pkb_tgk4 != '0' OR T.bea_pkb_tgk5 != '0' THEN 1 END ) AS wp_tgk_pkb_pok,

					SUM ( T.bea_pkb_den1 + T.bea_pkb_den2 + T.bea_pkb_den3 + T.bea_pkb_den4 + T.bea_pkb_den5 ) AS tgk_pkb_den,
					COUNT ( CASE WHEN T.bea_pkb_den1 != '0' OR T.bea_pkb_den2 != '0' OR T.bea_pkb_den3 != '0' OR T.bea_pkb_den4 != '0' OR T.bea_pkb_den5 != '0' THEN 1 END ) AS wp_tgk_pkb_den,

					SUM ( T.bea_bbn1_pok ) AS bbn1_pok,
					COUNT ( CASE WHEN T.bea_bbn1_pok != '0' THEN 1 END ) AS wp_bbn1_pok,

					SUM ( T.bea_bbn1_den + T.bea_denkas_bbn1 ) AS bbn1_den,
					COUNT ( CASE WHEN T.bea_bbn1_den != '0' OR T.bea_denkas_bbn1 != '0' THEN 1 END ) AS wp_bbn1_den,

					SUM ( T.bea_bbn_tgk1 ) AS tgk_bbn1_pok,
					COUNT ( CASE WHEN T.bea_bbn_tgk1 != '0' THEN 1 END ) AS wp_tgk_bbn1_pok,

					SUM ( T.bea_bbn_den1 ) AS tgk_bbn1_den,
					COUNT ( CASE WHEN T.bea_bbn_den1 != '0' THEN 1 END ) AS wp_tgk_bbn1_den,

					SUM ( T.bea_bbn2_pok ) bbn2_pok,
					COUNT ( CASE WHEN T.bea_bbn2_pok != '0' THEN 1 END ) AS wp_bbn2_pok,

					SUM ( T.bea_bbn2_den + T.bea_denkas_bbn2 ) AS bbn2_den,
					COUNT ( CASE WHEN T.bea_bbn2_den != '0' OR T.bea_denkas_bbn2 != '0' THEN 1 END ) AS wp_bbn2_den,

					SUM ( T.bea_bbn_tgk2 ) AS tgk_bbn2_pok,
					COUNT ( CASE WHEN T.bea_bbn_tgk2 != '0' THEN 1 END ) AS wp_tgk_bbn2_pok,

					SUM ( T.bea_bbn_den2 ) AS tgk_bbn2_den,
					COUNT ( CASE WHEN T.bea_bbn_den2 != '0' THEN 1 END ) AS wp_tgk_bbn2_den,

					SUM ( T.bea_swdkllj_pok ) AS swd_pok,
					COUNT ( CASE WHEN T.bea_swdkllj_pok != '0' THEN 1 END ) AS wp_swd_pok,

					SUM ( T.bea_swdkllj_den + T.bea_denkas_swd ) AS swd_den,
					COUNT ( CASE WHEN T.bea_swdkllj_den != '0' OR T.bea_denkas_swd != '0' THEN 1 END ) AS wp_swd_den,

					SUM ( T.bea_swdkllj_tgk1 + T.bea_swdkllj_tgk2 + T.bea_swdkllj_tgk3 + T.bea_swdkllj_tgk4 ) AS tgk_swd_pok,
					COUNT ( CASE WHEN T.bea_swdkllj_tgk1 != '0' OR T.bea_swdkllj_tgk2 != '0' OR T.bea_swdkllj_tgk3 != '0' OR T.bea_swdkllj_tgk4 != '0' THEN 1 END ) AS wp_tgk_swd_pok,

					SUM ( T.bea_swdkllj_den1 + T.bea_swdkllj_den2 + T.bea_swdkllj_den3 + T.bea_swdkllj_den4 ) AS tgk_swd_den,
					COUNT ( CASE WHEN T.bea_swdkllj_den1 != '0' OR T.bea_swdkllj_den2 != '0' OR T.bea_swdkllj_den3 != '0' OR T.bea_swdkllj_den4 != '0' THEN 1 END ) AS wp_tgk_swd_den,

					SUM ( bea_adm_stnk ) AS adm_stnk,
					COUNT ( CASE WHEN bea_adm_stnk != '0' THEN 1 END ) AS wp_adm_stnk,

					SUM ( T.bea_plat_nomor ) AS plat_nomor,
					COUNT ( CASE WHEN T.bea_plat_nomor != '0' THEN 1 END ) AS wp_plat_nomor,

					SUM ( T.bea_leges_pkb ) AS leges_pkb,
					COUNT ( CASE WHEN T.bea_leges_pkb != '0' THEN 1 END ) AS wp_leges_pkb,

					SUM ( T.bea_leges_bbn ) AS leges_bbn,
					COUNT ( CASE WHEN T.bea_leges_bbn != '0' THEN 1 END ) AS wp_leges_bbn,

					SUM ( T.bea_leges_frm ) AS leges_frm,
					COUNT ( CASE WHEN T.bea_leges_frm != '0' THEN 1 END ) AS wp_leges_frm,

					SUM ( T.bea_leges_fis ) AS leges_fis,
					COUNT ( CASE WHEN T.bea_leges_fis != '0' THEN 1 END ) AS wp_leges_fis,

					SUM ( T.bea_leges_fad ) AS leges_fad,
					COUNT ( CASE WHEN T.bea_leges_fad != '0' THEN 1 END ) AS wp_leges_fad,

					SUM ( T.bea_penning ) AS penning,
					COUNT ( CASE WHEN T.bea_penning != '0' THEN 1 END ) AS wp_penning,

					SUM ( C.opsen_pkb_pok ) opsen_pkb_pok,
					COUNT ( C.opsen_pkb_pok ) AS wp_opsen_pkb_pok,

					SUM ( C.opsen_pkb_den) opsen_pkb_den,
					COUNT ( CASE WHEN C.opsen_pkb_den != '0' THEN 1 END ) AS wp_opsen_pkb_den,

					SUM ( C.opsen_pkb_tgk1 + C.opsen_pkb_tgk2 + C.opsen_pkb_tgk3 + C.opsen_pkb_tgk4 + C.opsen_pkb_tgk5 ) AS tgk_opsen_pkb_pok,
					COUNT ( CASE WHEN C.opsen_pkb_tgk1 != '0' OR C.opsen_pkb_tgk2 != '0' OR C.opsen_pkb_tgk3 != '0' OR C.opsen_pkb_tgk4 != '0' OR C.opsen_pkb_tgk5 != '0' THEN 1 END ) AS wp_tgk_opsen_pkb_pok,

					SUM ( C.opsen_pkb_den1 + C.opsen_pkb_den2 + C.opsen_pkb_den3 + C.opsen_pkb_den4 + C.opsen_pkb_den5 ) AS tgk_opsen_pkb_den,
					COUNT ( CASE WHEN C.opsen_pkb_den1 != '0' OR C.opsen_pkb_den2 != '0' OR C.opsen_pkb_den3 != '0' OR C.opsen_pkb_den4 != '0' OR C.opsen_pkb_den5 != '0' THEN 1 END ) AS wp_tgk_opsen_pkb_den,

					SUM ( C.opsen_bbn1_pok + C.opsen_bbn2_pok ) opsen_bbn_pok,
					COUNT ( CASE WHEN C.opsen_bbn1_pok != '0' OR C.opsen_bbn2_pok != '0' THEN 1 END ) AS wp_opsen_bbn_pok,

					SUM ( C.opsen_bbn1_den + C.opsen_bbn2_den ) opsen_bbn_den,
					COUNT ( CASE WHEN C.opsen_bbn1_den != '0' OR C.opsen_bbn2_den != '0' THEN 1 END) AS wp_opsen_bbn_den,

					SUM ( C.opsen_bbn_tgk1 + C.opsen_bbn_tgk2) AS tgk_opsen_bbn_pok,
					COUNT ( CASE WHEN C.opsen_bbn_tgk1 != '0' OR C.opsen_bbn_tgk2 != '0' THEN 1 END ) AS wp_tgk_opsen_bbn_pok,

					SUM ( C.opsen_bbn_den1 + C.opsen_bbn_den2 ) AS tgk_opsen_bbn_den,
					COUNT ( CASE WHEN C.opsen_bbn_den1 != '0' OR C.opsen_bbn_den2 != '0'THEN 1 END ) AS wp_tgk_opsen_bbn_den,

					COUNT ( T.bea_pkb_pok ) AS jml_wp

					FROM
						t_trnkb
					T JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
					WHERE
						T.tg_bayar = '$tanggal'
						AND T.kd_lokasi LIKE '%$kd_lokasi%'
						AND T.kd_status >= '4 '
						AND T.kd_kasir != 'X'
					";
        return DB::selectOne($q);
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
			), 0) AS opsen_pkb_denda
			FROM
			t_wilayah
			LEFT JOIN t_trnkb T ON T.kd_wilayah = t_wilayah.kd_wilayah
				AND T.tg_bayar = '$tanggal'
				AND T.kd_lokasi LIKE '%$kd_lokasi%'
			LEFT JOIN cweb_t_opsen C ON T.no_trn = C.no_trn
			GROUP BY
			t_wilayah.kd_wilayah, t_wilayah.nm_wilayah
            ORDER BY t_wilayah.kd_wilayah ASC;";
        return DB::select($q);
    }

    public function sumPokokDanDenda($t_trnkb)
    {
        $bbnPokKeys = ['bea_bbn1_pok', 'bea_bbn2_pok', 'bea_bbn_tgk1', 'bea_bbn_tgk2'];
        $bbnDenKeys = ['bea_bbn1_den', 'bea_bbn2_den', 'bea_bbn_den1', 'bea_bbn_den2'];

        $opsenBbnPokKeys = ['opsen_bbn1_pok', 'opsen_bbn2_pok', 'opsen_bbn_tgk1', 'opsen_bbn_tgk2'];
        $opsenBbnDenKeys = ['opsen_bbn1_den', 'opsen_bbn2_den', 'opsen_bbn_den1', 'opsen_bbn_den2'];

        $pkbPokKeys = ['bea_pkb_pok', 'bea_pkb_tgk1', 'bea_pkb_tgk2', 'bea_pkb_tgk3', 'bea_pkb_tgk4', 'bea_pkb_tgk5'];
        $pkbDenKeys = ['bea_pkb_den', 'bea_pkb_den1', 'bea_pkb_den2', 'bea_pkb_den3', 'bea_pkb_den4', 'bea_pkb_den5'];

        $opsenPkbPokKeys = ['opsen_pkb_pok', 'opsen_pkb_tgk1', 'opsen_pkb_tgk2', 'opsen_pkb_tgk3', 'opsen_pkb_tgk4', 'opsen_pkb_tgk5'];
        $opsenPkbDenKeys = ['opsen_pkb_den', 'opsen_pkb_den1', 'opsen_pkb_den2', 'opsen_pkb_den3', 'opsen_pkb_den4', 'opsen_pkb_den5'];

        $swdklljPokKeys = ['bea_swdkllj_pok', 'bea_swdkllj_tgk1', 'bea_swdkllj_tgk2', 'bea_swdkllj_tgk3', 'bea_swdkllj_tgk4'];
        $swdklljDenKeys = ['bea_swdkllj_den', 'bea_swdkllj_den1', 'bea_swdkllj_den2', 'bea_swdkllj_den3', 'bea_swdkllj_den4'];

        // Calculate totals
        $bea_bbn_pok = $this->calculateTotal($t_trnkb, $bbnPokKeys);
        $bea_bbn_den = $this->calculateTotal($t_trnkb, $bbnDenKeys);
        $bea_bbn = $bea_bbn_pok + $bea_bbn_den;

        $opsen = $t_trnkb->opsen;

        $bea_opsen_bbn_pok = $this->calculateTotal($opsen, $opsenBbnPokKeys);
        $bea_opsen_bbn_den = $this->calculateTotal($opsen, $opsenBbnDenKeys);
        $bea_opsen_bbn = $bea_opsen_bbn_pok + $bea_opsen_bbn_den;

        $bea_pkb_pok = $this->calculateTotal($t_trnkb, $pkbPokKeys);
        $bea_pkb_den = $this->calculateTotal($t_trnkb, $pkbDenKeys);
        $bea_pkb = $bea_pkb_pok + $bea_pkb_den;

        $bea_opsen_pkb_pok = $this->calculateTotal($opsen, $opsenPkbPokKeys);
        $bea_opsen_pkb_den = $this->calculateTotal($opsen, $opsenPkbDenKeys);
        $bea_opsen_pkb = $bea_opsen_pkb_pok + $bea_opsen_pkb_den;

        $bea_swdkllj_pok = $this->calculateTotal($t_trnkb, $swdklljPokKeys);
        $bea_swdkllj_den = $this->calculateTotal($t_trnkb, $swdklljDenKeys);
        $bea_swdkllj = $bea_swdkllj_pok + $bea_swdkllj_den;

        $bea_adm_stnk = (float) $t_trnkb->bea_adm_stnk;

        $bea_plat_nomor = (float) $t_trnkb->bea_plat_nomor;

        // Final totals
        $total_pokok = $bea_bbn_pok + $bea_opsen_bbn_pok + $bea_pkb_pok + $bea_opsen_pkb_pok + $bea_swdkllj_pok + $t_trnkb->bea_adm_stnk + $t_trnkb->bea_plat_nomor;
        $total_denda = $bea_bbn_den + $bea_opsen_bbn_den + $bea_pkb_den + $bea_opsen_pkb_den + $bea_swdkllj_den;
        $total_seluruh = $bea_bbn + $bea_opsen_bbn + $bea_pkb + $bea_opsen_pkb + $bea_swdkllj + $bea_adm_stnk + $bea_plat_nomor;

        return [
            'pokok_bbnkb' => $bea_bbn_pok,
            'denda_bbnkb' => $bea_bbn_den,
            'total_bbnkb' => $bea_bbn,

            'pokok_pkb' => $bea_pkb_pok,
            'denda_pkb' => $bea_pkb_den,
            'total_pkb' => $bea_pkb,

            'pokok_swdkllj' => $bea_swdkllj_pok,
            'denda_swdkllj' => $bea_swdkllj_den,
            'total_swdkllj' => $bea_swdkllj,

            'pokok_opsen_bbnkb' => $bea_opsen_bbn_pok,
            'denda_opsen_bbnkb' => $bea_opsen_bbn_den,
            'total_opsen_bbnkb' => $bea_opsen_bbn,

            'pokok_opsen_pkb' => $bea_opsen_pkb_pok,
            'denda_opsen_pkb' => $bea_opsen_pkb_den,
            'total_opsen_pkb' => $bea_opsen_pkb,

            'bea_adm_stnk' => $bea_adm_stnk,
            'bea_plat_nomor' => $bea_plat_nomor,

            'total_pokok' => $total_pokok,
            'total_denda' => $total_denda,
            'total_seluruh' => $total_seluruh,
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
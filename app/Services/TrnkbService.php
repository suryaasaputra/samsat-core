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

    public function getLaporanTransaksiHarian($tanggal, $kd_lokasi, $kd_wilayah, $jenis)
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
            ->where(DB::raw('T.kd_wilayah'), 'like', "%$kd_wilayah%");

        if ($jenis === 'nontunai') {
            $query->whereNotNull(DB::raw('t_post_qris.nama'));
        } elseif ($jenis === 'tunai') {
            $query->whereNull(DB::raw('t_post_qris.nama'));
        }

        $query->orderByRaw("CAST(split_part(T.no_noticepp, ' ', 2) AS INTEGER) ASC");

        return $query->get();

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
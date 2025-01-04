<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
        html,
        body {
            font-size: 11px;
            position: relative;
            font-family: droidsans;
        }

        td {
            padding: 0;
        }

        table,
        tr,
        td,
        div {
            border-collapse: collapse;
        }

        .value-pemilik {
            position: absolute;
            font-size: 12px;
            height: 3.2mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
            width: 75mm;
        }

        .tnkb {
            top: 8.5mm;
            left: 29mm;
            font-weight: bold;
        }

        .nik {
            top: 12.7mm;
            left: 29mm;
            font-weight: bold;
        }

        .nama {
            top: 17mm;
            left: 29mm;
            font-weight: bold;
        }

        .alamat1 {
            top: 21.5mm;
            left: 29mm;
        }

        .alamat2 {
            top: 25.3mm;
            left: 29mm;
        }

        .value-kb {
            position: absolute;
            font-size: 10px;
            height: 3.2mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }

        .merk {
            top: 29.5mm;
            left: 30mm;
            width: 75mm;
        }

        .model {
            top: 33.5mm;
            left: 30mm;
            width: 32mm;
        }

        .warna-plat {
            top: 33.5mm;
            left: 81.5mm;
            width: 26mm;
        }

        .tahun-buat {
            top: 37.5mm;
            left: 30mm;
            width: 32mm;
        }

        .bahan-bakar {
            top: 37.5mm;
            left: 81.5mm;
            width: 26mm;
        }

        .tahun-rakit {
            top: 41.9mm;
            left: 30mm;
            width: 32mm;
        }

        .kode-lokasi {
            top: 41.9mm;
            left: 81.5mm;
            width: 26mm;
        }

        .isi-silinder {
            top: 46mm;
            left: 30mm;
            width: 32mm;
        }

        .jumlah-sumbu {
            top: 46mm;
            left: 81.5mm;
            width: 26mm;
        }

        .warna-kb {
            top: 50mm;
            left: 30mm;
            width: 32mm;
        }

        .no-chasis {
            top: 54.3mm;
            left: 30mm;
            width: 32mm;
        }

        .no-mesin {
            top: 58.5mm;
            left: 30mm;
            width: 32mm;
        }

        .no-bpkb {
            top: 62.8mm;
            left: 30mm;
            width: 32mm;
        }

        .tg-akhir-pkb {
            position: absolute;
            top: 67.8mm;
            left: 30.5mm;
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
            height: 3.2mm;
            width: 33mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }

        .nama-lokasi {
            position: absolute;
            top: 8mm;
            left: 167mm;
            font-size: 10px;
        }

        .tg-akhir-jr {
            top: 51mm;
            left: 62mm;
            font-weight: normal;
            width: 40mm;
        }

        .time-stamp {
            top: 56mm;
            left: 87mm;
            font-weight: normal;
            width: 40mm;
        }

        .value-no {
            position: absolute;
            font-size: 12px;
            height: 3.2mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
            width: 33mm;
        }

        .no-skum {
            top: 8.7mm;
            left: 126mm;
        }

        .no-kohir {
            top: 13mm;
            left: 126mm;
        }

        .no-urut {
            top: 17mm;
            left: 126mm;
        }

        .value-pokok-denda {
            position: absolute;
            font-size: 10px;
            height: 3.2mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
            width: 22mm;
            text-align: right;
        }

        .value-total {
            position: absolute;
            font-size: 10px;
            height: 3.2mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
            width: 30mm;
            text-align: right;
        }

        .bbn-pok {
            top: 26mm;
            left: 108mm;
        }

        .opsen-bbn-pok {
            top: 29.5mm;
            left: 108mm;
        }

        .pkb-pok {
            top: 33mm;
            left: 108mm;
        }

        .opsen-pkb-pok {
            top: 36.5mm;
            left: 108mm;
        }

        .swd-pok {
            top: 40mm;
            left: 108mm;
        }

        .stnk-pok {
            top: 43.5mm;
            left: 108mm;
        }

        .tnkb-pok {
            top: 47mm;
            left: 108mm;
        }

        .total-pok {
            top: 50.3mm;
            left: 108mm;
            font-weight: bold;
        }

        .bbn-denda {
            top: 26mm;
            left: 134mm;
        }

        .opsen-bbn-denda {
            top: 29.5mm;
            left: 134mm;
        }

        .pkb-denda {
            top: 33mm;
            left: 134mm;
        }

        .opsen-pkb-denda {
            top: 36.5mm;
            left: 134mm;
        }

        .swd-denda {
            top: 40mm;
            left: 134mm;
        }

        .stnk-denda {
            top: 43.5mm;
            left: 134mm;
        }

        .tnkb-denda {
            top: 47mm;
            left: 134mm;
        }

        .total-denda {
            top: 50.3mm;
            left: 134mm;
            font-weight: bold;
        }

        .bbn-total {
            top: 26mm;
            left: 160mm;
        }

        .opsen-bbn-total {
            top: 29.5mm;
            left: 160mm;
        }

        .pkb-total {
            top: 33mm;
            left: 160mm;
        }

        .opsen-pkb-total {
            top: 36.5mm;
            left: 160mm;
        }

        .swd-total {
            top: 40mm;
            left: 160mm;
        }

        .stnk-total {
            top: 43.5mm;
            left: 160mm;
        }

        .tnkb-total {
            top: 47mm;
            left: 160mm;
        }

        .total-penetapan {
            top: 50.3mm;
            left: 160mm;
            font-weight: bold;
        }

        .tg-penetapan {
            position: absolute;
            top: 57.8mm;
            left: 110mm;
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
            height: 3.2mm;
            width: 25mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }

        .petugas-penetapan {
            position: absolute;
            top: 57.8mm;
            left: 135mm;
            font-size: 12px;
            height: 3.2mm;
            width: 42mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
        }
    </style>
</head>

<body>

    <div class="value-pemilik tnkb">{{ $no_polisi }}</div>
    <div class="value-pemilik nik">{{ $nik_pemilik }}</div>
    <div class="value-pemilik nama">{{ $nm_pemilik }}</div>
    <div class="value-pemilik alamat1">{{ substr($al_pemilik, 0, 35) }}</div>
    <div class="value-pemilik alamat2">{{ substr($al_pemilik, 35, 80) }}</div>

    <div class="value-kb merk"> {{ $nm_merek_kb }} / {{ $nm_model_kb }}</div>
    <div class="value-kb model"> {{ $nm_jenis_kb }}</div>
    <div class="value-kb warna-plat"> {{ $nm_plat }}</div>
    <div class="value-kb tahun-buat"> {{ $th_buatan }}</div>
    <div class="value-kb bahan-bakar"> {{ $nm_bbm }}</div>
    <div class="value-kb tahun-rakit"> {{ $th_rakitan }}</div>
    <div class="value-kb kode-lokasi"> {{ $kd_lokasi }}</div>
    <div class="value-kb isi-silinder"> {{ $jumlah_cc }}</div>
    <div class="value-kb jumlah-sumbu"> {{ $jumlah_sumbu }}</div>
    <div class="value-kb warna-kb"> {{ $warna_kb }}</div>
    <div class="value-kb no-chasis"> {{ $no_chasis }}</div>
    <div class="value-kb no-mesin"> {{ $no_mesin }}</div>
    <div class="value-kb no-bpkb"> {{ $no_bpkb }}</div>

    <div class="tg-akhir-pkb">
        {{ \Carbon\Carbon::parse($tg_akhir_pkb)->format('d-m-Y') }}
    </div>

    <div class="nama-lokasi">
        ( {{ $kd_lokasi }} ) {{ $nm_lokasi }}
    </div>

    <div class="value-kb tg-akhir-jr">
        SWDKLLJ S/D: {{ \Carbon\Carbon::parse($tg_akhir_jr)->format('d-m-Y') }}
    </div>
    <div class="value-kb time-stamp">
        {{ $jam_skrg }}
    </div>

    <div class="value-no no-skum">{{ $no_skum }}</div>
    <div class="value-no no-kohir">{{ $no_kohir }}</div>
    <div class="value-no no-urut">{{ $no_urut }}</div>

    <div class="value-pokok-denda bbn-pok"> {{ number_format($bea_bbn_pok) }}</div>
    <div class="value-pokok-denda opsen-bbn-pok"> {{ number_format($bea_opsen_bbn_pok) }}</div>
    <div class="value-pokok-denda pkb-pok"> {{ number_format($bea_pkb_pok) }}</div>
    <div class="value-pokok-denda opsen-pkb-pok"> {{ number_format($bea_opsen_pkb_pok) }}</div>
    <div class="value-pokok-denda swd-pok"> {{ number_format($bea_swdkllj_pok) }}</div>
    <div class="value-pokok-denda stnk-pok"> {{ number_format($bea_adm_stnk) }}</div>
    <div class="value-pokok-denda tnkb-pok"> {{ number_format($bea_plat_nomor) }}</div>
    <div class="value-pokok-denda total-pok"> {{ number_format($total_pokok) }}</div>

    <div class="value-pokok-denda bbn-denda"> {{ number_format($bea_bbn_den) }}</div>
    <div class="value-pokok-denda opsen-bbn-denda"> {{ number_format($bea_opsen_bbn_den) }}</div>
    <div class="value-pokok-denda pkb-denda"> {{ number_format($bea_pkb_den) }}</div>
    <div class="value-pokok-denda opsen-pkb-denda"> {{ number_format($bea_opsen_pkb_den) }}</div>
    <div class="value-pokok-denda swd-denda"> {{ number_format($bea_swdkllj_den) }}</div>
    <div class="value-pokok-denda stnk-denda"> </div>
    <div class="value-pokok-denda tnkb-denda"> </div>
    <div class="value-pokok-denda total-denda"> {{ number_format($total_denda) }}</div>

    <div class="value-total bbn-total"> {{ number_format($bea_bbn) }}</div>
    <div class="value-total opsen-bbn-total"> {{ number_format($bea_opsen_bbn) }}</div>
    <div class="value-total pkb-total"> {{ number_format($bea_pkb) }}</div>
    <div class="value-total opsen-pkb-total"> {{ number_format($bea_opsen_pkb) }}</div>
    <div class="value-total swd-total"> {{ number_format($bea_swdkllj) }}</div>
    <div class="value-total stnk-total"> {{ number_format($bea_adm_stnk) }}</div>
    <div class="value-total tnkb-total"> {{ number_format($bea_plat_nomor) }}</div>
    <div class="value-total total-penetapan"> {{ number_format($total_penetapan) }}</div>

    <div class="tg-penetapan">{{ \Carbon\Carbon::parse($tg_tetap)->format('d-m-Y') }}</div>
    <div class="petugas-penetapan">{{ $user_id_tetap }}</div>
    <div class="petugas-korektor">{{ $user_id_korektor ?? '-' }}</div>

    <div class="ttd-dirlantas">
        <img class="ttd" src="{{ asset('images/TTD-DIRLANTAS.jpg') }}" />
    </div>

    <div class="nama-dirlantas">
        <p style="text-align:center;text-decoration:underline">
            {{ $ttd_dirlantas->text1 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_dirlantas->text2 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_dirlantas->text3 }}
        </p>
    </div>

    <div class="ttd-kaban-bpkpd">
        <img class="ttd" src="{{ asset('images/TTD-KADISPENDA.jpg') }}" />
    </div>
    <div class="nama-kaban-bpkpd">
        <p style="text-align:center;text-decoration:underline">
            {{ $ttd_kaban->text1 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_kaban->text2 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_kaban->text3 }}
        </p>
    </div>

    <div class="ttd-kacab-jr">
        <img class="ttd" src="{{ asset('images/TTD-KACABJR.jpg') }}" />
    </div>
    <div class="nama-kacab-jr">
        <p style="text-align:center;text-decoration:underline">
            {{ $ttd_kacabjr->text1 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_kacabjr->text2 }}
        </p>
        <p style="text-align:center ">
            {{ $ttd_kacabjr->text3 }}
        </p>
    </div>

    <div class="cap-tera">
        {{ $cap_tera }}
    </div>

</body>


</html>

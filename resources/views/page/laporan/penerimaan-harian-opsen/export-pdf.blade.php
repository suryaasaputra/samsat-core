<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penerimaan Harian Opsen {{ $wilayah->nm_wilayah }} Tanggal
        {{ $tanggal }}
    </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;


        }

        th,
        td {
            padding: 2px;
            text-align: left;
            font-size: 10px;
            /* Adjust font size to make content fit */
            border: 1px solid #000;
        }

        th {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <center>
        <div style="text-align: center; margin-bottom:10px">
            <h3 style="text-align: center;">
                Daftar Penerimaan Harian Opsen {{ $wilayah->nm_wilayah }} Tanggal
                {{ $tanggal }}
            </h3>
        </div>
    </center>
    <table">
        <thead>
            <tr>
                <th style="width:50px;"><strong>No</strong></th>
                <th><strong>NO. SKPD</strong></th>
                <th><strong>NO. POLISI</strong></th>
                <th><strong>Kd Lokasi Bayar</strong></th>
                <th><strong>TGL. BAYAR</strong></th>
                <th><strong>TGL. AWAL PKB</strong></th>
                <th><strong>TGL. AKHIR PKB</strong></th>
                <th><strong>Kode Mohon</strong></th>
                <th><strong>BBNKB Pokok</strong></th>
                <th><strong>BBNKB Denda</strong></th>
                <th><strong>PKB Pokok</strong></th>
                <th><strong>PKB Denda</strong></th>
                <th><strong>SWDKLLJ Pokok</strong></th>
                <th><strong>SWDKLLJ Denda</strong></th>
                <th><strong>Opsen BBNKB Pokok</strong></th>
                <th><strong>Opsen BBNKB Denda</strong></th>
                <th><strong>Opsen PKB Pokok</strong></th>
                <th><strong>Opsen PKB Denda</strong></th>
                <th><strong>Kasir</strong></th>
                <th><strong>Metode Bayar</strong></th>

            </tr>
        </thead>
        <tbody>
            @foreach ($dataTransaksi as $index => $row)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $row->no_noticepp }}</td>
                    <td>{{ $row->no_polisi }}</td>
                    <td>{{ $row->kd_lokasi }}</td>
                    <td>{{ $row->tg_bayar }}</td>
                    <td>{{ $row->tg_awal_pkb }}</td>
                    <td>{{ $row->tg_akhir_pkb }}</td>
                    <td>{{ $row->kd_mohon }}</td>
                    <td>{{ number_format($row->bbn_pokok, 0) }}</td>
                    <td>{{ number_format($row->bbn_denda, 0) }}</td>
                    <td>{{ number_format($row->pkb_pokok, 0) }}</td>
                    <td>{{ number_format($row->pkb_denda, 0) }}</td>
                    <td>{{ number_format($row->swd_pokok, 0) }}</td>
                    <td>{{ number_format($row->swd_denda, 0) }}</td>

                    <td>{{ number_format($row->opsen_bbn_pokok, 0) }}</td>
                    <td>{{ number_format($row->opsen_bbn_denda, 0) }}</td>

                    <td>{{ number_format($row->opsen_pkb_pokok, 0) }}</td>
                    <td>{{ number_format($row->opsen_pkb_denda, 0) }}</td>
                    <td>{{ $row->user_id_bayar }}</td>
                    <td>{{ $row->metode_bayar }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="8" rowspan="2" style="text-align: center"><strong>JUMLAH TOTAL</strong>
                </td>
                <td><strong>{{ number_format($sumJumlah['bbn_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['bbn_denda'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['pkb_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['pkb_denda'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['swd_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['swd_denda'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['opsen_bbn_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['opsen_bbn_denda'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['opsen_pkb_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($sumJumlah['opsen_pkb_denda'], 0) }} </strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="12" style="text-align: center">
                    <strong>{{ number_format(
                        $sumJumlah['bbn_pokok'] +
                            $sumJumlah['bbn_denda'] +
                            $sumJumlah['pkb_pokok'] +
                            $sumJumlah['pkb_denda'] +
                            $sumJumlah['swd_pokok'] +
                            $sumJumlah['swd_denda'] +
                            $sumJumlah['opsen_bbn_pokok'] +
                            $sumJumlah['opsen_bbn_denda'] +
                            $sumJumlah['opsen_pkb_pokok'] +
                            $sumJumlah['opsen_pkb_denda'],
                        0,
                    ) }}
                    </strong>
                </td>
            </tr>
        </tbody>
        </table>
</body>

</html>

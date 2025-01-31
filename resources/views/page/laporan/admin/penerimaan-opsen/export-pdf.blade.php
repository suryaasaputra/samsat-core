<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> REKAPITULASI PENERIMAAN OPSEN {{ $nm_wilayah }} TGL:
        {{ $tg_awal }} S/D {{ $tg_akhir }}
    </title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px 2px 2px 2px;
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
    <h3>
        REKAPITULASI PENERIMAAN OPSEN {{ $nm_wilayah }} <br>
        TGL: {{ $tg_awal }} S/D {{ $tg_akhir }}<br>
        <hr width="100%" size="2">
    </h3>

    <table>
        <thead>
            <tr>
                <th style="width:auto;"><strong>No</strong></th>
                <th><strong>LOKASI </strong></th>
                <th><strong>POKOK OPSEN BBNKB</strong></th>
                <th><strong>DENDA OPSEN BBNKB</strong></th>
                <th><strong>POKOK OPSEN PKB</strong></th>
                <th><strong>DENDA OPSEN PKB</strong></th>
                <th><strong>Total</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataRekapOpsen as $index => $row)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $row->nm_lokasi }}</td>
                    <td style="text-align: right">{{ number_format($row->opsen_bbn_pokok, 0) }}</td>
                    <td style="text-align: right">{{ number_format($row->opsen_bbn_denda, 0) }}</td>
                    <td style="text-align: right">{{ number_format($row->opsen_pkb_pokok, 0) }}</td>
                    <td style="text-align: right">{{ number_format($row->opsen_pkb_denda, 0) }}</td>
                    <td style="text-align: right">
                        {{ number_format($row->opsen_bbn_pokok + $row->opsen_bbn_denda + $row->opsen_pkb_pokok + $row->opsen_pkb_denda, 0) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2" style="text-align: center"><strong>TOTAL</strong>
                </th>
                <th style="text-align: right"><strong>{{ number_format($dataTotals['total_opsen_bbn_pokok'], 0) }}
                    </strong></th>
                <th style="text-align: right"><strong>{{ number_format($dataTotals['total_opsen_bbn_denda'], 0) }}
                    </strong></th>
                <th style="text-align: right"><strong>{{ number_format($dataTotals['total_opsen_pkb_pokok'], 0) }}
                    </strong></th>
                <th style="text-align: right"><strong>{{ number_format($dataTotals['total_opsen_pkb_denda'], 0) }}
                    </strong></th>
                <th style="text-align: right">
                    <strong>{{ number_format($dataTotals['total_opsen_bbn_pokok'] + $dataTotals['total_opsen_bbn_denda'] + $dataTotals['total_opsen_pkb_pokok'] + $dataTotals['total_opsen_pkb_denda'], 0) }}
                    </strong>
                </th>

            </tr>
        </tbody>
    </table>
</body>

</html>

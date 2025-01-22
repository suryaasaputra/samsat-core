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
    <h3>
        REKAPITULASI PENERIMAAN OPSEN {{ $nm_wilayah }} TGL: {{ $tg_awal }} S/D {{ $tg_akhir }}<br>
        <hr width="100%" size="2">
    </h3>

    <table>
        <thead>
            <tr>
                <th style="width:50px;"><strong>No</strong></th>
                <th><strong>LOKASI </strong></th>
                <th><strong>POKOK OPSEN BBNKB</strong></th>
                <th><strong>DENDA OPSEN BBNKB</strong></th>
                <th><strong>POKOK OPSEN PKB</strong></th>
                <th><strong>DENDA OPSEN PKB</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataRekapOpsen as $index => $row)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $row->nm_lokasi }}</td>
                    <td>{{ number_format($row->opsen_bbn_pokok, 0) }}</td>
                    <td>{{ number_format($row->opsen_bbn_denda, 0) }}</td>
                    <td>{{ number_format($row->opsen_pkb_pokok, 0) }}</td>
                    <td>{{ number_format($row->opsen_pkb_denda, 0) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" rowspan="2" style="text-align: center"><strong>JUMLAH TOTAL</strong>
                </td>
                <td><strong>{{ number_format($dataTotals['total_opsen_bbn_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($dataTotals['total_opsen_bbn_denda'], 0) }} </strong></td>
                <td><strong>{{ number_format($dataTotals['total_opsen_pkb_pokok'], 0) }} </strong></td>
                <td><strong>{{ number_format($dataTotals['total_opsen_pkb_denda'], 0) }} </strong></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">
                    <strong>{{ number_format(
                        $dataTotals['total_opsen_bbn_pokok'] +
                            $dataTotals['total_opsen_bbn_denda'] +
                            $dataTotals['total_opsen_pkb_pokok'] +
                            $dataTotals['total_opsen_pkb_denda'] +
                            0,
                    ) }}
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>

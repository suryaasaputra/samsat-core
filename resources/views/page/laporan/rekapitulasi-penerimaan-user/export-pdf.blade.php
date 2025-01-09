<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Penerimaan Tanggal {{ $tanggal }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
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
                {{ $lokasi->rpthdr1 ?? '' }} <br>
                {{ $lokasi->rpthdr2 ?? '' }} <br>
                {{ $lokasi->rpthdr3 ?? '' }}
            </h3>
        </div>
    </center>

    <h3>
        REKAPITULASI PENERIMAAN PER USER TGL: {{ $tanggal }} <br>
        PADA {{ !empty($lokasi->rpthdr3) ? $lokasi->rpthdr3 : $lokasi->rpthdr2 }}

        <hr width="100%" size="2">
    </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Gerai / Unit </th>
                <th style="text-align: right">BBNKB & PKB</th>
                <th style="text-align: right">Opsen BBNKB & PKB</th>
                <th style="text-align: right">SWDKLLJ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_rekap as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user ?? 'Unknown' }}</td> <!-- Replace with actual user key -->
                    <td>{{ $item->nm_lokasi ?? 'N/A' }}</td> <!-- Replace with actual gerai/unit key -->
                    <td style="text-align: right">
                        {{ number_format($dataTotal['totals_per_item'][$index]['total_bbn'] + $dataTotal['totals_per_item'][$index]['total_pkb'], 0, ',', '.') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($dataTotal['totals_per_item'][$index]['total_opsen_bbnkb'] + $dataTotal['totals_per_item'][$index]['total_opsen_pkb'], 0, ',', '.') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($dataTotal['totals_per_item'][$index]['total_swd'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: center">
                    Total
                </td>
                <td style="text-align: right">
                    {{ number_format($dataTotal['grand_totals']['total_bbn'] + $dataTotal['grand_totals']['total_pkb'], 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($dataTotal['grand_totals']['total_opsen_bbnkb'] + $dataTotal['grand_totals']['total_opsen_pkb'], 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($dataTotal['grand_totals']['total_swd'], 0, ',', '.') }}
                </td>
            </tr>
            <tr style="font-weight: bold">
                <td colspan="3" style="text-align: center">
                    Total Seluruh
                </td>
                <td colspan="3" style="text-align: center">
                    {{ number_format(
                        $dataTotal['grand_totals']['total_bbn'] +
                            $dataTotal['grand_totals']['total_pkb'] +
                            $dataTotal['grand_totals']['total_opsen_bbnkb'] +
                            $dataTotal['grand_totals']['total_opsen_pkb'] +
                            $dataTotal['grand_totals']['total_swd'],
                        0,
                        ',',
                        '.',
                    ) }}
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>

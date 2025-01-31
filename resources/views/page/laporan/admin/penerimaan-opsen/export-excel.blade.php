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
                <td style="text-align: right">{{ $row->opsen_bbn_pokok }}</td>
                <td style="text-align: right">{{ $row->opsen_bbn_denda }}</td>
                <td style="text-align: right">{{ $row->opsen_pkb_pokok }}</td>
                <td style="text-align: right">{{ $row->opsen_pkb_denda }}</td>
                <td style="text-align: right">
                    {{ $row->opsen_bbn_pokok + $row->opsen_bbn_denda + $row->opsen_pkb_pokok + $row->opsen_pkb_denda }}
                </td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2" style="text-align: center"><strong>TOTAL</strong>
            </th>
            <th style="text-align: right"><strong>{{ $dataTotals['total_opsen_bbn_pokok'] }}
                </strong></th>
            <th style="text-align: right"><strong>{{ $dataTotals['total_opsen_bbn_denda'] }}
                </strong></th>
            <th style="text-align: right"><strong>{{ $dataTotals['total_opsen_pkb_pokok'] }}
                </strong></th>
            <th style="text-align: right"><strong>{{ $dataTotals['total_opsen_pkb_denda'] }}
                </strong></th>
            <th style="text-align: right">
                <strong>{{ $dataTotals['total_opsen_bbn_pokok'] + $dataTotals['total_opsen_bbn_denda'] + $dataTotals['total_opsen_pkb_pokok'] + $dataTotals['total_opsen_pkb_denda'] }}
                </strong>
            </th>

        </tr>
    </tbody>
</table>

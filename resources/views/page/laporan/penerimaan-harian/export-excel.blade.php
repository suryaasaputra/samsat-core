<table>
    <thead>
        <tr>
            <th><strong>No</strong></th>
            <th><strong>NO. SKPD</strong></th>
            <th><strong>NO. POLISI</strong></th>
            <th><strong>Kd Wilayah</strong></th>
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
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->no_noticepp }}</td>
                <td>{{ $row->no_polisi }}</td>
                <td>{{ $row->kd_wilayah }}</td>
                <td>{{ $row->tg_bayar }}</td>
                <td>{{ $row->tg_awal_pkb }}</td>
                <td>{{ $row->tg_akhir_pkb }}</td>
                <td>{{ $row->kd_mohon }}</td>
                <td>{{ $row->bbn_pokok }}</td>
                <td>{{ $row->bbn_denda }}</td>
                <td>{{ $row->pkb_pokok }}</td>
                <td>{{ $row->pkb_denda }}</td>
                <td>{{ $row->swd_pokok }}</td>
                <td>{{ $row->swd_denda }}</td>

                <td>{{ $row->opsen_bbn_pokok }}</td>
                <td>{{ $row->opsen_bbn_denda }}</td>

                <td>{{ $row->opsen_pkb_pokok }}</td>
                <td>{{ $row->opsen_pkb_denda }}</td>
                <td>{{ $row->user_id_bayar }}</td>
                <td>{{ $row->metode_bayar }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8" rowspan="2" style="text-align: center"><strong>JUMLAH TOTAL</strong></td>
            <td><strong>{{ $sumJumlah['bbn_pokok'] }} </strong></td>
            <td><strong>{{ $sumJumlah['bbn_denda'] }} </strong></td>
            <td><strong>{{ $sumJumlah['pkb_pokok'] }} </strong></td>
            <td><strong>{{ $sumJumlah['pkb_denda'] }} </strong></td>
            <td><strong>{{ $sumJumlah['swd_pokok'] }} </strong></td>
            <td><strong>{{ $sumJumlah['swd_denda'] }} </strong></td>
            <td><strong>{{ $sumJumlah['opsen_bbn_pokok'] }} </strong></td>
            <td><strong>{{ $sumJumlah['opsen_bbn_denda'] }} </strong></td>
            <td><strong>{{ $sumJumlah['opsen_pkb_pokok'] }} </strong></td>
            <td><strong>{{ $sumJumlah['opsen_pkb_denda'] }} </strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center">
                <strong>{{ $sumJumlah['bbn_pokok'] +
                    $sumJumlah['bbn_denda'] +
                    $sumJumlah['pkb_pokok'] +
                    $sumJumlah['pkb_denda'] +
                    $sumJumlah['swd_pokok'] +
                    $sumJumlah['swd_denda'] +
                    $sumJumlah['opsen_bbn_pokok'] +
                    $sumJumlah['opsen_bbn_denda'] +
                    $sumJumlah['opsen_pkb_pokok'] +
                    $sumJumlah['opsen_pkb_denda'] }}
                </strong>
            </td>
        </tr>
    </tbody>
</table>

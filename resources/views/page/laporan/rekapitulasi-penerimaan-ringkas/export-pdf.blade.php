<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Penerimaan Tanggal {{ $tanggal }}</title>
    <style>
        table,
        tr,
        th,
        td {
            /* border: 1px solid #000; */
            border-collapse: collapse;
            /* text-align: center; */
            padding-right: 5px;
        }

        td,
        tr {
            padding: 4px 8px;
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
        REKAPITULASI PENERIMAAN TGL: {{ $tanggal }} <br>
        PADA {{ !empty($lokasi->rpthdr3) ? $lokasi->rpthdr3 : $lokasi->rpthdr2 }}

        <hr width="100%" size="2">
    </h3>

    <table>
        <tbody>
            <tr>
                <td colspan="5">
                    <strong>A. BBNKB & PKB</strong>
                </td>
            </tr>
            <tr>
                <td width="20px"></td>
                <td width="20px">1.</td>
                <td width="400px">BBNKB</td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    {{ number_format($dataTotal['total_bbn'], 0) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2.</td>
                <td>PKB</td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    {{ number_format($dataTotal['total_pkb'], 0) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL BBNKB & PKB *** (Rek.
                        101431703)</strong></td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    <strong>
                        {{ number_format($dataTotal['total_bbn'] + $dataTotal['total_pkb'], 0) }}</strong>
                </td>
            </tr>
            <tr height="15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="5">
                    <strong>B. Opsen BBNKB & Opsen PKB</strong>
                </td>
            </tr>
            @foreach ($dataPenerimaanOpsen as $row)
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $row->kd_wilayah }} - {{ $row->nm_wilayah }}
                        (Rek.{{ $dataRekeningWilayah[$row->kd_wilayah] }})
                    </td>
                    <td>Rp.</td>
                    <td style="text-align: right; padding-right:10px;">
                        {{ number_format($row->opsen_bbn_pokok + $row->opsen_bbn_denda + $row->opsen_pkb_pokok + $row->opsen_pkb_denda, 0) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL Opsen BBNKB & Opsen PKB ***</strong></td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    <strong>{{ number_format($dataTotal['total_opsen_bbnkb'] + $dataTotal['total_opsen_pkb'], 0) }}</strong>
                </td>
            </tr>
            <tr height="15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">
                    <strong>C. SWDKLLJ</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td width="20px">1.</td>
                <td>POKOK SWDKLLJ</td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    {{ number_format($data_rekap->swd_pok + $data_rekap->tgk_swd_pok, 0) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2.</td>
                <td>DENDA SWDKLLJ</td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    {{ number_format($data_rekap->swd_den + $data_rekap->tgk_swd_den, 0) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL SWDKLLJ ***</strong></td>
                <td>Rp.</td>
                <td style="text-align: right; padding-right:10px;">
                    <strong>{{ number_format($dataTotal['total_swd'], 0) }}</strong>
                </td>
            </tr>
            <tr height="15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr height="15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @if (\Auth::user()->kd_wilayah != '001' && \Auth::user()->kd_wilayah != '003' && \Auth::user()->kd_wilayah != '008')
                <tr>
                    <td colspan="5">
                        <strong>D. PNBP</strong>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td width="20px">1.</td>
                    <td>ADM. STNK</td>
                    <td>Rp.</td>
                    <td style="text-align: right; padding-right:10px;">
                        {{ number_format($data_rekap->adm_stnk, 0) }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.</td>
                    <td>ADM TNKB</td>
                    <td>Rp.</td>
                    <td style="text-align: right; padding-right:10px;">
                        {{ number_format($data_rekap->plat_nomor, 0) }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>*** TOTAL PNBP ***</strong></td>
                    <td>Rp.</td>
                    <td style="text-align: right; padding-right:10px;">
                        <strong>{{ number_format($dataTotal['total_pnbp'], 0) }}</strong>
                    </td>
                </tr>
                <tr height="15px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>TOTAL SELURUH</strong></td>
                    <td><strong>Rp.</strong></td>
                    <td style="text-align: right; padding-right:10px;">
                        <strong>{{ number_format($dataTotal['total_seluruh'] + $dataTotal['total_pnbp'], 0) }}</strong>
                    </td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>TOTAL SELURUH</strong></td>
                    <td><strong>Rp.</strong></td>
                    <td style="text-align: right; padding-right:10px;">
                        <strong>{{ number_format($dataTotal['total_seluruh'], 0) }}</strong>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>

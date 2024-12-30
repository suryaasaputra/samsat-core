<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Penerimaan Tanggal <?=$tanggal?></title>
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
                <?=$t_lokasi->rpthdr1?> <br>
                <?=$t_lokasi->rpthdr2?> <br>
                <?=$t_lokasi->rpthdr3?>
            </h3>
        </div>
    </center>

    <h3>REKAPITULASI PENERIMAAN TGL : <?=$tanggal?> <br>
        PADA <?=$t_lokasi->rpthdr3?>
        <hr width="100%" size="2">
    </h3>

    <table>
        <tbody>
            <tr>
                <td colspan="6">
                    <strong>A. PKB</strong>
                </td>
            </tr>

            <tr>
                <td width="20px"></td>
                <td width="20px">1.</td>
                <td width="400px">POKOK PKB</td>
                <td>Rp.</td>
                <td style="text-align: right;">
                    <?=number_format($data_rekap['pkb_pok'], 0)?></td>
                <td width="100px">
                    ( <?=number_format($data_rekap['wp_pkb_pok'], 0)?> )
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2.</td>
                <td>DENDA PKB</td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($data_rekap['pkb_den'], 0)?></td>
                <td>( <?=number_format($data_rekap['wp_pkb_den'], 0)?> )</td>
            </tr>
            <tr>
                <td></td>
                <td>3.</td>
                <td>TGK. POKOK PKB</td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($data_rekap['tgk_pkb_pok'], 0)?>
                </td>
                <td>( <?=number_format($data_rekap['wp_tgk_pkb_pok'], 0)?> )
                </td>
            </tr>
            <tr>
                <td></td>
                <td>4.</td>
                <td>TGK. DENDA PKB</td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($data_rekap['tgk_pkb_den'], 0)?>
                </td>
                <td>( <?=number_format($data_rekap['wp_tgk_pkb_den'], 0)?> )</td>
            </tr>
            <tr cellpadding="0" cellspacing="0" class="p-0 m-0" height="5px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">------------------</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL PKB ***</strong></td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($total_pkb, 0)?></td>
            </tr>

            <tr height="15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="6">
                    <strong>B. Opsen PKB</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>1.</td>
                <td>Opsen PKB Pokok</td>
                <td>Rp.</td>
                <td style="text-align: right;">
                    <?=number_format($data_rekap['opsen_pkb_pok'] + $data_rekap['tgk_opsen_pkb_pok'], 0)?></td>
                <td width=" 50px"> (
                    <?=number_format($data_rekap['wp_opsen_pkb_pok'] + $data_rekap['wp_tgk_opsen_pkb_pok'], 0)?> )
                </td>
            </tr>

            <?php $i = 0;foreach ($data_penerimaan_opsen as $row) {?>
            <?php $i++?>
            <tr>
                <td></td>
                <td></td>
                <td><?=$row->kd_wilayah?> - <?=$row->nm_wilayah?></td>
                <td>Rp.</td>
                <td style="text-align: right;padding-right:10px"><?=number_format($row->opsen_pkb_pokok, 0)?>
                </td>
            </tr>
            <?php }?>

            <tr height=" 15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td>2.</td>
                <td>Opsen PKB Denda</td>
                <td>Rp.</td>
                <td style="text-align: right">
                    <?=number_format($data_rekap['opsen_pkb_den'] + $data_rekap['tgk_opsen_pkb_den'], 0)?></td>
                <td>( <?=number_format($data_rekap['wp_opsen_pkb_den'] + $data_rekap['wp_tgk_opsen_pkb_den'], 0)?> )
                </td>
            </tr>

            <?php $i = 0;foreach ($data_penerimaan_opsen as $row) {?>
            <?php $i++?>
            <tr>
                <td></td>
                <td></td>
                <td><?=$row->kd_wilayah?> - <?=$row->nm_wilayah?></td>
                <td>Rp.</td>
                <td style=" text-align: right;padding-right:10px"><?=number_format($row->opsen_pkb_denda, 0)?>
                </td>
            </tr>
            <?php }?>

            <tr cellpadding=" 0" cellspacing="0" class="p-0 m-0" height="5px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">------------------</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL Opsen PKB ***</strong></td>
                <td>Rp.</td>
                <td style=" text-align: right;"><?=number_format($total_opsen_pkb, 0)?></td>
            </tr>
            <tr height=" 15px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6">
                    <strong>C. SWDKLLJ</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>1.</td>
                <td>POKOK SWDKLJJ</td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($data_rekap['swd_pok'] + $data_rekap['tgk_swd_pok'], 0)?>
                </td>
                <td width="50px">( <?=number_format($data_rekap['wp_swd_pok'] + $data_rekap['wp_tgk_swd_pok'], 0)?> )
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2.</td>
                <td>DENDA SWDKLLJ</td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($data_rekap['swd_den'] + $data_rekap['tgk_swd_den'], 0)?>
                </td>
                <td>(
                    <?=number_format($data_rekap['wp_swd_den'] + $data_rekap['wp_tgk_swd_den'], 0)?>
                    )</td>
            </tr>
            <tr cellpadding="0" cellspacing="0" height="5px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">------------------</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>*** TOTAL SWDKLLJ ***</strong></td>
                <td>Rp.</td>
                <td style="text-align: right"><?=number_format($total_swd, 0)?></td>
            </tr>
            <tr height="30px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4"><strong>TOTAL PKB + TOTAL OPSEN PKB + TOTAL SWDKLLJ</strong></td>
                <td><strong>Rp.</strong></td>
                <td style="text-align: right"><strong><?=number_format($total_seluruh, 0)?></strong> </td>
            </tr>
            <tr height="60px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="">
                <td colspan="4"><strong>TOTAL SELURUHNYA</strong></td>
                <td><strong>Rp.</strong></td>
                <td style="text-align: right"><strong><?=number_format($total_seluruh, 0)?></strong>
                </td>
            </tr>

        </tbody>
    </table>
    </div>
</body>



</html>

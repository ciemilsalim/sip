<?php

$skpd = $list['skpd'];
$penyerahan = $list['penyerahan'];
$detail = $list['detail'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>BAPenyerahan</title>

    <style type="text/css" media="print">
        td {
            padding: 2px;
        }

        th {
            padding: 5px;
            text-align: center;
        }

        .x {
            border-spacing: 0px;
            border-collapse: separate;
            border-right: 1px solid #000;
            border-top: 1px solid #000;
        }

        .x td {
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
        }

        .x th {
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
        }
    </style>
</head>

<body>


    <h4 style="font-weight:bold; font-size:0.9em; text-align:center"> LAMPIRAN <?php if (isset($penyerahan['judul_berita'])) {
                                                                                    echo strtoupper($penyerahan['judul_berita']);
                                                                                } else echo "" ?></label><br>
        PADA
        <?php if (isset($skpd['nama_skpd'])) {
            echo strtoupper($skpd['nama_skpd']);
        } else echo "" ?>
    </h4>



    <div style="font-size:0.8em;">

        <table class="x" width="100%" style="font-size:0.8em;" border="1|0" cell-spacing="0">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">NAMA BARANG</th>
                    <th scope="col" colspan="2">BANYAKNYA BARANG</th>
                    <th scope="col">PENEMPATAN/PENGGUNAAN</th>
                    <th scope="col">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php if (isset($detail)) {
                        foreach ($detail as $key1 => $arr1) {
                                ?>
                        <tr>
                            <td style="text-align:center;"><?= $i++; ?></td>
                            <td><?= $arr1['uraian_komponen']; ?></td>
                            <td width="15%" style="text-align:center;"><?= $arr1['jumlah_pengeluaran']; ?></td>
                            <td width="15%" style="text-align:center;"><?= $arr1['satuan']; ?></td>
                            <td style="text-align:center;"><?php if (isset($penyerahan['nama_bidang'])) {
                                                                echo 'Bidang ' . $penyerahan['nama_bidang'];
                                                            } else echo "" ?></td>
                            <td></td>
                        </tr>
                    <?php }
        } ?>
            </tbody>
        </table>

        <center>
            <table width="100%" style="font-size:0.8em; text-align:center; padding:20px">
                <tr>
                    <td></td>
                    <td>Buol, <?php if (isset($penyerahan['tgl_bap'])) {
                                    echo tgl_indo2($penyerahan['tgl_bap']);
                                } else echo "" ?> </td>
                </tr>
                <tr>
                    <td width="45%"><b>Yang Menyerahkan<br><?php if (isset($penyerahan['jabatan_1'])) {
                                                                echo ucwords(strtolower($penyerahan['jabatan_1']));
                                                            } else echo "" ?><br><?php if (isset($skpd['nama_skpd'])) {
                                                                                                                                                                                    echo ucwords(strtolower($skpd['nama_skpd']));
                                                                                                                                                                                } else echo "" ?> <br><br><br><br><u> <?php if (isset($penyerahan['nama_1'])) {
                                                                                                                                                                                                                                                                                                                echo strtoupper($penyerahan['nama_1']);
                                                                                                                                                                                                                                                                                                            } else echo "" ?></u></b> <br>NIP. <?php if (isset($penyerahan['nip_1'])) {
                                                                                                                                                                                                                                                                                                                                                                                                                                    echo strtoupper($penyerahan['nip_1']);
                                                                                                                                                                                                                                                                                                                                                                                                                                } else echo "" ?></td>
                    <td width="45%"><b>Yang Menerima<br><?php if (isset($penyerahan['jabatan_2'])) {
                                                            echo ucwords(strtolower($penyerahan['jabatan_2']));
                                                        } else echo "" ?> <?php if (isset($penyerahan['nama_bidang'])) {
                                                                                                                                                                                echo ucwords(strtolower($penyerahan['nama_bidang']));
                                                                                                                                                                            } else echo "" ?><br><?php if (isset($skpd['nama_skpd'])) {
                                                                                                                                                                                                                                                                                                        echo ucwords(strtolower($skpd['nama_skpd']));
                                                                                                                                                                                                                                                                                                    } else echo "" ?> <br><br><br><br><u> <?php if (isset($penyerahan['nama_2'])) {
                                                                                                                                                                                                                                                                                                                                                                                                                                    echo strtoupper($penyerahan['nama_2']);
                                                                                                                                                                                                                                                                                                                                                                                                                                } else echo "" ?></u></b> <br>NIP. <?php if (isset($penyerahan['nip_2'])) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo strtoupper($penyerahan['nip_2']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } else echo "" ?></td>
                </tr>
            </table>
        </center>

    </div>


</body>

</html>
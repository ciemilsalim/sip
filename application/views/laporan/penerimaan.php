<?php
// $data = $list['list'];
$action = $list['action'];
$pengadaan = $list['pengadaan'];  
$skpd = $list['skpd'];  
$bulan = $list['bulan'];  
$pj1 = $list['pj1']; 
$pj2 = $list['pj2']; 
$pj3 = $list['pj3'];  

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPpenerimaan.xls");
} elseif ($action == "pdf") {
?>
<style type="text/css" media="print">
	@page { size: landscape; }
    
    td
    {
        padding:5px;
    }

    th
    {
        padding:5px;
    }
</style>
<script>
	(function(){
		window.print();
	})();
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Penerimaan</title>
    <style type="text/css" media="print">
	@page { size: landscape; }
    
    td
    {
        padding:6px;
    }

    th
    {
        padding:6px;
    }

    .x
    {
        border-spacing: 0px;
        border-collapse: separate;
        border-right:1px solid #000;
        border-top:1px solid #000;
    }
    .x td {
        border-bottom:1px solid #000;
        border-left:1px solid #000;
    }
    .x th {
        border-bottom:1px solid #000;
        border-left:1px solid #000;
    }
</style>
</head>
<body>
<div style="width:33 cm; height:21 cm; font-size:10px;">
<?php
    if ($action == "excel") {
    ?>
    <center>
    <table style="font-size:0.9em;">
        <tr>
            <td colspan="12" style="font-weight:bold; text-align:center; font-size:1em;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                BUKU PENERIMAAN BARANG <?php if ($bulan!='') { echo "BULAN ".strtoupper($bulan); } else echo ""; ?>
                <?php if (isset($skpd['tahun'])) { echo "TAHUN ".$skpd['tahun'];} else echo "" ?>
            </td>
        </tr>
    </table>
    </center>
    
    <?php
    }
    else
    {
        ?>
    <center>
    <table width="100%" style="font-size:0.9em;">
        <tr>
            <td width="10%" style="text-align:right">
                <?php if (isset($skpd['foto'])){ ?>
                    <img width="50px" height="50px" src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                <?php }?>
            </td>
            <td style="font-weight:bold; text-align:center; font-size:1em;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                BUKU PENERIMAAN BARANG <?php if ($bulan!='') { echo "BULAN ".strtoupper($bulan); } else echo ""; ?> <br>
                <?php if (isset($skpd['tahun'])) { echo "TAHUN ".$skpd['tahun'];} else echo "" ?>
            </td>
        </tr>
    </table>
    </center>
    
    <?php
    }?>

    <br>

    <table class="x" id="dataTable" width="100%" cellspacing="0" border="1|0" style="font-size:0.8em;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2">#</th>
                        <th scope="col" rowspan="2">Terima <br>
                        Tanggal</th>
                        <th scope="col" rowspan="2">Dari</th>
                        <th scope="col" colspan="2">Dokumen Faktur</th>
                        <th scope="col" rowspan="2">Nama Barang</th>
                        <th scope="col" rowspan="2">Banyaknya</th>
                        <th scope="col" rowspan="2">Harga Satuan</th>
                        <th scope="col" rowspan="2">Jumlah Harga</th>
                        <th scope="col" colspan="2">Bukti Penerimaan</th>
                        <th scope="col" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th scope="col">Nomor</th>
                        <th scope="col">Tanggal</th>
                        <!-- <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th> -->
                        <th scope="col">Nomor</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                   
                </thead>
                <tbody>
                    <tr style="background-color:#dfe1ed">
                        <td style="text-align:center;">1</td>
                        <td style="text-align:center;">2</td>
                        <td style="text-align:center;">3</td>
                        <td style="text-align:center;">4</td>
                        <td style="text-align:center;">5</td>
                        <td style="text-align:center;">6</td>
                        <td style="text-align:center;">7</td>
                        <td style="text-align:center;">8</td>
                        <td style="text-align:center;">9</td>
                        <td style="text-align:center;">10</td>
                        <td style="text-align:center;">11</td>
                        <td style="text-align:center;">12</td>
                    </tr>
                <?php $i = 1;  $totalsemua=0; ?>
                <?php   if (isset($pengadaan)) //belanja
                    {
                        foreach ($pengadaan as $key1 =>$arr1) : 
                            foreach ($arr1 as $key2 =>$arr2) : 
                               
                            ?>
                                <tr>
                                    <td style="text-align:center;"><?= $i++; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $arr2['nama_belanja']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <!-- <td style="border-left:none"></td>
                                    <td style="border-right:none"></td>
                                    <td style="border-left:none"></td> -->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php //pengadaan
                                    foreach ($arr2['uraian_pengadaan'] as $key3 =>$arr3) :
                                        if(!empty($arr3['uraian_penerimaan']))
                                        {
    
                                    ?>
    
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><?= $arr3['nama_supplier']; ?></td>
                                            <td><?php echo substr($arr3['nomor_faktur'],0,12);  ?>
                                                <br>
                                                <?php echo substr($arr3['nomor_faktur'],12);  ?></td>
                                            <td><?php if($arr3['tgl_faktur']=='0000-00-00') echo ''; else echo  $arr3['tgl_faktur'];?></td>
                                            <td><?= $arr3['uraian_pembelian']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <!-- <td style="border-left:none"></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td> -->
                                            <td><?php echo substr($arr3['nomor_bap'],0,12);  ?>
                                                <br>
                                                <?php echo substr($arr3['nomor_bap'],12);  ?></td>
                                            <td><?php if($arr3['tgl_bap']=='0000-00-00') echo ''; else echo  $arr3['tgl_bap'];?></td>
                                            <td><?= $arr3['no_sp2d']; ?></td>
                                        </tr>


                                            <?php //penerimaan
                                            $total=0;
                                            foreach ($arr3['uraian_penerimaan'] as $key4 =>$arr4) : 
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php if($arr4['tgl_penerimaan']=='0000-00-00') echo ''; else echo  $arr4['tgl_penerimaan'];?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="mso-number-format:\@;"><?= $arr4['uraian_komponen']; ?></td>
                                                    <td style="mso-number-format:\@;"><?= $arr4['jumlah']; ?> <?= $arr4['satuan']; ?></td>
                                                    <!-- <td style="border-right:none">Rp </td> -->
                                                    <td style="mso-number-format:\@;">Rp <?php echo number_format($arr4['harga_satuan_da']); ?></td>
                                                    <!-- <td style="border-right:none">Rp </td> -->
                                                    <td style="mso-number-format:\@;">Rp <?php echo number_format($arr4['harga_total']); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                            <?php 
                                            $total+=$arr4['harga_total'];
                                           
                                            endforeach; 

                                            $totalsemua= $totalsemua+$total;
                                            
                                            ?>

                                            

                                        <!-- sum pengadaan -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td ></td>
                                            <td ></td>
                                            <!-- <td style="border-right:none"></td>
                                            <td style="border-left:none"></td> -->
                                            <!-- <td style="border-right:none; font-weight:bold; color:blue;">Rp </td> -->
                                            <td style=" font-weight:bold;  mso-number-format:\@;">Rp <?php echo number_format($total) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                            <?php
                                        }
                                    endforeach;  //pengadaan
                            
                            endforeach; 
                    
                    endforeach; } //belanja ?>


                                 <!-- sum everything -->
                                 <tr style="background-color:#dfe1ed">
                                            <td colspan="8" style="text-align:center">Total Bulan <?php if ($bulan!='') { echo $bulan; } else echo ""; ?> </td>
                                            <td style=" font-weight:bold; color:red; mso-number-format:\@;">Rp <?php echo number_format($totalsemua) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                </tr>


                </tbody>

        </table>
        
        <!-- pj -->
        <br>
        <br>

    <?php
    if ($action == "excel") 
    {
    ?>
        <table width="100%" style=" font-size:0.8em">
            <tr>
                <td style="text-align:center;" colspan="12">
                    Buol, <?php echo tgl_indo(date('Y-m-d')); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; mso-number-format:\@;" width="50%" colspan="5">
                    <?php
                    if(!empty($pj2))
                    {
                        echo "<b>".strtoupper($pj2['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd'])."</b>";} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;'><b><u>". strtoupper($pj2['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj2['nip']);
                    }
                    ?>
                </td>
                <td style="text-align:center;mso-number-format:\@;" width="50%" colspan="5">
                <?php
                    if(!empty($pj3))
                    {
                        echo "<b>".strtoupper($pj3['jabatan'])."</b>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' ><b><u>". strtoupper($pj3['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj3['nip']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; mso-number-format:\@;" colspan="12">
                <?php
                    if(!empty($pj1))
                    {
                        echo "<b>".strtoupper($pj1['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd'])."</b>";} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' ><b><u>". strtoupper($pj1['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj1['nip']);
                    }
                    ?>
                </td>
            </tr>
        </table>
        </center>
    <?php
    }
    else
    {
    ?>

            <table width="100%" style=" font-size:0.8em">
            <tr>
                <td style="text-align:center;" colspan="2">
                    Buol, <?php echo tgl_indo(date('Y-m-d')); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; mso-number-format:\@;" width="50%">
                    <?php
                    if(!empty($pj2))
                    {
                        echo "<b>".strtoupper($pj2['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd'])."</b>";} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;'><b><u>". strtoupper($pj2['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj2['nip']);
                    }
                    ?>
                </td>
                <td style="text-align:center;mso-number-format:\@;" width="50%">
                <?php
                    if(!empty($pj3))
                    {
                        echo "<b>".strtoupper($pj3['jabatan'])."</b>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' ><b><u>". strtoupper($pj3['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj3['nip']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; mso-number-format:\@;" colspan="2">
                <?php
                    if(!empty($pj1))
                    {
                        echo "<b>".strtoupper($pj1['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd'])."</b>";} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' ><b><u>". strtoupper($pj1['nama'])."</u></b></label>";
                        echo "<br>";
                        echo ($pj1['nip']);
                    }
                    ?>
                </td>
            </tr>
        </table>
        </center>

    <?php
    }
    ?>
</div>
</body>
</html>

<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
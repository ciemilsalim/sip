<?php
$pengadaan = $list['pengadaan'];  
$penerimaan = $list['penerimaan']; 
$pj1 = $list['pj1']; 
$pj3 = $list['pj3'];  
$skpd = $list['skpd'];  

?>
<style type="text/css" media="print">
	@page { size: landscape; }
    
    td
    {
        padding:2px;
    }

    th
    {
        padding:2px;
        text-align:center;
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

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Penerimaan</title>
</head>
<body>
<div style="width:33 cm; height:21 cm; font-size:10px;">
 
    <table style="font-size:0.9em;" width="100%">
        <tr>
            <td width="100%" style="font-weight:bold; text-align:center; font-size:0.9em; " cellspacing="0">
                LAMPIRAN BUKU PENERIMAAN BARANG <br>
                <?php if (isset($pengadaan['uraian_pembelian'])) { echo strtoupper($pengadaan['uraian_pembelian']);} else echo "" ?>
            </td>
        </tr>
    </table>
   
    <br>

    <table class="x" width="100%" style="font-size:0.8em;" border="1|0" cell-spacing="0">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2">#</th>
                        <th scope="col" rowspan="2">Tanggal <br>
                        Terima</th>
                        <th scope="col" rowspan="2">Dari</th>
                        <th scope="col" colspan="2">Dokumen Faktur</th>
                        <th scope="col" rowspan="2">Nama Barang</th>
                        <th scope="col" rowspan="2">Satuan</th>
                        <th scope="col" rowspan="2">Jumlah</th>
                        <th scope="col" colspan="2">Harga</th>
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
                        <th scope="col">Satuan</th>
                        <th scope="col">Jumlah</th>
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
                        <td style="text-align:center;">13</td>
                    </tr>
                <?php $i = 1;  $totalsemua=0; ?>
                <?php   if (isset($pengadaan)) 
                    {   
                            ?>
                                <tr>
                                    <td style="text-align:center;"></td>
                                    <td></td>
                                    <td><?= $pengadaan['nama_supplier']; ?></td>
                                    <td><?= $pengadaan['nomor_faktur']; ?></td>
                                    <td><?php if($pengadaan['tgl_faktur']=='0000-00-00'){echo '';}else{ echo date('d/m/Y',strtotime( $pengadaan['tgl_faktur']));} ?></td>
                                    <td><?= $pengadaan['nama_belanja']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <!-- <td style="border-left:none"></td>
                                    <td style="border-right:none"></td>
                                    <td style="border-left:none"></td> -->
                                    <td></td>
                                    <td><?= $pengadaan['nomor_bap']; ?></td>
                                    <td><?php if($pengadaan['tgl_bap']=='0000-00-00'){echo '';}else{echo date('d/m/Y',strtotime( $pengadaan['tgl_bap']));} ?></td>
                                    <td><?= $pengadaan['no_sp2d']; ?></td>
                                </tr>

                               
                            <?php   } ?>

                                 <!-- sum everything style="background-color:#dfe1ed"-->
                                 <?php   if (isset($penerimaan)) 
                                 {
                                     foreach($penerimaan as $key=>$value)
                                     {
                                ?>
                                 <tr>
                                            <td style="text-align:center;"><?= $i++; ?></td>
                                            <td ><?php echo date('d/m/Y',strtotime($value['tgl_penerimaan'])); ?></td>
                                            <td ></td>
                                            <td></td>
                                            <td ></td>
                                            <td ><?=$value['uraian_komponen'];?></td>
                                            <td ><?=$value['satuan'];?></td>
                                            <td ><?=$value['jumlah'];?></td>
                                            <!-- <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none; font-weight:bold; color:red;">Rp </td> -->
                                            <!-- <td style="border-left:none; font-weight:bold; color:red; mso-number-format:\@;">Rp php echo number_format($totalsemua) ?></td> -->
                                            <td>Rp <?php echo number_format($value['harga_satuan_da']);?></td>
                                            <td>Rp <?php echo number_format($value['harga_total']);?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php $totalsemua+=$value['harga_total']; ?>
                                </tr>

                                <?php
                                     } }
                                ?>

                                <tr  style="background-color:#dfe1ed">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="4" style="text-align:center; font-weight:bold;">Jumlah</td>
                                            <td style="font-weight:bold;">Rp <?php echo number_format($totalsemua);?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                </tr>


                </tbody>

        </table>
        
        <!-- pj -->
        <br>
        <br>
        <table width="100%" style=" font-size:0.8em">
            <tr>
                <td width="33%">
                </td>
                <td width="33%">
                </td>
                <td style="text-align:center;" width="33%">
                    Buol, <?php echo tgl_indo(date('Y-m-d')); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" width="33%" >
                    <?php
                    if(isset($pengadaan))
                    {
                        echo 'Penyedia Barang';
                        echo "<br>";
                        echo $pengadaan['nama_supplier']; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >Pimpinan</label>";
                        echo "<br>";
                        // echo ($pj2['nip']);
                    }
                    ?>
                </td>
                <td style="text-align:center;" width="33%">
                <?php
                    if(!empty($pj1))
                    {
                        echo $pj1['jabatan']. ' '.$skpd['nama_skpd'];
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >". $pj1['nama']."</label>";
                        echo "<br>";
                        echo ($pj1['nip']);
                    }
                    ?>
                </td>
                <td style="text-align:center;" width="33%">
                <?php
                    if(!empty($pj3))
                    {
                        echo $pj3['jabatan'];
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >". $pj3['nama']."</label>";
                        echo "<br>";
                        echo ($pj3['nip']);
                    }
                    ?>
                </td>
               
            </tr>
        </table>
        </center>
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
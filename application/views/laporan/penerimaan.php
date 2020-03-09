<?php
// $data = $list['list'];
$action = $list['action'];
$pengadaan = $list['pengadaan'];  
$skpd = $list['skpd'];  
$tw = $list['tw'];  
$pj1 = $list['pj1']; 
$pj2 = $list['pj2']; 
$pj3 = $list['pj3'];  

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPsupplier.xls");
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
    <title>Pembelian</title>
</head>
<body>
<div style="width:33 cm; height:21 cm; font-size:10px;">
<?php
    if ($action == "excel") {
    ?>
    <center>
    <table style="font-size:0.9em;">
        <tr>
            <td colspan="8" style="font-weight:bold; text-align:center; font-size:1em;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                <?php if ($tw!='') { echo "TW. ".$tw; } else echo ""; ?>
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
    <table style="font-size:0.9em;">
        <tr>
            <td width="10%" style="text-align:right">
                <?php if (isset($skpd['foto'])){ ?>
                    <img width="50px" height="50px" src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                <?php }?>
            </td>
            <td style="font-weight:bold; text-align:center; font-size:1em;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                <?php if ($tw!='') { echo "TW. ".$tw; } else echo ""; ?>
                <?php if (isset($skpd['tahun'])) { echo "TAHUN ".$skpd['tahun'];} else echo "" ?>
            </td>
        </tr>
    </table>
    </center>
    
    <?php
    }?>

    <br>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1|0" style="font-size:0.9em;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2">#</th>
                        <th scope="col" rowspan="2">Terima Tanggal</th>
                        <th scope="col" rowspan="2">Dari</th>
                        <th scope="col" colspan="2">Dokumen Faktur</th>
                        <th scope="col" rowspan="2">Nama Barang</th>
                        <th scope="col" colspan="2">Banyaknya</th>
                        <th scope="col" colspan="2">Harga Satuan</th>
                        <th scope="col" colspan="2">Jumlah Harga</th>
                        <th scope="col" colspan="2">Bukti Penerimaan</th>
                        <th scope="col" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th scope="col">Nomor</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Nomor</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                   
                </thead>
                <tbody>
                <?php $i = 1;  $totalsemua=0; ?>
                <?php   if (isset($pengadaan)) //belanja
                    {
                        foreach ($pengadaan as $key1 =>$arr1) : 
                            foreach ($arr1 as $key2 =>$arr2) : 
                               
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $arr2['nama_belanja']; ?></td>
                                    <td style="border-right:none"></td>
                                    <td style="border-left:none"></td>
                                    <td style="border-right:none"></td>
                                    <td style="border-left:none"></td>
                                    <td style="border-right:none"></td>
                                    <td style="border-left:none"></td>
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
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td><?php echo substr($arr3['nomor_bap'],0,12);  ?>
                                                <br>
                                                <?php echo substr($arr3['nomor_bap'],12);  ?></td>
                                            <td><?php if($arr3['tgl_bap']=='0000-00-00') echo ''; else echo  $arr3['tgl_bap'];?></td>
                                            <td><?= $arr3['ket']; ?></td>
                                        </tr>


                                            <?php //penerimaan
                                            $total=0;
                                            foreach ($arr3['uraian_penerimaan'] as $key4 =>$arr4) : 
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?= $arr4['uraian_komponen']; ?></td>
                                                    <td style="border-right:none"><?= $arr4['jumlah']; ?></td>
                                                    <td style="border-left:none"><?= $arr4['satuan']; ?></td>
                                                    <td style="border-right:none">Rp </td>
                                                    <td style="border-left:none"><?php echo number_format($arr4['harga_satuan']); ?></td>
                                                    <td style="border-right:none">Rp </td>
                                                    <td style="border-left:none"><?php echo number_format($arr4['harga_total']); ?></td>
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
                                            <td><?= $i++; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none; font-weight:bold; color:blue;">Rp </td>
                                            <td style="border-left:none; font-weight:bold; color:blue;"><?php echo number_format($total) ?></td>
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
                                            <td ><?= $i++; ?></td>
                                            <td ></td>
                                            <td ></td>
                                            <td></td>
                                            <td ></td>
                                            <td ></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none"></td>
                                            <td style="border-left:none"></td>
                                            <td style="border-right:none; font-weight:bold; color:red;">Rp </td>
                                            <td style="border-left:none; font-weight:bold; color:red;"><?php echo number_format($totalsemua) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                </tr>


                </tbody>

        </table>
        
        <!-- pj -->
        <br>
        <br>
        <table width="100%" style=" font-size:0.9em">
            <tr>
                <td>
                </td>
                <td style="text-align:center;">
                    Buol, <?php echo tgl_indo(date('Y-m-d')); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" width="50%">
                    <?php
                    if(!empty($pj2))
                    {
                        echo strtoupper($pj2['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >". strtoupper($pj2['nama'])."</label>";
                        echo "<br>";
                        echo ($pj2['nip']);
                    }
                    ?>
                </td>
                <td style="text-align:center;" width="50%" >
                <?php
                    if(!empty($pj3))
                    {
                        echo strtoupper($pj3['jabatan']);
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >". strtoupper($pj3['nama'])."</label>";
                        echo "<br>";
                        echo ($pj3['nip']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                <?php
                    if(!empty($pj1))
                    {
                        echo strtoupper($pj1['jabatan']);
                        echo "<br>";
                        if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo ""; 
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        echo "<br>";
                        
                        echo "<label style='text-decoration:underline; font-weight:bold;' >". strtoupper($pj1['nama'])."</label>";
                        echo "<br>";
                        echo ($pj1['nip']);
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
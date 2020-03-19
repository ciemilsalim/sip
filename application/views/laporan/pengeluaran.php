<?php
// $data = $list['list'];
$action = $list['action'];
$pengeluaran = $list['pengeluaran'];  
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
    <title>Pengeluaran</title>
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
                BUKU PENGELUARAN BARANG <?php if ($tw!='') { echo "TW. ".$tw; } else echo ""; ?>
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
                BUKU PENGELUARAN BARANG <?php if ($tw!='') { echo "TW. ".$tw; } else echo ""; ?> <br>
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
                    <tr style="padding:10px;">
                        <th scope="col" >#</th>
                        <th scope="col" >Tanggal</th>
                        <th scope="col" ">Nama Barang</th>
                        <th scope="col" >Banyaknya</th>
                        <th scope="col" >Harga Satuan</th>
                        <th scope="col" ">Jumlah Harga</th>
                        <th scope="col" >Untuk</th>
                        <th scope="col" >Tanggal Penyerahan</th>
                        <th scope="col" >Keterangan</th>
                    </tr>
                   
                </thead>
                <tbody>
                    
                <?php $i = 1;  $totalsemua=0; ?>
                <?php   if (isset($pengeluaran)) //belanja
                    {
                        foreach ($pengeluaran as $key1 =>$arr1) : 
                            foreach ($arr1 as $key2 =>$arr2) : 
                               
                            ?>
                                <tr>
                                    <td style="text-align:center;"><?= $i++; ?></td>
                                    <td></td>
                                    <td><?= $arr2['tgl_permintaan']; ?></td>
                                    <td><?= $arr2['tujuan_penggunaan']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $arr2['ket']; ?></td>
                                </tr>


                                <?php foreach ($arr2['detil'] as $key3 =>$value) : 
                               
                               ?>
                                   <tr>
                                       <td style="text-align:center;"><?= $i++; ?></td>
                                       <td></td>
                                       <td></td>
                                       <td><?= $arr2['uraian_komponen']; ?></td>
                                       <td><?= $arr2['jumlah_pengeluaran']; ?> <?= $arr2['satuan']; ?></td>
                                       <td>Rp <?php echo  number_format($arr2['harga_satuan']); ?></td>
                                       <td></td>
                                       <td></td>
                                       <td><?= $arr2['ket']; ?></td>
                                   </tr>
           
                               <?php
                               
                               endforeach; 
        
                            
                            endforeach; 
                    
                    endforeach; }  ?>


                      

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
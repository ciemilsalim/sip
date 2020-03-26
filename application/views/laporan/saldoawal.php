<?php
// $data = $list['list'];
$action = $list['action'];
$saldoawal = $list['saldoawal'];  
$skpd = $list['skpd'];  
$bulan = $list['bulan'];  
$pj1 = $list['pj1']; 
$pj2 = $list['pj2']; 
$pj3 = $list['pj3'];  

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPsaldoawal.xls");
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
            <td colspan="9" style="font-weight:bold; text-align:center; font-size:1em;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                SALDO AWAL <?php if ($bulan!='') { echo "BULAN ".strtoupper($bulan); } else echo ""; ?>
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
                SALDO AWA <?php if ($bulan!='') { echo "BULAN ".strtoupper($bulan); } else echo ""; ?> <br>
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
                        <th scope="col" rowspan="2">Nama Barang</th>
                        <th scope="col" rowspan="2" >Satuan</th>
                        <th scope="col" colspan="3">Sebelum Koreksi</th>
                        <th scope="col" colspan="3">Sesudah Koreksi</th>
                    </tr>
                    <tr>
                        <th scope="col" >Harga Satuan</th>
                        <th scope="col" >Jumlah</th>
                        <th scope="col" >Jumlah Harga</th>
                        <th scope="col" >Harga Satuan</th>
                        <th scope="col" >Jumlah</th>
                        <th scope="col" >Jumlah Harga</th>
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
                    </tr>
                <?php $i = 1; $totalsemuanonkoreksi=0;  $totalsemuakoreksi=0; ?>
                <?php   if (isset($saldoawal)) //belanja
                    {
                        foreach ($saldoawal as $key1 =>$arr1) :
                    ?>
                    <tr>
                        <td style="text-align:center;"><?=$i++; ?></td>
                        <td> <?=$arr1['uraian_komponen']; ?></td>
                        <td style="text-align:center;"><?=$arr1['satuan']; ?></td>
                        <td >Rp <?php echo number_format($arr1['harga_satuan_da']); ?></td>
                        <td style="text-align:center;"><?=$arr1['jumlah']; ?></td>
                        <td >Rp <?php echo number_format($arr1['harga_total']); ?></td>
                        <td >Rp <?php echo number_format($arr1['harga_koreksi']); ?></td>
                        <td style="text-align:center;"><?=$arr1['jumlah_koreksi']; ?></td>
                        <td >Rp <?php echo number_format($arr1['harga_total_koreksi']); ?></td>
                    </tr>
                    <?php
                    $totalsemuanonkoreksi+=$arr1['harga_total'];
                    $totalsemuakoreksi+=$arr1['harga_total_koreksi'];
                    endforeach; } //belanja ?>


                    <!-- sum everything -->
                    <tr style="background-color:#dfe1ed">
                        <td colspan="5" style="text-align:center">Total Saldo Awal Bulan <?php if ($bulan!='') { echo $bulan; } else echo ""; ?> </td>
                        <td style=" font-weight:bold; color:red; mso-number-format:\@;">Rp <?php echo number_format($totalsemuakoreksi) ?></td>
                        <td></td>
                        <td></td>
                        <td style=" font-weight:bold; color:red; mso-number-format:\@;">Rp <?php echo number_format($totalsemuanonkoreksi) ?></td>
                    </tr>
                </tbody>

        </table>
        
  
</div>
</body>
</html>


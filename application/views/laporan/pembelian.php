<?php
// $data = $list['list'];
$action = $list['action'];
$pengadaan = $list['pembelian'];  
$skpd = $list['skpd'];  
$tw = $list['tw'];  

// echo "<pre>"; print_r($list);

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPsupplier.xls");
} elseif ($action == "pdf") {
?>
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
<div style="width:33 cm; height:21 cm; font-size:15px;">
<?php
    if ($action == "excel") {
    ?>
    <center>
    <table>
        <tr>
            <td colspan="8" style="font-weight:bold; text-align:center;">
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
    <table>
        <tr>
            <td width="10%" style="text-align:right">
                <?php if (isset($skpd['foto'])){ ?>
                    <img width="50px" height="50px" src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                <?php }?>
            </td>
            <td style="font-weight:bold; text-align:center;">
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

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1|0" >
                <thead>
                    <tr>
                    <th scope="col" rowspan="2">Kode Pembelian</th>
                        <th scope="col" rowspan="2">Supplier</th>
                        <th scope="col" colspan="2">Dokumen Faktur</th>
                        <th scope="col" colspan="2">Bukti Penerimaan</th>
                        <th scope="col" rowspan="2">Uraian Pembelian</th>
                        <th scope="col" rowspan="2">Keterangan Belanja</th>
                        <th scope="col" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th scope="col" style="width:20px;">Nomor</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col"style="width:20px;">Nomor</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php   if (isset($pengadaan)) 
                    {
                        foreach ($pengadaan as $sm) : ?>
                        <tr>
                            <td style="text-align:center"><?= $sm['kd_pengadaan']; ?></td>
                            <td><?= $sm['nama_supplier']; ?></td>
                            <td ><?php echo substr($sm['nomor_faktur'],0,12);  ?>
                                <br>
                                <?php echo substr($sm['nomor_faktur'],12);  ?>
                            </td>
                            <td><?php if($sm['tgl_faktur']=='0000-00-00') echo ''; else echo  date('d/m/Y',strtotime($sm['tgl_faktur']));?></td>
                            <td ><?php echo substr($sm['nomor_bap'],0,12);  ?>
                                <br>
                                <?php echo substr($sm['nomor_bap'],12);  ?>
                            </td>
                            <td><?php if($sm['tgl_bap']=='0000-00-00') echo ''; else echo  date('d/m/Y',strtotime($sm['tgl_bap']));?></td>
                            <td><?php echo  $sm['uraian_pembelian']; ?></td>
                            <td><?php echo "Belanja ". $sm['nama_belanja']; ?></td>
                            <td ><?php echo substr($sm['ket'],0,12);  ?>
                                <br>
                                <?php echo substr($sm['ket'],12);  ?>
                            </td>
                        </tr>
                        <?php endforeach; } ?>
                </tbody>

        </table>
        </center>
</div>
</body>
</html>
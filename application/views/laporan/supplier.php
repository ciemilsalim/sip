<?php
// $data = $list['list'];
$action = $list['action'];
$supplier = $list['supplier'];  
$skpd = $list['skpd'];  

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
    <title>Supplier</title>
</head>
<body>
<?php
    if ($action == "excel") {
    ?>
    <center>
    <table>
        <tr>
            <td colspan="6" style="font-weight:bold; text-align:center;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
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
                        <th scope="col">#</th>
                        <th scope="col" width="10%">Kode Supplier</th>
                        <th scope="col">Nama Supplier</th>
                        <th scope="col">Nama Pimpinan</th>
                        <th scope="col">NPWP</th>
                        <th scope="col">Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($supplier)) 
                    {
                        foreach ($supplier as $b) : ?>
                        <tr>
                            <td width="5%" style="text-align:center;"><?= $i++; ?></td>
                            <td width="15%"><?= $b['kd_supplier']; ?></td>
                            <td><?= $b['nama_supplier']; ?></td>
                            <td><?= $b['nama_pimpinan']; ?></td>
                            <td><?= $b['npwp']; ?></td>
                            <td><?= $b['alamat']; ?></td>
                        </tr>
                        <?php endforeach; }?>
                </tbody>

        </table>
        </center>

</body>
</html>
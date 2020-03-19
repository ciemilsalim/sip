<?php
// $data = $list['list'];
$action = $list['action'];
$belanja = $list['belanja'];  
$skpd = $list['skpd'];  

// echo "<pre>"; print_r($list);

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=SIPbelanja.xls");
    
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
    <title>Belanja</title>
</head>
<body>
    <?php
    if ($action == "excel") {
    ?>
    <center>
    <table width="100%" style="font-size:0.9em">
        <tr>
            <td colspan="3" style="font-weight:bold; text-align:center;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                BELANJA <?php if (isset($skpd['tahun'])) { echo "TAHUN ".$skpd['tahun'];} else echo "" ?>
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
    <table width="100%">
        <tr>
            <td width="10%" style="text-align:right">
                <?php if (isset($skpd['foto'])){ ?>
                    <img width="50px" height="50px" src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                <?php }?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> <br>
                BELANJA <?php if (isset($skpd['tahun'])) { echo "TAHUN ".$skpd['tahun'];} else echo "" ?>
            </td>
        </tr>
    </table>
    </center>
    
    <?php
    }?>

    <br>
     
    <center>
    <table class="x" id="dataTable" width="100%" cellspacing="0" border="1|0" style="font-size:0.8em">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Belanja</th>
                        <th scope="col">Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($belanja)) 
                    {
                        foreach ($belanja as $b) : ?>
                        <tr>
                            <td width="5%" style="text-align:center;"><?= $i++; ?></td>
                            <td width="15%"><?= $b['kd_belanja']; ?></td>
                            <td><?= $b['nama_belanja']; ?></td>
                        </tr>
                        <?php endforeach; }?>
                </tbody>


        </table>
        </center>

</body>
</html>
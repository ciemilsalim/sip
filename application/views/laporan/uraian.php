<?php
// $data = $list['list'];
$action = $list['action'];
$uraian = $list['uraian'];  

// echo "<pre>"; print_r($list);

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPuraian.xls");
} elseif ($action == "pdf") {
?>
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
    <title>Uraian Komponen</title>
    <style type="text/css" media="print">
    
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

    <center>
        <table width="100%" style="font-size:0.9em;">
        <tr>
            <td colspan="4" style="font-weight:bold; text-align:center;">
                URAIAN KOMPONEN
            </td>
        </tr>
    </table>
    </center>
 

    <br>
    <center>
    <div class="table-responsive">
    <table class="x" width="100%" style="font-size:0.8em" border="1|0">
    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <!-- <th scope="col">ID</th> -->
                        <th scope="col">Jenis Komponen</th>
                        <!-- <th scope="col">ID</th> -->
                        <th scope="col">Komponen</th>
                        <th scope="col">Uraian Komponen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($uraian)) {
                        foreach ($uraian as $k) : ?>
                            <tr>
                                <td width="5%" style="text-align:center;"><?= $i++; ?></td>
                                <!-- <td>//= $k['kd_jenis']; ?></td> -->
                                <td><?= $k['jenis_komponen']; ?></td>
                                <!-- <td>//= $k['kd_komponen']; ?></td> -->
                                <td><?= $k['komponen']; ?></td>
                                <td><?= $k['uraian_komponen']; ?></td>
                            </tr>
                        <?php endforeach;
                } ?>
                </tbody>
            </table>
        </div>
        </center>

</body>
</html>
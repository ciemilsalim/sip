<?php
// $data = $list['list'];
$action = $list['action'];
$komponen = $list['komponen'];  

// echo "<pre>"; print_r($list);

if ($action == "excel") {
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=SIPkomponen.xls");
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
    <title>Komponen</title>
</head>
<body>
    <div width="100%">

        <center>
        <table width="100%" style="font-size:0.9em;">
            <tr>
                <td colspan="3" style="font-weight:bold; text-align:center;">
                    KOMPONEN
                </td>
            </tr>
        </table>
        </center>
    

        <br>
        <center>
        <table class="x" width="100%" style="font-size:0.8em">
        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col">Jenis Komponen</th>
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col">Komponen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php
                        if (isset($komponen)) {
                            foreach ($komponen as $k) : ?>
                                <tr>
                                    <td width="5%" style="text-align:center;"><?= $i++; ?></td>
                                    <!-- <td>//= $k['kd_jenis']; ?></td> -->
                                    <td><?= $k['jenis_komponen']; ?></td>
                                    <!-- <td>//= $k['kd_komponen']; ?></td> -->
                                    <td><?= $k['komponen']; ?></td>
                                </tr>
                            <?php endforeach;
                    } ?>
                    </tbody>
            </table>
        </center>
    
    </div>

</body>
</html>
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

    <center>
    <table>
        <tr>
            <td colspan="3" style="font-weight:bold; text-align:center;">
                KOMPONEN
            </td>
        </tr>
    </table>
    </center>
 

    <br>
    <center>
    <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="70%" cellspacing="0" border="1|0" >
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
                                <td style="text-align:center;"><?= $i++; ?></td>
                                <!-- <td>//= $k['kd_jenis']; ?></td> -->
                                <td><?= $k['jenis_komponen']; ?></td>
                                <!-- <td>//= $k['kd_komponen']; ?></td> -->
                                <td><?= $k['komponen']; ?></td>
                            </tr>
                        <?php endforeach;
                } ?>
                </tbody>
            </table>
        </div>
        </center>

</body>
</html>
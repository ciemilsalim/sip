<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12" >
            <form action="<?= base_url("laporan/downloadparameter/"); ?>" method="POST" enctype="multipart/form-data">
                <input type="radio" class="btn btn-primary" name="pilih" value="pdf" checked> Pdf</input>
                <input type="radio" class="btn btn-primary" name="pilih" value="excel" > Excel</input>
                <br>
                <br>
                <input type="submit" class="btn btn-success" name="supplier" value="Download Laporan Supplier"/>
                <input type="submit" class="btn btn-success" name="belanja" value="Download Laporan Belanja"/>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




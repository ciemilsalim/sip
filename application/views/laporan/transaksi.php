<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12" >
            <form action="<?= base_url("laporan/downloadkomponen/"); ?>" method="POST" enctype="multipart/form-data">
                <input type="radio" class="btn btn-primary" name="pilih" value="pdf" checked> Pdf</input>
                <input type="radio" class="btn btn-primary" name="pilih" value="excel" > Excel</input>
                <br>
                <br>
                <input type="submit" class="btn btn-success" name="pembelian" value="Download Laporan Pembelian"/>
                <input type="submit" class="btn btn-success" name="penerimaan" value="Download Buku Penerimaan"/>
                <input type="submit" class="btn btn-success" name="pengeluaran" value="Download Buku Pengeluaran"/>
                <input type="submit" class="btn btn-success" name="stok" value="Download Stock Opname"/>
                <input type="submit" class="btn btn-success" name="persediaan" value="Download Kartu Persediaan"/>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




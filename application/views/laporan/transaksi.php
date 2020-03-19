<style>
    td
    {
        padding:10px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12" >
            <form action="<?= base_url("laporan/downloadtransaksi/"); ?>" method="POST" enctype="multipart/form-data">
                <input type="radio" class="btn btn-primary" name="pilih" value="pdf" checked> Pdf</input>
                <input type="radio" class="btn btn-primary" name="pilih" value="excel" > Excel</input>
                <br>
                <br>

                <table>
                <tr>
                    <td width="20%">
                        <label>Laporan Pembelian</label>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari">Januari</option> 
                            <option value="Februari">Februari</option> 
                            <option value="Maret">Maret</option> 
                            <option value="April">April</option> 
                            <option value="Mei">Mei</option> 
                            <option value="Juni">Juni</option> 
                            <option value="Juli">Juli</option> 
                            <option value="Agustus">Agustus</option> 
                            <option value="September">September</option> 
                            <option value="Oktober">Oktober</option> 
                            <option value="November">November</option> 
                            <option value="Desember">Desember</option> 
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="pembelian" value="Download"/>
                    </td>
                    <td width="20%">
                        <label>Buku Penerimaan</label>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari">Januari</option> 
                            <option value="Februari">Februari</option> 
                            <option value="Maret">Maret</option> 
                            <option value="April">April</option> 
                            <option value="Mei">Mei</option> 
                            <option value="Juni">Juni</option> 
                            <option value="Juli">Juli</option> 
                            <option value="Agustus">Agustus</option> 
                            <option value="September">September</option> 
                            <option value="Oktober">Oktober</option> 
                            <option value="November">November</option> 
                            <option value="Desember">Desember</option> 
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="penerimaan" value="Download"/>
                    </td>
                    <td width="20%">
                        <label>Buku Pengeluaran</label>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari">Januari</option> 
                            <option value="Februari">Februari</option> 
                            <option value="Maret">Maret</option> 
                            <option value="April">April</option> 
                            <option value="Mei">Mei</option> 
                            <option value="Juni">Juni</option> 
                            <option value="Juli">Juli</option> 
                            <option value="Agustus">Agustus</option> 
                            <option value="September">September</option> 
                            <option value="Oktober">Oktober</option> 
                            <option value="November">November</option> 
                            <option value="Desember">Desember</option> 
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="pengeluaran" value="Download"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-success" name="stok" value="Download Stock Opname"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-success" name="persediaan" value="Download Kartu Persediaan"/>
                    </td>
                </tr>
                </table>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




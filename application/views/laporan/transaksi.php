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
                            <select name="tw" id="tw" class="form-control">
                                <option value="">-- Pilih TW --</option> 
                                <option value="1">I</option> 
                                <option value="2">II</option> 
                                <option value="3">III</option> 
                                <option value="4">IV</option> 
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="pembelian" value="Download"/>
                    </td>
                    <td width="20%">
                        <label>Buku Penerimaan</label>
                        <div class="form-group">
                            <select name="twpenerimaan" class="form-control">
                                <option value="">-- Pilih TW --</option> 
                                <option value="1">I</option> 
                                <option value="2">II</option> 
                                <option value="3">III</option> 
                                <option value="4">IV</option> 
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="penerimaan" value="Download"/>
                    </td>
                    <td width="20%">
                        <label>Buku Pengeluaran</label>
                        <div class="form-group">
                            <select name="twpengeluaran" class="form-control">
                                <option value="">-- Pilih TW --</option> 
                                <option value="1">I</option> 
                                <option value="2">II</option> 
                                <option value="3">III</option> 
                                <option value="4">IV</option> 
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




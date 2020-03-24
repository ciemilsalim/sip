<?php
$disabled='';
$class='';
if($this->session->userdata('role_id')==3)
{
    $disabled='';
    $class='';
}
else
{
    $disabled="disabled";
    $class="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;";
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('nama_supplier', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#supplierModal">Tambah Bidang</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Supplier</th>
                        <th scope="col">Nama Supplier</th>
                        <th scope="col">Nama Pimpinan</th>
                        <th scope="col">NPWP</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($supplier)) 
                    {
                        foreach ($supplier as $b) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $b['kd_supplier']; ?></td>
                            <td><?= $b['nama_supplier']; ?></td>
                            <td><?= $b['nama_pimpinan']; ?></td>
                            <td><?= $b['npwp']; ?></td>
                            <td><?= $b['alamat']; ?></td>
                            <td><a href="#ubahsupplierModal<?=$b['id']?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>">Edit</a> </td>
                        </tr>
                        <?php endforeach; }?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Tambah -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="bidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/supplier'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" placeholder="Nama Supplier">
                    </div>
                    <?= form_error('nama_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" placeholder="Nama Pimpinan">
                    </div>
                    <?= form_error('nama_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP">
                    </div>
                    <?= form_error('nama_npwp', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        Alamat
                        <textarea  class="form-control" id="alamat" name="alamat" ></textarea>
                    </div>
                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ubah -->
<?php 
    if (isset($supplier)) 
    {
        foreach ($supplier as $b) 
        {
?>

<div class="modal fade" id="ubahsupplierModal<?=$b['id']?>" tabindex="-1" role="dialog" aria-labelledby="ubahsupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahsupplierModalLabel">Ubah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/editsupplier/'.$b['id']); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" placeholder="Nama Supplier" value="<?php echo $b['nama_supplier']; ?>">
                    </div>
                    <?= form_error('nama_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" placeholder="Nama Pimpinan" value="<?php echo $b['nama_pimpinan']; ?>">
                    </div>
                    <?= form_error('nama_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="npwp" name="npwp" placeholder="NPWP" value="<?php echo $b['npwp']; ?>">
                    </div>
                    <?= form_error('nama_npwp', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" ><?php echo $b['alamat']; ?></textarea>
                    </div>
                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
        } 
    }
?>

<script>

    $(function(){
        $("input").prop('required',true);
        $("textarea").prop('required',true);
    });

</script>
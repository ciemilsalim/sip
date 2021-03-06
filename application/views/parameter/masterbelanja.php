<?php
$disabled='';
$class='';
if($this->session->userdata('role_id')==7)
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
            <?= form_error('bidang', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#belanjaModal" >Tambah Belanja</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Belanja</th>
                        <th scope="col">Belanja</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($belanja)) 
                    {
                        foreach ($belanja as $b) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $b['kd_belanja_master']; ?></td>
                            <td><?= $b['nama_belanja_master']; ?></td>
                            <td><a href="#ubahbidangModal<?=$b['id_belanja_master']?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>" >Edit</a> </td>
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
<div class="modal fade" id="belanjaModal" tabindex="-1" role="dialog" aria-labelledby="belanjaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="belanjaModalLabel">Tambah Belanja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/masterbelanja'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="kd_belanja" name="kd_belanja" placeholder="Kode Belanja">
                    </div>
                    <?= form_error('kd_belanja', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_belanja" name="nama_belanja" placeholder="Nama Belanja">
                    </div>
                    <?= form_error('belanja', '<small class="text-danger pl-3">', '</small>'); ?>
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
    if (isset($belanja)) 
    {
        foreach ($belanja as $b) 
        {
?>

<div class="modal fade" id="ubahbidangModal<?=$b['id_belanja_master']?>" tabindex="-1" role="dialog" aria-labelledby="bidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bidangModalLabel">Ubah Belanja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url("parameter/editbelanjamaster/".$b['id_belanja_master']); ?>" method="POST">
                <div class="modal-body">
                     <div class="form-group">
                        <input disabled type="text" class="form-control" id="kd_belanja" name="kd_belanja" placeholder="Kode Belanja" value="<?php echo $b['kd_belanja_master']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_belanja" name="nama_belanja" placeholder="Nama Belanja" value="<?php echo $b['nama_belanja_master']; ?>">
                    </div>
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
    });

</script>
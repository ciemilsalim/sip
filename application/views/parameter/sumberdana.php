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


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#sdModal">Tambah Sumber Dana</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <!-- <th scope="col">Kode Sumber Dana</th> -->
                        <th scope="col">Nama Sumber Dana</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($sumberdana)) 
                    {
                        foreach ($sumberdana as $b) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <!-- <td> $b['kd_bid_skpd']; ?></td> -->
                            <td><?= $b['nama_sumber']; ?></td>
                            <td><a href="#ubahsumberModal<?=$b['id']?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>">Edit</a> </td>
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
<div class="modal fade" id="sdModal" tabindex="-1" role="dialog" aria-labelledby="sdModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sdModalLabel">Tambah Sumber Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Parameter/sumberdana'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_sumber" name="nama_sumber" placeholder="Nama Sumber">
                    </div>
                    <?= form_error('nama_sumber', '<small class="text-danger pl-3">', '</small>'); ?>
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
    if (isset($sumberdana)) 
    {
        foreach ($sumberdana as $b) 
        {
?>

<div class="modal fade" id="ubahsumberModal<?=$b['id']?>" tabindex="-1" role="dialog" aria-labelledby="bidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bidangModalLabel">Ubah Sumber Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url("parameter/editsumberdana/".$b['id']); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_sumber" name="nama_sumber" placeholder="Nama Sumber" value="<?php echo $b['nama_sumber']; ?>">
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
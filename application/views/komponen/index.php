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
            <?= form_error('jenis_komponen', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#jeniskomponenModal">Tambah Jenis Komponen</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <!-- <th scope="col">ID</th> -->
                        <th scope="col" >Jenis Komponen</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($jenis_komponen)) {
                        foreach ($jenis_komponen as $jk) : ?>
                            <tr>
                                <td style="text-align:center;"><?= $i++; ?></td>
                                <!-- <td>$jk['kd_jenis']; ?></td> -->
                                <td><?= $jk['jenis_komponen']; ?></td>
                                <td><a href="#ubahjeniskomponenModal<?= $jk['id_jenis']; ?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?= base_url('komponen/delete_jenis_komponen/' . $jk['id_jenis']); ?>" class="badge badge-danger" style="<?= $class; ?>">Hapus</a></td>
                            </tr>
                        <?php endforeach;
                } ?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




<script>
    $(function()
    {
       $("input").prop('required',true);
    });
</script>

<!-- Modal -->
<div class="modal fade" id="jeniskomponenModal" tabindex="-1" role="dialog" aria-labelledby="jeniskomponenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jeniskomponenModalLabel">Tambah Jenis Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('komponen'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="jenis_komponenx" name="jenis_komponen" placeholder="Jenis Komponen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($jenis_komponen)) {
    foreach ($jenis_komponen as $jk) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahjeniskomponenModal<?= $jk['id_jenis'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahjeniskomponenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahjeniskomponenModalLabel">Ubah Jenis Komponen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('komponen/edit_jenis_komponen/' . $jk['id_jenis']); ?>" method="POST"  onsubmit="return validateformjenis()" name="formjenis">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="jenis_komponen" name="jenis_komponen" placeholder="Jenis Komponen" value="<?php echo $jk['jenis_komponen']; ?>">
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
} ?>






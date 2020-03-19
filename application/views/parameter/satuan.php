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


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#satuanModal">Tambah Satuan</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <!-- <th scope="col">ID</th> -->
                        <th scope="col" >Satuan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($satuan)) {
                        foreach ($satuan as $jk) : ?>
                            <tr>
                                <td style="text-align:center;"><?= $i++; ?></td>
                                <!-- <td>$jk['kd_jenis']; ?></td> -->
                                <td><?= $jk['nama_satuan']; ?></td>
                                <td><a href="#ubahsatuanModal<?= $jk['id']; ?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?= base_url('parameter/deletesatuan/' . $jk['id']); ?>" class="badge badge-danger" style="<?= $class; ?>">Hapus</a></td>
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
<div class="modal fade" id="satuanModal" tabindex="-1" role="dialog" aria-labelledby="satuanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="satuanModalLabel">Tambah Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/satuan'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
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
if (isset($satuan)) {
    foreach ($satuan as $jk) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahsatuanModal<?= $jk['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahsatuanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahsatuanModalLabel">Ubah Satuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('parameter/editsatuan/' . $jk['id']); ?>" method="POST"  onsubmit="return validateformjenis()" name="formjenis">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="satuan" name="satuan"value="<?php echo $jk['nama_satuan']; ?>">
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






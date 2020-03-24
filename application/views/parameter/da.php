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
            <?= form_error('bidang', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="<?= base_url('Parameter/tambahda')?>" class="btn btn-primary mb-3 <?= $disabled ?>" >Tambah Data AwaL</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Data Awal</th>
                        <th scope="col">Sumber Dana</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($rka)) 
                    {
                        foreach ($rka as $b) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $b['kd_da']; ?></td>
                            <td><?= $b['nama_sumber']; ?></td>
                           <td><a href="<?= base_url('Parameter/rincianda/'.$b['kd_da'])?>" class="badge badge-success" style="<?= $class; ?>">Rincian</a> </td>
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

<script>
    $(function()
    {
       $("select").prop('required',true);
    });
</script>

<!-- Tambah -->
<div class="modal fade" id="daModal" tabindex="-1" role="dialog" aria-labelledby="daModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="daModalLabel">Tambah Data Awal (RKA)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/da'); ?>" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                       Sumber Dana<br>
                        <select name="sumber" id="sumber" class="form-control" >
                                <option value="">--Pilih Sumber Dana--</option>
                                    <?php foreach ($sumber as $r) : ?>
                                    <option value="<?= $r['kd_sumber']; ?>"><?= $r['nama_sumber']; ?></option>
                                <?php endforeach; ?>
                        </select>
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




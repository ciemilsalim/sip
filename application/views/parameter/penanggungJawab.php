
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

<?php 

if(!empty($kode1)  and !empty($kode2)  and !empty($kode3) )
{
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <div class="row">
        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                    PIMPINAN
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                           
                            <?= form_open_multipart('parameter/editpenanggungJawab'); ?>
                            <div class="form-group row">
                                <label for="nip1" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nip1" name="nip1"  value="<?= $kode1['nip'] ?>">
                                </div>
                                <?= form_error('nip1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama1" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nama1" name="nama1" value="<?= $kode1['nama'] ?>">
                                </div>
                                <?= form_error('nama1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabata1n" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="jabatan1" name="jabatan1" value="<?= $kode1['jabatan'] ?>">
                                </div>
                                <?= form_error('jabatan1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                    KUASA BUD
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <div class="form-group row">
                                <label for="nip2" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nip2" name="nip2" value="<?= $kode2['nip'] ?>">
                                </div>
                                <?= form_error('nip2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nam2a" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nama2" name="nama2" value="<?= $kode2['nama'] ?>">
                                </div>
                                <?= form_error('nama2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan2" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="jabatan2" name="jabatan2" value="<?= $kode2['jabatan'] ?>">
                                </div>
                                <?= form_error('jabatan2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                    PENGURUS GUDANG
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                        <div class="form-group row">
                                <label for="nip3" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nip3" name="nip3" value="<?= $kode3['nip'] ?>">
                                </div>
                                <?= form_error('nip3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama3" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="nama3" name="nama3" value="<?= $kode3['nama'] ?>">
                                </div>
                                <?= form_error('nama3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan3" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input <?= $disabled ?> type="text" class="form-control" id="jabatan3" name="jabatan3" value="<?= $kode3['jabatan'] ?>">
                                </div>
                                <?= form_error('jabatan3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



                            
                            <div class="form-group row justify-content-end" style="margin-top:20px;">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary  <?= $disabled ?>" <?= $disabled ?>>Simpan</button>
                                </div>
                            </div>
                        </form>


    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
}
else
{
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                    PIMPINAN
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <?= $this->session->flashdata('message'); ?>

                            <?= form_open_multipart('parameter/penanggungJawab'); ?>
                            <div class="form-group row">
                                <label for="nip1" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nip1" name="nip1">
                                </div>
                                <?= form_error('nip1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama1" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama1" name="nama1" >
                                </div>
                                <?= form_error('nama1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabata1n" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="jabatan1" name="jabatan1" >
                                </div>
                                <?= form_error('jabatan1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                    KUASA BUD
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <div class="form-group row">
                                <label for="nip2" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nip2" name="nip2">
                                </div>
                                <?= form_error('nip2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nam2a" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama2" name="nama2" >
                                </div>
                                <?= form_error('nama2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan2" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="jabatan2" name="jabatan2" >
                                </div>
                                <?= form_error('jabatan2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <!-- Default Card Example -->
            <div class="card mb-12">
                <div class="card-header">
                   PENGURUS GUDANG
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                        <div class="form-group row">
                                <label for="nip3" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nip3" name="nip3">
                                </div>
                                <?= form_error('nip3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama3" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama3" name="nama3" >
                                </div>
                                <?= form_error('nama3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan3" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="jabatan3" name="jabatan3" >
                                </div>
                                <?= form_error('jabatan3', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



                            
                            <div class="form-group row justify-content-end" style="margin-top:20px;">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>


    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
}
?>

<script>

    $(function(){
        $("input").prop('required',true);   
    });

</script>

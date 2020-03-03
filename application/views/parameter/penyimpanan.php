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

if(!empty($penyimpanan))
{
?>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<div class="row">
    <div class="col-lg-12">
        <!-- Default Card Example -->
        <div class="card mb-12">
            <div class="card-header">
                SKPD
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg">
                        <?= $this->session->flashdata('message'); ?>

                        <?= form_open_multipart("parameter/editPenyimpanan"); ?>

                        <div class="form-group row" style="display:none">
                            <label for="id" class="col-sm-2 col-form-label">Id</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $penyimpanan['id'] ?>">
                            </div>
                            <?= form_error('id', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div> 
                        <div class="form-group row">
                            <label for="penyimpanan" class="col-sm-2 col-form-label">Nama Penyimpanan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan" value="<?= $penyimpanan['nama_gudang'] ?>">
                            </div>
                            <?= form_error('penyimpanan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary <?= $disabled ?>">Ubah</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <div class="col-lg-12">
        <!-- Default Card Example -->
        <div class="card mb-12">
            <div class="card-header">
                Penyimpanan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg">
                        <?= $this->session->flashdata('message'); ?>

                        <?= form_open_multipart("parameter/penyimpanan"); ?>

                
                        <div class="form-group row">
                            <label for="penyimpanan" class="col-sm-2 col-form-label">Nama Penyimpanan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan" >
                            </div>
                            <?= form_error('penyimpanan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
}
?>

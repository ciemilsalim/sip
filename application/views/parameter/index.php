<?php
// $disabled='';
// if($this->session->userdata('role_id')==3)
// {
//     $disabled='';
// }
// else
// {
    $disabled="disabled";
// }

?>

<?php
if(!empty($identitas))
{
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Pemerintah Daerah
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <?= $this->session->flashdata('message'); ?>

                            <?= form_open_multipart('parameter/index'); ?>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Tahun</label>
                                <div class="col-sm-2">
                                    <input readonly disabled type="text" class="form-control" id="tahun" name="tahun" value="<?= $identitas['tahun']; ?>">
                                </div>
                                <?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group row">
                                <label for="nama_pemda" class="col-sm-3 col-form-label">Nama Pemda</label>
                                <div class="col-sm-9">
                                    <input  readonly type="text" class="form-control" id="nama_pemda" name="nama_pemda" value="<?php if (isset($identitas['nama_pemda'])) { echo $identitas['nama_pemda'];}else echo "" ?>">
                                    <?= form_error('nama_pemda', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ibu_kota" class="col-sm-3 col-form-label">Ibu Kota</label>
                                <div class="col-sm-9">
                                    <input  readonly type="text" class="form-control" id="ibu_kota" name="ibu_kota" value="<?php if (isset($identitas['ibu_kota'])) { echo $identitas['ibu_kota'];}else echo "" ?>">
                                    <?= form_error('ibu_kota', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea readonly class="form-control" id="alamat" name="alamat" ><?php if (isset($identitas['alamat'])) { echo $identitas['alamat'];}else echo "" ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">Logo</div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <?php if (isset($identitas['logo'])){ ?>
                                            <img src="<?= base_url('assets/img/logo/') . $identitas['logo'];?> " class="img-thumbnail">
                                            <?php }?>
                                        </div>
                                        <div class="col-sm-7">
                                            <input  disabled type="file" class="custom-file-input" id="logo" name="logo">
                                            <label class="custom-file-label" for="logo">Ambil gambar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary <?= $disabled ?>" disabled>Simpan</button>
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
        <div class="col-lg-6">
            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Pemerintah Daerah
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <?= $this->session->flashdata('message'); ?>

                            <?= form_open_multipart('parameter/index'); ?>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Tahun</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tahun" name="tahun" >
                                </div>
                                <?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group row">
                                <label for="nama_pemda" class="col-sm-3 col-form-label">Nama Pemda</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_pemda" name="nama_pemda" >
                                    <?= form_error('nama_pemda', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ibu_kota" class="col-sm-3 col-form-label">Ibu Kota</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ibu_kota" name="ibu_kota" >
                                    <?= form_error('ibu_kota', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="alamat" >
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">Logo</div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <img src="" class="img-thumbnail">
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="file" class="custom-file-input" id="logo" name="logo">
                                            <label class="custom-file-label" for="logo">Ambil gambar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
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

<?php 

if(!empty($skpd))
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

                        <?= form_open_multipart("parameter/skpd"); ?>

                        <?php if ($skpd['tahun']=='0') $tahun=''; else  $tahun=$skpd['tahun'];?>
                        <div class="form-group row" style="display:none">
                            <label for="id" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="id" name="id" value="<?php if (isset($skpd['id'])) { echo $skpd['id'];} else echo "" ?>">
                            </div>
                            <?= form_error('id', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="tahun" class="col-sm-3 col-form-label">Tahun</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" disabled   id="tahun" name="tahun" value="<?= $tahun ?>">
                            </div>
                            <?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="nama_skpd" class="col-sm-3 col-form-label">Nama SKPD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_skpd" name="nama_skpd" value="<?php if (isset($skpd['nama_skpd'])) { echo $skpd['nama_skpd'];}else echo "" ?>">
                            </div>
                            <?= form_error('nama_skpd', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_skpd" class="col-sm-3 col-form-label">Alamat SKPD</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="alamat_skpd" name="alamat_skpd" value="<?php if (isset($skpd['alamat_skpd'])) { echo $skpd['alamat_skpd'];}else echo "" ?>">
                            </div>
                            <?= form_error('alamat_skpd', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-3 col-form-label">NIP Pimpinan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php if (isset($skpd['nip_pimpinan'])) { echo $skpd['nip_pimpinan'];}else echo "" ?>">
                            </div>
                            <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="nama_pimpinan" class="col-sm-3 col-form-label">Nama Pimpinan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" value="<?php if (isset($skpd['nama_pimpinan'])) { echo $skpd['nama_pimpinan'];}else echo "" ?>">
                            </div>
                            <?= form_error('nama_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-3 col-form-label">Jabatan Pimpinan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php if (isset($skpd['jabatan'])) { echo $skpd['jabatan'];}else echo "" ?>">
                            </div>
                            <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_pimpinan" class="col-sm-3 col-form-label">Alamat Pimpinan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="alamat_pimpinan" name="alamat_pimpinan" value="<?php if (isset($skpd['alamat_pimpinan'])) { echo $skpd['alamat_pimpinan'];}else echo "" ?>">
                            </div>
                            <?= form_error('alamat_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">Foto</div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?php if (isset($skpd['foto'])){ ?>
                                            <img src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                                        <?php }?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" class="custom-file-input" id="foto" name="foto">
                                        <label class="custom-file-label" for="foto">Ambil gambar</label>
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
                    SKPD
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <?= $this->session->flashdata('message'); ?>

                            <?= form_open_multipart('parameter/editskpd'); ?>
                            <div class="form-group row">
                                <label for="tahun" class="col-sm-3 col-form-label">Tahun</label>
                                <div class="col-sm-6">
                                    <input disabled type="text" class="form-control" id="tahun" name="tahun">
                                </div>
                                <?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama_skpd" class="col-sm-3 col-form-label">Nama SKPD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nama_skpd" name="nama_skpd" >
                                </div>
                                <?= form_error('nama_skpd', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_skpd" class="col-sm-3 col-form-label">Alamat SKPD</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="alamat_skpd" name="alamat_skpd" >
                                </div>
                                <?= form_error('alamat_skpd', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nip" class="col-sm-3 col-form-label">NIP Pimpinan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nip" name="nip" >
                                </div>
                                <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="nama_pimpinan" class="col-sm-3 col-form-label">Nama Pimpinan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" >
                                </div>
                                <?= form_error('nama_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan Pimpinan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" >
                                </div>
                                <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_pimpinan" class="col-sm-3 col-form-label">Alamat Pimpinan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="alamat_pimpinan" name="alamat_pimpinan" >
                                </div>
                                <?= form_error('alamat_pimpinan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">Foto</div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <img src="" class="img-thumbnail">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" class="custom-file-input" id="foto" name="foto">
                                            <label class="custom-file-label" for="foto">Ambil gambar</label>
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

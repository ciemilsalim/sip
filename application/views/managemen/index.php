<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('managemen', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#managemenModal">Tambah TA</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tahun Anggaran</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($ta as $a) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $a['tahun']; ?></td>
                            <td><a href="#ubahmanagemenModal<?=$a['id_tahun']?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href="<?php echo base_url('managemen/deletetahun/'.$a['id_tahun']); ?>" class="badge badge-danger">Hapus</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Tambah -->
<div class="modal fade" id="managemenModal" tabindex="-1" role="dialog" aria-labelledby="managemenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="managemenModalLabel">Tambah Tahun Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('managemen'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun Anggaran" value="<?php echo date("Y"); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ubah -->
<?php 
    if (isset($ta)) 
    {
        foreach ($ta as $a) 
        {
?>
<div class="modal fade" id="ubahmanagemenModal<?=$a['id_tahun']?>" tabindex="-1" role="dialog" aria-labelledby="managemenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="managemenModalLabel">Ubah Tahun Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('managemen/edittahun'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun Anggaran" value="<?php echo $a['tahun']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="id_tahun" name="id_tahun" style="display:none" value="<?php echo $a['id_tahun']; ?>">
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
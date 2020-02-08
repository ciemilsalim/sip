<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-6">
            <?= form_error('komponen', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>


            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#uraiankomponenModal">Tambah Komponen</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Jenis Komponen</th>
                        <th scope="col">Komponen</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($uraian_komponen)) {
                        foreach ($uraian_komponen as $uk) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $uk['kd_uraian']; ?></td>
                                <td><?= $uk['jenis_komponen']; ?></td>
                                <td><?= $uk['komponen']; ?></td>
                                <td><?= $uk['uraian_komponen']; ?></td>
                                <td><a href="#ubahuraiankomponenModal<?= $uk['id']; ?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?= base_url('komponen/delete_uraian_komponen/' . $uk['id']); ?>" class="badge badge-danger">Hapus</a></td>
                            </tr>
                        <?php endforeach;
                } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="uraiankomponenModal" tabindex="-1" role="dialog" aria-labelledby="uraiankomponenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uraiankomponenModalLabel">Tambah Uraian Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('komponen/uraian_komponen'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="kd_komponen" id="kd_komponen" class="form-control">
                            <option value="">Pilih Komponen</option>
                            <?php foreach ($komponen as $k) : ?>
                                <option value="<?= $k['kd_komponen']; ?>"><?= $k['komponen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="uraian_komponen" name="uraian_komponen" placeholder="Uraian Komponen">
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


<?php
if (isset($uraian_komponen)) {
    foreach ($uraian_komponen as $uk) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahuraiankomponenModal<?= $uk['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahuraiankomponenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahuraiankomponenModalLabel">Ubah Uraian Komponen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('komponen/edit_uraian_komponen/' . $uk['id']); ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="kd_jenis" name="kd_jenis" placeholder="Jenis Komponen" value="<?php echo $uk['jenis_komponen']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="kd_komponen" name="kd_komponen" placeholder="Komponen" value="<?php echo $uk['komponen']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="uraian_komponen" name="uraian_komponen" placeholder="Uraian Komponen" value="<?php echo $uk['uraian_komponen']; ?>">
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
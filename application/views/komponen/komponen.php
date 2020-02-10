<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-6">
            <?= form_error('komponen', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>


            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#komponenModal">Tambah Komponen</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Jenis Komponen</th>
                        <th scope="col">ID</th>
                        <th scope="col">Komponen</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($komponen)) {
                        foreach ($komponen as $k) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $k['kd_jenis']; ?></td>
                                <td><?= $k['jenis_komponen']; ?></td>
                                <td><?= $k['kd_komponen']; ?></td>
                                <td><?= $k['komponen']; ?></td>
                                <td><a href="#ubahkomponenModal<?= $k['id_komponen']; ?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?= base_url('komponen/delete_komponen/' . $k['id_komponen']); ?>" class="badge badge-danger">Hapus</a></td>
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
<div class="modal fade" id="komponenModal" tabindex="-1" role="dialog" aria-labelledby="komponenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="komponenModalLabel">Tambah Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('komponen/komponen'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="id_jenis" id="id_jenis" class="form-control">
                            <option value="">Pilih Jenis Komponen</option>
                            <?php foreach ($jenis_komponen as $jk) : ?>
                                <option value="<?= $jk['id_jenis']; ?>"><?= $jk['jenis_komponen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="komponen" name="komponen" placeholder="Komponen">
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
if (isset($komponen)) {
    foreach ($komponen as $k) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahkomponenModal<?= $k['id_komponen'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahkomponenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahkomponenModalLabel">Ubah Komponen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('komponen/edit_komponen/' . $k['id_komponen']); ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="kd_jenis" name="kd_jenis" placeholder="Jenis Komponen" value="<?php echo $k['jenis_komponen']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="komponen" name="komponen" placeholder="Komponen" value="<?php echo $k['komponen']; ?>">
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
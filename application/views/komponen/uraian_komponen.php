<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-8">
            <?= form_error('komponen', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>


            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#uraiankomponenModal">Tambah Komponen</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Jenis Komponen</th>
                        <th scope="col">ID</th>
                        <th scope="col">Komponen</th>
                        <th scope="col">ID</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga (Rp)</th>
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
                                <td><?= $uk['kd_jenis']; ?></td>
                                <td><?= $uk['jenis_komponen']; ?></td>
                                <td><?= $uk['kd_komponen']; ?></td>
                                <td><?= $uk['komponen']; ?></td>
                                <td><?= $uk['kd_uraian']; ?></td>
                                <td><?= $uk['uraian_komponen']; ?></td>
                                <td><?= $uk['satuan']; ?></td>
                                <td><?= number_format($uk['harga']); ?></td>
                                <td><a href="#ubahuraiankomponenModal<?= $uk['id_uraian']; ?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?= base_url('komponen/delete_uraian_komponen/' . $uk['id_uraian']); ?>" class="badge badge-danger">Hapus</a></td>
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
                        <select name="id_komponen" id="id_komponen" class="form-control">
                            <option value="">Pilih Komponen</option>
                            <?php foreach ($komponen as $k) : ?>
                                <option value="<?= $k['id_komponen']; ?>"><?= $k['komponen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="uraian_komponen" name="uraian_komponen" placeholder="Uraian Komponen">
                    </div>
                    <div class="form-group">
                        <select name="satuan" id="satuan" class="form-control">
                            <option value="">Pilih Satuan</option>
                            <option value="Buah">Buah</option>
                            <option value="Lembar">Lembar</option>
                            <option value="Unit">Unit</option>
                            <option value="Lusin">Lusin</option>    
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga">
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
        <div class="modal fade" id="ubahuraiankomponenModal<?= $uk['id_uraian'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahuraiankomponenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahuraiankomponenModalLabel">Ubah Uraian Komponen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('komponen/edit_uraian_komponen/' . $uk['id_uraian']); ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="id_jenis" name="id_jenis" placeholder="Jenis Komponen" value="<?php echo $uk['jenis_komponen']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="id_komponen" name="id_komponen" placeholder="Komponen" value="<?php echo $uk['komponen']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="uraian_komponen" name="uraian_komponen" placeholder="Uraian Komponen" value="<?php echo $uk['uraian_komponen']; ?>">
                            </div>
                            <div class="form-group">
                                <select name="satuan" id="satuan" class="form-control">
                                    <option value="<?= $uk['satuan']; ?>"><?= $uk['satuan']; ?></option>

                                    <option value="Buah">Buah</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Lusin">Lusin</option>    
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="harga<?= $uk['id_uraian'] ?>" name="harga" placeholder="Harga" value="<?php echo number_format($uk['harga']); ?>">
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

        <script>
            $('#harga<?= $uk['id_uraian'] ?>').mask("#,###.###.###.###", {reverse: true});
        </script>

    <?php
}
} ?>



<script>
    $('#harga').mask("#,###.###.###.###", {reverse: true});
</script>

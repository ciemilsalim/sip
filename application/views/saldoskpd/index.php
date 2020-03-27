<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-12">
            <?= form_error('nama_supplier', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">SKPD</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php
                        if (isset($skpd)) {
                                foreach ($skpd as $b) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $b['nm_sub_unit']; ?></td>
                                    <td><?php if ($b['status_saldo_awal'] == 0) {
                                            echo "Tidak Aktif";
                                        } else {
                                            echo "Aktif";
                                        }; ?></td>

                                    <?php if ($b['status_saldo_awal'] == 0) { ?>
                                        <td><a href=" <?= base_url('Saldoskpd/status/' . $b['id'] . '/' . $b['status_saldo_awal']); ?>" class="badge badge-success">Aktif</a> </td>
                                    <?php
                                } else {
                                    ?>
                                        <td><a href=" <?= base_url('Saldoskpd/status/' . $b['id'] . '/' . $b['status_saldo_awal']); ?>" class="badge badge-danger">Tidak Aktif</a> </td>
                                    <?php

                                }; ?>

                                </tr>
                            <?php endforeach;
                    } ?>
                    </tbody>

                </table>
            </div>
            <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
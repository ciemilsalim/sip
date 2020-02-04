<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12" >
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>

            <div class="table-responsive" >
            <table class="table table-hover" id="dataTable" >
                <thead>
                    <tr>
                        <th scope="col">Kode Program</th>
                        <th scope="col">Program</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($program as $sm) : ?>
                        <tr>
                            <td><?= $sm['Kd_Prog']; ?></td>
                            <td><?= $sm['Ket_Program']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


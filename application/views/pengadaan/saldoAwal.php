<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    if(isset($status))
    {
        if($status==0)
        {
    ?>

    <a href="<?= base_url('pengadaan/tambahsaldoawal'); ?>" class="btn btn-primary mb-3" >Tambah Saldo Awal</a>

    <?php
        }
        else
        {
    ?>

    <a disabled class="btn btn-primary mb-3 disabled" >Tambah Saldo Awal</a>

    <?php
        }
    }
    ?>

    <?php
                    if(isset($aktif))
                    {
                        if ($aktif['tahun']==$this->session->userdata('tahun'))
                        {
                    ?>
                    <div class="form-group">
                        <label>Data Aktif : Tahun Anggaran <?=$aktif['tahun'];?> - Bulan <?=$aktif['bulan'];?></label>
                    </div>
                    <?php
                        }
                    }
                    else
                    {
                    ?>
                         <div class="form-group">
                            <label>Tidak ada tahun anggaran dan bulan aktif untuk login tahun <?=$this->session->userdata('tahun');?></label>
                        </div>
                    <?php } ?>


    <div class="row">
        <div class="col-lg-12">
           
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Uraian Komponen</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Sumber Dana</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($saldo_awal)) {
                        foreach ($saldo_awal as $uk) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $uk['uraian_komponen']; ?></td>
                                <td><?= $uk['satuan']; ?></td>
                                <td><?= number_format($uk['harga_koreksi']); ?></td>
                                <td><?= $uk['jumlah_koreksi']; ?></td>
                                <td><?= number_format($uk['harga_total_koreksi']); ?></td>
                                <td><?= $uk['nama_sumber']; ?></td>
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


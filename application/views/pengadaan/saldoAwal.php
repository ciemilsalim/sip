<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <a href="<?= base_url('pengadaan/tambahsaldoawal'); ?>" class="btn btn-primary mb-3" >Tambah Saldo Awal</a>

    <?php
    if(isset($aktif))
    {
        if ($aktif['tahun']==$this->session->userdata('tahun'))
        {
    ?>
        <div class="form-group">
           <label>Data Aktif : Tahun Anggaran <?=$aktif['tahun'];?> - Triwulan <?=$aktif['tw'];?></label>
        </div>
        <?php
            $tahun=$aktif['tahun'];
            $tw='';
            if ($aktif['tw']==1)
            {
                $tahun=$aktif['tahun']-1;
                $tw='IV';
            }
            else if($aktif['tw']==2)
            {
                $tw='I';
            }
            else if($aktif['tw']==3)
            {
                $tw='II';
            }
            else if($aktif['tw']==4)
            {
                $tw='III';
            }
        ?>
    <?php
        }
        else
        {
    ?>
        <div class="form-group">
            <label>Tidak ada tahun anggaran dan tw aktif untuk login tahun <?=$this->session->userdata('tahun');?></label>
        </div>
    <?php       
        }
    }
    else
    {
    ?>
        <div class="form-group">
        <label>Tidak ada tahun anggaran dan tw aktif untuk login tahun <?=$this->session->userdata('tahun');?></label>
        </div>
    <?php
    }
    ?>

    <div class="row">
        <div class="col-lg-12">
            <label style="text-decoration:underline">Detail Saldo Awal</label>
            <table width="70%">
            <tr>
                <td width="20%">Tahun</td>
                <td>
                    <div class="form-group">
                    <input readonly type="text" class="form-control" name="tahun" value="<?php echo $tahun; ?>">
                </div>
                </td>
                <tr>
                <tr>
                <td>TW</td>
                <td>
                    <div class="form-group">
                        <input readonly type="text" class="form-control" name="tw" placeholder="icon submenu" value="<?php echo $tw; ?>">
                    </div>
                </td>
            </table>
          
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
                                <td><?= number_format($uk['harga_satuan']); ?></td>
                                <td><?= $uk['jumlah']; ?></td>
                                <td><?= number_format($uk['harga_total']); ?></td>
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


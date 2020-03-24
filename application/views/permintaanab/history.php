<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">
               
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
                    
                    <?php
                    if(isset($aktif))
                    {
                        if($index=='ya')
                        {
                        ?>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari" <?php if($aktif['bulan']=='Januari') { echo "selected"; } ?>>Januari</option> 
                            <option value="Februari" <?php if($aktif['bulan']=='Februari') { echo "selected"; } ?>>Februari</option> 
                            <option value="Maret" <?php if($aktif['bulan']=='Maret') { echo "selected"; } ?>>Maret</option> 
                            <option value="April" <?php if($aktif['bulan']=='April') { echo "selected"; } ?>>April</option> 
                            <option value="Mei" <?php if($aktif['bulan']=='Mei') { echo "selected"; } ?>>Mei</option> 
                            <option value="Juni" <?php if($aktif['bulan']=='Juni') { echo "selected"; } ?>>Juni</option> 
                            <option value="Juli" <?php if($aktif['bulan']=='Juli') { echo "selected"; } ?>>Juli</option> 
                            <option value="Agustus" <?php if($aktif['bulan']=='Agustus') { echo "selected"; } ?>>Agustus</option> 
                            <option value="September" <?php if($aktif['bulan']=='September') { echo "selected"; } ?>>September</option> 
                            <option value="Oktober" <?php if($aktif['bulan']=='Oktober') { echo "selected"; } ?>>Oktober</option> 
                            <option value="November" <?php if($aktif['bulan']=='November') { echo "selected"; } ?>>November</option> 
                            <option value="Desember" <?php if($aktif['bulan']=='Desember') { echo "selected"; } ?>>Desember</option> 
                            </select>
                        </div>

                        <?php
                        }
                        else
                        {?>
                         <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari" <?php if($index=='Januari') { echo "selected"; } ?>>Januari</option> 
                            <option value="Februari" <?php if($index=='Februari') { echo "selected"; } ?>>Februari</option> 
                            <option value="Maret" <?php if($index=='Maret') { echo "selected"; } ?>>Maret</option> 
                            <option value="April" <?php if($index=='April') { echo "selected"; } ?>>April</option> 
                            <option value="Mei" <?php if($index=='Mei') { echo "selected"; } ?>>Mei</option> 
                            <option value="Juni" <?php if($index=='Juni') { echo "selected"; } ?>>Juni</option> 
                            <option value="Juli" <?php if($index=='Juli') { echo "selected"; } ?>>Juli</option> 
                            <option value="Agustus" <?php if($index=='Agustus') { echo "selected"; } ?>>Agustus</option> 
                            <option value="September" <?php if($index=='September') { echo "selected"; } ?>>September</option> 
                            <option value="Oktober" <?php if($index=='Oktober') { echo "selected"; } ?>>Oktober</option> 
                            <option value="November" <?php if($index=='November') { echo "selected"; } ?>>November</option> 
                            <option value="Desember" <?php if($index=='Desember') { echo "selected"; } ?>>Desember</option> 
                            </select>
                        </div>
                        <?php
                        }
                    }
                    else
                    {
                    ?>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option> 
                            <option value="Januari">Januari</option> 
                            <option value="Februari">Februari</option> 
                            <option value="Maret">Maret</option> 
                            <option value="April">April</option> 
                            <option value="Mei">Mei</option> 
                            <option value="Juni">Juni</option> 
                            <option value="Juli">Juli</option> 
                            <option value="Agustus">Agustus</option> 
                            <option value="September">September</option> 
                            <option value="Oktober">Oktober</option> 
                            <option value="November">November</option> 
                            <option value="Desember">Desember</option> 
                            </select>
                        </div>
                    <?php
                    }
                    ?>
            
            <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Bulan</th>
                        <th scope="col">Kode Permintaan</th>
                        <th scope="col">Tanggal Permintaan</th>
                        <th scope="col">Tujuan Penggunaan</th>
                        <th scope="col">Tanggal Persetujuan Kepala Bidang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php   if (isset($permintaan)) 
                    {
                        foreach ($permintaan as $sm) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $sm['tahun']; ?></td>
                            <td><?= $sm['bulan']; ?></td>
                            <td><?= $sm['kd_permintaan']; ?></td>
                            <td><?= $sm['tgl_permintaan']; ?></td>
                            <td><?= $sm['tujuan_penggunaan']; ?></td>
                            <td><?= $sm['tgl_kepala_bidang']; ?></td>
                            <td><a href="<?=base_url('Permintaanab/detailhistory/'.$sm['kd_permintaan']."/".$sm['tahun']."/".$sm['bulan']); ?>" class="badge badge-success">Detail</a> </td>
                        </tr>
                        <?php endforeach; } ?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<script>

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#bulan').on('change', function() 
    {
        bulan=$('#bulan').val();
        window.location.href = "<?php echo base_url(); ?>Permintaanab/pilihantw/"+bulan;
    });

</script>


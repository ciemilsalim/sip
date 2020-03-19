<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message');?>
           
            
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
                        <th scope="col">Status Proses Kepala Bidang</th>
                        <th scope="col">Status Proses Pengurus Gudang</th>
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
                            <td>
                                <?php if($sm['status_kepala_bidang']==0) 
                                        {
                                            echo "Belum dibaca";
                                        }
                                        else if($sm['status_kepala_bidang']==1) 
                                        {
                                            echo "Sudah dibaca dan belum diproses";
                                        }
                                        else if($sm['status_kepala_bidang']==2) 
                                        {
                                            echo "Sudah diproses";
                                        }    
                                        else if($sm['status_kepala_bidang']==3 ) 
                                        {
                                            echo "Permintaan ditolak";
                                        }
                                                            
                                ?>
                            </td>
                            <td>
                                <?php  if($sm['status_kepala_gudang']==0 and $sm['status_kepala_bidang']<=2) 
                                        {
                                            echo "Belum diproses";
                                        }
                                        else if($sm['status_kepala_gudang']==1 and $sm['status_kepala_bidang']==2) 
                                        {
                                            echo "Sudah dibaca dan belum diproses";
                                        }
                                        else if($sm['status_kepala_gudang']==2  and $sm['status_kepala_bidang']==2) 
                                        {
                                            echo "Sudah diproses";
                                        }
                                        else if($sm['status_kepala_gudang']==7  and $sm['status_kepala_bidang']>=3) 
                                        {
                                            echo "Tidak diproses";
                                        }
                                        else if($sm['status_kepala_gudang']==3  and $sm['status_kepala_bidang']>=3) 
                                        {
                                            echo "Permintaan ditolak";
                                        }
                                ?> 
                            </td>
                            <td><a href=" <?=base_url('permintaanab/detailpermintaan/'.$sm['kd_permintaan']); ?>" class="badge badge-success">Detail</a> </td>
                            <td>
                            <?php
                                    
                                    $class="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;";
                                    if($sm['status_kepala_gudang']>=2 and $sm['status_kepala_bidang']>=2) 
                                    {
                                        $class='';  
                                    }
                            ?>   
                                <a href=" <?=base_url('permintaanab/status/'.$sm['kd_permintaan']); ?>" class="badge badge-warning" style="<?= $class; ?>">Selesai</a> 
                            </td>
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
    $('#tw').on('change', function() 
    {
        tw=$('#tw').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihantw/"+tw;
    });

</script>


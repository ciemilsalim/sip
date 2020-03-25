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
                                        else if($sm['status_kepala_bidang']==3) 
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
                                        else if($sm['status_kepala_gudang']==7  and $sm['status_kepala_bidang']==3) 
                                        {
                                            echo "Tidak diproses";
                                        }
                                        else if($sm['status_kepala_gudang']==3  and $sm['status_kepala_bidang']==3) 
                                        {
                                            echo "Permintaan ditolak";
                                        }
                                ?> 
                            </td>
                            <td><a href=" <?=base_url('permintaanag/detailpermintaanproses/'.$sm['kd_permintaan']); ?>" class="badge badge-success">Detail</a> 

                            <?php
                                if($sm['status_penyerahan']==1)
                                {
                            ?>
                                        | <a href=" <?=base_url('permintaanag/bap/'.$sm['id']); ?>" class="badge badge-primary">Cetak Berita Acara Penyerahan</a> 
                            <?php
                                }
                                else
                                {
                            ?>
                             
                                        | <a href="#buatModal<?=$sm['id']?>" class="badge badge-primary" data-toggle="modal">Buat Berita Acara Penyerahan</a> 
                            <?php } ?>

                            <?php
                                    
                                    $class="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;";
                                    if($sm['status_selesai_kb']>=0 and $sm['status_kepala_gudang']>=2) 
                                    {
                                        $class='';  
                                    }
                            ?>   
                                 | <a href=" <?=base_url('permintaanag/status/'.$sm['kd_permintaan']); ?>" class="badge badge-warning" style="<?= $class; ?>">Selesai</a> 
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




<!-- ubah -->
<?php 
    if (isset($permintaan)) 
    {
        foreach ($permintaan as $b) 
        {
?>

<div class="modal fade" id="buatModal<?=$b['id']?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Berita Acara Penyerahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('permintaanag/simpanbap/'.$b['id']); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        Judul Berita Acara <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh : BERITA ACARA PENYERAHAN LOGISTIK">
                    </div>
                    <div class="form-group">
                        Nomor Berita Acara <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Nomor B.A Penyerahan">
                    </div>
                    <div class="form-group">
                        Tanggal <input type="date" class="form-control" id="nomor" name="tgl" placeholder="Nomor B.A Penyerahan">
                    </div>
                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
        } 
    }
?>

<script>

    $(function(){
        $("input").prop('required',true);
    });

</script>


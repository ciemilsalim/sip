<?php
if($this->uri->segment(3)!='')
{
    $kd_pengadaan=$this->uri->segment(3);
}
else
{
    $kd_pengadaan='';
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="<?=base_url('Permintaanab/proses') ?>" class="badge badge-success" width="100%">Kembali</a>
    <br>

    
    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>');?>
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

                    
                    
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Permintaan</label>
                    <table width="90%">
                        <tr>
                            <td style="padding:10px;">
                                <label >Kode Permintaan</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="kd" name="kd" value="<?php if(isset($permintaan)) { echo $permintaan['kd_permintaan']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Bidang</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" value="<?php if(isset($permintaan)) { echo $permintaan['nama_bidang']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Kepala Bidang</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="nama_k_bidang" name="nama_k_bidang" value="<?php if(isset($permintaan)) { echo $permintaan['nama_kep_bid_skpd']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>NIP Kepala Bidang</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php if(isset($permintaan)) { echo $permintaan['nip']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Admin</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="nama_admin" name="nama_admin" value="<?php if(isset($permintaan)) { echo $permintaan['nama_admin']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Tanggal Permintaan</label>
                            </td>
                            <td width="70%">
                                <input type="text" class="form-control" id="tgl_permintaan" name="tgl_permintaan" value="<?php if(isset($permintaan)) { echo $permintaan['tgl_permintaan']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Tujuan Penggunaan</label>
                            </td>
                            <td width="60%">
                                <textarea class="form-control" id="tujuan" name="tujuan" readonly><?php if(isset($permintaan)) { echo $permintaan['tujuan_penggunaan']; } ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Tanggal Persetujuan Kepala Bidang</label>
                            </td>
                            <td width="60%">
                            <input readonly type="text" class="form-control" value="<?php if(isset($permintaan)) { echo $permintaan['tgl_kepala_bidang']; } ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Tanggal Persetujuan Pengurus Gudang</label>
                            </td>
                            <td width="60%">
                            <input readonly type="text" class="form-control" value="<?php if(isset($permintaan)) { echo $permintaan['tgl_kepala_gudang']; } ?>" />
                            </td>
                        </tr>
                      
                    </table>
                </div>

                    <br>
                    <label style="text-decoration:underline">Detail Komponen</label>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian Komponen</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah Permintaan</th>
                            <!-- <th scope="col">Harga Permintaan</th> -->
                            <th scope="col">Jumlah Persetujuan Kepala Bidang</th>
                            <!-- <th scope="col">Harga Persetujuan Kepala Bidang</th> -->
                            <th scope="col">Jumlah Persetujuan Pengurus Barang</th>
                            <!-- <th scope="col">Harga Persetujuan Pengurus Gudang</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                        <?php   if (isset($detailpermintaan)) 
                        {
                            foreach ($detailpermintaan as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= number_format($sm['harga_satuan']);; ?></td>
                                <td><?= $sm['jumlah_permintaan']; ?></td>
                                <!-- <td>//= number_format($sm['harga_permintaan']); ?></td> -->
                                <td><?= $sm['jumlah_persetujuan_kb']; ?></td>
                                <!-- <td>//= number_format($sm['harga_persetujuan_kb']); ?></td> -->
                                <td><?= $sm['jumlah_persetujuan_pg']; ?></td>
                                <!-- <td>//= number_format($sm['harga_persetujuan_pg']); ?></td> -->
                            </tr>


                            <?php endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->

  
                            
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


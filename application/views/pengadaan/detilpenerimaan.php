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

    <a href="<?=base_url('Pengadaan/index') ?>" class="badge badge-success" width="100%">Kembali</a> | 
    <a href="<?=base_url('Pengadaan/lampiran/'.$pengadaan['kd_pengadaan'].'/'.$pengadaan['bulan'])?>" class="badge badge-success">Cetak Lampiran Buku Penerimaan Barang</a>
            
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
                    <label style="text-decoration:underline">Detail Pengadaan</label>
                    <table width="100%">
                        <tr>
                            <td>
                                <label>Belanja</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $pengadaan['nama_belanja']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Supplier</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $pengadaan['nama_supplier']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Sumber Dana</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $pengadaan['nama_sumber']; ?></label>
                                <input type="input" name="sumber" value="<?php echo $pengadaan['kd_sumber']; ?>" style="display:none"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Uraian Belanja</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $pengadaan['uraian_pembelian']; ?></label>
                            </td>
                        </tr>
                    </table>
                </div>

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Penerimaan</label><br>
                    <label>Dokumen Faktur</label>
                    <div class="form-group" style="width:35%">
                        <input readonly type="text" class="form-control" id="no_faktur" name="no_faktur" value="<?php echo $pengadaan['nomor_faktur']; ?>">
                    </div>
                    <div class="form-group" style="width:35%">
                        <input readonly type="text" class="form-control" id="tgl_faktur" name="tgl_faktur" value="<?php echo date('d/m/Y',strtotime($pengadaan['tgl_faktur'])); ?>">
                    </div>
                    <label>Bukti Penerimaan </label><br>
                    <div class="form-group" style="width:35%">
                        <input readonly type="text" class="form-control" id="no_bap" name="no_bap" value="<?php echo $pengadaan['nomor_bap']; ?>">
                    </div>
                    <div class="form-group" style="width:35%">
                        <input readonly type="text" class="form-control" id="tgl_bap" name="tgl_bap" value="<?php echo date('d/m/Y',strtotime( $pengadaan['tgl_bap'])); ?>">
                    </div>
                    <label>No. SP2D </label><br>
                    <div class="form-group" style="width:35%">
                        <input readonly type="text" class="form-control" id="sp2d" name="sp2d" value="<?php echo $pengadaan['no_sp2d']; ?>">
                    </div>

                </div>

                    <br>
                    <label style="text-decoration:underline">Detail Penerimaan Komponen</label>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th >#</th>
                            <th >Uraian Komponen</th>
                            <th >Satuan</th>
                            <th >Harga Satuan</th>
                            <th >Jumlah</th>
                            <th >Jumlah Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; $total=0;?>
                        <?php   if (isset($komponen)) 
                        {
                            foreach ($komponen as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= number_format($sm['harga_satuan_da']); ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <td><?= number_format($sm['harga_total']); ?></td>
                            </tr>


                            <?php $total+=$sm['harga_total']; endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input class="form-control" name="total" id="totalharga" placeholder="Total Harga" value="<?php echo number_format($total);?>"/>            
                </div>
                
                <br>

               
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<br>
<br>

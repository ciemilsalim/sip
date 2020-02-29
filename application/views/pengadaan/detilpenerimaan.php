
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
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>
                <?php
                    $tw='';
                    if (isset($detil)) 
                    {
                        $tw=$detil['tw'];
                    }
                ?>
                <a href="<?=base_url('Pengadaan/pilihantw/'.$tw) ?>" class="badge badge-success" width="100%">Kembali</a>
                <br>

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
                   

            <?php   if (isset($detil)) 
            {
            ?>

     
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Pengadaan</label>
                    <table width="100%">
                        <tr>
                            <td>
                                <label>Kode Pengadaan</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['kd_pengadaan']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Nomor Faktur</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['nomor_faktur']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tanggal Faktur</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['tgl_faktur']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >Nomor BAP</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['nomor_bap']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >Tanggal BAP</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['tgl_bap']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Keterangan Belanja</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['nama_belanja']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Supplier</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['nama_supplier']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >NIP Penerima</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['nip_penerima']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >Nama Penerima</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['nama_penerima']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >Jabatan Penerima</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['jabatan']; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label >Keterangan Lainnya</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['ket']; ?></label>
                            </td>
                        </tr>
                    </table>
                </div>

                    <br>
                    <label style="text-decoration:underline">Detail Penerimaan</label>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian Komponen</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah Pembelian</th>
                            <th scope="col">Total</th>
                            <th scope="col">Tanggal Penerimaan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php   if (isset($penerimaan)) 
                    {
                        $total=0;
                        foreach ($penerimaan as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= $sm['harga']; ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <td class="total"><?= $sm['harga_total']; ?></td>
                                <td><?= $sm['tgl_penerimaan']; ?></td>
                            </tr>
                        <?php $total+=$sm['harga_total']; endforeach; } ?>
                        </tbody>
                    </table>
                </div> <!--table -->

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input class="form-control" name="total" id="totalharga" placeholder="Total Harga" value="<?= $total ?>"/>            
                </div>
           
        <?php } ?>     

                            
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
$('.total').mask("#,###,###,###,###", {reverse: true});
$('#totalharga').mask("#,###,###,###,###", {reverse: true});
</script>





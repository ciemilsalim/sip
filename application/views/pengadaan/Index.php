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
            if(isset($aktif))
            {
                if ($aktif['tahun']==$this->session->userdata('tahun'))
                {
            ?>
                <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#pengadaanModal">Tambah Pengadaan</a>
            <?php
                }
                else
                {
            ?>
                <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal" >Tambah Pengadaan</a>
            <?php
                }
            }
            else
            {
                ?>
                    <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal" >Tambah Pengadaan</a>
                <?php
                    
            }
            ?>
            
                <div class="modal-body">
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
                    <div class="form-group">
                        <select name="tw" id="tw" class="form-control">
                           <option value="">-- Pilih TW --</option> 
                           <option value="1">I</option> 
                           <option value="2">II</option> 
                           <option value="3">III</option> 
                           <option value="4">IV</option> 
                        </select>
                    </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">TW</th>
                        <th scope="col">Kode Pengadaan</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php   if (isset($pengadaan)) 
                    {
                        foreach ($pengadaan as $sm) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $sm['tahun']; ?></td>
                            <td><?= $sm['tw']; ?></td>
                            <td><?= $sm['kd_pengadaan']; ?></td>
                            <td><?= $sm['nama_supplier']; ?></td>
                            <td><a href="#detilpembelianModal<?=$sm['id'];?>" data-toggle="modal" class="badge badge-success">Detail</a> </td>
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

<!-- Modal -->
<div class="modal fade" id="pengadaanModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pengadaan/index'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Data Faktur</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_faktur" name="tgl_faktur" placeholder="Nomor Faktur">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur">
                    </div>
                    <hr style="border:1px solid grey;"></hr>
                    <div class="form-group">
                        <label>Data BAP</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_bap" name="tgl_bap" placeholder="Nomor BAP">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tgl_bap" name="tgl_bap">
                    </div>
                    <hr style="border:1px solid grey;"></hr>
                    <div class="form-group">
                        <label>Data Belanja</label>
                    </div>
                    <div class="form-group">
                        <select name="belanja" id="belanja" class="form-control">
                           <option value="">-- Pilih Belanja --</option> 
                           <?php if (isset($belanja))
                           {
                               foreach ($belanja as $m): ?>
                            <option value="<?= $m['kd_belanja'];?>"><?= $m['nama_belanja'];?></option> 
                           <?php endforeach; }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="supplier" id="supplier" class="form-control">
                           <option value="">-- Pilih Supplier --</option> 
                           <?php if (isset($supplier))
                           {
                               foreach ($supplier as $m): ?>
                            <option value="<?= $m['kd_supplier'];?>"><?= $m['nama_supplier'];?></option> 
                           <?php endforeach; }?>
                        </select>
                    </div>
                    <hr style="border:1px solid grey;"></hr>
                    <div class="form-group">
                        <label>Data Penerima</label>
                    </div>
                    <div class="form-group">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    NIP
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?php if (isset($pj)){ echo $pj['nip'];}?>" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                         <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    Nama
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($pj)){ echo $pj['nama'];}?>" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    Jabatan
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php if (isset($pj)){ echo $pj['jabatan'];}?>" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr style="border:1px solid grey;"></hr>
                    <div class="form-group">
                        <label>Keterangan</label>
                    </div>
                    <div class="form-group">
                        <textarea name="ket" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>

        </div>
    </div>
</div>



<script>

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#tw').on('change', function() 
    {
        tw=$('#tw').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihantw/"+tw;
    });

</script>

<?php   if (isset($pengadaan)) 
{
foreach ($pengadaan as $sm) : ?>
<!-- Modal -->
<div class="modal fade" id="detilpembelianModal<?=$sm['id']?>" tabindex="-1" role="dialog" aria-labelledby="detilpembelianModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detilpembelianModalLabel">Detail Pembelian</h5>
            </div>
           
                <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td>
                            <label class="form-control">Nomor Faktur</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nomor_faktur']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Tanggal Faktur</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['tgl_faktur']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Nomor BAP</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nomor_bap']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Tanggal BAP</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['tgl_bap']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Keterangan Belanja</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nama_belanja']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Supplier</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nama_supplier']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">NIP Penerima</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nip_penerima']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Nama Penerima</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['nama_penerima']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Jabatan Penerima</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['jabatan']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-control">Keterangan Lainnya</label>
                        </td>
                        <td width="60%">
                            <label class="form-control"><?php echo $sm['ket']; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <a href="<?=base_url('Pengadaan/detilpenerimaan/'.$sm['kd_pengadaan'].'/'.$sm['tahun'].'/'.$sm['tw']); ?>" class="badge badge-success" width="100%">Detail Penerimaan</a>
                        </td>
                    </tr>
                </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >close</button>
                </div>
        </div>

    </div>
</div>




<?php endforeach; } ?>

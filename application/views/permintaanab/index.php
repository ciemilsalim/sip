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
           
            <?php
            if(isset($aktif))
            {
                if ($aktif['tahun']==$this->session->userdata('tahun'))
                {
            ?>
                <a href="<?php echo base_url(); ?>permintaanab/tambahpermintaan/" class="btn btn-primary mb-3" >Tambah Permintaan</a>
            <?php
                }
                else
                {
            ?>
                <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal" >Tambah Pembelian</a>
            <?php
                }
            }
            else
            {
                ?>
                    <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal" >Tambah Pembelian</a>
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
                    <?php   if (isset($permintaan)) 
                    {
                        foreach ($permintaan as $sm) : ?>
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



<script>

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#tw').on('change', function() 
    {
        tw=$('#tw').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihantw/"+tw;
    });

</script>


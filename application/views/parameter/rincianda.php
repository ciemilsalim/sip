<?php
$disabled='';
$class='';
if($this->session->userdata('role_id')==7)
{
    $disabled='';
    $class='';
}
else
{
    $disabled="disabled";
    $class="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;";
}

?>
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
               
                <a href="<?=base_url('Parameter/da') ?>" class="badge badge-success" width="100%">Kembali</a>
                <br>

                    <div class="form-group">
                        <label>Tahun Anggaran <?=$this->session->userdata('tahun')?></label>
                    </div>
                 

     
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Data Awal</label>
                   <?php
                      if (isset($detil)) 
                      {
                   ?>
                    <table width="100%">
                        <tr>
                            <td>
                                <label>Kode Data Awal</label>
                            </td>
                            <td width="60%">
                                <label>: <?php echo $detil['kd_da']; ?></label>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td>
                                <label>Sumber Dana</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['nama_sumber']; ?></label>
                            </td>
                        </tr>
                       
                    </table>
                      <?php } ?>
                </div>

                    <br>
                    <label style="text-decoration:underline">Rincian</label><br>
                    <a href="<?=base_url('Parameter/tambahda/'.$detil['kd_da']) ?>" class="badge badge-success" width="100%">Tambah Rincian</a>
                    <br><div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian Komponen</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Maksimal</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah Pembelian</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; $total=0;?>
                        <?php   if (isset($detilkomponen)) 
                        {
                            foreach ($detilkomponen as $sm) : ?>
                            <tr>
                                <td><?=$i++ ?></td>
                                <td><?=$sm['uraian_komponen']?></td>
                                <td><?=$sm['satuan']?></td>
                                <td><?php echo number_format($sm['harga_satuan']) ?></td>
                                <td><?php echo number_format($sm['harga_input']) ?></td>
                                <td><?=$sm['jumlah']?></td>
                                <td><?php echo number_format($sm['harga_total']) ?></td>
                                <td>
                                <!-- style="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;" -->
                                <!-- <a onclick="return confirm('Yakin akan menghapus data?');" href=" base_url('Parameter/deleterincianda/'.$sm['id_detail_da'].'/'.$sm['kd_da']); ?>" class="badge badge-danger" >Hapus</a> |  -->
                                <a href="#ubahdaModal<?= $sm['id_detail_da']; ?>" data-toggle="modal" class="badge badge-success" >Ubah</a></td>
                            </tr>
                            <?php $total+=$sm['harga_total']; endforeach;

                        } ?>
                    
                        </tbody>
                    </table>
                </div> <!--table -->

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input class="form-control" name="total" id="totalharga" placeholder="Total Harga" value="<?php echo $total; ?>"/>            
                </div>
           
       

                            
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
if (isset($detilkomponen)) {
    foreach ($detilkomponen as $jk) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahdaModal<?= $jk['id_detail_da'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahModalLabel">Ubah Data Awal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Parameter/editrincianda/' . $jk['id_detail_da'].'/'.$sm['kd_da']); ?>" method="POST"  name="formjenis">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control harga_input" id="harga_input" name="harga_input" value="<?php echo $jk['harga_input']; ?>">
                                <input type="text" class="form-control" id="harga_satuan" name="harga_satuan"value="<?php echo $jk['harga_satuan']; ?>" style="display:none;">
                                <input type="text" class="form-control" id="jumlah" name="jumlah"value="<?php echo $jk['jumlah']; ?>" style="display:none;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
}
} ?>

<script>
    $('.total').mask("#,###,###,###,###", {reverse: true});
    $('#totalharga').mask("#,###,###,###,###", {reverse: true});

    $('.harga_input').mask("#,###,###,###,###", {reverse: true});

    $(function()
    {
       $("input").prop('required',true);
    });
</script>




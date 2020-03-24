<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="<?=base_url('Koreksi/index') ?>" class="badge badge-success" width="100%">Kembali</a><br>
    <div class="row">
        <div class="col-lg-12">
            
            <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                <input type="text" class="form-control" value="<?= $skpd['nm_sub_unit'] ?>" readonly>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th  rowspan="2">#</th>
                        <th  rowspan="2">Uraian Komponen</th>
                        <th  rowspan="2">Satuan</th>
                        <th  rowspan="2">Harga Satuan</th>
                        <th  rowspan="2">Jumlah</th>
                        <th  rowspan="2">Jumlah Harga</th>
                        <th  colspan="3" style="text-align:center"> Koreksi </th>
                        <th  rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>Koreksi Harga Satuan</th>
                        <th>Koreksi Jumlah</th>
                        <th>Koreksi Total Harga </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; $total=0;?>
                        <?php   if (isset($koreksi)) 
                        {
                            foreach ($koreksi as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= number_format($sm['harga_satuan_da']); ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <td><?= number_format($sm['harga_total']); ?></td>
                                <td><?= number_format($sm['harga_koreksi']); ?></td>
                                <td>
                                    <?= $sm['jumlah_koreksi']; ?>
                                </td>
                                <td>
                                    <?php echo number_format($sm['harga_total_koreksi']); ?>
                                </td>
                                <td>
                                <a href="#ubahkoreksiModal<?= $sm['id_koreksi']; ?>" data-toggle="modal" class="badge badge-success" >Koreksi</a>
                                </td>
                            </tr>


                        <?php  endforeach; } ?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
if (isset($koreksi)) {
    foreach ($koreksi as $jk) {

        ?>

        <!-- Modal -->
        <div class="modal fade" id="ubahkoreksiModal<?= $jk['id_koreksi'] ?>" tabindex="-1" role="dialog" aria-labelledby="ubahLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahLabel">Koreksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Koreksi/dokoreksidetail/' . $jk['id_koreksi'].'/'.$skpd['id_k']); ?>" method="POST" >
                        <div class="modal-body">
                            <div class="form-group">
                                Harga Satuan
                                <input type="text" class="form-control" id="harga<?= $jk['id_koreksi'] ?>"  name="harga" placeholder="Harga Satuan" value="<?php echo $jk['harga_koreksi']; ?>">
                            </div>
                            <div class="form-group">
                                Jumlah
                                <input type="text" class="form-control" id="jumlah<?= $jk['id_koreksi'] ?>" name="jumlah" placeholder="Jumlah" value="<?php echo $jk['jumlah_koreksi']; ?>">
                            </div>
                            <div class="form-group">
                                Total
                                <input readonly type="text" class="form-control" id="total<?= $jk['id_koreksi'] ?>" name="total" placeholder="Total Harga" value="<?php echo $jk['harga_total_koreksi']; ?>">
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

        <script>
            $('#harga<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true});
            $('#total<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true});

            $(document).ready(function() { 
                $("#jumlah"+<?= $jk['id_koreksi']; ?>).bind('keyup changed', function () 
                {                 
                    if($('#jumlah'+<?= $jk['id_koreksi']; ?>).val()=='' || $('#jumlah'+<?= $jk['id_koreksi']; ?>).val()<0)
                    {
                        $('#jumlah'+<?= $jk['id_koreksi']; ?>).val(0);
                    }

                    jumlah= $('#jumlah'+<?= $jk['id_koreksi']; ?>).val();    
                    harga= $('#harga'+<?= $jk['id_koreksi']; ?>).val();    
                    nilai=Number(harga.replace(/[^0-9.-]+/g,""));  
                    total=jumlah*nilai;   
                    $('#total'+<?= $jk['id_koreksi']; ?>).val(total);  
                    
                    $('#harga<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: false});
                    $('#harga<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true}); 
                    $('#total<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: false});
                    $('#total<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true});
                }); 

                $("#harga"+<?= $jk['id_koreksi']; ?>).bind('keyup changed', function () 
                {                 
                    if($('#harga'+<?= $jk['id_koreksi']; ?>).val()=='' || $('#harga'+<?= $jk['id_koreksi']; ?>).val()<0)
                    {
                        $('#harga'+<?= $jk['id_koreksi']; ?>).val(0);
                    }

                    jumlah= $('#jumlah'+<?= $jk['id_koreksi']; ?>).val();    
                    harga= $('#harga'+<?= $jk['id_koreksi']; ?>).val();    
                    nilai=Number(harga.replace(/[^0-9.-]+/g,""));  
                    total=jumlah*nilai;   
                    $('#total'+<?= $jk['id_koreksi']; ?>).val(total);  
                    
                    $('#harga<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: false});
                    $('#harga<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true}); 
                    $('#total<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: false});
                    $('#total<?= $jk['id_koreksi'] ?>').mask("#,###,###,###,###", {reverse: true});
                }); 
            }); 

        </script>

    <?php
}
} ?>

<script>
    $(function()
    {
       $("input").prop('required',true);
    });

</script>


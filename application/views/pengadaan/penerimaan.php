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

<script>
    var i=0;
    var data=[];
    var datano=[];
</script>

<script>

    var totaltes=0;


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',hargada,jumlah,total)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',hargada:''+hargada+'', jumlah:''+jumlah+'',total:''+total+''};  
        totaltes+=total;                                
        // console.log(data);
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',hargada,jumlah,total)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',hargada:''+hargada+'', jumlah:''+jumlah+'',total:''+total+''};  
                // console.log(data);
            }
            
        });

    }

    

</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <a href="<?=base_url('Pengadaan/index') ?>" class="badge badge-success" width="100%">Kembali</a>
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


                <form action="<?= base_url('Pengadaan/penerimaanbarang'); ?>" method="POST">
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Pengadaan Komponen</label>
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
                                <input type="input" name="sumber" value="<?php echo $pengadaan['kd_sumber']; ?>" style="display:none">
                                <input type="input" name="kd_pengadaan" value="<?php echo $pengadaan['kd_pengadaan']; ?>" style="display:none">
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
                        <input type="text" class="form-control" id="no_faktur" name="no_faktur" placeholder="Nomor Faktur">
                    </div>
                    <div class="form-group" style="width:35%">
                        <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur">
                    </div>
                    <label>Bukti Penerimaan </label><br>
                    <div class="form-group" style="width:35%">
                        <input type="text" class="form-control" id="no_bap" name="no_bap" placeholder="Nomor BAP">
                    </div>
                    <div class="form-group" style="width:35%">
                        <input type="date" class="form-control" id="tgl_bap" name="tgl_bap">
                    </div>
                    <label>No. SP2D </label><br>
                    <div class="form-group" style="width:35%">
                        <input type="text" class="form-control" id="sp2d" name="sp2d" placeholder="Nomor SP2D">
                    </div>

                </div>


                    <br>
                    <label style="text-decoration:underline">Detail Penerimaan Komponen</label>
                    <br>
                    <input type="radio" id="pilih" name="pilih" value="y" checked/> Realisasi semua pengadaan
                    <input style="margin-left:20px;" type="radio" id="pilih" value="c" name="pilih" /> Custom

                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th >#</th>
                            <th >Uraian Komponen</th>
                            <th >Satuan</th>
                            <th >Jumlah</th>
                            <th >Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; $jumlahsemua=0; ?>
                        <?php   if (isset($komponen)) 
                        {
                            foreach ($komponen as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= $sm['jumlah_pengadaan']; ?></td>
                                <td><?= number_format($sm['harga_pengadaan']); ?></td>
                            
                                <td>
                                    <input type="checkbox" id="id<?= $sm['id_detail_pengadaan']; ?>"  value="<?= $sm['id_detail_pengadaan']; ?>" > Realisasi
                                </td>
                            </tr>

                            <script> 
                                 $(document).ready(function() { 
                                    klik<?= $sm['id_detail_pengadaan']; ?>='1'+<?= $sm['id_detail_pengadaan']; ?>;
                                    
                                    $("#id"+<?= $sm['id_detail_pengadaan']; ?>).click(function() 
                                    { 
                                       
                                        if(klik<?= $sm['id_detail_pengadaan']; ?>=='1'+<?= $sm['id_detail_pengadaan']; ?>)
                                        {

                                            ubahobjek(<?= $sm['id_detail_pengadaan']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_da']; ?>,0,0)
                                            
                                            klik<?= $sm['id_detail_pengadaan']; ?>='2'+<?= $sm['id_detail_pengadaan']; ?>;
                                        }
                                        else
                                        {
                                            simpanobjek(<?= $sm['id_detail_pengadaan']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_da']; ?>,<?= $sm['jumlah_pengadaan']; ?>,<?= $sm['harga_pengadaan']; ?>);
                                        }
                                      

                                    }); 
                                }); 
                        </script>

                            <?php 
                                $jumlahsemua+=$sm['harga_pengadaan'];
                            endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->
                

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px; display:none">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input readonly class="form-control" name="total" id="totalharga" placeholder="Total Harga" value="<?php echo number_format($jumlahsemua);  ?>"/>            
                </div>
                
                <br>
                <table width="100%">
                    <tr>
                        <td width="90%">
                            <textarea style="width:550px; display:none;" name="jsondata" id="jsondata"></textarea>
                            <textarea style="width:550px; display:none;" name="jsondatano" id="jsondatano"></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success pull-right" id="buttonjson">Selesai</button>
                        </td>
                        <td>
                            <button disabled type="submit" class="btn btn-primary pull-right" id="buttonsimpan">Simpan</button>
                        </td>
                    </tr>
                </table>

            </form>

   
                            
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>


    if($('input[name=pilih]:checked').val() == "y") 
    {
                <?php  
                    if (isset($komponen)) 
                    {
                        foreach ($komponen as $sm) : 
                    ?>
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop("disabled",true);
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop('checked', true);
                        simpanobjek(<?= $sm['id_detail_pengadaan']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_da']; ?>,<?= $sm['jumlah_pengadaan']; ?>,<?= $sm['harga_pengadaan']; ?>);
                    <?php
                    endforeach; }
                ?>
    }

    $(function () 
    {
        $("input[name=pilih]:radio").click(function () 
        {
            if($('input[name=pilih]:checked').val() == "y") 
            {
                <?php  
                    if (isset($komponen)) 
                    {
                        foreach ($komponen as $sm) : 
                    ?>
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop("disabled",true);
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop('checked', true);
                        ubahobjek(<?= $sm['id_detail_pengadaan']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_da']; ?>,<?= $sm['jumlah_pengadaan']; ?>,<?= $sm['harga_pengadaan']; ?>);
                    <?php
                    endforeach; }
                ?>
         
            }
            else if ($('input[name=pilih]:checked').val() == "c")  
            {
                <?php  
                    if (isset($komponen)) 
                    {
                        foreach ($komponen as $sm) : 
                    ?>
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop("disabled",false);
                        $("#id"+<?= $sm['id_detail_pengadaan']; ?>).prop('checked', true);
                        ubahobjek(<?= $sm['id_detail_pengadaan']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_da']; ?>,<?= $sm['jumlah_pengadaan']; ?>,<?= $sm['harga_pengadaan']; ?>);
                    <?php
                    endforeach; }
                ?>

            }
           
        });
    });

    $("#buttonjson").click(function() 
    { 
        datafix=JSON.stringify(data);
        $('#jsondata').val(datafix);

        datanofix=JSON.stringify(datano);
        $('#jsondatano').val(datanofix);

        $('#buttonjson').prop("disabled",true);
        $('#buttonsimpan').prop("disabled",false);
    });
</script>

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
    var dataobj=[];
</script>

<style>
th
{
    height: 5px;
    line-height: 5px;
    text-align: center;
    border: 2px dashed #f69c55;
}
</style>

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


            <form action="<?= base_url('pengadaan/simpandetailpengadaan/'.$pengadaan['kd_pengadaan']); ?>" method="POST">

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
                    <label style="text-decoration:underline">Detail Pengadaan</label>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Uraian Komponen</th>
                            <th scope="col" rowspan="2">Satuan</th>
                            <th scope="col" colspan="2">Data Awal</th>
                            <th scope="col" colspan="2">Realisasi Penerimaan</th>
                            <th scope="col" rowspan="2" style="border-left:1px solid #e0e1e6">Sisa</th>
                            <th scope="col" rowspan="2" style="border-left:1px solid #e0e1e6">Pengadaan</th>
                        </tr>
                        <tr>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <!-- <th scope="col">Harga Satuan</th> -->
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                        <?php   if (isset($komponen)) 
                        {
                            foreach ($komponen as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <td><?= number_format($sm['harga_input']); ?></td>
                                <td><?php if($sm['jumlahrealisasi']==null){ echo $r=0;}else{ echo $r=$sm['jumlahrealisasi'];} ?></td>
                                <td><?php if($sm['hargarealisasi']==null){ echo "0";}else{ echo  number_format($sm['hargarealisasi']);} ?></td>
                                <td><?php echo $sisa=$sm['jumlah']-$sm['jumlahrealisasi']; ?></td>
                                <td>
                                    <input type="checkbox" id="id<?= $sm['id_detail_da']; ?>"  value="<?= $sm['id_detail_da']; ?>" >
                                    <input type="number" style="width:100px; padding:10px;" id="jumlah<?= $sm['id_detail_da']; ?>"  value="0" disabled>
                                    <input type="text" style="width:150px; padding:10px;" id="total<?= $sm['id_detail_da']; ?>" readonly  value="0" disabled>
                                </td>
                            </tr>

                            <script> 
                           
                                $(document).ready(function() { 
                                    var klik<?= $sm['id_detail_da']; ?>='';
                                    var jumlahsisa<?= $sm['id_detail_da']; ?>=<?=$sisa;?>;


                                    $("#id"+<?= $sm['id_detail_da']; ?>).click(function() 
                                    { 
                                       
                                        if(klik<?= $sm['id_detail_da']; ?>=='1'+<?= $sm['id_detail_da']; ?>)
                                        {
                                            //input total
                                            nilai=$('#total'+<?= $sm['id_detail_da']; ?>).val();

                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).prop("disabled", true);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).prop("disabled", true);
                                            // $('#hargainput'+$sm['id_detail_da']; ?>).prop("disabled", true);

                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val('0');
                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(0);
                                            // $('#hargainput'+$sm['id_detail_da']; ?>).val(<$sm['harga']; ?>);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                                                    
                                           
                                            
                                            ubahobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,0,0);
                                            
                                            klik<?= $sm['id_detail_da']; ?>='2'+<?= $sm['id_detail_da']; ?>;
                                           
                                        }
                                        else
                                        {
                                           
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).prop("disabled", false);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).prop("disabled", false);
                                            // $('#hargainput'+$sm['id_detail_da']; ?>).prop("disabled", false);
                                                
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val('1');

                                            harga=<?= $sm['harga_input']; ?>;
                                          
                                            jumlah=$('#jumlah'+<?= $sm['id_detail_da']; ?>).val();
                                            total=jumlah*parseFloat(harga);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(total);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            simpanobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,jumlah,total);

                                            klik<?= $sm['id_detail_da']; ?>='1'+<?= $sm['id_detail_da']; ?>;
                                            
                                        }

                                        totalsemua();
                                        
                                    }); 


                                    $("#jumlah"+<?= $sm['id_detail_da']; ?>).change(function()
                                    {
                                        if( $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val('1');
                                        }
                                        else if( $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()>jumlahsisa<?= $sm['id_detail_da']; ?>)
                                        {
                                            alert("Jumlah tidak diizinkan");
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val($('#jumlah'+<?= $sm['id_detail_da']; ?>).val()-1);
                                        }
                                        else
                                        {
                                            nilai=$('#total'+<?= $sm['id_detail_da']; ?>).val();

                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            harga=<?= $sm['harga_input']; ?>;
                                          
                                            jumlah=$('#jumlah'+<?= $sm['id_detail_da']; ?>).val();
                                            total=jumlah*parseFloat(harga);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(total);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: true});
                                            
                                            ubahobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,jumlah,total);
                                        }

                                        totalsemua();

                                    });

                                    $("#jumlah"+<?= $sm['id_detail_da']; ?>).bind('keyup changed', function () 
                                    {
                                        if( $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val('1');
                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(<?= $sm['harga_input']; ?>);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            
                                            harga=<?= $sm['harga_input']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_detail_da']; ?>).val();
                                            total=jumlah*parseFloat(harga);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(total);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            ubahobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,jumlah,total);

                                        }
                                        else if( $('#jumlah'+<?= $sm['id_detail_da']; ?>).val()>jumlahsisa<?= $sm['id_detail_da']; ?>)
                                        {
                                            alert("Jumlah tidak diizinkan");
                                            $('#jumlah'+<?= $sm['id_detail_da']; ?>).val($('#jumlah'+<?= $sm['id_detail_da']; ?>).val()-1);
                                            
                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(<?= $sm['harga_input']; ?>);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            
                                            harga=<?= $sm['harga_input']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_detail_da']; ?>).val();
                                            total=jumlah*parseFloat(harga);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(total);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            ubahobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,jumlah,total);

                                        }
                                        else
                                        {

                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            harga=<?= $sm['harga_input']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_detail_da']; ?>).val();
                                            total=jumlah*parseFloat(harga);

                                            $('#total'+<?= $sm['id_detail_da']; ?>).val(total);
                                            $('#total'+<?= $sm['id_detail_da']; ?>).mask("#,###,###,###,###", {reverse: true});
                                            
                                            ubahobjek(<?= $sm['id_detail_da']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['harga_input']; ?>,jumlah,total);
                                        }

                                        totalsemua();
                                      
                                    });
                                    

                                }); 

                               
                            </script> 

                            <?php endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input class="form-control" name="total" id="totalharga" placeholder="Total Harga"/>            
                </div>
                
                <br>
                <table width="100%">
                    <tr>
                        <td width="90%">
                            <textarea style="width:550px; display:none;" name="jsondata" id="jsondata"></textarea>
                        </td>
                        <td>
                            <button disabled type="button" class="btn btn-success pull-right" id="buttonjson">Selesai</button>
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

<br>
<br>
<script>

    var totaltes=0;


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',hargasatuan,hargada,jumlah,total)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',hargasatuan:''+hargasatuan+'', hargada:''+hargada+'', jumlah:''+jumlah+'',total:''+total+''};  
        totaltes+=total;   
        console.log(data);                             
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',hargasatuan,hargada,jumlah,total)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',hargasatuan:''+hargasatuan+'', hargada:''+hargada+'', jumlah:''+jumlah+'',total:''+total+''};  
            }
            
        });

        console.log(data);

    }

    

</script>


<script>

    function totalsemua()
    {
        totaltes=0;

        $.each(data, function(key, value) {
          
            totaltes+=parseFloat(value["total"]);
        });

        $('#totalharga').mask("#,###,###,###,###", {reverse: false});
        $('#totalharga').val(totaltes);
        $('#totalharga').mask("#,###,###,###,###", {reverse: true});

       

        if($('#totalharga').val()==0)
        {
            $('#buttonjson').prop("disabled",true);
        }
        else
        {
            $('#buttonjson').prop("disabled",false);
        }

    }

    $("#buttonjson").click(function() 
    { 
        datafix=JSON.stringify(data);
        $('#jsondata').val(datafix);
        $('#buttonjson').prop("disabled",true);
        $('#buttonsimpan').prop("disabled",false);
    });
   

</script>



<script>
   
    $(function(){
        $(".selectpicker").select2();
    });



</script>


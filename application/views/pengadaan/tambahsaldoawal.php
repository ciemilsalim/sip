<?php
if($this->uri->segment(3)!='')
{
    $id_rka=$this->uri->segment(3);
}
else
{
    $id_rka='';
}
?>

<script>
    var i=0;
    var data=[];
    var dataobj=[];
    var regex = /[.,\s]/g;
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">

     
<script>
    $(function()
    {
       $("select").prop('required',true);
    });
</script>

            <form action="<?= base_url('Pengadaan/simpansaldoawal'); ?>" method="POST">

                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <table width="100%">

                    
                    <div class="form-group">
                       Tahun<br>
                       <input type="text" class="form-control" name="tahun" value="<?=$aktif['tahun']?>" readonly/>
                    </div>

                    <div class="form-group">
                       Bulan<br>
                       <input type="text" class="form-control" name="bulan" value="<?=$aktif['bulan']?>"  readonly/>
                    </div>


                    <div class="form-group">
                       Sumber Dana<br>
                       <select name="sumber" id="sumber" class="selectpicker" style="width:100%;">
                                <option value="">--Pilih Sumber Dana--</option>
                                    <?php foreach ($sumber as $r) : ?>
                                    <option value="<?= $r['kd_sumber']; ?>"><?= $r['nama_sumber']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                       
                    </table>
                </div>

                    <br>
                    <label style="text-decoration:underline">Detail Saldo Awal</label>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian Komponen</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Maksimal</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Action</th>
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
                                <td><?= number_format($sm['harga']); ?></td>
                                <td><input type="text" style="width:150px; padding:10px;" id="hargainput<?= $sm['id_uraian']; ?>"  value="<?= number_format($sm['harga']); ?>" disabled></td>
                                <td>
                                    <input type="checkbox" id="id<?= $sm['id_uraian']; ?>"  value="<?= $sm['id_uraian']; ?>" >
                                    <input type="number" style="width:100px; padding:10px;" id="jumlah<?= $sm['id_uraian']; ?>"  value="0" disabled>
                                    <input type="text" style="width:150px; padding:10px;" id="total<?= $sm['id_uraian']; ?>" readonly  value="0" disabled>
                                </td>
                            </tr>

                            <script> 
                           
                                $(document).ready(function() { 
                                    var klik<?= $sm['id_uraian']; ?>='';


                                    $("#id"+<?= $sm['id_uraian']; ?>).click(function() 
                                    { 
                                       
                                        if(klik<?= $sm['id_uraian']; ?>=='1'+<?= $sm['id_uraian']; ?>)
                                        {
                                            //input total
                                            nilai=$('#total'+<?= $sm['id_uraian']; ?>).val();

                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).prop("disabled", true);
                                            $('#total'+<?= $sm['id_uraian']; ?>).prop("disabled", true);
                                            $('#hargainput'+<?= $sm['id_uraian']; ?>).prop("disabled", true);

                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('0');
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(0);
                                            $('#hargainput'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                                                    
                                            
                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                           
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*parseFloat(hargainput);

                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,0,0)
                                            
                                            klik<?= $sm['id_uraian']; ?>='2'+<?= $sm['id_uraian']; ?>;
                                           
                                        }
                                        else
                                        {
                                           
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).prop("disabled", false);
                                            $('#total'+<?= $sm['id_uraian']; ?>).prop("disabled", false);
                                            $('#hargainput'+<?= $sm['id_uraian']; ?>).prop("disabled", false);
                                                
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('1');

                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                            
                                          
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*parseFloat(hargainput);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            simpanobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);

                                            klik<?= $sm['id_uraian']; ?>='1'+<?= $sm['id_uraian']; ?>;
                                            
                                        }

                                        totalsemua();
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                        
                                    }); 


                                
                                    $("#jumlah"+<?= $sm['id_uraian']; ?>).change(function()
                                    {
                                        if( $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('1');
                                        }
                                        else
                                        {
                                            nilai=$('#total'+<?= $sm['id_uraian']; ?>).val();

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                     

                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*parseFloat(hargainput);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});
                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);
                                        }

                                        totalsemua();
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                    });

                                    //change input 
                                    $("#jumlah"+<?= $sm['id_uraian']; ?>).bind('keyup changed', function () 
                                    {
                                        if( $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('1');
                                            $('#hargainput'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            
                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();

                                            total=jumlah*parseFloat(hargainput);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);

                                        }
                                        else
                                        {

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                     

                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*parseFloat(hargainput);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});
                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);
                                        }

                                        totalsemua();
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});
                                                
                                    });


                                     //change input 
                                     $("#hargainput"+<?= $sm['id_uraian']; ?>).bind('keyup changed', function () 
                                    {
                                        z=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                        input=Number(z.replace(/[^0-9.-]+/g,""));
                                        
                                        if( input > <?= $sm['harga']; ?>)
                                        {
                                            alert("Maaf, harga melebihi harga maksimal");
                                            $('#hargainput'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            
                                            x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                            hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            
                                            total=jumlah*parseFloat(hargainput);
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);

                                        }
                                        else
                                        {
                                            if( $('#hargainput'+<?= $sm['id_uraian']; ?>).val()==-1 || $('#hargainput'+<?= $sm['id_uraian']; ?>).val()==0)
                                            {
                                                alert("Jumlah tidak valid");
                                                
                                                $('#hargainput'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);
                                                $('#total'+<?= $sm['id_uraian']; ?>).val(<?= $sm['harga']; ?>);

                                                $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                
                                                x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                                hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                                jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                                
                                                total=jumlah*parseFloat(hargainput);
                                                $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                                $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);

                                            }
                                            else
                                            {

                                                $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});

                                                x=$('#hargainput'+<?= $sm['id_uraian']; ?>).val();
                                                hargainput=Number(x.replace(/[^0-9.-]+/g,""));
                                        

                                                jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                                total=jumlah*parseFloat(hargainput);
                                                $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                                $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});
                                                
                                                ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,hargainput,jumlah,total);
                                            }

                                        }

                                        totalsemua();
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                        $('#hargainput'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});
                                                
                                                
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

    var totaltes=0;


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,hargainput,jumlah,total)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', hargainput:''+hargainput+'', jumlah:''+jumlah+'',total:''+total+''};  
        totaltes+=total;                                
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,hargainput,jumlah,total)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', hargainput:''+hargainput+'', jumlah:''+jumlah+'',total:''+total+''};  
            }
            
        });

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

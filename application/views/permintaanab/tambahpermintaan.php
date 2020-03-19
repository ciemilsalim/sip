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


<script>

    var totaltes=0;

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#pembelian').on('change', function() 
    {
        beli=$('#pembelian').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihpembelian/"+beli;
    });


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total,kdsumber)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+'',kdsumber:''+kdsumber+''};  
        totaltes+=total;                                
        // console.log(data);
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total,kdsumber)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+'',kdsumber:''+kdsumber+''};  
                // console.log(data);
            }
            
        });

    }

    function totalsemua()
    {
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

    

</script>

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
                    

            <form action="<?= base_url('Permintaanab/index'); ?>" method="POST">

                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Permintaan</label>
                    <table width="100%">
                        <tr>
                            <td style="padding:10px;">
                                <label >Kode Permintaan</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="kd" name="kd" value="<?php if(isset($kd)) { echo $kd; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" value="<?php if(isset($bidang)) { echo $bidang['nama_bidang']; } ?>" readonly>
                                <input type="text" class="form-control" id="kd_bidang" name="kd_bidang" style="display:none" value="<?php if(isset($bidang)) { echo $bidang['kd_bid_skpd']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Kepala Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_k_bidang" name="nama_k_bidang" value="<?php if(isset($kbidang)) { echo $kbidang['nama']; } ?>"  readonly>
                                <input type="text" class="form-control" id="kd_k_bidang" name="kd_k_bidang" style="display:none" value="<?php if(isset($kbidang)) { echo $kbidang['kd_kep_bid_skpd']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>NIP Kepala Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php if(isset($kbidang)) { echo $kbidang['nip']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Admin</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_admin" name="nama_admin" value="<?php if(isset($admin)) { echo $admin['nama']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Tanggal Permintaan</label>
                            </td>
                            <td width="60%">
                                <input type="date" class="form-control" id="tgl_permintaan" name="tgl_permintaan" value="<?php echo date('Y-m-d');?>">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Tujuan Penggunaan</label>
                            </td>
                            <td width="60%">
                                <textarea class="form-control" id="tujuan" name="tujuan"></textarea>
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
                            <th scope="col">Saldo</th>
                            <th scope="col">Sumber Dana</th>
                            <th scope="col">Jumlah Permintaan</th>
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
                                <td><?= number_format($sm['harga_satuan_da']);; ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <td><?= $sm['nama_sumber']; ?></td>
                                <td>
                                    <input type="checkbox" id="id<?= $sm['id_saldo']; ?>"  value="<?= $sm['id_saldo']; ?>" >
                                    <input type="number" style="width:100px; padding:10px;" id="jumlah<?= $sm['id_saldo']; ?>"  value="0" disabled>
                                    <input type="text" style="width:150px; padding:10px;" id="total<?= $sm['id_saldo']; ?>" readonly  value="0" disabled>
                                </td>
                            </tr>

                            <script> 

                                var klik<?= $sm['id_saldo']; ?>='';
                                //otomatis dipanggil
                                if((<?= $sm['jumlah']; ?>)!=0)
                                {
                                            
                                }
                                else
                                {
                                    $("#id"+<?= $sm['id_saldo']; ?>).prop('checked', false);
                                    $("#id"+<?= $sm['id_saldo']; ?>).prop("disabled",true);
                                    $('#jumlah'+<?= $sm['id_saldo']; ?>).prop("disabled",true);
                                    $('#total'+<?= $sm['id_saldo']; ?>).prop("disabled", true);                
                                    $('#jumlah'+<?= $sm['id_saldo']; ?>).val(0);
                                    $('#total'+<?= $sm['id_saldo']; ?>).val(0);
                                }

                                totalsemua();

                           
                                $(document).ready(function() { 
                                    

                                    $("#id"+<?= $sm['id_saldo']; ?>).click(function() 
                                    { 
                                       
                                        if(klik<?= $sm['id_saldo']; ?>=='1'+<?= $sm['id_saldo']; ?>)
                                        {
                                            //input total
                                            nilai=$('#total'+<?= $sm['id_saldo']; ?>).val();

                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).prop("disabled", true);
                                            $('#total'+<?= $sm['id_saldo']; ?>).prop("disabled", true);

                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).val('0');
                                            $('#total'+<?= $sm['id_saldo']; ?>).val(0);
                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            harga=<?= $sm['harga_satuan_da']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                            total=jumlah*harga;

                                            //kurang tambah total
                                            nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                            if(nilait>total)
                                            {
                                                totaltes-=nilait;
                                            }
                                       

                                            ubahobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,0,0,<?= $sm['kd_sumber']; ?>)
                                            
                                            klik<?= $sm['id_saldo']; ?>='2'+<?= $sm['id_saldo']; ?>;
                                        }
                                        else
                                        {
                                           
                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).prop("disabled", false);
                                            $('#total'+<?= $sm['id_saldo']; ?>).prop("disabled", false);
                                                
                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).val('1');
                                            harga=<?= $sm['harga_satuan_da']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_saldo']; ?>).val(total);
                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            simpanobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,jumlah,total,<?= $sm['kd_sumber']; ?>);

                                            klik<?= $sm['id_saldo']; ?>='1'+<?= $sm['id_saldo']; ?>;
                                            
                                        }

                                        totalsemua();

                                    }); 
                                
                                    $("#jumlah"+<?= $sm['id_saldo']; ?>).change(function()
                                    {
                                        if( $('#jumlah'+<?= $sm['id_saldo']; ?>).val() > <?= $sm['jumlah']; ?>)
                                        {
                                            alert('Maaf, jumlah permintaan lebih dari jumlah saldo persediaan');
                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).val($('#jumlah'+<?= $sm['id_saldo']; ?>).val()-1);
                                        }
                                        else
                                        {
                                                if( $('#jumlah'+<?= $sm['id_saldo']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_saldo']; ?>).val()==0)
                                                {
                                                    alert("Jumlah tidak valid");
                                                    $('#jumlah'+<?= $sm['id_saldo']; ?>).val('1');
                                                }
                                                else
                                                {
                                                    nilai=$('#total'+<?= $sm['id_saldo']; ?>).val();

                                                    $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                    harga=<?= $sm['harga_satuan_da']; ?>;
                                                    jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                                    total=jumlah*harga;
                                                    $('#total'+<?= $sm['id_saldo']; ?>).val(total);
                                                    $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
                                                    //kurang tambah total
                                                    nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                                    if(nilait>total)
                                                    {
                                                        totaltes-=harga;
                                                    }
                                                    else
                                                    {
                                                        totaltes+=harga;
                                                    }

                                                    
                                                    ubahobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,jumlah,total,<?= $sm['kd_sumber']; ?>);
                                                }

                                                totalsemua();
                                        }

                                    });



                                    //change input 
                                    $("#jumlah"+<?= $sm['id_saldo']; ?>).bind('keyup mouseup', function () 
                                    {
                                        if( $('#jumlah'+<?= $sm['id_saldo']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_saldo']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).val('1');
                                            
                                            nilai=$('#total'+<?= $sm['id_saldo']; ?>).val('1');

                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga_satuan_da']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_saldo']; ?>).val(total);
                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
                                            //kurang tambah total
                                            nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                            if(nilait>total)
                                            {
                                                totaltes-=harga;
                                            }
                                            else
                                            {
                                                totaltes+=harga;
                                            }

                                                    
                                            ubahobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,jumlah,total,<?= $sm['kd_sumber']; ?>);
                                            
                                            totalsemua();
                                        }
                                        else if( $('#jumlah'+<?= $sm['id_saldo']; ?>).val() > <?= $sm['jumlah']; ?>)
                                        {
                                            alert('Maaf, jumlah permintaan lebih dari jumlah saldo persediaan');
                                            $('#jumlah'+<?= $sm['id_saldo']; ?>).val(<?= $sm['jumlah']; ?>);
                                            
                                            nilai=$('#total'+<?= $sm['id_saldo']; ?>).val();

                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga_satuan_da']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_saldo']; ?>).val(total);
                                            $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
                                            //kurang tambah total
                                            nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                            if(nilait>total)
                                            {
                                                totaltes-=harga;
                                            }
                                            else
                                            {
                                                totaltes+=harga;
                                            }

                                                    
                                            ubahobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,jumlah,total,<?= $sm['kd_sumber']; ?>);
                                            
                                            totalsemua();
                                        }
                                        else
                                        {
                                                // if( $('#jumlah'+//= $sm['id_saldo']; ?>).val()==-1 || $('#jumlah'+//= $sm['id_saldo']; ?>).val()==0)
                                                // {
                                                //     alert("Jumlah tidak valid");
                                                //     $('#jumlah'+//= $sm['id_saldo']; ?>).val('1');
                                                // }
                                                // else
                                                // {
                                                    nilai=$('#total'+<?= $sm['id_saldo']; ?>).val();

                                                    $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                    harga=<?= $sm['harga_satuan_da']; ?>;
                                                    jumlah=$('#jumlah'+<?= $sm['id_saldo']; ?>).val();
                                                    total=jumlah*harga;
                                                    $('#total'+<?= $sm['id_saldo']; ?>).val(total);
                                                    $('#total'+<?= $sm['id_saldo']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
                                                    //kurang tambah total
                                                    nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                                    if(nilait>total)
                                                    {
                                                        totaltes-=harga;
                                                    }
                                                    else
                                                    {
                                                        totaltes+=harga;
                                                    }

                                                    
                                                    ubahobjek(<?= $sm['id_saldo']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan_da']; ?>,jumlah,total,<?= $sm['kd_sumber']; ?>);
                                                // }

                                                totalsemua();
                                        }           
                                    });


                                }); 

                               

                            </script> 

                            <?php endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->

                <br>
                <div style="10px solid grey; background-color:#e9d8d8; padding:10px; display:none">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input class="form-control" name="total" id="totalharga" placeholder="Total Harga"/>            
                </div>
                
                <br>
                <table width="100%">
                    <tr>
                        <td width="80%">
                            <textarea style="width:550px; display:none;" name="jsondata" id="jsondata"></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success pull-right" id="buttonjson" disabled>Selesai</button>
                        </td>
                        <td>
                            <button disabled type="submit" class="btn btn-primary pull-right" id="buttonsimpan">Kirim Permintaan</button>
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
    $("#buttonjson").click(function() 
    { 
        datafix=JSON.stringify(data);
        $('#jsondata').val(datafix);
        $('#buttonjson').prop("disabled",true);
        $('#buttonsimpan').prop("disabled",false);
    });
</script>


<?php
$jumlahsemua=0;

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
    //parameter untuk menolak permintaan
    var datano=[];
</script>

<script>

    var totaltes=0;


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total,tahunpengadaan,kdpengadaan)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+'',tahunpengadaan:''+tahunpengadaan+'',kdpengadaan:''+kdpengadaan+''};    
        totaltes+=total;                                
        // console.log(data);
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total,tahunpengadaan,kdpengadaan)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+'',tahunpengadaan:''+tahunpengadaan+'',kdpengadaan:''+kdpengadaan+''};   
                // console.log(data);
            }
            
        });

    }

    

</script>


<script>

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
    <a href="<?=base_url('Permintaankb/pengajuan') ?>" class="badge badge-success" width="100%">Kembali</a>
    <br>

    
    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= form_error('detail', '<div class = "alert alert-danger" role="alert">', '</div>');?>
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
                    

            <form action="<?= base_url('Permintaankb/detailpermintaan'); ?>" method="POST">

                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Permintaan</label>
                    <table width="100%">
                    <tr>
                            <td style="padding:10px;">
                                <label >Kode Permintaan</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="kd" name="kd" value="<?php if(isset($permintaan)) { echo $permintaan['kd_permintaan']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" value="<?php if(isset($permintaan)) { echo $permintaan['nama_bidang']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Kepala Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_k_bidang" name="nama_k_bidang" value="<?php if(isset($permintaan)) { echo $permintaan['nama_kep_bid_skpd']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>NIP Kepala Bidang</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php if(isset($permintaan)) { echo $permintaan['nip']; } ?>"  readonly>
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Admin</label>
                            </td>
                            <td width="60%">
                                <input type="text" class="form-control" id="nama_admin" name="nama_admin" value="<?php if(isset($permintaan)) { echo $permintaan['nama_admin']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label>Tanggal Permintaan</label>
                            </td>
                            <td width="60%">
                                <input type="date" class="form-control" id="tgl_permintaan" name="tgl_permintaan" value="<?php if(isset($permintaan)) { echo $permintaan['tgl_permintaan']; } ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;">
                                <label >Tujuan Penggunaan</label>
                            </td>
                            <td width="60%">
                                <textarea class="form-control" id="tujuan" name="tujuan" readonly><?php if(isset($permintaan)) { echo $permintaan['tujuan_penggunaan']; } ?></textarea>
                            </td>
                        </tr>

                    </table>
                </div>

                    <br>
                    <label style="text-decoration:underline">Detail Komponen</label>
                    
                    <br>
                    <input type="radio" id="pilih" name="pilih" value="y" checked/> Setujui Semua Permintaan 
                    <input style="margin-left:20px;" type="radio" id="pilih" value="c" name="pilih" /> Custom
                    <input style="margin-left:20px;" type="radio" id="pilih" value="n" name="pilih"/ > Tolak Semua Permintaan

                    <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uraian Komponen</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah Permintaan</th>
                            <th scope="col">Saldo</th>
                            <!-- <th scope="col">Sumber Dana</th> -->
                            <th scope="col">Persetujuan Kepala Bidang</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                        <?php   if (isset($detailpermintaan)) 
                        {
                            foreach ($detailpermintaan as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['uraian_komponen']; ?></td>
                                <td><?= $sm['satuan']; ?></td>
                                <td><?= number_format($sm['harga_satuan']);; ?></td>
                                <td><?= $sm['jumlah_permintaan']; ?></td>
                                <td><?= $sm['jumlah']; ?></td>
                                <!-- <td> $sm['nama_sumber']; ?></td> -->
                                <td>
                                    <input type="checkbox" id="id<?= $sm['id']; ?>"  value="<?= $sm['id']; ?>" >
                                    <input type="number" style="width:100px; padding:10px;" id="jumlah<?= $sm['id']; ?>"  value="0" disabled>
                                    <input type="text" style="width:150px; padding:10px;" id="total<?= $sm['id']; ?>" readonly  value="0" disabled>
                                </td>
                            </tr>

                            <script> 
                                var klik<?= $sm['id']; ?>='';
                                //otomatis dipanggil
                                if((<?= $sm['jumlah']; ?>)!=0)
                                {
                                    $("#id"+<?= $sm['id']; ?>).prop('checked', true);
                                    $("#id"+<?= $sm['id']; ?>).prop("disabled",false);
                                    $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", false);
                                    $('#total'+<?= $sm['id']; ?>).prop("disabled", false);                
                                    if((<?= $sm['jumlah_permintaan']; ?>)>(<?= $sm['jumlah']; ?>))
                                    {
                                        $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah']; ?>);
                                        $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_total']; ?>);
                                        simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah']; ?>,<?= $sm['harga_total']; ?>,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                    }
                                    else
                                    {
                                        $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah_permintaan']; ?>);
                                        $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_permintaan']; ?>);
                                        simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah_permintaan']; ?>,<?= $sm['harga_permintaan']; ?>,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                    }

                                    $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});
                                }
                                else
                                {
                                    $("#id"+<?= $sm['id']; ?>).prop('checked', false);
                                    $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                                    $('#jumlah'+<?= $sm['id']; ?>).prop("disabled",true);
                                    $('#total'+<?= $sm['id']; ?>).prop("disabled", true);                
                                    $('#jumlah'+<?= $sm['id']; ?>).val(0);
                                    $('#total'+<?= $sm['id']; ?>).val(0);
                                }

                                totalsemua();

                                
                           
                                $(document).ready(function() { 
                                    klik<?= $sm['id']; ?>='1'+<?= $sm['id']; ?>;
                                    
                                    $("#id"+<?= $sm['id']; ?>).click(function() 
                                    { 
                                       
                                        if(klik<?= $sm['id']; ?>=='1'+<?= $sm['id']; ?>)
                                        {
                                           
                                            //input total
                                            nilai=$('#total'+<?= $sm['id']; ?>).val();

                                            $("#id"+<?= $sm['id']; ?>).prop("disabled",false);
                                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", true);
                                            $('#total'+<?= $sm['id']; ?>).prop("disabled", true);

                                            $('#jumlah'+<?= $sm['id']; ?>).val('0');
                                            $('#total'+<?= $sm['id']; ?>).val(0);
                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            harga=<?= $sm['harga_satuan']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                            total=jumlah*harga;

                                            //kurang tambah total
                                            nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                            if(nilait>total)
                                            {
                                                totaltes-=nilait;
                                            }
                                       

                                            ubahobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,0,0,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                            
                                            klik<?= $sm['id']; ?>='2'+<?= $sm['id']; ?>;
                                        }
                                        else
                                        {
                                            $("#id"+<?= $sm['id']; ?>).prop("disabled",false);
                                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", false);
                                            $('#total'+<?= $sm['id']; ?>).prop("disabled", false);
                                                
                                            $('#jumlah'+<?= $sm['id']; ?>).val('1');
                                            harga=<?= $sm['harga_satuan']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id']; ?>).val(total);
                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,jumlah,total,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);

                                            klik<?= $sm['id']; ?>='1'+<?= $sm['id']; ?>;
                                            
                                        }

                                        totalsemua();

                                    }); 
                                
                                    $("#jumlah"+<?= $sm['id']; ?>).change(function()
                                    {
                                        if( $('#jumlah'+<?= $sm['id']; ?>).val() > <?= $sm['jumlah']; ?>)
                                        {
                                            alert('Maaf, jumlah permintaan lebih dari jumlah saldo persediaan');
                                            $('#jumlah'+<?= $sm['id']; ?>).val($('#jumlah'+<?= $sm['id']; ?>).val()-1);
                                        }
                                        else
                                        {
                                                if( $('#jumlah'+<?= $sm['id']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id']; ?>).val()==0)
                                                {
                                                    alert("Jumlah tidak valid");
                                                    $('#jumlah'+<?= $sm['id']; ?>).val('1');
                                                }
                                                else
                                                {
                                                    nilai=$('#total'+<?= $sm['id']; ?>).val();

                                                    $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                    harga=<?= $sm['harga_satuan']; ?>;
                                                    jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                                    total=jumlah*harga;
                                                    $('#total'+<?= $sm['id']; ?>).val(total);
                                                    $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
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

                                                    
                                                    ubahobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,jumlah,total,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                                }

                                                totalsemua();
                                        }

                                    });



                                    //change input 
                                    $("#jumlah"+<?= $sm['id']; ?>).bind('keyup mouseup', function () 
                                    {
                                        if( $('#jumlah'+<?= $sm['id']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id']; ?>).val('1');
                                            
                                            nilai=$('#total'+<?= $sm['id']; ?>).val('1');

                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga_satuan']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id']; ?>).val(total);
                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
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

                                                    
                                            ubahobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,jumlah,total,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                            
                                            totalsemua();
                                        }
                                        else if( $('#jumlah'+<?= $sm['id']; ?>).val() > <?= $sm['jumlah']; ?>)
                                        {
                                            alert('Maaf, jumlah permintaan lebih dari jumlah saldo persediaan');
                                            $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah']; ?>);
                                            
                                            nilai=$('#total'+<?= $sm['id']; ?>).val();

                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga_satuan']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id']; ?>).val(total);
                                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
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

                                                    
                                            ubahobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,jumlah,total,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                            
                                            totalsemua();
                                        }
                                        else
                                        {
                                              
                                                    nilai=$('#total'+<?= $sm['id']; ?>).val();

                                                    $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: false});
                                                    harga=<?= $sm['harga_satuan']; ?>;
                                                    jumlah=$('#jumlah'+<?= $sm['id']; ?>).val();
                                                    total=jumlah*harga;
                                                    $('#total'+<?= $sm['id']; ?>).val(total);
                                                    $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                                                    
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

                                                    
                                                    ubahobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,jumlah,total,<?= $sm['tahun_pengadaan']; ?>,<?= $sm['kd_pengadaan']; ?>);
                                                

                                                totalsemua();
                                        }           
                                    });



                                }); 
                  

                            </script> 

                            <?php 
                                $jumlahsemua+=$sm['harga_permintaan'];
                            endforeach; } ?>
                    </tbody>

                    </table>
                </div> <!--table -->

                <br>
                <!-- <div style="10px solid grey; background-color:#e9d8d8; padding:10px; display:none">
                    <label style="text-decoration:underline">Total Harga</label>
                    <input readonly class="form-control" name="total" id="totalharga" placeholder="Total Harga" value=""/>            
                </div> -->
                
                <br>
                <table width="100%">
                    <tr>
                        <td width="80%">
                            <textarea style="width:550px; display:none;" name="jsondata" id="jsondata"></textarea>
                            <textarea style="width:550px; display:none;" name="jsondatano" id="jsondatano"></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success pull-right" id="buttonjson">Selesai</button>
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
   
    $('#totalharga').val(totaltes);
    $('#totalharga').mask("#,###,###,###,###", {reverse: true});
    var totaltotal=totaltes;
    datano='NO';

    if($('input[name=pilih]:checked').val() == "y") 
    {
                <?php  
                    if (isset($detailpermintaan)) 
                    {
                        foreach ($detailpermintaan as $sm) : 
                    ?>
                        $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                        $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", true);
                        $('#total'+<?= $sm['id']; ?>).prop("disabled", true);

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
                i=0;
                data=[];
               
                <?php
                if (isset($detailpermintaan)) 
                {
                    $hitungtotal=0;
                foreach ($detailpermintaan as $sm) : 
                    ?>

                        if((<?= $sm['jumlah']; ?>)!=0)
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', true);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", true);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled",true);                
                            
                            if((<?= $sm['jumlah_permintaan']; ?>)>(<?= $sm['jumlah']; ?>))
                            {
                                $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah']; ?>);
                                $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_total']; ?>);
                                simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah']; ?>,<?= $sm['harga_total']; ?>);
                            }
                            else
                            {
                                $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah_permintaan']; ?>);
                                $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_permintaan']; ?>);
                                simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah_permintaan']; ?>,<?= $sm['harga_permintaan']; ?>);
                            }

                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});


                            
                        }
                        else
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', false);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled", true);                
                            $('#jumlah'+<?= $sm['id']; ?>).val(0);
                            $('#total'+<?= $sm['id']; ?>).val(0);
                        }

                    <?php
                    endforeach; }
                ?>

                $('#totalharga').mask("#,###,###,###,###", {reverse: false});
                $('#totalharga').val(totaltotal);
                $('#buttonjson').prop("disabled",false);
                $('#totalharga').mask("#,###,###,###,###", {reverse: true});
                totaltes=totaltotal;
                datano='NO';
         
            }
            else if ($('input[name=pilih]:checked').val() == "c")  
            {
                i=0;
                data=[];

                <?php
                if (isset($detailpermintaan)) 
                {
                foreach ($detailpermintaan as $sm) : 
                    ?>

                        if((<?= $sm['jumlah']; ?>)!=0)
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', true);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",false);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled", false);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled", false);                
                            
                            if((<?= $sm['jumlah_permintaan']; ?>)>(<?= $sm['jumlah']; ?>))
                            {
                                $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah']; ?>);
                                $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_total']; ?>);
                                simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah']; ?>,<?= $sm['harga_total']; ?>);
                            }
                            else
                            {
                                $('#jumlah'+<?= $sm['id']; ?>).val(<?= $sm['jumlah_permintaan']; ?>);
                                $('#total'+<?= $sm['id']; ?>).val(<?= $sm['harga_permintaan']; ?>);
                                simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah_permintaan']; ?>,<?= $sm['harga_permintaan']; ?>);
                            }

                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});

                            
                        }
                        else
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', false);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled", true);                
                            $('#jumlah'+<?= $sm['id']; ?>).val(0);
                            $('#total'+<?= $sm['id']; ?>).val(0);
                        }

                    <?php
                    endforeach; }
                ?>
                
                $('#totalharga').mask("#,###,###,###,###", {reverse: false});
                $('#totalharga').val(totaltotal);
                $('#buttonjson').prop("disabled",false);
                $('#totalharga').mask("#,###,###,###,###", {reverse: true});
                totaltes=totaltotal;
                datano='NO';

            }
            else if ($('input[name=pilih]:checked').val() == "n")  
            {
                
                totaltes=totaltotal;

                <?php
                if (isset($detailpermintaan)) 
                {
                foreach ($detailpermintaan as $sm) : 
                    ?>

                        if((<?= $sm['jumlah']; ?>)!=0)
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', false);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled", true);                
                            $('#jumlah'+<?= $sm['id']; ?>).val(0);
                            $('#total'+<?= $sm['id']; ?>).val(0);
                            $('#total'+<?= $sm['id']; ?>).mask("#,###,###,###,###", {reverse: true});
                            simpanobjek(<?= $sm['id']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga_satuan']; ?>,<?= $sm['jumlah_permintaan']; ?>,<?= $sm['harga_permintaan']; ?>);
                        }
                        else
                        {
                            $("#id"+<?= $sm['id']; ?>).prop('checked', false);
                            $("#id"+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#jumlah'+<?= $sm['id']; ?>).prop("disabled",true);
                            $('#total'+<?= $sm['id']; ?>).prop("disabled", true);                
                            $('#jumlah'+<?= $sm['id']; ?>).val(0);
                            $('#total'+<?= $sm['id']; ?>).val(0);

                        }

                    <?php
                    endforeach; }
                ?>

                $('#totalharga').val(0);
                $('#buttonjson').prop("disabled",false);
                $('#totalharga').mask("#,###,###,###,###", {reverse: false});

                //parameter untuk menolak permintaan
                datano='YES';
                i=0;
                data=[];
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

        // console.log(datano);
    });
</script>




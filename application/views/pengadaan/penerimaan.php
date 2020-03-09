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
                        <table width="80%">
                        <tr>
                        <td width="20%"><label >Kode Pengadaan</label></td>
                        <td> <select name="pembelian" id="pembelian" class="form-control">

                            <?PHP
                                if($kd_pengadaan!='')
                                {
                                    ?>
                                    
                                            <option value="<?= $kd_pengadaan; ?>" selected><?= $kd_pengadaan; ?></option>
                                            <?php
                                            if(isset($pembelian))
                                            {
                                                    foreach ($pembelian as $r) : 
                                                    if($r['kd_pengadaan']==$kd_pengadaan)
                                                        continue;
                                                    else
                                                    {
                                                    ?>
                                                    <option value="<?= $r['kd_pengadaan']; ?>"><?= $r['kd_pengadaan']; ?></option>
                                            <?php  } endforeach; 
                                            } 
                                }
                                else
                                {
                            ?>

                                <option value="">-- Pilih Pengadaan --</option> 
                                <?php 
                                    if(isset($pembelian))
                                    {
                                            foreach ($pembelian as $r) : ?>
                                            <option value="<?= $r['kd_pengadaan']; ?>"><?= $r['kd_pengadaan']; ?></option>
                                    <?php endforeach; 
                                    } 
                                }
                                ?>
                            </select>
                            </td>
                        </tr>
                        </table>
                        
                        <br>

            <?php   if (isset($detil)) 
            {
            ?>

            <form action="<?= base_url('pengadaan/penerimaanbarang/'.$detil['kd_pengadaan']); ?>" method="POST">

                <div style="10px solid grey; background-color:#e9d8d8; padding:10px;">
                    <label style="text-decoration:underline">Detail Pengadaan</label>
                    <table width="100%">
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
                                <label>Uraian Pembelian</label>
                            </td>
                            <td width="60%">
                                <label >: <?php echo $detil['uraian_pembelian']; ?></label>
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
                                <td><?= number_format($sm['harga']);; ?></td>
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

                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('0');
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(0);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});

                                            harga=<?= $sm['harga']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*harga;

                                            //kurang tambah total
                                            nilait=Number(nilai.replace(/[^0-9.-]+/g,""));
                                            if(nilait>total)
                                            {
                                                totaltes-=nilait;
                                            }
                                       

                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,0,0)
                                            
                                            klik<?= $sm['id_uraian']; ?>='2'+<?= $sm['id_uraian']; ?>;
                                        }
                                        else
                                        {
                                           
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).prop("disabled", false);
                                            $('#total'+<?= $sm['id_uraian']; ?>).prop("disabled", false);
                                                
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('1');
                                            harga=<?= $sm['harga']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            simpanobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,jumlah,total);

                                            klik<?= $sm['id_uraian']; ?>='1'+<?= $sm['id_uraian']; ?>;
                                            
                                        }

                                        totalsemua();

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
                                            harga=<?= $sm['harga']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            
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

                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,jumlah,total);
                                        }

                                        totalsemua();

                                    });


                                    //change input 
                                    $("#jumlah"+<?= $sm['id_uraian']; ?>).bind('keyup mouseup', function () 
                                    {
                                        if( $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==-1 || $('#jumlah'+<?= $sm['id_uraian']; ?>).val()==0)
                                        {
                                            alert("Jumlah tidak valid");
                                            $('#jumlah'+<?= $sm['id_uraian']; ?>).val('1');

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            
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

                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,jumlah,total);
                                            
                                          
                                        }
                                        else
                                        {
                                            nilai=$('#total'+<?= $sm['id_uraian']; ?>).val();

                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: false});
                                            harga=<?= $sm['harga']; ?>;
                                            jumlah=$('#jumlah'+<?= $sm['id_uraian']; ?>).val();
                                            total=jumlah*harga;
                                            $('#total'+<?= $sm['id_uraian']; ?>).val(total);
                                            $('#total'+<?= $sm['id_uraian']; ?>).mask("#,###,###,###,###", {reverse: true});

                                            
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

                                            
                                            ubahobjek(<?= $sm['id_uraian']; ?>,<?= $sm['kd_jenis']; ?>,<?= $sm['kd_komponen']; ?>,<?= $sm['kd_uraian']; ?>,<?php echo json_encode($sm['uraian_komponen']); ?>,<?php echo json_encode($sm['satuan']); ?>,<?= $sm['harga']; ?>,jumlah,total);
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
                            <button type="button" class="btn btn-success pull-right" id="buttonjson">Selesai</button>
                        </td>
                        <td>
                            <button disabled type="submit" class="btn btn-primary pull-right" id="buttonsimpan">Simpan</button>
                        </td>
                    </tr>
                </table>

            </form>

        <?php } ?>     

                            
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>

    var totaltes=0;

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#pembelian').on('change', function() 
    {
        beli=$('#pembelian').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihpembelian/"+beli;
    });


    //simpan objek data
    function simpanobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total)
    {
        data[i++]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+''};  
        totaltes+=total;                                
        // console.log(data);
    }

    //ganti nilai objek data
    function ubahobjek(id,kd_jenis,kd_komponen,kd_uraian,uraian='',satuan='',harga,jumlah,total)
    {
        jQuery.each( data, function( i, val ) 
        {
            if(val.id==id)
            {
                data[i]={id:''+id+'',kd_jenis:''+kd_jenis+'',kd_komponen:''+kd_komponen+'',kd_uraian:''+kd_uraian+'',uraian:''+uraian+'',satuan:''+satuan+'',harga:''+harga+'', jumlah:''+jumlah+'',total:''+total+''};  
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

    $("#buttonjson").click(function() 
    { 
        datafix=JSON.stringify(data);
        $('#jsondata').val(datafix);
        $('#buttonjson').prop("disabled",true);
        $('#buttonsimpan').prop("disabled",false);
    });
   

</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('managemen', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>
            <div class="row">
            <div class="col-lg-12" style=" height:200px">
                <H3 style="text-align:center; font-weight:bold; padding:20px;">INFORMASI TA AKTIF</H3>
                <div class="row">
                    <?php
                    $tw='';

                    if(!empty($managementa))
                    {
                        
                        if(isset($managementa['tw']))
                        {
                            if($managementa['tw']==1)
                            {
                                $tw="I";
                            }
                            else if($managementa['tw']==2)
                            {
                                $tw="II";
                            }
                            else if($managementa['tw']==3)
                            {
                                $tw="III";
                            }
                            else if($managementa['tw']==4)
                            {
                                $tw="IV";
                            }
                        }
                    }
                    ?>
                    <div class="col-lg-6" style="text-align:center; padding:35px; background-color:#fefe7b; height:100px"><H4>TAHUN <label id="adatahun"><?php if(isset($managementa['tahun'])) { echo  $managementa['tahun']; }?></label></H4></div>
                    <div class="col-lg-6" style="text-align:center; padding:35px; background-color:#fefe7b; height:100px"><H4>TW <?=$tw?></H4></div>
                    <?php $id=0; 
                        if(isset($managementa['id'])) 
                        { 
                            $id=$managementa['id']; 
                        }; 
                    ?>
                    <a style="margin-top:20px; " id="nonaktif" onclick="return confirm('Yakin akan menonaktifkan?');" href="<?=base_url('Managemen/nonaktifta/'.$id); ?>" class="btn btn-danger">Nonaktif</a>
                <div class="row">
            </div>

            <div class="col-lg-12" style="height:350px">
                <H3 style="text-align:center; font-weight:bold; padding:20px;">SETTING TAHUN ANGGARAN</H3>
                <div class="row">
                        <div class="col-lg-12">
                            <form action="<?= base_url('managemen/managementa'); ?>" method="POST">
                                <div class="form-group">
                                    <select name="tahun" id="tahun" class="form-control">
                                        <option value="">--Pilih Tahun--</option>
                                        <?php 
                                        if(isset($ta))
                                        {
                                            foreach ($ta as $r=>$value) : ?>
                                            <option value="<?= $value['tahun']; ?>"><?= $value['tahun']; ?></option>
                                        <?php endforeach; }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tw" name="tw" placeholder="TW" value="" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <select name="tw" id="tw" class="form-control">
                                        <option value="">--Pilih TW--</option>
                                    </select>
                                </div> -->
                                <button type="submit" id="set" class="btn btn-primary">SET</button>
                            </form>
                        </div>
                </div>
            <div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<script>

    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#tahun').on('change', function() 
    {
        tahun=$('#tahun').val();

        // console.log(tahun);
      
        jQuery.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>managemen/ambiltw/"+tahun,
        dataType: "json",
            success: function(result)
            {
                $('#tw').val(parseInt(result)+1);

                if(result==4)
                {
                    $('#tw').val("1");
                }

                if(result==null)
                {
                    $('#tw').val("1");
                }

              
            },
            error: function() 
            {
                alert("Invalide!");
            }
        }); 
         
    });


    //jika tw aktif maka form setting tw nonaktif
    function nonaktif()
    {
        document.getElementById('tahun').disabled = true;
        document.getElementById('tw').disabled = true;
        document.getElementById('set').disabled = true;
    
        var link = document.getElementById('nonaktif'); 
        link.setAttribute("class", "btn btn-danger"); 
    }

    //sebaliknya
    function aktif()
    {
        document.getElementById('tahun').disabled = false;
        document.getElementById('tw').disabled = false;
        document.getElementById('set').disabled = false;

        var link = document.getElementById('nonaktif'); 
        link.setAttribute("class", "btn btn-danger disabled");  
      
    }

    $(document).ready(function(){
        
        if(($("#adatahun").html())!='')
        {
            nonaktif();
        }
        else
        {
            aktif()
        }
       
    });

   

    
</script>




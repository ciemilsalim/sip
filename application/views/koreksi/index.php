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
            <?= $this->session->flashdata('message'); ?>
            <form class="user" method="post" action="<?= base_url('Koreksi/index') ?>">
                <div class="form-group">
                    <select name="skpd" id="skpd" class="form-control">
                        <option value="">--Pilih SKPD--</option>
                            <?php foreach ($urusan as $u) : ?>
                                <option value="<?= $u['Kd_Urusan'].'#'.$u['Kd_Bidang'].'#'.$u['Kd_Unit'].'#'.$u['Kd_Sub'].'#'.$u['Nm_Sub_Unit']; ?>"><?= $u['Nm_Sub_Unit']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <!-- <button type="submit" class="btn btn-primary"> -->
                    <!-- Koreksi  -->
                <!-- </button> -->
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<script>
    $(function()
    {
       $("input").prop('required',true);
    });

        
  
    $('#skpd').on('change', function() 
    {
        kd=$('#skpd').val();
        string=kd.split('#');
        tahun=<?=json_encode($koreksiaktif['tahun'],true);?>;
        bulan=<?=json_encode($koreksiaktif['bulan'],true);?>;

        jQuery.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Koreksi/pilihbidang/"+string[0]+"/"+string[1]+"/"+string[2]+"/"+string[3]+"/"+tahun+"/"+bulan,
        dataType: "json",
            success: function(posted) 
            {
                console.log(posted);
                if(posted==1)
                {
                    alert('Sudah dikoreksi');
                }
                else if(posted==2)
                {
                    alert('Belum ada data yang dapat dikoreksi');
                }
                else if(posted==0)
                {
                    // alert('Siahkan mengoreksi data');
                    window.location.href = "<?php echo base_url(); ?>pengadaan/pilihanbulan/"+bulan;
                }
            },
            error: function() 
            {
                alert("Invalide! ");
            }
        });

        event.preventDefault();

    });


   

</script>





<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.js"></script>

<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image" style="background:none"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Registrasi Akun</h1>
                        </div>
                        <form class="user" method="post" action="<?= base_url('auth/registrasi') ?>">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama lengkap" value="<?= set_value('nama'); ?>">
                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulangi Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <select name="skpd" id="skpd" class="form-control">
                                    <option value="">--Pilih SKPD--</option>
                                    <?php foreach ($urusan as $u) : ?>
                                        <option value="<?= $u['Kd_Urusan'].'#'.$u['Kd_Bidang'].'#'.$u['Kd_Unit'].'#'.$u['Kd_Sub'].'#'.$u['Nm_Sub_Unit']; ?>"><?= $u['Nm_Sub_Unit']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">--Pilih Role--</option>
                                    <?php foreach ($role as $r) : ?>
                                        <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="tes">
                                <div class="form-group" style="">
                                    <select disabled name="bidang" id="bidang" class="form-control">
                                        <option value="">--Pilih Bidang--</option>        
                                    </select>
                                    <?= form_error('bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                                    <input type="text" class="form-control form-control-user" id="nama_bid" name="nama_bid" style="display:none">
                                </div>

                            </div>
                          
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Buat Akun
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url() ?>auth/forgotpassword">Lupa Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url() ?>auth">Sudah Memiliki Akun? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>

    $('#role_id').on('change', function(event) 
    {
        var kd='';
        if($('#role_id').val()=='4' || $('#role_id').val()=='5' )
        {
            document.getElementById('bidang').disabled = false;

            if($('#skpd').val()=='')
            {
                alert('Silahkan mengisi SKPD terlebih dahulu');
                $('#role_id').val('');
            }
            else
            {
                kd=$('#skpd').val();
                string=kd.split('#');

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>auth/pilihbidang/"+string[0]+"/"+string[1]+"/"+string[2]+"/"+string[3],
                    dataType: "json",
                    success: function(posted) 
                    {
                        $('#bidang').children('option:not(:first)').remove();
                        $.each(posted, function(key, value) {
                            $('#bidang')
                                .append($("<option></option>")
                                .attr("value",value["kd_bid_skpd"])
                                .text(value["nama_bidang"]));
                        });

                    },
                    error: function() 
                    {
                        alert("Invalide! jsdfghds "+kd);
                    }
                });

                event.preventDefault();
               
            }
        }
        else if($('#role_id').val()=="")
        {
            document.getElementById('bidang').disabled = true;
            $('#bidang').val('');
        }
        else
        {
            document.getElementById('bidang').disabled = true;
            $('#bidang').val('');
        }

    });


    $('#skpd').on('change', function() 
    {
        if($('#role_id').val()=="")
        {
            document.getElementById('bidang').disabled = true;
            $('#bidang').val('');
        } 
        else if($('#skpd').val()=='')
        {
            document.getElementById('bidang').disabled = true;
            $('#bidang').val()='';
        }
        else
        {
            if($('#role_id').val()=='4' || $('#role_id').val()=='5' )
            { 
                document.getElementById('bidang').disabled = false;

                if($('#skpd').val()=='')
                {
                    alert('Silahkan mengisi SKPD terlebih dahulu');
                    $('#role_id').val('');
                }
                else
                {
                    kd=$('#skpd').val();
                    string=kd.split('-');

                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>auth/pilihbidang/"+string[0]+"/"+string[1]+"/"+string[2]+"/"+string[3],
                        dataType: "json",
                        success: function(posted) 
                        {
                            $('#bidang').children('option:not(:first)').remove();
                            $.each(posted, function(key, value) {
                                $('#bidang')
                                    .append($("<option></option>")
                                    .attr("value",value["kd_bid_skpd"])
                                    .text(value["nama_bidang"]));
                            });

                        },
                        error: function() 
                        {
                            alert("Invalide! jsdfghds "+kd);
                        }
                    });

                    event.preventDefault();
                }
               
            
            }

        }

    });


    $('#bidang').on('change', function() 
    {
        $('#nama_bid').val($("#bidang option:selected").text());
    });

</script>
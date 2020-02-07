<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-12" >
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <div class="table-responsive" >
            <table class="table table-hover" id="dataTable" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Image</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                     if (isset($pengguna)) 
                     {
                     foreach ($pengguna as $sm) : 

                        if  ($sm['is_active']==1)
                        $aktif="Aktif";
                        else
                        $aktif="Tidak Aktif";
                     
                     ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $sm['nama']; ?></td>
                            <td><?= $sm['email']; ?></td>
                            <td><?= $sm['image']; ?></td>
                            <td><?= $sm['role']; ?></td>
                            <td><?= $aktif; ?></td>
                            <td><a href="#ubahpenggunaModal<?=$sm['id_user']?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?=base_url('admin/deletepengguna/'.$sm['id_user']); ?>" class="badge badge-danger">Hapus</a></td>
                        </tr>
                     <?php endforeach; }?>
                </tbody>

            </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<!-- ubah -->
<?php 
    if (isset($pengguna)) 
    {
        foreach ($pengguna as $b) 
        {
?>

<!-- Modal -->
<div class="modal fade" id="ubahpenggunaModal<?=$b['id_user']?>" tabindex="-1" role="dialog" aria-labelledby="ubahpenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahpenggunaModalLabel">Tambah Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url("admin/editpengguna/".$b['id_user']); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="nama role" value="<?php echo $b['nama']; ?>">
                    </div>
                
                    <div class="form-group" >
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="<?= $b['role_id']; ?>"><?= $b['role']; ?></option>
                            <?php 

                            if (isset($role)) 
                            {
                            
                            foreach ($role as $r) : 
                                if($r['id']!=$b['role_id'])
                                {
                            ?>
                                <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                            <?php } endforeach; }?>
                        </select>
                    </div>
                    <div class="form-group">
                                
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-5">
                                    <?php if (isset($b['image'])){ ?>
                                        <img src="<?= base_url('assets/img/profile/') . $b['image'];?> " class="img-thumbnail">
                                    <?php }?>
                                </div>
                                <input style="display:none" type="file" class="custom-file-input" id="fotolama" name="fotolama" value="<?php echo $b['image']; ?>">
                                <div class="col-sm-6">
                                    <input type="file" class="custom-file-input" id="ifoto" name="foto">
                                    <label class="custom-file-label" for="foto">Ambil gambar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                           
                                <?php if ($b['is_active']==1)
                                {
                                    $check1="checked";
                                    $check2="unchecked";
                                }
                                else 
                                {
                                    $check2="checked";
                                    $check1="unchecked";
                                }
                                ?>
                

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active" id="exampleRadios1" value="1" <?php echo $check1; ?>/>
                                <label class="form-check-label" for="exampleRadios1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active" id="exampleRadios2" value="0" <?php echo $check2; ?>/>
                                <label class="form-check-label" for="exampleRadios2">
                                    Tidak Aktif
                                </label>
                            </div>
                            
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

<?php 
        } 
    }
?>

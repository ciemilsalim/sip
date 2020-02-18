<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    
    <div class="row">
        <div class="col-lg-10">
            <?php if (validation_errors()): ?>
                <div class = "alert alert-danger" role="alert">
                    <?= validation_errors();?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#submenuModal">Tambah Sub Menu</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php   if (isset($subMenu)) 
                    {
                        foreach ($subMenu as $sm) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $sm['title']; ?></td>
                            <td><?= $sm['menu']; ?></td>
                            <td><?= $sm['url']; ?></td>
                            <td><?= $sm['icon']; ?></td>
                            <td><?= $sm['is_active']; ?></td>
                            <td><a href="#ubahsubmenuModal<?=$sm['id'];?>" data-toggle="modal" class="badge badge-success">Edit</a> | <a onclick="return confirm('Yakin akan menghapus data?');" href=" <?=base_url('menu/deletesubmenu/'.$sm['id']); ?>" class="badge badge-danger">Hapus</a></td>
                        </tr>
                        <?php endforeach; } ?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="submenuModal" tabindex="-1" role="dialog" aria-labelledby="submenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="nama Sub menu">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                           <option value="">Pilih Menu</option> 
                           <?php foreach ($menu as $m): ?>
                            <option value="<?= $m['id'];?>"><?= $m['menu'];?></option> 
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="alamat url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="icon submenu">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input active" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                            Aktif?
                            </label>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if (isset($subMenu)) 
{ 
    foreach ($subMenu as $sm) 
    {

?>

<!-- Modal -->
<div class="modal fade" id="ubahsubmenuModal<?=$sm['id']?>" tabindex="-1" role="dialog" aria-labelledby="submenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action=<?= base_url('menu/editsubmenu/'.$sm['id']); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="nama Sub menu" value="<?php echo $sm['title']; ?>">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                           <option value="<?= $sm['id_menu']; ?>"><?= $sm['menu']; ?></option>
                            <?php 

                            if (isset($menu)) 
                            {
                            
                            foreach ($menu as $r) : 
                                if($sm['id_menu']!=$r['menu_id'])
                                {
                            ?>
                                <option value="<?= $r['id']; ?>"><?= $r['menu']; ?></option>
                            <?php } endforeach; }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="alamat url" value="<?php echo $sm['url']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="icon submenu" value="<?php echo $sm['icon']; ?>">
                    </div>
                    
                    <div class="form-group">
                           
                           <?php if ($sm['is_active']==1)
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

} ?>
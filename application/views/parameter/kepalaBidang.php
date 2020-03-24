<?php
$disabled='';
$class='';
if($this->session->userdata('role_id')==3)
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
            <?= form_error('bidang', '<div class = "alert alert-danger" role="alert">', '</div>');?>
            <?= $this->session->flashdata('message');?>


            <a href="#" class="btn btn-primary mb-3 <?= $disabled ?>" data-toggle="modal" data-target="#bidangModal">Tambah Kepala Bidang</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width:15%">ID Kepala Bidang</th>
                        <th scope="col">Bidang</th>
                        <th scope="col">Nip</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php 
                    if (isset($kbidang)) 
                    {
                        foreach ($kbidang as $b) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $b['kd_kep_bid_skpd']; ?></td>
                            <td><?= $b['nama_bidang']; ?></td>
                            <td><?= $b['nip']; ?></td>
                            <td><?= $b['nama']; ?></td>
                            <td><a href="#ubahkbidangModal<?=$b['id_kepala_bidang']?>" data-toggle="modal" class="badge badge-success" style="<?= $class; ?>">Edit</a> </td>
                        </tr>
                        <?php endforeach; }?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Tambah -->
<div class="modal fade" id="bidangModal" tabindex="-1" role="dialog" aria-labelledby="bidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bidangModalLabel">Tambah Kepala Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('parameter/kepalabidang'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="nama_bidang" id="nama_bidang" class="form-control">
                                    <option value="">--Pilih Bidang--</option>
                                    <?php foreach ($bidang as $r=>$value) : ?>
                                        <option value="<?= $r; ?>"><?= $value; ?></option>
                                    <?php endforeach; ?>
                        </select>
                        <?= form_error('nama_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
               
                    <div class="form-group">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP">
                    </div>
               
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kepala Bidang">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ubah -->
<?php 
    if (isset($kbidang)) 
    {
        foreach ($kbidang as $b) 
        {
?>

<div class="modal fade" id="ubahkbidangModal<?=$b['id_kepala_bidang']?>" tabindex="-1" role="dialog" aria-labelledby="bidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bidangModalLabel">Tambah Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url("parameter/editkbidang/".$b['id_kepala_bidang']); ?>" method="POST">
               
                <div class="modal-body">
                    <div class="form-group">
                        <select name="nama_bidang" id="nama_bidang" class="form-control">
                                    <option value="<?= $b['id_bidang']; ?>"><?= $b['nama_bidang']; ?></option>
                                    <?php foreach ($bidang as $r=>$value) : ?>
                                        <option value="<?= $r; ?>"><?= $value; ?></option>
                                    <?php endforeach; ?>
                        </select>
                    </div>
               
                    <div class="form-group">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" value="<?php echo $b['nip']; ?>">
                    </div>
               
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kepala Bidang" value="<?php echo $b['nama']; ?>">
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

<script>

    $(function(){
        $("select").prop('required',true);
        $("input").prop('required',true);
        
    });

</script>

<!-- | <a onclick="return confirm('Yakin akan menghapus data?');" href=" //echo base_url('parameter/deletekbidang/'.$b['id_kepala_bidang']); ?>" class="badge badge-danger">Hapus</a> -->
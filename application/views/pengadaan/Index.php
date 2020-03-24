<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= form_error('menu', '<div class = "alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <?php
            if (isset($aktif)) {
                if ($aktif['tahun'] == $this->session->userdata('tahun')) {
                    ?>
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#pengadaanModal">Tambah Pengadaan</a>
                <?php
            } else {
                ?>
                    <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal">Tambah Pengadaan</a>
                <?php
            }
        } else {
            ?>
                <a href="#" class="btn btn-primary mb-3 disabled" data-toggle="modal" data-target="#pengadaanModal">Tambah Pengadaan</a>
            <?php
        }

        ?>

            <div class="modal-body">
                <?php
                if (isset($aktif)) {
                    if ($aktif['tahun'] == $this->session->userdata('tahun')) {
                        ?>
                        <div class="form-group">
                            <label>Data Aktif : Tahun Anggaran <?= $aktif['tahun']; ?> - Bulan <?= $aktif['bulan']; ?></label>
                        </div>
                    <?php
                }
            } else {
                ?>

                    <div class="form-group">
                        <label>Tidak ada tahun anggaran dan bulan aktif untuk login tahun <?= $this->session->userdata('tahun'); ?></label>
                    </div>

                <?php } ?>


                <?php
                if (isset($aktif)) {
                    if ($index == 'ya') {
                        ?>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="Januari" <?php if ($aktif['bulan'] == 'Januari') {
                                                            echo "selected";
                                                        } ?>>Januari</option>
                                <option value="Februari" <?php if ($aktif['bulan'] == 'Februari') {
                                                                echo "selected";
                                                            } ?>>Februari</option>
                                <option value="Maret" <?php if ($aktif['bulan'] == 'Maret') {
                                                            echo "selected";
                                                        } ?>>Maret</option>
                                <option value="April" <?php if ($aktif['bulan'] == 'April') {
                                                            echo "selected";
                                                        } ?>>April</option>
                                <option value="Mei" <?php if ($aktif['bulan'] == 'Mei') {
                                                        echo "selected";
                                                    } ?>>Mei</option>
                                <option value="Juni" <?php if ($aktif['bulan'] == 'Juni') {
                                                            echo "selected";
                                                        } ?>>Juni</option>
                                <option value="Juli" <?php if ($aktif['bulan'] == 'Juli') {
                                                            echo "selected";
                                                        } ?>>Juli</option>
                                <option value="Agustus" <?php if ($aktif['bulan'] == 'Agustus') {
                                                            echo "selected";
                                                        } ?>>Agustus</option>
                                <option value="September" <?php if ($aktif['bulan'] == 'September') {
                                                                echo "selected";
                                                            } ?>>September</option>
                                <option value="Oktober" <?php if ($aktif['bulan'] == 'Oktober') {
                                                            echo "selected";
                                                        } ?>>Oktober</option>
                                <option value="November" <?php if ($aktif['bulan'] == 'November') {
                                                                echo "selected";
                                                            } ?>>November</option>
                                <option value="Desember" <?php if ($aktif['bulan'] == 'Desember') {
                                                                echo "selected";
                                                            } ?>>Desember</option>
                            </select>
                        </div>

                    <?php
                } else { ?>
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="Januari" <?php if ($index == 'Januari') {
                                                            echo "selected";
                                                        } ?>>Januari</option>
                                <option value="Februari" <?php if ($index == 'Februari') {
                                                                echo "selected";
                                                            } ?>>Februari</option>
                                <option value="Maret" <?php if ($index == 'Maret') {
                                                            echo "selected";
                                                        } ?>>Maret</option>
                                <option value="April" <?php if ($index == 'April') {
                                                            echo "selected";
                                                        } ?>>April</option>
                                <option value="Mei" <?php if ($index == 'Mei') {
                                                        echo "selected";
                                                    } ?>>Mei</option>
                                <option value="Juni" <?php if ($index == 'Juni') {
                                                            echo "selected";
                                                        } ?>>Juni</option>
                                <option value="Juli" <?php if ($index == 'Juli') {
                                                            echo "selected";
                                                        } ?>>Juli</option>
                                <option value="Agustus" <?php if ($index == 'Agustus') {
                                                            echo "selected";
                                                        } ?>>Agustus</option>
                                <option value="September" <?php if ($index == 'September') {
                                                                echo "selected";
                                                            } ?>>September</option>
                                <option value="Oktober" <?php if ($index == 'Oktober') {
                                                            echo "selected";
                                                        } ?>>Oktober</option>
                                <option value="November" <?php if ($index == 'November') {
                                                                echo "selected";
                                                            } ?>>November</option>
                                <option value="Desember" <?php if ($index == 'Desember') {
                                                                echo "selected";
                                                            } ?>>Desember</option>
                            </select>
                        </div>
                    <?php
                }
            } else {
                ?>
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                <?php
            }
            ?>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Kode Pengadaan</th>
                                <!-- <th scope="col">Belanja</th> -->
                                <th scope="col">Uraian</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php if (isset($pengadaan)) {
                                foreach ($pengadaan as $sm) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $sm['tahun']; ?></td>
                                        <td><?= $sm['bulan']; ?></td>
                                        <td><?= $sm['kd_pengadaan']; ?></td>
                                        <td><?= $sm['uraian_pembelian']; ?></td>

                                        <?php
                                        if ($sm['status_pengadaan'] == 1) {
                                            ?>
                                            <td><a href="<?= base_url('Pengadaan/detilpengadaan2/' . $sm['kd_pengadaan'] . '/' . $sm['kd_sumber']) ?>" class="badge badge-success">Detail Pengadaan</a> |

                                                <?php
                                                if ($sm['status_penerimaan'] == 0) {
                                                    ?>
                                                    <a href="<?= base_url('Pengadaan/penerimaan/' . $sm['kd_pengadaan'] . '/' . $sm['kd_sumber']) ?>" class="badge badge-danger">Penerimaan</a>
                                                <?php
                                            } else {
                                                ?>
                                                    <a href="<?= base_url('Pengadaan/detilpenerimaan/' . $sm['kd_pengadaan'] . '/' . $sm['bulan']); ?>" class="badge badge-primary">Detail Penerimaan</a>
                                                <?php
                                            }
                                        } else if ($sm['status_pengadaan'] == 0) {
                                            ?>
                                            <td><a href="<?= base_url('pengadaan/detilpengadaan/' . $sm['kd_pengadaan'] . '/' . $sm['kd_sumber']); ?>" class="badge badge-danger">Tambah Detail Pengadaan</a>

                                            <?php } ?>

                                        </td>
                                    </tr>
                                <?php endforeach;
                        } ?>
                        </tbody>

                    </table>
                </div>
                <!--table -->
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="pengadaanModal" tabindex="-1" role="dialog" aria-labelledby="pengadaanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengadaanModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pengadaan/index'); ?>" method="POST">
                <div class="modal-body">
                    <!-- <label>Data Faktur</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_faktur" name="no_faktur" placeholder="Nomor Faktur">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur">
                    </div>
                    <hr style="border:1px solid grey;"></hr>
                    <label>Data BAP </label><br>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_bap" name="no_bap" placeholder="Nomor BAP">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tgl_bap" name="tgl_bap">
                    </div>
                    <hr style="border:1px solid grey;"></hr> -->
                    <div class="form-group">
                        <select name="belanja" id="belanja" class="selectpicker" style="width:100%;">
                            <option value="">-- Pilih Belanja --</option>
                            <?php if (isset($belanja)) {
                                foreach ($belanja as $m) : ?>
                                    <option value="<?= $m['kd_belanja']; ?>"><?= $m['nama_belanja']; ?></option>
                                <?php endforeach;
                        } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="supplier" id="supplier" class="selectpicker" style="width:100%;">
                            <option value="">-- Pilih Supplier --</option>
                            <?php if (isset($supplier)) {
                                foreach ($supplier as $m) : ?>
                                    <option value="<?= $m['kd_supplier']; ?>"><?= $m['nama_supplier']; ?></option>
                                <?php endforeach;
                        } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="sumber" id="sumber" class="selectpicker" style="width:100%;">
                            <option value="">-- Pilih Sumber Dana --</option>
                            <?php if (isset($sumber)) {
                                foreach ($sumber as $m) : ?>
                                    <option value="<?= $m['kd_sumber']; ?>"><?= $m['nama_sumber']; ?></option>
                                <?php endforeach;
                        } ?>
                        </select>
                    </div>
                    <label>Uraian Pembelian</label><br>
                    <div class="form-group">
                        <textarea name="uraian" class="form-control"></textarea>
                    </div>

                    <div class="form-group" style="display:none">
                        <label>Data Penerima</label>
                    </div>
                    <div class="form-group" style="display:none">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    NIP
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?php if (isset($pj)) {
                                                                                                            echo $pj['nip'];
                                                                                                        } ?>" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group" style="display:none">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    Nama
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($pj)) {
                                                                                                                echo $pj['nama'];
                                                                                                            } ?>" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group" style="display:none">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:30%">
                                    Jabatan
                                </td>
                                <td style="width:70%">
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php if (isset($pj)) {
                                                                                                                    echo $pj['jabatan'];
                                                                                                                } ?>" readonly>
                                </td>
                            </tr>
                        </table>
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


<script>
    $(function() {
        $(".selectpicker").select2();
    });
</script>



<script>
    //js untuk ambil nilai TW yang belum diaktifkan pada database
    $('#bulan').on('change', function() {
        bulan = $('#bulan').val();
        window.location.href = "<?php echo base_url(); ?>pengadaan/pilihanbulan/" + bulan;
    });
</script>
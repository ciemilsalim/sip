<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <button onclick="call()" class="btn btn-primary">Selesai Koreksi</button><br><br>

    <script>
        function call()
        {
            bulan=<?php echo json_encode($koreksiaktif['bulan']); ?>;
            tahun=<?php echo json_encode($koreksiaktif['tahun']); ?>;

            bulanfix='';
            tahunfix='';
            if(bulan=='Januari')
            {
                bulanfix='Februari';
                tahunfix=tahun;
            }
            else if(bulan=='Februari')
            {
                bulanfix='Maret';
                tahunfix=tahun;
            }
            else if(bulan=='Maret')
            {
                bulanfix='April';
                tahunfix=tahun;
            }
            else if(bulan=='April')
            {
                bulanfix='Mei';
                tahunfix=tahun;
            }
            else if(bulan=='Mei')
            {
                bulanfix='Juni';
                tahunfix=tahun;
            }
            else if(bulan=='Juni')
            {
                bulanfix='Juli';
                tahunfix=tahun;
            }
            else if(bulan=='Juli')
            {
                bulanfix='Agusutus';
                tahunfix=tahun;
            }
            else if(bulan=='Agustus')
            {
                bulanfix='September';
                tahunfix=tahun;
            }
            else if(bulan=='September')
            {
                bulanfix='Oktober';
                tahunfix=tahun;
            }
            else if(bulan=='Oktober')
            {
                bulanfix='November';
                tahunfix=tahun;
            }
            else if(bulan=='November')
            {
                bulanfix='Desember';
                tahunfix=tahun;
            }
            else if(bulan=='Desember')
            {
                bulanfix='Januari';
                tahunfix=parseInt(tahun)+1;
            }

            if (confirm('Data hasil koreksi akan menjadi data saldo awal pada bulan '+bulanfix+' tahun '+tahunfix +'. Apakah akan dilanjutkan?'))
            {
                window.location.href = "<?php echo base_url(); ?>Koreksi/selesaikoreksi";
            }
            else
            {
                return false;
            }
        }
    </script>

    <div class="row">
        <div class="col-lg-12">
          
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SKPD</th>
                        <!-- <th scope="col">Status Koreksi</th> -->
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    if (isset($urusan)) {
                        foreach ($urusan as $uk) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $uk['nm_sub_unit']; ?></td>
                                <!-- <td> if($uk['status_koreksi']==0) {echo 'Belum dikoreksi';} else {echo 'Sudah di koreksi';}  ?></td> -->
                                <td><?php if($uk['status_koreksi']==0) {?>
                                    <a href="<?= base_url('Koreksi/koreksidetail/'.$uk['id_k']); ?>" class="badge badge-success" >Koreksi</a>
                                <?php    
                                } else {?>
                                    <a href="" data-toggle="modal" class="badge badge-success" style="pointer-events: none; cursor: default; text-decoration: none; background-color:#b4b5b7;">Koreksi</a>
                                <?php
                                }  ?></td>
                            </tr>
                        <?php endforeach;
                } ?>
                </tbody>

                </table>
            </div> <!--table -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


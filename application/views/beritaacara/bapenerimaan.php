<?php

$skpd = $list['skpd'];  
$penyerahan = $list['penyerahan'];  

?>


<?php

// FUNGSI TERBILANG OLEH : MALASNGODING.COM
// WEBSITE : WWW.MALASNGODING.COM
// AUTHOR : https://www.malasngoding.com/author/admin

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
}

$daftar_hari = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
   );

   function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
 
	return $bulan[ (int)$pecahkan[1] ];
    }

    function tgl_indo2($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
    
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>BAPenyerahan</title>
</head>
<body>

    <center>
    <table width="100%" style="font-size:0.9em; padding:0px;">
        <tr>
            <td width="10%" style="text-align:right">
                <?php if (isset($skpd['foto'])){ ?>
                    <img width="50px" height="50px" src="<?= base_url('assets/img/foto/') . $skpd['foto'];?> " class="img-thumbnail">
                <?php }?>
            </td>
            <td style="text-align:center; ">
                <label>PEMERINTAH DAERAH KABUPATEN BUOL</label><br>
                <h4 style="font-weight:bold;">
                <?php if (isset($skpd['nama_skpd'])) { echo strtoupper($skpd['nama_skpd']);} else echo "" ?> 
                </h4>
                <h4 style="font-weight:bold; font-size:0.8em"> Alamat : <?php if (isset($skpd['alamat_skpd'])) { echo $skpd['alamat_skpd'];} else echo "" ?> </h4>
            </td>
        </tr>
    </table>
    <hr width="100%" style="margin-top: 5px; height:3px; border:1px solid black; "></hr>
    <hr width="100%" style="margin-top: -11px; height:1px; border:1px solid black; "></hr>
    <br>
    </center>

    <div style="font-size:0.8em;" >
        <p style="text-align:center; text-decoration: underline; font-weight:bold; margin-top:0px;"><?php if (isset($penyerahan['judul_berita'])) { echo strtoupper($penyerahan['judul_berita']);} else echo "" ?> </p><br>
        <p style="margin-top:-30px; text-align:center"><?php if (isset($penyerahan['no_ba_penyerahan'])) { echo strtoupper($penyerahan['no_ba_penyerahan']);} else echo "" ?> </p>

        <p style="text-align:justify; text-indent:20px;">Pada hari ini 
        <?php if (isset($penyerahan['tgl_bap'])) { $namahari = date('l', strtotime($penyerahan['tgl_bap'])); echo $daftar_hari[$namahari]; } else echo "" ?> 
        Tanggal  <?php if (isset($penyerahan['tgl_bap'])) { $tanggal= date('d', strtotime($penyerahan['tgl_bap'])); echo terbilang($tanggal); } else echo "" ?> 
        Bulan  <?php if (isset($penyerahan['tgl_bap'])) { echo tgl_indo($penyerahan['tgl_bap']);  } else echo "" ?> 
        Tahun  <?php if (isset($penyerahan['tgl_bap'])) { $tanggal= date('Y', strtotime($penyerahan['tgl_bap'])); echo terbilang($tanggal); } else echo "" ?>, yang bertanda tangan dibawah ini :
        </p>
        
            <table style="font-size:0.8em; margin-left:60px; ">
                <tr >
                    <td>a.</td>
                    <td>Nama</td>
                    <td>:</td>
                    <td style="font-weight:bold;"><?php if (isset($penyerahan['nama_1'])) { echo strtoupper($penyerahan['nama_1']);} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nip</td>
                    <td>:</td>
                    <td><?php if (isset($penyerahan['nip_1'])) { echo strtoupper($penyerahan['nip_1']);} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php if (isset($penyerahan['jabatan_1'])) { echo $penyerahan['jabatan_1'];} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight:bold;">Di sebut Pihak Pertama</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>b.</td>
                    <td>Nama</td>
                    <td>:</td>
                    <td style="font-weight:bold;"><?php if (isset($penyerahan['nama_2'])) { echo strtoupper($penyerahan['nama_2']);} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nip</td>
                    <td>:</td>
                    <td><?php if (isset($penyerahan['nip_2'])) { echo strtoupper($penyerahan['nip_2']);} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php if (isset($penyerahan['jabatan_2'])) { echo $penyerahan['jabatan_2'].' '.$penyerahan['nama_bidang'];} else echo "" ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight:bold;">Di sebut Pihak Kedua</td>
                </tr>
            </table>
   
   
        <p style="text-align:justify; text-indent:20px;">
        Bahwa pihak <b>Pertama</b> telah menyerahkan barang kepada pihak kedua dan pihak <b>Kedua</b> telah menerima barang  <b>sesuai dengan daftar terlampir</b>. Daftar tersebut dalam keadaan baru dan baik.
        </p>
        <p style="text-align:justify; text-indent:20px;">
        Demikian <?php if (isset($penyerahan['judul_berita'])) { echo strtoupper($penyerahan['judul_berita']);} else echo "" ?> ini dibuat dan ditanda tangani oleh kedua belah pihak di Buol pada Tanggal, Bulan dan Tahun sebagaimana tersebut di atas untuk dipergunakan sebagaimana mestinya.
        </p>

        <center>
        <table width="100%" style="font-size:0.8em; text-align:center; padding:20px">
            <tr>
                <td></td>
                <td>Buol, <?php if (isset($penyerahan['tgl_bap'])) { echo tgl_indo2($penyerahan['tgl_bap']);  } else echo "" ?> </td>
            </tr>
            <tr>
                <td width="45%" ><b>Yang Menyerahkan<br>Pihak Pertama<br><br><br><br><u> <?php if (isset($penyerahan['nama_1'])) { echo strtoupper($penyerahan['nama_1']);} else echo "" ?></u></b> <br>NIP. <?php if (isset($penyerahan['nip_1'])) { echo strtoupper($penyerahan['nip_1']);} else echo "" ?></td>
                <td width="45%" ><b>Yang Menerima<br>Pihak Kedua<br><br><br><br><u> <?php if (isset($penyerahan['nama_2'])) { echo strtoupper($penyerahan['nama_2']);} else echo "" ?></u></b> <br>NIP. <?php if (isset($penyerahan['nip_2'])) { echo strtoupper($penyerahan['nip_2']);} else echo "" ?></td>
            </tr>
        </table>
        </center>

    </div>


</body>
</html>
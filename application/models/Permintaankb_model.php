<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Permintaankb_model extends CI_Model
{
	public function getPermintaansaldo($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw, $kd_permintaan, $kd_bid_skpd)
	{
		$query = "SELECT a.*, sum(b.jumlah) as jumlah, sum(b.harga_total) as harga_total FROM tb_detail_permintaan a JOIN tb_saldo b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and  b.kd_unit=a.kd_unit and  b.kd_sub=a.kd_sub and b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_bid_skpd='$kd_bid_skpd' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.tw='$tw' and a.kd_permintaan='$kd_permintaan' GROUP BY  b.kd_urusan, b.kd_bidang, b.kd_unit, b.kd_sub, b.tahun,b.tw, b.kd_jenis, b.kd_komponen, b.kd_uraian";
		return $this->db->query($query)->result_array();
	}
	
}

?>
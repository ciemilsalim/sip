<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Pengadaan_model extends CI_Model
{
	public function getPengadaan($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw)
	{
		$query = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_urusan=a.kd_urusan and c.kd_bidang=a.kd_bidang and c.kd_unit=a.kd_unit and c.kd_sub=a.kd_sub and c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.tw='$tw';
		";
		return $this->db->query($query)->result_array();
	}
}

?>
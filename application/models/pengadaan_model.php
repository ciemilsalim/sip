<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Pengadaan_model extends CI_Model
{
	public function getPengadaan($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw)
	{
		$query = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_urusan=a.kd_urusan and c.kd_bidang=a.kd_bidang and c.kd_unit=a.kd_unit and c.kd_sub=a.kd_sub and c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.tw='$tw' ORDER BY a.kd_pengadaan asc
		";
		return $this->db->query($query)->result_array();
	}

	public function getPembelian($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw, $kd_pengadaan)
	{
		$query = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_urusan=a.kd_urusan and c.kd_bidang=a.kd_bidang and c.kd_unit=a.kd_unit and c.kd_sub=a.kd_sub and c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.tw='$tw' and a.kd_pengadaan='$kd_pengadaan'
		";
		return $this->db->query($query)->row_array();
	}

	public function getPenerimaan($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw,$kd_pengadaan)
	{
		$query = "SELECT a.*, b.uraian_komponen, b.satuan, b.harga FROM tb_penerimaan a JOIN tb_uraian_komponen b on b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.tw='$tw' and a.kd_pengadaan='$kd_pengadaan'";
		return $this->db->query($query)->result_array();
	}

	public function getSaldo($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw)
	{
		$query = "SELECT uraian_komponen,satuan,harga_satuan,sum(jumlah) as jumlah,SUM(harga_total) as harga_total FROM tb_saldo where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and tw='$tw' GROUP BY kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_komponen,kd_uraian,satuan,harga_satuan ";
		return $this->db->query($query)->result_array();
	}

	public function getSaldoAwal($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $tw)
	{
		$query = "SELECT uraian_komponen,satuan,harga_satuan,sum(jumlah) as jumlah,SUM(harga_total) as harga_total FROM tb_saldo_awal where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and tw='$tw' GROUP BY kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_komponen,kd_uraian,satuan,harga_satuan ";
		return $this->db->query($query)->result_array();
	}
	
}

?>
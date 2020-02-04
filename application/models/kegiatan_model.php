<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Kegiatan_model extends CI_Model
{
	public function getKegiatan($kd_urusan,$kd_bidang)
	{
        $array = array('kd_urusan' => $kd_urusan, 'kd_bidang' =>$kd_bidang );
        
		$this->db->select('*');
        $this->db->from('ref_kegiatan');
        $this->db->where($array); 
	
		return $this->db->get()->result_array();
	}
}

?>
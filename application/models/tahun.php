<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Tahun_model extends CI_Model
{
	public function getTahun()
	{
		$this->db->select('*');
		$this->db->from('tb_tahun');
		return $this->db->get()->result_array();
	}
}

?>
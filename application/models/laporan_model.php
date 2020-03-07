<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Laporan_model extends CI_Model
{
	public function get_Download_supplier($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res1 = $this->db->get('tb_supplier')->result_array();

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['supplier']=$res1;
        $final_res['skpd']=$res2;
         
        return $final_res;
    }
    
    public function get_Download_belanja($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res1 = $this->db->get('tb_belanja')->result_array();

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['belanja']=$res1;
        $final_res['skpd']=$res2;
         
        return $final_res;
    }
    
    public function get_Download_jenis($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $this->db->order_by("jenis_komponen", "asc");
        $res1 = $this->db->get('tb_jenis_komponen')->result_array();


        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['jenis']=$res1;
         
        return $final_res;
    }
    
    public function get_Download_komponen($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('tb_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_komponen.id_jenis', 'left');
        $res1  = $this->db->get()->result_array();


        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['komponen']=$res1;
         
        return $final_res;
    }
    
    public function get_Download_uraian($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('tb_uraian_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_uraian_komponen.id_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.id_komponen = tb_uraian_komponen.id_komponen', 'left');
        $this->db->order_by('tb_jenis_komponen.kd_jenis');
        $this->db->order_by('tb_komponen.kd_komponen');
        $res1  = $this->db->get()->result_array();


        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['uraian']=$res1;
         
        return $final_res;
	}
}

?>
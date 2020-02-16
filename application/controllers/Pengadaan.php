<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }

    public function cektTATWaktif()
    {
        $this->db->where('status', "Aktif"); 
        $data['managementa'] = $this->db->get('tb_managementa')->row_array();
    }

    public function index()
    {
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if(!empty($cektatw)>0)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/index', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/notactive', $data);
            $this->load->view('templates/footer');
        }
    }



}

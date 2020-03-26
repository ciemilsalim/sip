<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldoskpd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }

    public function index()
    {
        $data['title'] = 'Status Saldo Awal SKPD';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('nm_sub_unit');
        $data['skpd'] = $this->db->get('tb_saldo_awal_skpd_status')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Saldoskpd/index', $data);
        $this->load->view('templates/footer');
    }

    public function status()
    {
        $id = $this->uri->segment(3);
        $status=$this->uri->segment(4);

        if($status==0)
        {
            $datax = array(
                'status_saldo_awal' => 1
            );

            $this->db->where('id',$id);  
            $this->db->update('tb_saldo_awal_skpd_status', $datax);
        }
        else
        {
            $datax = array(
                'status_saldo_awal' => 0
            );

            $this->db->where('id',$id);  
            $this->db->update('tb_saldo_awal_skpd_status', $datax);

        }

        redirect('Saldoskpd/index');
        
    }


}

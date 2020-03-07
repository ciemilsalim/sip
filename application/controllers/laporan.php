<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        $this->load->model('Laporan_model');
    }

    public function parameter()
    {
        $data['title'] = 'Laporan Parameter';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/parameter', $data);
        $this->load->view('templates/footer');	

    }

    public function downloadparameter()
    {
        $data['title'] = 'Laporan Parameter';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if($this->input->post('supplier'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_supplier($pilih);
            $this->load->view('laporan/supplier', $data);
        }

        if($this->input->post('belanja'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_belanja($pilih);
            $this->load->view('laporan/belanja', $data);
        }

    }


    public function komponen()
    {
        $data['title'] = 'Laporan Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/komponen', $data);
        $this->load->view('templates/footer');	

    }

    public function downloadkomponen()
    {
        $data['title'] = 'Laporan Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if($this->input->post('jenis'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_jenis($pilih);
            $this->load->view('laporan/jenis', $data);
        }

        if($this->input->post('komponen'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_komponen($pilih);
            $this->load->view('laporan/komponenn', $data);
        }

        if($this->input->post('uraian'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_uraian($pilih);
            $this->load->view('laporan/uraian', $data);
        }

    }

    public function transaksi()
    {
        $data['title'] = 'Laporan Transaksi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/transaksi', $data);
        $this->load->view('templates/footer');	

    }

}

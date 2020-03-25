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
            // $this->load->view('laporan/supplier', $data);
        }

        if($this->input->post('belanja'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_belanja($pilih);
            // $this->load->view('laporan/belanja', $data);
        }

        redirect('laporan/parameter');

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
            // $this->load->view('laporan/jenis', $data);
        }

        if($this->input->post('komponen'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_komponen($pilih);
            // $this->load->view('laporan/komponenn', $data);
        }

        if($this->input->post('uraian'))
        {
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_uraian($pilih);
            // $this->load->view('laporan/uraian', $data);
        }

        redirect('laporan/parameter');

    }

    public function index()
    {
        $data['title'] = 'Laporan Persediaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');	

    }

    public function downloadtransaksi()
    {
        $data['title'] = 'Laporan Persediaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        if($this->input->post('pembelian'))
        {
            $tw = $this->input->post('tw');
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_pembelian($pilih,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);
            $this->load->view('laporan/pembelian', $data);
        }

        if($this->input->post('penerimaan'))
        {
            $tw = $this->input->post('twpenerimaan');
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_penerimaan($pilih,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);
            $this->load->view('laporan/penerimaan', $data);
        }

        if($this->input->post('pengeluaran'))
        {
            $tw = $this->input->post('twpengeluaran');
            $pilih=$this->input->post('pilih');
            $data['list'] = $this->Laporan_model->get_Download_pengeluaran($pilih,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);
            $this->load->view('laporan/pengeluaran', $data);
        }

    }

}

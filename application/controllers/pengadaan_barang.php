<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }

    public function index()
    {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/index', $data);
        $this->load->view('templates/footer');
    }
}

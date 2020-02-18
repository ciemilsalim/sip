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

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        // echo "<pre>"; print_r($cektatw);
        // die;


            $data['aktif']=$cektatw;
            $this->db->where($array);
            $data['supplier']= $this->db->get('tb_supplier')->result_array();

            $this->db->where($array);
            $data['belanja']= $this->db->get('tb_belanja')->result_array();

            $this->db->where($array);
            $this->db->where('kd_jabatan', '3');
            $data['pj']= $this->db->get('tb_penanggung_jawab')->row_array();

            $this->form_validation->set_rules('supplier', 'Nama Supplier', 'required');
            $this->form_validation->set_rules('belanja', 'Nama Belanja', 'required');
            $this->form_validation->set_rules('nip', 'NIP', 'required');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

            if ($this->form_validation->run() == false) 
            {
                
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('pengadaan/index', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $id_supplier = $this->input->post('supplier');
                $id_belanja = $this->input->post('belanja');
                $nip = $this->input->post('nip');
                $nama = $this->input->post('nama');
                $jabatan = $this->input->post('jabatan');
                $ket = $this->input->post('ket');
                $no_faktur = $this->input->post('no_faktur');
                $tgl_faktur = $this->input->post('tgl_faktur');
                $no_bap = $this->input->post('no_bap');
                $tgl_bap = $this->input->post('tgl_bap');
                $tahun = $this->session->userdata('tahun');
                $kd_urusan = $this->session->userdata('kd_urusan');
                $kd_bidang = $this->session->userdata('kd_bidang');
                $kd_unit = $this->session->userdata('kd_unit');
                $kd_sub = $this->session->userdata('kd_sub');


                $koneksi = mysqli_connect('localhost', 'root', '', 'db_sip');

                $cek = "SELECT * from tb_pengadaan";
                $cek2 = mysqli_query($koneksi, $cek);
                $cek3 = mysqli_num_rows($cek2);

                if ($cek3 > 0) {
                    $sqll = "SELECT MAX(kd_pengadaan) from tb_pengadaan where tahun='$tahun' and kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub'";
                    $hasill = mysqli_query($koneksi, $sqll);
                    $dataa = mysqli_fetch_array($hasill);
                    $maxid = $dataa[0];
                    $maxid++;
                    $no = $maxid++;
                } else {
                    $no = '1';
                }


                $data = array(
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    'tahun' => $cektatw['tahun'],
                    'tw' => $cektatw['tw'],
                    'kd_pengadaan ' => $no,
                    'nomor_faktur' =>  $no_faktur,
                    'tgl_faktur' =>  $tgl_faktur,
                    'nomor_bap' =>  $no_bap,
                    'tgl_bap' =>  $tgl_bap,
                    'kd_belanja' =>  $id_belanja,
                    'kd_supplier' =>  $id_supplier,
                    'nip_penerima' =>  $nip,
                    'nama_penerima' =>  $nama,
                    'jabatan' =>  $jabatan,
                    'ket'=> $ket
                );


                $this->db->insert('tb_pengadaan', $data);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                redirect('pengadaan/index');

            }
      
    }


    public function pilihantw()
    {
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
        $this->db->where($array);
        $data['supplier']= $this->db->get('tb_supplier')->result_array();

        $this->db->where($array);
        $data['belanja']= $this->db->get('tb_belanja')->result_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan', '3');
        $data['pj']= $this->db->get('tb_penanggung_jawab')->row_array();

        $tw = $this->uri->segment(3);
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $this->load->model('Pengadaan_model', 'pengadaan');
        $data['pengadaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/index', $data);
        $this->load->view('templates/footer');

    }



}

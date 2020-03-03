<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaanab extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        // $this->load->model('Permintaanab_model', 'permintaan');
    }


    public function index()
    {
        $data['title'] = 'Permintaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
       
        if(!empty($cektatw))
        {
            $this->form_validation->set_rules('tgl_permintaan', 'Tanggal Permintaan', 'required');

            if ($this->form_validation->run() == false) 
            {     
                $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'tw' => $cektatw['tw']);
                
                $this->db->where($array); 
                $data['komponen'] = $this->db->get('tb_saldo')->result_array();

                $array2 = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
                $this->db->where($array2); 
                $this->db->where('kd_bid_skpd',$this->session->userdata('kd_bid_skpd'));   
                $data['kbidang'] = $this->db->get('tb_kepala_bidang')->row_array();

                $this->db->where($array2);
                $this->db->where('kd_bid_skpd',$this->session->userdata('kd_bid_skpd'));  
                $data['bidang'] = $this->db->get('tb_bidang')->row_array();

                $this->db->where('email',$this->session->userdata('email')); 
                $data['admin'] = $this->db->get('user')->row_array();


                $array3 = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun']);
                
                $cek = $this->db->get('tb_permintaan')->result_array();
                if ($cek > 0) {
                    $this->db->select_max('kd_permintaan');
                    $this->db->where($array3);
                    $result = $this->db->get('tb_permintaan')->row_array();
                    $maxkdjenis = $result['kd_permintaan'];
                    $maxkdjenis++;
                    $data['kd'] = $maxkdjenis++;
                } else {
                    $data['kd'] = '1';
                }

                
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('permintaanab/tambahpermintaan', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $array3 = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun']);
                $kd='';
                $cek = $this->db->get('tb_permintaan')->result_array();
                if ($cek > 0) {
                    $this->db->select_max('kd_permintaan');
                    $this->db->where($array3);
                    $result = $this->db->get('tb_permintaan')->row_array();
                    $maxkdjenis = $result['kd_permintaan'];
                    $maxkdjenis++;
                    $kd = $maxkdjenis++;
                } else {
                    $kd = '1';
                }

                $kd_bidang = $this->input->post('kd_bidang');
                $nama_bidang = $this->input->post('nama_bidang');
                $kd_kepala_bidang = $this->input->post('kd_k_bidang');
                $nama_kepala_bidang = $this->input->post('nama_k_bidang');
                $nip = $this->input->post('nip');
                $nama_admin = $this->input->post('nama_admin');
                $tgl = $this->input->post('tgl_permintaan');
                $tujuan = $this->input->post('tujuan');
                $tahun = $cektatw['tahun'];
                $tw = $cektatw['tw'];
                $kd_urusan = $this->session->userdata('kd_urusan');
                $kd_bidang = $this->session->userdata('kd_bidang');
                $kd_unit = $this->session->userdata('kd_unit');
                $kd_sub = $this->session->userdata('kd_sub');
                $datajson = json_decode($this->input->post('jsondata'),true);

                $data = array(
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    'tahun' => $tahun,
                    'tw' => $tw,
                    'kd_permintaan ' => $kd,
                    'tgl_permintaan' =>  $tgl,
                    'tujuan_penggunaan' =>  $tujuan,
                    'nama_admin' =>  $nama_admin,
                    'kd_bid_skpd' =>  $kd_bidang,
                    'nama_bidang' =>  $nama_bidang,
                    'kd_kep_bid_skpd' =>  $kd_kepala_bidang,
                    'nama_kep_bid_skpd' =>  $nama_kepala_bidang,
                    'nip' =>  $nip,
                    'status_kepala_bidang' =>  0,
                    'status_kepala_gudang ' =>  0,
                    'status_selesai ' =>  0
                );

                $this->db->insert('tb_permintaan', $data);

                //status 1:dibaca, 2:sudah  diproses, 0:belumdibaca, 

                foreach($datajson as $key=> $arr)
                {
                    $data = array(
                        'kd_urusan' => $kd_urusan,
                        'kd_bidang' => $kd_bidang,
                        'kd_unit' => $kd_unit,
                        'kd_sub' => $kd_sub,
                        'kd_permintaan' => $kd,
                        'kd_jenis' => $datajson[$key]['kd_jenis'],
                        'kd_komponen' => $datajson[$key]['kd_komponen'],
                        'kd_uraian' => $datajson[$key]['kd_uraian'],
                        'uraian_komponen' => $datajson[$key]['uraian'],
                        'satuan' => $datajson[$key]['satuan'],
                        'harga_satuan' => $datajson[$key]['harga'],
                        'jumlah_permintaan ' => $datajson[$key]['jumlah'],
                        'harga_permintaan' =>  $datajson[$key]['total'],
                        'jumlah_persetujuan_kb' => 0,
                        'jumlah_persetujuan_pg' =>  0,
                        'tahun' => $tahun,
                        'tw' => $tw
                    );


                    $this->db->insert('tb_detail_permintaan', $data);
                    
                }

                $data['title'] = 'Proses Permintaan';
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                redirect('permintaanab/proses');

            }
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


    public function proses()
    {
        $data['title'] = 'Proses Permintaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
       
        if(!empty($cektatw))
        {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'tw' => $cektatw['tw']);
        
            // $data['permintaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->db->where($array);
            $this->db->where('status_kepala_bidang < ', 4); 
            $this->db->where('status_kepala_gudang < ', 4); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanab/proses', $data);
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


    public function tambahpermintaan()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;

        
        if(!empty($cektatw))
        {

            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'tw' => $cektatw['tw']);
            
            $this->db->where($array); 
            $data['komponen'] = $this->db->get('tb_saldo')->result_array();

            $array2 = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
            $this->db->where($array2); 
            $this->db->where('kd_bid_skpd',$this->session->userdata('kd_bid_skpd'));   
            $data['kbidang'] = $this->db->get('tb_kepala_bidang')->row_array();

            $this->db->where($array2);
            $this->db->where('kd_bid_skpd',$this->session->userdata('kd_bid_skpd'));  
            $data['bidang'] = $this->db->get('tb_bidang')->row_array();

            $this->db->where('email',$this->session->userdata('email')); 
            $data['admin'] = $this->db->get('user')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanab/tambahpermintaan', $data);
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


    public function detailpermintaan()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;

        if(!empty($cektatw))
        {
            $kd = $this->uri->segment(3);
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'tw' => $cektatw['tw']);
            
            $this->db->where($array); 
            $this->db->where('kd_permintaan',$kd); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->row_array();

            $this->db->where($array); 
            $this->db->where('kd_permintaan',$kd); 
            $data['detailpermintaan'] = $this->db->get('tb_detail_permintaan')->result_array();


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanab/detailpermintaan', $data);
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

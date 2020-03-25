<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaankb extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        $this->load->model('Permintaankb_model', 'm_permintaankb');
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
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $cektatw['bulan']);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
            // $data['permintaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('status_kepala_bidang <= ', 1); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/pengajuan', $data);
            $this->load->view('templates/footer');

        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/notactive', $data);
            $this->load->view('templates/footer');
        }
      
    }

    public function detailpermintaan()
    {
        $data['title'] = 'Permintaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;

        if(!empty($cektatw))
        {
            $this->form_validation->set_rules('kd', 'Kode Permintaan', 'required');

            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $cektatw['bulan']);
                           
            $kdp = $this->uri->segment(3);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');

            $this->db->where($array); 
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('kd_permintaan',$kdp); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->row_array();

            $bulan = $cektatw['bulan'];
            $tahun = $cektatw['tahun'];
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
           

            if ($this->form_validation->run() == false) 
            {  
                $data['detailpermintaan'] = $this->m_permintaankb->getPermintaansaldo($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan,$kdp,$kd_bid_skpd);
                // echo $kd_bid_skpd;
                // echo "<pre>"; print_r($data['detailpermintaan']);
                // die;
                $datax = array(
                    'status_kepala_bidang' => 1
                );

                $this->db->where($array); 
                $this->db->where('kd_permintaan',$kdp); 
                $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                $this->db->update('tb_permintaan', $datax);

                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('permintaankb/detailpermintaan', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $kdp = $this->input->post('kd');
                $kd_bid = $this->input->post('kd_bid');
                $datajson = json_decode($this->input->post('jsondata'),true);
                $datajsonno = json_decode($this->input->post('jsondatano'),true);

                if(empty($datajson))
                {
                        $datacc = array(
                            'jumlah_persetujuan_kb' => 0,
                            'harga_persetujuan_kb' => 0,
                            'jumlah_persetujuan_pg' => 0,
                            'harga_persetujuan_pg' => 0,
                        );

                        $this->db->where($array); 
                        $this->db->where('kd_permintaan',$kdp); 
                        $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                        $this->db->update('tb_detail_permintaan', $datacc);
                }
                else
                {
                    foreach($datajson as $key=> $arr)
                    {
                        $kd = $datajson[$key]['id'];

                        $data = array(
                            'jumlah_persetujuan_kb' => $datajson[$key]['jumlah'],
                            'harga_persetujuan_kb' => $datajson[$key]['total'],
                        );

                        $this->db->where('id',$kd); 
                        $this->db->update('tb_detail_permintaan', $data);
                        
                    }
                }

                

                //jika permintaan ditolak
                if($datajsonno=='YES')
                {
                    $datax = array(
                        'status_kepala_bidang' => 3, //ditolak
                        'status_kepala_gudang' => 7, //tidak diproses
                        // 'tgl_kepala_bidang' => date('Y-m-d')
                    );
    
                    $this->db->where($array); 
                    $this->db->where('kd_permintaan',$kdp); 
                    $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                    $this->db->update('tb_permintaan', $datax);
                }
                else
                {
                    $datax = array(
                        'status_kepala_bidang' => 2,
                        'tgl_kepala_bidang' => date('Y-m-d')
                    );
    
                    $this->db->where($array); 
                    $this->db->where('kd_permintaan',$kdp); 
                    $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                    $this->db->update('tb_permintaan', $datax);
                }
              

                $data['title'] = 'Prose Permintaan';
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diproses</div>');
                redirect('permintaankb/proses');

            }
        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/notactive', $data);
            $this->load->view('templates/footer');
        }

    }

    public function detailpermintaanproses()
    {
        $data['title'] = 'Permintaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;

        if(!empty($cektatw))
        {
            $kd = $this->uri->segment(3);
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $cektatw['bulan']);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');

            $this->db->where($array); 
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('kd_permintaan',$kd); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->row_array();

            $this->db->where($array); 
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('kd_permintaan',$kd); 
            $data['detailpermintaan'] = $this->db->get('tb_detail_permintaan')->result_array();


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/detailpermintaanproses', $data);
            $this->load->view('templates/footer');
        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/notactive', $data);
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
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $cektatw['bulan']);
        
            // $data['permintaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
            
            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('status_kepala_bidang >= ', 2); 
            $this->db->where('status_kepala_gudang <= ', 7);
            $this->db->where('status_selesai_kb != ', 9);  
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/proses', $data);
            $this->load->view('templates/footer');

        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/notactive', $data);
            $this->load->view('templates/footer');
        }

    }


    public function status()
    {
        $data['title'] = 'Proses Permintaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
       
        if(!empty($cektatw))
        {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $cektatw['bulan']);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
            $kdp = $this->uri->segment(3);

            $datax = array(
                'status_selesai_kb' => 9
            );

            $this->db->where($array); 
            $this->db->where('kd_permintaan',$kdp); 
            $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
            $this->db->update('tb_permintaan', $datax);

            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('status_kepala_bidang <= ', 2); 
            $this->db->where('status_kepala_gudang <= ', 2); 
            $this->db->where('status_admin_bidang <= ', 3); 
            $this->db->where('status_selesai_kb != ', 9);  
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/proses', $data);
            $this->load->view('templates/footer');

        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanab/notactive', $data);
            $this->load->view('templates/footer');
        }

    }

    public function history()
    {
        $data['title'] = 'History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
     
            $data['index'] = 'ya';
            $bulan=$cektatw['bulan'];
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $bulan);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
           
            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('status_kepala_bidang >= ', 2); 
            $this->db->where('status_kepala_gudang >= ', 2); 
            $this->db->where('status_selesai_kb = ', 9);  
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            // echo "<pre>"; print_r( $data['permintaan'] );

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/history', $data);
            $this->load->view('templates/footer');
        
    }

    public function pilihantw()
    {
        $data['title'] = 'History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
       
        $bulan= $this->uri->segment(3);
        $data['index'] =  $bulan;
       
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $bulan);
        $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
            // $data['permintaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('status_kepala_bidang >= ', 2); 
            $this->db->where('status_kepala_gudang >= ', 2); 
            $this->db->where('status_selesai_kb = ', 9);  
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/history', $data);
            $this->load->view('templates/footer');

       
    }

    public function detailhistory()
    {
        $data['title'] = 'Detail History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
       
        if(!empty($cektatw))
        {
            $kd = $this->uri->segment(3);
            $tahun = $this->uri->segment(4);
            $bulan = $this->uri->segment(5);
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $tahun, 'bulan' => $bulan);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');

            $this->db->where($array); 
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            $this->db->where('kd_permintaan',$kd); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->row_array();

            $this->db->where($array); 
            $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
            $this->db->where('kd_permintaan',$kd); 
            $data['detailpermintaan'] = $this->db->get('tb_detail_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaankb/detailhistory', $data);
            $this->load->view('templates/footer');
        }
    }




}
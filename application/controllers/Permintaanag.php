<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaanag extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        $this->load->model('Permintaankb_model', 'm_permintaankb');
    }


    public function permintaanMasuk()
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
            $this->db->where('status_kepala_bidang = ', 2); 
            $this->db->where('status_kepala_gudang <= ', 1); 
            $this->db->where('status_kepala_gudang != ', 9); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanag/permintaanMasuk', $data);
            $this->load->view('templates/footer');

        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanag/notactive', $data);
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
            $this->db->where('kd_permintaan',$kdp); 
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
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
                
                $datax = array(
                    'status_kepala_gudang' => 1
                );

                $this->db->where($array); 
                $this->db->where('kd_permintaan',$kdp); 
                $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                $this->db->update('tb_permintaan', $datax);

                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('permintaanag/detailpermintaan', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $kdp = $this->input->post('kd');
                $kd_bid = $this->input->post('kd_bid_skpd');
                $nama_bidang = $this->input->post('nama_bidang');
                $nama_k_bid = $this->input->post('nama_k_bidang');
                $kd_k_bid = $this->input->post('kd_k_bidang');
                // $ket = $this->input->post('ket');
                $nip = $this->input->post('nip');
                $tujuan = $this->input->post('tujuan');
                $nama_admin = $this->input->post('nama_admin');
                $datajson = json_decode($this->input->post('jsondata'),true);
                $datajsonno = json_decode($this->input->post('jsondatano'),true);

                //kode pengeluaran
                $array3 = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun']);
                $kd_pgl='';
                $cek = $this->db->get('tb_pengeluaran')->result_array();
                if ($cek > 0) {
                    $this->db->select_max('kd_pengeluaran');
                    $this->db->where($array3);
                    $result = $this->db->get('tb_pengeluaran')->row_array();
                    $maxkdp = $result['kd_pengeluaran'];
                    $maxkdp++;
                    $kd_pgl = $maxkdp++;
                } else {
                    $kd_pgl = '1';
                }

                if(empty($datajson))
                {
                        $datacc = array(
                            // 'jumlah_persetujuan_kb' => 0,
                            // 'harga_persetujuan_kb' => 0,
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
                  
                    //proses update status, jumlah persetujuan, perubahan saldo, dan detail pengeluaran
                        foreach($datajson as $key=> $arr)
                        {
                            $kd = $datajson[$key]['id'];

                            $data = array(
                                'jumlah_persetujuan_pg' => $datajson[$key]['jumlah'],
                                'harga_persetujuan_pg' => $datajson[$key]['total'],
                            );

                            $this->db->where('id',$kd); 
                            $this->db->update('tb_detail_permintaan', $data);


                            //pengeluaran
                            if($datajson[$key]['jumlah']>0)
                            {
                                $datakeluar=array();
                                $datakeluar = array(
                                    'kd_urusan' => $kd_urusan,
                                    'kd_bidang' => $kd_bidang,
                                    'kd_unit' => $kd_unit,
                                    'kd_sub' => $kd_sub,
                                    'kd_bid_skpd' => $kd_bid,
                                    'kd_pengeluaran' => $kd_pgl,
                                    'kd_jenis' => $datajson[$key]['kd_jenis'],
                                    'kd_komponen' => $datajson[$key]['kd_komponen'],
                                    'kd_uraian' => $datajson[$key]['kd_uraian'],
                                    'uraian_komponen' => $datajson[$key]['uraian'],
                                    'satuan' => $datajson[$key]['satuan'],
                                    'harga_satuan' => $datajson[$key]['harga'],
                                    'jumlah_pengeluaran ' => $datajson[$key]['jumlah'],
                                    'harga_pengeluaran' =>  $datajson[$key]['total'],
                                    'tahun' => $tahun,
                                    'bulan' => $bulan,
                                    'kd_sumber' => $datajson[$key]['kdsumber']
                                );

                                $this->db->insert('tb_detail_pengeluaran', $datakeluar);
            
                            }


                            //updatesaldo
                            $datasaldowhere=array();
                            $datasaldowhere = array(
                                'kd_urusan' => $kd_urusan,
                                'kd_bidang' => $kd_bidang,
                                'kd_unit' => $kd_unit,
                                'kd_sub' => $kd_sub,
                                'tahun' =>$tahun,
                                'bulan' =>$bulan,
                                'kd_jenis' => $datajson[$key]['kd_jenis'],
                                'kd_komponen' => $datajson[$key]['kd_komponen'],
                                'kd_uraian' => $datajson[$key]['kd_uraian'],
                            );

                            $saldo=array();
                            $this->db->where($datasaldowhere); 
                            $saldo = $this->db->get('tb_saldo')->result_array();
                            $jumlahkeluar=$datajson[$key]['jumlah'];
                            $totalharga=$datajson[$key]['total'];
                            $sisa=0;
                            $sisaharga=0;

                            foreach ($saldo as $key => $value)
                            {
                                if ($saldo[$key]['jumlah']>=$jumlahkeluar)
                                {
                                    $sisa=$saldo[$key]['jumlah']-$jumlahkeluar;
                                    $sisaharga=$saldo[$key]['harga_total']-$totalharga;
                                    $datasaldoupdate=array();
                                    $datasaldoupdate = array(
                                        'jumlah' => $sisa,
                                        'harga_total' => $sisaharga,
                                    );

                                    //saldo
                                    $this->db->where($datasaldowhere); 
                                    $this->db->where('id_saldo',$saldo[$key]['id_saldo']); 
                                    $this->db->update('tb_saldo', $datasaldoupdate);
                                    break;
                                }
                                else if ($saldo[$key]['jumlah']<$jumlahkeluar)
                                {
                                    $sisa=$jumlahkeluar-$saldo[$key]['jumlah'];
                                    $sisaharga=$saldo[$key]['harga_total']-$totalharga;
                                    $datasaldoupdate=array();
                                    $datasaldoupdate = array(
                                        'jumlah' => 0,
                                        'harga_total' => 0,
                                    );

                                    //saldo
                                    $this->db->where($datasaldowhere); 
                                    $this->db->where('id_saldo',$saldo[$key]['id_saldo']); 
                                    $this->db->update('tb_saldo', $datasaldoupdate);
                                    $jumlahkeluar=$sisa;
                                    $totalharga=$sisaharga;
                                }
                            }


                          
                        }


                    
                     //simpan pengeluran
                     $datap = array(
                        'kd_urusan' => $kd_urusan,
                        'kd_bidang' => $kd_bidang,
                        'kd_unit' => $kd_unit,
                        'kd_sub' => $kd_sub,
                        'kd_bid_skpd' => $kd_bidang,
                        'kd_pengeluaran' => $kd_pgl,
                        'tgl_pengeluaran' => date('Y-m-d'),
                        'kd_permintaan' => $kdp,                    
                        'tujuan_penggunaan' =>  $tujuan,
                        'nama_admin' =>  $nama_admin,
                        'nama_bidang' =>  $nama_bidang,
                        'kd_kep_bid_skpd' =>  $kd_k_bid,
                        'nama_kep_bid_skpd' =>  $nama_k_bid,
                        'nip' =>  $nip,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        // 'ket' => $ket
                        // 'status_selesai ' =>  0
                    );
    
                    $this->db->insert('tb_pengeluaran', $datap);
                    
                    
                }

                //jika permintaan ditolak
                if($datajsonno=='YES')
                {
                    $datax = array(
                        'status_kepala_gudang' => 3,
                        'tgl_kepala_gudang' => date('Y-m-d')
                    );

                    $this->db->where($array); 
                    $this->db->where('kd_permintaan',$kdp); 
                    $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                    $this->db->update('tb_permintaan', $datax);
                }
                else
                {
                    $datax = array(
                        'status_kepala_gudang' => 2,
                        'tgl_kepala_gudang' => date('Y-m-d')
                    );

                    $this->db->where($array); 
                    $this->db->where('kd_permintaan',$kdp); 
                    $this->db->where('kd_bid_skpd',$kd_bid_skpd); 
                    $this->db->update('tb_permintaan', $datax);

                }
              

                $data['title'] = 'Pengajuan';
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diproses</div>');
                redirect('permintaanag/permintaanMasuk');

            }
        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanag/notactive', $data);
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
            $bulan= $cektatw['bulan'];
            $data['index'] =  $bulan;

       
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $cektatw['tahun'], 'bulan' => $bulan);
            $kd_bid_skpd = $this->session->userdata('kd_bid_skpd');
            // $data['permintaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->db->where($array);
            $this->db->where("kd_bid_skpd",$kd_bid_skpd);
            // $this->db->where('status_kepala_bidang <= ', 3); 
            $this->db->where('status_kepala_gudang >= ', 2); 
            // $this->db->where('status_admin_bidang <= ', 3); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanag/history', $data);
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
            // $this->db->where('status_kepala_bidang <= ', 3); 
            $this->db->where('status_kepala_gudang >= ', 2); 
            // $this->db->where('status_admin_bidang <= ', 3); 
            $data['permintaan'] = $this->db->get('tb_permintaan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('permintaanag/history', $data);
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
            $this->load->view('permintaanag/detailhistory', $data);
            $this->load->view('templates/footer');
        }
    }

  

}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        $this->load->model('Pengadaan_model', 'pengadaan');
    }


    public function index()
    {
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
       
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

                if ($cek3 > 0) 
                {
                    $sqll = "SELECT MAX(kd_pengadaan) from tb_pengadaan where tahun='$tahun' and kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub'";
                    $hasill = mysqli_query($koneksi, $sqll);
                    $dataa = mysqli_fetch_array($hasill);
                    $maxid = $dataa[0];
                    $maxid++;
                    $no = $maxid++;
                } else 
                {
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
       
        $this->db->where('status', "Aktif"); 
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

        
        $data['pengadaan'] = $this->pengadaan->getPengadaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

        // $data['penerimaan'] = $this->pengadaan->getPenerimaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/index', $data);
        $this->load->view('templates/footer');

    }


    public function penerimaan()
    {
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();
        
        if(!empty($cektatw))
        {
            $data['aktif']=$cektatw;

            $this->db->where($array);
            $this->db->where('tahun', $cektatw['tahun']);
            $this->db->where('tw', $cektatw['tw']);
            $data['pembelian']= $this->db->get('tb_pengadaan')->result_array();


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/penerimaan', $data);
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

    public function pilihpembelian()
    {
        $data['title'] = 'Pembelian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        
        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        $data['aktif']=$cektatw;
        
        $kd_pengadaan = $this->uri->segment(3);
        $tw = $cektatw['tw'];
        $tahun = $cektatw['tahun'];
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');


        $this->db->where($array);
        $this->db->where('tahun', $cektatw['tahun']);
        $this->db->where('tw', $cektatw['tw']);
        $data['pembelian']= $this->db->get('tb_pengadaan')->result_array();

        $data['komponen']= $this->db->get('tb_uraian_komponen')->result_array();

        $data['detil'] = $this->pengadaan->getPembelian($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw,$kd_pengadaan);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/penerimaan', $data);
        $this->load->view('templates/footer');

    }

    public function penerimaanbarang()
    {
        $datajson = json_decode($this->input->post('jsondata'),true);

        $kd_pengadaan = $this->uri->segment(3);
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif']=$cektatw;
        $tw = $cektatw['tw'];
        $tahun = $cektatw['tahun'];
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        foreach($datajson as $key=> $arr)
        {
            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_pengadaan' => $kd_pengadaan,
                'kd_jenis' => $datajson[$key]['kd_jenis'],
                'kd_komponen' => $datajson[$key]['kd_komponen'],
                'kd_uraian' => $datajson[$key]['kd_uraian'],
                'uraian_komponen' => $datajson[$key]['uraian'],
                'satuan' => $datajson[$key]['satuan'],
                'harga_satuan' => $datajson[$key]['harga'],
                'jumlah ' => $datajson[$key]['jumlah'],
                'harga_total' =>  $datajson[$key]['total'],
                'tahun' =>  $cektatw['tahun'],
                'tw' =>  $cektatw['tw'],
                'tgl_penerimaan' =>  date("Y/m/d")
            );


            $this->db->insert('tb_penerimaan', $data);
             
        }


        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
        redirect('pengadaan/index');
    }


    
    public function detilpenerimaan()
    {
        $data['title'] = 'Detil Penerimaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        
        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        $data['aktif']=$cektatw;
        
        $kd_pengadaan = $this->uri->segment(3);
        $tw = $cektatw['tw'];
        $tahun = $cektatw['tahun'];
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');


        $data['detil'] = $this->pengadaan->getPembelian($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw,$kd_pengadaan);
        $data['penerimaan'] = $this->pengadaan->getPenerimaan($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw,$kd_pengadaan);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/detilpenerimaan', $data);
        $this->load->view('templates/footer');

    }


    public function saldo()
    {
        $data['title'] = 'Saldo';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if(!empty($cektatw))
        {
            $data['aktif']=$cektatw;

            $this->db->where($array);
            $this->db->where('tahun', $cektatw['tahun']);
            $this->db->where('tw', $cektatw['tw']);
            
            $tw = $cektatw['tw'];
            $tahun = $cektatw['tahun'];
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data['saldo'] = $this->pengadaan->getSaldo($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/saldo', $data);
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


    public function saldoawal()
    {
        $data['title'] = 'Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if(!empty($cektatw))
        {
            $data['aktif']=$cektatw;

            $this->db->where($array);
            $this->db->where('tahun', $cektatw['tahun']);
            $this->db->where('tw', $cektatw['tw']);
            
            $tw = '';
            $tahun=$cektatw['tahun'];
            if ($cektatw['tw']=='4')
            {
                $tw='3';
            }
            else if($cektatw['tw']=='3')
            {
                $tw='2';
            }
            else if($cektatw['tw']=='2')
            {
                $tw='1';
            }
            else if($cektatw['tw']=='1')
            {
                $tahun=$cektatw['tahun']-1;
                $tw='4';
            }

            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data['saldo_awal'] = $this->pengadaan->getSaldoAwal($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/saldoAwal', $data);
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


    public function tambahsaldoawal()
    {
        $data['title'] = 'Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if(!empty($cektatw))
        {
            $data['aktif']=$cektatw;
            $data['komponen']= $this->db->get('tb_uraian_komponen')->result_array();

            $this->db->where($array);
            $this->db->where('tahun', $cektatw['tahun']);
            $this->db->where('tw', $cektatw['tw']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/tambahsaldoawal', $data);
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


    public function simpansaldoawal()
    {
        $datajson = json_decode($this->input->post('jsondata'),true);
        $tahun=$this->input->post('tahun');
        $twpost=$this->input->post('tw');

        $tw='';
        if ($twpost=='IV')
        {
            $tw='4';
        }
        else if($twpost=='III')
        {
            $tw='3';
        }
        else if($twpost=='II')
        {
            $tw='2';
        }
        else if($twpost=='I')
        {
            $tw='1';
        }

        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        foreach($datajson as $key=> $arr)
        {
            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_pengadaan' => '0',
                'kd_jenis' => $datajson[$key]['kd_jenis'],
                'kd_komponen' => $datajson[$key]['kd_komponen'],
                'kd_uraian' => $datajson[$key]['kd_uraian'],
                'uraian_komponen' => $datajson[$key]['uraian'],
                'satuan' => $datajson[$key]['satuan'],
                'harga_satuan' => $datajson[$key]['harga'],
                'jumlah ' => $datajson[$key]['jumlah'],
                'harga_total' =>  $datajson[$key]['total'],
                'tahun' =>  $tahun,
                'tw' =>  $tw,
            );


            $this->db->insert('tb_saldo_awal', $data);
             
        }

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
        redirect('pengadaan/saldoawal');
    }



}

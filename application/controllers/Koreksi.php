<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koreksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }


    public function index()
    {
        $data['title'] = 'Koreksi Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        

        $this->db->where('status_koreksi', "Aktif"); 
        $dataaktif = $this->db->get('tb_koreksi_ta_nonaktif')->row_array();

        if(!empty($dataaktif))
        {
            $data['koreksiaktif']=$dataaktif ;

            $this->db->where('tahun',$dataaktif['tahun']);
            $this->db->where('bulan',$dataaktif['bulan']);
            $this->db->order_by('nm_sub_unit');
            $dataunit = $this->db->get('tb_koreksi_status')->result_array();
            $data['urusan'] = $dataunit;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('koreksi/index2', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('koreksi/notactive', $data);
            $this->load->view('templates/footer');
        }
    
    }

    public function pilihbidang()
    {
        $kd_urusan = $this->uri->segment(3);
        $kd_bidang = $this->uri->segment(4);
        $kd_unit = $this->uri->segment(5);
        $kd_sub = $this->uri->segment(6);
        $tahun = $this->uri->segment(7);
        $bulan = $this->uri->segment(8);
       
        $array = array('kd_urusan' => $kd_urusan, 'kd_bidang' =>  $kd_bidang, 'kd_unit' => $kd_unit, 'kd_sub' => $kd_sub, 'tahun' => $tahun, 'bulan' => $bulan);
   
        $this->db->where($array);
        $data= $this->db->get('tb_koreksi_status')->row_array();

        $hasil=2;
        if(isset($data['status_koreksi']))
        {
            $hasil=$data['status_koreksi'];
        }

        echo json_encode($hasil);
    }


    public function koreksidetail()
    {
        $data['title'] = 'Detail Koreksi Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        
        $this->db->where('id_k',$this->uri->segment(3));
        $skpd= $this->db->get('tb_koreksi_status')->row_array();

        $array = array('kd_urusan' => $skpd['kd_urusan'], 'kd_bidang' =>  $skpd['kd_bidang'], 'kd_unit' => $skpd['kd_unit'], 'kd_sub' => $skpd['kd_sub'], 'tahun' => $skpd['tahun'], 'bulan' => $skpd['bulan']);
        $this->db->where($array);
        $data['koreksi']= $this->db->get('tb_koreksi_saldo_awal')->result_array();
        $data['skpd']=$skpd;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('koreksi/koreksidetail', $data);
        $this->load->view('templates/footer');
    }


    public function dokoreksidetail()
    {
        $data['title'] = 'Detail Koreksi Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        

        $data = [
            'harga_koreksi' => str_replace(',','',$this->input->post('harga')),
            'jumlah_koreksi' => $this->input->post('jumlah'),
            'harga_total_koreksi' => str_replace(',','',$this->input->post('total'))
        ];
        $this->db->where('id_koreksi',$this->uri->segment(3));
        $this->db->update('tb_koreksi_saldo_awal',$data);

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dikoreksi</div>');
        redirect('Koreksi/koreksidetail/'.$this->uri->segment(4));
    }

    public function selesaikoreksi()
    {
        
        $this->db->where('status_koreksi', "Aktif"); 
        $dataaktif = $this->db->get('tb_koreksi_ta_nonaktif')->row_array();
        $tahun=$dataaktif['tahun'];
        $bulan=$dataaktif['bulan'];

        $bulanfix='';
        $tahunfix='';
        if($bulan=='Januari')
        {
            $bulanfix='Februari';
            $tahunfix=$tahun;
        }
        else if($bulan=='Februari')
        {
            $bulanfix='Maret';
            $tahunfix=$tahun;
        }
        else if($bulan=='Maret')
        {
            $bulanfix='April';
            $tahunfix=$tahun;
        }
        else if($bulan=='April')
        {
            $bulanfix='Mei';
            $tahunfix=$tahun;
        }
        else if($bulan=='Mei')
        {
            $bulanfix='Juni';
            $tahunfix=$tahun;
        }
        else if($bulan=='Juni')
        {
            $bulanfix='Juli';
            $tahunfix=$tahun;
        }
        else if($bulan=='Juli')
        {
            $bulanfix='Agusutus';
            $tahunfix=$tahun;
        }
        else if($bulan=='Agustus')
        {
            $bulanfix='September';
            $tahunfix=$tahun;
        }
        else if($bulan=='September')
        {
            $bulanfix='Oktober';
            $tahunfix=$tahun;
        }
        else if($bulan=='Oktober')
        {
            $bulanfix='November';
            $tahunfix=$tahun;
        }
        else if($bulan=='November')
        {
            $bulanfix='Desember';
            $tahunfix=$tahun;
        }
        else if($bulan=='Desember')
        {
            $bulanfix='Januari';
            $tahunfix=$tahun+1;
        }

        $query="INSERT INTO tb_saldo_awal (kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_pengadaan,kd_komponen,kd_uraian,uraian_komponen,satuan,harga_satuan_da,jumlah,harga_total,tahun_sebelumnya,bulan_sebelumnya,tahun_saldo_awal,bulan_saldo_awal,kd_sumber,kd_koreksi,harga_koreksi,jumlah_koreksi,harga_total_koreksi) SELECT kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_pengadaan,kd_komponen,kd_uraian,uraian_komponen,satuan,harga_satuan_da,jumlah,harga_total,tahun,bulan,'$tahunfix','$bulanfix',kd_sumber,kd_koreksi,harga_koreksi,jumlah_koreksi,harga_total_koreksi from tb_koreksi_saldo_awal where tahun='$tahun' and bulan='$bulan'";
        $this->db->query($query);

        $data = [
            'status_koreksi' => '1',
        ];
        $this->db->where('tahun',$tahun);
        $this->db->where('bulan',$bulan);
        $this->db->update('tb_koreksi_status',$data);

        $data = [
            'status_koreksi' => 'Tidak Aktif',
        ];
        $this->db->where('status_koreksi','Aktif');
        $this->db->update('tb_koreksi_ta_nonaktif',$data);

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Selesai Melakukan Koreksi</div>');
        redirect('Managemen/managemenTA');
    }

  


}

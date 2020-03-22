<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Managemen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }
    public function index()
    {
        $data['title'] = 'Tahun Anggaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['ta'] = $this->db->get('tb_tahun')->result_array();

        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('managemen/index', $data);
            $this->load->view('templates/footer');
        } else {

            $this->db->select('*'); 
            $this->db->from('tb_tahun');
            $this->db->where('tahun', $this->input->post('tahun'));
            $query = $this->db->get();
            $result = $query->result_array();
            $count = count( $result);
            if (!empty($count))
            {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Tahun sudah pernah ditambahkan</div>');
                redirect('managemen');
            }
            else
            {
                $this->db->insert('tb_tahun', ['tahun' => $this->input->post('tahun')]);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Tahun anggaran ditambahkan</div>');
                redirect('managemen');
            }
            
        }
    }

    public function edittahun()
    {
        $data['title'] = 'Tahun Anggaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

       
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('managemen/tahun', $data);
            $this->load->view('templates/footer');
        } else {
            $id_tahun = $this->input->post('id_tahun');
            $tahun = $this->input->post('tahun');

            $data = array(
                'id_tahun' => $id_tahun,
                'tahun' => $tahun
            );

            $this->db->where('id_tahun', $id_tahun);
            $this->db->update('tb_tahun', $data);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil diubah</div>');
            redirect('managemen');
        }
    }

    public function deletetahun()
    {
        $id['id_tahun'] = $this->uri->segment(3);
		$this->db->delete('tb_tahun', $id);
		$this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
		redirect('managemen');
    }


    public function managementa()
    {
        $data['title'] = 'Managemen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif");
        $data['managementa'] = $this->db->get('tb_managementa')->row_array();

        //memilih tahun anggaran yang sudah memiliki TW 4
        $query ="SELECT tahun from tb_managementa where bulan='Desember'";
        $result=$this->db->query($query)->result_array();
        //masukan tahun tersebut dalam array
        $removetahun=array();
        foreach ($result as $key=>$value)
        {
            array_push($removetahun,$value['tahun']);
        }

        $tahunsekarang=date("Y");

        //jika tahun yang punya tw 4 tidak kosong
        if(!empty($removetahun))
        {
            $this->db->where('tahun>=', $tahunsekarang);
            $this->db->where_not_in('tahun', $removetahun);
            $data['ta']= $this->db->get('tb_tahun')->result_array();
        }
        else //else kosong
        {
            $this->db->where('tahun>=', $tahunsekarang);
            $data['ta']= $this->db->get('tb_tahun')->result_array();
        }

     
       
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('managemen/managemenTA', $data);
            $this->load->view('templates/footer');
        } else {

            $tahun = $this->input->post('tahun');
            $bulan =$this->input->post('bulan');
            $kd_bulan='';
            if($bulan=='Januari')
            {
                $kd_bulan=1;
            }
            else if($bulan=='Februari')
            {
                $kd_bulan=2;
            }
            else if($bulan=='Maret')
            {
                $kd_bulan=3;
            }
            else if($bulan=='April')
            {
                $kd_bulan=4;
            }
            else if($bulan=='Mei')
            {
                $kd_bulan=5;
            }
            else if($bulan=='Juni')
            {
                $kd_bulan=6;
            }
            else if($bulan=='Juli')
            {
                $kd_bulan=7;
            }
            else if($bulan=='Agustus')
            {
                $kd_bulan=8;
            }
            else if($bulan=='September')
            {
                $kd_bulan=9;
            }
            else if($bulan=='Oktober')
            {
                $kd_bulan=10;
            }
            else if($bulan=='November')
            {
                $kd_bulan=11;
            }
            else if($bulan=='Desember')
            {
                $kd_bulan=12;
            }
           
            $status = "Aktif";
            $currentDate = date('Y-m-d');


            $data = array(
                'tahun' => $tahun,
                'kd_bulan' => $kd_bulan,
                'bulan' => $bulan,
                'status' => $status,
                'tgl_aktif' =>$currentDate
            );

            $this->db->insert('tb_managementa', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Berhasil diaktifkan</div>');
            redirect('managemen/managemenTA');
            
        }
    }


    public function ambiltw()
    {
        $tahun['tahun'] = $this->uri->segment(3);
        $this->db->select_max('kd_bulan');
        $this->db->where('tahun', $tahun['tahun']);
        $result = $this->db->get('tb_managementa')->row();  

        echo json_encode($result->kd_bulan);
    }


    public function nonaktifta()
    {          
            //pemindahan data saldo ke data koreksi awal
            $this->db->where('status', "Aktif"); 
            $cektatw = $this->db->get('tb_managementa')->row_array();
            $tahun=$cektatw['tahun'];
            $bulan=$cektatw['bulan'];

            $cek = $this->db->get('tb_koreksi_saldo_awal')->result_array();
            if ($cek > 0) 
            {
                $this->db->select_max('kd_koreksi');
                $this->db->where('tahun', $tahun);
                $result = $this->db->get('tb_koreksi_saldo_awal')->row_array();
                $maxkd = $result['kd_koreksi'];
                $maxkd++;
                $kd = $maxkd++;
            } else 
            {
                $kd = '1';
            }
    
            $query="INSERT INTO tb_koreksi_saldo_awal (kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_pengadaan,kd_komponen,kd_uraian,uraian_komponen,satuan,harga_satuan_da,jumlah,harga_total,tahun,bulan,kd_sumber,kd_koreksi,harga_koreksi,jumlah_koreksi,harga_total_koreksi) SELECT kd_urusan,kd_bidang,kd_unit,kd_sub,kd_jenis,kd_pengadaan,kd_komponen,kd_uraian,uraian_komponen,satuan,harga_satuan_da,jumlah,harga_total,tahun,bulan,kd_sumber,'$kd',harga_satuan_da,jumlah,harga_total from tb_saldo where tahun='$tahun' and bulan='$bulan'";
            $this->db->query($query);

            $query="INSERT INTO tb_koreksi_status (kd_urusan,kd_bidang,kd_unit,kd_sub,tahun,bulan,nm_sub_unit) SELECT kd_urusan,kd_bidang,kd_unit,kd_sub,'$tahun','$bulan',nm_sub_unit from ref_sub_unit ";
            $this->db->query($query);
            
            $this->db->where('tahun',$tahun);
            $this->db->where('bulan',$bulan);
            $this->db->delete('tb_saldo');

            //eksekusi
            $id = $this->uri->segment(3);
            $status = "Tidak Aktif";
            $currentDate = date('Y-m-d');

            $data = array(
            
                'status' => $status,
                'tgl_nonaktif' =>$currentDate
            );

            $this->db->where('id', $id);
            $this->db->update('tb_managementa', $data);


            //simpan ke status koreksi nonaktif
            $dataxx = array(
                'tahun' => $tahun,
                'bulan' =>$bulan,
                'status_koreksi' =>'Aktif',
            );

            $this->db->insert('tb_koreksi_ta_nonaktif', $dataxx);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Berhasil dinonaktifkan</div>');
            redirect('managemen/managemenTA');

    }

}

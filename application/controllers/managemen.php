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

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil update</div>');
            redirect('managemen');
        }
    }

    public function deletetahun()
    {
        $id['id_tahun'] = $this->uri->segment(3);
		$this->db->delete('tb_tahun', $id);
		$this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dihapus</div>');
		redirect('managemen');
    }


    public function managementa()
    {
        $data['title'] = 'Managemen TA';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->db->where('status', "Aktif");
        $data['managementa'] = $this->db->get('tb_managementa')->row_array();

        //memilih tahun anggaran yang sudah memiliki TW 4
        $query ="SELECT tahun from tb_managementa where tw=4";
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
        $this->form_validation->set_rules('tw', 'TW', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('managemen/managemenTA', $data);
            $this->load->view('templates/footer');
        } else {

            $tahun = $this->input->post('tahun');
            $tw =$this->input->post('tw');
            $status = "Aktif";
            $currentDate = date('Y-m-d');


            $data = array(
                'tahun' => $tahun,
                'tw' => $tw,
                'status' => $status,
                'tgl_aktif' =>$currentDate
            );


            $this->db->insert('tb_managementa', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">TW berhasil diaktifkan</div>');
            redirect('managemen/managemenTA');
            
        }
    }


    public function ambiltw()
    {
        $tahun['tahun'] = $this->uri->segment(3);
        $this->db->select_max('tw');
        $this->db->where('tahun', $tahun['tahun']);
        $result = $this->db->get('tb_managementa')->row();  

        echo json_encode($result->tw);
    }


    public function nonaktifta()
    {

            $id = $this->uri->segment(3);
            $tahun = $this->input->post('tahun');
            $tw =$this->input->post('tw');
            $status = "Tidak Aktif";
            $currentDate = date('Y-m-d');

            $data = array(
            
                'status' => $status,
                'tgl_nonaktif' =>$currentDate
            );

            $this->db->where('id', $id);
            $this->db->update('tb_managementa', $data);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">TW berhasil dinonaktifkan</div>');
            redirect('managemen/managemenTA');

    }

}

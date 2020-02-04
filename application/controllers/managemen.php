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
}

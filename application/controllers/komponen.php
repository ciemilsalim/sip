<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Komponen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }
    public function index()
    {
        $data['title'] = 'Jenis Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();

        $this->form_validation->set_rules('jenis_komponen', 'Jenis Komponen', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/index', $data);
            $this->load->view('templates/footer');
        } else {

            $cek = $this->db->get('tb_jenis_komponen')->result_array();

            if ($cek > 0) {
                $this->db->select_max('kd_jenis');
                $result = $this->db->get('tb_jenis_komponen')->row_array();
                $maxkdjenis = $result['kd_jenis'];
                $maxkdjenis++;
                $kd_jenis = $maxkdjenis++;
            } else {
                $kd_jenis = '1';
            }

            $array = array(
                'id' => '',
                'kd_jenis' => $kd_jenis,
                'jenis_komponen' => $this->input->post('jenis_komponen')
            );

            $this->db->insert('tb_jenis_komponen', $array);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Jenis Komponen Baru ditambahkan</div>');
            redirect('komponen');
        }
    }

    public function edit_jenis_komponen()
    {
        $data['title'] = 'Jenis Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();

        $this->form_validation->set_rules('jenis_komponen', 'Jenis Komponen', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/index', $data);
            $this->load->view('templates/footer');
        } else {
            $id['id'] = $this->uri->segment(3);

            $data = [
                'jenis_komponen' => $this->input->post('jenis_komponen'),
            ];

            $this->db->where($id);
            $this->db->update('tb_jenis_komponen', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Jenis Komponen diubah</div>');
            redirect('komponen');
        }
    }

    public function delete_jenis_komponen()
    {
        $id['id'] = $this->uri->segment(3);
        $kdhapus = $this->db->get_where('tb_jenis_komponen', ['id' => $this->uri->segment(3)])->row_array();
        $kd_jenis = $kdhapus['kd_jenis'];

        $hapus = $this->db->delete('tb_jenis_komponen', $id);

        if ($hapus) {
            $this->db->where('kd_jenis', $kd_jenis);
            $hapus2 = $this->db->delete('tb_komponen');
            if ($hapus2) {
                $this->db->where('kd_jenis', $kd_jenis);
                $this->db->delete('tb_uraian_komponen');
            }
        }

        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
        redirect('komponen');
    }

    public function komponen()
    {
        $data['title'] = 'Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('*');
        $this->db->from('tb_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.kd_jenis = tb_komponen.kd_jenis', 'left');
        $data['komponen'] = $this->db->get()->result_array();

        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();

        $this->form_validation->set_rules('kd_jenis', 'Jenis Komponen', 'required');
        $this->form_validation->set_rules('komponen', 'Komponen', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/komponen', $data);
            $this->load->view('templates/footer');
        } else {

            $cek = $this->db->get('tb_komponen')->result_array();


            if ($cek > 0) {
                $this->db->select_max('kd_komponen');
                $result = $this->db->get('tb_komponen')->row_array();
                $maxid = $result['kd_komponen'];
                $maxid++;
                $kd_komponen = $maxid++;
            } else {
                $kd_komponen = '1';
            }

            $array = array(
                'id' => '',
                'kd_jenis' => $this->input->post('kd_jenis'),
                'kd_komponen' => $kd_komponen,
                'komponen' => $this->input->post('komponen')
            );

            $this->db->insert('tb_komponen', $array);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Komponen Baru ditambahkan</div>');
            redirect('komponen/komponen');
        }
    }

    public function edit_komponen()
    {
        $data['title'] = 'Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();

        $this->db->select('*');
        $this->db->from('tb_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.kd_jenis = tb_komponen.kd_jenis', 'left');
        $data['komponen'] = $this->db->get()->result_array();

        //$data['komponen'] = $this->db->get('tb_komponen')->result_array();

        //$this->form_validation->set_rules('kd_jenis', 'Jenis Komponen', 'required');
        $this->form_validation->set_rules('komponen', 'Komponen', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/komponen', $data);
            $this->load->view('templates/footer');
        } else {
            $id['kd_komponen'] = $this->uri->segment(3);

            $data = [
                'komponen' => $this->input->post('komponen'),
            ];

            $this->db->where($id);
            $this->db->update('tb_komponen', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert"> Komponen diubah</div>');
            redirect('komponen/komponen');
        }
    }

    public function delete_komponen()
    {
        $id['kd_komponen'] = $this->uri->segment(3);
        $kdhapus = $this->db->get_where('tb_komponen', ['kd_komponen' => $this->uri->segment(3)])->row_array();
        $kd_komponen = $kdhapus['kd_komponen'];

        $hapus = $this->db->delete('tb_komponen', $id);

        if ($hapus) {
            $this->db->where('kd_komponen', $kd_komponen);
            $this->db->delete('tb_uraian_komponen');
        }



        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
        redirect('komponen/komponen');
    }


    public function uraian_komponen()
    {
        $data['title'] = 'Uraian Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('*');
        $this->db->from('tb_uraian_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.kd_jenis = tb_uraian_komponen.kd_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.kd_komponen = tb_uraian_komponen.kd_komponen', 'left');
        $data['uraian_komponen'] = $this->db->get()->result_array();

        $data['komponen'] = $this->db->get('tb_komponen')->result_array();

        $this->form_validation->set_rules('kd_komponen', 'Komponen', 'required');
        $this->form_validation->set_rules('uraian_komponen', 'Uraian Komponen', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/uraian_komponen', $data);
            $this->load->view('templates/footer');
        } else {



            $cek = $this->db->get('tb_uraian_komponen')->result_array();
            if ($cek > 0) {
                $this->db->select_max('kd_uraian');
                $result = $this->db->get('tb_uraian_komponen')->row_array();
                $maxid = $result['kd_uraian'];
                $maxid++;
                $kd_uraian = $maxid++;
            } else {
                $kd_uraian = '1';
            }


            $kdkomponen = $this->db->get_where('tb_komponen', ['kd_komponen' => $this->input->post('kd_komponen')])->row_array();
            $kdjenis = $kdkomponen['kd_jenis'];


            $array = array(
                'id' => '',
                'kd_jenis' => $kdjenis,
                'kd_komponen' => $this->input->post('kd_komponen'),
                'kd_uraian' => $kd_uraian,
                'uraian_komponen' => $this->input->post('uraian_komponen')
            );

            $this->db->insert('tb_uraian_komponen', $array);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">uraian Komponen Baru ditambahkan</div>');
            redirect('komponen/uraian_komponen');
        }
    }

    public function edit_uraian_komponen()
    {
        $data['title'] = 'Uraian Komponen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();
        $data['komponen'] = $this->db->get('tb_komponen')->result_array();

        $this->db->select('*');
        $this->db->from('tb_uraian_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.kd_jenis = tb_uraian_komponen.kd_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.kd_komponen = tb_uraian_komponen.kd_komponen', 'left');
        $data['uraian_komponen'] = $this->db->get()->result_array();


        $this->form_validation->set_rules('uraian_komponen', 'Uraian Komponen', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/uraian_komponen', $data);
            $this->load->view('templates/footer');
        } else {
            $kduraian = $id['kd_uraian'] = $this->uri->segment(3);

            $data = [
                'uraian_komponen' => $this->input->post('uraian_komponen'),
            ];

            $this->db->where('kd_uraian', $kduraian);
            $this->db->update('tb_uraian_komponen', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Uraian Komponen diubah</div>');
            redirect('komponen/uraian_komponen');
        }
    }

    public function delete_uraian_komponen()
    {
        $kduraian = $id['kd_uraian'] = $this->uri->segment(3);
        $this->db->where('kd_uraian', $kduraian);
        $this->db->delete('tb_uraian_komponen');
        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
        redirect('komponen/uraian_komponen');
    }
}

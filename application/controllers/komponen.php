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
                'id_jenis' => '',
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
            $id['id_jenis'] = $this->uri->segment(3);

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
        $idjenis = $this->uri->segment(3);
        $this->db->where('id_jenis', $idjenis);
        $hapus = $this->db->delete('tb_jenis_komponen');

        if ($hapus) {
            $this->db->where('id_jenis', $idjenis);
            $hapus2 = $this->db->delete('tb_komponen');
            if ($hapus2) {
                $this->db->where('id_jenis', $idjenis);
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
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_komponen.id_jenis', 'left');
        $data['komponen'] = $this->db->get()->result_array();

        $data['jenis_komponen'] = $this->db->get('tb_jenis_komponen')->result_array();

        $this->form_validation->set_rules('id_jenis', 'Jenis Komponen', 'required');
        $this->form_validation->set_rules('komponen', 'Komponen', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/komponen', $data);
            $this->load->view('templates/footer');
        } else {

            $cek = $this->db->get('tb_komponen')->result_array();
            $idjenis = $this->input->post('id_jenis');

            if ($idjenis > 0) {
                $this->db->where('id_jenis', $idjenis);
                $kodejenis = $this->db->get('tb_jenis_komponen')->row_array();
                $kdjenis = $kodejenis['kd_jenis'];
            }


            if ($cek > 0) {
                $this->db->select_max('kd_komponen');
                $this->db->where('kd_jenis', $kdjenis);
                $result = $this->db->get('tb_komponen')->row_array();
                $maxid = $result['kd_komponen'];
                $maxid++;
                $kd_komponen = $maxid++;
            } else {
                $kd_komponen = '1';
            }

            $array = array(
                'id_komponen' => '',
                'id_jenis' => $idjenis,
                'kd_jenis' => $kdjenis,
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

        $this->form_validation->set_rules('komponen', 'Komponen', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/komponen', $data);
            $this->load->view('templates/footer');
        } else {
            $idkomponen = $this->uri->segment(3);

            $data = [
                'komponen' => $this->input->post('komponen'),
            ];

            $this->db->where('id_komponen', $idkomponen);
            $this->db->update('tb_komponen', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert"> Komponen diubah</div>');
            redirect('komponen/komponen');
        }
    }

    public function delete_komponen()
    {
        $idkomponen = $this->uri->segment(3);
        $this->db->where('id_komponen', $idkomponen);
        $hapus = $this->db->delete('tb_komponen');

        if ($hapus) {
            $this->db->where('id_komponen', $idkomponen);
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

        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_uraian_komponen.id_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.id_komponen = tb_uraian_komponen.id_komponen', 'left');
        $this->db->order_by('tb_jenis_komponen.kd_jenis');
        $this->db->order_by('tb_komponen.kd_komponen');
        $data['uraian_komponen'] = $this->db->get()->result_array();

        $data['komponen'] = $this->db->get('tb_komponen')->result_array();

        $this->form_validation->set_rules('id_komponen', 'Komponen', 'required');
        $this->form_validation->set_rules('uraian_komponen', 'Uraian Komponen', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/uraian_komponen', $data);
            $this->load->view('templates/footer');
        } else {



            $cek = $this->db->get('tb_uraian_komponen')->result_array();
            $idkomponen = $this->input->post('id_komponen');

            if ($idkomponen > 0) {
                $this->db->where('id_komponen', $idkomponen);
                $datakomponen = $this->db->get('tb_komponen')->row_array();
                $kd_komponen = $datakomponen['kd_komponen'];
                $kdjenis = $datakomponen['kd_jenis'];
                $idjenis = $datakomponen['id_jenis'];
            }


            if ($cek > 0) {
                $this->db->select_max('kd_uraian');
                $this->db->where('kd_komponen', $kd_komponen);
                $this->db->where('id_komponen', $idkomponen);
                $result = $this->db->get('tb_uraian_komponen')->row_array();
                $maxid = $result['kd_uraian'];
                $maxid++;
                $kd_uraian = $maxid++;
            } else {
                $kd_uraian = '1';
            }

            $harga=$this->input->post('harga');
            echo $hargafinal = str_replace(array('.',' '), '',$harga);

            $array = array(
                'id_uraian' => '',
                'id_jenis' => $idjenis,
                'id_komponen' => $idkomponen,
                'kd_jenis' => $kdjenis,
                'kd_komponen' => $kd_komponen,
                'kd_uraian' => $kd_uraian,
                'uraian_komponen' => $this->input->post('uraian_komponen'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $hargafinal
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
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_uraian_komponen.id_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.id_komponen = tb_uraian_komponen.id_komponen', 'left');
        $data['uraian_komponen'] = $this->db->get()->result_array();


        $this->form_validation->set_rules('uraian_komponen', 'Uraian Komponen', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('komponen/uraian_komponen', $data);
            $this->load->view('templates/footer');
        } else {
            $iduraian = $id['id_uraian'] = $this->uri->segment(3);
            $harga=$this->input->post('harga');
            echo $hargafinal = str_replace(array('.',' '), '',$harga);

            $data = [
                'uraian_komponen' => $this->input->post('uraian_komponen'),
                'satuan' => $this->input->post('satuan'),
                'harga'=> $hargafinal
            ];

            $this->db->where('id_uraian', $iduraian);
            $this->db->update('tb_uraian_komponen', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Uraian Komponen diubah</div>');
            redirect('komponen/uraian_komponen');
        }
    }

    public function delete_uraian_komponen()
    {
        $iduraian = $id['id_uraian'] = $this->uri->segment(3);
        $this->db->where('id_uraian', $iduraian);
        $this->db->delete('tb_uraian_komponen');
        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
        redirect('komponen/uraian_komponen');
    }
}

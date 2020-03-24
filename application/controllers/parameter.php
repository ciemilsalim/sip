<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parameter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }
    public function index()
    {
        $data['title'] = 'Identitas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        // $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim|numeric');
        $this->form_validation->set_rules('nama_pemda', 'Nama Pemda', 'required|trim');
        $this->form_validation->set_rules('ibu_kota', 'Ibu Kota', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->db->where('tahun', $this->session->userdata('tahun'));
            $data['identitas'] = $this->db->get('tb_pemda')->row_array();

            $data['identitas']['tahun'] = $this->session->userdata('tahun');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/index', $data);
            $this->load->view('templates/footer');
        } else {

            $query = "SELECT *FROM tb_pemda where tahun=" . $this->session->userdata('tahun');
            $result = $this->db->query($query)->result_array();
            $count = count($result);


            if (!empty($count)) {
                $this->edit();
            } else {

                $tahun = $this->input->post('tahun');
                $nama_pemda = $this->input->post('nama_pemda');
                $ibu_kota = $this->input->post('ibu_kota');
                $alamat = $this->input->post('alamat');

                //cek gambar
                $upload_image = $_FILES['logo']['name'];
                if ($upload_image) {
                    $config['allowed_types'] = 'gif|png|jpg';
                    $config['max_size'] = '2040';
                    $config['upload_path'] = './assets/img/logo/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('logo')) {

                        $old_image = $data['user']['logo'];
                        if ($old_image != 'default.jpg') {
                            unlink(FCPATH . 'assets/img/logo/' . $old_image);
                        }

                        $new_image = $this->upload->data('file_name');
                        $this->db->set('logo', $new_image);
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                $data = array(
                    'tahun' => $this->session->userdata('tahun'),
                    'nama_pemda' => $nama_pemda,
                    'ibu_kota' => $ibu_kota,
                    'alamat' => $alamat
                );


                $this->db->insert('tb_pemda', $data);

                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil disimpan</div>');
                redirect('parameter');
            }
        }
    }

    public function edit()
    {
        $data['title'] = 'Edit Identitas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $tahun = $this->session->userdata('tahun');
        $nama_pemda = $this->input->post('nama_pemda');
        $ibu_kota = $this->input->post('ibu_kota');
        $alamat = $this->input->post('alamat');

        //cek gambar
        $upload_image = $_FILES['logo']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|png|jpg';
            $config['max_size'] = '2040';
            $config['upload_path'] = './assets/img/logo/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {

                $old_image = $data['user']['logo'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/logo/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('logo', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }

        $data = array(
            'nama_pemda' => $nama_pemda,
            'ibu_kota' => $ibu_kota,
            'alamat' => $alamat
        );


        $this->db->where('tahun', $tahun);
        $this->db->update('tb_pemda', $data);

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil diubah</div>');
        redirect('parameter');
    }


    public function skpd()
    {
        $data['title'] = 'Identitas SKPD';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('nama_skpd', 'Nama SKPD', 'required');
        $this->form_validation->set_rules('alamat_skpd', 'Alamat SKPD', 'required');
        $this->form_validation->set_rules('nip', 'nip', 'required');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('alamat_pimpinan', 'Alamat Pimpinan', 'required');

        if ($this->form_validation->run() == false) {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

            $this->db->where($array);

            $data['skpd'] = $this->db->get('tb_skpd')->row_array();
            $data['skpd']['tahun'] = $this->session->userdata('tahun');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/skpd', $data);
            $this->load->view('templates/footer');
        } else {
            $query = "SELECT *FROM tb_skpd where tahun=" . $this->session->userdata('tahun');
            $result = $this->db->query($query)->result_array();
            $count = count($result);


            if (!empty($count)) {
                $this->editskpd();
            } else {

                $tahun = $this->session->userdata('tahun');
                $kd_urusan = $this->session->userdata('kd_urusan');
                $kd_bidang = $this->session->userdata('kd_bidang');
                $kd_unit = $this->session->userdata('kd_unit');
                $kd_sub = $this->session->userdata('kd_sub');
                $nama_skpd = $this->input->post('nama_skpd');
                $alamat_skpd = $this->input->post('alamat_skpd');
                $nip_pimpinan = $this->input->post('nip');
                $nama_pimpinan = $this->input->post('nama_pimpinan');
                $jabatan = $this->input->post('jabatan');
                $alamat_pimpinan = $this->input->post('alamat_pimpinan');

                //cek gambar
                $upload_image = $_FILES['foto']['name'];
                if ($upload_image) {
                    $config['allowed_types'] = 'gif|png|jpg';
                    $config['max_size'] = '2040';
                    $config['upload_path'] = './assets/img/foto/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('foto')) {

                        $old_image = $data['user']['foto'];
                        if ($old_image != 'default.jpg') {
                            unlink(FCPATH . 'assets/img/foto/' . $old_image);
                        }

                        $new_image = $this->upload->data('file_name');
                        $this->db->set('foto', $new_image);
                    } else {
                        echo $this->upload->display_errors();
                    }
                }


                $data = array(
                    'id' => '',
                    'tahun' => $tahun,
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    'nama_skpd' => $nama_skpd,
                    'alamat_skpd' => $alamat_skpd,
                    'nip_pimpinan' => $nip_pimpinan,
                    'nama_pimpinan' => $nama_pimpinan,
                    'jabatan' => $jabatan,
                    'alamat_pimpinan' => $alamat_pimpinan
                );


                $this->db->insert('tb_skpd', $data);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                redirect('parameter/skpd');
            }
        }
    }

    public function editskpd()
    {
        $data['title'] = 'Edit Identitas SKPD';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id = $this->input->post('id');
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');
        $nama_skpd = $this->input->post('nama_skpd');
        $alamat_skpd = $this->input->post('alamat_skpd');
        $nip_pimpinan = $this->input->post('nip');
        $nama_pimpinan = $this->input->post('nama_pimpinan');
        $jabatan = $this->input->post('jabatan');
        $alamat_pimpinan = $this->input->post('alamat_pimpinan');

        //cek gambar
        $upload_image = $_FILES['foto']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|png|jpg';
            $config['max_size'] = '2040';
            $config['upload_path'] = './assets/img/foto/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {

                $old_image = $data['user']['foto'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/foto/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('foto', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }

        $data = array(
            'kd_urusan' => $kd_urusan,
            'kd_bidang' => $kd_bidang,
            'kd_unit' => $kd_unit,
            'kd_sub' => $kd_sub,
            'nama_skpd' => $nama_skpd,
            'alamat_skpd' => $alamat_skpd,
            'nip_pimpinan' => $nip_pimpinan,
            'nama_pimpinan' => $nama_pimpinan,
            'jabatan' => $jabatan,
            'alamat_pimpinan' => $alamat_pimpinan
        );



        $this->db->where('id', $id);
        $this->db->update('tb_skpd', $data);

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
        redirect('parameter/skpd');
    }



    public function program()
    {
        $data['title'] = 'Program';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Program_model', 'objprogram');

        $data['program'] = $this->objprogram->getProgram($this->session->userdata('kd_urusan'), $this->session->userdata('kd_bidang'));


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('parameter/program', $data);
        $this->load->view('templates/footer');
    }



    public function kegiatan()
    {
        $data['title'] = 'Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Kegiatan_model', 'objkegiatan');

        $data['kegiatan'] = $this->objkegiatan->getKegiatan($this->session->userdata('kd_urusan'), $this->session->userdata('kd_bidang'));


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('parameter/kegiatan', $data);
        $this->load->view('templates/footer');
    }


    public function penanggungJawab()
    {
        $data['title'] = 'Penanggung Jawab';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nip1', 'NIP', 'required');
        $this->form_validation->set_rules('nama1', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan1', 'Jabatan', 'required');
        $this->form_validation->set_rules('nip2', 'NIP', 'required');
        $this->form_validation->set_rules('nama2', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan2', 'Jabatan', 'required');
        $this->form_validation->set_rules('nip3', 'NIP', 'required');
        $this->form_validation->set_rules('nama3', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan3', 'Jabatan', 'required');

        if ($this->form_validation->run() == false) {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

            $this->db->where($array);
            $this->db->where('kd_jabatan', '1');
            $data['kode1'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where($array);
            $this->db->where('kd_jabatan', '2');
            $data['kode2'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where($array);
            $this->db->where('kd_jabatan', '3');
            $data['kode3'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penanggungJawab', $data);
            $this->load->view('templates/footer');
        } else {
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
            $nip1 = $this->input->post('nip1');
            $nama1 = $this->input->post('nama1');
            $jabatan1 = $this->input->post('jabatan1');
            $nip2 = $this->input->post('nip2');
            $nama2 = $this->input->post('nama2');
            $jabatan2 = $this->input->post('jabatan2');
            $nip3 = $this->input->post('nip3');
            $nama3 = $this->input->post('nama3');
            $jabatan3 = $this->input->post('jabatan3');


            $data1 = array(
                'id' => '',
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '1',
                'nip' => $nip1,
                'nama' => $nama1,
                'jabatan' => $jabatan1,
            );

            $data2 = array(
                'id' => '',
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '2',
                'nip' => $nip2,
                'nama' => $nama2,
                'jabatan' => $jabatan2,
            );

            $data3 = array(
                'id' => '',
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '3',
                'nip' => $nip3,
                'nama' => $nama3,
                'jabatan' => $jabatan3,
            );


            $this->db->insert('tb_penanggung_jawab', $data1);
            $this->db->insert('tb_penanggung_jawab', $data2);
            $this->db->insert('tb_penanggung_jawab', $data3);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/penanggungJawab');
        }
    }


    public function editpenanggungJawab()
    {
        $data['title'] = 'Penaggung Jawab';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nip1', 'NIP', 'required');
        $this->form_validation->set_rules('nama1', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan1', 'Jabatan', 'required');
        $this->form_validation->set_rules('nip2', 'NIP', 'required');
        $this->form_validation->set_rules('nama2', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan2', 'Jabatan', 'required');
        $this->form_validation->set_rules('nip3', 'NIP', 'required');
        $this->form_validation->set_rules('nama3', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan3', 'Jabatan', 'required');

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $this->db->where('kd_jabatan', '1');
            $data['kode1'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where($array);
            $this->db->where('kd_jabatan', '2');
            $data['kode2'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where($array);
            $this->db->where('kd_jabatan', '3');
            $data['kode3'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penanggungJawab', $data);
            $this->load->view('templates/footer');
        } else {
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
            $nip1 = $this->input->post('nip1');
            $nama1 = $this->input->post('nama1');
            $jabatan1 = $this->input->post('jabatan1');
            $nip2 = $this->input->post('nip2');
            $nama2 = $this->input->post('nama2');
            $jabatan2 = $this->input->post('jabatan2');
            $nip3 = $this->input->post('nip3');
            $nama3 = $this->input->post('nama3');
            $jabatan3 = $this->input->post('jabatan3');


            $data1 = array(
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '1',
                'nip' => $nip1,
                'nama' => $nama1,
                'jabatan' => $jabatan1,
            );

            $data2 = array(
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '2',
                'nip' => $nip2,
                'nama' => $nama2,
                'jabatan' => $jabatan2,
            );

            $data3 = array(
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_jabatan' => '3',
                'nip' => $nip3,
                'nama' => $nama3,
                'jabatan' => $jabatan3,
            );



            $this->db->where($array);

            $this->db->where('kd_jabatan', '1');
            $this->db->update('tb_penanggung_jawab', $data1);

            $this->db->where('kd_jabatan', '2');
            $this->db->update('tb_penanggung_jawab', $data2);

            $this->db->where('kd_jabatan', '3');
            $this->db->update('tb_penanggung_jawab', $data3);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/penanggungJawab');
        }
    }



    public function penyimpanan()
    {
        $data['title'] = 'Penyimpanan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('penyimpanan', 'Penyimpanan', 'required');

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));


        if ($this->form_validation->run() == false) {

            $this->db->where($array);

            $data['penyimpanan'] = $this->db->get('tb_penyimpanan')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penyimpanan', $data);
            $this->load->view('templates/footer');
        } else {
            $tahun = $this->session->userdata('tahun');
            $penyimpanan = $this->input->post('penyimpanan');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data = array(
                'id' => '',
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'nama_gudang' => $penyimpanan,
            );


            $this->db->insert('tb_penyimpanan', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/penyimpanan');
        }
    }


    public function editPenyimpanan()
    {
        $data['title'] = 'Penyimpanan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('penyimpanan', 'Penyimpanan', 'required');

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));


        if ($this->form_validation->run() == false) {

            $this->db->where($array);

            $data['penyimpanan'] = $this->db->get('tb_penyimpanan')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penyimpanan', $data);
            $this->load->view('templates/footer');
        } else {

            $id = $this->input->post('id');
            $tahun = $this->session->userdata('tahun');
            $penyimpanan = $this->input->post('penyimpanan');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'nama_gudang' => $penyimpanan,
            );

            $this->db->where('id', $id);
            $this->db->update('tb_penyimpanan', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/penyimpanan');
        }
    }


    public function bidang()
    {
        $data['title'] = 'Bidang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $array = array(
            'kd_urusan' => $this->session->userdata('kd_urusan'),
            'kd_bidang' => $this->session->userdata('kd_bidang'),
            'kd_unit' => $this->session->userdata('kd_unit'),
            'kd_sub' => $this->session->userdata('kd_sub'),
            'tahun' => $this->session->userdata('tahun')
        );

        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $data['bidang'] = $this->db->get('tb_bidang')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/bidang', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_bidang = $this->input->post('nama_bidang');
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');


            $cek = $this->db->get('tb_bidang')->result_array();

            if ($cek > 0) {
                $this->db->select_max('kd_bid_skpd');
                $this->db->where($array);
                $result = $this->db->get('tb_bidang')->row_array();
                $maxkdjenis = $result['kd_bid_skpd'];
                $maxkdjenis++;
                $no = $maxkdjenis++;
            } else {
                $no = '1';
            }



            $data = array(
                'id_bidang' => '',
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_bid_skpd' => $no,
                'nama_bidang' => $nama_bidang
            );


            $this->db->insert('tb_bidang', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/bidang');
        }
    }


    public function editbidang()
    {
        $data['title'] = 'Bidang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $data['bidang'] = $this->db->get('tb_bidang')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/bidang', $data);
            $this->load->view('templates/footer');
        } else {
            $id_bidang['kd_bid_skpd'] = $this->uri->segment(3);
            $nama_bidang = $this->input->post('nama_bidang');

            $data = array(
                'nama_bidang' => $nama_bidang
            );

            $this->db->where($array);
            $this->db->where($id_bidang);
            $this->db->update('tb_bidang', $data);


            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/bidang');
        }
    }


    public function deletebidang()
    {
        $id['kd_bid_skpd'] = $this->uri->segment(3);
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        $this->db->where($array);
        $this->db->delete('tb_bidang', $id);
        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dihapus</div>');
        redirect('parameter/bidang');
    }


    public function kepalabidang()
    {
        $data['title'] = 'Kepala Bidang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nip', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $bidang = $this->db->get('tb_bidang')->result_array();

            $array1 = array('tb_kepala_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_kepala_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_kepala_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_kepala_bidang.kd_sub' => $this->session->userdata('kd_sub'), 'tb_kepala_bidang.tahun' => $this->session->userdata('tahun'));
            $array1 = array('tb_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_bidang.kd_sub' => $this->session->userdata('kd_sub'), 'tb_bidang.tahun' => $this->session->userdata('tahun'));
            $this->db->select('*');
            $this->db->from('tb_kepala_bidang');
            $this->db->join('tb_bidang', 'tb_kepala_bidang.kd_bid_skpd = tb_bidang.kd_bid_skpd');
            $this->db->where($array1);
            $data['kbidang'] = $this->db->get()->result_array();

            $data['bidang'] = array();


            foreach ($bidang as $key1 => $arr) {
                $this->db->select('*');
                $this->db->from('tb_kepala_bidang');
                $this->db->where($array);
                $this->db->where('kd_bid_skpd', $arr['kd_bid_skpd']);
                $query = $this->db->get();
                $result = $query->result_array();
                $count = count($result);
                if (empty($count)) {
                    $data['bidang'][$arr['kd_bid_skpd']] = $arr['nama_bidang'];
                }
            }


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/kepalaBidang', $data);
            $this->load->view('templates/footer');
        } else {
            $kd_bid_skpd = $this->input->post('nama_bidang');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data = array(
                'tahun' => $this->session->userdata('tahun'),
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_bid_skpd' => $kd_bid_skpd,
                'kd_kep_bid_skpd' => $kd_bid_skpd,
                'nip' => $nip,
                'nama' => $nama
            );


            $this->db->insert('tb_kepala_bidang', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/kepalaBidang');
        }
    }


    public function editkbidang()
    {
        $data['title'] = 'Kepala Bidang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nip', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $bidang = $this->db->get('tb_bidang')->result_array();

            $array1 = array('tb_kepala_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_kepala_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_kepala_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_kepala_bidang.kd_sub' => $this->session->userdata('kd_sub'), 'tb_kepala_bidang.tahun' => $this->session->userdata('tahun'));
            $array1 = array('tb_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_bidang.kd_sub' => $this->session->userdata('kd_sub'), 'tb_bidang.tahun' => $this->session->userdata('tahun'));
            $this->db->select('*');
            $this->db->from('tb_kepala_bidang');
            $this->db->join('tb_bidang', 'tb_kepala_bidang.kd_bid_skpd = tb_bidang.kd_bid_skpd');
            $this->db->where($array1);
            $data['kbidang'] = $this->db->get()->result_array();

            $data['bidang'] = array();


            foreach ($bidang as $key1 => $arr) {
                $this->db->select('*');
                $this->db->from('tb_kepala_bidang');
                $this->db->where($array);
                $this->db->where('kd_bid_skpd', $arr['kd_bid_skpd']);
                $query = $this->db->get();
                $result = $query->result_array();
                $count = count($result);
                if (empty($count)) {
                    $data['bidang'][$arr['kd_bid_skpd']] = $arr['nama_bidang'];
                }
            }


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/kepalaBidang', $data);
            $this->load->view('templates/footer');
        } else {
            $id_kbidang = $this->uri->segment(3);
            $id_bidang = $this->input->post('nama_bidang');
            $kd_kep_bidang = $this->input->post('nama_bidang');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data = array(
                'tahun' => $kd_urusan,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_bid_skpd' => $id_bidang,
                'kd_kep_bid_skpd' => $kd_kep_bidang,
                'nip' => $nip,
                'nama' => $nama
            );

            $this->db->where('id_kepala_bidang', $id_kbidang);
            $this->db->update('tb_kepala_bidang', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/kepalaBidang');
        }
    }


    public function deletekbidang()
    {
        $id['id_kepala_bidang'] = $this->uri->segment(3);
        $this->db->delete('tb_kepala_bidang', $id);
        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dihapus</div>');
        redirect('parameter/kepalaBidang');
    }


    public function belanja()
    {
        $data['title'] = 'Sub Belanja';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('nama_belanja', 'Sub Belanja', 'required');
        $this->form_validation->set_rules('master_belanja', 'Belanja', 'required');

        if ($this->form_validation->run() == false) {


            $this->db->select('*');
            $this->db->from('tb_belanja a');
            $this->db->join('tb_belanja_master b', 'b.kd_belanja_master = a.kd_belanja_master', 'left');
            $this->db->order_by('b.kd_belanja_master');
            $data['belanja'] = $this->db->get()->result_array();

            $data['master'] = $this->db->get('tb_belanja_master')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/belanja', $data);
            $this->load->view('templates/footer');
        } else {
            $master = $this->input->post('master_belanja');
            $nama_belanja = $this->input->post('nama_belanja');
            $kd_belanja = $this->input->post('kd_belanja');

            $this->db->where('kd_belanja',$kd_belanja);
            $query = $this->db->get('tb_belanja');
            if ($query->num_rows() <=0)
            {
                $data = array(
                    'id_belanja' => '',
                    'kd_belanja_master' => $master,
                    'kd_belanja' => $kd_belanja,
                    'nama_belanja' =>  $nama_belanja
                );

                $this->db->insert('tb_belanja', $data);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                redirect('parameter/belanja');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Kode Sub Belanja Sudah Pernah Digunakan</div>');
                redirect('parameter/belanja');
            }
            

        }
    }


    public function editbelanja()
    {
        $data['title'] = 'Sub Belanja';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('nama_belanja', 'Nama Belanja', 'required');

        if ($this->form_validation->run() == false) {

            $data['belanja'] = $this->db->get('tb_belanja')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/belanja', $data);
            $this->load->view('templates/footer');
        } else {

            $id_belanja['id_belanja'] = $this->uri->segment(3);
            $nama_belanja = $this->input->post('nama_belanja');

            $data = array(
                'nama_belanja' => $nama_belanja
            );

            $this->db->where($id_belanja);
            $this->db->update('tb_belanja', $data);


            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/belanja');
        }
    }


    public function supplier()
    {
        $data['title'] = 'Supplier';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
        $this->form_validation->set_rules('npwp', 'NPWP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $data['supplier'] = $this->db->get('tb_supplier')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_supplier = $this->input->post('nama_supplier');
            $nama_pimpinan = $this->input->post('nama_pimpinan');
            $npwp = $this->input->post('npwp');
            $alamat = $this->input->post('alamat');
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');


            $cek = $this->db->get('tb_bidang')->result_array();

            if ($cek > 0) {
                $this->db->select_max('kd_bid_skpd');
                $result = $this->db->get('tb_bidang')->row_array();
                $maxkdjenis = $result['kd_bid_skpd'];
                $maxkdjenis++;
                $no = $maxkdjenis++;
            } else {
                $no = '1';
            }



            $data = array(
                'tahun' => $tahun,
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'kd_supplier' => $no,
                'nama_supplier' =>  $nama_supplier,
                'nama_pimpinan' =>  $nama_pimpinan,
                'npwp' =>  $npwp,
                'alamat' =>  $alamat
            );


            $this->db->insert('tb_supplier', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/supplier');
        }
    }

    public function editsupplier()
    {
        $data['title'] = 'Supplier';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
        $this->form_validation->set_rules('npwp', 'NPWP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->where($array);
            $data['supplier'] = $this->db->get('tb_supplier')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $id['id'] = $this->uri->segment(3);
            $nama_supplier = $this->input->post('nama_supplier');
            $nama_pimpinan = $this->input->post('nama_pimpinan');
            $npwp = $this->input->post('npwp');
            $alamat = $this->input->post('alamat');

            $data = array(
                'nama_supplier' =>  $nama_supplier,
                'nama_pimpinan' =>  $nama_pimpinan,
                'npwp' =>  $npwp,
                'alamat' =>  $alamat
            );


            $this->db->where($array);
            $this->db->where($id);
            $this->db->update('tb_supplier', $data);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/supplier');
        }
    }



    public function sumberdana()
    {
        $data['title'] = 'Sumber Dana';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('nama_sumber', 'Nama Sumber', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->order_by('nama_sumber');
            $data['sumberdana'] = $this->db->get('tb_sumber_dana')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/sumberdana', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_bidang = $this->input->post('nama_sumber');
         
            $cek = $this->db->get('tb_sumber_dana')->result_array();

            if ($cek > 0) {
                $this->db->select_max('kd_sumber');
                $result = $this->db->get('tb_sumber_dana')->row_array();
                $maxkdjenis = $result['kd_sumber'];
                $maxkdjenis++;
                $no = $maxkdjenis++;
            } else {
                $no = '1';
            }



            $data = array(
                'kd_sumber' => $no,
                'nama_sumber' => $nama_bidang
            );


            $this->db->insert('tb_sumber_dana', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('parameter/sumberdana');
        }
    }


    public function editsumberdana()
    {
        $data['title'] = 'Sumber Dana';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
       
        $this->form_validation->set_rules('nama_sumber', 'Nama Sumber', 'required');

        if ($this->form_validation->run() == false) {

            $this->db->order_by('nama_sumber');
            $data['sumberdana'] = $this->db->get('tb_bidang')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/sumberdana', $data);
            $this->load->view('templates/footer');
        } else {
            $id['id'] = $this->uri->segment(3);
            $nama_sumber= $this->input->post('nama_sumber');

            $data = array(
                'nama_sumber' => $nama_sumber
            );

            $this->db->where($id);
            $this->db->update('tb_sumber_dana', $data);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/sumberdana');
        }
    }


    public function deletesumberdana()
    {
        $id['id'] = $this->uri->segment(3);
        $this->db->where($id);
        $this->db->delete('tb_sumber_dana', $id);
        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dihapus</div>');
        redirect('parameter/sumberdana');
    }


    public function da()
    {
        $data['title'] = 'Data Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if(!empty($cektatw))
        {
    
                $this->form_validation->set_rules('sumber', 'Sumber', 'required');

                $tahun = $this->session->userdata('tahun');
                $kd_urusan = $this->session->userdata('kd_urusan');
                $kd_bidang = $this->session->userdata('kd_bidang');
                $kd_unit = $this->session->userdata('kd_unit');
                $kd_sub = $this->session->userdata('kd_sub');

                if ($this->form_validation->run() == false) {

                    $data['belanja'] = $this->db->get('tb_belanja')->result_array();

                    $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();

                    $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'));
                    $this->db->where($array);
                    $data['program'] = $this->db->get('ref_program')->result_array();


                    $query="SELECT a.*, e.kd_sumber, e.nama_sumber from  tb_da a join tb_sumber_dana e on e.kd_sumber = a.kd_sumber where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' order by a.kd_da";
                    $data['rka'] = $this->db->query($query)->result_array();

                    // echo"<pre>"; print_r( $data['program']);
                    // die;
                
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('parameter/da', $data);
                    $this->load->view('templates/footer');
                } else {
                
                    $sumberdana = $this->input->post('sumber');
                
                    $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
                    
                    if($this->input->post('kd_da')==null)
                    {
                        $cek = $this->db->get('tb_da')->result_array();
                        if ($cek > 0) {
                            $this->db->select_max('kd_da');
                            $this->db->where($array);
                            $result = $this->db->get('tb_da')->row_array();
                            $maxkd = $result['kd_da'];
                            $maxkd++;
                            $no = $maxkd++;
                        } else {
                            $no = '1';
                        }

                        $data = array(
                            'tahun' => $tahun,
                            'kd_urusan' => $kd_urusan,
                            'kd_bidang' => $kd_bidang,
                            'kd_unit' => $kd_unit,
                            'kd_sub' => $kd_sub,
                            'kd_sumber'=>$sumberdana,
                            'kd_da' =>$no,
                            'tgl_input' =>  date("Y/m/d")
                        );
                        $this->db->insert('tb_da', $data);
                    }
                    else
                    {
                        $no=$this->input->post('kd_da');
                    }

                    $datajson = json_decode($this->input->post('jsondata'),true);
                    foreach($datajson as $key=> $arr)
                    {
                        if($datajson[$key]['jumlah']==0)
                        {
                            continue;
                        }
                        else
                        {
                            $data = array(
                                'kd_urusan' => $kd_urusan,
                                'kd_bidang' => $kd_bidang,
                                'kd_unit' => $kd_unit,
                                'kd_sub' => $kd_sub,
                                'kd_da' => $no,
                                'kd_jenis' => $datajson[$key]['kd_jenis'],
                                'kd_komponen' => $datajson[$key]['kd_komponen'],
                                'kd_uraian' => $datajson[$key]['kd_uraian'],
                                'uraian_komponen' => $datajson[$key]['uraian'],
                                'satuan' => $datajson[$key]['satuan'],
                                'harga_satuan' => $datajson[$key]['harga'],
                                'harga_input' => $datajson[$key]['hargainput'],
                                'jumlah ' => $datajson[$key]['jumlah'],
                                'harga_total' =>  $datajson[$key]['total'],
                                'tahun' =>  $tahun,
                                'kd_sumber'=>$sumberdana,
                                'tgl_input' =>  date("Y/m/d")
                            );
                            $this->db->insert('tb_da_detail', $data);
                        }
                    }

                    $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                    redirect('parameter/da');
                }
        }
        else
        { 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/notactive', $data);
            $this->load->view('templates/footer');
        }
    }

    public function rincianda()
    {
        $data['title'] = 'Detail Data Awal ';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $this->uri->segment(3);
 
      
        $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $data['aktif'] = $this->db->get('tb_managementa')->row_array();


        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $query="SELECT a.*, e.kd_sumber, e.nama_sumber from  tb_da a join tb_sumber_dana e on e.kd_sumber = a.kd_sumber where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.kd_da='$id'";
        $data['detil'] = $this->db->query($query)->row_array();

       
        $query="SELECT * from  tb_da_detail where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_da='$id' order by uraian_komponen";
        $data['detilkomponen'] = $this->db->query($query)->result_array();

    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('parameter/rincianda', $data);
        $this->load->view('templates/footer');
       
    }

    public function deleterincianda()
    {
        $id['id_detail_da'] = $this->uri->segment(3);
        $kd_da = $this->uri->segment(4);
        $this->db->where($id);
        $this->db->delete('tb_da_detail', $id);
        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
        redirect('Parameter/rincianda/'.$kd_da);
    }

    public function editrincianda()
    {
        $id['id_detail_da'] = $this->uri->segment(3);
        $kd_da = $this->uri->segment(4);

        if($harga=$this->input->post('harga_input')!='')
        {
            $jumlah=$this->input->post('jumlah');
            $harga=$this->input->post('harga_input');
            $maks=$this->input->post('harga_satuan');
            $hargafinal = str_replace(',','',$harga);
            // $hargafinal = str_replace('.','',$harga);

            if($hargafinal>$maks)
            {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Tidak dapat disimpan, harga yang diinput melebihi harga maksimal</div>');
                redirect('Parameter/rincianda/'.$kd_da);
            }
            else
            {
                $total=$jumlah*$hargafinal;
                $data = array(
                    'harga_input' => $hargafinal,
                    'harga_total' => $total
                );
                $this->db->where($id);
                $this->db->update('tb_da_detail', $data);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil diubah</div>');
                redirect('Parameter/rincianda/'.$kd_da);
            }
        }
        else
        {
            $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Harga belum diisi. Tidak dapat mengubah harga</div>');
            redirect('Parameter/rincianda/'.$kd_da);
        }
    }


    public function tambahda()
    {
        $data['title'] = 'Tambah Data Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');
       
        $this->db->where("tb_sumber_dana.kd_sumber NOT IN (select kd_sumber from tb_da where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' )",NULL,FALSE);
        $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();

        
        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif"); 
        $data['aktif'] = $this->db->get('tb_managementa')->row_array();

        $kd_da = $this->uri->segment(3);

        if($kd_da=='' or $kd_da==null )
        {
            $data['komponen']= $this->db->get('tb_uraian_komponen')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/tambahda', $data);
            $this->load->view('templates/footer');  
        }
        else
        {

            $query="SELECT a.*, e.kd_sumber, e.nama_sumber from  tb_da a join tb_sumber_dana e on e.kd_sumber = a.kd_sumber where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.kd_da='$kd_da'";
            $data['detil'] = $this->db->query($query)->row_array();

            $query1="SELECT c.id_uraian, c.kd_jenis, c.kd_komponen,c.kd_uraian,c.uraian_komponen,c.satuan,c.harga FROM tb_uraian_komponen c 
            EXCEPT 
            SELECT b.id_uraian, a.kd_jenis, a.kd_komponen, a.kd_uraian, a.uraian_komponen, a.satuan, a.harga_satuan from tb_da_detail a join tb_uraian_komponen b on b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.kd_da='$kd_da' and a.tahun='$tahun'";
            $data['komponen']= $this->db->query($query1)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/tambahda', $data);
            $this->load->view('templates/footer');  
        }
      
    }


    // public function deletekbidang()
    // {
    //     $id['id_kepala_bidang'] = $this->uri->segment(3);
    //     $this->db->delete('tb_kepala_bidang', $id);
    //     $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil dihapus</div>');
    //     redirect('parameter/kepalaBidang');
    // }


    public function masterbelanja()
    {
        $data['title'] = 'Belanja';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('nama_belanja', 'Nama Belanja', 'required');

        if ($this->form_validation->run() == false) {

            // $this->db->where($array);
            $data['belanja'] = $this->db->get('tb_belanja_master')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/masterbelanja', $data);
            $this->load->view('templates/footer');
        }
        else 
        {
            $nama_belanja = $this->input->post('nama_belanja');
            $kd_belanja = $this->input->post('kd_belanja');

            $this->db->where('kd_belanja_master',$kd_belanja);
            $query = $this->db->get('tb_belanja_master');
            if ($query->num_rows() <=0)
            {
                $data = array(
                    'kd_belanja_master' => $kd_belanja,
                    'nama_belanja_master' =>  $nama_belanja
                );
    
                $this->db->insert('tb_belanja_master', $data);
                $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
                redirect('parameter/masterbelanja');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Kode Belanja Sudah Pernah Digunakan</div>');
                redirect('parameter/masterbelanja');
            }

           
        }
    }


    public function editbelanjamaster()
    {
        $data['title'] = 'Belanja';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('nama_belanja', 'Nama Belanja', 'required');

        if ($this->form_validation->run() == false) {

            $data['belanja'] = $this->db->get('tb_belanja_master')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/masterbelanja', $data);
            $this->load->view('templates/footer');
        } else {

            $id_belanja['id_belanja_master'] = $this->uri->segment(3);
            $nama_belanja = $this->input->post('nama_belanja');

            $data = array(
                'nama_belanja_master' => $nama_belanja
            );

            $this->db->where($id_belanja);
            $this->db->update('tb_belanja_master', $data);


            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('parameter/masterbelanja');
        }
    }

}

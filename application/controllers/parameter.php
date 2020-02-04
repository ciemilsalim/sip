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
            $this->db->where('tahun',$this->session->userdata('tahun'));
            $data['identitas'] = $this->db->get('tb_pemda')->row_array();

            $data['identitas']['tahun'] =$this->session->userdata('tahun');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/index', $data);
            $this->load->view('templates/footer');
        } else {

            $query="SELECT *FROM tb_pemda where tahun=".$this->session->userdata('tahun');
            $result = $this->db->query($query)->result_array();
            $count = count( $result);

       
            if (!empty($count))
            {
                $this->edit();
            }
            else
            {

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

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil diupdate</div>');
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

        if ($this->form_validation->run() == false) 
        {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        
            $this->db->where($array); 
            
            $data['skpd'] = $this->db->get('tb_skpd')->row_array();
            $data['skpd']['tahun'] =$this->session->userdata('tahun');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/skpd', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $query="SELECT *FROM tb_skpd where tahun=".$this->session->userdata('tahun');
            $result = $this->db->query($query)->result_array();
            $count = count( $result);

       
            if (!empty($count))
            {
                $this->editskpd();
            }
            else
            {

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
                    'id'=>'',
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

                die;


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
                'id'=>'',
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


            $this->db->where('id', $tahun);
            $this->db->update('tb_skpd', $data);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diupdate</div>');
            redirect('parameter/skpd');
        
    }



    public function program()
    {
        $data['title'] = 'Program';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Program_model', 'objprogram');

        $data['program'] = $this->objprogram->getProgram($this->session->userdata('kd_urusan'),$this->session->userdata('kd_bidang'));
        
       
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

        $data['kegiatan'] = $this->objkegiatan->getKegiatan($this->session->userdata('kd_urusan'),$this->session->userdata('kd_bidang'));
        
       
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

        if ($this->form_validation->run() == false) 
        {
            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        
            $this->db->where($array); 
            $this->db->where('kd_jabatan','1'); 
            $data['kode1'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where('kd_jabatan','2'); 
            $data['kode2'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where('kd_jabatan','3'); 
            $data['kode3'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penanggungJawab', $data);
            $this->load->view('templates/footer');
        }
        else
        {

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
                'id'=>'',
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
                'id'=>'',
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
                'id'=>'',
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

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));

        if ($this->form_validation->run() == false) 
        {
        
            $this->db->where($array); 
            $this->db->where('kd_jabatan','1'); 
            $data['kode1'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where('kd_jabatan','2'); 
            $data['kode2'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->db->where('kd_jabatan','3'); 
            $data['kode3'] = $this->db->get('tb_penanggung_jawab')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penanggungJawab', $data);
            $this->load->view('templates/footer');
        }
        else
        {

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

            $this->db->where('kd_jabatan','1'); 
            $this->db->update('tb_penanggung_jawab', $data1);

            $this->db->where('kd_jabatan','2'); 
            $this->db->update('tb_penanggung_jawab', $data2);

            $this->db->where('kd_jabatan','3'); 
            $this->db->update('tb_penanggung_jawab', $data3);

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diupdate</div>');
            redirect('parameter/penanggungJawab');
        }
    }



    public function penyimpanan()
    {
        $data['title'] = 'Penyimpanan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('penyimpanan', 'Penyimpanan', 'required');

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        
    
        if ($this->form_validation->run() == false) 
        {
            
            $this->db->where($array); 
            
            $data['penyimpanan'] = $this->db->get('tb_penyimpanan')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penyimpanan', $data);
            $this->load->view('templates/footer');
        }
        else
        {

            $penyimpanan = $this->input->post('penyimpanan');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
          
            $data = array(
                'id'=>'',
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

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        
    
        if ($this->form_validation->run() == false) 
        {
           
            $this->db->where($array); 
            
            $data['penyimpanan'] = $this->db->get('tb_penyimpanan')->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/penyimpanan', $data);
            $this->load->view('templates/footer');
        }
        else
        {

            $id = $this->input->post('id');
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
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diupdate</div>');
            redirect('parameter/penyimpanan');
        }
    }


    public function bidang()
    {
        $data['title'] = 'Bidang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) 
        {
            
            $this->db->where($array); 
            $data['bidang'] = $this->db->get('tb_bidang')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/bidang', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $nama_bidang = $this->input->post('nama_bidang');
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');


            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sip');

            $cek="SELECT * from tb_bidang";
            $cek2=mysqli_query($koneksi,$cek);
            $cek3=mysqli_num_rows($cek2);
                                      
            if ($cek3>0)
            {                        
                $sqll="SELECT MAX(kd_bid_skpd) from tb_bidang";
                $hasill = mysqli_query($koneksi,$sqll);
                $dataa = mysqli_fetch_array($hasill);
                $maxid=$dataa[0];
                $maxid++;
                $no=$maxid++; 
            }
            else
            {
                $no='1';
            }

          
            $data = array(
                'id_bidang'=>'',
                'tahun'=>$tahun,
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

        if ($this->form_validation->run() == false) 
        {
            
            $this->db->where($array); 
            $data['bidang'] = $this->db->get('tb_bidang')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/bidang', $data);
            $this->load->view('templates/footer');
        }
        else
        {
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
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nip', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) 
        {
            
            $this->db->where($array); 
            $bidang = $this->db->get('tb_bidang')->result_array();

            $array1 = array('tb_kepala_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_kepala_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_kepala_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_kepala_bidang.kd_sub' => $this->session->userdata('kd_sub'));
            $this->db->select('*');
            $this->db->from('tb_kepala_bidang');
            $this->db->join('tb_bidang', 'tb_kepala_bidang.id_bidang = tb_bidang.id_bidang');
            $this->db->where($array1); 
            $data['kbidang'] = $this->db->get()->result_array();

            $data['bidang']=array();


            foreach ($bidang as $key1 =>$arr)
            {
                    $this->db->select('*'); 
                    $this->db->from('tb_kepala_bidang');
                    $this->db->where($array); 
                    $this->db->where('id_bidang', $arr['id_bidang']);
                    $query = $this->db->get();
                    $result = $query->result_array();
                    $count = count( $result);
                    if (empty($count))
                    {
                        $data['bidang'][$arr['id_bidang']]=$arr['nama_bidang'];
                    }
            }


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/kepalaBidang', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $id_bidang = $this->input->post('nama_bidang');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
          
            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'id_bidang' => $id_bidang,
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
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
        
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nip', 'Nama Bidang', 'required');
        $this->form_validation->set_rules('nama', 'Nama Bidang', 'required');

        if ($this->form_validation->run() == false) 
        {
            
            $this->db->where($array); 
            $bidang = $this->db->get('tb_bidang')->result_array();

            $array1 = array('tb_kepala_bidang.kd_urusan' => $this->session->userdata('kd_urusan'), 'tb_kepala_bidang.kd_bidang' => $this->session->userdata('kd_bidang'), 'tb_kepala_bidang.kd_unit' => $this->session->userdata('kd_unit'), 'tb_kepala_bidang.kd_sub' => $this->session->userdata('kd_sub'));
            $this->db->select('*');
            $this->db->from('tb_kepala_bidang');
            $this->db->join('tb_bidang', 'tb_kepala_bidang.id_bidang = tb_bidang.id_bidang');
            $this->db->where($array1); 
            $data['kbidang'] = $this->db->get()->result_array();

            $data['bidang']=array();


            foreach ($bidang as $key1 =>$arr)
            {
                    $this->db->select('*'); 
                    $this->db->from('tb_kepala_bidang');
                    $this->db->where($array); 
                    $this->db->where('id_bidang', $arr['id_bidang']);
                    $query = $this->db->get();
                    $result = $query->result_array();
                    $count = count( $result);
                    if (empty($count))
                    {
                        $data['bidang'][$arr['id_bidang']]=$arr['nama_bidang'];
                    }
            }


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('parameter/kepalaBidang', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $id_kbidang= $this->uri->segment(3);
            $id_bidang = $this->input->post('nama_bidang');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
          
            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'id_bidang' => $id_bidang,
                'nip' => $nip,
                'nama' => $nama
            );

            $this->db->where('id_kepala_bidang',$id_kbidang);
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



    
}

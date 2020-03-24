<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }
    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');

            //cek gambar
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|png|jpg';
                $config['max_size'] = '2040';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $old_image = $data[user]['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">data berhasil update</div>');
            redirect('user');
        }
    }

    public function changepassword()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('curentpassword', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('newpassword1', 'Password Baru', 'required|trim|min_length[3]|matches[newpassword2]');
        $this->form_validation->set_rules('newpassword2', 'Konfirmasi Password', 'required|trim|min_length[3]|matches[newpassword1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $curentpassword = $this->input->post('curentpassword');
            $newpassword = $this->input->post('newpassword1');
            if (!password_verify($curentpassword, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Salah Password Lama!</div>');
                redirect('user/changepassword');
            } else {
                if ($curentpassword == $newpassword) {
                    $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Password Baru tidak boleh sama dengan Password Lama!</div>');
                    redirect('user/changepassword');
                } else {
                    //password ok
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Password Berhasil diubah!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }


    public function pengguna()
    {
        $data['title'] = 'Pengguna';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Pengguna_model', 'admin');

        $data['pengguna'] = $this->admin->getPengguna();
        $data1 = $this->db->get('user_role')->result_array();
        $data['role'] = $data1;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/pengguna', $data);
        $this->load->view('templates/footer');
        
    }


    public function editpengguna()
    {
        $data['title'] = 'Pengguna';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Pengguna_model', 'admin');

        $data['pengguna'] = $this->admin->getPengguna();

        $data1 = $this->db->get('user_role')->result_array();
        $data['role'] = $data1;
       
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('role_id', 'role_id', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/pengguna', $data);
            $this->load->view('templates/footer');
        } else {
            $id['id_user'] = $this->uri->segment(3);

            //cek gambar
            $upload_image = $_FILES['foto']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|png|jpg';
                $config['max_size'] = '2040';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {

                    $old_image = $this->input->post('fotolama');
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . "assets/img/profile/".$old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            $data = [
                'nama' => $this->input->post('nama'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active')
            ];


            $this->db->where($id);
            $this->db->update('user', $data);
            
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diupdate</div>');
            redirect('admin/pengguna');
        }
    }

    public function deletepengguna()
    {
        $data['title'] = 'Pengguna';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id['id_user'] = $this->uri->segment(3);
        $data1 = json_decode(json_encode($this->db->get_where('user',$id)->row()), true); 

        $old_image = $data1['image'];
        if ($old_image != 'default.jpg') {
            unlink(FCPATH . "assets/img/profile/".$old_image);
        }

		$this->db->delete('user', $id);
		$this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
		redirect('admin/pengguna');
    }
}

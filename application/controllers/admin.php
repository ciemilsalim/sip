<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) 
        {
            
            $data['role'] = $this->db->get('user_role')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $role = $this->input->post('role');
          
            $data = array(
                'role'=>$role
            );


            $this->db->insert('user_role', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            redirect('admin/role');
        }
    }

    public function editrole()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) 
        {
            
            $data['role'] = $this->db->get('user_role')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $id['id'] = $this->uri->segment(3);
            $role = $this->input->post('role');
          
            $data = array(
                'role'=>$role
            );

            $this->db->where($id);
            $this->db->update('user_role', $data);
            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil diubah</div>');
            redirect('admin/role');
        }
    }

    public function deleterole()
    {
        $id['id'] = $this->uri->segment(3);
		$this->db->delete('user_role', $id);
		$this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">data berhasil dihapus</div>');
		redirect('admin/role');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Access Change!</div>');
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

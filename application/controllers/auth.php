<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $tahun = $this->input->post('tahun');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'kd_urusan' => $user['kd_urusan'],
                        'kd_bidang' => $user['kd_bidang'],
                        'kd_unit' => $user['kd_unit'],
                        'kd_sub' => $user['kd_sub'],
                        'kd_bid_skpd' => $user['kd_bid_skpd'],
                        'tahun' => $tahun
                    ];
                   

                    $this->db->select('*'); 
                    $this->db->from('tb_tahun');
                    $this->db->where('tahun', $tahun);
                    $query = $this->db->get();
                    $result = $query->result_array();
                    $count = count( $result);
                    if (!empty($count))
                    {
                        $this->session->set_userdata($data);

                        //direct
                        if ($user['role_id'] == 1 or $user['role_id'] == 7) 
                        {
                            redirect('admin');
                        }
                        else 
                        {
                             //cek apakah data skpd sudah ada atau belum
                            $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));
                            $this->db->select('*');
                            $this->db->from('tb_skpd');
                            $this->db->where($array);  
                            $queryx = $this->db->get();
                            $resultx = $queryx->result_array();
                            $countx = count( $resultx);
                            //jika belum ada, maka simpan.
                            if (empty($countx))
                            {
                                $array = array('Kd_Urusan' => $this->session->userdata('kd_urusan'), 'Kd_Bidang' => $this->session->userdata('kd_bidang'), 'Kd_Unit' => $this->session->userdata('kd_unit'), 'Kd_Sub' => $this->session->userdata('kd_sub'));
                                $this->db->select('*');
                                $this->db->from('ref_sub_unit');
                                $this->db->where($array);  
                                $dataskpd=$this->db->get()->row_array();

                                $data = array(
                                    'kd_urusan' => $dataskpd['Kd_Urusan'],
                                    'kd_bidang' => $dataskpd['Kd_Bidang'],
                                    'kd_unit' => $dataskpd['Kd_Unit'],
                                    'kd_sub' =>  $dataskpd['Kd_Sub'],
                                    'nama_skpd' => $dataskpd['Nm_Sub_Unit']
                                );
                    
                                $this->db->insert('tb_skpd', $data);
                            }
                        
                            redirect('user');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Tahun Anggaran tidak terdaftar</div>');
                        redirect('auth');
                    }

                   
                } else {
                    $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Password salah</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Email belum diaktivasi</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class = "alert alert-danger" role="alert">Akun Tidak terdaftar!</div>');
            redirect('auth');
        }
    }

    public function registrasi()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This Email already used!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        $role_id = $this->input->post('role_id', true);
        $kd_bid = $this->input->post('bidang', true);
        if(($role_id==4 and $kd_bid=='') or ($role_id==5 and $kd_bid==''))
        {
            $this->form_validation->set_rules('bidang', 'Bidang', 'required');
        }
        

        if ($this->form_validation->run() == false) {

            $this->db->where('id !=', 1); 
            $this->db->where('id !=', 7); 
            $data = $this->db->get('user_role')->result_array();
            $data['role'] = $data;

            // $this->db->select('*');
            // $this->db->from('ref_sub_unit');
            $dataunit = $this->db->get('ref_sub_unit')->result_array();
            $data['urusan'] = $dataunit;

            $data['title'] = 'Registrasi SIP';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registrasi', $data);
            $this->load->view('templates/auth_footer');
        } else {
            $nama = $this->input->post('nama', true);
            $email = $this->input->post('email', true);
            $role_id = $this->input->post('role_id', true);
            $skpd = $this->input->post('skpd', true);
            $kd_bid = $this->input->post('bidang', true);
            $nama_bid = $this->input->post('nama_bid', true);
            $dataskpd=explode("#",$skpd);


            $data = [
                'nama' => htmlspecialchars($nama),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => htmlspecialchars($role_id),
                'is_active' => 0,
                'date_created' => time(),
                'kd_urusan' =>$dataskpd[0],
                'kd_bidang' =>$dataskpd[1],
                'kd_unit' =>$dataskpd[2],
                'kd_sub' =>$dataskpd[3],
                'nama_skpd' =>$dataskpd[4],
                'kd_bid_skpd' =>$kd_bid,
                'nama_bid_skpd' =>$nama_bid
            ];

            //token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Selamat.. Akun Anda terdaftar! Silahkan Aktivasi Akun anda di alamat ' . $email . '</div>');
            redirect('auth');
        }
    }


    public function pilihbidang()
    {
        $kd_urusan = $this->uri->segment(3);
        $kd_bidang = $this->uri->segment(4);
        $kd_unit = $this->uri->segment(5);
        $kd_sub = $this->uri->segment(6);
       
        $array = array('kd_urusan' => $kd_urusan, 'kd_bidang' =>  $kd_bidang, 'kd_unit' => $kd_unit, 'kd_sub' => $kd_sub);
   
        $this->db->where($array);
        $data['bidang']= $this->db->get('tb_bidang')->result_array();

        echo json_encode($data['bidang']);
    }


    private function _sendEmail($token, $type)
    {
        // $config = [
        //     'protocol' => 'smtp',
        //     'smtp_host' => 'ssl://smtp.gmail.com',
        //     'smtp_user' => 'emilbiosci2018@gmail.com',
        //     'smtp_pass' => 'aspireone2018',
        //     'smtp_port' => 465,
        //     'mailtype' => 'html',
        //     'chartset' => 'utf-8',
        //     'newline' => "\r\n"
        // ];

        // $this->load->library('email', $config);
        // $this->email->initialize($config);

        // $this->email->from('emilbiosci2018@gmail.com', 'Zahra dev');
        // $this->email->to($this->input->post('email'));

        // if ($type == 'verify') {
        //     $this->email->subject('Verifikasi Akun');
        //     $this->email->message('Klik Link ini untuk verifikasi akun anda <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . ' ">Aktifkan</a>');
        // } else if ($type == 'forgot') {
        //     $this->email->subject('Reset Password');
        //     $this->email->message('Klik Link ini untuk reset password anda <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . ' ">Reset Password</a>');
        // }

        // if ($this->email->send()) {
            return true;
        // } else {
        //     echo $this->email->print_debugger();
        //     die;
        // };
    }


    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' =>  $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {

                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class = " alert alert-success" role= "alert">Berhasil mengaktivasi email ' . $email . '! Silahkan Login!</div>');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class = " alert alert-gagal" role= "alert">Gagal mengaktivasi email! Token expire!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class = " alert alert-danger" role= "alert">Gagal mengaktivasi email! Token tidak valid!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class = " alert alert-danger" role= "alert">Gagal mengaktivasi email! email salah!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class = " alert aler t -succes s" role= "aler t">Anda melakukan logout</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $data['title'] = 'Blocked Access';
        $this->load->view('templates/header', $data);
        $this->load->view('auth/blocked');
        $this->load->view('templates/footer');
    }

    public function forgotpassword()
    {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgotpassword');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user =  $this->db->get_where('user', ['email' => $email], ['is_active' => 1])->row_array();

            if ($user) {

                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class = " alert alert-success" role= "alert">Periksa email anda untuk memvalidasi password!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class = " alert alert-danger" role= "alert">email tidak terdaftar atau belum aktif!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {

                $this->session->set_userdata('reset_email', $email);

                $this->changepassword();
            } else {
                $this->session->set_flashdata('message', '<div class = " alert alert-danger" role= "alert">Reset Password gagal! Token Salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class = " alert alert-danger" role= "alert">Reset Password gagal! Email Salah!</div>');
            redirect('auth');
        }
    }

    public function changepassword()
    {

        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|required|min_length[4]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/changepassword');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class = " alert alert-success" role= "alert">Reset password Berhasil diubah! Silahkan Login!</div>');
            redirect('auth');
        }
    }
}

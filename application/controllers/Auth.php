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
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required');

        if ($this->form_validation->run() == false){
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }
        else{
            // validasinya succes
            $this->_login();

        }
        
    }

    private function _login(){
        $email  = $this->input->post('email');
        $password = $this->input->post('password');

        $users = $this->db->get_where('users', ['email' => $email])->row_array();
       
        // jika usernya ada
        if ($users) {
            // jika usernya aktif
            if ($users ['is_active']== 1) {
                // cek password
                if(password_verify($password,$users['password'])){
                    $data = [
                        'email'=> $users['email'],
                        'role_id'=> $users ['role_id'],
                        'logged_in' => TRUE 
                    ];
                    $this->session->set_userdata($data);
                    if($users['role_id']== 1){
                        redirect('admin');

                    } else {
                        redirect('user');
                    }

                }else {
                      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Password salah!</div>');
                      redirect('auth');
                }
            }
            else {
                 $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">email belum di aktivasi </div>');
                 redirect('auth');
            }
        }
        else {
             $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert"> Akun Belum Terdaftar! </div>');
             redirect('auth');
        }

    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]',[
            'is_unique' => 'Email sudah pernah Daftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'password tidak sama!',
            'min_length' => 'password minimal 8 karakter'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'user registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date' => time()
            ];

            $this->db->insert('users', $data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"> Akun Terdaftar,Silahkan Login!</div>');
            redirect('auth');
        }
    }

    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert"> Logout berhasil</div>');
            redirect('auth');
    }

    public function blocked(){

       $this->load->view('auth/blocked');

    }
    
}

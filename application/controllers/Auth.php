<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{   

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

    }

    public function index()
    {
        if($this->session->userdata('email')){
            redirect('user');
        }


        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email',[
            // ini untuk mengubah pesan default error
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Project user login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $this ->_login();

        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        

        // jika user ada
        if($user){
            // jika usernya active
            if($user['is_active'] == 1){
                // cek password
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                // cek role apakah admin atau user
                    if($user['role_id'] == 1){
                        redirect('admin');
                    } else {
                        redirect('user');
                    }

                } else {

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                   Worng password
                  </div>');
                  redirect('auth');
                }

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               This email has been activated
              </div>');
              redirect('auth');
            }

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            email is not registered
          </div>');
            redirect('auth');
        }
    }

    
    public function registration()
    {
        if($this->session->userdata('email')){
            redirect('user');
        }


        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|matches[password1]');
        
        if ( $this->form_validation->run() == false )  {
            $data['title'] = 'Project user registration';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/footer'); 
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' =>'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // $this->db->insert('user', $data);

            $this->_sendEmail();

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations your account has been created. Please Login
          </div>');
            redirect('auth');
        }
    }


    private function _sendEmail() 
    {

        // $this->load->library("phpmailer_library");
        //     $mail = $this->phpmailer_library->load();
        //         $mail->Host = "smtp.gmail.com";
        //         $mail->isSMTP();
        //         $mail->SMTPOptions = array(
        //                              'ssl' => array(
        //                              'verify_peer' => false,
        //                              'verify_peer_name' => false,
        //                              'allow_self_signed' => true
        //                                             )
        //                                     );
        //         $mail->SMTPAuth = TRUE;
        //         $mail->Username = 'rizqalazizhan@gmail.com';
        //         $mail->Password = 'rizqal2021';
        //         $mail->SMTPSecure = "ssl";
        //         $mail->Port = 465;


        //         $mail->addAddress('rizqalazizhan231205@gmail.com');
        //         $mail->setFrom('rizqalazizhan@gmail.com');

        //         $mail->Subject = 'Test';
        //         $mail->Message = 'Hello World';
        //         $mail->isHTML(TRUE);
        //         $mail->send();
        
        
        // if ($mail->send()) {
        //     return true;
        // } else {
        //     echo $this->email->print_debugger();
        //     die;
        //     redirect('Auth');
        // }

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_user'] = 'rizqalazizhan232105@gmail.com';
        $config['smtp_pass'] = 'kituning2021';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->load->library('email',$config );

        $this->email->from('rizqalazizhan231205@gmail.com', 'rizqal');
        $this->email->to('rizqalazizhan@gmail.com');
        $this->email->subject('Testing');
        $this->email->message('Hello World');

        if ($this->email->send() ) {
            return true;
        } else {
            echo $this->email->print_debbugger();
            die;
        }

    }



    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            You have been logged out
          </div>');
            redirect('auth');
    }

    public function blocked()
    {
       $this->load->view('auth/blocked');
    }
}
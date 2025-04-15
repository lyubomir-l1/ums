<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('cookie');

        $this->check_remember_me();
    }


    private function check_remember_me(){
        $token = $this->input->cookie('remember_me');
        if($token){
            $user = $this->User_model->get_user_by_token($token);
            if($user){
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
            }
        }
    }
    
    public function dashboard(){
     
        if(!$this->session->userdata('user_id')){
            redirect('login/login');
        }else{
            $user_id = $this->session->userdata('user_id');
            $message = '';
            if($this->session->flashdata('is_new_user')){
                $message = 'WELCOME. Successful Registration.';
            }elseif($this->session->flashdata('login_success')){
                $message = 'WELCOME. Successful login.';
            }
            $username = $this->session->userdata('username');
            $user_info = $this->User_model->get_user_info($user_id);
            $data = ['message' => $message, 'username' => $username, 'user_info' => $user_info];
            $title['title'] = "Dashboard";
            $this->load->view('header', $title);
            $this->load->view('navbar');
            $this->load->view('dashboard', $data);
            $this->load->view('footer');
            
        }
    }
     

}

?>
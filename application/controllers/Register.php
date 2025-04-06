<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');

    }

    public function register(){
            $data['title'] = "Register Page";
            $this->load->view('header', $data);
            $this->load->view('register');
            $this->load->view('footer');
    }

    public function register_user(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'matches[password]');

        if($this->form_validation->run() == FALSE){
        //    $data['title'] = "Register Page";
        //    $this->load->view('header', $data);
        //    $this->load->view('register');
        //    $this->load->view('footer');
        echo $this->register();

        }else{
            $email = $this->input->post('email');
            $existing_user = $this->User_model->get_user_by_email($email);
            if(!$existing_user){
                $data = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
                );

                $new_user = $this->User_model->insert_user($data);
                if($new_user){
                    $new_user_data = $this->User_model->get_user_by_email($data['email']);
                    $new_user_id = $new_user_data['id'];
                    $new_user_permission_level = $new_user_data['permission_level'];
                    $this->session->set_flashdata('is_new_user', true);
                    $this->session->set_userdata([
                        'user_id' => $new_user_id,
                        'username' => $data['username'],
                        'permission_level' => $new_user_permission_level]);

                    //TODO TRACKING FUNCTIONALITY

                    $action = [
                        'active_user_id' => $this->session->userdata('user_id'),
                        'action_type' => ACTION_REGISTER_USER,
                        'old_value' => '',
                        'new_value' => json_encode(['username' => $new_user_data['username'], 'email' => $new_user_data['email']]),
                        'passive_user_id' => NULL,
                        'ticket_id' => NULL,
                        'comment_id' => NULL,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $this->User_model->insert_action($action);
                    // print_r($action);
                    
                    redirect('dashboard');
                } else {
                    echo 'Error occurred!';
                } 
            }else{
                echo 'This email is taken! Try a different one!';
            }
        }
    }
}

?>

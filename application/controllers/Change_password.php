<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

class Change_password extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function change_password(){
        if(!$this->session->userdata('user_id')){
            redirect('login/login');
        }
        $data['title'] = "Change Own Pass";
        $this->load->view('header', $data);
        $this->load->view('change_password');
        $this->load->view('footer');
    }

    public function update_password(){
        if(!$this->session->userdata('user_id')){
            redirect('login/login');
        }
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
        $user_id = $this->session->userdata('user_id');

        if($new_password !== $confirm_password){
            echo "New and confirm password do not match!";
            return;
        }

        $user = $this->User_model->get_user_by_id($user_id);
        if(!password_verify($current_password, $user['password'])){
            echo "Wrong current password input!";
            return;
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $this->User_model->update_password($user_id, $hashed_password);

        // TODO: TRACKING FUNCTIONALITY

        $action = [
            'active_user_id' => $user['id'],
            'action_type' => ACTION_CHANGE_OWN_PASS,
            'old_value' => '',
            'new_value' => '',
            'passive_user_id' => NULL,
            'ticket_id' => NULL,
            'comment_id' => NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // print_r($action);

        $this->User_model->insert_action($action);

        echo "Change password success!";
        echo '<a href="'.site_url('dashboard').'"><button>Go To Dashboard</button></a>';
        exit;

    }
}
?>
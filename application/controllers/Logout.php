<?php
defined('BASEPATH') OR exit('No direct script access allowed!');
class Logout extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('cookie');
    }

    public function logout(){
        
        
        //TODO TRACKING FUNCTIONALITY
        
        $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_LOGOUT,
                'old_value' => '',
                'new_value' => '',
                'passive_user_id' => NULL,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            // print_r($action);
            
        $this->session->sess_destroy();
        delete_cookie('remember_me');

        redirect('login');
    }
}
?>
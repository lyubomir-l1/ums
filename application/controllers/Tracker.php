<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Tracker extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function display_users() {
        $data['users'] = $this->User_model->get_all_users();
        $title['title'] = "Tracking System";
        $this->load->view('header', $title);
        $this->load->view('admin/tracking_system', $data);
        $this->load->view('footer');
    }

    public function display_user_actions($user_id){
        $actions = $this->User_model->get_user_actions($user_id);
        echo json_encode($actions);
    }
}
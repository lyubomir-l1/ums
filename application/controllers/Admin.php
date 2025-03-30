<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Admin extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        if(!$this->session->userdata('user_id')){
            redirect('login/login');
        }
    }

    public function manage_users(){
        $title['title'] = "Manage Users";
        $data['users'] = $this->User_model->get_all_users();
        $data['permission_level'] = $this->session->userdata('permission_level');
        $this->load->view('header', $title);
        $this->load->view('admin/manage_users', $data);
        $this->load->view('footer');
        
    }


    public function change_password($user_id) {
        if ($this->session->userdata('permission_level') > 2) {
            show_error('No permission.', 403);
        }
    
        if ($this->input->post()) {
            $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            $this->User_model->update_password($user_id, $new_password);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_OTHER_PASS,
                'old_value' => '',
                'new_value' => '',
                'passive_user_id' => $user_id,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Change Other User Pass";
            $this->load->view('header', $title);
            $this->load->view('admin/change_password', $data);
            $this->load->view('footer');
        }
    }

    public function change_email($user_id) {
        if ($this->session->userdata('permission_level') > 2) {
            show_error('No permission.', 403);
        }
    
        if ($this->input->post()) {
            $new_email = $this->input->post('new_email');
            $this->User_model->update_email($user_id, $new_email);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_OTHER_EMAIL,
                'old_value' => '',
                'new_value' => '',
                'passive_user_id' => $user_id,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Change Other User Pass";
            $this->load->view('header', $title);
            $this->load->view('admin/change_email', $data);
            $this->load->view('footer');
            
        }
    }
    
    
    public function ban_user($user_id) {
        if ($this->session->userdata('permission_level') > 2) {
            show_error('No permission.', 403);
        }
    
        if ($this->input->post()) {
            $ban_days = (int) $this->input->post('ban_days');
            $ban_until = date('Y-m-d H:i:s', strtotime("+$ban_days days"));
            $this->User_model->ban_user($user_id, $ban_until);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_BAN_USER,
                'old_value' => '',
                'new_value' => json_encode(['ban_days' => $ban_days, 'ban_until' => $ban_until]),
                'passive_user_id' => $user_id,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Ban User";
            $this->load->view('header', $title);
            $this->load->view('admin/ban_user', $data);
            $this->load->view('footer');
        }
    }
    

    public function remove_ban($user_id) {
        if ($this->session->userdata('permission_level') != 1) {
            show_error('No permission.', 403);
        }
    
        if ($this->input->post()) {
            $this->User_model->remove_ban($user_id);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_REMOVE_BAN,
                'old_value' => '',
                'new_value' => '',
                'passive_user_id' => $user_id,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Remove Ban";
            $this->load->view('header', $title);
            $this->load->view('admin/remove_ban', $data);
            $this->load->view('footer');
        }
    }
    

    public function delete_user($user_id) {
        if ($this->session->userdata('permission_level') != 1) {
            show_error('No permission.', 403);
        }
        $user = $this->User_model->get_user_by_id($user_id);
    
        if ($this->input->post()) {
            $this->User_model->delete_user($user_id);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_DELETE_USER,
                'old_value' => json_encode(['username' => $user['username'], 'email' => $user['email']]),'',
                'new_value' => '',
                'passive_user_id' => $user['id'],
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Delete User";
            $this->load->view('header', $title);
            $this->load->view('admin/delete_user', $data);
            $this->load->view('footer');
        }
    }

    public function change_user_permission_level($user_id){
        if ($this->session->userdata('permission_level') != 1) {
            show_error('No permission.', 403);
        }

        if ($this->input->post()) {
            $user = $this->User_model->get_user_by_id($user_id);
            $new_level = $this->input->post('level');
            $this->User_model->change_user_permission($user_id, $new_level);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_USER_PERMISSION,
                'old_value' => $user['permission_level'],
                'new_value' => $new_level,
                'passive_user_id' => $user_id,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/users');

        } else {
            $data['user_id'] = $user_id;
            $title['title'] = "Change Permission Level";
            $this->load->view('header', $title);
            $this->load->view('admin/change_user_permission_level', $data);
            $this->load->view('footer');
        }
    }    

    public function create_ticket() {
        if ($this->session->userdata('permission_level') > 2) {
            show_error('No permission.', 403);
        }

        if($this->input->post()){
            $data = array(
            'creator_id' => $this->session->userdata('user_id'),
            'title' => $this->input->post('ticket_title'),
            'description' => $this->input->post('ticket_description'),
            'status' => $this->input->post('ticket_status'),
            'refered_user_id' => $this->input->post('ticket_person')
            );
            $ticket_id = $this->User_model->insert_ticket($data);

            $action = [
                'active_user_id' => $data['creator_id'],
                'action_type' => ACTION_CREATE_TICKET,
                'old_value' => '',
                'new_value' => json_encode(['ticket_title' => $data['title'], 'ticket_description' => $data['description']]),
                'passive_user_id' => $data['refered_user_id'],
                'ticket_id' => $ticket_id,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/view_tickets');

        }else{

            $data['ticket_creator_id'] = $this->session->userdata('user_id');
            $data['users'] = $this->User_model->get_all_users();
            $title['title'] = "Create New Ticket";
            $this->load->view('header', $title);
            $this->load->view('admin/create_ticket', $data);
            $this->load->view('footer');
        }
    }

    public function view_tickets() {
        $data['tickets'] = $this->User_model->get_all_tickets();
        $data['permission_level'] = $this->session->userdata('permission_level');
        $data['username'] = $this->session->userdata('username');
        $title['title'] = "View All Tickets";
        $this->load->view('header', $title);
        $this->load->view('admin/view_tickets', $data);
        $this->load->view('footer');
        
    }

    public function view_one_ticket($ticket_id) {
        if ($this->session->userdata('permission_level') > 3) {
            show_error('No permission.', 403);
        }
        $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
        
        $data['ticket_info'] = $ticket_info;
        $data['comments'] = $this->User_model->get_all_comments($ticket_id);
        $title['title'] = "View ticket";
        $this->load->view('header', $title);
        $this->load->view('admin/view_one_ticket', $data);
        $this->load->view('footer');
    }

    public function change_ticket_title($ticket_id) {
        if ($this->session->userdata('permission_level') > 1) {
            show_error('No permission.', 403);
        }
        $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
        if ($this->input->post()) {
            $new_ticket_title = $this->input->post('new_ticket_title');
            $this->User_model->update_ticket_title($ticket_id, $new_ticket_title);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_TICKET_TITLE,
                'old_value' => $ticket_info['title'],
                'new_value' => $new_ticket_title,
                'passive_user_id' => $ticket_info['creator_id'],
                'ticket_id' => $ticket_id,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/view_one_ticket/' . $ticket_id);

        } else {
            $data['ticket_id'] = $ticket_id;
            $data['ticket_title'] = $ticket_info['title'];
            $title['title'] = "Change Ticket Title";
            $this->load->view('header', $title);
            $this->load->view('admin/edit_ticket_title', $data);
            $this->load->view('footer');
        }
    }

    public function change_ticket_description($ticket_id) {
        if ($this->session->userdata('permission_level') > 1) {
            show_error('No permission.', 403);
        }
        $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
        if ($this->input->post()) {
            $new_ticket_description = $this->input->post('new_ticket_description');
            $this->User_model->update_ticket_description($ticket_id, $new_ticket_description);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_TICKET_DESCRIPTION,
                'old_value' => $ticket_info['description'],
                'new_value' => $new_ticket_description,
                'passive_user_id' => $ticket_info['creator_id'],
                'ticket_id' => $ticket_id,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/view_one_ticket/' . $ticket_id);

        } else {
            $data['ticket_id'] = $ticket_id;
            $data['ticket_description'] = $ticket_info['description'];
            $title['title'] = "Change Ticket Description";
            $this->load->view('header', $title);
            $this->load->view('admin/edit_ticket_description', $data);
            $this->load->view('footer');
        }
    }

    public function change_ticket_status($ticket_id) {
        if ($this->session->userdata('permission_level') > 2) {
            show_error('No permission.', 403);
        }
        $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
        if ($this->input->post()) {
            $new_ticket_status = $this->input->post('new_ticket_status');
            $this->User_model->update_ticket_status($ticket_id, $new_ticket_status);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_CHANGE_TICKET_STATUS,
                'old_value' => $ticket_info['status'],
                'new_value' => $new_ticket_status,
                'passive_user_id' => $ticket_info['creator_id'],
                'ticket_id' => $ticket_id,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/view_one_ticket/' . $ticket_id);

        } else {
            $data['ticket_id'] = $ticket_id;
            $data['ticket_status'] = $ticket_info['status'];
            $title['title'] = "Change Ticket Status";
            $this->load->view('header', $title);
            $this->load->view('admin/change_ticket_status', $data);
            $this->load->view('footer');
        }
    }

    public function delete_ticket($ticket_id) {
        if ($this->session->userdata('permission_level') != 1) {
            show_error('No permission.', 403);
        }
    
        if ($this->input->post()) {
            $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
            
            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_DELETE_TICKET,
                'old_value' => json_encode(['removed_ticket_title' => $ticket_info['title'], 'removed_ticket_description' => $ticket_info['description'], 'removed_ticket_status' => $ticket_info['status']]),
                'new_value' => '',
                'passive_user_id' => $ticket_info['creator_id'],
                'ticket_id' => $ticket_info['id'],
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            $this->User_model->delete_ticket($ticket_id);
            redirect('admin/view_tickets');

        } else {
            $data['ticket_id'] = $ticket_id;
            $title['title'] = "Delete Ticket";
            $this->load->view('header', $title);
            $this->load->view('admin/delete_ticket', $data);
            $this->load->view('footer');
        }
    }

    public function add_comment($ticket_id) {
        if ($this->session->userdata('permission_level') > 3) {
            show_error('No permission.', 403);
        }

        if($this->input->post()){
            $data = array(
            'ticket_id' => $this->input->post('ticket_id'),
            'comment_creator_id' => $this->input->post('comment_creator_id'),
            'comment' => $this->input->post('comment')
            );
            $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
            $comment_id = $this->User_model->insert_comment($data);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_ADD_TICKET_COMMENT,
                'old_value' => '',
                'new_value' => json_encode(['comment_creator_id' => $data['comment_creator_id'], 'comment' => $data['comment']]),
                'passive_user_id' => $ticket_info['creator_id'],
                'ticket_id' => $data['ticket_id'],
                'comment_id' => $comment_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->User_model->insert_action($action);
            redirect('admin/view_one_ticket/' . $ticket_id);

        }else{

            $data = [
            'comment_creator_id' => $this->session->userdata('user_id'),
            'ticket_id' => $ticket_id];
            $title['title'] = "Add New Comment";
            $this->load->view('header', $title);
            $this->load->view('admin/add_comment', $data);
            $this->load->view('footer');
        }
    }

    // public function view_comments($ticket_id) {
    //     if ($this->session->userdata('permission_level') > 3) {
    //         show_error('No permission.', 403);
    //     }
    //         $ticket_info = $this->User_model->get_ticket_by_id($ticket_id);
    //         $data['comments'] = $this->User_model->get_all_comments($ticket_id);

    //         $title['title'] = "View All Comments";
    //         $this->load->view('header', $title);
    //         $this->load->view('admin/view_comments', $data);
    //         $this->load->view('footer');
            
    // }

    public function edit_comment($comment_id) {

        $comment = $this->User_model->get_comment_by_id($comment_id);

        if ($this->input->post()) {
            $new_comment = $this->input->post('new_comment');
            $this->User_model->update_comment($comment_id, $new_comment);

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_EDIT_TICKET_COMMENT,
                'old_value' => $comment['comment'],
                'new_value' => $new_comment,
                'passive_user_id' => $comment['comment_creator_id'],
                'ticket_id' => $comment['ticket_id'],
                'comment_id' => $comment_id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            redirect('admin/view_one_ticket/' . $comment['ticket_id']);

        } else {
            
            if (!$comment) {
                show_error('Comment not found.', 404);
            }
            $data['comment'] = $comment;
            $title['title'] = "Edit Comment";
            $this->load->view('header', $title);
            $this->load->view('admin/edit_comment', $data);
            $this->load->view('footer');
        }
    }

    public function delete_comment($comment_id){
        $comment = $this->User_model->get_comment_by_id($comment_id);

        if ($this->input->post()) {

            $action = [
                'active_user_id' => $this->session->userdata('user_id'),
                'action_type' => ACTION_DELETE_TICKET_COMMENT,
                'old_value' => json_encode(['current_comment' => $comment['comment']]),
                'new_value' => '',
                'passive_user_id' => $comment['comment_creator_id'],
                'ticket_id' => $comment['ticket_id'],
                'comment_id' => $comment['id'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->User_model->insert_action($action);
            $this->User_model->delete_comment($comment_id);
            redirect('admin/view_one_ticket/' . $comment['ticket_id']);

        } else {
            $data['comment_id'] = $comment['id'];
            $title['title'] = "Delete Comment";
            $this->load->view('header', $title);
            $this->load->view('admin/delete_comment', $data);
            $this->load->view('footer');
        }
    }
}
?>


<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function insert_user($data){
        return $this->db->insert('users', $data);
    }

    public function get_user_by_email($email){
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->row_array();
    }

    public function set_remember_token($user_id, $token){
        $this->db->set('remember_token', $token);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }

    public function get_user_by_token($token){
        $this->db->where('remember_token', $token);
        $query= $this->db->get('users');
        return $query->row_array();
    }

    public function is_user_locked_out($email){
        $this->db->select('lockout_time');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        $user = $query->row_array();

        if($user && $user['lockout_time'] !== NULL){
            $lockout_time = strtotime($user['lockout_time']);
            $current_time = time();

            if($current_time < $lockout_time +(60 * 60)){
                return true;
            } else {
                $this->clear_lockout($email);
            }

        }
        return false;
    }

    public function increment_failed_attempts($email){
        $this->db->set('failed_attempts', 'failed_attempts+1', FALSE);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function lockout_user($email){
        $this->db->set('lockout_time', date('Y-m-d H:i:s'));
        $this->db->set('failed_attempts', 0);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function clear_lockout($email){
        $this->db->set('lockout_time', NULL);
        $this->db->set('failed_attempts', 0);
        $this->db->where('email', $email);
        $this->db->update('users');
    }

    public function get_user_by_id($user_id){
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row_array();
    }

    public function update_password($user_id, $hashed_password){
        $this->db->where('id', $user_id);
        $this->db->update('users', ['password' => $hashed_password]);
        return $this->db->affected_rows() > 0;
    }

    public function log_user_login($data) {
        $this->db->insert('user_logins', $data);
    }

    public function count_logins($user_id, $status) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', $status);
        return $this->db->count_all_results('user_logins');
    }

    public function set_reset_token($email, $token){
        $expiry = date('Y-m-d H:i:s', time() + 3600);
        $this->db->where('email', $email);
        $this->db->update('users', [
            'reset_token' => $token,
            'reset_token_expiry' => $expiry
        ]);
    }

    public function get_user_by_reset_token($token){
        $this->db->where('reset_token', $token);
        $this->db->where('reset_token_expiry >', date('Y-m-d H:i:s'));
        return $this->db->get('users')->row_array();
    }

    public function clear_reset_token($user_id){
        $this->db->where('id', $user_id);
        $this->db->update('users', [
            'reset_token' => NULL,
            'reset_token_expiry' => NULL,
        ]);
    }

    public function update_last_password_reset($user_id) {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['last_password_reset' => date('Y-m-d H:i:s')]);
    }

    public function get_user_info($user_id) {
   
    $this->db->select('users.id, users.username, users.email, users.failed_attempts, users.last_password_reset, user_logins.ip_address, user_logins.browser_details, user_logins.status, user_logins.login_time');
    $this->db->from('users');
    $this->db->join('user_logins', 'users.id = user_logins.user_id', 'left');
    $this->db->where('users.id', $user_id);
    
    $query = $this->db->get();
    return $query->result_array();
    } 

    public function get_all_users() {
        $this->db->select('id, username, email, permission_level, failed_attempts, lockout_time');
        $this->db->from('users');
        $query = $this->db->get();
        return  $query->result_array();
    }

    public function update_email($user_id, $new_email) {
        $this->db->where('id', $user_id)->update('users', ['email' => $new_email]);
    }
    

    public function ban_user($user_id, $ban_until) {
        $this->db->where('id', $user_id)->update('users', ['lockout_time' => $ban_until]);
    }
    
    
    public function remove_ban($user_id) {
        $this->db->where('id', $user_id)->update('users', ['lockout_time' => NULL]);
    }
    
    
    public function delete_user($user_id) {
        $this->db->where('id', $user_id)->delete('users');
    }

    public function change_user_permission($user_id, $level) {
        $this->db->where('id', $user_id)->update('users', ['permission_level' => $level]);
    }

    //Insert Ticket in DB

    public function insert_ticket($data){
        $this->db->insert('tickets', $data);
        return $this->db->insert_id();
        // print_r($data);
    }

    public function get_all_tickets() {
        $this->db->select('
            tickets.id, 
            tickets.creator_id, 
            creator.username AS creator_username, 
            tickets.title, 
            tickets.description, 
            tickets.status, 
            tickets.refered_user_id, 
            refered.username AS refered_username, 
            tickets.created_at
        ');
        $this->db->from('tickets');
        $this->db->join('users AS creator', 'creator.id = tickets.creator_id', 'left');
        $this->db->join('users AS refered', 'refered.id = tickets.refered_user_id', 'left');
    
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ticket_by_id($ticket_id){
        $this->db->where('id', $ticket_id);
        $query = $this->db->get('tickets');
        return $query->row_array();
    }

    public function update_ticket_title($ticket_id, $new_ticket_title) {
        $this->db->where('id', $ticket_id)->update('tickets', ['title' => $new_ticket_title]);
    }

    public function update_ticket_description($ticket_id, $new_ticket_description) {
        $this->db->where('id', $ticket_id)->update('tickets', ['description' => $new_ticket_description]);
    }

    public function delete_ticket($ticket_id) {
        $this->db->where('id', $ticket_id)->delete('tickets');
        // echo 'Deleted ticket - ' . $ticket_id;
    }

    public function update_ticket_status($ticket_id, $new_ticket_status) {
        $this->db->where('id', $ticket_id)->update('tickets', ['status' => $new_ticket_status]);
        // echo 'Updated ticket - ' . $new_ticket_status;
    }

    public function insert_comment($data){
        $this->db->insert('comments', $data);
        return $this->db->insert_id();
        // print_r($data);
    }

    public function get_all_comments($ticket_id) {
        // $this->db->select('*');
        // $this->db->from('comments');
        // $this->db->where('ticket_id', $ticket_id);

        $this->db->select('
            comments.id, 
            comments.ticket_id,
            comments.comment_creator_id,
            ticket.title AS ticket_title, 
            creator.username AS creator_username,
            comments.comment,  
            comments.created_at
        ');
        $this->db->from('comments');
        $this->db->join('users AS creator', 'creator.id = comments.comment_creator_id', 'left');
        $this->db->join('tickets AS ticket', 'ticket.id = comments.ticket_id', 'left');
        $this->db->where('comments.ticket_id', $ticket_id);
    
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_by_id($comment_id){
        $this->db->where('id', $comment_id);
        $query = $this->db->get('comments');
        return $query->row_array();
    }

    public function update_comment($comment_id, $new_comment){
        $this->db->where('id', $comment_id)->update('comments', ['comment' => $new_comment]);
    }

    public function delete_comment($comment_id) {
        $this->db->where('id', $comment_id)->delete('comments');
    }

    public function insert_action($action){
        return $this->db->insert('actions', $action);
    }

    public function get_user_actions($user_id){
        $this->db->select('*');
        $this->db->from('actions');
        $this->db->where('active_user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}
?>


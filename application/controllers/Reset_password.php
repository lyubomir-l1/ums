<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

class Reset_password extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function forgot_password() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $user = $this->User_model->get_user_by_email($email);
    
            if ($user) {
                // Създаваме токен
                $token = bin2hex(random_bytes(32));
                $this->User_model->set_reset_token($email, $token);
    
                // Симулираме изпращане на имейл (показваме линка на екрана)
                $reset_link = site_url('reset_password/reset_password/' . $token);
                echo "Reset password link: <a href='$reset_link'>Reset Link</a>";
            } else {
                echo "Invalid email address.";
            }
        } else {
            $data['title'] = "Forgot Password";
            $this->load->view('header', $data);
            $this->load->view('forgot_password');
            $this->load->view('footer');
        }
    }

    public function reset_password($token) {
        $user = $this->User_model->get_user_by_reset_token($token);
    
        if (!$user) {
            show_error('Invalid or expired reset token.', 403);
        }

        // Проверка за последно възстановяване на парола
    if ($user['last_password_reset']) {
        $last_reset_time = strtotime($user['last_password_reset']);
        $next_reset_time = strtotime('+1 day', $last_reset_time);
        $current_time = time();

        if ($current_time < $next_reset_time) {
            $remaining_time = $next_reset_time - $current_time;
            $hours = floor($remaining_time / 3600);
            $minutes = floor(($remaining_time % 3600) / 60);

            echo "You can reset your password again in $hours hours and $minutes minutes.";
            echo '<a href="'.site_url('login/login').'"><button>Go To Login</button></a>';
            exit;
        }
    }
    
        if ($this->input->post()) {
            $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            $this->User_model->update_password($user['id'], $new_password);
            $this->User_model->clear_reset_token($user['id']);
            $this->User_model->update_last_password_reset($user['id']); // Обновява времето

            //TODO: tracking functionality
            
            $action = [
                'active_user_id' => $user['id'],
                'action_type' => ACTION_RESET_PASS,
                'old_value' => '',
                'new_value' => '',
                'passive_user_id' => NULL,
                'ticket_id' => NULL,
                'comment_id' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->User_model->insert_action($action);

            // print_r($action);

            echo "Password reset successfully!";
            echo "<br>";
            echo '<a href="'.site_url('login/login').'">
            <button>Go To Login</button>
            </a>';
        } else {
            $data['token'] = $token;
            $title['title'] = "Register Page";
            $this->load->view('header', $title);
            $this->load->view('reset_password', $data);
            $this->load->view('footer');
        }
    }
}

?>
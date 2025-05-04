<?php 
    defined('BASEPATH') OR exit('No direct script access allowed!');
    class Login extends CI_Controller{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('User_model');
            $this->load->helper('cookie');
        }

        public function login(){
            $data['title'] = "Login Page";
            $this->load->view('header', $data);
            $this->load->view('login');
            $this->load->view('footer');
        }
    
        public function login_user(){
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $remember_me = $this->input->post('remember_me');
    
            if($this->User_model->is_user_locked_out($email)){
                
                echo "You`ve been locked out! Try again in 1 hour!";
                return;
            }
    
            $user = $this->User_model->get_user_by_email($email);
    
             
             $ip_address = $this->input->ip_address();
             $user_agent = $this->input->user_agent();
             $browser_details = $this->get_browser_name($user_agent); 
             $login_time = date('Y-m-d H:i:s');
             $status = 'fail'; 
    
            if($user && password_verify($password, $user['password'])){
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('permission_level', $user['permission_level']);
                $this->session->set_flashdata('login_success', true);
                $this->User_model->clear_lockout($email);
                $status = 'success'; 
    
                if($remember_me){
                    $token = bin2hex(random_bytes(32));
                    $this->User_model->set_remember_token($user['id'], $token);
    
                    $cookie = array(
                        'name' => 'remember_me',
                        'value' =>  $token,
                        'expire' => 60 * 60 * 24 * 30,
                        'secure' => false
                    );
    
                    $this->input->set_cookie($cookie);
                }
    
               
                $this->User_model->log_user_login([
                'user_id' => $user ? $user['id'] : null, 
                'ip_address' => $ip_address,
                'browser_details' => $browser_details,
                'status' => $status,
                'login_time' => $login_time
                ]);
    
                redirect('dashboard');
            } else {
                if($user){
                    $this->User_model->increment_failed_attempts($email);
                    if($user['failed_attempts'] + 1 >= 3){
                        $this->User_model->lockout_user($email);
                        echo "You have 3 failed attempts to login. Try again in 1 hour!";
                        return;
                    } 
                }
                echo "Wrong password!";
            }
            
            $this->User_model->log_user_login([
                'user_id' => $user ? $user['id'] : 0, 
                'ip_address' => $ip_address,
                'browser_details' => $browser_details,
                'status' => $status,
                'login_time' => $login_time
                ]);
        }
        private function get_browser_name($user_agent) {
            if (strpos($user_agent, 'Edge') !== false) {
                return 'Microsoft Edge';
            } elseif (strpos($user_agent, 'Chrome') !== false) {
                return 'Google Chrome';
            } elseif (strpos($user_agent, 'Safari') !== false && strpos($user_agent, 'Chrome') === false) {
                return 'Safari';
            } elseif (strpos($user_agent, 'Firefox') !== false) {
                return 'Mozilla Firefox';
            } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
                return 'Internet Explorer';
            }
            return 'Unknown';
        }
    }

?>
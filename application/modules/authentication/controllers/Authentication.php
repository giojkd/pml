<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This controller will handle user registration/login/forgot password etc
 * @author Md. Faisal Alam
 */
class Authentication extends MX_Controller {

    function __construct() {
        parent :: __construct();

        $this->load->model('authentication_model', 'authentication');
    }

    public function index() {
        $this->login();
    }

    /**
     * This function will check if login credential is valid and give user to proper access
     * @author Ashraful Islam
     */
    public function login_chk() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Username', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            //Handle form validation failure
            $this->index();
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            //check validity
            $check = $this->authentication->check_credential($email, $password);
            $redirectto = $this->input->get("redirectto");
            if ($check != FALSE) {
                if ($redirectto) {
                    $redirectto = str_replace(base_url(), "", $redirectto);
                } else {
                    $redirectto = "";
                }
                $this->session->set_userdata('userdata', $check);
                redirectAlert($redirectto, "Successfully Logged In...", 'success');
            } else {
                redirectAlert("authentication/login?redirectto=$redirectto", "Invalid credentials", 'error');
            }
        }
    }

    /**
     * Showing login form
     * @todo captcha integration for failed try
     * @author Ashikur Rahman
     */
    public function login() {
        if ($this->session->userdata('userdata')) {
            $this->logout();
        }
        $this->load->view("login");
    }

    /**
     * Callback function for checking if email exists
     * @author Ashikur Rahman
     */
    public function email_check($email) {
        if ($this->authentication->check_email($email)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', lang('auth_invalid_email'));
            return FALSE;
        }
    }

    /**
     * destroy userdata session and logout
     */
    public function logout() {
        $this->session->unset_userdata('userdata');
        redirect_tr('authentication');
    }

//    public function account_activation() {
//        $this->session->unset_userdata('userdata');
//        $token = $this->input->get('token');
//        $id = $this->input->get('id');
//        if ($token & $id) {
//            $user = getUser($id);
//            $token_compare = md5($user->user_id . $user->user_email . $user->user_type);
//            if ($token_compare == $token) {
//                $this->authentication->activate_account($user->user_id);
//                redirectAlert("authentication/login", lang('auth_account_activation_success'));
//            } else {
//                echo "Invalid Token";
//                die;
//            }
//        } else {
//            echo "Invalid Request";
//            die;
//        }
//    }

    /**
     * Password reset form
     */
    // public function forgot_password(){
    //     if($this->session->userdata('userdata')){$this->logout();}
    //     $this->load->library('recaptcha');
    //     $data['body']['captcha'] = $this->recaptcha->recaptcha_get_html();
    //     $data['body']['page'] = "login_forgot_password_view";
    //     makeTemplate($data); 
    // }

    /**
     * Submit email and captcha from forgot password form
     */
    //   public function forgot_password_submit(){
    //       $this->load->library('form_validation');
    //       $this->load->library('recaptcha'); //loading captcha library
    //       $this->form_validation->set_rules('user_email', 'Email', 'trim|required|email|callback_email_check');
    //       $this->form_validation->set_rules('recaptcha_response_field', 'Security Code', 'trim|required|callback_captcha_check');
    //       if($this->form_validation->run() == FALSE){
    //           //Handle form validation failure
    //           $this->session->keep_flashdata('logincaptcha');
    //           $this->forgot_password();
    //       }else{
    //           //captcha was valid. now check login credentials
    //           $user_email = $this->input->post('user_email');
    //           $token = $this->authentication->forgot_pw_token($user_email);           
    //           if($token != FALSE){
    //               $this->adataemail->forgot_password_request_email($user_email,$token);
    // redirectAlert('authentication/login',"Password reset link has been sent. Please check your email.",'success');
    //           }else{
    //               redirectAlert("authentication/forgot_password","An error occured. Please try again.",'error');
    //           }
    //       }        
    //   }    
    // public function password_reset(){
    //     $email = $this->input->get('email');
    //     $token = $this->input->get('token');
    //     $check = $this->authentication->chk_forgot_pw_token($email,$token);
    //     if($check){
    //         $this->password_reset_form($email,$token);
    //     }else{
    //         $data['body']['msg'] = "Password reset request invalid or expired";
    //         $data['body']['page'] = "msg_view";
    //         makeTemplate($data); 
    //     }
    // }
    // public function password_reset_form($email,$token){
    //     if($this->session->userdata('userdata')){$this->logout();}
    //     $this->load->library('recaptcha');
    //     $data['body']['captcha'] = $this->recaptcha->recaptcha_get_html();
    //     $data['body']['email'] = $email;
    //     $data['body']['token'] = $token;
    //     $data['body']['page'] = "login_password_reset_form_view";
    //     makeTemplate($data);         
    // }
    // public function password_reset_submit(){
    //     $this->load->library('form_validation');
    //     $this->load->library('recaptcha'); //loading captcha library
    //     $email = $this->input->post('email');
    //     $token = $this->input->post('token');
    //     if(!($email && $token)){
    //         redirect_tr();
    //     }
    //     $this->form_validation->set_rules('user_pw', 'Password', 'trim|required');
    //     $this->form_validation->set_rules('user_pw_retype', 'Retype Password', 'trim|required|matches[user_pw]');
    //     $this->form_validation->set_rules('recaptcha_response_field', 'Security Code', 'trim|required|callback_captcha_check');
    //     if($this->form_validation->run() == FALSE){
    //         $this->password_reset_form($email,$token);
    //     }else{
    //         if($this->authentication->reset_pw($email,$token)){
    //             redirectAlert('authentication/login',"Password has been reset successfully. You can now login.",'success');
    //         }else{
    //             //$this->session->set_flashdata("alertmsg","Error occured. Please try again.");
    //             redirectAlert('authentication/login',"Error occured. Please try again.");
    //         }
    //     }        
    // }
}

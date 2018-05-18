<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Email Library that will be used in overall site for sending emails
 */
class Email_manager {

    public $protocol = "smtp";
    public $smtp_host = "smtp.ict-euro.com";
    public $smtp_user = "relay";
    public $smtp_pass = "+acce015"; //++RelTest
    public $smtp_port = "25";
    public $email_from = "info@ict-euro.com";
    public $email_from_name = "Ap4Rent";
    public $mailtype = "html";

    public function __construct() {
       $settings = getSettings();
	   if(isset($settings['ini_mail_protocol']) && isset($settings['ini_smtp_host']) && isset($settings['ini_smtp_user']) && $settings['ini_smtp_pass']){
		   $this->protocol = $settings['ini_mail_protocol'];
		   $this->smtp_host = $settings['ini_smtp_host'];
		   $this->smtp_user = $settings['ini_smtp_user'];
		   $this->smtp_pass = $settings['ini_smtp_pass'];
		   $this->smtp_port = @$settings['ini_smtp_port'];
		   $this->email_from = @$settings['ini_email_from'];
		   $this->email_from_name = @$settings['ini_site_name'];
	   }

    }

    /**
     * This is the main method for sending email.
     * All other methods will set the public properties
     * if needed and use this method to send email
     * @param string $email_to
     * @param string $sub
     * @param string $msg
     * @param string $cc
     * @return boolean true if successfully sent
     * @author Ashikur Rahman
     */
    public function send_email($email_to,$sub,$msg,$cc="", $attach = ""){
        $CI = &get_instance();
        $CI->load->library('email');

        $email_from = $this->email_from;
        $email_from_name = $this->email_from_name;

        $config['protocol'] = $this->protocol;
        $config['smtp_host'] = $this->smtp_host;
        $config['smtp_user'] = $this->smtp_user;
        $config['smtp_pass'] = $this->smtp_pass;
        $config['smtp_port'] = $this->smtp_port;
        $config['mailtype'] = $this->mailtype;

        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $CI->email->initialize($config);
        $CI->email->from($email_from,$email_from_name);
        $CI->email->to($email_to);

        if($cc!=""){
          $CI->email->cc($cc);
        }
        if($attach != "") {
            $CI->email->attach($attach);
        }
        $CI->email->subject($sub);
        $CI->email->message($msg);

        return $CI->email->send();

        //echo $CI->email->print_debugger();
    }


    public function contact_submit($data){
        $CI = &get_instance();
        $contact_email = getSettingSingle("ini_email_noti");
        //$user_email = $user->user_email;
        $sub = "Contact From Marseta";
        $msg = $CI->load->view('email/contact',$data,true);
        return $this->send_email($contact_email,$sub,$msg);
    }

	//Like above, create seperate methods for each email event and call it with required parameters where needed.

}

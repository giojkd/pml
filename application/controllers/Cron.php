<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent :: __construct();
        $this->load->library("email_manager");
        $this->load->model("cron_model");
    }
    
    public function email_alerts_for_available_room()
    {
        $booked_rooms = array();
        $free_rooms = array();
        
        $all_rooms = $this->cm->select_all("rooms");
        
        foreach($all_rooms as $room)
        {
            $room_id = $room["id"];
            
            if($this->cron_model->check_if_a_room_is_booked($room_id)){
                $booked_rooms[] = $room;
            }
            else{
                $free_rooms[] = $room;
            }
        }
        
        
        $rooms_to_expire = $this->cron_model->select_rooms_expire_in_7_days();
        
        $data = array();
        $data["all_rooms"] = $all_rooms;
        $data["booked_rooms"] = $booked_rooms;
        $data["free_rooms"] = $free_rooms;
        $data["rooms_to_expire"] = $rooms_to_expire;
        //$email_message = $this->load->view("email_templates/available_rooms",$data, true);
        //$this->email_manager->send_email("jami@ict-euro.com","Available Room Alert",$email_message);
        
        $this->load->view("email_templates/available_rooms",$data);
        //echo "email has been sent :-)";
    }
    
    
    public function test()
    {
        $this->email_manager->send_email("jami@ict-euro.com","Hello","This is a test email...");
        echo "smile :-)";
    }
    
    
    public function installment_invoice_create()
    {
        $date_today = date("Y-m-d");
        $installments = $this->cm->select_all_with_2_where("cost","cost_for","2","payment_date",$date_today);
        $current_year = date("Y");
        
        foreach($installments as $value)
        {
            $exist_already = $this->cm->exist_or_not_2_where("invoice", "installment_id", $value["id"], "create_date", $date_today);
            
            if(!$exist_already)
            {
                $last_invoice_serial = $this->select_last_invoice_serial();
                
                $data = array();
                $data["invoice_of"] = 1;
                $data["invoice_serial"] = $last_invoice_serial+1;
                $data["invoice_year"] = $current_year;
                $data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
                $data["invoice_amount"] = $value["revenue_amount"];
                $data["oc_id"] = 0;
                $data["installment_id"] = $value["id"];
                $data["create_date"] = date("Y-m-d");
                $this->cm->insert("invoice",$data);
            }
        }
    }
    
    
    public function select_last_invoice_serial() {
        $this->db->from("invoice");
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $return = $this->db->get();

        if ($return->num_rows()) {
            return $return->row()->invoice_serial;
        } else {
            return 0;
        }
    }
    

    
    
}

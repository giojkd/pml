<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class Tenant_Model extends CI_Model {

    function get_all_requests($user_id = 0) {
        if($user_id){
            $this->db->where('user_id', $user_id);
        }else{
            $this->db->select('tenant_request.*, user.name, user.family_name, apartment_detail.address as apartment_address, apartment_detail.zip_code as apartment_zip_code, apartment_detail.floor as apartment_floor');
            $this->db->join('user', 'user.id = user_id');
            $this->db->join('apartment_detail', 'apartment_detail.id = apartment_id','LEFT');
        }
        $query = $this->db->get('tenant_request');
        return $query->result_array();
    }

    function get_feedback_messages($request_id, $last_id = 0) {
        $this->db->select('request_feedback.*, DATE_FORMAT(request_feedback.create_date, "%d-%b-%Y %h:%i %p") as create_date,user.name, user.family_name');
        $this->db->from('request_feedback');
        $this->db->join('user', 'user.id = request_feedback.user_id', 'LEFT');
        $this->db->where('request_id', $request_id);
        $this->db->where('request_feedback.id > ' . $last_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function make_all_feedback_seen($request_id) {
        $user_id = getUserdata('user_id');
        $this->db->where('request_id', $request_id);
        $this->db->where('user_id !=' . $user_id);
        $this->db->where('seen', 0);
        return $this->db->update('request_feedback', array('seen' => 1));
    }

    function get_unseen_feedback_message_requests($request_ids) {
        $this->db->select('request_feedback.request_id');
        $this->db->from('request_feedback');
        $this->db->where_in('request_id', $request_ids);
        $this->db->where('user_id !=' . getUserdata('user_id'));
        $this->db->where('seen', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_feedback_images($request_id = 0) {

        $this->db->where('request_id', $request_id);
        $query = $this->db->get('request_feedback_image');
        return $query->result_array();
    }
    
    public function select_bookings_by_tenant($user_id) {
        $this->db->select("*");
        $this->db->from("apartment_booked_list");
        $this->db->where("user_id", $user_id);
        //return $this->db->get()->row_array();
        
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->row_array();
        } else {
            return array();
        }
    }
    
    public function select_installments_by_booking($booking_id) {
        $this->db->select("*");
        $this->db->from("cost");
        $this->db->where("booking_id", $booking_id);
        $this->db->where("cost_for", "2");
        $this->db->where("payment_status", "1");
        //return $this->db->get()->row_array();
        
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }
    
    


}

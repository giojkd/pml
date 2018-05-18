<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class Apartment_Model
 */
class Calendar_Model extends CI_Model {
    


    public function select_booked_list_by_room_id($apartment_id,$room_id){
        $date_today = date("Y-m-d");
        $this->db->select('*');
        //$this->db->join('apartment_service_charges', "apartment_detail.id = apartment_service_charges.apartment_id");
        $this->db->where('apartment_id', $apartment_id);
        $this->db->where('room_id', $room_id);
        //$this->db->where('rent_to >=', $date_today);
        $this->db->where("(UNIX_TIMESTAMP(rent_to) >= UNIX_TIMESTAMP('$date_today'))");
        $result = $this->db->get('apartment_booked_list');
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }
    
    
    public function select_bookings_by_room_id($apartment_id,$room_id){
        $this->db->select('*');
        $this->db->where('apartment_id', $apartment_id);
        $this->db->where('room_id', $room_id);
        $result = $this->db->get('apartment_booked_list');
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    
    
}
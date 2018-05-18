<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class Cron_Model
 */
class Cron_model extends CI_Model {
    
    public function select_rooms_expire_in_7_days()
    {
        $date_after_7_days = date('Y-m-d', strtotime("+7 day"));
        $date_today = date("Y-m-d");
        
        $this->db->select('apartment_booked_list.id as appt_id,apartment_booked_list.rent_to,rooms.*');
        $this->db->from('apartment_booked_list');
        $this->db->join('rooms','apartment_booked_list.room_id=rooms.id');
        $this->db->where("((apartment_booked_list.rent_to >= '$date_today') AND (apartment_booked_list.rent_to <= '$date_after_7_days'))");
        $result = $this->db->get();
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    
    public function check_if_a_room_is_booked($room_id)
    {
        $date_today = date("Y-m-d ");
        
        $this->db->select('*');
        $this->db->from('apartment_booked_list');
        $this->db->where('room_id',$room_id);
        $this->db->where("(UNIX_TIMESTAMP(rent_to) >= UNIX_TIMESTAMP('$date_today'))");
        $result = $this->db->get();
        
        if ($result->num_rows()) {
            return true; //means booked
        } else {
            return false;
        }
    }
    


}
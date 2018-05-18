<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class Cleaning_Model extends CI_Model {
    // public $protected_attributes = array( 'id', 'psalt', 'username', 'password' );
    //public $belongs_to = array( 'types' => array( 'model' => 'user/type_model', 'primary_key' => 'user_type' ) );
    public $_table = 'user';
    public $primary_key = 'id';

    public function get_rooms_in_apartment($apartment_id)
    {
        $this->db->select('*');
        $this->db->from('rooms');
        $this->db->where('apartment_id', $apartment_id);
        $query = $this->db->get();
        return $query->result_array();
    }
     public function get_rooms_in_apartment_and_common_area($apartment_id)
    {
        $this->db->select('rooms.*, common_area.type, common_area.qty');
        $this->db->from('rooms');
        $this->db->join('common_area','common_area.apartment_id = rooms.apartment_id','LEFT');
        $this->db->where('rooms.apartment_id', $apartment_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_booking_info($apartment_id)
    {
        $this->db->select('apartment_booked_list.*, user.family_name, user.name');
        $this->db->from('apartment_booked_list');
        $this->db->join('user','user.id = apartment_booked_list.user_id','LEFT');
        $this->db->where('apartment_booked_list.apartment_id', $apartment_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_booking_info_per_room($apartment_id, $room_id)
    {
        $this->db->select('apartment_booked_list.*, user.family_name, user.name');
        $this->db->from('apartment_booked_list');
        $this->db->join('user','user.id = apartment_booked_list.user_id','LEFT');
        $this->db->where('apartment_booked_list.apartment_id', $apartment_id);
        $this->db->where('apartment_booked_list.room_id', $room_id);
        $this->db->order_by('apartment_booked_list.id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_cleaning($cleaning_data)
    {
        $this->db->insert('cleaning', $cleaning_data);
        return $this->db->insert_id();
    }

    public function get_all_cleaning_info()
    {
        $this->db->select('cleaning.*,suppliers.company as supplier_company,rooms.room_description,cleaners.cleaner_name, apartment_detail.id as apartment_id,apartment_detail.address, rooms.id as room_id, common_area.type');
        $this->db->from('cleaning');
        $this->db->join('cleaners','cleaners.cleaner_id = cleaning.cleaner_id','LEFT');
        $this->db->join('apartment_detail','apartment_detail.id = cleaning.apartment_id','LEFT');
        $this->db->join('rooms','rooms.id = cleaning.room_id','LEFT');
        $this->db->join('common_area','common_area.apartment_id = cleaning.apartment_id','LEFT');
        $this->db->join('suppliers','cleaning.supplier_id = suppliers.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_cleaning_info_from_cost($cleaning_id)
    {
        $this->db->select("cost.*, invoice.id as invoice_id, invoice.create_date as invoice_date, invoice.invoice_no as invoice_no, invoice.oc_id as oc_id");
        $this->db->from("cost");
        $this->db->join("invoice","invoice.oc_id = cost.id");
        $this->db->where("cost.cleaning_id",$cleaning_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_cleaning_info_from_invoice($cost_id)
    {
        $this->db->select("*");
        $this->db->from("invoice");
        $this->db->where("oc_id",$cost_id);
        $query = $this->db->get();
        return $query->row_array();
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class Supplier_Model
 */
class Supplier_Model extends CI_Model {

    public function get_city_by_county_code()
    {
        $q = $this->db->where("city_status", 1)->order_by("city_name")->get("city");
        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function get_city_by_county($county_code) {
        $this->db->where("county_code", $county_code);
        $this->db->order_by("city_name");
        $q = $this->db->get("ini_cities");
        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function store_supplier($data)
    {
        $this->db->insert('suppliers',$data);
        return $this->db->insert_id();
    }

    public function get_all_supplier()
    {
        $this->db->select('suppliers.*, ini_provinces_regions.county_name, ini_cities.city_name');
        $this->db->from('suppliers');
        $this->db->join('ini_provinces_regions','suppliers.county_code=ini_provinces_regions.county_code',"left");
        $this->db->join('ini_cities','suppliers.city_code=ini_cities.city_code',"left");
        $result = $this->db->get();
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function update_supplier($data)
    {
        $this->db->where("id",$this->input->post("supplier_id"));
        $this->db->update("suppliers",$data);
        return true;
    }

}

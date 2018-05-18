<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * COmmon Model 
 * @author ICT Euro
 */
class Common_model extends CI_Model {

    //put your code here

    public function get_city_by_country($country_id, $is_array = false){
        $this->db->select('city_id,country_id,city_name');
        $this->db->from('city');
        $this->db->where('country_id',$country_id);
        if($is_array == true){
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->result();
        }
    }


    public function get_country_list() {
        $q = $this->db->where("country_status", 1)->order_by("country_shortName")->get("country");
        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function getCountry($country_id = "", $country_code = "") {
        if ($country_id || $country_code) {
            if ($country_id) {
                $this->db->where("country_id", $country_id);
            } elseif ($country_code) {
                $this->db->where("country_code", $country_code);
            }
            $this->db->where("country_status", 1);
            $q = $this->db->get("country");
            if ($q->num_rows()) {
                return $q->row_array();
            } else {
                return false;
            }
        }
    }


    public function get_currency_list() {
        $q = $this->db->where("currency_status", 1)->order_by("currency_order")->get("currency");
        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function insert($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function select_single_field($value, $table_name, $condition_field, $condition_value) {
        $this->db->select($value);
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        $return = $this->db->get();
        if ($return->num_rows()) {
            return $return->row()->$value;
        } else {
            return false;
        }
    }

    public function select_single_field_2_where($value, $table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->select($value);
        $this->db->from($table_name);
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        return $this->db->get()->row()->$value;
    }

    public function select_single_row($table_name, $condition_field, $condition_value) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        return $this->db->get()->row_array();
    }

    public function select_single_row_2_where($table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        return $this->db->get()->row_array();
    }

    public function select_single_column($select_field, $table_name, $condition_field, $condition_value) {
        $this->db->select($select_field);
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        return $this->db->get()->row_array();
    }

    public function select_all($table_name) {
        return $this->db->get($table_name)->result_array();
    }

    public function select_all_asc($table_name, $field_name) {
        $this->db->order_by($field_name, "asc");
        return $this->db->get($table_name)->result_array();
    }

    public function select_all_desc($table_name, $field_name) {
        $this->db->order_by($field_name, "desc");
        return $this->db->get($table_name)->result_array();
    }

    public function select_all_where($table_name, $condition_field, $condition_value) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        $result = $this->db->get();
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function select_all_where_asc($table_name, $condition_field, $condition_value, $order_field_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        $this->db->order_by($order_field_name, "asc");
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function select_all_with_2_where($table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        $result = $this->db->get();
        
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }
    
    public function select_all_with_2_or_where($table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($condition_field1, $condition_value1);
        $this->db->or_where($condition_field2, $condition_value2);
        return $this->db->get()->result_array();
    }

    public function update($table_name, $data, $condition_field, $condition_value) {
        $this->db->where($condition_field, $condition_value);
        $this->db->update($table_name, $data);
        return true;
    }

    public function update_2_where($table_name, $data, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        $this->db->update($table_name, $data);
        return true;
    }

    public function delete($table_name, $condition_field, $condition_value) {
        $this->db->where($condition_field, $condition_value);
        $this->db->delete($table_name);
        return true;
    }

    public function delete_3_where($table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2, $condition_field3, $condition_value3) {
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        $this->db->where($condition_field3, $condition_value3);
        $this->db->delete($table_name);
        return true;
    }

    public function exist_or_not($table_name, $condition_field, $condition_value) {
        $this->db->from($table_name);
        $this->db->where($condition_field, $condition_value);
        $return = $this->db->get();

        if ($return->num_rows())
            return 1;
        else
            return 0;
    }

    public function exist_or_not_2_where($table_name, $condition_field1, $condition_value1, $condition_field2, $condition_value2) {
        $this->db->from($table_name);
        $this->db->where($condition_field1, $condition_value1);
        $this->db->where($condition_field2, $condition_value2);
        $return = $this->db->get();

        if ($return->num_rows())
            return 1;
        else
            return 0;
    }




}

?>

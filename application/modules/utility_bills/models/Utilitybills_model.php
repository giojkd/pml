<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* Class User_Model
*/
class Utilitybills_model extends CI_Model {

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_all_apartment_info(){
    echo 'cane';
    $this->db->select('apartment_detail.*, apartment_detail.id as apartment_id, user.name, user.family_name');
    $this->db->join('user', "user.id = apartment_detail.owner");
    $query = $this->db->get('apartment_detail');
    return $query->result_array();
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

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_all_apartment(){
    $this->db->select('apartment_detail.*, apartment_detail.id as apartment_id, user.name, user.family_name, internet_close_status, council_tax_close_status, water_close_status, electricity_close_status, gas_close_status');
    $this->db->join('user', "user.id = apartment_detail.owner");
    $this->db->join('apartment_to_close_list', 'apartment_detail.id = apartment_to_close_list.apartment_id');
    $query = $this->db->get('apartment_detail');
    return $query->result_array();
  }

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_apartment_info($apartment_id){
    $this->db->select('apartment_detail.*, user.name, user.family_name');
    $this->db->join('user', "user.id = apartment_detail.owner");
    $this->db->where('apartment_detail.id', $apartment_id);
    $query = $this->db->get('apartment_detail');
    return $query->row_array();
  }

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_apartment_info_with_setup(){
    $this->db->select('apartment_detail.id as apid, user.name, user.family_name, a.*, apartment_detail.contract_from, apartment_detail.contract_to');
    $this->db->join('user', "user.id = apartment_detail.owner");
    $this->db->join('apartment_to_setup_list a', 'apartment_detail.id=a.apartment_id', 'left');
    $query = $this->db->get('apartment_detail');
    return $query->result_array();
  }

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_apartment_to_close_info($apartment_id){
    $this->db->select('*');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('apartment_to_close_list');

    if($query->num_rows()>0) {
      return $query->row_array();
    } else {
      return false;
    }
  }

  /**
  * @return mixed
  * @author Razib Mahmjd
  */
  public function get_apartment_to_setup_info($apartment_id){
    $this->db->select('*');
    $this->db->join('apartment_detail', 'apartment_detail.id=apartment_to_setup_list.apartment_id', 'left');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('apartment_to_setup_list');

    if($query->num_rows()>0) {
      return $query->row_array();
    } else {
      return false;
    }
  }
}

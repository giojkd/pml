<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class User_Model extends CI_Model {
    // public $protected_attributes = array( 'id', 'psalt', 'username', 'password' );
    //public $belongs_to = array( 'types' => array( 'model' => 'user/type_model', 'primary_key' => 'user_type' ) );
    public $_table = 'user';
    public $primary_key = 'id';

    public function save_change_password($user_id, $password)
    {
        $this->load->library('crypt');

        $psalt    = $this->crypt->salt();
        $password = $this->crypt->generate_password($password, $psalt);

        $db_array = array(
            'password'    => $password,
            'psalt' => $psalt
        );
        $this->user->update($user_id, $db_array);
    }

    public function generatePassword($password, $type = 'p')
    {
        $this->load->library('crypt');

        $psalt    = $this->crypt->salt();
        $password = $this->crypt->generate_password($password, $psalt);

        if($type == 's') {
            return $psalt;
        }
        return $password;
    }

    public function get_all(){
        return $this->db->get($this->_table)->result_array();
    }

    public function get_admin(){
      $this->db->select("*");
      $this->db->from('user');
      $this->db->where('type', 1);
      return $result = $this->db->get()->result_array();

    }

    public function get_all_where($table_name, $condition_field, $condition_value) {
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

    public function get($id)
    {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where($this->primary_key, $id);
        $this->db->limit(1);
        $data = $this->db->get()->result_array();

        foreach($data as $value) {
            $result = $value;
        }
        return $result;
    }
    public function insert($data) {
        $file_name = $this->input->post('file_name');
        $this->db->insert($this->_table,$data);
        $inserted_id =  $this->db->insert_id();
        if($inserted_id)
        {
             return $inserted_id;
        }
        else
        {
            unlink("./uploads/user_file/" . $file_name);
        }

    }
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->_table);
    }
    public function update($id, $data)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->_table, $data);
        return true;
    }

    public function get_many_by()
    {
        $where = func_get_args();
        $this->_set_where($where);
        return $this->get_all();
    }
    protected function _set_where($params)
    {
        if (count($params) == 1)
        {
            $this->db->where($params[0]);
        }
        else if(count($params) == 2)
        {
            $this->db->where($params[0], $params[1]);
        }
        else if(count($params) == 3)
        {
            $this->db->where($params[0], $params[1], $params[2]);
        }
        else
        {
            $this->db->where($params);
        }
    }

    function get_cities(){
        $this->db->select('city_id,city_name');
        $this->db->where('city_name != ""');
        $query = $this->db->get('city');
        return $query->result();
    }

    public function get_owner(){
      $this->db->select('*');
      $this->db->select('(SELECT GROUP_CONCAT(address SEPARATOR "<br>") FROM apartment_detail ad WHERE ad.owner = u.id GROUP BY ad.owner) as owner_properties_list ');
      $this->db->where('type',6);


      $query = $this->db->get('user u');
      return $query->result_array();
    }



    public function get_user_by_type($type){
        $this->db->select('*');
        $this->db->where('type', $type);
        $query = $this->db->get('user');
        return $query->result_array();
    }

    public function get_occupants_list(){
      $this->db->select('*');
      $this->db->join('apartment_booked_list abl', "user.id = abl.user_id");
      $this->db->join('apartment_detail ad',"abl.apartment_id = ad.id");
      $this->db->join('rooms r',"abl.room_id = r.id");
      $this->db->where('type', 5);
      $query = $this->db->get('user');
      return $query->result_array();
    }

}

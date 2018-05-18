<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * User log model of
 * User Module
 */
class User_log_Model extends CI_Model {
    public $_table = 'user_logs';
    public $primary_key = 'id';

    public function get_all(){
        return $this->db->get($this->_table)->result_array();
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
        $this->db->insert($this->_table,$data);
        return $this->db->insert_id();
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
}
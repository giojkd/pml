<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Generalcost_model
 * This class is for managing general cost model
 * @author Md. Asif Rahman
 */
class Generalcost_model extends CI_Model {
    /**
     * This method is used to save apartments general cost
     * @
     */
    public function select_all()
    {
    	$this->db->select('general_cost.*,suppliers.*');
    	$this->db->from('general_cost');
    	$this->db->join('suppliers','suppliers.id=general_cost.supplier_id','left');
    	return $this->db->get()->result_array();
    }

    public function save_bank_movement()
    {
        $data = array();
        $data['movement_date'] = formatted_date($this->input->post('movement_date'),"Y-m-d");
        $data['movement_description'] = $this->input->post('movement_description');
        $data['movement_amount'] = abs($this->input->post('movement_amount'));
        $data['movement_type'] = $this->input->post('movement_type');
//        $data['to_whom'] = $this->input->post('tenant_or_owner');
//        if($this->input->post('tenant_user_id'))
//        {
//            $data['tenant_id'] = $this->input->post('tenant_user_id');
//        }
//        else if($this->input->post('owner_user_id'))
//        {
//            $data['owner_id'] = $this->input->post('owner_user_id');
//        }
        $data['entry_date'] = date('Y-m-d');
        $this->db->insert("bank_movement",$data);
        return $this->db->insert_id();

    }
}
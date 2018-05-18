<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Generalcost_model
 * This class is for managing general cost model
 * @author Md. Asif Rahman
 */
class Invoice_model extends CI_Model {
    /**
     * This method is used to save apartments general cost
     * @
     */


    public function select_installment_invoices()
    {
        /*
        $this->db->select("invoice.*,cost.*");
        $this->db->from("invoice");
        $this->db->join('cost','invoice.installment_id=cost.id');
        $this->db->where("invoice.invoice_of","1"); //2 means installment
        $this->db->order_by("invoice.id","desc");
        $result = $this->db->get();
        */

        $this->db->select("*");
        $this->db->select("user.name as user_name");
        $this->db->select("invoice.id as invoice_id");
        $this->db->select("user.family_name as user_surname");
        $this->db->from("invoice");
        $this->db->join('user', "invoice.user_id = user.id","left");
        $this->db->order_by("invoice.id","desc");
        $result = $this->db->get();



        if ($result->num_rows()) {
          
            return $result->result_array();
        } else {
            return array();
        }
    }



}

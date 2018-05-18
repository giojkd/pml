<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Generalcost_model
 * This class is for managing general cost model
 * @author Md. Asif Rahman
 */
class Revenue_model extends CI_Model {
    /**
     * This method is used to save apartments general cost
     * @
     */


     public function get_invoice_costs($invoice_id){
       echo $invoice_id;
       $this->db->select("*");
       $this->db->from("cost");
       $this->db->where("invoice_id",$invoice_id);
       $result = $this->db->get();
       return $result->result_array();
     }

    public function select_due_installments($id = "")
    {
        $this->db->select("*, (select count(invoice.id) from invoice where invoice.installment_id = cost.id) as count_invoice");
        $this->db->from("cost");
        $this->db->where("cost_for","2");
        $this->db->where("payment_status","0");

        if($id){
           $this->db->where("id",$id);
        }

        $this->db->order_by("payment_date","desc");
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }


    public function select_due_payments()
    {
        $this->db->select('cost.*,user.name,user.family_name,apartment_detail.address');
        $this->db->where('cost_for',"1");
        $this->db->from('cost');
        $this->db->join('user','cost.tenant_user_id=user.id','left');
        $this->db->join('apartment_detail','cost.apartment_id=apartment_detail.id','left');
        $this->db->where("cost.cost_for","1");
        $this->db->where("cost.payment_status","0");
        $this->db->order_by("cost.payment_date","desc");
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }

        /*
        $this->db->select("*");
        $this->db->from("cost");
        $this->db->where("cost_for","1");
        $this->db->where("payment_status","0");
        $this->db->order_by("payment_date","desc");
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
        */
    }
}

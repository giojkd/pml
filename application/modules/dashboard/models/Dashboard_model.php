<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Special_service Model
 *
 * @author Rejoanul Alam
 */
class Dashboard_model extends CI_Model {

    function add_quantity($product_id, $product_attr_id, $qty) {
        $_DB_PREFIX = 'ps_test_';
        $this->db->set('quantity', 'quantity + ' . (int) $qty, FALSE);
        $this->db->where('id_product', $product_id);
        $this->db->where('id_product_attribute', $product_attr_id);
        return $this->db->update($_DB_PREFIX . 'stock_available');
    }

    function substitute_quantity($product_id, $product_attr_id, $qty) {
        $_DB_PREFIX = 'ps_test_';
        $this->db->set('quantity', 'quantity - ' . (int) $qty, FALSE);
        $this->db->where('id_product', $product_id);
        $this->db->where('id_product_attribute', $product_attr_id);
        return $this->db->update($_DB_PREFIX . 'stock_available');
    }

    function replace_quantity($product_id, $product_attr_id, $qty, $old_qty = "") {
        $_DB_PREFIX = $this->config->item('db_prefix');
        if ($product_attr_id) {
            $this->db->where('id_product', $product_id);
            $this->db->where('id_product_attribute', $product_attr_id);
            return $this->db->update($_DB_PREFIX . 'stock_available', array('quantity' => $qty));
        } else {
            $this->db->set('quantity', 'quantity - ' . $old_qty . ' + ' . $qty, FALSE);
            $this->db->where('id_product', $product_id);
            $this->db->where('id_product_attribute', $product_attr_id);
            return $this->db->update($_DB_PREFIX . 'stock_available');
        }
    }

    public function tenant_requests_by_apartment($apartment_id){
    
        $this->db->select('*');
        $this->db->from('apartment_detail as ad');
        $this->db->where('ad.id', $apartment_id);
        $this->db->join('tenant_request as tr', 'ad.id =tr.apartment_id', 'left');
        $this->db->order_by('tr.create_date', 'desc');
        $this->db->where('tr.status',0);
        return $this->db->get()->row_array();
    }

    public function get_apartment_room_details($apartment_id){
        $this->db->select('*');
        $this->db->from('apartment_detail as ad');
        $this->db->where('ad.id',$apartment_id);
        $this->db->join('rooms as r','r.apartment_id=ad.id');
        return $this->db->get()->result_array();
    }
    
    public function tenant_requests_by_apartment1($apartment_id){
    
        $this->db->select('*,ad.id as apartment_id,tr.id as tenant_req_id');
        $this->db->from('apartment_detail as ad');
        $this->db->where('ad.id', $apartment_id);
        $this->db->join('tenant_request as tr', 'ad.id =tr.apartment_id', 'left');
        $this->db->order_by('tr.create_date', 'desc');
        $this->db->where("(tr.status='0' OR tr.status is NULL)");
        return $this->db->get()->row_array();
    }
    

}

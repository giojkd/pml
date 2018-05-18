<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class Stock_model extends CI_Model {

    public function save_item() {
        $data = array();
        $data["item_name"] = $this->input->post("item_name");
        $data["create_date"] = date("Y-m-d H:i:s");
        $this->db->insert("stock_item", $data);
        return $this->db->insert_id();
    }

    public function select_external_items() {
        $this->db->select('stock_external.*, stock_item.item_name');
        $this->db->from('stock_external');
        $this->db->join('stock_item', 'stock_external.item_id=stock_item.item_id');
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function getExternalItem($id) {
        $this->db->select('stock_external.*,stock_item.item_name');
        $this->db->from('stock_external');
        $this->db->join('stock_item', 'stock_external.item_id=stock_item.item_id');
        $this->db->where('stock_external.id', $id);
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->row_array();
        } else {
            return array();
        }
    }

    public function save_external_item() {
        $item_id = $this->save_item();
        $data = array();
        $data["item_id"] = $item_id;
        $data["current_quantity"] = $this->input->post("item_quantity");
        $data["note"] = $this->input->post("note");
        $data["create_date"] = date("Y-m-d H:i:s");
        $data["update_date"] = date("Y-m-d H:i:s");
        $this->db->insert("stock_external", $data);
        return $this->db->insert_id();
    }

    public function update_external_item() {
        $data = array();
        $data["current_quantity"] = $this->input->post("item_quantity");
        $data["note"] = $this->input->post("note");
        $data["update_date"] = date("Y-m-d H:i:s");

        $this->db->where("id", $this->input->post("id"));
        $this->db->update("stock_external", $data);
        return true;
    }

    public function select_all_apartment_items() {
        $this->db->select('stock_apartment.*,stock_item.item_name, apartment_detail.address, rooms.room_type, user.name, user.family_name');
        $this->db->from('stock_apartment');
        $this->db->join('stock_item', 'stock_apartment.item_id=stock_item.item_id');
        $this->db->join('apartment_detail', 'stock_apartment.apartment_id=apartment_detail.id');
        $this->db->join('rooms', 'rooms.id=stock_apartment.room_id', 'left');
        $this->db->join('user', "user.id = apartment_detail.owner");

        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    public function getApartmentItem($id) {
        $this->db->select('stock_apartment.*,stock_item.item_name');
        $this->db->from('stock_apartment');
        $this->db->join('stock_item', 'stock_apartment.item_id=stock_item.item_id');
        $this->db->where('id', $id);
        $result = $this->db->get();

        if ($result->num_rows()) {
            return $result->row_array();
        } else {
            return array();
        }
    }

    public function save_apartment_item() {
        $apartment_id = $this->input->post("apartment_id");
        $room_id = $this->input->post('room_id');
        $item_name = $this->input->post('item_name');
        $item_quantity = $this->input->post('item_quantity');

        foreach ($item_name as $key => $value) {
            $item = array();
            $item["item_name"] = $value;
            $item["create_date"] = date("Y-m-d H:i:s");
            $item["update_date"] = date("Y-m-d H:i:s");
            $this->db->insert("stock_item", $item);
            $item_id = $this->db->insert_id();

            $data = array();
            $data["apartment_id"] = $apartment_id;
            $data["room_id"] = $room_id[$key];
            $data["item_id"] = $item_id;
            $data["current_quantity"] = $item_quantity[$key];
            $data["create_date"] = date("Y-m-d H:i:s");
            $data["update_date"] = date("Y-m-d H:i:s");
            $this->db->insert("stock_apartment", $data);
        }
        return true;
    }

    public function update_apartment_item() {
        $data = array();
        $data["current_quantity"] = $this->input->post("item_quantity");
        $data["update_date"] = date("Y-m-d H:i:s");

        $this->db->where("id", $this->input->post("id"));
        $this->db->update("stock_apartment", $data);
        return true;
    }

}

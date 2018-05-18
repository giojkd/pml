<?php

class Stock extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('stock_model');
        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {

    }
    
    public function item_list() {
        $data = array();
        $data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['header']['title'] = "Item List";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "item_list";
        makeTemplateAdmin($data);
    }

    public function item_add() {
        $data = array();
        $data['header']['title'] = "Item Add";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "item_add";
        makeTemplateAdmin($data);
    }
    
    public function item_add_save()
    {
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->item_add();
        }
        else
        {
            $this->stock_model->save_item();
            redirectAlert("stock/item_list",lang('save_success'));
        }
    }
    
    public function item_delete($item_id)
    {
        $exist1 = $this->cm->exist_or_not("stock_external", "item_id", $item_id);
        $exist2 = $this->cm->exist_or_not("stock_apartment", "item_id", $item_id);
        
        if($exist1 || $exist2)
        {
            redirectAlert("stock/item_list","Item is in use. Can't be deleted");
        }
        else
        {
            $this->db->where("item_id",$item_id);
            $this->db->delete("stock_item");
            redirectAlert("stock/item_list",lang('delete_success'));
        }
    }
    
    
    public function external_item_list() {
        $data = array();
        $data['body']['items'] = $this->stock_model->select_external_items();
        $data['header']['title'] = "External Stock";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "external_item_list";
        makeTemplateAdmin($data);
    }
    
    public function external_item_add() {
        $data = array();
        //$data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['header']['title'] = "External Item Add";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "external_item_add";
        makeTemplateAdmin($data);
    }
    
    
    public function external_item_add_save()
    {
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        //$this->form_validation->set_rules('item_id', 'Item Name', 'required|callback_check_if_item_has_been_added_in_external_already');
        $this->form_validation->set_rules('item_quantity', 'Quantity', 'required');
        
        if ($this->form_validation->run($this) == FALSE) {
            $this->external_item_add();
        }
        else
        {
            $this->stock_model->save_external_item();
            redirectAlert("stock/external_item_list",lang('save_success'));
        }
    }
    
    public function check_if_item_has_been_added_in_external_already($item_id)
    {
        $exist = $this->cm->exist_or_not("stock_external", "item_id", $item_id);
        
        if($exist){
            $this->form_validation->set_message('check_if_item_has_been_added_in_external_already', 'This item has been added already');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    
    public function external_item_edit($id) {
        $data = array();
        //$data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['body']['details'] = $this->stock_model->getExternalItem($id);
        $data['header']['title'] = "External Item Edit";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "external_item_edit";
        makeTemplateAdmin($data);
    }
    
    
    public function external_item_edit_save()
    {
        $this->form_validation->set_rules('item_quantity', 'Quantity', 'required');
        
        if ($this->form_validation->run($this) == FALSE) {
            $this->external_item_edit($this->input->post("id"));
        }
        else
        {
            $this->stock_model->update_external_item();
            redirectAlert("stock/external_item_list",lang('save_success'));
        }
    }
    
    
    public function external_item_delete($id)
    {
        $this->db->where("id",$id);
        $this->db->delete("stock_external");
        redirectAlert("stock/external_item_list",lang('delete_success'));
    }
    
    
    // Handled apartment stock below
    public function apartment_item_list() {
        $data = array();
        $data['body']['items'] = $this->stock_model->select_all_apartment_items();
        /*print_r($data['body']['items']).exit;*/
        $data['header']['title'] = "Apartment Stock";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "apartment_item_list";
        makeTemplateAdmin($data);
    }
    
    public function apartment_item_add() {
        $data = array();
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        $data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['header']['title'] = "Apartment Item Add";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "apartment_item_add";
        makeTemplateAdmin($data);
    }
    
    public function apartment_item_add_save()
    {
        $rooms = $this->input->post('room_id');
        
        $item_name = $this->input->post('item_name');
        $item_name = array_filter($item_name);
        if(empty($item_name)){
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        }
        
        $item_quantity = $this->input->post('item_quantity');
        $item_quantity = array_filter($item_quantity);
        if(empty($item_quantity)){
            $this->form_validation->set_rules('item_quantity', 'Quantity', 'required');
        }
        

        $this->form_validation->set_rules('apartment_id', 'Apartment', 'required');
        //$this->form_validation->set_rules('apartment_id', 'Apartment', 'required|callback_check_if_item_has_been_added_in_apartment_already');

        if ($this->form_validation->run($this) == FALSE) {
            $this->apartment_item_add();
        }
        else
        {
            $this->stock_model->save_apartment_item();
            redirectAlert("stock/apartment_item_list",lang('save_success'));
        }
    }
    
    public function check_if_item_has_been_added_in_apartment_already()
    {
        $exist = $this->cm->exist_or_not_2_where("stock_apartment", "item_id", $this->input->post("item_id"), "apartment_id", $this->input->post("apartment_id"));
        
        if($exist){
            $this->form_validation->set_message('check_if_item_has_been_added_in_apartment_already', 'This item has been added already');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    
    public function apartment_item_edit($id) {
        $data = array();
        $data['body']['details'] = $this->stock_model->getApartmentItem($id);
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        //$data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['header']['title'] = "Apartment Item Edit";
        $data['header']['menu_base'] = "stock";
        $data['body']['page'] = "apartment_item_edit";
        makeTemplateAdmin($data);
    }

    
    public function apartment_item_edit_save()
    {
        $this->form_validation->set_rules('item_quantity', 'Quantity', 'required');
        
        if ($this->form_validation->run($this) == FALSE) {
            $this->apartment_item_edit($this->input->post("id"));
        }
        else
        {
            $this->stock_model->update_apartment_item();
            redirectAlert("stock/apartment_item_list",lang('save_success'));
        }
    }
    
    public function apartment_item_delete($id)
    {
        $this->db->where("id",$id);
        $this->db->delete("stock_apartment");
        redirectAlert("stock/apartment_item_list",lang('delete_success'));
    }
    
    public function get_room_dropdown() {
        $apartment_id = $this->input->post('apartment_id');

        echo "<option value='0' selected>" . 'Common Area' . "</option>";

        if ($apartment_id) {
            $this->load->model('apartment/apartment_model');
            $room_list = $this->apartment_model->get_rooms_in_apartment($apartment_id);

            if ($room_list) {

                foreach ($room_list as $room) {
                    $room_type = $room['room_type'] == 1 ? ' (Single)' : ' (Double)';
                    //echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - " . $room_type . "</option>";
                    echo "<option value='" . $room['id'] . "'>" . $room['id'] . $room_type."</option>";
                }
            }
        }
    }


}

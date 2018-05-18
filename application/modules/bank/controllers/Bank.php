<?php

class Bank extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('bank_model');
        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {

    }

    public function bmlist() { //bmlist = bank movement list
        $data = array();
        $data['body']['movements'] = $this->bank_model->select_all_asc();
        $data['header']['title'] = "Bank Movement List";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_movement_list";
        makeTemplateAdmin($data);
    }

    public function bma() { //bma=bank movement add
        $data = array();
        $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers","name");
        $data['body']['tenants'] = $this->cm->select_all_where_asc("user","type","5","name");
        $data['body']['owners'] = $this->cm->select_all_where_asc("user","type","6","name");
        $data['header']['title'] = "Bank Movement Add";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_movement_add";
        makeTemplateAdmin($data);
    }

    public function bma_save()
    {
        $this->form_validation->set_rules('movement_date', 'Date', 'required');
        $this->form_validation->set_rules('unpaid_cost_id', 'Unpaid Cost', 'required');

        if($this->input->post("tenant_or_owner") == "1")
        {
            $this->form_validation->set_rules('tenant_user_id', 'Occupant', 'required');
        }
        else if($this->input->post("tenant_or_owner") == "2")
        {
            $this->form_validation->set_rules('owner_user_id', 'Owner', 'required');
        }
        else if($this->input->post("tenant_or_owner") == "3")
        {
            $this->form_validation->set_rules('supplier_user_id', 'Supplier', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->bma();
        }
        else{

            $this->bank_model->save_bank_movement();
            if($this->input->post('tenant_or_owner') == "3" && $this->input->post("unpaid_cost_id"))
            {
                $data = array(
                    "payment_status" => 1,
                    "payment_date" => sqldate($this->input->post("movement_date"), "-", "d-m-Y")
                );
                $this->cm->update('general_cost', $data, 'gc_id', $this->input->post("unpaid_cost_id"));


            }
            $costData = array(
                "payment_status" => 1,
                "payment_status_update_date" => sqldate($this->input->post("movement_date"), "-", "d-m-Y")
            );
            $this->cm->update('cost', $costData, 'id', $this->input->post("unpaid_cost_id"));
            redirectAlert("bank/bmlist",lang('save_success'));
        }
    }

    public function bma_delete($id)
    {
        $deleted = $this->cm->delete("bank_movement", "id", $id);
        if($deleted)
        {
            $exist = $this->cm->exist_or_not("general_cost", "bm_id", $id);
            if($exist)
            {
                $data = array(
                    "payment_status" => 0,
                    "payment_date" => "0000-00-00 00:00:00",
                    "bm_id" => 0
                );

                $this->cm->update("general_cost", $data, "bm_id", $id);
            }
            redirectAlert("bank/bmlist",lang('delete_success'));
        }

    }

    public function item_delete($item_id)
    {
        $exist1 = $this->cm->exist_or_not("stock_external", "item_id", $item_id);
        $exist2 = $this->cm->exist_or_not("stock_apartment", "item_id", $item_id);

        if($exist1 || $exist2){
            redirectAlert("stock/item_list","Item is in use. Can't be deleted");
        }
        else{
            $this->db->where("item_id",$item_id);
            $this->db->delete("stock_item");
            redirectAlert("stock/item_list",lang('delete_success'));
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



    public function apartment_item_edit($id) {
        $data = array();
        $data['body']['details'] = $this->cm->select_single_row("stock_apartment", "id", $id);
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        $data['body']['items'] = $this->cm->select_all_asc("stock_item","item_name");
        $data['header']['title'] = "Property Item Edit";
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

    /*
    public function ledger_entry() {
        ini_set('max_execution_time', 50000);
        ini_set('memory_limit', '128M');
        $flag = true;
        $file = "codes.csv";
        $handle = fopen($file, "r");
        //$result = array();

        while ($csv_data = fgetcsv($handle, 1000, ",")) {
            if ($flag) {
                $flag = false;
                continue;
            }

            $data = array();
            $data['nominal_code'] = $csv_data[0];
            $data['ledger_name'] = $csv_data[1];
            $data['category'] = $csv_data[2];
            $this->db->insert('ledger',$data);
        }

        echo "Insertion Completed!";
    }
    */

    public function bank_file()
    {
        $data = array();
        $data['header']['title'] = "Load Bank File";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_file";
        makeTemplateAdmin($data);
    }

    public function file_upload()
    {
        $response = uploadFile("myfile","","bank_temp/");
        echo json_encode($response);
    }

    public function file_info()
    {
        ini_set('max_execution_time', 50000);
        ini_set('memory_limit', '128M');
        $flag = true;
        $file = "uploads/bank_temp/".$this->input->post('file_name');
        $handle = fopen($file, "r");

        $result = array();

            while ($csv_data = fgetcsv($handle, 1000, ",")) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $result[] = $csv_data;

            }

            $this->bank_model->get_file_info($result);
            // for($i = 0; $i < count($result); $i++) {
            //   $number =  preg_replace("/[^0-9]/", '', $result[$i][5]);

            // }

            $this->last_bank_file_info();

    }

    public function last_bank_file_info()
    {
        $data = array();
        $data['body']['bank_info'] = $this->cm->select_all_asc('bank_temp','id');
        $data['header']['title'] = "Unmatched Bank File Info";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_file_info";
        makeTemplateAdmin($data);
    }

    public function bma_from_file($id)
    {
        $data = array();
        $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers","name");
        $data['body']['bank_temp'] = $this->cm->select_single_row("bank_temp","id",$id);
        $data['body']['tenants'] = $this->cm->select_all_where_asc("user","type","5","name");
        $data['body']['owners'] = $this->cm->select_all_where_asc("user","type","6","name");
        $data['header']['title'] = "Bank Movement Add";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_movement_add_from_bank_file";
        makeTemplateAdmin($data);
    }

    public function unpaid_cost_by_id()
    {
        $id = $this->input->post('id');
        $user_type = $this->input->post('user_type');

        if($user_type == "1")
        {
            $this->db->where('(revenue_amount != "" or revenue_amount != "0.00")');
            $unpaid_cost = $this->cm->select_all_with_2_where("cost", "tenant_user_id", $id, "payment_status", "0");
        }
        else if($user_type == "2")
        {
            #$this->db->where('(revenue_amount != "" or revenue_amount != "0.00")');
            $unpaid_cost = $this->cm->select_all_with_2_where("cost", "owner_user_id", $id, "payment_status", "0");
        }
        else if($user_type == "3")
        {
            $unpaid_cost = $this->cm->select_all_with_2_where("cost", "supplier_id", $id, "payment_status", "0");
        }

        echo json_encode($unpaid_cost);
    }

    public function bma_edit($id)
    {
        $data = array();
        $bma_edit = $this->cm->select_single_row("bank_movement", "id", $id);
        if($bma_edit['tenant_id'])
        {
             $data['body']['unpaid_cost'] = $this->cm->select_all_with_2_where("cost", "tenant_user_id", $bma_edit['tenant_id'], "payment_status", "0");
        }
        else if($bma_edit['owner_id'])
        {
            $data['body']['unpaid_cost'] = $this->cm->select_all_with_2_where("cost", "tenant_user_id", $bma_edit['owner_id'], "payment_status", "0");
        }
        else if($bma_edit['supplier_id'])
        {
            $data['body']['unpaid_cost'] = $this->cm->select_all_with_2_where("cost", "supplier_id", $bma_edit['supplier_id'], "payment_status", "0");
        }
        $data['body']['bma_edit'] = $bma_edit;
        $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers","name");
        $data['body']['tenants'] = $this->cm->select_all_where_asc("user","type","5","name");
        $data['body']['owners'] = $this->cm->select_all_where_asc("user","type","6","name");

        $data['header']['title'] = "Bank Movement Edit";
        $data['header']['menu_base'] = "bank";
        $data['body']['page'] = "bank_movement_edit";
        makeTemplateAdmin($data);
    }

    public function bma_edit_save()
    {
        $this->form_validation->set_rules('movement_date', 'Date', 'required');
        $this->form_validation->set_rules('unpaid_cost_id', 'Unpaid Cost', 'required');

        if($this->input->post("tenant_or_owner") == "1")
        {
            $this->form_validation->set_rules('tenant_user_id', 'Occupant', 'required');
        }
        else if($this->input->post("tenant_or_owner") == "2")
        {
            $this->form_validation->set_rules('owner_user_id', 'Owner', 'required');
        }
        else if($this->input->post("tenant_or_owner") == "3")
        {
            $this->form_validation->set_rules('supplier_user_id', 'Supplier', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->bma();
        }
        else{
            $this->bank_model->update_bank_movement();
            if($this->input->post('tenant_or_owner') == "3" && $this->input->post("unpaid_cost_id"))
            {
                $data = array(
                    "payment_status" => 1,
                    "payment_date" => sqldate($this->input->post("movement_date"), "-", "d-m-Y")
                );
                $this->cm->update('general_cost', $data, 'gc_id', $this->input->post("unpaid_cost_id"));
            }
            $costData = array(
                "payment_status" => 1,
                "payment_status_update_date" => sqldate($this->input->post("movement_date"), "-", "d-m-Y")
            );
            $this->cm->update('cost', $costData, 'id', $this->input->post("unpaid_cost_id"));
            redirectAlert("bank/bmlist",lang('save_success'));
        }
    }

}

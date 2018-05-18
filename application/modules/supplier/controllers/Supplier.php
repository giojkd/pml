<?php

class Supplier extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('supplier_model', 'supplier');
        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */

    public function index()
    {
        $data['header']['title'] = 'Supplier List';
        $data['body']['page'] = "list";
        $data['body']['suppliers'] = $this->supplier->get_all_supplier();
        makeTemplateAdmin($data);
    }

    public function create()
    {
        $data['header']['title'] = 'Add Supplier';
        $data['body']['page'] = "add";
        $data['body']['countries'] = getAllCounty();
        //$data['header']['menu_base'] = "user_manager";
        makeTemplateAdmin($data);
    }

    public function insert()
    {
        $this->form_validation->set_rules('company', 'Company', 'required');
        //$this->form_validation->set_rules('vat_no', 'Vat no.', 'required');
        //$this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('county_code', 'County', 'required');
        //$this->form_validation->set_rules('city_code', 'City', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else
        {
            $data =array();
            $data['company'] = $this->input->post('company');
            $data['name'] = $this->input->post('name');
            $data['surname'] = $this->input->post('surname');
            $data['vat_no'] = $this->input->post('vat_no');
            $data['address'] = $this->input->post('address');
            $data['county_code'] = $this->input->post('county_code');
            $data['city_code'] = $this->input->post('city_code');
            $data['notes'] = $this->input->post('notes');
            $data['supplier_telephone'] = $this->input->post('supplier_telephone');
            $data['supplier_email'] = $this->input->post('supplier_email');
            $data['supplier_type'] = $this->input->post('supplier_type');
            $data['create_date'] = date('Y-m-d H:i:s');

            $this->supplier->store_supplier($data);
            redirectAlert("supplier",lang('save_success'));
        }
    }

     public function get_city_dropdown() {
        $county_code = $this->input->post('county_code');
        $cities = $this->supplier->get_city_by_county($county_code);
        if ($cities) {
            echo "<option value=''>---</option>";
            foreach ($cities as $city) {
                echo "<option value='" . $city['city_code'] . "'>" . strtoupper($city['city_name']) . "</option>";
            }
        }
    }

    public function edit($id)
    {
        $supplier_info = $this->cm->select_single_row("suppliers", "id", $id);
        $county_code = $supplier_info['county_code'];

        $data['header']['title'] = 'Supplier Edit';
        $data['body']['page'] = "edit";
        $data['body']['countries'] = getAllCounty();
        $data['body']['supplier'] =  $supplier_info;
        $data['body']['cities'] = $this->cm->select_all_where("ini_cities", "county_code", $county_code);
        //$data['header']['menu_base'] = "user_manager";
        makeTemplateAdmin($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('company', 'Company', 'required');
        //$this->form_validation->set_rules('vat_no', 'Vat no.', 'required');
        //$this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('county_code', 'County', 'required');
        //$this->form_validation->set_rules('city_code', 'City', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else
        {
            $data =array();
            $data['company'] = $this->input->post('company');
            $data['name'] = $this->input->post('name');
            $data['surname'] = $this->input->post('surname');
            $data['vat_no'] = $this->input->post('vat_no');
            $data['address'] = $this->input->post('address');
            $data['county_code'] = $this->input->post('county_code');
            $data['city_code'] = $this->input->post('city_code');
            $data['notes'] = $this->input->post('notes');
            $data['supplier_telephone'] = $this->input->post('supplier_telephone');
            $data['supplier_email'] = $this->input->post('supplier_email');
            $data['supplier_type'] = $this->input->post('supplier_type');
            $data['update_date'] = date('Y-m-d H:i:s');

            $this->supplier->update_supplier($data);
            redirectAlert("supplier",lang('save_success'));
        }
    }

    public function delete($id)
    {
        $this->db->where("id",$id);
        $this->db->delete("suppliers");
        redirectAlert("supplier",lang('delete_success'));
    }


}

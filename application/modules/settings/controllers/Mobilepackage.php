<?php

class MobilePackage extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        redirect("settings/mobilepackage/all");
    }


    public function all() {
        $data = array();
        $data['body']['packages'] = $this->cm->select_all_asc("mobile_package","assigned_to");
        $data['header']['title'] = "Mobile Phone Packages";
        $data['header']['menu_base'] = "mobile";
        $data['body']['page'] = "mobile_package_list";
        makeTemplateAdmin($data);
    }

    public function add() {
        $data = array();
        $data['header']['title'] = "Mobile Package Add";
        $data['header']['menu_base'] = "mobile";
        $data['body']['page'] = "mobile_package_add";
        makeTemplateAdmin($data);
    }


    public function add_save()
    {
        $this->form_validation->set_rules('assigned_to', 'Assigned To', 'required');

        if($this->form_validation->run($this) == FALSE) {
            $this->add();
        }
        else{
            $data = array();
            $data["assigned_to"] = $this->input->post("assigned_to");
            $data["phone_number"] = $this->input->post("phone_number");
            $data["plan_name"] = $this->input->post("plan_name");
            $data["mobile_company"] = $this->input->post("mobile_company");
            $data["plan_description"] = $this->input->post("plan_description");
            $data["plan_cost"] = $this->input->post("plan_cost");


/*$data["included_mins_in_uk"] = $this->input->post("included_mins_in_uk");
            $data["included_mins_uk_to_eu"] = $this->input->post("included_mins_uk_to_eu");
            $data["included_mins_eu_to_uk"] = $this->input->post("included_mins_eu_to_uk");
            $data["included_mins_uk_to_world"] = $this->input->post("included_mins_uk_to_world");
            $data["included_mins_world_to_uk"] = $this->input->post("included_mins_world_to_uk");
            $data["included_sms_in_uk"] = $this->input->post("included_sms_in_uk");
            $data["included_sms_uk_to_eu"] = $this->input->post("included_sms_uk_to_eu");
            $data["included_sms_eu_to_uk"] = $this->input->post("included_sms_eu_to_uk");
            $data["included_sms_uk_to_world"] = $this->input->post("included_sms_uk_to_world");
            $data["included_sms_world_to_uk"] = $this->input->post("included_sms_world_to_uk");
            $data["included_data_in_uk"] = $this->input->post("included_data_in_uk");
            $data["included_data_in_eu"] = $this->input->post("included_data_in_eu");
            $data["included_data_in_world"] = $this->input->post("included_data_in_world");*/

            $data["insert_date"] = date("Y-m-d");

            $this->cm->insert("mobile_package",$data);
            redirectAlert("settings/mobilepackage/all",lang('save_success'));
        }
    }


    public function edit($id) {
        $data = array();
        $data['header']['title'] = "Mobile Package";
        $data['header']['menu_base'] = "mobile";
        $data['body']['package_info'] = $this->cm->select_single_row("mobile_package","id",$id);
        $data['body']['page'] = "mobile_package_edit";
        makeTemplateAdmin($data);
    }


    public function edit_save()
    {
        $this->form_validation->set_rules('assigned_to', 'Assigned To', 'required');

        if($this->form_validation->run($this) == FALSE) {
            $this->edit($this->input->post("id"));
        }
        else{
            $data = array();
            $data["assigned_to"] = $this->input->post("assigned_to");
            $data["phone_number"] = $this->input->post("phone_number");
            $data["plan_name"] = $this->input->post("plan_name");
            $data["mobile_company"] = $this->input->post("mobile_company");
            $data["plan_description"] = $this->input->post("plan_description");
            $data["plan_cost"] = $this->input->post("plan_cost");

            /*$data["included_mins_in_uk"] = $this->input->post("included_mins_in_uk");
            $data["included_mins_uk_to_eu"] = $this->input->post("included_mins_uk_to_eu");
            $data["included_mins_eu_to_uk"] = $this->input->post("included_mins_eu_to_uk");
            $data["included_mins_uk_to_world"] = $this->input->post("included_mins_uk_to_world");
            $data["included_mins_world_to_uk"] = $this->input->post("included_mins_world_to_uk");
            $data["included_sms_in_uk"] = $this->input->post("included_sms_in_uk");
            $data["included_sms_uk_to_eu"] = $this->input->post("included_sms_uk_to_eu");
            $data["included_sms_eu_to_uk"] = $this->input->post("included_sms_eu_to_uk");
            $data["included_sms_uk_to_world"] = $this->input->post("included_sms_uk_to_world");
            $data["included_sms_world_to_uk"] = $this->input->post("included_sms_world_to_uk");
            $data["included_data_in_uk"] = $this->input->post("included_data_in_uk");
            $data["included_data_in_eu"] = $this->input->post("included_data_in_eu");
            $data["included_data_in_world"] = $this->input->post("included_data_in_world");*/

            $this->db->where("id",$this->input->post("id"));
            $this->db->update("mobile_package",$data);
            redirectAlert("settings/mobilepackage/all",lang('save_success'));
        }
    }


    public function delete($id)
    {
        $this->db->where("id",$id);
        $this->db->delete("mobile_package");
        redirectAlert("settings/mobilepackage/all",lang('delete_success'));
    }


}

<?php

class WifiRouter extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        redirect("settings/wifirouter/router_list");
    }
    
    
    public function router_list() {
        $data = array();
        $data['body']['routers'] = $this->cm->select_all_asc("wifi_router_log","router_name");
        $data['header']['title'] = "Router List";
        $data['header']['menu_base'] = "router";
        $data['body']['page'] = "router_list";
        makeTemplateAdmin($data);
    }
    
    public function router_add() {
        $data = array();
        $data['header']['title'] = "Router Add";
        $data['header']['menu_base'] = "router";
        $data['body']['page'] = "router_add";
        makeTemplateAdmin($data);
    }
    
    
    public function router_add_save()
    {
        $this->form_validation->set_rules('router_name', 'Router Name', 'required');
        
        if($this->form_validation->run($this) == FALSE) {
            $this->router_add();
        }
        else{
            $data = array();
            $data["router_name"] = $this->input->post("router_name");
            $data["router_location"] = $this->input->post("router_location");
            $data["insert_date"] = sqldate($this->input->post("insert_date"),"-","d-m-Y");
            
            $this->cm->insert("wifi_router_log",$data);
            redirectAlert("settings/wifirouter/router_list",lang('save_success'));
        }
    }
    
    
    public function router_edit($id) {
        $data = array();
        $data['header']['title'] = "Router Edit";
        $data['header']['menu_base'] = "router";
        $data['body']['router_info'] = $this->cm->select_single_row("wifi_router_log","id",$id);
        $data['body']['page'] = "router_edit";
        makeTemplateAdmin($data);
    }
    
    
    public function router_edit_save()
    {
        $this->form_validation->set_rules('router_name', 'Router Name', 'required');
        
        if($this->form_validation->run($this) == FALSE) {
            $this->router_edit($this->input->post("id"));
        }
        else{
            $data = array();
            $data["router_name"] = $this->input->post("router_name");
            $data["router_location"] = $this->input->post("router_location");
            $data["insert_date"] = sqldate($this->input->post("insert_date"),"-","d-m-Y");
            
            $this->db->where("id",$this->input->post("id"));
            $this->db->update("wifi_router_log",$data);
            redirectAlert("settings/wifirouter/router_list",lang('save_success'));
        }
    }
    
    
    public function router_delete($id)
    {
        $this->db->where("id",$id);
        $this->db->delete("wifi_router_log");
        redirectAlert("settings/wifirouter/router_list",lang('delete_success'));
    }
    

}

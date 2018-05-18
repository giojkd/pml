<?php

class Settings extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('settings_model', 'settings');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
	public function index() {}
        
    public function email_settings() {
        $data['body']['settings'] = $this->settings->get_settings();
        $data['header']['title'] = lang('email_setting');
        $data['body']['page'] = "email_settings";
        makeTemplateAdmin($data);
    }

    public function site_settings() {
        $data['body']['settings'] = $this->settings->get_settings();
        $data['header']['title'] = lang('site_setting');
        $data['body']['page'] = "site_settings";
        makeTemplateAdmin($data);
    }    
    
    
    public function update($settings="") {
        if ($this->settings->update_settings($settings) > 0) {
            redirectAlert("settings/$settings",lang('save_success'));
        } else {
            redirectAlert("settings/$settings",lang('save_fail'));
        }
    }

}

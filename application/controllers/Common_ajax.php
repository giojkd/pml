<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_ajax extends MX_Controller {

    function __construct() {
        parent :: __construct();
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    public function index() {
        
    }

    public function get_country_dropdown() {
        $country_id = $this->input->post('country_id');
        $dropdown = "<option value=''>" . lang('select_country') . "</option>";

        $countries = $this->cm->getCountry();
        if ($countries) {
            foreach ($countries as $country) {
                $dropdown .= "<option value='" . $country['country_id'] . "'>" . $country['country_shortName'] . "</option>";
            }
        }

        echo $dropdown;
    }

    public function get_city_dropdown() {
        $country_id = $this->input->post('country_id');
        $dropdown = "<option value=''>Choose a City</option>";
        if ($country_id) {
            $cities = $this->cm->get_city_by_country($country_id, true);
            if ($cities) {
                foreach ($cities as $city) {
                    $dropdown .= "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . "</option>";
                }
            } else {
                $dropdown .= "<option value=''>No Cities Found</option>";
            }
        }
        echo $dropdown;
    }

    public function get_country_array() {
        $countries = $this->cm->get_country_list();
        $array = array();
        foreach ($countries as $country) {
            $array[] = array("value" => $country['country_shortName'], "text" => $country['country_shortName']);
        }

        echo json_encode($array);
    }

    public function change_currency($currency) {
        $userdata = $this->session->userdata('userdata');
        $user_id = $userdata['user_id'];

        if ($user_id) {
            if ($userdata["is_admin"]) {
                $this->db->where('admin_id', $user_id)->update('admin', array("admin_currencyCode" => $currency));
            } else {
                $this->db->where('user_id', $user_id)->update('user', array("user_currency" => $currency));
            }
        } else {
            //echo "ase5";
            setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/');
            //$this->input->set_cookie(array('name'=>'currency','value'=>$currency));
        }
    }

    public function get_coordinates_from_address() {
        $address = $this->input->post('address');
        echo json_encode(getGeocode($address));
    }

    public function assign_request() {
        $request_id = $this->input->post('request_id');
        $user_id = $this->input->post('user_id');
        $updated = $this->cm->update('tenant_request', array('assigned_to' => $user_id), 'id', $request_id);
        echo 1;
    }

}

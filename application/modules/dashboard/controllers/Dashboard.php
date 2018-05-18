<?php

/**
 * This controller will handle dasboard and the default controller after
 * successful login
 * @author Md. Faisal Alam
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    /**
     * This method is used to get load dashboard default page
     * @author Ashraful Islam Tushar
     */
    public function index() {
        $user_type = getUserdata('user_type');
        if ($user_type == 'tenant') {
            modules::load('tenant')->index();
        } elseif ($user_type == 'employer') {
            modules::load('employer')->index();
        }elseif ($user_type == 'external_maintainer') {
            modules::load('employer')->index();
        } else {
            $data['body']['page'] = 'dashboard';
            $data['header']['page_title'] = lang('dashboard');
            
            makeTemplateAdmin($data);
        }
    }

    public function payment_alert_list(){
        $user_type = getUserdata('user_type');
        if($user_type=='backend_user'){
            $data['header']['page_title'] ='Due payment alert';
            $data['body']['page'] = 'payment_alert_list';
            $data['body']['alert_list'] =get_delaya_payments_alert();

            makeTemplateAdmin($data);
        }
    }

    public function apartments_lat_lang(){
        $apartments_lat_lng=$this->db->select('latitude,longitude,id')->get('apartment_detail')->result_array();
        foreach($apartments_lat_lng as $key=>$val){
            $apartments_lat_lng[$key]['requests']=count($this->dashboard_model->tenant_requests_by_apartment($apartments_lat_lng[$key]['id']));
        }
        echo json_encode($apartments_lat_lng);
    }

    public function tenant_requests(){
        $apartment_id=$this->input->post('apartment_id');
        
        echo json_encode($this->dashboard_model->tenant_requests_by_apartment1($apartment_id));
    }

    public function apartment_rooms_details(){
        $apartment_id=$this->input->post('apartment_id');
        echo json_encode($this->dashboard_model->get_apartment_room_details($apartment_id));
    }

    public function request_view() {
        if($this->input->post('apartment_id') && $this->input->post('room_id')) {
            $this->load->model('tenant/tenant_model', 'tenant');
            $user = getUserdata();
            if ($user['user_type'] == 'tenant') {
                $user_id = $user['user_id'];
            } else {
                $user_id = 0;
            }
            $this->db->where('apartment_id', $this->input->post('apartment_id'));
            $this->db->where('room_id', $this->input->post('room_id'));
            $all_requests = $this->tenant->get_all_requests($user_id);

            if($all_requests) {
                echo json_encode($all_requests);
            } else {
                echo json_encode(0);
            }
        }
    }
}

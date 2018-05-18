<?php

class Employer extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('employer_model', 'employer');
        //$this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $user = getUserdata();
        if ($user['user_type'] == 'employer') {
            $user_id = $user['user_id'];
        } else {
            $user_id = getUserdata("user_id");
        }
        $all_requests = $this->employer->get_all_requests($user_id);
        $requests = array();
        foreach ($all_requests as $key => $value) {
            $value['image'] = $this->employer->get_all('request_feedback_image', '*', array('request_id' => $value['id']));
            $requests[] = $value;
        }
 
        $data['body']['requests'] = $requests;
        $data['body']['user'] = $user;
        $data['body']['request_ids'] = array_column($all_requests, 'id');
        $data['header']['title'] = 'My Requests';
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "employer/index";
        makeTemplateAdmin($data);
    }

    public function requests() {
        $this->index();
    }

    public function request_feedback($request_id) {
        modules::load('tenant')->request_feedback($request_id);
    }
    
    public function feedback_image_upload($req_id)
    {
        $response = uploadImage("myfile");
        $file_name = $response['upload_data']['file_name'];
        $orig_name = $response['upload_data']['orig_name'];
        $this->employer->insert_feedback_images($file_name, $orig_name, $req_id);
        echo json_encode($response);
    }
    
    public function delete_temp_file(){
        $file_name = $this->input->post('file_name');
        unlink('./uploads/feedback_temp/'.$file_name);
        echo 'ok';
    }
    
     public function change_request_status($request_id) {

            change_column_status($request_id, 'tenant_request', 'status', 'id', 'employer');
    }

}

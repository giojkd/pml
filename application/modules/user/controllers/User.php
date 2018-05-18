<?php

class User extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('user_model', 'user');
        //$this->load->library('form_validation');

    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $data['body']['users'] = $this->user->get_admin();
        $data['header']['title'] = lang('user_list');
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "index";
        makeTemplateAdmin($data);
    }

    public function add($preSelectedUserType = 0) {
        $data['header']['title'] = lang('user_add');
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "add";
        $data['body']['countries'] = getAllCountry();
        $data['body']['preSelectedUserType'] = $preSelectedUserType;
        makeTemplateAdmin($data);
    }

    public function add_tenant(){
        $userTypeCode = user_type_code('tenant');
        $this->add($userTypeCode);
    }

    public function add_owner(){
        $userTypeCode = user_type_code('owner');
        $this->add($userTypeCode);
    }

    public function addsave() {

        $rules = array(
            array(
                'field' => 'name',
                'label' => lang('label_name'),
                'rules' => 'required'
            ),
            array(
                'field' => 'family_name',
                'label' => 'Family Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => lang('label_email'),
                'rules' => 'required|valid_email|is_unique[user.email]'
            ),
            array(
                'field' => 'password',
                'label' => lang('label_password'),
                'rules' => 'trim|required|min_length[5]|max_length[12]'
            ),
            array(
                'field' => 'password_confirm',
                'label' => lang('password_confirm'),
                'rules' => 'trim|required|matches[password]'
            ),
            array(
                'field' => 'type',
                'label' => 'User Type',
                'rules' => 'required'
            )
        );

        if (user_type_text($this->input->post('type')) == 'tenant') {
            $rules[] = array(
                'field' => 'birthday',
                'label' => 'Date of Birth',
                'rules' => 'required'
            );
            $rules[] = array(
                'field' => 'country_id',
                'label' => 'Country',
                'rules' => 'required'
            );
            $rules[] = array(
                'field' => 'city_id',
                'label' => 'City',
                'rules' => 'required'
            );
             $rules[] = array(
                'field' => 'tenant_address',
                'label' => 'Occupant Adddress',
                'rules' => 'required'
            );
            /*$rules[] = array(
                'field' => 'document_type',
                'label' => 'Document Type',
                'rules' => 'required'
            );*/
            $rules[] = array(
                'field' => 'document_no',
                'label' => 'Document No.',
                'rules' => 'required'
            );
        } else if (user_type_text($this->input->post('type')) == 'external_maintainer') {
            $rules[] = array(
                'field' => 'company_name',
                'label' => 'lang:company_name',
                'rules' => 'required'
            );
        } else if (user_type_text($this->input->post('type')) == 'owner') {
//            $rules[] = array(
//                'field' => 'company_name',
//                'label' => 'lang:company_name',
//                'rules' => 'required'
//            );
//            $rules[] = array(
//                'field' => 'agent_name',
//                'label' => 'Agent Name',
//                'rules' => 'required'
//            );
//            $rules[] = array(
//                'field' => 'agent_phone',
//                'label' => 'Agent Phone',
//                'rules' => 'required'
//            );
//             $rules[] = array(
//                'field' => 'agent_email',
//                'label' => 'Agent Email',
//                'rules' => 'required'
//            );
        }



        $this->form_validation->set_rules($rules);

        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        } else {
            $is_active = $this->input->post('status') == 'on' ? 1 : 0;
            $data = array(
                'name' => $this->input->post('name'),
                'family_name' => $this->input->post('family_name'),
                'phone_no' => $this->input->post('phone_no'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'type' => $this->input->post('type'),
                'status' => $is_active,
                'create_date' => date('Y-m-d H:i:s')
            );
            if (user_type_text($this->input->post('type')) == 'tenant') {
                $data['birthday'] = date('Y-m-d H:i:s',  strtotime($this->input->post('birthday')));
                $data['country_id'] = $this->input->post('country_id');
                $data['city_id'] = $this->input->post('city_id');
                $data['tenant_address'] = $this->input->post('tenant_address');
                if($this->input->post('tenant_post_address') == ""){
                     $data['tenant_post_address'] = $this->input->post('tenant_address');
                }
                else{
                     $data['tenant_post_address'] = $this->input->post('tenant_post_address');
                }
                /*$data['document_type'] = $this->input->post('document_type');
                $data['tenant_doc_name'] = $this->input->post('file_name');
                $data['tenant_doc_orig_name'] = $this->input->post('orig_name');*/

                $data['work_reference_file'] = $this->input->post('work_file_name');
                $data['education_program_file'] = $this->input->post('education_file_name');
                $data['passport_file'] = $this->input->post('passport_file_name');

                $data['document_no'] = $this->input->post('document_no');
                $data['national_ins_nr']=$this->input->post('national_ins_nr');
            } else if (user_type_text($this->input->post('type')) == 'external_maintainer') {
                $data['company_name'] = $this->input->post('company_name');
            } else if(user_type_text($this->input->post('type')) == 'owner')
            {
                $data['company_name'] = $this->input->post('company_name');
                $data['owner_agent_name'] = $this->input->post('agent_name');
                $data['owner_agent_phone'] = $this->input->post('agent_phone');
                $data['owner_agent_email'] = $this->input->post('agent_email');
            }
            $insert = $this->user->insert($data);
            if ($insert) {
                $response = array(
                    'status' => 1,
                    'message' => lang('save_success'),
                    'redirectto' => base_url_tr('user'),
                );
                if($this->input->post('return_user')){
                    $data['id'] = $insert;
                    $response['user'] = $data;
                }
            } else {
                $response = array(
                    'status' => 0,
                    'message' => lang('save_fail'),
                );
            }
        }
        echo json_encode($response);
    }

    public function edit($id) {
        if ($id) {
            if(getUserdata('user_type')!='admin'){
                $user = $this->user->get(getUserdata('user_id'));
            }
            else{
                $user = $this->user->get($id);
            }
            $data['header']['title'] = lang('user_edit');
            $data['header']['menu_base'] = "user_manager";
            $data['body']['page'] = "edit";
            $data['body']['user'] = $user;
            $data['body']['countries'] = getAllCountry();
            $data['body']['cities'] = $this->cm->get_city_by_country($user['country_id']);
            makeTemplateAdmin($data);
        } else {
            redirect_tr('user');
        }
    }

    public function editsave() {

        $rules = array(
            array(
                'field' => 'name',
                'label' => lang('label_name'),
                'rules' => 'required'
            ),
            array(
                'field' => 'family_name',
                'label' => 'Family Name',
                'rules' => 'required'
            )
        );

        if ($this->input->post('password')) {
            $rules[] = array(
                'field' => 'password',
                'label' => lang('label_password'),
                'rules' => 'trim|required|min_length[5]|max_length[12]'
            );
            $rules[] = array(
                'field' => 'password_confirm',
                'label' => lang('password_confirm'),
                'rules' => 'trim|required|matches[password]'
            );
        }

        if (user_type_text($this->input->post('type')) == 'admin') {
             $rules[] = array(
                'field' => 'type',
                'label' => 'User Type',
                'rules' => 'required'
            );
        }

        if (user_type_text($this->input->post('type')) == 'tenant') {
            $rules[] = array(
                'field' => 'birthday',
                'label' => 'Date of Birth',
                'rules' => 'required'
            );
            $rules[] = array(
                'field' => 'country_id',
                'label' => 'Country',
                'rules' => 'required'
            );
            $rules[] = array(
                'field' => 'city_id',
                'label' => 'City',
                'rules' => 'required'
            );
            /*$rules[] = array(
                'field' => 'document_type',
                'label' => 'Document Type',
                'rules' => 'required'
            );*/
            $rules[] = array(
                'field' => 'document_no',
                'label' => 'Document No.',
                'rules' => 'required'
            );
        }
        else if (user_type_text($this->input->post('type')) == 'external_maintainer') {
            $rules[] = array(
                'field' => 'company_name',
                'label' => 'lang:company_name',
                'rules' => 'required'
            );
        }
        else if (user_type_text($this->input->post('type')) == 'owner') {
//            $rules[] = array(
//                'field' => 'company_name',
//                'label' => 'lang:company_name',
//                'rules' => 'required'
//            );
//            $rules[] = array(
//                'field' => 'agent_name',
//                'label' => 'Agent Name',
//                'rules' => 'required'
//            );
//            $rules[] = array(
//                'field' => 'agent_phone',
//                'label' => 'Agent Phone',
//                'rules' => 'required'
//            );
//             $rules[] = array(
//                'field' => 'agent_email',
//                'label' => 'Agent Email',
//                'rules' => 'required'
//            );
        }

        $this->form_validation->set_rules($rules);
        $id = $this->input->post('id');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        } else {
            $is_active = $this->input->post('status') == 'on' ? 1 : 0;
            $data = array(
                'name' => $this->input->post('name'),
                'family_name' => $this->input->post('family_name'),
                'phone_no' => $this->input->post('phone_no'),
                'type' => $this->input->post('type'),
                'status' => $is_active,
            );
            if ($this->input->post('password')) {
                $data['password'] = md5($this->input->post('password'));
            }
            if (user_type_text($this->input->post('type')) == 'tenant') {
                $data['birthday'] = date('Y-m-d H:i:s',  strtotime($this->input->post('birthday')));
                $data['country_id'] = $this->input->post('country_id');
                $data['city_id'] = $this->input->post('city_id');
                $data['document_type'] = $this->input->post('document_type');
                $data['document_no'] = $this->input->post('document_no');
                $data['tenant_address'] = $this->input->post('tenant_address');

                if($this->input->post('tenant_post_address') == ""){
                     $data['tenant_post_address'] = $this->input->post('tenant_address');
                }
                else{
                     $data['tenant_post_address'] = $this->input->post('tenant_post_address');
                }
                /*$data['tenant_doc_name'] = $this->input->post('file_name');
                $data['tenant_doc_orig_name'] = $this->input->post('orig_name');*/

                if($this->input->post('work_file_name')) {
                    $data['work_reference_file'] = $this->input->post('work_file_name');
                }
                if($this->input->post('education_file_name')) {
                    $data['education_program_file'] = $this->input->post('education_file_name');
                }
                if($this->input->post('passport_file_name')) {
                    $data['passport_file'] = $this->input->post('passport_file_name');
                }

                $data['national_ins_nr']=$this->input->post('national_ins_nr');

            }
            else if (user_type_text($this->input->post('type')) == 'external_maintainer') {
                $data['company_name'] = $this->input->post('company_name');
            }
            else if(user_type_text($this->input->post('type')) == 'owner')
            {
                $data['company_name'] = $this->input->post('company_name');
                $data['owner_agent_name'] = $this->input->post('agent_name');
                $data['owner_agent_phone'] = $this->input->post('agent_phone');
                $data['owner_agent_email'] = $this->input->post('agent_email');
            }

            $update = $this->user->update($id, $data);
            if ($update) {
                $response = array(
                    'status' => 1,
                    'message' => lang('save_success'),
                    //'redirectto' => base_url_tr('user'),
                );
            } else {
                $response = array(
                    'status' => 0,
                    'message' => lang('save_fail'),
                );
            }
        }
        echo json_encode($response);
    }

    public function delete($id) {
        $delete = $this->user->delete($id);
        if ($delete) {
            redirectAlert("user", lang('delete_success'));
        }
    }

    public function password() {
        $get_all = $this->user->get_all();
        $this->layout->set('page_title', "Admin User");
        $this->layout->set('parent', 'user');
        $this->layout->set('child', 'admin_user');
        $this->layout->set('get_all', $get_all);

        $this->layout->buffer('content', 'user/change_pass');
        $this->layout->render();
        $data['header']['title'] = "User Add";
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "change_pass";
        makeTemplateAdmin($data);
    }

    public function savepassword() {
        $config = array(
            array(
                'field' => 'old_pass',
                'label' => 'Old Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'New Password',
                'rules' => 'trim|required|min_length[5]|xss_clean'
            ),
            array(
                'field' => 're_password',
                'label' => 'Re-New Password',
                'rules' => 'trim|required|min_length[5]|matches[password]|xss_clean'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            $this->password();
        } else {
            $user_id = $this->session->userdata('user_id');
            $user_info = $this->user->get($user_id);
            $old_db_pass = $user_info['password'];

            $this->load->library('crypt');
            $old_password = $this->input->post('old_pass');
            $password = $this->input->post('password');

            if ($this->crypt->check_password($old_db_pass, $old_password)) {
                $psalt = $this->crypt->salt();
                $password = $this->crypt->generate_password($password, $psalt);

                $db_array = array(
                    'password' => $password,
                    'psalt' => $psalt
                );
                if ($this->user->update($user_id, $db_array)) {
                    redirect(base_url() . "sessions/logout");
                }
            } else {
                $this->session->set_flashdata('save_error', msg('Old password wrong', 'error'));
                redirect(site_url() . "user/password");
            }
        }
    }

    /**
     * This method is used to change user status
     * this is used under user module
     * @param $user_id is the user id
     * this method has been loaded from ./helpers/common_helper
     */
    public function change_user_status($user_id) {
        change_column_status($user_id, 'user', 'status', 'id', 'user');
    }

    public function user_file_upload()
    {
        $response = uploadFile("myfile","", "user_file/");
        echo json_encode($response);
    }

    public function tenant(){
        $data['body']['tenants'] = $this->user->get_occupants_list();
        $data['header']['title'] = "Occupant List";
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "tenant_list";
        makeTemplateAdmin($data);
    }

    public function owner()
    {
        $data['body']['users'] = $this->user->get_owner();
        $data['header']['title'] = 'Owner List';
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "owner_list";
        makeTemplateAdmin($data);
    }

}

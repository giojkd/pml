<?php

class Tenant extends MX_Controller {

    function __construct() {
        parent::__construct();

        // load required models
        $this->load->model('tenant_model', 'tenant');
        //$this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $user = getUserdata();
        if ($user['user_type'] == 'tenant') {
            $user_id = $user['user_id'];
        } else {
            $user_id = 0;
        }

        $all_requests = $this->tenant->get_all_requests($user_id);
        $data['body']['requests'] = $all_requests;
        $data['body']['user'] = $user;
        $data['body']['request_ids'] = array_column($all_requests, 'id');
        if ($user['user_type'] == 'backend_user') {
            $employer_external_maintainer = $this->cm->select_all_with_2_or_where('user', 'type', user_type_code('employer'), 'type', user_type_code('external_maintainer'));
            if ($employer_external_maintainer) {
                $employer_external_maintainer = array_column($employer_external_maintainer, NULL, 'id');
            }
            //print_r($employer_external_maintainer);die;
            $data['body']['employer_external_maintainer'] = $employer_external_maintainer;
        }
        $data['header']['title'] = 'My Requests';
        $data['header']['menu_base'] = "user_manager";
        $data['body']['page'] = "tenant/index";
        makeTemplateAdmin($data);
    }

    public function requests() {
        $this->index();
    }

    public function add_request() {
        $data['header']['title'] = 'Add Request';
        $data['body']['page'] = "add_request";
        $user = getUserdata();
        //if ($user['user_type'] == 'backend_user') {
            $data['body']['tenants'] = $this->cm->select_all_where('user', 'type', user_type_code('tenant'));
        //}
        $data['body']['user_type'] = $user['user_type'];
        $data['body']['page'] = "add_request";
        makeTemplateAdmin($data);
    }

    public function add_requestsave() {

        $rules = array(
            array(
                'field' => 'description',
                'label' => lang('description'),
                'rules' => 'required'
            ),
        );

        $this->form_validation->set_rules($rules);

        $response = array();
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        } else {
            if ($this->input->post('tenant_id')) {
                $user_id = $this->input->post('tenant_id');
            } else {
                $user_id = getUserdata('user_id');
            }
            $booking_info = $this->cm->select_single_row('apartment_booked_list', 'user_id', $user_id);
            if (!empty($booking_info)) {
                $data = array(
                    'user_id' => $user_id,
                    'request_for' => $this->input->post('request_for'),
                    'description' => $this->input->post('description'),
                    'room_id' => $booking_info['room_id'],
                    'apartment_id' => $booking_info['apartment_id'],
                    'create_date' => date('Y-m-d H:i:s'),
                );
                $insert = $this->cm->insert('tenant_request', $data);
                if ($insert) {
                    $this->session->set_flashdata('alertmsg', lang('save_success'));
                    $this->session->set_flashdata('alertType', 'success');
                    $response = array(
                        'status' => 1,
                        'message' => lang('save_success'),
                        'redirectto' => base_url_tr('tenant'),
                    );
                } else {
                    $response = array(
                        'status' => 0,
                        'message' => lang('save_fail'),
                    );
                }
            } else {
                $this->session->set_flashdata('alertmsg', 'No Booking Data Found.');
                $this->session->set_flashdata('alertType', 'error');
                $response = array(
                    'status' => 0,
                    'message' => 'No Booking Data Found.',
                    'redirectto' => base_url_tr('tenant'),
                );
            }
        }
        echo json_encode($response);
    }

    public function edit_request($id) {
        if ($id) {
            $request = $this->cm->select_single_row('tenant_request', 'id', $id);
            if (!$request['assigned_to']) {
                $data['header']['title'] = 'Edit Request';
                $data['body']['page'] = "edit_request";
                $data['body']['request'] = $request;
                $user = getUserdata();
                //if ($user['user_type'] == 'backend_user') {
                    $data['body']['tenants'] = $this->cm->select_all_where('user', 'type', user_type_code('tenant'));
                //}
                $data['body']['user_type'] = $user['user_type'];
                makeTemplateAdmin($data);
            } else {
                $this->session->set_flashdata('alertmsg', 'This Request is already in progress.');
                $this->session->set_flashdata('alertType', 'error');
                redirect_tr('tenant');
            }
        } else {
            redirect_tr('tenant');
        }
    }

    public function edit_requestsave() {

        $rules = array(
            array(
                'field' => 'description',
                'label' => lang('description'),
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        $id = $this->input->post('id');
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 0,
                'message' => validation_errors(),
            );
        } else {
            $data = array(
                'request_for' => $this->input->post('request_for'),
                'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
                'update_date' => date('Y-m-d H:i:s'),
            );
            if ($this->input->post('tenant_id')) {
                $data['user_id'] = $this->input->post('tenant_id');
                $booking_info = $this->cm->select_single_row('apartment_booked_list', 'user_id', $data['user_id']);
                if (empty($booking_info)) {
                    $this->session->set_flashdata('alertmsg', 'No Booking Data Found.');
                    $this->session->set_flashdata('alertType', 'error');
                    $response = array(
                        'status' => 0,
                        'message' => 'No Booking Data Found.',
                        'redirectto' => base_url_tr('tenant'),
                    );
                    echo json_encode($response);
                    return;
                }
            }
            $update = $this->cm->update('tenant_request', $data, 'id', $id);
            if ($update) {
                $this->session->set_flashdata('alertmsg', lang('save_success'));
                $this->session->set_flashdata('alertType', 'success');
                $response = array(
                    'status' => 1,
                    'message' => lang('save_success'),
                    'redirectto' => base_url_tr('tenant'),
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

    public function request_feedback($request_id) {
        if ($request_id) {
            $request = $this->cm->select_single_row('tenant_request', 'id', $request_id);
            if ($request) {
                $all_messages = $this->tenant->get_feedback_messages($request_id);
                $all_request_images = $this->tenant->get_feedback_images($request_id);
                $user = getUserdata();
                if ($all_messages || $user['user_type'] != 'tenant') {
                    $data['header']['title'] = 'Feedback';
                    $data['body']['page'] = "tenant/request_feedback";
                    $data['body']['request'] = $request;
                    $data['body']['user_id'] = $user['user_id'];
                    $data['body']['all_messages'] = $all_messages;
                    $data['body']['all_request_images'] = $all_request_images;
                    makeTemplateAdmin($data);
                } else {
                    $this->session->set_flashdata('alertmsg', 'No feedback posted yet.');
                    $this->session->set_flashdata('alertType', 'error');
                    redirect_tr('tenant');
                }
            } else {
                $this->session->set_flashdata('alertmsg', 'This Request is Invalid.');
                $this->session->set_flashdata('alertType', 'error');
                redirect_tr('tenant');
            }
        } else {
            redirect_tr('tenant');
        }
    }

    public function send_message() {
        $message = $this->input->post('message');
        $request_id = $this->input->post('request_id');
        $userdata = getUserdata();
        $create_date = date('Y-m-d H:i:s');
        $data = array(
            'request_id' => $request_id,
            'user_id' => $userdata['user_id'],
            'message' => $message,
            'create_date' => $create_date
        );
        $insert_id = $this->cm->insert('request_feedback', $data);
        if ($insert_id) {
            $data['id'] = $insert_id;
            $data['name'] = $userdata['user_name'];
            $data['family_name'] = $userdata['user_family_name'];
            $data['status'] = 1;
            $data['create_date'] = date('d F Y, h:i a', strtotime($create_date));
        } else {
            $data = array('status' => 0);
        }
        echo json_encode($data);
    }

    function refresh_feedback() {
        $last_id = $this->input->post('last_id');
        $request_id = $this->input->post('request_id');
        $new_messages = $this->tenant->get_feedback_messages($request_id, $last_id);
        if ($new_messages) {
            $response = array(
                'status' => 1,
                'messages' => $new_messages,
                'userdata' => getUserdata(),
            );
        } else {
            $response = array(
                'status' => 0
            );
        }
        echo json_encode($response);
    }

    function make_all_feedback_seen() {
        $reuqest_id = $this->input->post('request_id');
        $this->tenant->make_all_feedback_seen($reuqest_id);
    }

    function refresh_feedback_request_list() {
        $request_ids = json_decode($this->input->post('request_ids'));
        if ($request_ids) {
            $unseen_messages = $this->tenant->get_unseen_feedback_message_requests($request_ids);
            echo json_encode($unseen_messages);
        }
    }

    public function apartment_details() {
        $user = getUserdata();
        $booking_info = $this->cm->select_single_row('apartment_booked_list', 'user_id', $user['user_id']);
        $apartment = $this->cm->select_single_row('apartment_detail', 'id', $booking_info['apartment_id']);
        $room = $this->cm->select_single_row('rooms', 'id', $booking_info['room_id']);
        $data['header']['title'] = 'Apartment Details';
        $data['body']['page'] = "apartment_details";
        $data['body']['booking_info'] = $booking_info;
        if (!empty($apartment)) {
            $data['body']['apartment'] = $apartment;
            $data['body']['apartment']['owner_details'] = getUser($apartment['owner']);
        }
        if (!empty($room)) {
            $data['body']['room'] = $room;
        }

        makeTemplateAdmin($data);
    }

    function update_request() {
        $rules = array(
            array(
                'field' => 'cost',
                'label' => "Cost",
                'rules' => 'required|numeric|trim'
            ),
            array(
                'field' => 'charge_amount',
                'label' => "Charge Amount",
                'rules' => 'required|numeric|trim'
            ),
        );
        if ($this->input->post('to_external')) {
            $rules[] = array(
                'field' => 'external_maintainer',
                'label' => 'External Maintainer',
                'rules' => 'required'
            );
        } else {
            $rules[] = array(
                'field' => 'employer',
                'label' => 'Employer',
                'rules' => 'required'
            );
        }
        $this->form_validation->set_rules($rules);
        $request_id = $this->input->post('request_id');
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 0,
                'message' => validation_errors('<div class="alert alert-danger">', '</div>')
            );
        } else {
            $data = array(
                'cost' => $this->input->post('cost'),
                'charge_amount' => $this->input->post('charge_amount'),
            );
            if ($this->input->post('to_external')) {
                $data['assigned_to'] = $this->input->post('external_maintainer');
            } else {
                $data['assigned_to'] = $this->input->post('employer');
            }
            $this->cm->update('tenant_request', $data, 'id', $request_id);
            $assigned_user = getUser($data['assigned_to']);
            $response = array(
                'status' => 1,
                'message' => 'Request Updated',
                'assigned_to' => $assigned_user->name . ' ' . $assigned_user->family_name,
                'cost' => $data['cost'],
                'charge_amount' => $data['charge_amount'],
                'request_id' => $request_id,
            );
        }
        echo json_encode($response);
    }

    public function change_request_status($request_id) {
        if (getUserdata('user_type') == 'backend_user') {
            change_column_status($request_id, 'tenant_request', 'status', 'id', 'tenant');
        }
    }

    public function general_info() {
        $user = getUserdata();
        if ($user['user_type'] == 'tenant') {
            $booking_info = $this->cm->select_single_row('apartment_booked_list', 'user_id', $user['user_id']);
            if ($booking_info) {
                $data['header']['title'] = 'General Info';
                $data['body']['page'] = "general_info";
                $data['body']['booking_info'] = $booking_info;
                makeTemplateAdmin($data);
            } else {
                $this->session->set_flashdata('alertmsg', 'You do not have any bookings.');
                $this->session->set_flashdata('alertType', 'error');
                redirect_tr('dashboard');
            }
        } else {
            redirect_tr('dashboard');
        }
    }

    public function download_agreement() {
        $user = getUserdata();
        if ($user['user_type'] == 'tenant') {
            $booking_info = $this->cm->select_single_row('apartment_booked_list', 'user_id', $user['user_id']);
            if ($booking_info) {
                $this->load->helper('download');
                $data = file_get_contents("./uploads/agreement_file/" . $booking_info['agreement_file']); // Read the file's contents
                $name = 'Agreement.' . pathinfo($booking_info['agreement_file'], PATHINFO_EXTENSION);

                force_download($name, $data);
            } else {
                $this->session->set_flashdata('alertmsg', 'You do not have any bookings.');
                $this->session->set_flashdata('alertType', 'error');
                redirect_tr('dashboard');
            }
        } else {
            redirect_tr('dashboard');
        }
    }

    public function payment_list() {
        $user = getUserdata();
        $booking_info = $this->tenant->select_bookings_by_tenant($user['user_id']);
        if (count($booking_info)) {
            $installments = $this->tenant->select_installments_by_booking($booking_info['id']);
            
            $data = array();
            $data['header']['title'] = 'Payment List';
            $data['body']['page'] = "payment_list";
            $data['body']['installments'] = $installments;
            makeTemplateAdmin($data);
        } else {
            $this->session->set_flashdata('alertmsg', 'You do not have any bookings.');
            $this->session->set_flashdata('alertType', 'error');
            redirect_tr('dashboard');
        }
    }

}

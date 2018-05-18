<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * General_cost
 * This class is for managing general cost
 * @author Md. Asif Rahman
 */
class General_cost extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('generalcost_model', 'generalcost');
        $this->load->library('form_validation');
    }

    /**
     * This method is used to add general cost
     * @param  null
     * @author Md. Asif Rahman
     */
    public function index() {
        $data['header']['title'] = "Add General Cost";
        $data['header']['menu_base'] = "general_cost";
        $data['body']['page'] = "add_general_cost";
        $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers", "company");
        $data['body']['cost_codes'] = $this->cm->select_all_asc("ledger", "nominal_code");
        $data['body']['apartments_list'] = get_apartments("*");
        makeTemplateAdmin($data);
    }

    /**
     * This method is used to validate general cost add form 
     * and save this data to general_cost table
     * @param null
     * @return view
     * @author Md. Asif Rahman
     */
    public function save_general_cost() {
        if ($this->input->post('general_cost_type') == "related_apartment") {
            $this->form_validation->set_rules('general_cost_apartment_id', 'Property Id', 'required|numeric');
        }
//        $this->form_validation->set_rules('general_cost_type', 'Cost type', 'trim|required|numeric');
        $this->form_validation->set_rules('gc_description', 'Description', 'trim|required');
        $this->form_validation->set_rules('general_cost_amount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('general_cost_expiration_date', 'Expiration Date', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            /*
              $general_costs=[
              'apartment_id'  =>$this->input->post('general_cost_apartment_id'),
              //                'cost_type'     =>$this->input->post('general_cost_type'),
              'description' => $this->input->post('gc_description'),
              'amount'        =>$this->input->post('general_cost_amount'),
              'expire_date'   =>formatted_date($this->input->post('general_cost_expiration_date'),"Y-m-d"),
              ];
             */

            $general_costs = array();
            $general_cost_type = 0;
            if ($this->input->post('general_cost_type') == "related_apartment") {
                $general_cost_type = 2;
                $general_costs["apartment_id"] = $this->input->post('general_cost_apartment_id');
            }
            $general_costs["description"] = $this->input->post('gc_description');
            $general_costs["amount"] = $this->input->post('general_cost_amount');
            $general_costs["expire_date"] = sqldate($this->input->post('general_cost_expiration_date'),"-","d-m-Y");
            $general_costs["general_cost_type"] = $this->input->post('general_cost_type');

            if ($this->input->post('general_cost_type') == "general_cost") {
                $general_cost_type = 1;
                $general_costs["supplier_invoice_date"] = sqldate($this->input->post('supplier_invoice_date'), "-", "d-m-Y");
                //$general_costs["cost_period_to"] = sqldate($this->input->post('cost_period_to'),"-","d-m-Y");
                $general_costs["supplier_invoice_number"] = $this->input->post('supplier_invoice_number');
                $general_costs["file_name"] = $this->input->post('file_name');
                $general_costs["supplier_id"] = $this->input->post('supplier_id');
                $general_costs["nominal_code"] = $this->input->post('nominal_code');
            }


            $inserted = $this->cm->insert('general_cost', $general_costs);

            if ($inserted) {
                if ($this->input->post('file_name')) {
                    copy("./uploads/gc_temp/" . $this->input->post('file_name'), "./uploads/gc_file/" . $this->input->post('file_name'));
                    unlink("./uploads/gc_temp/" . $this->input->post('file_name'));
                }


                /*
                  $current_year = date("Y");
                  $last_invoice_serial = $this->select_last_invoice_serial();

                  $invoice_data = array();
                  $invoice_data["invoice_of"] = 3;
                  $invoice_data["invoice_serial"] = $last_invoice_serial+1;
                  $invoice_data["invoice_year"] = $current_year;
                  $invoice_data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
                  $invoice_data["invoice_amount"] = $this->input->post("general_cost_amount");
                  $invoice_data["gc_id"] = $inserted;
                  $invoice_data["installment_id"] = 0;
                  $invoice_data["create_date"] = date("Y-m-d");
                  $this->cm->insert("invoice",$invoice_data);
                 */

                //insert contract cost in cost table
                $costData = array(
                    'cost_for' => 4, //4 is for  OC (general cost)
                    'gc_id' => $inserted, //*
                    'gc_type' => $general_cost_type, //*
                    'apartment_id' => $general_cost_type == 2 ? $this->input->post('general_cost_apartment_id') : 0,
                    'oc_amount' => $this->input->post('general_cost_amount'),
                    'payment_date' => formatted_date($this->input->post('general_cost_expiration_date'), "Y-m-d"),
                    'description' => $this->input->post('gc_description'), //*
                    'billing_number' => $this->input->post('supplier_invoice_number'), // *
                    'supplier_id' => $this->input->post('supplier_id'), // *
                    'cost_code' => $general_cost_type == 1 ? $this->input->post('nominal_code') : '',
                    'create_date' => date('Y-m-d'),
                );
                $this->cm->insert('cost', $costData);

                $this->session->set_flashdata('general_cost_save', 'Saved Successfully');
                redirect('general_cost/general_cost_lists');
            } else {
                $this->session->set_flashdata('general_cost_save', 'Problem in saving');
            }

            redirect('general_cost');
        }
    }

    public function select_last_invoice_serial() {
        $this->db->from("invoice");
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $return = $this->db->get();

        if ($return->num_rows()) {
            return $return->row()->invoice_serial;
        } else {
            return 0;
        }
    }

    /**
     * This method is used to list general costs done
     * @param null
     * @return view
     * @author Md. Asif Rahman
     */
    public function general_cost_lists() {
        $data['header']['title'] = "General Cost List";
        $data['header']['menu_base'] = "general_cost/general_cost_lists";
        $data['body']['page'] = "generalcost_lists";
        $data['body']['generalcosts'] = $this->generalcost->select_all();
        $data['body']['tenants'] = $this->cm->select_all_where_asc("user", "type", "5", "name");
        $data['body']['owners'] = $this->cm->select_all_where_asc("user", "type", "6", "name");
        makeTemplateAdmin($data);
    }

    /**
     * This method is used to get general cost data to edit
     * @param $generalcost_id
     * @return view
     * @author Md. Asif Rahman
     */
    public function generalcost_edit($generalcost_id = false) {
        $data['header']['title'] = "Edit General Cost";
        $data['header']['menu_base'] = "general_cost";
        $data['body']['page'] = "generalcost_edit";
        $data['body']['apartments_list'] = get_apartments("*");
        if ($generalcost_id) {
            $data['body']['generalcost_edit'] = $this->cm->select_single_row('general_cost', 'gc_id', $generalcost_id);
        }

        $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers", "company");
        $data['body']['cost_codes'] = $this->cm->select_all_asc("ledger", "nominal_code");
        makeTemplateAdmin($data);
    }

    /**
     * This method is used to update general cost data to edit
     * @param $generalcost_id
     * @return view
     * @author Md. Asif Rahman
     */
    public function generalcost_update() {
        if ($this->input->post('general_cost_type') == "related_apartment") {
            $this->form_validation->set_rules('general_cost_apartment_id', 'Property Id', 'required|numeric');
        }
//        $this->form_validation->set_rules('general_cost_type', 'Cost type', 'trim|required|numeric');
        $this->form_validation->set_rules('gc_description', 'Description', 'trim|required');
        $this->form_validation->set_rules('general_cost_amount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('general_cost_expiration_date', 'Expiration Date', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->generalcost_edit();
        } else {
            $general_costs = array();
            $general_cost_type = 0;
            if ($this->input->post('general_cost_type') == "related_apartment") {
                $general_cost_type = 2;
                $general_costs["apartment_id"] = $this->input->post('general_cost_apartment_id');
            }
            $general_costs["description"] = $this->input->post('gc_description');
            $general_costs["amount"] = $this->input->post('general_cost_amount');
            $general_costs["expire_date"] = sqldate($this->input->post('general_cost_expiration_date'),"-","d-m-Y");
            $general_costs["general_cost_type"] = $this->input->post('general_cost_type');

            if ($this->input->post('general_cost_type') == "general_cost") {
                $general_cost_type = 1;
                $general_costs["supplier_invoice_date"] = sqldate($this->input->post('supplier_invoice_date'), "-", "d-m-Y");
                //$general_costs["cost_period_to"] = sqldate($this->input->post('cost_period_to'),"-","d-m-Y");
                $general_costs["supplier_invoice_number"] = $this->input->post('supplier_invoice_number');
                $general_costs["file_name"] = $this->input->post('file_name');
                $general_costs["supplier_id"] = $this->input->post('supplier_id');
                $general_costs["nominal_code"] = $this->input->post('nominal_code');
            }

            $inserted = $this->cm->update('general_cost', $general_costs, 'gc_id', $this->input->post('generalcost_id'));

            if ($inserted) {
                //update contract cost in cost table
                $costData = array(
                    'gc_type' => $general_cost_type, //*
                    'apartment_id' => $general_cost_type == 2 ? $this->input->post('general_cost_apartment_id') : 0,
                    'oc_amount' => $this->input->post('general_cost_amount'),
                    'payment_date' => formatted_date($this->input->post('general_cost_expiration_date'), "Y-m-d"),
                    'description' => $this->input->post('gc_description'), //*
                    'billing_number' => $this->input->post('supplier_invoice_number'), // *
                    'supplier_id' => $this->input->post('supplier_id'), // *
                    'cost_code' => $general_cost_type == 1 ? $this->input->post('nominal_code') : '',
                    'create_date' => date('Y-m-d'),
                );
                $this->cm->update_2_where('cost', $costData, 'cost_for', 4, 'gc_id', $this->input->post('generalcost_id'));

                if ($this->input->post('file_name')) {
                    copy("./uploads/gc_temp/" . $this->input->post('file_name'), "./uploads/gc_file/" . $this->input->post('file_name'));
                    unlink("./uploads/gc_temp/" . $this->input->post('file_name'));
                    unlink("./uploads/gc_file/" . $this->input->post('old_file_name'));
                }
                $this->session->set_flashdata('general_cost_update', 'Updated Successfully');
            } else {
                $this->session->set_flashdata('general_cost_update', 'Problem in updating');
            }
            redirect('general_cost/general_cost_lists');
        }
    }

    /**
     * This method is used to delete general cost data to edit
     * @return view
     * @author Md. Asif Rahman
     */
    public function generalcost_delete() {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $generalcost_id = $this->input->post('generalcost_id');
            $deleted = $this->cm->delete('general_cost', 'gc_id', $generalcost_id);
            if ($deleted) {
                $this->cm->delete('cost', 'gc_id', $generalcost_id);
                $this->session->set_flashdata('general_cost_update', 'Deleted Successfully');
            } else {
                $this->session->set_flashdata('general_cost_update', 'Problem in deleting');
            }

            redirect('general_cost/general_cost_lists');
        } else {
            show_404();
        }
    }

    public function update_general_paymentDate() {

        $inserted_id = $this->generalcost->save_bank_movement();
        if ($inserted_id) {
            $movement_amount = $this->input->post('movement_amount');
            $gc_amount = $this->cm->select_single_field("amount", "general_cost", "gc_id", $this->input->post('gc_id'));
            $get_movement_amount_from_db = $this->cm->select_single_field("amount_paid", "general_cost", "gc_id", $this->input->post('gc_id'));

            if($get_movement_amount_from_db)
                {
                    $movement_amount = $movement_amount + $get_movement_amount_from_db;
                }
                
            if($movement_amount < $gc_amount)
            {
                
                $general_costs_update = [
                'payment_status' => 0,
                'payment_date' => '0000-00-00 00:00:00',
                'bm_id' => $inserted_id,
                'amount_paid' => $movement_amount
                ];
                $updated = $this->cm->update('general_cost', $general_costs_update, 'gc_id', $this->input->post('gc_id'));
            }
            else{
                $general_costs_update = [
                'payment_status' => 1,
                'payment_date' => formatted_date($this->input->post('movement_date'), "Y-m-d"),
                'bm_id' => $inserted_id,
                'amount_paid' => $movement_amount
                ];

                $updated = $this->cm->update('general_cost', $general_costs_update, 'gc_id', $this->input->post('gc_id'));
            }
            
            if ($updated) {
                $this->cm->update('cost', array(
                    'payment_status' => 1,
                    'payment_status_update_date' => formatted_date($this->input->post('movement_date'), "Y-m-d")
                        ), 'gc_id', $this->input->post('gc_id'));
                $this->session->set_flashdata('general_cost_update', 'Updated Successfully');
                redirect('general_cost/general_cost_lists');
            }
        }
    }

    public function gc_invoice_pdf($id) {
        $data['generalcost'] = $this->cm->select_single_row('general_cost', 'gc_id', $id);
        $data['gc_id'] = $id;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "GeneralCost_" . $id . "_Invoice.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //page 01
        $html_01 = $this->load->view('generalcost_invoice', $data, true);
        $this->m_pdf->pdf->AddPage('P'); // margin footer
        $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function gc_file_upload() {
        $response = uploadFile("myfile", "", "gc_temp/");
        echo json_encode($response);
    }
    
    public function download_file($id){
        $generalcost = $this->cm->select_single_row('general_cost', 'gc_id', $id);
        //print_r($generalcost);
        $this->load->helper('download');
        if($generalcost['file_name'] && is_file('./uploads/gc_file/'.$generalcost['file_name'])){
            $this->load->helper('download');
            force_download('General-Cost.'.end(explode(".", $generalcost['file_name'])), file_get_contents('./uploads/gc_file/'.$generalcost['file_name']));
        }else{
            $this->session->set_flashdata('error_message', 'Invalid file');
            redirect('general_cost/general_cost_lists');
        }
    }

}

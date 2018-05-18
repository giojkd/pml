<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Payments
 * This class is for managing revenue
 * @author Md. Jamiul Hasan
 */
class Revenue extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('revenue_model');
        //$this->load->library('form_validation');
    }


    public function index()
    {

    }


    public function installment_list()
    {
        $data = array();
        $data['header']['title'] = "Incoming Licence Fee";
        $data['header']['menu_base'] = "Revenue";
        $data['body']['page'] = "installment_list";
        $data['body']['installments']=$this->revenue_model->select_due_installments();
        makeTemplateAdmin($data);
    }


    public function update_installment_payment_status()
    {
        $data=[
                'payment_status' =>1,
                'payment_status_update_date' =>formatted_date($this->input->post('payment_date'),"Y-m-d"),
            ];

            $inserted=$this->cm->update('cost', $data,'id',$this->input->post('id'));
            if($inserted)
            {
                $this->session->set_flashdata('payment_status_update', 'Updated Successfully');
                redirect('cashmanager/revenue/installment_list');
            }
    }


    public function due_payment_list()
    {
        $data = array();
        $data['header']['title'] = "Due Payment List";
        $data['header']['menu_base'] = "Revenue";
        $data['body']['page'] = "due_payment_list";
        $data['body']['payments'] = $this->revenue_model->select_due_payments();
        makeTemplateAdmin($data);
    }


    public function credit_control()
    {
        $data = array();
        $data['header']['title'] = "Credit Control";
        $data['header']['menu_base'] = "Revenue";
        $data['body']['page'] = "credit_control";
        $data['body']['payments'] = $this->revenue_model->select_due_payments();
        makeTemplateAdmin($data);
    }


    public function update_due_payment_status()
    {
        $data=[
                'payment_status' =>1,
                'payment_status_update_date' =>formatted_date($this->input->post('payment_date'),"Y-m-d"),
            ];

            $inserted=$this->cm->update('cost', $data,'id',$this->input->post('id'));
            if($inserted)
            {
                $this->session->set_flashdata('payment_status_update', 'Updated Successfully');
                redirect('cashmanager/revenue/due_payment_list');
            }
    }

    public function installment_invoice_pdf($id)
    {

      /*$outgoing_costs = $this->outgoing_model->get_invoice_costs($id);



      array_walk($outgoing_costs, function(&$val){
          $cost_id = $val['id'];
          $invoice_info = $this->cm->select_single_row("invoice","oc_id",$cost_id);
          $val['invoice'] = $invoice_info;
      });

      $data['outgoing_costs']=$outgoing_costs;
      $data['outgoing_cost_id'] = $id;
      $invoice = $this->cm->select_single_row("invoice","id",$id);
      $data['invoice'] = $invoice;
      $data['user'] = $this->cm->select_single_row("user","id",$invoice['user_id']);*/



        $installments = $this->revenue_model->get_invoice_costs($id);
        array_walk($installments, function(&$val){
            $cost_id = $val['id'];
            $invoice_info = $this->cm->select_single_row("invoice","installment_id",$cost_id);
            $val['invoice'] = $invoice_info;
        });

        /*echo "<pre>";
        print_r($installments).exit;*/

        $data['installments']=$installments;
        $invoice = $this->cm->select_single_row("invoice","id",$id);
        $data['invoice'] = $invoice;
        $data['user'] = $this->cm->select_single_row("user","id",$invoice['user_id']);
        $data['installment_id'] = $id;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "Installment_".$id."_Invoice.pdf";

        //load mPDF library

        $this->load->library('m_pdf');

        // page 01


        $html_01 = $this->load->view('pdfpage/installment_invoice', $data, true);



        $this->m_pdf->pdf->AddPage('P'); // margin footer
        $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
    public function send_invoice_to_tenant($id)
    {
        $this->load->library('email_manager');
        $installments = $this->revenue_model->select_due_installments($id);

        array_walk($installments, function(&$val){
            $cost_id = $val['id'];
            $invoice_info = $this->cm->select_single_row("invoice","installment_id",$cost_id);
            $val['invoice'] = $invoice_info;
        });

        $data['installments']=$installments;
        $data['installment_id'] = $id;
        $tenant_email=get_single_table_data_by_id($data['installments'][0]['tenant_user_id'],$field = "email", $table = "user");
        $email_body=$this->load->view('pdfpage/installment_invoice', $data, true);
        $this->email_manager->send_email($tenant_email,"Installments",$email_body);
        redirect('cashmanager/revenue/installment_list');
    }
    public function installment_invoice($id)
    {
        $data = array();
        $data['header']['title'] = "Installment Invoice";
        $data['header']['menu_base'] = "Revenue";
        $data['body']['page'] = "pdfpage/installment_invoice2";
        $data['body']['installments']=$this->revenue_model->select_due_installments($id);
        $data['body']['installment_id'] = $id;
        makeTemplateAdmin($data);
    }
}

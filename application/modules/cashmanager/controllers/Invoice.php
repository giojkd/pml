<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Payments
 * This class is for managing revenue
 * @author Md. Jamiul Hasan
 */
class Invoice extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('invoice_model');
        //$this->load->library('form_validation');
    }


    public function index()
    {

    }


    public function invoice_list()
    {
        $data = array();
        $data['header']['title'] = "Invoice List";
        $data['header']['menu_base'] = "Invoice";
        $data['body']['page'] = "invoice_list";
        $data['body']['invoices']=$this->invoice_model->select_installment_invoices();
        
        makeTemplateAdmin($data);
    }






}

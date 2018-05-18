<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Reports
 * This class is for generating different types of reports
 * @author Md. Asif Rahman
 */
class Reports extends MX_Controller {

    public $currency;

    function __construct() {
        parent::__construct();
        $this->load->model('reports_model');
        $this->load->library('form_validation');
        $this->currency = '£';
    }

    /**
     * This method is used to generate reports per apartment
     * @param  null
     * @author Md. Asif Rahman
     */
    public function per_apartment() {

        $per_apartment_data = $this->reports_model->per_apartment_inout_cash();

        /*echo "<pre>";
        print_r($per_apartment_data).exit;*/

        $data['header']['title'] = "In/Out Cash Report Per Property";
        $data['header']['menu_base'] = "reports";
        $data['body']['page'] = "cash_report_per_apartment";
        $data['body']['per_apartment_inout_cash'] = $per_apartment_data;
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        $data['body']['apartment_id'] = $this->input->get('apartment_id');
        $data['body']['from_month'] = $this->input->get('from_month');
        $data['body']['to_month'] = $this->input->get('to_month');
        $data['body']['currency'] = $this->currency;
        makeTemplateAdmin($data);
    }

    /**
     * This method is used to generate pdf per apartment
     * @param  null
     * @author Imrul Hossain Chowdhury
     */
    public function per_apartment_pdf() {
        $data['title'] = "In/Out Cash Report Per Property";
        $data['currency'] = $this->currency;
        $data['per_apartment_inout_cash'] = $this->reports_model->per_apartment_inout_cash();
        $html = $this->load->view('cash_report_per_apartment_pdf', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "cash_report_per_apartment.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //actually, you can pass mPDF parameter on this load() function
//    $pdf = $this->m_pdf->load();
        $this->m_pdf->pdf->AddPage('L'); // margin footer
        //generate the PDF!
        $this->m_pdf->pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    /**
     * This method is used to generate reports per tenant
     * @param  null
     * @author Md. Asif Rahman
     */
    public function per_tenant() {
        $data['header']['title'] = "In/Out Cash Report Per Tenant";
        $data['header']['menu_base'] = "reports";
        $data['body']['page'] = "cash_report_per_tenant";
        $data['body']['per_tenant_inout_cash'] = $this->reports_model->per_tenant_inout_cash();

        $data['body']['tenants'] = $this->cm->select_all_where_asc("user","type","5","name");
        $data['body']['tenant_user_id'] = $this->input->get('tenant_user_id');
        $data['body']['from_month'] = $this->input->get('from_month');
        $data['body']['to_month'] = $this->input->get('to_month');
        $data['body']['currency'] = $this->currency;

        makeTemplateAdmin($data);
    }

        /**
     * This method is used to generate pdf per tenant
     * @param  null
     * @author Imrul Hossain Chowdhury
     */
    public function per_tenant_pdf() {
        $data['title'] = "In/Out Cash Report Per Tenant";
        $data['per_tenant_inout_cash'] = $this->reports_model->per_tenant_inout_cash();
        $data['tenant_user_id'] = $this->input->get('tenant_user_id');
        $data['from_month'] = $this->input->get('from_month');
        $data['to_month'] = $this->input->get('to_month');
        $data['currency'] = $this->currency;
        $html = $this->load->view('cash_report_per_tenant_pdf', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = "cash_report_per_tenant.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //actually, you can pass mPDF parameter on this load() function
//    $pdf = $this->m_pdf->load();
        $this->m_pdf->pdf->AddPage('L'); // margin footer
        //generate the PDF!
        $this->m_pdf->pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function per_owner() {
        $data['header']['title'] = "In/Out Cash Report Per Owner";
        $data['header']['menu_base'] = "reports";

        $data['body']['owners'] = $this->cm->select_all_where_asc("user","type","6","name");
        $data['body']['onwers_id'] = $this->input->get('onwers_id');
        $data['body']['from_month'] = $this->input->get('from_month');
        $data['body']['to_month'] = $this->input->get('to_month');
        $data['body']['currency'] = $this->currency;

        $data['body']['page'] = "cash_report_per_owner";
        $data['body']['per_owner_inout_cash'] = $this->reports_model->per_owner_inout_cash();
        makeTemplateAdmin($data);
    }

          /**
     * This method is used to generate pdf per Owner
     * @param  null
     * @author Imrul Hossain Chowdhury
     */
    public function per_owner_pdf() {
        $data['title'] = "In/Out Cash Report Per Owner";
        $data['per_owner_inout_cash'] = $this->reports_model->per_owner_inout_cash();

        $data['onwers_id'] = $this->input->get('onwers_id');
        $data['from_month'] = $this->input->get('from_month');
        $data['to_month'] = $this->input->get('to_month');
        $data['currency'] = $this->currency;

        $html = $this->load->view('cash_report_per_owner_pdf', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = "cash_report_per_owner.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //actually, you can pass mPDF parameter on this load() function
//    $pdf = $this->m_pdf->load();
        $this->m_pdf->pdf->AddPage('L'); // margin footer
        //generate the PDF!
        $this->m_pdf->pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    /**
     * This method is used to show cost details
     * @param  null
     * @return json
     * @author Md. Asif Rahman
     */
    public function inout_cash_details() {
        $apartment_id = $this->input->post('apartment_id');
        $tenant_id = $this->input->post('tenant_id');
        $owner_id = $this->input->post('owner_id');
        if ($apartment_id) {
            $inout_cash_details = [
                'cost_details' => $this->reports_model->cost_details($apartment_id),
                'revenue_details' => $this->reports_model->revenue_details($apartment_id)
            ];
            echo json_encode($inout_cash_details);
        } else if ($tenant_id) {
            $inout_cash_details = [
                'cost_details' => $this->reports_model->cost_details_per_tenant($tenant_id),
                'revenue_details' => $this->reports_model->revenue_details_per_tenant($tenant_id)
            ];
            echo json_encode($inout_cash_details);
        } else if ($owner_id) {
            $inout_cash_details = [
                'cost_details' => $this->reports_model->cost_details_per_owner($owner_id),
                'revenue_details' => $this->reports_model->revenue_details_per_owner($owner_id)
            ];
            echo json_encode($inout_cash_details);
        }
    }

    /**
     * This method is used to generate pdf apartment allotment
     * @param  null
     * @author Razib Mahmud
     */
    public function apartment_allotment() {
        $data['header']['title'] = "Property Allotment";
        $data['header']['menu_base'] = "reports";
        $data['body']['page'] = "reports/apartment_allotment";

        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        $data['body']['rooms'] = $this->reports_model->get_rooms_in_apartment($this->input->get('apartment_id'));

        $data['body']['apartment_id'] = $this->input->get('apartment_id');
        $data['body']['room_id'] = $this->input->get('room_id');
        $data['body']['from_month'] = $this->input->get('from_month');
        $data['body']['to_month'] = $this->input->get('to_month');

        $filter_data = $this->reports_model->get_rooms_by_filter();

        /*echo "<pre>";
        print_r($filter_data).exit;*/

        $data['body']['filter_rooms'] = $filter_data;

        makeTemplateAdmin($data);
    }

     /**
     * Modify Razib Mahmud
     * This method is used to generate pdf apartment allotment
     * @param  null
     * @author Imrul Hossain Chowdhury
     */
    public function apartment_allotment_pdf() {
        $data['title'] = "Properties Allotment ( ".date('d-m-Y',strtotime($this->input->get('from_month')))." to ".date('d-m-Y',strtotime($this->input->get('to_month')))." )";
        //$data['apartments_allotment'] = $this->reports_model->apartments_allotment();

        $data['apartment_id'] = $this->input->get('apartment_id');
        $data['room_id'] = $this->input->get('room_id');
        $data['from_month'] = $this->input->get('from_month');
        $data['to_month'] = $this->input->get('to_month');
        $data['filter_rooms'] = $this->reports_model->get_rooms_by_filter();

        $html = $this->load->view('apartment_allotment_pdf', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "apartment_allotment_".$this->input->get('room_id').".pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //actually, you can pass mPDF parameter on this load() function
        //$pdf = $this->m_pdf->load();
        $this->m_pdf->pdf->AddPage('L'); // margin footer
        //generate the PDF!
        $this->m_pdf->pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }


    /**
     * This function has been used to show form for add booking
     * @author Razib Mahmud
     */
    public function get_room_dropdown() {
        $apartment_id = $this->input->post('apartment_id');

        echo "<option value='all'>" . 'All' . "</option>";

        if ($apartment_id) {
            $room_list = $this->reports_model->get_rooms_in_apartment($apartment_id);

            if ($room_list) {

                foreach ($room_list as $room) {
                    $room_type = $room['room_type'] == 1 ? 'Single Type' : 'Double Type';
                    echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - " . $room_type . " : ".$room['address']."</option>";
                }
            }
        }
    }

    /**
     * @author Imrul Hossain Chowdhury
     */
    public function cash_flow() {


        if(!$this->input->get('cash_flow_year')) {
            $year = '0';
            $data['header']['title'] = "Cash Flow";
        }else{
            $year = date('Y-m-d', strtotime($this->input->get('cash_flow_year')));
            $data['header']['title'] = "Cash Flow from TODAY Until ".mydate($year,'-');
        }

        $data['header']['menu_base'] = "reports";
        $data['body']['page'] = "cash_flow";
        $data['body']['year'] = $year;
        $data['body']['currency'] = $this->currency;

        $data['body']['cash_flow'] = $this->reports_model->cash_flow($year);
        $data['body']['previous_year_amount'] = $this->reports_model->previous_year_initial_amount($year);
        /*print_r($data['body']['cash_flow']);
        exit;*/
        makeTemplateAdmin($data);
    }

      /**
     * This method is used to generate pdf apartment allotment
     * @param  Year
     * @author Imrul Hossain Chowdhury
     */
    public function cash_flow_pdf($year) {
        $data['title'] = "Cash Flow of ".mydate($year,'-');
        $data['year'] = $year;
        $data['currency'] = $this->currency;

        if($year) {
          $data['cash_flow'] = $this->reports_model->cash_flow($year);
          $data['previous_year_amount'] = $this->reports_model->previous_year_initial_amount($year);
        }

        $html = $this->load->view('cash_flow_pdf', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "cash_flow_$year.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

        //actually, you can pass mPDF parameter on this load() function
//    $pdf = $this->m_pdf->load();
        $this->m_pdf->pdf->AddPage('L'); // margin footer
        //generate the PDF!
        $this->m_pdf->pdf->WriteHTML($html);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function get_filtered_booking_date()
    {
        $apartment_id = $this->input->post('apartment_id');
        $room_id = $this->input->post('room_id');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $booked_date = $this->reports_model->get_filtered_booking_date( $apartment_id, $room_id, sqldate($this->input->post('from_date'),'-','d-m-Y'), sqldate($this->input->post('to_date'),'-','d-m-Y'));
        echo json_encode($booked_date);
    }

}

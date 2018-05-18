<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * DocuSign
 * This class is for DocuSign
 * @author Md. Jamiul Hasan
 */
class Docusign extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_model');
    }

    public function index() {
        
    }
    
    public function reply()
    {
        $data = file_get_contents('php://input');
        $xml = simplexml_load_string ($data, "SimpleXMLElement", LIBXML_PARSEHUGE);
        $envelope_id = (string)$xml->EnvelopeStatus->EnvelopeID;
        $time_generated = (string)$xml->EnvelopeStatus->TimeGenerated;
        
        $data_docusign = array();
        $data_docusign["envelopeId"] = $envelope_id;
        $data_docusign["status"] = (string)$xml->EnvelopeStatus->Status;
        $data_docusign["statusDateTime"] = $time_generated;


        $log = $this->common_model->select_single_row('docusign_log', 'envelopeId', $envelope_id);
        //change to status signed_by_licensee = 1
        if($data_docusign["status"] == "Completed") {
            $this->db->where('id', $log['booking_id']);
            $this->db->update('apartment_booked_list', array('signed_by_licensee' => 1));
        }
        $data_docusign["booking_id"] = $log['booking_id'];
        $this->db->insert("docusign_log",$data_docusign);
    }



}

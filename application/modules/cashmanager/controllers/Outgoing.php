<?php
/*
* Outgoing cost means "Maintenence Cost"
*/
class Outgoing extends MX_Controller {

  function __construct() {
    parent::__construct();

    // load required models
    $this->load->model('outgoing_model');
    $this->load->library('form_validation');
  }

  /**
  * [index description]
  * @return [type] [description]
  */
  public function index() {
    redirect("cashmanager/outgoing/oc_list");
  }

  public function maintenance_cost_create_send_invoice($id){
    $maintenance_cost = $this->cm-> select_single_row("cost","id",$id);

    $email = getUser($maintenance_cost['tenant_user_id'], "email");
    // For Invoice A
    $last_A_invoice_serial = $this->outgoing_model->select_last_invoice_serial();
    $invoice_A_data = array(
      "invoice_of" => 2,
      "invoice_type" => 0,
      "invoice_serial" => $last_A_invoice_serial+1,
      "invoice_year" => date("Y"),
      "invoice_no" => "A".($last_A_invoice_serial+1)."-".date("Y"),
      "invoice_amount" => $maintenance_cost['revenue_amount'],
      "create_date" => date("Y-m-d"),
      "user_id"=>$maintenance_cost['tenant_user_id'],
      "payment_due_date"=>$maintenance_cost['payment_date']
    );

    $invoice_A_id = $this->cm->insert("invoice", $invoice_A_data);

    $data = [];
    $data['invoice_id'] = $invoice_A_id;
    $this->cm->update("cost", $data, "id", $id);#associated invoice id to the maintenance_cost

    $invoice_A_details = $this->cm->select_single_row("invoice", "id", $invoice_A_id);
    $invoice_A_pdf['booking_details'] = $this->cm->select_single_row("user", "id", $maintenance_cost['tenant_user_id']);
    $invoice_A_pdf['invoice_no'] = $invoice_A_details['invoice_no'];
    $invoice_A_pdf['invoice_amount'] = $invoice_A_details['invoice_amount'];

    $this->load->library("email_manager");
    if($invoice_A_id)
    {
      $pdfFileName = "Invoice". $invoice_A_pdf['invoice_no'].".pdf";
      $this->load->library('m_pdf');
      $html = $this->load->view('pdfpage/invoice_a', $invoice_A_pdf, true);
      $this->m_pdf->pdf->WriteHTML($html); //generate the PDF!

      $pdfFilePath = FCPATH."uploads/".$pdfFileName;
      $this->m_pdf->pdf->Output($pdfFilePath, "F");

      //Send Email
      $attach_file_path = base_url()."/uploads/".$pdfFileName;

      $status = $this->email_manager->send_email($email, $pdfFileName, "","", $attach_file_path);
    }
  }

  public function maintenance_photo_upload()
  {
    $response = uploadFile("myfile","", "temp/");
    echo json_encode($response);
  }

  public function maintenance_manage($id){
    $maintenance = $this->cm->select_single_row("maintenance","maintenance_id",$id);
    $apartment = $this->cm->select_single_row("apartment_detail","id",$maintenance['apartment_id']);
    $data = [];

    $data['header']['title'] = "Maintenance Edit";
    $data['header']['menu_base'] = "cash";
    $data['body']['maintenance_costs'] =$this->outgoing_model->get_maintenance_costs($maintenance['maintenance_id']);
    $data['body']['page'] = "maintenance_manage";
    $data['body']['billable_users'] = $this->outgoing_model->get_rooms_in_apartment_and_common_area($maintenance['apartment_id']);
    #if the maintenance is for entire apartment
    if($maintenance['room_id'] == 0 || $maintenance['all_apartment']==1){
      $data['body']['users'] = $this->outgoing_model->get_apt_all_tenant($aparment_id);
    }
    #if the maintenance is for a single room
    if($maintenance['room_id']>0){
      $data['body']['users'] = $this->outgoing_model->get_room_all_tenant($maintenance['room_id']);
    }
    $data['bodh']['apartment'] = $apartment;
    $data['body']['owner'] = $this->cm->select_single_row("user","id",$apartment['owner']);
    $data['body']['suppliers'] = $this->outgoing_model->get_all_suppliers();
    $data['body']['maintenance'] = $maintenance;
    makeTemplateAdmin($data);
  }



  public function maintenance_list(){
    $data = [];
    $data['body']['maintenances'] = $this->outgoing_model->select_maintenance();
    $data['header']['title'] = "Maintenance List";
    $data['header']['menu_base'] = "cash";
    $data['body']['page'] = "maintenance_list";

    makeTemplateAdmin($data);
  }

  public function oc_list() {
    $data = array();
    $data['body']['costs'] = $this->outgoing_model->select_outgoing_costs();
    $data['header']['title'] = "Maintenance Cost List";
    $data['header']['menu_base'] = "cash";
    $data['body']['page'] = "oc_list";
    makeTemplateAdmin($data);
  }

  public function oc_list_sent() {
    $data = array();
    $data['body']['costs'] = $this->outgoing_model->select_outgoing_costs_sent();
    $data['body']['apartments'] = $this->cm->select_all("apartment_detail");

    $data['body']['apartment_id'] = $this->input->get('apartment_id');
    $data['body']['from_month'] = $this->input->get('from_month');
    $data['body']['to_month'] = $this->input->get('to_month');

    $data['header']['title'] = "Past Maintenance Jobs";
    $data['header']['menu_base'] = "cash";
    $data['body']['page'] = "oc_list_sent";
    makeTemplateAdmin($data);
  }

  public function oc_add() {
    $data = array();
    $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
    $data['body']['cost_types'] = service_charges();
    $data['body']['cost_codes'] = $this->cm->select_all_asc("ledger", "nominal_code");
    $data['body']['related_to'] = related_to();
    $data['body']['tenants'] = $this->cm->select_all_where_asc("user","type","5","name");
    $data['body']['employers'] = $this->cm->select_all_where_asc("user","type","3","name");
    $data['body']['owners'] = $this->cm->select_all_where_asc("user","type","6","name");
    $data['body']['suppliers'] = $this->cm->select_all_asc("suppliers", "company");
    $data['header']['title'] = "Maintenance Cost Add";
    $data['header']['menu_base'] = "cash";
    $data['body']['page'] = "oc_add";
    makeTemplateAdmin($data);
  }

  public function maintenance_edit(){
    $post = $this->input->post();
    $maintenance_id = $post['maintenance_id'];
    unset($post['maintenance_id']);
    $oc_amount = $post['maintenance_supplier_cost'];
    $supplier_id = $post['supplier_id'];
    foreach($post as $index => $value){
      $this->db->query("UPDATE maintenance SET ".$index." = '".$value."' WHERE maintenance_id = ".$maintenance_id);
    }

    $data = [];
    $data['oc_amount'] =$oc_amount;
    $data['supplier_id'] =$supplier_id;
    $data['job_description'] = "Supplier invoice";
    $data['create_date'] = date('Y-m-d');
    $this->db->insert("cost",$data);

    redirectAlert("/cashmanager/outgoing/maintenance_manage/".$maintenance_id,lang('save_success'));
  }

  public function maintenance_add_cost(){

    $data['cost_for'] = 1;#apartment cost
    $data['apartment_id'] = $this->input->post('apartment_id');
    $data['job_description'] = "Maintenance ".$this->input->post('maintenance_id')." cost billed to user ".$this->input->post('tenant_user_id');
    $data['tenant_user_id'] = $this->input->post('tenant_user_id');
    $data['revenue_amount'] = $this->input->post('revenue_amount');
    $data['maintenance_id'] = $this->input->post('maintenance_id');
    $data['payment_date'] = date('Y-m-d',strtotime($this->input->post('payment_date')));
    $data['create_date'] = date('Y-m-d');
    $this->db->insert("cost",$data);
    redirectAlert("/cashmanager/outgoing/maintenance_manage/".$this->input->post('maintenance_id'),lang('save_success'));
  }

  public function maintenance_add(){
    $data = array();
    $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
    $data['header']['title'] = "Maintenance Add";
    $data['header']['menu_base'] = "cash";
    $data['body']['page'] = "maintenance_add";
    makeTemplateAdmin($data);
  }

  public function supplier_file_upload() {
    $response = uploadFile("myfile", "", "oc_temp/");
    echo json_encode($response);
  }



  public function save_maintenance(){
    $this->outgoing_model->save_maintenance();
    redirectAlert("cashmanager/outgoing/maintenance_list",lang('save_success'));
  }

  public function oc_add_save()
  {
    $this->form_validation->set_rules('apartment_id', 'Property', 'required');

    if($this->form_validation->run($this) == FALSE) {
      $this->oc_add();
    }
    else{
      $this->outgoing_model->save_oc_data();
      redirectAlert("cashmanager/outgoing/oc_list",lang('save_success'));
    }
  }

  /*
  public function check_if_item_has_been_added_in_external_already($item_id)
  {
  $exist = $this->cm->exist_or_not("stock_external", "item_id", $item_id);

  if($exist){
  $this->form_validation->set_message('check_if_item_has_been_added_in_external_already', 'This item has been added already');
  return FALSE;
}
else{
return TRUE;
}
}
*/


public function oc_delete($id)
{
  $this->db->where("id",$id);
  $this->db->delete("cost");
  redirectAlert("cashmanager/outgoing/oc_list",lang('delete_success'));
}


public function outgoing_invoice_pdf($id)
{
  $outgoing_costs = $this->outgoing_model->get_invoice_costs($id);

  array_walk($outgoing_costs, function(&$val){
    $cost_id = $val['id'];
    $invoice_info = $this->cm->select_single_row("invoice","oc_id",$cost_id);
    $val['invoice'] = $invoice_info;
  });

  $data['outgoing_costs']=$outgoing_costs;
  $data['outgoing_cost_id'] = $id;
  $invoice = $this->cm->select_single_row("invoice","id",$id);
  $data['invoice'] = $invoice;
  $data['user'] = $this->cm->select_single_row("user","id",$invoice['user_id']);
  //this the the PDF filename that user will get to download
  $pdfFilePath = "outgoing_".$id."_Invoice.pdf";

  //load mPDF library
  $this->load->library('m_pdf');

  //page 01
  $html_01 = $this->load->view('pdfpage/outgoing_invoice', $data,true);


  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

  //offer it to user via browser download! (The PDF won't be saved on your server HDD)
  $this->m_pdf->pdf->Output($pdfFilePath, "D");
}

public function outgoing_invoice($id)
{
  $data = array();
  $data['header']['title'] = "Outgoing Invoice";
  $data['header']['menu_base'] = "outgoing";
  $data['body']['page'] = "outgoing_invoice";
  $data['body']['outgoing_costs']=$this->outgoing_model->select_due_outgoing($id);
  $data['body']['outgoing_cost_id'] = $id;
  makeTemplateAdmin($data);
}


public function ajax_get_apartment_all_tenant(){
  $rooms_id = $this->input->post('rooms_id');
  $tenant_list = $this->outgoing_model->get_apartment_all_tenant($rooms_id);

  if ($tenant_list) {
    echo json_encode($tenant_list);
  } else {
    echo json_encode(0);
  }
}

public function get_apartment_all_tenant(){
  $rooms_id = $this->input->post('rooms_id');
  $tenant_list = $this->outgoing_model->get_apartment_all_tenant($rooms_id);
  return $tenant_list;
}

public function ajax_change_job_to_done(){
  $cost_id = $this->input->post('cost_id');
  $status = $this->input->post('status');
  $job_done_date = sqldate($this->input->post('job_done_date'),"-","d-m-Y");
  $reported_date = $this->input->post('reported_date'); //yyyy-mm-dd

  $job_duration = 0;
  if(($reported_date != "0000-00-00") && ($job_done_date != "0000-00-00")){
    $date1 = new DateTime($reported_date);
    $date2 = new DateTime($job_done_date);

    $job_duration = $date2->diff($date1)->format("%a");
  }


  if($cost_id) {
    $data['job_done_status'] = $status;
    if($status == 1) {
      $data['job_done_date'] = $job_done_date;
      $data['job_duration'] = $job_duration;
      $result['job_date'] = mydate($job_done_date,"-");
    }
    $this->db->where('id', $cost_id);
    $this->db->update('cost', $data);
    $result['result'] = 1;
  }
  echo json_encode($result);
}

public function ajax_save_price(){
  $invoice_id = $this->input->post('invoice_id');
  $invoice_amount = $this->input->post('invoice_amount');

  if($invoice_id && $invoice_amount) {
    $data['invoice_amount'] = $invoice_amount;
    $this->db->where('id', $invoice_id);
    $this->db->update('invoice', $data);
    $result = 1;
  }

  $cost_id = $this->input->post('cost_id');
  $cost_amount = $this->input->post('cost_amount');
  if($cost_id && $cost_amount) {
    $data['oc_amount'] = $cost_amount;
    $this->db->where('id', $cost_id);
    $this->db->update('cost', $data);
    $result = 1;
  }

  $cost_comment = $this->input->post('cost_comment');
  if($cost_id && $cost_comment) {
    $data['comments'] = $cost_comment;
    $this->db->where('id', $cost_id);
    $this->db->update('cost', $data);
    $result = 1;
  }
  echo json_encode($result);
}

public function send_invoice($id)
{
  $outgoing_costs = $this->outgoing_model->select_due_outgoing($id);
  array_walk($outgoing_costs, function(&$val){
    $cost_id = $val['id'];
    $invoice_info = $this->cm->select_single_row("invoice","oc_id",$cost_id);
    $val['invoice'] = $invoice_info;
    $user_id = 0;
    if($val['if_to_tenant'] == 1) {
      $user_id = $val['tenant_user_id'];
    }
    if($val['if_to_owner'] == 1) {
      $user_id = $val['owner_user_id'];
    }
    $val['user'] = $this->cm->select_single_row("user","id",$user_id);
  });
  /*echo "<pre>";
  print_r($outgoing_costs).exit;*/
  $data['outgoing_costs'] = $outgoing_costs;
  $data['outgoing_cost_id'] = $id;
  //this the the PDF filename that user will get to download
  $pdfFilePath = FCPATH."uploads/temp/outgoing_send_".$id."_Invoice_".time().".pdf";
  //load mPDF library
  $this->load->library('m_pdf');
  //page 01
  $html_01 = $this->load->view('pdfpage/outgoing_send_invoice', $data,true);
  //$this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!
  //offer it to user via browser download! (The PDF won't be saved on your server HDD)
  $this->m_pdf->pdf->Output($pdfFilePath, "F");

  $this->load->library("email_manager");
  $user_email = $outgoing_costs[0]['user']['email'];
  $this->email_manager->send_email($user_email,"Invoice","","", $pdfFilePath);
  $this->cm->update("cost", array('send_invoice_status' => 1), "id", $id);
  echo json_encode(1);
}
}

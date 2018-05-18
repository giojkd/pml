<?php

class Cleaning extends MX_Controller {

  function __construct() {
    parent::__construct();

    // load required models
    $this->load->model('cleaning_model', 'cleaning');
    $this->load->model('apartment/apartment_model');
    $this->load->model('common_model');
    $this->load->library('form_validation');

  }

  public function index()
  {
    $data['body']['cleaning'] = $this->cleaning->get_all_cleaning_info();
    $data['header']['title'] = 'Cleaning List';
    $data['header']['menu_base'] = "cleaning";
    $data['body']['page'] = "list";
    makeTemplateAdmin($data);
  }

  public function add()
  {
    $data['header']['title'] = lang('cleaning_add');
    $data['body']['apartments'] = $this->apartment_model->get_all_apartment_info();
    $data['body']['cleaners'] = $this->common_model->select_all_asc('cleaners', 'cleaner_id');
    $data['body']['suppliers'] = $this->common_model->select_all_asc('suppliers','id');

    $data['header']['menu_base'] = "cleaning";
    $data['body']['page'] = "add";
    makeTemplateAdmin($data);
  }

  public function addSave()
  {
    $rules = array(
      array(
        'field' => 'cleaning_date',
        'label' => 'Date',
        'rules' => 'required'
      ),
      array(
        'field' => 'apartment_id',
        'label' => 'Property',
        'rules' => 'required'
      ),
      array(
        'field' => 'room_id',
        'label' => 'Area',
        'rules' => 'required'
      ),
      array(
        'field' => 'cleaner_id',
        'label' => 'Cleaner',
        'rules' => 'required'
      ),
      array(
        'field' => 'who_pay',
        'label' => 'Who Pay',
        'rules' => 'required'
      ),
      array(
        'field' => 'cleaning_cost',
        'label' => 'Cleaning Cost',
        'rules' => 'required'
      )

    );

    $this->form_validation->set_rules($rules);

    $response = array();
    if ($this->form_validation->run($this) == FALSE) {
      $response = array(
        'status' => 0,
        'message' => validation_errors(),
      );
    }
    else{
      $cleaning_data = array(
        'apartment_id' => $this->input->post('apartment_id'),
        'room_id' => $this->input->post('room_id'),
        'cleaner_id' => $this->input->post('cleaner_id'),
        'who_pay' => $this->input->post('who_pay'),
        'cleaning_cost' => $this->input->post('cleaning_cost'),
        'cleaning_date' => sqldate($this->input->post('cleaning_date'),"-","d-m-Y"),
        'cleaning_createDate' => date('Y-m-d H:i:s'),
        'file_name'=>$this->input->post('file_name'),
        'supplier_id'=>$this->input->post('supplier_id'),
        'supplier_cost'=>$this->input->post('supplier_cost'),
      );

      #supplier cost must be written in cash flow (cost table)

      $cleaning_id = $this->cleaning->insert_cleaning($cleaning_data);


      #save outgoint supplier cost cost in cash flow
      $cost_data = [];
      $cost_data['cost_for'] = 9;
      $cost_data['apartment_id'] = $this->input->post('apartment_id');
      $cost_data['room_id'] = $this->input->post('room_id');
      $cost_data['payment_date'] = date('Y-m-d');
      $cost_data['payment_status'] = 0;
      $cost_data['create_date'] = date('Y-m-d');
      $cost_data['cost_code'] = 6003;
      $cost_data['cleaning_id'] =  $cleaning_id;
      $cost_data['oc_amount'] = $this->input->post('supplier_cost');
      $oc_id = $this->common_model->insert('cost', $cost_data);
      ########################################################



      if($cleaning_id)
      {
        $response = array(
          'status' => 1,
          'message' => lang('save_success'),
          'redirectto' => base_url_tr('cleaning'),
        );
      }
    }
    #echo json_encode($response);
    redirectAlert("cleaning",lang('save_success'));
  }

  // public function edit()
  // {

  // }
  // public function editSave()
  // {

  // }

  public function get_room_dropdown()
  {
    $apartment_id = $this->input->post('apartment_id');

    // echo "<option value=''>" . 'Select Room' . "</option>";

    if ($apartment_id) {
      $room_list = $this->cleaning->get_rooms_in_apartment($apartment_id);

      // foreach ($room_list as $key => $value) {
      //     $room_id[] =  $value['id'];
      // }
      // sort($room_id);
      // foreach ($room_id as $key => $room_no) {
      //     $booking_per_room = $this->cleaning->get_all_booking_info_per_room($apartment_id, $room_no);

      // if($booking_per_room)
      // {
      //     $unique_user = array();
      //     //$previous_bookings[$room_no] = array();
      //     foreach ($booking_per_room as $key => $booking) {

      //         $user_id = $booking['user_id'];

      //         if (!in_array($user_id, $unique_user))
      //         {
      //             $date_today = date('Y-m-d');
      //             if(strtotime($booking['rent_to']) < strtotime($date_today))
      //             {
      //                  $previous_bookings[$room_no][] =  '<option value="'.$booking['user_id'].'/'.$booking['user_id'].'">Licensee ('.$booking['family_name'].' '.$booking['name'].', Room '.$booking['room_id'].' (Previous Licensee)'.'</option>';
      //             }
      //             else
      //             {
      //                  $previous_bookings[$room_no][] =  '<option value="'.$booking['user_id'].'/'.$booking['user_id'].'">Licensee ('.$booking['family_name'].' '.$booking['name'].', Room '.$booking['room_id'].' (Current Licensee)'.'</option>';
      //             }

      //             $unique_user[] = $user_id;
      //         }
      //     }

      //     $xxx[] = $room_no;
      //     }

      // }
      //$booking_list = $this->cleaning->get_all_booking_info($apartment_id);

      // if ($room_list) {

      //     foreach ($room_list as $room) {
      //         $room_type = $room['room_type'] == 1 ? 'Single Type' : 'Double Type';
      //         //echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - " . $room_type . "</option>";
      //         echo "<option value='" . $room['id'] . "'>" . $room['id'] . ($room['type']?' ('.$room['type'].')':'') ."</option>";
      //     }
      // }
    }
    //print_r($previous_bookings);
    echo json_encode(array("rooms"=>$room_list));
  }

  public function get_who_pay()
  {
    $apartment_id = $this->input->post('apartment_id');
    $room_id = $this->input->post('room_id');
    $cleaning_data = $this->input->post('cleaning_date');

    if($room_id)
    {
      $booking_per_room = $this->cleaning->get_all_booking_info_per_room($apartment_id, $room_id);
      $previous_licensee = array();
      $current_licensee = array();
      if($booking_per_room)
      {
        $unique_user = array();

        //$previous_bookings[$room_no] = array();
        foreach ($booking_per_room as $key => $booking) {
          $to_date = $booking['rent_to'];
          $from_date = $booking['rent_from'];
          $cleaning_date = date('Y-m-d');

          $datetimeObjto = new DateTime($to_date);
          $datetimeObjfrom = new DateTime($from_date);
          $datetimeObjcleaning = new DateTime($cleaning_date);

          $interval1 = $datetimeObjto->diff($datetimeObjcleaning);
          $dateDiff1 = $interval1->format('%R%a');

          $interval2 = $datetimeObjfrom->diff($datetimeObjcleaning);
          $dateDiff2 = $interval2->format('%R%a');

          $user_id = $booking['user_id'];

          if (!in_array($user_id, $unique_user))
          {
            if($dateDiff1 > 0)
            {
              $previous_licensee[] =  '<option value="'.$booking['user_id'].'/'."previous occupant".'">Occupant ('.$booking['family_name'].' '.$booking['name'].'), Room '.$booking['room_id'].' (Previous Occupant)'.'</option>';
              $unique_user[] = $user_id;
            }
            else if(($dateDiff1 < 0) && ($dateDiff2 > 0))
            {
              $current_licensee[] =  '<option value="'.$booking['user_id'].'/'."current occupant".'">Occupant ('.$booking['family_name'].' '.$booking['name'].'), Room '.$booking['room_id'].' (Current Occupant)'.'</option>';
              $unique_user[] = $user_id;
            }


          }
        }
      }
      echo json_encode(array("room_select" => "yes","previous_licensee" => $previous_licensee, "current_licensee" => $current_licensee));

    }

    else
    {
      $previous_licensee = array();
      $current_licensee = array();
      // $room_list = $this->cleaning->get_rooms_in_apartment_and_common_area($apartment_id);
      // $room_id = array();
      // foreach ($room_list as $key => $value) {
      //     $room_id[] =  $value['id'];
      // }
      // sort($room_id);
      // foreach ($room_id as $key => $room_no) {
      //     $booking_per_room = $this->cleaning->get_all_booking_info_per_room($apartment_id, $room_no);

      //     if($booking_per_room)
      //     {
      //         $unique_user = array();
      //         //$previous_bookings[$room_no] = array();
      //         foreach ($booking_per_room as $key => $booking) {

      //             $user_id = $booking['user_id'];

      //             if (!in_array($user_id, $unique_user))
      //             {
      //                 $to_date = $booking['rent_to'];
      //                 $from_date = $booking['rent_from'];
      //                 $cleaning_date = $this->input->post('cleaning_date');

      //                 $datetimeObjto = new DateTime($to_date);
      //                 $datetimeObjfrom = new DateTime($from_date);
      //                 $datetimeObjcleaning = new DateTime($cleaning_date);

      //                 $interval1 = $datetimeObjto->diff($datetimeObjcleaning);
      //                 $dateDiff1 = $interval1->format('%R%a');

      //                 $interval2 = $datetimeObjfrom->diff($datetimeObjcleaning);
      //                 $dateDiff2 = $interval2->format('%R%a');

      //                 if($dateDiff1 > 0)
      //                 {
      //                      $previous_bookings[$room_no][] =  '<option value="'.$booking['user_id'].'/'."previous occupant".'">Licensee ('.$booking['family_name'].' '.$booking['name'].', Room '.$booking['room_id'].' (Previous Licensee)'.'</option>';
      //                 }
      //                 else if(($dateDiff1 < 0) && ($dateDiff2 > 0))
      //                 {
      //                      $previous_bookings[$room_no][] =  '<option value="'.$booking['user_id'].'/'."current occupant".'">Licensee ('.$booking['family_name'].' '.$booking['name'].', Room '.$booking['room_id'].' (Current Licensee)'.'</option>';
      //                     $unique_user[] = $user_id;
      //                 }


      //             }
      //         }

      //         $xxx[] = $room_no;
      //     }

      // }
      echo json_encode(array("room_select" => "no", "previous_licensee" => $previous_licensee, "current_licensee" => $current_licensee));
    }


  }

  public function create_invoice()
  {
    $cleaning_id = $this->input->post('cleaning_id');

    $cleaning_details = $this->common_model->select_all_where('cleaning', 'id', $cleaning_id);

    $all_licensee = array();
    $current_year = date("Y");
    if($cleaning_details[0]['who_pay'] == "all_licensee")
    {
      $all_licensee = $this->common_model->select_all_where('apartment_booked_list', 'apartment_id', $cleaning_details[0]['apartment_id']);
      $unique_licensee = array();
      foreach ($all_licensee as $key => $licensee) {

        $licensee_id = $licensee['user_id'];

        if (!in_array($licensee_id, $unique_licensee))
        {
          $unique_licensee[] = $licensee_id;
        }
      }

      foreach ($unique_licensee as $key => $licensee) {
        $cost_data['cost_for'] = 9;
        $cost_data['apartment_id'] = $cleaning_details[0]['apartment_id'];
        if($cleaning_details[0]['room_id'])
        {
          $cost_data['room_id'] = $cleaning_details[0]['room_id'];
        }
        else{
          $cost_data['room_id'] = "";
        }
        #$cost_data['oc_amount'] = $cleaning_details[0]['cleaning_cost']/count($unique_licensee);
        $cost_data['payment_date'] = date('Y-m-d');
        $cost_data['tenant_user_id'] = $licensee;
        $cost_data['payment_status'] = 0;
        $cost_data['create_date'] = date('Y-m-d');
        $cost_data['cost_code'] = 6003;
        $cost_data['cleaning_id'] =  $cleaning_id;
        $cost_data['revenue_amount'] = $cleaning_details[0]['cleaning_cost']/count($unique_licensee);

        $oc_id = $this->common_model->insert('cost', $cost_data);



        $last_invoice_serial = $this->select_last_invoice_serial();

        $data = array();
        $data["invoice_of"] = 2;
        $data["invoice_serial"] = $last_invoice_serial+1;
        $data["invoice_year"] = $current_year;
        $data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
        $data["invoice_amount"] = $cleaning_details[0]['cleaning_cost']/count($unique_licensee);
        $data["oc_id"] =  $oc_id;
        $data["installment_id"] = 0;
        $data["create_date"] = date("Y-m-d");
        $data["user_id"] = $licensee;
        $data['payment_due_date'] = date('Y-m-d');
        $invoice_id = $this->cm->insert("invoice",$data);
        #echo $this->db->last_query();

        $data = [];
        $data['invoice_id '] = $invoice_id;
        $this->common_model->update('cost', $data, 'id', $oc_id);

      }



    }
    else if($cleaning_details[0]['who_pay'] == "apartment_owner")
    {
      $owner_id = $this->common_model->select_single_field('owner', 'apartment_detail', 'id', $cleaning_details[0]['apartment_id']);

      $cost_data['cost_for'] = 9;
      $cost_data['apartment_id'] = $cleaning_details[0]['apartment_id'];
      if($cleaning_details[0]['room_id'])
      {
        $cost_data['room_id'] = $cleaning_details[0]['room_id'];
      }
      else{
        $cost_data['room_id'] = "";
      }
      #$cost_data['oc_amount'] = $cleaning_details[0]['cleaning_cost'];
      $cost_data['revenue_amount'] = $cleaning_details[0]['cleaning_cost'];
      $cost_data['payment_date'] = date('Y-m-d');
      $cost_data['owner_user_id'] = $owner_id;
      $cost_data['payment_status'] = 0;
      $cost_data['create_date'] = date('Y-m-d');
      $cost_data['cost_code'] = 6003;
      $cost_data['cleaning_id'] =  $cleaning_id;

      $oc_id = $this->common_model->insert('cost', $cost_data);

      #$exist_already = $this->cm->exist_or_not_2_where("invoice", "oc_id", $oc_id, "create_date", date('Y-m-d'));

      $last_invoice_serial = $this->select_last_invoice_serial();

      $data = array();
      $data["invoice_of"] = 2;
      $data["invoice_serial"] = $last_invoice_serial+1;
      $data["invoice_year"] = $current_year;
      $data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
      $data["invoice_amount"] = $cleaning_details[0]['cleaning_cost'];
      $data["oc_id"] =  $oc_id;
      $data["installment_id"] = 0;
      $data["user_id"] = $owner_id;
      $data["create_date"] = date("Y-m-d");
      $data["payment_due_date"] = date("Y-m-d");
      $invoice_id =  $this->cm->insert("invoice",$data);

      $data = [];
      $data['invoice_id '] = $invoice_id;
      $this->common_model->update('cost', $data, 'id', $oc_id);
    }
    else{
      $licensee = explode('/', $cleaning_details[0]['who_pay']);
      $licensee_id = $licensee[0];

      $cost_data['cost_for'] = 9;
      $cost_data['apartment_id'] = $cleaning_details[0]['apartment_id'];
      if($cleaning_details[0]['room_id'])
      {
        $cost_data['room_id'] = $cleaning_details[0]['room_id'];
      }
      else{
        $cost_data['room_id'] = "";
      }
      #$cost_data['oc_amount'] = $cleaning_details[0]['cleaning_cost'];
      $cost_data['payment_date'] = date('Y-m-d');
      $cost_data['tenant_user_id'] = $licensee_id;
      $cost_data['payment_status'] = 0;
      $cost_data['create_date'] = date('Y-m-d');
      $cost_data['cost_code'] = 6003;
      $cost_data['cleaning_id'] =  $cleaning_id;
      $cost_data['revenue_amount'] = $cleaning_details[0]['cleaning_cost'];

      $oc_id = $this->common_model->insert('cost', $cost_data);

      #$exist_already = $this->cm->exist_or_not_2_where("invoice", "oc_id", $oc_id, "create_date", date('Y-m-d'));

      $last_invoice_serial = $this->select_last_invoice_serial();

      $data = array();
      $data["invoice_of"] = 2;
      $data["invoice_serial"] = $last_invoice_serial+1;
      $data["invoice_year"] = $current_year;
      $data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
      $data["invoice_amount"] = $cleaning_details[0]['cleaning_cost'];
      $data["oc_id"] =  $oc_id;
      $data["installment_id"] = 0;
      $data["user_id"] = $licensee_id;
      $data["create_date"] = date("Y-m-d");
      $data['payment_due_date'] = date("Y-m-d");
      $invoice_id = $this->cm->insert("invoice",$data);

      $data = [];
      $data['invoice_id '] = $invoice_id;
      $this->common_model->update('cost', $data, 'id', $oc_id);
    }
    $cleaning_data['cleaning_invoice_create'] = 1;
    $this->common_model->update('cleaning', $cleaning_data, 'id', $cleaning_id);
    echo "success";
  }

  public function send_invoice()
  {
    $cleaning_id = $this->input->post('cleaning_id');

    $cost_details = $this->cleaning->get_cleaning_info_from_cost($cleaning_id);

    foreach ($cost_details as $key => $cost) {
      $data['oc_id'] = $cost['oc_id'];
      $data['invoice_no'] = $cost['invoice_no'];
      $data['invoice_id'] = $cost['invoice_id'];
      $data['cost'] = $cost['oc_amount'];
      $data['invoice_date'] = $cost['invoice_date'];
      $data['apartment_id'] = $cost['apartment_id'];
      if($cost['room_id'])
      {
        $data['room_id'] = $cost['room_id'];
      }
      else{
        $data['room_id'] = 0;
      }

      if($cost['tenant_user_id'])
      {
        $data['user_id'] = $cost['tenant_user_id'];
      }
      else{
        $data['user_id'] = $cost['owner_user_id'];
      }

      $user_email = getUser($data['user_id'], 'email');

      $pdfFileName = "cleaning".$data['invoice_id']."_Invoice.pdf";

      //load mPDF library
      $this->load->library('m_pdf');
      $mpdf=new mPDF();

      //page 01
      $html_01 = $this->load->view('pdfpage/cleaning_invoice', $data,true);
      //$mpdf->AddPage('P'); // margin footer
      $mpdf->WriteHTML($html_01); //generate the PDF!

      //offer it to user via browser download! (The PDF won't be saved on your server HDD)
      $pdfFilePath = FCPATH."uploads/temp/".$pdfFileName;
      $mpdf->Output($pdfFilePath, "F");


      //now, send the email
      $attach_file_path = base_url()."/uploads/temp/".$pdfFileName;
      $this->load->library("email_manager");
      $this->email_manager->send_email($user_email,"Cleaning Invoice","","", $attach_file_path);
    }
    $cleaning_data['cleaning_invoice_sent'] = 1;
    $this->common_model->update('cleaning', $cleaning_data, 'id', $cleaning_id);
    echo "success";
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

}

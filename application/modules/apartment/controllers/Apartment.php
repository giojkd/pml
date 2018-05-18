<?php
class Apartment extends MX_Controller {

  function __construct() {
    parent::__construct();

    // load required models
    $this->load->model('apartment_model');
    $this->load->model('user/user_model', 'user');
    $this->load->model('common_model');
    //$this->load->library('form_validation');
  }

  /**
  * This function has been used to display list of apartments
  * @author Jobayer Islam
  */
  public function index() {
    $user_type = getUserdata('user_type');
    if( $user_type != "sales")
    {
      $data['body']['apartments'] = $this->apartment_model->get_all_apartment_info();
      $data['header']['title'] = 'Property List';
      $data['header']['menu_base'] = "apartment_manager";
      $data['body']['page'] = "index";
      makeTemplateAdmin($data);
    }
    else{
      redirect($_SERVER['HTTP_REFERER']);
    }
  }

  /**
  * This function has been used to show form for apartment addition
  * @author Jobayer Islam
  */
  public function add() {
    $data['header']['title'] = lang('apartment_add');
    $data['body']['users'] = $this->user->get_many_by('type=6');

    $data['header']['menu_base'] = "apartment_manager";
    $data['body']['page'] = "add";
    makeTemplateAdmin($data);
  }

  /**
  * This method has been used to save apartment detail
  * @return string $response after saving data
  * @author Jobayer Islam
  */
  public function addsave() {
    //  $contract_end = $this->input->post('contract_to');
    //         $standard_payment = $this->input->post('standard_payment');
    //         $contract_start = $this->input->post('contract_from');
    //         $added_month_date = strtotime(date("Y-m-d", strtotime($contract_start)) . " +".$this->input->post('month_in_advance')." month");
    //         $new_date = date("Y-m-d",$added_month_date);
    // $loop = 1;
    //         for($i = 0; $i < $loop; $i++)
    //         {
    //             $next_date = strtotime(date("Y-m-d", strtotime($new_date)) . " +".$this->input->post('standard_payment')." month");

    //            $next_date1 = date("Y-m-d",$next_date);

    //            $new_date = $next_date1;

    //            $date1Timestamp = strtotime($new_date);
    //            $date2Timestamp = strtotime($contract_end);
    //            echo $date1Timestamp."-------".$date2Timestamp;

    //                 $year1 = date('Y', $date1Timestamp);
    //                 $year2 = date('Y', $date2Timestamp);
    //                 $month1 = date('m', $date1Timestamp);
    //                 $month2 = date('m', $date2Timestamp);

    //                 $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    //            if($diff >= $standard_payment)
    //            {
    //             echo "found<br>";
    //                 // $advanceCostData = array(
    //                 //     'cost_for' => 3, //3 is for OC(apartment contract cost)
    //                 //     'apartment_id' => $apartment_id,
    //                 //     'oc_amount' => $first_advance_cost,
    //                 //     'payment_date' => $new_date,
    //                 //     'owner_user_id' => $this->input->post('owner'),
    //                 //     'create_date' => date('Y-m-d'),
    //                 //     'cost_code' => '1100',
    //                 // );
    //                 // $this->common_model->insert('cost', $advanceCostData);
    //                 $loop++;
    //            }
    //            else{
    //             echo "not found";
    //                 break;
    //            }
    //         }
    //         die;

    $rules = array(
      array(
        'field' => 'owner',
        'label' => 'Owner',
        'rules' => 'required'
      ),
      array(
        'field' => 'address',
        'label' => 'Address',
        'rules' => 'required'
      ),
      array(
        'field' => 'zip_code',
        'label' => 'ZIP Code',
        'rules' => 'required'
      ),
      array(
        'field' => 'floor',
        'label' => 'Floor',
        'rules' => 'required'
      ),
      array(
        'field' => 'nr',
        'label' => 'Nr. ',
        'rules' => 'required'
      ),
      //            array(
      //                'field' => 'water',
      //                'label' => 'Service charge for water',
      //                'rules' => 'required'
      //            ),
      //            array(
      //                'field' => 'gas',
      //                'label' => 'Service charge for gas',
      //                'rules' => 'required'
      //            ),
      //            array(
      //                'field' => 'electricity',
      //                'label' => 'Service charge for electricity',
      //                'rules' => 'required'
      //            ),
      //            array(
      //                'field' => 'internet',
      //                'label' => 'Service charge for internet',
      //                'rules' => 'required'
      //            ),
      //            array(
      //                'field' => 'council_tax',
      //                'label' => 'Service charge for council tax',
      //                'rules' => 'required'
      //            ),
      // array(
      //     'field' => 'room1_qty',
      //     'label' => 'Single type Room quantity',
      //     'rules' => 'required'
      // ),
      array(
        'field' => 'room2_qty',
        'label' => 'Double type Room quantity',
        'rules' => 'required'
      ),
      array(
        'field' => 'map_lat',
        'label' => 'Map Latitude',
        'rules' => 'required'
      ),
      array(
        'field' => 'map_lang',
        'label' => 'Map Langitude',
        'rules' => 'required'
      ),
      array(
        'field' => 'contract_cost',
        'label' => 'Contract Cost',
        'rules' => 'required'
      ),
      array(
        'field' => 'contract_from',
        'label' => 'Contract From',
        'rules' => 'required'
      ),
      array(
        'field' => 'contract_to',
        'label' => 'Contract To',
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



      $data = array(
        'owner' => $this->input->post('owner'),
        'address' => $this->input->post('address'),
        'latitude'=>$this->input->post('map_lat'),
        'longitude'=>$this->input->post('map_lang'),
        'max_couples_allowed'   =>  $this->input->post('max_couples_allowed'),
        'zip_code' => $this->input->post('zip_code'),
        'floor' => $this->input->post('floor'),
        'nr' => $this->input->post('nr'),
        'contract_cost' => $this->input->post('contract_cost'),
        'contract_from' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
        'contract_to' => date("Y-m-d", strtotime($this->input->post('contract_to'))),

        'day_of_month' => $this->input->post('day_of_month'),
        'month_in_advance' => $this->input->post('month_in_advance'),
        'standard_payment' => $this->input->post('standard_payment'),
        'deposit' => $this->input->post('deposit'),
        'note' => $this->input->post('note'),
        'attachment_title' => $this->input->post('attachment_title'),
        'file_name' => $this->input->post('file_name'),

        'payment_date_to_owner' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
        'create_date' => date('Y-m-d H:i:s')
      );

      $apartment_id = $this->common_model->insert('apartment_detail', $data);



      $service_charges = array(
        'apartment_id' => $apartment_id,
        'water' => $this->input->post('water'),
        'gas' => $this->input->post('gas'),
        'internet' => $this->input->post('internet'),
        'electricity' => $this->input->post('electricity'),
        'council_tax' => $this->input->post('council_tax'),
        'create_date' => date('Y-m-d H:i:s')
      );

      $this->common_model->insert('apartment_service_charges', $service_charges);

      $single_room = array(
        'apartment_id' => $apartment_id,
        'room_type' => 1,
        'create_date' => date('Y-m-d H:i:s')
      );

      // $total_single_room = $this->input->post('room1_qty');

      // for ($i = 0; $i < $total_single_room; $i++) {
      //     $this->common_model->insert('rooms', $single_room);
      // }

      // $double_room = array(
      //     'apartment_id' => $apartment_id,
      //     'room_type' => 2,
      //     'create_date' => date('Y-m-d H:i:s')
      // );

      // $total_double_room = $this->input->post('room2_qty');

      // for ($i = 0; $i < $total_double_room; $i++) {
      //     $this->common_model->insert('rooms', $double_room);
      // }

      /*
      $common_area_type = $this->input->post('common_area_type');
      $common_area_qty = $this->input->post('common_area_qty');

      if ($common_area_type) {
      $this->insert_common_area($apartment_id, $common_area_type, $common_area_qty);
    }

    $private_area_type = $this->input->post('private_area_type');
    $private_area_qty = $this->input->post('private_area_qty');

    if ($private_area_type) {
    $this->insert_private_area($apartment_id, $private_area_type, $private_area_qty);
  }
  */

  if ($apartment_id) {

    //insert all room to rooms table of this apartment
    if($this->input->post('room_repeater') == "yes")
    {
      $this->apartment_model->insert_rooms($apartment_id);
    }

    //insert contract cost in cost table
    $contract_cost = $this->input->post('contract_cost');
    $month_in_advance = $this->input->post('month_in_advance');
    $total_contract_cost = $contract_cost * $month_in_advance;
    $costData = array(
      'cost_for' => 3, //3 is for OC(apartment contract cost)
      'apartment_id' => $apartment_id,
      'oc_amount' => $total_contract_cost,
      'payment_date' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
      'owner_user_id' => $this->input->post('owner'),
      'create_date' => date('Y-m-d'),
      'cost_code' => '5000'
    );
    $this->common_model->insert('cost', $costData);

    //Insert Deposit Cost in Cost Table
    $depositCostData = array(
      'cost_for' => 3, //3 is for OC(apartment contract cost)
      'apartment_id' => $apartment_id,
      'oc_amount' => $this->input->post('deposit'),
      'payment_date' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
      'owner_user_id' => $this->input->post('owner'),
      'create_date' => date('Y-m-d'),
      'cost_code' => '1102'
    );
    $this->common_model->insert('cost', $depositCostData);

    //Insert admin fee in cost table

    $depositCostData = array(
      'cost_for' => 7, //3 is for OC(apartment contract cost)
      'apartment_id' => $apartment_id,
      'oc_amount' => $this->input->post('admin_fee'),
      'payment_date' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
      'owner_user_id' => $this->input->post('owner'),
      'create_date' => date('Y-m-d'),
      'cost_code' => '4011'
    );
    $this->common_model->insert('cost', $depositCostData);

    //Insert Advance Cost in Cost Table
    $contract_end = date("Y-m-d", strtotime($this->input->post('contract_to')));
    $standard_payment = $this->input->post('standard_payment');
    $contract_start = $this->input->post('contract_from');
    $added_month_date = strtotime(date("Y-m-d", strtotime($contract_start)) . " +".$this->input->post('month_in_advance')." month");
    $new_date = date("Y-m-d",$added_month_date);

    $first_advance_cost = $contract_cost * $standard_payment;

    $advanceCostData = array(
      'cost_for' => 3, //3 is for OC(apartment contract cost)
      'apartment_id' => $apartment_id,
      'oc_amount' => $first_advance_cost,
      'payment_date' => $new_date,
      'owner_user_id' => $this->input->post('owner'),
      'create_date' => date('Y-m-d'),
      'cost_code' => '5000',
    );
    $this->common_model->insert('cost', $advanceCostData);
    $loop = 1;
    for($i = 0; $i < $loop; $i++)
    {
      $date1Timestamp = strtotime($new_date);
      $date2Timestamp = strtotime($contract_end);
      $year1 = date('Y', $date1Timestamp);
      $year2 = date('Y', $date2Timestamp);
      $month1 = date('m', $date1Timestamp);
      $month2 = date('m', $date2Timestamp);

      $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

      $next_date = strtotime(date("Y-m-d", strtotime($new_date)) . " +".$this->input->post('standard_payment')." month");

      $next_date1 = date("Y-m-d",$next_date);

      $new_date = $next_date1;

      if($diff >= $standard_payment)
      {
        $advanceCostData1 = array(
          'cost_for' => 3, //3 is for OC(apartment contract cost)
          'apartment_id' => $apartment_id,
          'oc_amount' => $first_advance_cost,
          'payment_date' => $new_date,
          'owner_user_id' => $this->input->post('owner'),
          'create_date' => date('Y-m-d'),
          'cost_code' => '5000',
        );
        $this->common_model->insert('cost', $advanceCostData1);
        $loop++;
      }
      else{
        break;
      }
    }





    $response = array(
      'status' => 1,
      'message' => lang('save_success'),
      'redirectto' => base_url_tr('apartment'),
    );
    //redirectAlert("apartment", lang('save_success'));
  } else {
    $response = array(
      'status' => 0,
      'message' => lang('save_fail'),
    );
    //redirectAlert("apartment", lang('save_fail'));
  }
}
echo json_encode($response);

}

/**
* This method has been used to show specific apartment detail
* @param integer $id (apartment ID)
* @author Jobayer Islam
*/
public function apartment_detail($id) {
  $data['header']['title'] = 'Property Detail';
  $data['body']['users'] = $this->user->get_many_by('type=6');
  $data['body']['apartment_info'] = $this->apartment_model->get_apartment_info_by_id($id);
  $data['body']['apartment_common_area'] = $this->apartment_model->get_apartment_common_area_by_id($id);
  $data['body']['apartment_private_area'] = $this->apartment_model->get_apartment_private_area_by_id($id);
  $data['body']['single_room_in_apartment'] = $this->apartment_model->rooms_in_apartment($id, 1);
  $data['body']['double_room_in_apartment'] = $this->apartment_model->rooms_in_apartment($id, 2);

  $data['header']['menu_base'] = "apartment_manager";
  $data['body']['page'] = "apartment_detail";
  makeTemplateAdmin($data);
}

/**
* This method has been used to show apartment edit form
* @param integer $id (apartment ID)
* @author Jobayer Islam
*/
public function apartment_edit($id) {

  $data['header']['title'] = 'Property Edit';
  $data['body']['users'] = $this->user->get_many_by('type=6');
  $data['body']['apartment_info'] = $this->apartment_model->get_apartment_info_by_id($id);
  // $data['body']['apartment_common_area'] = $this->apartment_model->get_apartment_common_area_by_id($id);
  // $data['body']['apartment_private_area'] = $this->apartment_model->get_apartment_private_area_by_id($id);
  $data['body']['apartment_rooms'] = $this->apartment_model->get_apartment_rooms_by_id($id);

  $data['header']['menu_base'] = "apartment_manager";
  $data['body']['page'] = "edit_apartment";
  makeTemplateAdmin($data);
}

/**
* This method has been used to save data from apartment edit form
* @return string $response (will return json encoded success/error message)
* @author Jobayer Islam
*/
public function apartment_edit_save() {
  // echo "<pre>";
  // print_r($this->input->post('room_name'));
  // echo "<pre>";
  // print_r($this->input->post('check_box'));
  // echo "<pre>";
  // print_r($this->input->post('market_price'));
  // echo "<pre>";
  // print_r($this->input->post('room_description'));
  // die;


  $rules = array(
    array(
      'field' => 'owner',
      'label' => 'Owner',
      'rules' => 'required'
    ),
    array(
      'field' => 'address',
      'label' => 'Address',
      'rules' => 'required'
    ),
    array(
      'field' => 'zip_code',
      'label' => 'ZIP Code',
      'rules' => 'required'
    ),
    array(
      'field' => 'floor',
      'label' => 'Floor',
      'rules' => 'required'
    ),
    array(
      'field' => 'nr',
      'label' => 'Nr. ',
      'rules' => 'required'
    ),
    //            array(
    //                'field' => 'water',
    //                'label' => 'Service charge for water',
    //                'rules' => 'required'
    //            ),
    //            array(
    //                'field' => 'gas',
    //                'label' => 'Service charge for gas',
    //                'rules' => 'required'
    //            ),
    //            array(
    //                'field' => 'electricity',
    //                'label' => 'Service charge for electricity',
    //                'rules' => 'required'
    //            ),
    //            array(
    //                'field' => 'internet',
    //                'label' => 'Service charge for internet',
    //                'rules' => 'required'
    //            ),
    //            array(
    //                'field' => 'council_tax',
    //                'label' => 'Service charge for council tax',
    //                'rules' => 'required'
    //            ),
    // array(
    //     'field' => 'room1_qty',
    //     'label' => 'Single type Room quantity',
    //     'rules' => 'required'
    // ),
    // array(
    //     'field' => 'room2_qty',
    //     'label' => 'Double type Room quantity',
    //     'rules' => 'required'
    // ),
    array(
      'field' => 'map_lat',
      'label' => 'Map Latitude',
      'rules' => 'required'
    ),
    array(
      'field' => 'map_lang',
      'label' => 'Map Langitude',
      'rules' => 'required'
    ),
    array(
      'field' => 'contract_cost',
      'label' => 'Contract Cost',
      'rules' => 'required'
    ),
    array(
      'field' => 'contract_from',
      'label' => 'Contract From',
      'rules' => 'required'
    ),
    array(
      'field' => 'contract_to',
      'label' => 'Contract To',
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
    $apartment_id = $this->input->post('id');;

    $apartment_data = array(
      'owner' => $this->input->post('owner'),
      'address' => $this->input->post('address'),
      'latitude'=>$this->input->post('map_lat'),
      'longitude'=>$this->input->post('map_lang'),
      'max_couples_allowed'   =>  $this->input->post('max_couples_allowed'),
      'zip_code' => $this->input->post('zip_code'),
      'floor' => $this->input->post('floor'),
      'nr' => $this->input->post('nr'),
      'contract_cost' => $this->input->post('contract_cost'),
      'contract_from' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
      'contract_to' => date("Y-m-d", strtotime($this->input->post('contract_to'))),

      'day_of_month' => $this->input->post('day_of_month'),
      'month_in_advance' => $this->input->post('month_in_advance'),
      'standard_payment' => $this->input->post('standard_payment'),
      'deposit' => $this->input->post('deposit'),
      'note' => $this->input->post('note'),
      'attachment_title' => $this->input->post('attachment_title'),
      'file_name' => $this->input->post('file_name'),

      'payment_date_to_owner' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
      'create_date' => date('Y-m-d H:i:s')
    );

    $this->apartment_model->update_apartment_detail($apartment_id, $apartment_data);

    $service_charges = array(
      'water' => $this->input->post('water'),
      'gas' => $this->input->post('gas'),
      'internet' => $this->input->post('internet'),
      'electricity' => $this->input->post('electricity'),
      'council_tax' => $this->input->post('council_tax'),
      'update_date' => date('Y-m-d H:i:s')
    );

    $this->apartment_model->update_service_charge_info($apartment_id, $service_charges);

    /* $single_room = array(
    'qty' => $this->input->post('room1_qty'),
    'update_date' => date('Y-m-d H:i:s')
  );

  $this->apartment_model->update_room_detail($apartment_id, 1, $single_room);

  $double_room = array(
  'qty' => $this->input->post('room2_qty'),
  'update_date' => date('Y-m-d H:i:s')
);

$this->apartment_model->update_room_detail($apartment_id, 2, $double_room); */


/*
$this->apartment_model->remove_common_area($apartment_id);

$common_area_type = $this->input->post('common_area_type');
$common_area_qty = $this->input->post('common_area_qty');

if ($common_area_type) {
$this->insert_common_area($apartment_id, $common_area_type, $common_area_qty);
}

$this->apartment_model->remove_private_area($apartment_id);

$private_area_type = $this->input->post('private_area_type');
$private_area_qty = $this->input->post('private_area_qty');

if ($private_area_type) {
$this->insert_private_area($apartment_id, $private_area_type, $private_area_qty);
}
*/

if ($apartment_id) {
  //Insert New Rooms in rooms table
  if($this->input->post('room_repeater') == "yes")
  {
    $this->apartment_model->insert_rooms($apartment_id);
  }

  //Update existing room in rooms table
  $edit_room_id = $this->input->post('edit_room_id');
  if($edit_room_id)
  {
    $this->apartment_model->update_rooms();
  }

  //delete records of all cost from cost table where cost_for=3, booking_id="", apartment_id = apartment_id
  $this->apartment_model->delete_cost_data($apartment_id);

  //insert contract cost in cost table
  $contract_cost = $this->input->post('contract_cost');
  $month_in_advance = $this->input->post('month_in_advance');
  $total_contract_cost = $contract_cost * $month_in_advance;
  $costData = array(
    'cost_for' => 3, //3 is for OC(apartment contract cost)
    'apartment_id' => $apartment_id,
    'oc_amount' => $total_contract_cost,
    'payment_date' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
    'owner_user_id' => $this->input->post('owner'),
    'create_date' => date('Y-m-d'),
    'cost_code' => '1100'
  );
  $this->common_model->insert('cost', $costData);

  //Insert Deposit Cost in Cost Table
  $depositCostData = array(
    'cost_for' => 3, //3 is for OC(apartment contract cost)
    'apartment_id' => $apartment_id,
    'oc_amount' => $this->input->post('deposit'),
    'payment_date' => date("Y-m-d", strtotime($this->input->post('contract_from'))),
    'owner_user_id' => $this->input->post('owner'),
    'create_date' => date('Y-m-d'),
    'cost_code' => '1101'
  );
  $this->common_model->insert('cost', $depositCostData);

  //Insert Advance Cost in Cost Table
  $contract_end = date("Y-m-d", strtotime($this->input->post('contract_to')));
  $standard_payment = $this->input->post('standard_payment');
  $contract_start = $this->input->post('contract_from');
  $added_month_date = strtotime(date("Y-m-d", strtotime($contract_start)) . " +".$this->input->post('month_in_advance')." month");
  $new_date = date("Y-m-d",$added_month_date);

  $first_advance_cost = $contract_cost * $standard_payment;

  $advanceCostData = array(
    'cost_for' => 3, //3 is for OC(apartment contract cost)
    'apartment_id' => $apartment_id,
    'oc_amount' => $first_advance_cost,
    'payment_date' => $new_date,
    'owner_user_id' => $this->input->post('owner'),
    'create_date' => date('Y-m-d'),
    'cost_code' => '1100',
  );
  $this->common_model->insert('cost', $advanceCostData);
  $loop = 1;
  for($i = 0; $i < $loop; $i++)
  {
    $date1Timestamp = strtotime($new_date);
    $date2Timestamp = strtotime($contract_end);
    $year1 = date('Y', $date1Timestamp);
    $year2 = date('Y', $date2Timestamp);
    $month1 = date('m', $date1Timestamp);
    $month2 = date('m', $date2Timestamp);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    $next_date = strtotime(date("Y-m-d", strtotime($new_date)) . " +".$this->input->post('standard_payment')." month");

    $next_date1 = date("Y-m-d",$next_date);

    $new_date = $next_date1;

    if($diff >= $standard_payment)
    {
      $advanceCostData1 = array(
        'cost_for' => 3, //3 is for OC(apartment contract cost)
        'apartment_id' => $apartment_id,
        'oc_amount' => $first_advance_cost,
        'payment_date' => $new_date,
        'owner_user_id' => $this->input->post('owner'),
        'create_date' => date('Y-m-d'),
        'cost_code' => '1100',
      );
      $this->common_model->insert('cost', $advanceCostData1);
      $loop++;
    }
    else{
      break;
    }
  }

  $response = array(
    'status' => 1,
    'message' => lang('save_success'),
    'redirectto' => base_url_tr('apartment'),
  );
  //redirectAlert("apartment", lang('save_success'));
} else {
  $response = array(
    'status' => 0,
    'message' => lang('save_fail'),
  );
  //redirectAlert("apartment", lang('save_fail'));
}
}
echo json_encode($response);
}

/**
* This method has been used to delete an apartment
* @param integer $id (apartment ID)
* @author Jobayer Islam
*/
public function apartment_delete($id) {
  $delete = $this->apartment_model->apartment_delete($id);
  if ($delete) {
    redirectAlert("apartment", lang('delete_success'));
  }
}

/**
* This method has been used to insert common area of an apartment
* @param integer $apartment_id
* @param string $common_area_type
* @param integer $common_area_qty
* @author Jobayer Islam
*/
public function insert_common_area($apartment_id, $common_area_type, $common_area_qty) {
  foreach ($common_area_type as $key => $value) {

    $common_info = array(
      'apartment_id' => $apartment_id,
      'type' => $common_area_type[$key],
      'qty' => $common_area_qty[$key],
      'create_date' => date('Y-m-d H:i:s')
    );

    if ($common_info['type']) {
      $this->common_model->insert('common_area', $common_info);
    }
  }
}

/**
* This method has been used to insert private area of an apartment
* @param integer $apartment_id
* @param string $private_area_type
* @param integer $private_area_qty
* @author Jobayer Islam
*/
public function insert_private_area($apartment_id, $private_area_type, $private_area_qty) {
  foreach ($private_area_type as $key => $value) {
    $private_info = array(
      'apartment_id' => $apartment_id,
      'type' => $private_area_type[$key],
      'qty' => $private_area_qty[$key],
      'create_date' => date('Y-m-d H:i:s')
    );

    if ($private_info['type']) {
      $this->common_model->insert('private_area', $private_info);
    }
  }
}

/**
* This function has been used to show form for add booking
* @author Jobayer Islam
*/
public function add_booking() {
  $data['header']['title'] = 'Add Booking';
  $data['body']['apartments'] = $this->apartment_model->get_all_apartment_info();
  $this->load->model('user_model');
  $data['body']['tenants'] = $this->user_model->get_user_by_type(5); //5 = Tenant
  $data['body']['agents'] = $this->user_model->get_user_by_type(7); // 7 = Agent
  $data['body']['sorces'] = $this->cm->select_all_asc("source", "id");

  $data['header']['menu_base'] = "apartment_manager";
  $data['body']['page'] = "add_booking";
  makeTemplateAdmin($data);
}

/**
* This function has been used for saving booking info
* @author Jobayer Islam
*/
public function save_booking() {
  $rules = array(
    array(
      'field' => 'apartment_id',
      'label' => 'Property id',
      'rules' => 'required'
    ),
    array(
      'field' => 'rent_from',
      'label' => 'Rent From',
      'rules' => 'required|callback_check_room_availability'
    ),
    array(
      'field' => 'rent_to',
      'label' => 'Rent Duration',
      'rules' => 'required|callback_check_rent_duration'
    ),
    array(
      'field' => 'room_id',
      'label' => 'Room ',
      'rules' => 'required'
    ),
    array(
      'field' => 'payment_date',
      'label' => 'Date for monthly payment',
      'rules' => 'required|callback_check_payment_date'
    ),
    array(
      'field' => 'monthly_fee',
      'label' => 'Monthly Fee',
      'rules' => 'required'
    ),
    array(
      'field' => 'deposit_fee',
      'label' => 'Deposit Fee',
      'rules' => 'required'
    ),
    array(
      'field' => 'booking_fee',
      'label' => 'Booking Fee',
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
  } else {

    $tenant_list = $this->input->post('user_id');
    $rent_from = sqldate($this->input->post('rent_from'),"-","d-m-Y");
    $rent_to = sqldate($this->input->post('rent_to'),"-","d-m-Y");

    $booking_data = array();
    $booking_data['apartment_id'] = $this->input->post('apartment_id');
    $booking_data['rent_from'] = $rent_from;
    $booking_data['rent_to'] = $rent_to;
    $booking_data['room_id'] = $this->input->post('room_id');
    $booking_data['user_id'] = implode(",", $tenant_list);
    $booking_data['payment_date'] = $this->input->post('payment_date');
    $booking_data['monthly_fee'] = $this->input->post('monthly_fee');
    $booking_data['deposit_fee'] = $this->input->post('deposit_fee');
    $booking_data['booking_fee'] = $this->input->post('booking_fee');
    $booking_data['admin_fee'] = $this->input->post('admin_fee');
    $booking_data['contract_signed'] = $this->input->post('contract_signed');
    $booking_data['create_date'] = date('Y-m-d H:i:s');
    $booking_data['internal_external'] = $this->input->post('internal_external');
    if($this->input->post('internal_external') == "internal")
    {
      $booking_data['agent_id'] = $this->input->post('agent_id');
    }

    if($this->input->post('internal_external') == "external")
    {
      $booking_data['external'] = $this->input->post('external');
      $booking_data['source_id'] = $this->input->post('source_id');
    }



    // $booking_data = array(
    //     'apartment_id' => $this->input->post('apartment_id'),
    //     'rent_from' => $rent_from,
    //     'rent_to' => $rent_to,
    //     'room_id' => $this->input->post('room_id'),
    //     'user_id' => implode(",", $tenant_list),
    //     'payment_date' => $this->input->post('payment_date'),
    //     'monthly_fee' => $this->input->post('monthly_fee'),
    //     'deposit_fee' => $this->input->post('deposit_fee'),
    //     'booking_fee' => $this->input->post('booking_fee'),
    //     'contract_signed' => $this->input->post('contract_signed'),
    //     'create_date' => date('Y-m-d H:i:s'),
    // );

    $booking_id = $this->apartment_model->insert_booking($booking_data);

    //$total_rented_month = date_diff(new DateTime($rent_to), new DateTime($rent_from));
    $total_rented_month = $this->month_count_between_two_dates($rent_from,$rent_to);

    $day = $this->input->post('payment_date');
    $temp_payment_date = date("Y-m")."-".str_pad($day, 2, "0", STR_PAD_LEFT);

    $time=strtotime($rent_from);
    $month=date("m",$time);
    $year=date("Y",$time);
    $temp_payment_date = $year.'-'.$month.'-'.str_pad($day, 2, "0", STR_PAD_LEFT);

    $next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));

    if(strtotime($rent_from) > strtotime($temp_payment_date))
    {
      $rent_from_greater = true;
      //$next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));
      $installment_date = $rent_from;
      $total_rented_month = $total_rented_month;
    }
    else{
      $rent_from_greater = false;
      //$next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));
      $installment_date = $temp_payment_date;
    }
    //$installment_date = strtotime($temp_payment_date)>strtotime($rent_from)?$temp_payment_date:$next_month_date;
    $count = 0;

    $total_rented_month--;


    for ($i = 0; $i < $total_rented_month; $i++) {
      foreach ($tenant_list as $tenant) {
        if($rent_from_greater && $count == 0)
        {
          $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
          $next_installment_date = date('Y-m-d',$timestamp);
        }
        else if($rent_from_greater && $count > 0){
          $timestamp = strtotime("+$i months", strtotime($next_month_date)); // returns timestamp
          $next_installment_date = date('Y-m-d',$timestamp);
        }
        else{
          $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
          $next_installment_date = date('Y-m-d',$timestamp);
        }
        //calculate the installment date
        // $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
        // $next_installment_date = date('Y-m-d',$timestamp);

        if($i==0){
          $revenue_amount = $this->input->post('monthly_fee')*2;
          $first_two_months = 1;
        }
        else{
          $revenue_amount = $this->input->post('monthly_fee');
          $first_two_months = 0;
        }

        $installment_data = array(
          'booking_id' => $booking_id,
          'cost_for' => 2,
          'apartment_id' => $this->input->post('apartment_id'),
          'room_id' => $this->input->post('room_id'),
          'payment_date' => $next_installment_date,
          'tenant_user_id' => $tenant,
          'revenue_amount' => $revenue_amount,
          'create_date' =>  date('Y-m-d'),
          'cost_code' => '4000',
          'first_two_months' => $first_two_months
        );

        $this->apartment_model->insert_monthly_cost($installment_data);
        $count++;
      }
    }

    //insert deposit fee in cost table
    $owner_id = $this->cm->select_single_field('owner', 'apartment_detail', 'id', $this->input->post('apartment_id'));
    $costData = array(
      'cost_for' => 5, //5 is for cash in(deposit fee)
      'apartment_id' => $this->input->post('apartment_id'),
      'room_id' => $this->input->post('room_id'),
      'booking_id' => $booking_id,
      'revenue_amount' => $this->input->post('deposit_fee'),
      'payment_date' => $rent_from,
      'tenant_user_id' => $tenant,
      'create_date' => date('Y-m-d'),
      'cost_code' => '2102'
    );
    $this->common_model->insert('cost', $costData);

    //insert deposit fee in cost table

    $costData = array(
      'cost_for' => 6, //6 is for cash in(booking fee amount)
      'apartment_id' => $this->input->post('apartment_id'),
      'room_id' => $this->input->post('room_id'),
      'booking_id' => $booking_id,
      'revenue_amount' => $this->input->post('booking_fee'),
      'payment_date' => $rent_from,
      'tenant_user_id' => $tenant,
      'create_date' => date('Y-m-d'),
      'cost_code' => '4002'
    );
    $this->common_model->insert('cost', $costData);


    $costData = array(
      'cost_for' => 7, //7 initial admin fee
      'apartment_id' => $this->input->post('apartment_id'),
      'room_id' => $this->input->post('room_id'),
      'booking_id' => $booking_id,
      'revenue_amount' => $this->input->post('admin_fee'),
      'payment_date' => $rent_from,
      'tenant_user_id' => $tenant,
      'create_date' => date('Y-m-d'),
      'cost_code' => '4002'
    );
    $this->common_model->insert('cost', $costData);

    $response = array(
      'status' => 1,
      'payment_date' => $this->input->post('payment_date'),
      'message' => lang('save_success'),
      'redirectto' => base_url_tr('apartment/booking_list'),
    );
  }
  echo json_encode($response);
}


public function month_count_between_two_dates($rent_from,$rent_to) {
  /*$year1 = date('Y', strtotime($rent_from));
  $year2 = date('Y', strtotime($rent_to));

  $month1 = date('m', strtotime($rent_from));
  $month2 = date('m', strtotime($rent_to));

  $year_diff = $year2 - $year1;

  if ($year_diff > 0) {
  return ((12-$month1)+1)+$month2+(($year_diff-1)*12);
} else {
return ($month2 - $month1) + 1;
}*/

$date1 = $rent_from;
$date2 = $rent_to;

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

$value = (($year2 - $year1) * 12) + ($month2 - $month1);

if($year2-$year1>0) {
  $diff = $value+1;
} else {
  if($value == 0) {
    $diff = $value+1;
  } else {
    $diff = $value;
  }
}
return $diff;
}


/**
* callback function for form validation used
* @return boolean
*/
public function check_rent_duration() {

  $rent_from = $this->input->post("rent_from");
  $rent_to = $this->input->post("rent_to");

  $total_rented_month = date_diff(new DateTime($rent_from), new DateTime($rent_to));

  if($this->date_diff_now($rent_from, $rent_to) < 0) {
    $this->form_validation->set_message('check_rent_duration', "Please check carefully from and to date.");
    return FALSE;
  } else {
    if ($total_rented_month->days < 28) {
      $this->form_validation->set_message('check_rent_duration', "Please increase rent duration, you have selected less a month");
      return FALSE;
    } else {
      return TRUE;
    }
  }
}

public function check_payment_date()
{
  $rent_from = $this->input->post("rent_from");
  $rent_to = $this->input->post("rent_to");
  $payment_date = $this->input->post("payment_date");
  $d1 = date_parse_from_format("Y-m-d", $rent_from);
  $d2 = date_parse_from_format("Y-m-d", $rent_to);
  $pay_date1 = $d1["year"].'-'.sprintf("%02d",$d1["month"]).'-'.sprintf("%02d", $payment_date);
  $pay_date2 = $d2["year"].'-'.sprintf("%02d",$d2["month"]).'-'.sprintf("%02d", $payment_date);
  $flag1 = false;
  $flag2 = false;
  if($payment_date < $d1['day'])
  {
    //$flag1 = true;
    $flag1 = false; //according to new requirement
  }
  if($payment_date > $d2['day'])
  {
    $flag2 = true;
  }

  if($flag1 && $flag2)
  {
    $this->form_validation->set_message('check_payment_date', "PAYMENT FROM date is before FROM date and PAYMENT TO date is after TO date");
    return FALSE;
  }
  else if($flag1)
  {
    $this->form_validation->set_message('check_payment_date', "PAYMENT FROM date is before FROM date");
    return FALSE;
  }
  else if($flag2)
  {
    $this->form_validation->set_message('check_payment_date', "PAYMENT TO date is after TO date");
    return FALSE;
  }
  else{
    return TRUE;
  }
}

/**
* @author Razib Mahmud
*/
private function date_diff_now($from, $to){
  $now = strtotime($from); // or your date as well
  $your_date = strtotime($to);
  $datediff = $your_date-$now;

  return floor($datediff / (60 * 60 * 24));
  //$this->date_diff_now('2018-10-10', '2016-10-20');
}

/**
* callback function for form validation used
* @return boolean
*/
public function check_room_availability() {

  $apartment_id = $this->input->post("apartment_id");
  $room_id = $this->input->post("room_id");
  $rent_from = $this->input->post("rent_from");
  $rent_to = $this->input->post("rent_to");

  if($this->date_diff_now($rent_from, $rent_to) < 0 || $this->date_diff_now(date('Y-m-d'), $rent_from) < 0) {
    $this->form_validation->set_message('check_room_availability', "");
    return FALSE;
  } else {
    $room_availability = $this->apartment_model->check_room_availability($room_id, $rent_from, $rent_to);

    if (!$room_availability) {
      $this->form_validation->set_message('check_room_availability', "This room is not available now");
      return FALSE;
    } else {
      return TRUE;
    }
  }
}

/**
* callback function for form validation used
* @return boolean
*/
public function check_room_availability_edit() {

  $apartment_id = $this->input->post("apartment_id");
  $apartment_id_old = $this->input->post("old_apartment_id"); //added razib

  $room_id = $this->input->post("room_id");
  $room_id_old = $this->input->post("old_room_id"); //added razib

  $rent_from = $this->input->post("rent_from");
  $rent_to = $this->input->post("rent_to");
  $cur_rent_from = $this->input->post("rent_from");
  $cur_rent_to = $this->input->post("rent_to");

  if($apartment_id != $apartment_id_old || $room_id != $room_id_old){ //if change appartment id or room id
    $room_availability = $this->apartment_model->check_room_availability($room_id, $rent_from, $rent_to);
  } else {
    $room_availability = $this->apartment_model->check_room_availability_edit($room_id, $rent_from, $rent_to, $cur_rent_from, $cur_rent_to);
  }

  if (!$room_availability) {
    $this->form_validation->set_message('check_room_availability_edit', "This room is not available now");
    return FALSE;
  } else {
    return TRUE;
  }
}

/**
* This function has been used to show form for add booking
* @author Jobayer Islam
*/
public function get_room_dropdown() {
  $apartment_id = $this->input->post('apartment_id');

  echo "<option value=''>" . 'Select Room' . "</option>";

  if ($apartment_id) {
    $room_list = $this->apartment_model->get_rooms_in_apartment($apartment_id);

    if ($room_list) {

      foreach ($room_list as $room) {
        $room_type = $room['room_type'] == 1 ? ' (Single)' : ' (Double)';
        //echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - " . $room_type . "</option>";
        echo "<option value='" . $room['id'] . "'>" . $room['id'] . $room_type."</option>";
      }
    }
  }
}



public function booking_list() {
  $data['body']['booking_list'] = $this->apartment_model->get_all_booking_info();
  $data['header']['title'] = 'Booking List';
  $data['header']['menu_base'] = "booking_list";
  $data['body']['page'] = "booking_list";
  $data['body']['user_type']=$this->session->userdata('userdata')['user_type'];
  makeTemplateAdmin($data);
}

public function booking_file_upload($booking_id) {
  $response = uploadFile("myfile", "", "agreement_temp/");
  $file_name = $response['upload_data']['file_name'];
  $orig_name = $response['upload_data']['orig_name'];
  $this->apartment_model->booking_file_insert($file_name, $orig_name, $booking_id);
  echo json_encode($response);
}

public function booking_file_upload_sales($booking_id) {

  $response = uploadFile("salesFile","", "agreement_temp/");
  $file_name = $response['upload_data']['file_name'];
  $orig_name = $response['upload_data']['orig_name'];
  $description=$this->input->post('upload_description');
  $date=date_format(date_create($this->input->post('upload_date')),"Y-m-d H:i:s");
  $this->apartment_model->booking_file_insert_sales($file_name, $orig_name,$booking_id,$description,$date);
  echo json_encode($response);
}

/**
* This function has been used to show form for add booking
* @author Jobayer Islam
*/
public function edit_booking($id) {
  $data['header']['title'] = 'Edit Booking';
  $data['body']['apartments'] = $this->apartment_model->get_all_apartment_info();
  $data['body']['booking_detail'] = $this->apartment_model->get_booking_detail_by_id($id);
  $this->load->model('user_model');
  $data['body']['tenants'] = $this->user_model->get_user_by_type(5);
  $data['body']['agents'] = $this->user_model->get_user_by_type(7); // 7 = Agent
  $data['body']['sorces'] = $this->cm->select_all_asc("source", "id");
  $data['body']['booked_tenants'] = explode(',', $data['body']['booking_detail'][0]['user_id']);
  $data['body']['room_list'] = $this->apartment_model->get_rooms_in_apartment($data['body']['booking_detail'][0]['apartment_id']);

  $data['body']['room_drop_down'] = "<option value=''>" . 'Select Room' . "</option>";

  if ($data['body']['room_list']) {

    foreach ($data['body']['room_list'] as $room) {
      $room_type = $room['room_type'] == 1 ? 'Single Type' : 'Double Type';
      $selected = $data['body']['booking_detail'][0]['room_id'] == $room['id'] ? 'selected' : '';
      $data['body']['room_drop_down'] .= "<option value='" . $room['id'] . "'" . " $selected>" . $room['id'] . " - " . $room_type . "</option>";
    }
  }

  $data['header']['menu_base'] = "Booking";
  $data['body']['page'] = "edit_booking";
  makeTemplateAdmin($data);
}

/**
* This function has been used for saving booking info after editing
* @author Jobayer Islam
*/
public function save_edit_booking() {
  $rules = array(
    array(
      'field' => 'apartment_id',
      'label' => 'Property id',
      'rules' => 'required'
    ),
    array(
      'field' => 'rent_from',
      'label' => 'Rent From',
      'rules' => 'required|callback_check_room_availability_edit'
    ),
    array(
      'field' => 'rent_to',
      'label' => 'Rent Duration',
      'rules' => 'required|callback_check_rent_duration'
    ),
    array(
      'field' => 'room_id',
      'label' => 'Room ',
      'rules' => 'required'
    ),
    array(
      'field' => 'payment_date',
      'label' => 'Date for monthly payment',
      'rules' => 'required'
    ),
    array(
      'field' => 'monthly_fee',
      'label' => 'Monthly Fee',
      'rules' => 'required'
    ),
    array(
      'field' => 'deposit_fee',
      'label' => 'Deposit Fee',
      'rules' => 'required'
    ),
    array(
      'field' => 'booking_fee',
      'label' => 'Booking Fee',
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
  } else {
    $rent_from = $this->input->post('rent_from');
    $rent_to = $this->input->post('rent_to');
    $tenant_list = $this->input->post('user_id');
    $booking_id = $this->input->post('id');

    $booking_data = array();
    $booking_data['apartment_id'] = $this->input->post('apartment_id');
    $booking_data['rent_from'] = sqldate($this->input->post('rent_from'),"-","d-m-Y");
    $booking_data['rent_to'] = sqldate($this->input->post('rent_to'),"-","d-m-Y");
    $booking_data['room_id'] = $this->input->post('room_id');
    $booking_data['user_id'] = implode(",", $tenant_list);
    $booking_data['payment_date'] = $this->input->post('payment_date');
    $booking_data['monthly_fee'] = $this->input->post('monthly_fee');
    $booking_data['deposit_fee'] = $this->input->post('deposit_fee');
    $booking_data['booking_fee'] = $this->input->post('booking_fee');
    $booking_data['contract_signed'] = $this->input->post('contract_signed');
    $booking_data['create_date'] = date('Y-m-d H:i:s');
    $booking_data['internal_external'] = $this->input->post('internal_external');
    if($this->input->post('internal_external') == "internal")
    {
      $booking_data['agent_id'] = $this->input->post('agent_id');
    }

    if($this->input->post('internal_external') == "external")
    {
      $booking_data['external'] = $this->input->post('external');
      $booking_data['source_id'] = $this->input->post('source_id');
    }

    // $booking_data = array(
    //     'apartment_id' => $this->input->post('apartment_id'),
    //     'rent_from' => sqldate($this->input->post('rent_from'),"-","d-m-Y"),
    //     'rent_to' => sqldate($this->input->post('rent_to'),"-","d-m-Y"),
    //     'room_id' => $this->input->post('room_id'),
    //     'user_id' => implode(",", $tenant_list),
    //     'payment_date' => $this->input->post('payment_date'),
    //     'monthly_fee' => $this->input->post('monthly_fee'),
    //     'deposit_fee' => $this->input->post('deposit_fee'),
    //     'booking_fee' => $this->input->post('booking_fee'),
    //     'contract_signed' => $this->input->post('contract_signed'),
    //     'create_date' => date('Y-m-d H:i:s')
    // );

    $this->apartment_model->update_booking($booking_id, $booking_data);

    //$total_rented_month = date_diff(new DateTime($booking_data['rent_to']), new DateTime($booking_data['rent_from']));
    $total_rented_month = $this->month_count_between_two_dates($rent_from,$rent_to);

    $current_installment_info = $this->apartment_model->get_current_installment_info($booking_id);

    $this->apartment_model->remove_unpaid_installment_info($booking_id);
    $total_paid = $this->apartment_model->get_total_paid_installment_info($booking_id);

    for ($i = $total_paid; $i < $total_rented_month; $i++) {
      foreach ($tenant_list as $key => $tenant) {
        $installment_data = array(
          'booking_id' => $booking_id,
          'cost_for' => 2,
          'apartment_id' => $this->input->post('apartment_id'),
          'room_id' => $this->input->post('room_id'),
          'payment_date' => $this->input->post('payment_date'),
          'tenant_user_id' => $tenant,
          'revenue_amount' => $this->input->post('monthly_fee'),
          'cost_code' => '4000'
        );

        $this->apartment_model->insert_monthly_cost($installment_data);
      }
    }


    //insert deposit fee in cost table
    $costData = array(
      'apartment_id' => $this->input->post('apartment_id'),
      'room_id' => $this->input->post('room_id'),
      'revenue_amount' => $this->input->post('deposit_fee'),
      'payment_date' => $rent_from,
      'cost_code' => '2102'
    );

    $this->cm->update_2_where('cost', $costData, 'cost_for', 5, 'booking_id', $booking_id);

    //insert deposit fee in cost table
    $costData = array(
      'apartment_id' => $this->input->post('apartment_id'),
      'room_id' => $this->input->post('room_id'),
      'revenue_amount' => $this->input->post('booking_fee'),
      'payment_date' => $rent_from,
      'cost_code' => '4002'
    );
    $this->cm->update_2_where('cost', $costData, 'cost_for', 6, 'booking_id', $booking_id);

    $response = array(
      'status' => 1,
      'message' => lang('save_success'),
      'redirectto' => base_url_tr('apartment/booking_list'),
    );
  }
  echo json_encode($response);
}

/**
* This method has been used to delete an apartment booking
* @param integer $id (apartment ID)
* @author Jobayer Islam
*/
public function delete_booking($id) {
  $delete = $this->apartment_model->delete_booking($id);
  if ($delete) {
    redirectAlert("apartment/booking_list", lang('delete_success'));
  }
}

public function download_booking($id) {
  $booking = $this->apartment_model->get_pdf_booking_detail_by_id($id);

  /*echo "<pre>";
  print_r($booking);
  exit;*/

  $this->agreement_pdf($booking);
}

/**
* this function used for generated booking agreement pdf
* @author Razib Mahmud
* @param $id booking id
*/
public function agreement_pdf($booking) {
  if($booking) {
    $data['booking'] = $booking;
    //this the the PDF filename that user will get to download
    $pdfFilePath = "Booking_".$booking['id']."_Agreement.pdf";

    //load mPDF library
    $this->load->library('m_pdf');

    //page 01
    $html_01 = $this->load->view('pdfpage/01', $data, true);
    $this->m_pdf->pdf->AddPage('P'); // margin footer
    $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

    //page 02
    $html_02 = $this->load->view('pdfpage/02', $data, true);
    $this->m_pdf->pdf->AddPage('P'); // margin footer
    $this->m_pdf->pdf->WriteHTML($html_02);
    //echo $html_01.$html_02;
    //offer it to user via browser download! (The PDF won't be saved on your server HDD)
    $this->m_pdf->pdf->Output($pdfFilePath, "D");
  }
}

public function booking_detail($id)
{
  $data['header']['title'] = 'Booking Detail';
  $data['body']['booking_detail'] = $this->apartment_model->get_booking_detail_by_id($id);
  $this->load->model('user_model');
  $data['body']['tenants'] = $this->user_model->get_user_by_type(5);
  $data['body']['booked_tenants'] = explode(',', $data['body']['booking_detail'][0]['user_id']);

  $data['header']['menu_base'] = "Booking";
  $data['body']['page'] = "booking_show_detail";
  $data['body']['other_files']=$this->apartment_model->get_booking_attached_files($id);
  makeTemplateAdmin($data);
}

public function booking_detail_delete($id, $booking_id) {
  $file_details = $this->apartment_model->get_attached_file($id);
  if($file_details) {
    $uploaded_file_id = $file_details['uploaded_file_id'];
    $file_name = $file_details['file_name'];

    $this->db->where('uploaded_file_id', $uploaded_file_id);
    $this->db->delete('uploaded_sales_files');
    @unlink('uploads/agreement_file/'.$file_name);

    $response = array(
      'status' => 1,
      'message' => lang('delete_success'),
      'redirectto' => base_url_tr('apartment/booking_detail/'.$booking_id)
    );

    echo json_encode($response);
  }
}

public function apartment_allotment(){
  modules::load('reports')->apartment_allotment();
}


public function check_in() {
  $data['body']['check_in_list'] = $this->apartment_model->get_all_bookings("in");
  $data['header']['title'] = 'Check IN List';
  $data['header']['menu_base'] = "Check IN";
  $data['body']['page'] = "check_in_list";
  makeTemplateAdmin($data);
}

public function check_out() {
  $data['body']['check_out_list'] = $this->apartment_model->get_all_bookings("out");
  $data['header']['title'] = 'Check OUT List';
  $data['header']['menu_base'] = "Check OUT";
  $data['body']['page'] = "check_out_list";
  makeTemplateAdmin($data);
}

public function check_in_licensee_key()
{
  $licensee_key = $this->input->post('licensee_key');
  $booking_id = $this->input->post('booking_id');
  $data = array();
  //$data['licensee_key'] = $licensee_key; //seems like "licensee_key" and "licensee_key_return_time_location" are same
  $data['licensee_key_return_time_location'] = $licensee_key;
  $this->cm->update('apartment_booked_list', $data, 'id', $booking_id);
  echo $licensee_key;
}

public function check_in_payment()
{
  $payment_received = $this->input->post('payment_received');
  $booking_id = $this->input->post('booking_id');
  $data = array();
  $data['payment_received'] = $payment_received;
  $this->cm->update('apartment_booked_list', $data, 'id', $booking_id);
  echo $payment_received;
}

public function check_in_payment_comment()
{
  $payment_comment = $this->input->post('payment_comment');
  $booking_id = $this->input->post('booking_id');
  $data = array();
  $data['payment_comment'] = $payment_comment;
  $this->cm->update('apartment_booked_list', $data, 'id', $booking_id);
  echo $payment_comment;
}

public function check_out_time_location()
{
  $licensee_key_return_time_location = $this->input->post('licensee_key_return_time_location');
  $booking_id = $this->input->post('booking_id');
  $data = array();
  $data['licensee_key_return_time_location'] = $licensee_key_return_time_location;
  $this->cm->update('apartment_booked_list', $data, 'id', $booking_id);
  echo $licensee_key_return_time_location;
}

public function renewal_list() {
  $data = array();
  $data['body']['renewal_list'] = $this->apartment_model->get_all_renewal_info();
  $data['header']['title'] = 'Renewal List';
  $data['header']['menu_base'] = "booking_list";
  $data['body']['page'] = "renewal_list";
  $data['body']['user_type']=$this->session->userdata('userdata')['user_type'];
  makeTemplateAdmin($data);
}

public function send_renewal_reminder_email(){
  $booking_id = $this->input->post("booking_id");

  $data = array();
  $booking_details = $this->apartment_model->get_booking_details($booking_id);
  $data["booking_details"] = $booking_details;

  $pdfFileName = "Booking_".$booking_id."_Renewal_Reminder.pdf";

  //load mPDF library
  $this->load->library('m_pdf');
  $html = $this->load->view('pdfpage/renewal_request_letter', $data, true);
  $this->m_pdf->pdf->WriteHTML($html); //generate the PDF!

  $pdfFilePath = FCPATH."uploads/".$pdfFileName;
  $this->m_pdf->pdf->Output($pdfFilePath, "F");

  //now, send the email
  $attach_file_path = base_url()."/uploads/".$pdfFileName;
  $this->load->library("email_manager");
  $status = $this->email_manager->send_email($booking_details["email"],"Renewal Letter","text text text","jamiulh@gmail.com", $attach_file_path);

  sleep(1);

  if($status){
    $update_data = array();
    $update_data["reminder_email_sent"] = "1";
    $this->db->where("id",$booking_id);
    $this->db->update("apartment_booked_list",$update_data);
  }
}

public function booking_renewal() {
  $booking_id = $this->input->post("booking_id");
  $booking_details = $this->apartment_model->get_booking_details($booking_id);
  $total_agency_fee = 60;

  $data = array();
  $data["apartment_id"] = $booking_details["apartment_id"];
  $data["rent_from"] = sqldate($this->input->post("new_rent_from"),"-","d-m-Y");
  $data["rent_to"] = sqldate($this->input->post("new_rent_to"),"-","d-m-Y");
  $data["room_id"] = $booking_details["room_id"];
  $data["user_id"] = $booking_details["user_id"];
  $data["payment_date"] = $booking_details["payment_date"];
  $data["monthly_fee"] = $this->input->post("new_monthly_fee");
  $data["deposit_fee"] = $booking_details["deposit_fee"];
  $data["booking_fee"] = $total_agency_fee;//$booking_details["booking_fee"];
  $data["contract_signed"] = $booking_details["contract_signed"];
  $data["keys_in_office"] = $booking_details["keys_in_office"];
  $data["licensee_key"] = $booking_details["licensee_key"];
  $data["payment_received"] = $booking_details["payment_received"];
  $data["payment_comment"] = $booking_details["payment_comment"];
  $data["licensee_key_return_time_location"] = $booking_details["licensee_key_return_time_location"];
  $data["agreement_file"] = $booking_details["agreement_file"];
  $data["orig_file_name"] = $booking_details["orig_file_name"];
  $data["create_date"] = $booking_details["create_date"];
  $data["update_date"] = $booking_details["update_date"];

  $renewBookedId = $this->db->insert("apartment_booked_list",$data);

  $param['booking_id'] = $renewBookedId;
  $param['tenant_list'] = $booking_details["user_id"];
  $param['rent_from'] =   sqldate($this->input->post("new_rent_from"),"-","d-m-Y");
  $param['rent_to'] =   sqldate($this->input->post("new_rent_to"),"-","d-m-Y");
  $param['payment_date']  =   $booking_details["payment_date"];
  $param['apartment_id'] = $booking_details["apartment_id"];
  $param['room_id'] = $booking_details["room_id"];
  $param['monthly_fee'] = $this->input->post("new_monthly_fee");
  $param['deposit_fee'] = $booking_details["deposit_fee"];
  $param['booking_fee'] = $total_agency_fee;
  $this->renew_to_cost_diposit($param);

  //now, update the renewal status
  $update_data = array();
  $update_data["deposit_fee"] = 0;
  $update_data["renewal_status"] = "1";
  $this->db->where("id",$booking_id);

  $this->db->update("apartment_booked_list",$update_data);
}

private function renew_to_cost_diposit($param) {
  $tenant_list = explode(',', $param['tenant_list']);
  $rent_from = $param['rent_from'];
  $rent_to = $param['rent_to'];
  $booking_id = $param['booking_id'];
  $apartment_id = $param['apartment_id'];
  $room_id    =   $param['room_id'];
  $monthly_fee    =   $param['monthly_fee'];
  $deposit_fee    =   $param['deposit_fee'];
  $booking_fee    =   $param['booking_fee'];

  $total_rented_month = $this->month_count_between_two_dates($rent_from,$rent_to);

  $day = $param['payment_date'];
  $temp_payment_date = date("Y-m")."-".str_pad($day, 2, "0", STR_PAD_LEFT);

  $time=strtotime($rent_from);
  $month=date("m",$time);
  $year=date("Y",$time);
  $temp_payment_date = $year.'-'.$month.'-'.str_pad($day, 2, "0", STR_PAD_LEFT);

  $next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));

  if(strtotime($rent_from) > strtotime($temp_payment_date))
  {
    $rent_from_greater = true;
    //$next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));
    $installment_date = $rent_from;
    $total_rented_month = $total_rented_month;
  }
  else{
    $rent_from_greater = false;
    //$next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));
    $installment_date = $temp_payment_date;
  }
  //$installment_date = strtotime($temp_payment_date)>strtotime($rent_from)?$temp_payment_date:$next_month_date;
  $count = 0;
  for ($i = 0; $i < $total_rented_month; $i++) {
    foreach ($tenant_list as $tenant) {
      if($rent_from_greater && $count == 0)
      {
        $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
        $next_installment_date = date('Y-m-d',$timestamp);
      }
      else if($rent_from_greater && $count > 0){
        $timestamp = strtotime("+$i months", strtotime($next_month_date)); // returns timestamp
        $next_installment_date = date('Y-m-d',$timestamp);
      }
      else{
        $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
        $next_installment_date = date('Y-m-d',$timestamp);
      }
      //calculate the installment date
      // $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
      // $next_installment_date = date('Y-m-d',$timestamp);

      $installment_data = array(
        'booking_id' => $booking_id,
        'cost_for' => 2,
        'apartment_id' => $apartment_id,
        'room_id' => $room_id,
        'payment_date' => $next_installment_date,
        'tenant_user_id' => $tenant,
        'revenue_amount' => $monthly_fee,
        'create_date' =>  date('Y-m-d'),
        'cost_code' => '4000'
      );

      $this->apartment_model->insert_monthly_cost($installment_data);
      $count++;
    }
  }

  //insert deposit fee in cost table
  $owner_id = $this->cm->select_single_field('owner', 'apartment_detail', 'id', $apartment_id);
  $costData = array(
    'cost_for' => 5, //5 is for cash in(deposit fee)
    'apartment_id' => $apartment_id,
    'room_id' => $room_id,
    'booking_id' => $booking_id,
    'revenue_amount' => $deposit_fee,
    'payment_date' => $rent_from,
    'owner_user_id' => $owner_id,
    'create_date' => date('Y-m-d'),
    'cost_code' => '2102'
  );
  $this->common_model->insert('cost', $costData);

  //insert cash fee in cost table
  $costData = array(
    'cost_for' => 6, //6 is for cash in(booking fee amount)
    'apartment_id' => $apartment_id,
    'room_id' => $room_id,
    'booking_id' => $booking_id,
    'revenue_amount' => $booking_fee,
    'payment_date' => $rent_from,
    'owner_user_id' => $owner_id,
    'create_date' => date('Y-m-d'),
    'cost_code' => '4002'
  );
  $this->common_model->insert('cost', $costData);
}

public function send_pdf_contract_email() {
  $booking_id = $this->input->post("booking_id");
  $booking = $this->apartment_model->get_pdf_booking_detail_by_id($booking_id);

  $data['booking'] = $booking;
  //this the the PDF filename that user will get to download
  $pdfFileName = "Booking_".$booking['id']."_Agreement.pdf";

  //load mPDF library
  $this->load->library('m_pdf');

  //page 01
  $html_01 = $this->load->view('pdfpage/01', $data, true);
  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

  //page 02
  $html_02 = $this->load->view('pdfpage/02', $data, true);
  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_02);

  $pdfFilePath = FCPATH."uploads/".$pdfFileName;
  $this->m_pdf->pdf->Output($pdfFilePath, "F");

  //now, send the email
  $attach_file_path = base_url()."/uploads/".$pdfFileName;
  $this->load->library("email_manager");
  $this->email_manager->send_email($booking["email"],"Booking Agreement","text text text","jamiulh@gmail.com", $attach_file_path);

  echo "success";


}

public function booking_move_out()
{
  $booking_id = $this->input->post("booking_id");

  $update_data = array();
  $update_data["moved_out"] = "1";
  $this->db->where("id",$booking_id);
  $this->db->update("apartment_booked_list",$update_data);

  echo "success";
}

public function update_booking_comments()
{
  $booking_id = $this->input->post("booking_id");

  $update_data = array();
  $update_data["comments"] = $this->input->post("comments");
  $this->db->where("id",$booking_id);
  $this->db->update("apartment_booked_list",$update_data);

  echo "success";
}

public function user_passport_upload() //user here = tenant
{
  $response = uploadFile("myfile","", "user_file/");
  $user_id = $this->input->post("user_id");
  $file_name = $response["upload_data"]["file_name"];

  $data = array();
  $data["passport_file"] = $file_name;
  $this->db->where("id",$user_id);
  $this->db->update("user",$data);

  echo "ok";
}

public function user_passport_download($user_id)
{
  $file_name = $this->cm->select_single_field("passport_file", "user", "id", $user_id);
  $ext = end(explode('.', $file_name));

  $this->load->helper('download');
  force_download("passport.".$ext, file_get_contents("./uploads/user_file/".$file_name));
}

//education program file upload
public function education_program_file_upload() //user here = tenant
{
  $response = uploadFile("myfile","", "user_file/");
  $user_id = $this->input->post("user_id");
  $file_name = $response["upload_data"]["file_name"];

  $data = array();
  $data["education_program_file"] = $file_name;
  $this->db->where("id",$user_id);
  $this->db->update("user",$data);

  echo "ok";
}

//education program file download
public function education_program_file_download($user_id)
{
  $file_name = $this->cm->select_single_field("education_program_file", "user", "id", $user_id);
  $ext = end(explode('.', $file_name));

  $this->load->helper('download');
  force_download("education_program.".$ext, file_get_contents("./uploads/user_file/".$file_name));
}

//work reference file upload
public function work_reference_file_upload() //user here = tenant
{
  $response = uploadFile("myfile","", "user_file/");
  $user_id = $this->input->post("user_id");
  $file_name = $response["upload_data"]["file_name"];

  $data = array();
  $data["work_reference_file"] = $file_name;
  $this->db->where("id",$user_id);
  $this->db->update("user",$data);

  echo "ok";
}

//work reference file download
public function work_reference_file_download($user_id)
{
  $file_name = $this->cm->select_single_field("work_reference_file", "user", "id", $user_id);
  $ext = end(explode('.', $file_name));

  $this->load->helper('download');
  force_download("work_reference.".$ext, file_get_contents("./uploads/user_file/".$file_name));
}

public function send_check_out_formality_email(){
  $booking_id = $this->input->post("booking_id");

  $data = array();
  $booking_details = $this->apartment_model->get_booking_details($booking_id);
  $data["booking_details"] = $booking_details;

  $pdfFileName = "Check_Out_Formalities.pdf";

  //load mPDF library
  $this->load->library('m_pdf');
  $html = $this->load->view('pdfpage/check_out_formalities', $data, true);
  $this->m_pdf->pdf->WriteHTML($html); //generate the PDF!

  $pdfFilePath = FCPATH."uploads/".$pdfFileName;
  $this->m_pdf->pdf->Output($pdfFilePath, "F");

  //now, send the email
  $attach_file_path = base_url()."/uploads/".$pdfFileName;
  $this->load->library("email_manager");
  $status = $this->email_manager->send_email($booking_details["email"],"Check Out Formalities","text text text","jamiulh@gmail.com", $attach_file_path);

  sleep(1);

  if($status){
    $update_data = array();
    $update_data["formality_email_sent"] = "1";
    $this->db->where("id",$booking_id);
    $this->db->update("apartment_booked_list",$update_data);
  }
}


public function deposit_list() {

  $deposit_list = $this->apartment_model->get_all_deposit_info();

  $outstanding_total = array();

  foreach($deposit_list as $value) {
    $user_id = $value["user_id"];

    $outgoing_cost_invoices = $this->apartment_model->get_invoices1_by_user_id($user_id);
    $installment_invoices = $this->apartment_model->get_invoices2_by_user_id($user_id);

    $total = 0;
    foreach($outgoing_cost_invoices as $value) {
      $total = $total + $value["invoice_amount"];
    }

    foreach($installment_invoices as $value) {
      $total = $total + $value["invoice_amount"];
    }

    $outstanding_total[$user_id] = $total;
  }



  $data = array();
  $data['body']['deposit_list'] = $deposit_list;
  $data['body']['outstanding_total'] = $outstanding_total;
  $data['header']['title'] = 'Deposits';
  $data['header']['menu_base'] = "cash";
  $data['body']['page'] = "deposit_list";
  makeTemplateAdmin($data);
}


public function docusign_email_send($booking_id) {

  $booking = $this->apartment_model->get_pdf_booking_detail_by_id($booking_id);

  $data['booking'] = $booking;
  //this the the PDF filename that user will get to download
  $pdfFileName = "Booking_".$booking['id']."_Agreement.pdf";

  //load mPDF library
  $this->load->library('m_pdf');

  //page 01
  $html_01 = $this->load->view('pdfpage/01', $data, true);
  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

  //page 02
  $html_02 = $this->load->view('pdfpage/02', $data, true);
  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_02);

  $pdfFilePath = FCPATH."uploads/".$pdfFileName;
  $this->m_pdf->pdf->Output($pdfFilePath, "F");

  //now, send the contract thru DocuSign for signature
  $attach_file_path = base_url()."uploads/".$pdfFileName;
  $this->load->library("docusign");
  $recipient_name = $booking["name"]." ".$booking["family_name"];
  $status = $this->docusign->signatureRequest($booking["email"],$recipient_name,$attach_file_path,$pdfFileName);

  if($status != "0") {
    $result = json_decode($status,true);

    /* this is the sample output of $result variable
    Array
    (
    [envelopeId] => 45eeff43-b38f-4444-bd0b-738cda4d0da5
    [status] => sent
    [statusDateTime] => 2018-03-16T09:07:31.2100000Z
    [uri] => /envelopes/45eeff43-b38f-4444-bd0b-738cda4d0da5
    )
    */

    $data_docusign = array();
    $data_docusign["envelopeId"] = $result["envelopeId"];
    $data_docusign["status"] = $result["status"];
    $data_docusign["statusDateTime"] = $result["statusDateTime"];
    $data_docusign["booking_id"] = $booking['id'];

    $this->db->insert("docusign_log",$data_docusign);

    //change to status signed_by_pml = 1
    $this->db->where('id', $booking['id']);
    $this->db->update('apartment_booked_list', array('signed_by_pml' => 1));
  }


  $data['header']['title'] = 'Document Sent';
  $data['header']['menu_base'] = "booking_list";
  $data['body']['status'] = $status;
  $data['body']['page'] = "docusign_sent";
  makeTemplateAdmin($data);

}


public function checkout_report_upload() //user here = tenant
{
  $response = uploadFile("myfile","", "checkout_report/");
  $booking_id = $this->input->post("booking_id");
  $file_name = $response["upload_data"]["file_name"];

  $data = array();
  $data["checkout_report_file"] = $file_name;
  $this->db->where("id",$booking_id);
  $this->db->update("apartment_booked_list",$data);

  echo "ok";
}

public function checkout_report_download($booking_id)
{
  $file_name = $this->cm->select_single_field("checkout_report_file", "apartment_booked_list", "id", $booking_id);
  $ext = end(explode('.', $file_name));

  $this->load->helper('download');
  force_download("checkoutReport.".$ext, file_get_contents("./uploads/checkout_report/".$file_name));
}


public function send_notification_to_accounting_department(){
  $booking_id = $this->input->post("booking_id");
  $booking_details = $this->apartment_model->get_single_deposit_info($booking_id);

  $email_body = "Deposit Refund Deadline: ".mydate(date('Y-m-d',date(strtotime("+14 day", strtotime($booking_details["rent_to"])))),"-")."<br>"
  ."Deposit: ".$booking_details['deposit_fee']."<br>"
  ."Outstanding Invoices: ".$booking_details['deposit_fee']."<br>"
  ."Licensee: ".$booking_details['name']." ".$booking_details['family_name']."<br>"
  ."Room and Address: ".$booking_details['apartment_id']." (".$booking_details['address'].")"."<br>";


  //now, send the email
  $this->load->library("email_manager");
  //$email_aadress = "account@pmlservices.co.uk";
  $status = $this->email_manager->send_email("account@pmlservices.co.uk","Deposit",$email_body,"jamiulh@gmail.com");

  sleep(1);

  if($status){
    $update_data = array();
    $update_data["accounting_notify_status"] = "1";
    $this->db->where("id",$booking_id);
    $this->db->update("apartment_booked_list",$update_data);
  }
}


public function create_credit_note($booking_id)
{
  $booking_details = $this->apartment_model->get_single_deposit_info($booking_id);

  $user_id = $booking_details["user_id"];

  $outgoing_cost_invoices = $this->apartment_model->get_invoices1_by_user_id($user_id);
  $installment_invoices = $this->apartment_model->get_invoices2_by_user_id($user_id);

  $data['booking_details'] = $booking_details;
  $data['outgoing_cost_invoices'] = $outgoing_cost_invoices;
  $data['installment_invoices'] = $installment_invoices;

  //this the the PDF filename that user will get to download
  $pdfFilePath = "Credit_Note";

  //load mPDF library
  $this->load->library('m_pdf');

  //page 01
  $html_01 = $this->load->view('pdfpage/credit_note', $data, true);
  $this->m_pdf->pdf->AddPage('P'); // margin footer
  $this->m_pdf->pdf->WriteHTML($html_01); //generate the PDF!

  //offer it to user via browser download! (The PDF won't be saved on your server HDD)
  $this->m_pdf->pdf->Output($pdfFilePath, "D");
}




public function create_send_invoice($booking_id)
{
  $first_two_months = $this->apartment_model-> get_first_two_months($booking_id)[0];#get two first months
  $deposit = $this->apartment_model->get_booking_cost($booking_id,5)[0];#get deposit

  $booking_details = $this->cm->select_single_row("apartment_booked_list", "id", $booking_id);
  print_r($booking_details);
  $email = getUser($booking_details['user_id'], "email");
  // For Invoice A
  $last_A_invoice_serial = $this->apartment_model->select_last_invoice_serial();
  $invoice_A_amount = $first_two_months['revenue_amount'] + $deposit['revenue_amount'];
  $invoice_A_data = array(
    "invoice_of" => 2,
    "invoice_type" => 0,
    "invoice_serial" => $last_A_invoice_serial+1,
    "invoice_year" => date("Y"),
    "invoice_no" => "A".($last_A_invoice_serial+1)."-".date("Y"),
    "invoice_amount" => $invoice_A_amount,
    "create_date" => date("Y-m-d"),
    "user_id"=>$booking_details['user_id'],
    "payment_due_date"=>$booking_details['rent_from']
  );

  $invoice_A_id = $this->cm->insert("invoice", $invoice_A_data);

  $data = [];
  $data['invoice_id'] = $invoice_A_id;
  $this->cm->update("cost", $data, "id", $first_two_months['id']);#associated invoice id to first two months
  $this->cm->update("cost",$data,"id",$deposit['id']);#associated invoice id to deposit



  $invoice_A_details = $this->cm->select_single_row("invoice", "id", $invoice_A_id);
  $invoice_A_pdf['booking_details'] = $booking_details;
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

  // For Invoice B

$admin_fee =  $this->apartment_model->get_booking_cost($booking_id,7)[0];#get admin fee
$booking_fee = $this->apartment_model->get_booking_cost($booking_id,6)[0];#get booking fee

  $invoice_B_amount = $booking_fee['revenue_amount'] + $admin_fee['revenue_amount'] + ((20 / 100) * $admin_fee['revenue_amount']);
  $last_B_invoice_serial = $this->apartment_model->select_last_invoice_serial();

  $last_invoice_number = $this->apartment_model->select_last_invoice_number();
  $invoice_B_data = array(
    "invoice_of" => 4,
    "invoice_type" => 1,
    "invoice_serial" => $last_B_invoice_serial+1,
    "invoice_year" => date("Y"),
    "invoice_no" => "B".($last_invoice_number+1)."-".date("Y"),
    "invoice_amount" => $invoice_B_amount,
    "create_date" => date("Y-m-d"),
    "user_id"=>$booking_details['user_id'],
    "payment_due_date"=>$booking_details['rent_from']
  );
  $invoice_B_id = $this->cm->insert("invoice", $invoice_B_data);

  $data = [];
  $data['invoice_id'] = $invoice_B_id;
  $this->cm->update("cost", $data, "id", $admin_fee['id']);#associated invoice id to admin fee
  $this->cm->update("cost",$data,"id",$booking_fee['id']);#associated invoice id to booking fee

  $invoice_B_details = $this->cm->select_single_row("invoice", "id", $invoice_B_id);
  $invoice_B_pdf['booking_details'] = $booking_details;
  $invoice_B_pdf['invoice_no'] = $invoice_B_details['invoice_no'];
  $invoice_B_pdf['invoice_amount'] = $invoice_B_details['invoice_amount'];

  if($invoice_B_id)
  {
    $pdfFileName = "Invoice". $invoice_B_pdf['invoice_no'].".pdf";
    $this->load->library('m_pdf');
    $objPHPpdf = new mPDF();
    $html = $this->load->view('pdfpage/invoice_b', $invoice_B_pdf, true);
    $objPHPpdf->WriteHTML($html); //generate the PDF!

    $pdfFilePath = FCPATH."uploads/".$pdfFileName;
    $objPHPpdf->Output($pdfFilePath, "F");

    $attach_file_path = base_url()."/uploads/".$pdfFileName;

    $status = $this->email_manager->send_email($email, $pdfFileName, "","", $attach_file_path);
  }
  $data = array(
    "invoice_created" => 1
  );
  $this->cm->update("apartment_booked_list", $data, "id", $booking_id);
  redirect('apartment/booking_list');


  // $pdfFileName = "Check_Out_Formalities.pdf";

  //load mPDF library
  // $this->load->library('m_pdf');
  // $html = $this->load->view('pdfpage/invoice_a', $data, true);
  // $this->m_pdf->pdf->WriteHTML($html); //generate the PDF!

  // $pdfFilePath = FCPATH."uploads/".$pdfFileName;
  // $this->m_pdf->pdf->Output($pdfFilePath, "F");

  //now, send the email
  // $attach_file_path = base_url()."/uploads/".$pdfFileName;
  // $this->load->library("email_manager");
  // $status = $this->email_manager->send_email($booking_details["email"],"Check Out Formalities","text text text","jamiulh@gmail.com", $attach_file_path);

}

public function apartment_photo_upload()
{
  $response = uploadFile("myfile","", "temp/");
  echo json_encode($response);
}

public function deleteRoom($room_id)
{
  $this->cm-> delete("rooms", "id", $room_id);
  echo "success";
}

}

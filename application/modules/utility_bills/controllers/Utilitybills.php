<?php

class Utilitybills extends MX_Controller {

  function __construct() {
    parent::__construct();

    // load required models
    $this->load->model('utilitybills_model', 'util');
    $this->load->model('apartment/apartment_model', 'apps');
    $this->load->library('form_validation');
  }

  /**
  * [index description]
  * @return [type] [description]
  * @author Razib Mahmud
  */
  public function index() {
    $data = array();
    $data['body']['movements'] = '';
    $data['header']['title'] = "Account to Close List";
    $data['header']['menu_base'] = "bank";
    $data['body']['apartments'] = $this->util->get_all_apartment_info();
    $data['body']['apartments_list'] = $this->util->get_all_apartment();
    $data['body']['suppliers'] = $this->util->get_all_supplier();
    /*print_r( $data['body']['apartments_list']);
    exit;*/
    $data['body']['page'] = "account_to_close_list";
    makeTemplateAdmin($data);
  }

  /**
  * @author Razib Mahmud
  */
  public function ajax_get_apartment_info() {
    $id = $this->input->post('apartment_id');
    if($id) {
      $close_info = $this->util->get_apartment_to_close_info($id);
      if($close_info == false) {
        $data['apartment_id'] = $id;
        $data['create_date'] = date('Y-m-d H:i:s');
        $this->db->insert('apartment_to_close_list', $data);
      }
      $info = $this->util->get_apartment_info($id);
      $info['internet_close_status'] = $close_info ? $close_info['internet_close_status']:0;
      $info['council_tax_close_status'] = $close_info ? $close_info['council_tax_close_status']:0;
      $info['water_close_status'] = $close_info ? $close_info['water_close_status']:0;
      $info['electricity_close_status'] = $close_info ? $close_info['electricity_close_status']:0;
      $info['gas_close_status'] = $close_info ? $close_info['gas_close_status']:0;
      echo json_encode($info);
    }
  }

  /**
  * @author Razib Mahmud
  */
  public function ajax_status_change_to_close() {
    $apartment_id = $this->input->post('apartment_id');
    $type = $this->input->post('type');
    $status = $this->input->post('status');

    if($apartment_id && $type) {
      $close_info = $this->util->get_apartment_to_close_info($apartment_id);
      if($type == 'internet') {
        $data['internet_close_status'] = $status;
      }
      if($type == 'council') {
        $data['council_tax_close_status'] = $status;
      }
      if($type == 'water') {
        $data['water_close_status'] = $status;
      }
      if($type == 'el') {
        $data['electricity_close_status'] = $status;
      }
      if($type == 'gas') {
        $data['gas_close_status'] = $status;
      }
      $data['apartment_id'] = $apartment_id;

      if($close_info) {
        $id = $close_info['id'];

        $data['update_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update('apartment_to_close_list', $data);
        echo json_encode(1);
      } else {
        $data['create_date'] = date('Y-m-d H:i:s');
        $insert = $this->db->insert('apartment_to_close_list', $data);
        if($insert) {
          echo json_encode(1);
        } else {
          echo json_encode(0);
        }
      }
    }
  }

  /**
  * [index description]
  * @return [type] [description]
  * @author Razib Mahmud
  */
  public function setup() {
    $apartments_ = $this->util->get_apartment_info_with_setup();
    foreach($apartments_ as $apt){
      $apartments['ap_'.$apt['apid']] = $apt;
    }

    $data = array();
    $data['body']['movements'] = '';
    $data['header']['title'] = "Account to be Setup List";
    $data['header']['menu_base'] = "bank";
    $data['body']['apartments'] = $apartments;
    $data['body']['suppliers'] = $this->util->get_all_supplier();
    $data['body']['page'] = "account_to_setup_list";
    makeTemplateAdmin($data);
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
* @author Razib Mahmud
*/
public function ajax_status_change_to_setup() {
  $apartment_id = $this->input->post('apartment_id');
  $supplier_id = $this->input->post('supplier_id');
  $type = $this->input->post('type');
  $value = $this->input->post('value');

  if($apartment_id && $type) {
    $setup_info = $this->util->get_apartment_to_setup_info($apartment_id);



    $data[$type] = $value;
    $data['apartment_id'] = $apartment_id;

    if($setup_info) {
      $id = $setup_info['id'];

      $data['update_date'] = date('Y-m-d H:i:s');
      $this->db->where('id', $apartment_id);

      $query = "UPDATE apartment_to_setup_list SET ".$type." = '".$value."'";

      $result = $this->db->query($query);

      if($result) {
        echo json_encode(1);
      } else {
        echo json_encode(0);
      }
    } else {
      $data['create_date'] = date('Y-m-d H:i:s');
      $insert = $this->db->insert('apartment_to_setup_list', $data);
      if($insert) {
        echo json_encode(1);
      } else {
        echo json_encode(0);
      }
    }

    #cashflow integration
    #if I modified a monthly cost
    $cost_type_['water_monthly_cost'] = 1;
    $cost_type_['gas_monthly_cost'] = 2;
    $cost_type_['electricity_monthly_cost'] = 3;
    $cost_type_['internet_monthly_cost'] = 4;
    $cost_type_['council_monthly_cost'] = 5;

    $pos = strpos($type,'monthly_cost');
    if ($pos !== false && $value > 1 ){

      #delete future installments
      /*$this->db->where('apartment_id',$apartment_id);
      $this->db->where('cost_type',$cost_type_[$type]);
      $this->db->where('payment_date >',date('Y-m-d'));
      $this->db->delete('cost');*/

      $query = "DELETE FROM cost WHERE apartment_id = ".$apartment_id." AND cost_type = '".$cost_type_[$type]."' AND payment_date > '".date('Y-m-d')."'";
      $this->db->query($query);

      #$total_rented_month = date_diff(new DateTime($setup_info['contract_from']), new DateTime($setup_info['contract_to']));
      $total_rented_month = $this->month_count_between_two_dates($setup_info['contract_from'],$setup_info['contract_to']);



      for($i = 0; $i<$total_rented_month; $i++){
        $payment_date = date('Ymd',strtotime($setup_info['contract_from'].' +'.$i.' months'));
        if($payment_date>date('Ymd')){
          $installment_data = [
            'cost_for'=>8,
            'apartment_id'=>$apartment_id,
            'cost_type'=>$cost_type_[$type],
            'oc_amount'=>$value,
            'create_date' =>  date('Y-m-d'),
            'payment_date'=> date('Y-m-d',strtotime($payment_date)),#must be the 15th of the month
            'cost_code'=>'9999',
            'description'=>'account no',
            'supplier_id' =>$supplier_id,
            'payment_month'=>date('Ym',strtotime($payment_date))
          ];
          $this->db->insert('cost', $installment_data);
        }
      }
    }

  }
}

/**
* @author Razib Mahmud
*/
public function ajax_get_apartment_setup_info() {
  $id = $this->input->post('apartment_id');
  if($id) {
    $setup_info = $this->util->get_apartment_to_setup_info($id);
    echo json_encode($setup_info);
  }
}
}

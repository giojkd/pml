<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* Class User_Model
*/
class Bank_model extends CI_Model {


  public function save_bank_movement()
  {
    $data =  array();
    $data["movement_date"] = sqldate($this->input->post("movement_date"), "-", "d-m-Y");
    $data["movement_description"] = $this->input->post("movement_description");
    $data["movement_amount"] = abs($this->input->post("movement_amount"));
    $data["movement_type"] = $this->input->post("movement_type");
    $data["entry_date"] = date("Y-m-d");
    $data["to_whom"] = $this->input->post("tenant_or_owner");
    if($this->input->post("tenant_or_owner") == "1")
    {
      $data["tenant_id"] = $this->input->post("tenant_user_id");
      $data["cost_id"] = $this->input->post('unpaid_cost_id');
    }
    else if($this->input->post("tenant_or_owner") == "2")
    {
      $data["owner_id"] = $this->input->post("owner_user_id");
      $data["cost_id"] = $this->input->post('unpaid_cost_id');
    }
    else if($this->input->post("tenant_or_owner") == "3")
    {
      $data["supplier_id"] = $this->input->post("supplier_user_id");
      $data["gc_id"] = $this->input->post('unpaid_cost_id');
    }



    $this->db->insert("bank_movement",$data);
    return $this->db->insert_id();
  }

  public function select_external_items()
  {
    $this->db->select('*');
    $this->db->from('stock_external');
    $this->db->join('stock_item','stock_external.item_id=stock_item.item_id');
    $result = $this->db->get();

    if ($result->num_rows()) {
      return $result->result_array();
    } else {
      return array();
    }
  }

  public function save_external_item()
  {
    $data =  array();
    $data["item_id"] = $this->input->post("item_id");
    $data["current_quantity"] = $this->input->post("item_quantity");
    $data["create_date"] = date("Y-m-d H:i:s");
    $this->db->insert("stock_external",$data);
    return $this->db->insert_id();
  }

  public function update_external_item()
  {
    $data =  array();
    $data["current_quantity"] = $this->input->post("item_quantity");
    $data["update_date"] = date("Y-m-d H:i:s");

    $this->db->where("id",$this->input->post("id"));
    $this->db->update("stock_external",$data);
    return true;
  }


  public function select_all_apartment_items()
  {
    $this->db->select('stock_apartment.*,stock_item.*');
    $this->db->from('stock_apartment');
    $this->db->join('stock_item','stock_apartment.item_id=stock_item.item_id');
    $result = $this->db->get();

    if ($result->num_rows()) {
      return $result->result_array();
    } else {
      return array();
    }
  }

  public function select_all_asc()
  {
    $this->db->select('bank_movement.id, bank_movement.movement_date, bank_movement.movement_description, bank_movement.movement_amount, bank_movement.movement_type, bank_movement.to_whom, bank_movement.tenant_id, bank_movement.owner_id, bank_movement.supplier_id as bm_supplier_id, general_cost.supplier_id, general_cost.supplier_invoice_number, general_cost.supplier_invoice_date');
    $this->db->from('bank_movement');
    $this->db->join('general_cost','general_cost.bm_id=bank_movement.id','left');
    $this->db->order_by('bank_movement.movement_date');
    return $this->db->get()->result_array();
  }

  public function extract_account_no($s) {
    $s=preg_replace('/[[:space:]]+/',' ',$s);
    $parts=explode(' ',$s);
    array_pop($parts); //trashing last piece
    $good=array_pop($parts);
    if (strpos($good,'*')!== false) {
      $extra=array_pop($parts);
      if (strpos($extra,'*')!== false) {
        $good=$extra.' '.$good;
      }
    }
    return $good;
  }

  public function set_cost_paid($account_no, $month){
    $bills = ['internet_account_no','council_account_no','water_account_no','electricity_account_no','gas_account_no'];
    $bill_type_id = ['internet_account_no'=>4,'council_account_no'=>5,'water_account_no'=>1,'electricity_account_no'=>3,'gas_account_no'=>2];
    if(!empty($account_no) && !empty($month)){
      $this->db->select('*');
      $this->db->from('apartment_to_setup_list atsl');
      $this->db->where('atsl.internet_account_no LIKE ("'.$account_no.'") OR atsl.council_account_no LIKE ("'.$account_no.'") OR atsl.water_account_no LIKE ("'.$account_no.'") OR atsl.electricity_account_no LIKE ("'.$account_no.'") OR atsl.gas_account_no LIKE ("'.$account_no.'")');
      $result = $this->db->get();
      $result_array = $result->result_array();

      if(count($result_array)>0){

        $result_array = $result_array[0];

        $bill_type = '';
        foreach($bills as $bill){
          if($result_array[$bill]==$account_no){
            $bill_type = $bill;
          }
        }
        if($bill_type!=''){
          $cost_type = $bill_type_id[$bill_type];
          $SQL = "UPDATE cost SET payment_status = 1 WHERE apartment_id = ".$result_array['apartment_id']." AND cost_type = ".$cost_type." AND payment_month = ".$month;
          $this->db->query($SQL);
          $this->db->insert('debug_log',['debug_content'=>json_encode($result_array),'extra_field_1'=>$account_no,'extra_field_2'=>$month,'extra_field_3'=>$SQL]);
          return 1;
        }


      }else{

      }
    }else{
      return "missing account_no or month";
    }
  }

  public function get_file_info($data)
  {
    $this->db->truncate('bank_temp');
    foreach ($data as $value) {
      $id = preg_replace("/[^0-9]/", '', $value[5]);
      $count_check = 0;

      $count_check++;
      
      if($this->cm->exist_or_not('cost','id',$id))
      {
        $bank_temp = array(
          'payment_status' => 1,
          'payment_status_update_date' => sqldate($value[1],"/","d/m/Y")
        );
        $this->cm->update('cost',$bank_temp,'id',$id);
        $count_check++;
      }

      #####################################
      #extract account no for utility bill#
      #      set as paid those costs      #
      #####################################
      $account_no = $this->extract_account_no($value[5]);
      $month = date('Ym',strtotime(str_replace('/','-',$value[1])));
      $bill_status = $this->set_cost_paid($account_no,$month);
      if($bill_status == 1){
        $count_check++;
      }

      if($count_check<2){
        $bank_temp = array(
          'installment_id' => $id,
          'payment_date' => sqldate($value[1],"/","d/m/Y"),
          'description' => $value[5],
          'amount' => $value[3]
        );
        $this->db->insert('bank_temp',$bank_temp);
      }


    }
  }



  public function update_bank_movement()
  {
    $movement_id = $this->input->post('movement_id');
    $data =  array();
    $data["movement_date"] = sqldate($this->input->post("movement_date"), "-", "d-m-Y");
    $data["movement_description"] = $this->input->post("movement_description");
    $data["movement_amount"] = abs($this->input->post("movement_amount"));
    $data["movement_type"] = $this->input->post("movement_type");
    $data["entry_date"] = date("Y-m-d");
    $data["to_whom"] = $this->input->post("tenant_or_owner");
    if($this->input->post("tenant_or_owner") == "1")
    {
      $data["tenant_id"] = $this->input->post("tenant_user_id");
      $data["owner_id"] = "";
      $data["supplier_id"] = "";
    }
    else if($this->input->post("tenant_or_owner") == "2")
    {
      $data["owner_id"] = $this->input->post("owner_user_id");
      $data["tenant_id"] = "";
      $data["supplier_id"] = "";
    }
    else if($this->input->post("tenant_or_owner") == "3")
    {
      $data["supplier_id"] = $this->input->post("supplier_user_id");
      $data["tenant_id"] = "";
      $data["owner_id"] = "";
    }
    $this->db->where("id",$movement_id);
    $this->db->update('bank_movement',$data);
    return true;
  }



}

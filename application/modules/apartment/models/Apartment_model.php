<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* Class Apartment_Model
*/
class Apartment_Model extends CI_Model {

  public function get_booking_cost($booking_id,$cost_for){
    $this->db->select('cost.*');
    $this->db->where('cost.booking_id', $booking_id);
    $this->db->where('cost.cost_for', $cost_for);
    $query = $this->db->get('cost');
    return $query->result_array();
  }

  public function get_first_two_months($booking_id){
    $this->db->select('cost.*');
    $this->db->where('cost.booking_id', $booking_id);
    $this->db->where('cost.first_two_months', 1);
    $query = $this->db->get('cost');
    return $query->result_array();
  }



  public function get_all_apartment_info(){
    $this->db->select('apartment_detail.*, user.name, user.family_name');
    $this->db->join('user', "user.id = apartment_detail.owner");
    $query = $this->db->get('apartment_detail');
    return $query->result_array();
  }

  public function get_apartment_info_by_id($apartment_id){
    $this->db->select('apartment_detail.id, apartment_detail.*, apartment_service_charges.*');
    $this->db->join('apartment_service_charges', "apartment_detail.id = apartment_service_charges.apartment_id");
    $this->db->where('apartment_detail.id', $apartment_id);
    $query = $this->db->get('apartment_detail');
    return $query->result_array();
  }

  public function get_apartment_rooms_by_id($apartment_id)
  {
    $this->db->select('*');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('rooms');
    return $query->result_array();
  }

  public function get_apartment_common_area_by_id($apartment_id){
    $this->db->select('*');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('common_area');
    return $query->result_array();
  }

  public function get_apartment_private_area_by_id($apartment_id){
    $this->db->select('*');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('private_area');
    return $query->result_array();
  }

  public function get_rooms_in_apartment($apartment_id){
    $this->db->select('*');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get('rooms');
    return $query->result_array();
  }

  public function rooms_in_apartment($apartment_id, $type){
    $this->db->select('count(*) as total_room');
    $this->db->where('apartment_id', $apartment_id);
    $this->db->where('room_type', $type);
    $query = $this->db->get('rooms');
    return $query->row_array();
  }

  public function update_apartment_detail($apartment_id, $apartment_data){
    $this->db->where('id', $apartment_id);
    $this->db->update('apartment_detail', $apartment_data);
    return true;
  }

  public function update_service_charge_info($apartment_id, $service_charges){
    $this->db->where('id', $apartment_id);
    $this->db->update('apartment_service_charges', $service_charges);
    return true;
  }

  public function update_room_detail($apartment_id, $type, $single_room){
    $this->db->where('id', $apartment_id);
    $this->db->where('room_type', $type);
    $this->db->update('rooms', $single_room);
    return true;
  }

  function remove_common_area($apartment_id)
  {
    $this->db->where('apartment_id', $apartment_id);
    $this->db->delete('common_area');
  }

  function remove_private_area($apartment_id)
  {
    $this->db->where('apartment_id', $apartment_id);
    $this->db->delete('private_area');
  }

  function remove_service_charges($apartment_id)
  {
    $this->db->where('apartment_id', $apartment_id);
    $this->db->delete('apartment_service_charges');
  }

  function remove_room($apartment_id)
  {
    $this->db->where('apartment_id', $apartment_id);
    $this->db->delete('rooms');
  }

  function apartment_delete($id){
    $this->remove_private_area($id);
    $this->remove_common_area($id);
    $this->remove_service_charges($id);
    $this->remove_room($id);

    $this->db->where('id', $id);
    $this->db->delete('apartment_detail');

    return true;
  }

  function insert_booking($booking_data){
    $this->db->insert('apartment_booked_list', $booking_data);
    return $this->db->insert_id();
  }

  function insert_monthly_cost($installment_data){
    $this->db->insert('cost', $installment_data);
  }

  function check_room_availability($room_id, $rent_from, $rent_to){

    $this->db->select('*');
    $this->db->where('room_id', $room_id);
    $this->db->where("( rent_from BETWEEN '".$rent_from."' AND '".$rent_to. "'
    OR rent_to BETWEEN '". $rent_from."' AND '".$rent_to."'
    OR rent_from BETWEEN '". $rent_from. "' AND '".$rent_to."')");

    $result = $this->db->get('apartment_booked_list');

    if($result->num_rows()){
      return FALSE;
    }
    else{
      return TRUE;
    }

  }

  function check_room_availability_edit($room_id, $rent_from, $rent_to, $cur_rent_from, $cur_rent_to){


    $this->db->select('*');
    $this->db->where('room_id', $room_id);
    $this->db->where(' ( rent_from NOT BETWEEN "'.$cur_rent_from.'" AND "'.$cur_rent_to. '"
    OR rent_to NOT BETWEEN "'. $cur_rent_from.'" AND "'.$cur_rent_to.'"
    OR rent_from NOT BETWEEN "'. $cur_rent_from. '" AND "'.$cur_rent_to.'")', null, false);

    $this->db->where("( rent_from BETWEEN '".$rent_from."' AND '".$rent_to. "'
    OR rent_to BETWEEN '". $rent_from."' AND '".$rent_to."'
    OR rent_from BETWEEN '". $rent_from. "' AND '".$rent_to."')");

    $result = $this->db->get('apartment_booked_list');

    if($result->num_rows()){
      return FALSE;
    }
    else{
      return TRUE;
    }

  }

  public function get_all_booking_info(){
    $this->db->select('apartment_booked_list.*,user.*,apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_all_bookings($in_out = ""){
    $this->db->select('apartment_booked_list.*,user.*,user.id as user_id,apartment_detail.id as apartment_id,apartment_detail.address,rooms.id as room_id*, apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
    $this->db->join('rooms', 'apartment_booked_list.room_id = rooms.id');

    if($in_out == "in") {
      $this->db->order_by("apartment_booked_list.rent_from","asc");
    }

    if($in_out == "out") {
      $this->db->where("apartment_booked_list.moved_out","1");
      $this->db->order_by("apartment_booked_list.rent_to","asc");
    }

    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_booking_detail_by_id($id){
    $this->db->select('a.*');
    $this->db->from('apartment_booked_list a');
    $this->db->where('a.id', $id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_pdf_booking_detail_by_id($id){
    $this->db->select('e.address, a.*, b.email, b.name, b.family_name, b.birthday, b.phone_no, b.company_name, c.city_name, d.country_shortName');
    $this->db->from('apartment_booked_list a');

    $this->db->join('user b', 'a.user_id = b.id', 'left');

    $this->db->join('city c', 'b.city_id = c.city_id', 'left');
    $this->db->join('country d', 'b.country_id = d.country_id', 'left');
    $this->db->join('apartment_detail e', 'a.apartment_id = e.id', 'left');

    $this->db->where('a.id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function booking_file_insert($file_name, $orig_name,$booking_id)
  {
    $ap_booked_list_id = $this->input->post('ap_booked_list_id');

    $data_feed['agreement_file'] = $file_name;
    $data_feed['orig_file_name'] = $orig_name;

    $this->db->where('id',$booking_id);
    $this->db->update('apartment_booked_list', $data_feed);

    copy("./uploads/agreement_temp/" . $file_name, "./uploads/agreement_file/" . $file_name);
    unlink("./uploads/agreement_temp/" . $file_name);

    return true;

  }

  public function booking_file_insert_sales($file_name, $orig_name,$booking_id,$description,$date)
  {

    $sales_file_data=[
      'booking_id'        =>$booking_id,
      'date'              =>$date,
      'description'       =>$description,
      'file_name'         =>$file_name,
      'original_file_name'=>$orig_name,
      'uploaded_by'=>getUserdata("user_id")
    ];

    $this->db->insert('uploaded_sales_files', $sales_file_data);
    copy("./uploads/agreement_temp/" . $file_name, "./uploads/agreement_file/" . $file_name);
    unlink("./uploads/agreement_temp/" . $file_name);

    return true;

  }

  public function get_booking_attached_files($booking_id){
    $this->db->select('a.*,b.name,b.family_name');
    $this->db->from('uploaded_sales_files as a');
    $this->db->join('user as b','b.id=a.uploaded_by');
    $this->db->where('a.booking_id', $booking_id);
    return $this->db->get()->result();
  }

  public function get_attached_file($file_id){
    $this->db->select('a.*');
    $this->db->from('uploaded_sales_files as a');
    $this->db->where('a.uploaded_file_id', $file_id);
    return $this->db->get()->row_array();
  }

  public function update_booking($booking_id, $booking_data){
    $this->db->where('id', $booking_id);
    $this->db->update('apartment_booked_list', $booking_data);
    return true;
  }

  function delete_booking($id){
    $this->remove_booking_cost($id);

    $this->db->where('id', $id);
    $this->db->delete('apartment_booked_list');

    return true;
  }

  function remove_booking_cost($id){
    $this->db->where('booking_id', $id);
    $this->db->delete('cost');
  }

  function get_current_installment_info($booking_id){
    $this->db->select("*");
    $this->db->where('booking_id', $booking_id);
    $query = $this->db->get('cost');

    return $query->result_array();
  }

  function remove_unpaid_installment_info($booking_id){
    $this->db->where('booking_id', $booking_id);
    $this->db->where('payment_status', 0);
    $this->db->delete('cost');
  }

  function get_total_paid_installment_info($booking_id){
    $this->db->select("count(*) as total_paid");
    $this->db->where('booking_id', $booking_id);
    $query = $this->db->get('cost');

    return $query->row_array()['total_paid'];
  }

  public function get_all_renewal_info(){
    $this->db->select('apartment_booked_list.*,user.name,user.family_name, apartment_detail.address, apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
    $this->db->where("apartment_booked_list.renewal_status","0");
    $this->db->where("moved_out","0");
    $this->db->order_by("apartment_booked_list.rent_to","asc");
    $query = $this->db->get();
    return $query->result_array();
  }


  public function get_booking_details($booking_id){
    $this->db->select('apartment_booked_list.*,user.*,apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->where("apartment_booked_list.id",$booking_id);
    $query = $this->db->get();
    return $query->row_array();
  }


  public function get_all_deposit_info(){
    $this->db->select('apartment_booked_list.*,user.name,user.family_name, apartment_detail.id as apartment_id, apartment_detail.address, apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
    $this->db->order_by("apartment_booked_list.rent_to","asc");
    $query = $this->db->get();
    return $query->result_array();

    /*
    $this->db->select('apartment_booked_list.*,user.*,user.id as user_id,apartment_detail.id as apartment_id,apartment_detail.address,rooms.id as room_id*, apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
    $this->db->join('rooms', 'apartment_booked_list.room_id = rooms.id');
    */
  }

  public function get_single_deposit_info($booking_id){
    $this->db->select('apartment_booked_list.*,user.*, apartment_detail.id as apartment_id, apartment_detail.address, apartment_booked_list.id as booking_id');
    $this->db->from('apartment_booked_list');
    $this->db->join('user', 'apartment_booked_list.user_id = user.id');
    $this->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
    $this->db->where("apartment_booked_list.id",$booking_id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_invoices1_by_user_id($user_id) //of outgoing costs
  {
    $this->db->from('invoice');
    $this->db->join('cost', 'invoice.oc_id = cost.id');
    $this->db->where("cost.tenant_user_id",$user_id);
    $this->db->where("cost.payment_status","0");
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_invoices2_by_user_id($user_id) //of installments
  {
    $this->db->from('invoice');
    $this->db->join('cost', 'invoice.installment_id = cost.id');
    $this->db->where("cost.tenant_user_id",$user_id);
    $this->db->where("cost.payment_status","0");
    $query = $this->db->get();
    return $query->result_array();
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

  public function select_last_invoice_number() {
    $this->db->from("invoice");
    $this->db->where("invoice_type",1);
    $this->db->order_by("id", "desc");
    $this->db->limit(1);
    $return = $this->db->get();

    if ($return->num_rows()) {
      $invoice_number = $return->row()->invoice_number;
      return $return->row()->invoice_serial;
    } else {
      return 0;
    }
  }

  public function insert_rooms($apartment_id)
  {
    $room_name = $this->input->post('room_name');
    $check_box = $this->input->post('check_box');
    $market_price = $this->input->post('market_price');
    $room_description = $this->input->post('room_description');

    foreach ($room_name as $key => $value)
    {
      if(array_key_exists($key, $room_name))
      {

        $rooms = array();
        $rooms['apartment_id'] = $apartment_id;
        $rooms['room_name'] = $value;
        if(!$check_box)
        {
          $rooms['ensuite'] = "0";
        }
        elseif(array_key_exists($key, $check_box))
        {
          $rooms['ensuite'] = $check_box[$key];
        }
        else{
          $rooms['ensuite'] = "0";
        }

        $rooms['market_price'] = $market_price[$key];
        $rooms['room_description'] = $room_description[$key];
        $rooms['create_date'] = date('Y-m-d H:i:s');

        $this->db->insert("rooms", $rooms);
      }

    }
    return true;
  }

  public function update_rooms()
  {
    $edit_room_id = $this->input->post('edit_room_id');
    $edit_room_name = $this->input->post('edit_room_name');
    $edit_check_box = $this->input->post('edit_check_box');
    $edit_market_price =$this->input->post('edit_market_price');
    $edit_room_description = $this->input->post('edit_room_description');

    foreach ($edit_room_id as $key => $value) {
      $rooms = array();
      $rooms['room_name'] =  $edit_room_name[$key];
      $rooms['ensuite'] = 0; #temp fix
      /*if(array_key_exists($key, $edit_check_box))
      {
      $rooms['ensuite'] = $edit_check_box[$key];
    }
    else{
    $rooms['ensuite'] = "0";
  }*/

  $rooms['market_price'] = $edit_market_price[$key];
  $rooms['room_description'] = $edit_room_description[$key];
  $rooms['update_date'] = date('Y-m-d H:i:s');

  $this->db->where('id',$value);
  $this->db->update('rooms',$rooms);
}
return true;
}

public function delete_cost_data($apartment_id)
{
  $this->db->where('apartment_id', $apartment_id);
  $this->db->where('cost_for', 3);
  $this->db->where('booking_id', NULL);
  $this->db->delete('cost');
  return true;
}

}

<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
* Class User_Model
*/
class Outgoing_model extends CI_Model {



  public function get_maintenance_costs($maintenance_id){
    $this->db->select('*');
    $this->db->select('c.id as cost_id');
    $this->db->select('c.invoice_id as invoice_id');
    $this->db->from('cost c');
    $this->db->join('user u','c.tenant_user_id = u.id','LEFT');
    $this->db->where('maintenance_id', $maintenance_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rooms_in_apartment($apartment_id)
  {
    $this->db->select('*');
    $this->db->from('rooms');
    $this->db->where('apartment_id', $apartment_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function get_rooms_in_apartment_and_common_area($apartment_id)
  {
    $this->db->select('rooms.*, common_area.type, common_area.qty');
    $this->db->from('rooms');
    $this->db->join('common_area','common_area.apartment_id = rooms.apartment_id','LEFT');
    $this->db->where('rooms.apartment_id', $apartment_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function save_item()
  {
    $data =  array();
    $data["item_name"] = $this->input->post("item_name");
    $data["create_date"] = date("Y-m-d H:i:s");
    $this->db->insert("stock_item",$data);
    return $this->db->insert_id();
  }

  public function select_outgoing_costs()
  {
    /*
    *  SELECT d.name as ap_name, d.family_name as ap_family_name, e.invoice_amount, cost.*, user.name, user.family_name FROM cost
    LEFT JOIN user ON cost.tenant_user_id = user.id
    LEFT JOIN apartment_detail c on cost.apartment_id = c.id
    LEFT JOIN user d on c.owner = d.id
    LEFT JOIN invoice e on cost.id = e.oc_id
    WHERE cost_for = '1'
    * */
    $this->db->select('g.company, g.name as supplier_name, g.surname as supplier_surname, d.name as ap_name, d.family_name as ap_family_name, e.id as invoice_id, e.invoice_amount, f.name as owner_name, f.family_name as owner_family_name, cost.*, user.name, user.family_name');
    $this->db->where('cost_for',"1");
    $this->db->where('cost.send_invoice_status',"0");
    $this->db->from('cost');
    $this->db->join('user','cost.tenant_user_id=user.id','left');

    $this->db->join('apartment_detail c', 'cost.apartment_id = c.id','left');
    $this->db->join('user d', 'c.owner = d.id','left');
    $this->db->join('invoice e', 'cost.id = e.oc_id','left');
    $this->db->join('user f', 'cost.owner_user_id = f.id','left');
    $this->db->join('suppliers g', 'cost.supplier_id = g.id', 'left');
    $result = $this->db->get();

    if ($result->num_rows()) {
      return $result->result_array();
    } else {
      return array();
    }
  }

  public function select_appointment_IDs_as_string() {
    $this->db->select('GROUP_CONCAT(id) as appointmentIDs', false);
    $result = $this->db->get("apartment_detail");
    return $result->result_array();
    if ($result->num_rows()) {
      return $result->row()->appointmentIDs;
    } else {
      return false;
    }
  }

  public function select_maintenance(){
    $this->db->select('*', false);
    $this->db->select('(SELECT SUM(revenue_amount) FROM cost c WHERE c.maintenance_id = m.maintenance_id GROUP BY maintenance_id) as total_revenue');
    $this->db->join('apartment_detail ad', 'm.apartment_id = ad.id','LEFT');
    $this->db->join('rooms r', 'm.room_id = r.id','LEFT');
    $result = $this->db->get("maintenance m");
    return $result->result_array();
  }

  public function get_all_suppliers()
  {
    $this->db->select('suppliers.*, ini_provinces_regions.county_name, ini_cities.city_name');
    $this->db->from('suppliers');
    $this->db->join('ini_provinces_regions','suppliers.county_code=ini_provinces_regions.county_code',"left");
    $this->db->join('ini_cities','suppliers.city_code=ini_cities.city_code',"left");
    $result = $this->db->get();

    if ($result->num_rows()) {
      return $result->result_array();
    } else {
      return array();
    }
  }


  public function save_maintenance(){

    $data = [];
    $data['apartment_id'] = $this->input->post("apartment_id");
    $data['all_apartment'] = ($this->input->post("room_id")>0) ? 0 : 1;
    $data['room_id'] = $this->input->post("room_id");
    $data['maintenance_description'] = $this->input->post("maintenance_description");
    $data['maintenance_reported_date'] = date('Y-m-d',strtotime($this->input->post("maintenance_reported_date")));
    $data['maintenance_reported_by'] = $this->input->post("maintenance_reported_by");
    $data['maintenance_comments'] = $this->input->post("maintenance_comments");
    $data['maintenance_responsible'] = $this->input->post("maintenance_responsible");
    $data['file_name'] = $this->input->post("file_name");
    $data['maintenance_create_date'] = date('Y-m-y');
    $maintenance_id = $this->cm->insert("maintenance",$data);






  }

  public function save_oc_data()
  {
    $apartment_id = $this->input->post("apartment_id");

    if($apartment_id == "0") //means all apartments
    {
      $apartment_IDs_as_string = $this->select_appointment_IDs_as_string();
      $apartment_IDs = explode(",",$apartment_IDs_as_string);

      foreach($apartment_IDs as $apart_id)
      {
        $data =  array();
        $data["apartment_id"] = $apart_id;
        $data["cost_for"] = "1";
        $data["cost_code"] = $this->input->post("nominal_code");
        $data["related_to"] = $this->input->post("related_to");
        $data["oc_amount"] = $this->input->post("amount");
        $data["payment_date"] = sqldate($this->input->post("payment_date"),"-","d-m-Y");

        $data["supplier_id"] = $this->input->post("supplier_id");
        $data["supplier_invoice_date"] = sqldate($this->input->post("supplier_invoice_date"),"-","d-m-Y");
        $data["supplier_invoice_number"] = $this->input->post("supplier_invoice_number");
        $data["file_name"] = $this->input->post("file_name");

        $data["create_date"] = date("Y-m-d");

        if($this->input->post("related_to")=="4"){
          $data["employers"] = implode(",",$this->input->post("employer_user_id"));
        }

        if($this->input->post("to_owner")){
          $data["if_to_owner"] = 1;
          $data["owner_user_id"] = $this->input->post("owner_user_id");
          $data["revenue_amount"] = $this->input->post("owner_revenue_amount");
          $data["expired_date"] = sqldate($this->input->post("owner_expired_date"),"-","d-m-Y");
        }

        $oc_id = $this->cm->insert("cost",$data);


        //now upload the photo
        if($oc_id)
        {
          if($this->input->post('file_name')) {
            copy("./uploads/oc_temp/" . $this->input->post('file_name'), "./uploads/oc_file/" . $this->input->post('file_name'));
            unlink("./uploads/oc_temp/" . $this->input->post('file_name'));
          }
        }

        //now, insert a row in invoice table
        $current_year = date("Y");
        $last_invoice_serial = $this->select_last_invoice_serial();

        $invoice_data = array();
        $invoice_data["invoice_of"] = 2;
        $invoice_data["invoice_serial"] = $last_invoice_serial+1;
        $invoice_data["invoice_year"] = $current_year;
        $invoice_data["invoice_no"] = ($last_invoice_serial+1)."-".$current_year;
        $invoice_data["invoice_amount"] = $this->input->post("amount");
        $invoice_data["oc_id"] = $oc_id;
        $invoice_data["installment_id"] = 0;
        $invoice_data["create_date"] = date("Y-m-d");
        $this->cm->insert("invoice",$invoice_data);
      }

    }
    else
    {
      if ($this->input->post("to_tenant")) {
        $tenant_user_id = $this->input->post("tenant_user_id");
        foreach ($tenant_user_id as $tenant_id) {
          $data = array();
          //apartment
          $data["apartment_id"] = $apartment_id;
          $data['job_description'] = $this->input->post('job_description');
          $data['reported_date'] = sqldate($this->input->post('reported_date'), "-", "d-m-Y");
          $data['comments'] = $this->input->post('comments');
          $data['reported_by'] = $this->input->post('reported_by');
          $data['internal_pml'] = $this->input->post('internal_pml');

          //supplier
          $data["supplier_id"] = $this->input->post("supplier_id");
          $data["supplier_invoice_amount"] = $this->input->post("supplier_invoice_amount");
          $data["supplier_invoice_date"] = sqldate($this->input->post("supplier_invoice_date"), "-", "d-m-Y");
          $data["supplier_invoice_number"] = $this->input->post("supplier_invoice_number");
          $data["file_name"] = $this->input->post("file_name");

          //after upload file
          $data["payment_date"] = sqldate($this->input->post("payment_date"), "-", "d-m-Y");
          //$data['job_duration'] = $this->input->post('job_duration');
          $data["oc_amount"] = $this->input->post("amount");
          $data["cost_code"] = $this->input->post("nominal_code");

          $data["cost_for"] = "1";
          #$data["related_to"] = $this->input->post("related_to");
          $data["create_date"] = date("Y-m-d");

          if ($this->input->post("related_to") == "4" && $apartment_id == "0") {
            $data["employers"] = implode(",", $this->input->post("employer_user_id"));
          }
          $data["if_to_tenant"] = $this->input->post("to_tenant");
          $data["tenant_user_id"] = $tenant_id;
          $data["revenue_amount"] = $this->input->post("amount")/count($tenant_user_id);
          $data["expired_date"] = sqldate($this->input->post("expired_date"), "-", "d-m-Y");


          /*if ($this->input->post("to_owner")) {
          $data["if_to_owner"] = 1;
          $data["owner_user_id"] = $this->input->post("owner_user_id");
          $data["revenue_amount"] = $this->input->post("owner_revenue_amount");
          $data["expired_date"] = sqldate($this->input->post("owner_expired_date"), "-", "d-m-Y");
        }*/

        $oc_id = $this->cm->insert("cost", $data);


        /*
        //now, insert a row in invoice table
        $current_year = date("Y");
        $last_invoice_serial = $this->select_last_invoice_serial();

        $invoice_data = array();
        $invoice_data["invoice_of"] = 2;
        $invoice_data["invoice_serial"] = $last_invoice_serial + 1;
        $invoice_data["invoice_year"] = $current_year;
        $invoice_data["invoice_no"] = ($last_invoice_serial + 1) . "-" . $current_year;
        $invoice_data["invoice_amount"] = $this->input->post("amount")/count($tenant_user_id);
        $invoice_data["oc_id"] = $oc_id;
        $invoice_data["installment_id"] = 0;
        $invoice_data["create_date"] = date("Y-m-d");
        $invoice_id = $this->cm->insert("invoice", $invoice_data);

        #######################################
        #associate cost to its relative invoice
        #######################################

        echo 'invoice '.$invoice_id.'<br/>';
        echo 'oc_id '.$oc_id;



        $this->db->query("UPDATE cost SET invoice_id = ".$invoice_id." WHERE id = ".$oc_id);
        */
      }
    }

    if ($this->input->post("to_owner")) {
      $data = array();
      //apartment
      $data["apartment_id"] = $apartment_id;
      $data['job_description'] = $this->input->post('job_description');
      $data['reported_date'] = sqldate($this->input->post('reported_date'), "-", "d-m-Y");
      $data['comments'] = $this->input->post('comments');
      $data['reported_by'] = $this->input->post('reported_by');
      $data['internal_pml'] = $this->input->post('internal_pml');

      //supplier
      $data["supplier_id"] = $this->input->post("supplier_id");
      $data["supplier_invoice_amount"] = $this->input->post("supplier_invoice_amount");
      $data["supplier_invoice_date"] = sqldate($this->input->post("supplier_invoice_date"), "-", "d-m-Y");
      $data["supplier_invoice_number"] = $this->input->post("supplier_invoice_number");
      $data["file_name"] = $this->input->post("file_name");

      //after upload file
      $data["payment_date"] = sqldate($this->input->post("payment_date"), "-", "d-m-Y");
      //$data['job_duration'] = $this->input->post('job_duration');
      $data["oc_amount"] = $this->input->post("amount");
      $data["cost_code"] = $this->input->post("nominal_code");

      $data["cost_for"] = "1";
      $data["related_to"] = $this->input->post("related_to");
      $data["create_date"] = date("Y-m-d");

      if ($this->input->post("related_to") == "4" && $apartment_id == "0") {
        $data["employers"] = implode(",", $this->input->post("employer_user_id"));
      }

      //if ($this->input->post("to_owner")) {
      $data["if_to_owner"] = 1;
      $data["owner_user_id"] = $this->input->post("owner_user_id");
      $data["revenue_amount"] = $this->input->post("owner_revenue_amount");
      $data["expired_date"] = sqldate($this->input->post("owner_expired_date"), "-", "d-m-Y");
      //}

      $oc_id = $this->cm->insert("cost", $data);

      //now, insert a row in invoice table
      $current_year = date("Y");
      $last_invoice_serial = $this->select_last_invoice_serial();

      $invoice_data = array();
      $invoice_data["invoice_of"] = 2;
      $invoice_data["invoice_serial"] = $last_invoice_serial + 1;
      $invoice_data["invoice_year"] = $current_year;
      $invoice_data["invoice_no"] = ($last_invoice_serial + 1) . "-" . $current_year;
      $invoice_data["invoice_amount"] = $this->input->post("amount");
      $invoice_data["oc_id"] = $oc_id;
      $invoice_data["installment_id"] = 0;
      $invoice_data["create_date"] = date("Y-m-d");
      $this->cm->insert("invoice", $invoice_data);
    }
  }
  return $this->db->insert_id();
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

public function get_invoice_costs($invoice_id){
  echo $invoice_id;
  $this->db->select("*");
  $this->db->from("cost");
  $this->db->where("invoice_id",$invoice_id);
  $result = $this->db->get();
  return $result->result_array();
}

public function select_due_outgoing($id = "")
{
  $this->db->select("*");
  $this->db->from("cost");
  $this->db->where("cost_for","5");
  $this->db->where("payment_status","0");

  if($id)
  {
    $this->db->where("id",$id);
  }
  $this->db->order_by("payment_date","desc");
  $result = $this->db->get();

  if ($result->num_rows()) {
    return $result->result_array();
  } else {
    return array();
  }
}

public function get_apartment_all_tenant($rooms_id){
  /*
  *  select c.* from rooms a
  join apartment_booked_list b on a.id = b.room_id
  join user c on b.user_id = c.id
  where a.apartment_id = '2' group by c.id
  */
  $this->db->select("c.*");
  $this->db->from("rooms a");
  $this->db->join('apartment_booked_list b', 'a.id = b.room_id');
  $this->db->join('user c', 'b.user_id = c.id');
  $this->db->where_in("a.id", $rooms_id);
  $this->db->group_by('c.id');
  $result = $this->db->get();

  if ($result->num_rows()) {
    return $result->result_array();
  } else {
    return false;
  }
}
public function get_room_all_tenant($rooms_id){
  /*
  *  select c.* from rooms a
  join apartment_booked_list b on a.id = b.room_id
  join user c on b.user_id = c.id
  where a.apartment_id = '2' group by c.id
  */
  $this->db->select("c.*");
  $this->db->from("rooms a");
  $this->db->join('apartment_booked_list b', 'a.id = b.room_id');
  $this->db->join('user c', 'b.user_id = c.id');
  $this->db->where_in("a.id", $rooms_id);
  $this->db->group_by('c.id');
  $result = $this->db->get();

  if ($result->num_rows()) {
    return $result->result_array();
  } else {
    return false;
  }
}

public function get_apt_all_tenant($aparment_id){
  /*
  *  select c.* from rooms a
  join apartment_booked_list b on a.id = b.room_id
  join user c on b.user_id = c.id
  where a.apartment_id = '2' group by c.id
  */
  $this->db->select("u.*");
  $this->db->from("apartment_booked_list abl");
  $this->db->join('rooms r', 'abl.room_id = r.room_id');
  $this->db->join('user u', 'abl.user_id = u.id');
  $this->db->where_in("r.apartment_id", $aparment_id);
  $this->db->group_by('u.id');
  $result = $this->db->get();

  if ($result->num_rows()) {
    return $result->result_array();
  } else {
    return false;
  }
}



public function select_outgoing_costs_sent()
{
  $apartment_id = $this->input->get('apartment_id');
  $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
  $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

  $this->db->select('g.company, g.name as supplier_name, g.surname as supplier_surname, d.name as ap_name, d.family_name as ap_family_name, e.id as invoice_id, e.invoice_amount, f.name as owner_name, f.family_name as owner_family_name, cost.*, user.name, user.family_name');
  $this->db->where('cost_for',"1");
  $this->db->where('cost.send_invoice_status',"1");
  $this->db->from('cost');
  $this->db->join('user','cost.tenant_user_id=user.id','left');

  $this->db->join('apartment_detail c', 'cost.apartment_id = c.id','left');
  $this->db->join('user d', 'c.owner = d.id','left');
  $this->db->join('invoice e', 'cost.id = e.oc_id','left');
  $this->db->join('user f', 'cost.owner_user_id = f.id','left');
  $this->db->join('suppliers g', 'cost.supplier_id = g.id', 'left');

  if($apartment_id>0) {
    $this->db->where('cost.apartment_id', $apartment_id);
  }

  if($from_month != "" && $from_month != "") {
    $this->db->where("(UNIX_TIMESTAMP(cost.create_date) >= UNIX_TIMESTAMP('$from_month')) AND (UNIX_TIMESTAMP(cost.create_date) <= UNIX_TIMESTAMP('$to_month'))");
  }

  $result = $this->db->get();

  if ($result->num_rows()) {
    return $result->result_array();
  } else {
    return array();
  }
}
}

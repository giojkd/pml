<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Payments
 * This class is for managing calendar
 * @author Md. Jamiul Hasan
 */
class Calendar extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('calendar_model');
        //$this->load->library('form_validation');
    }

    public function index() {
        
    }

    public function calendar_view() {
        $data = array();
        $data['header']['title'] = "Calendar";
        $data['header']['menu_base'] = "slot";
        $data['body']['page'] = "calendar_view";
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        //$data['body']['installments']=$this->revenue_model->select_due_installments();
        makeTemplateAdmin($data);
    }

    public function get_room_dropdown() {
        $apartment_id = $this->input->post('apartment_id');
        $rooms = $this->cm->select_all_where("rooms", "apartment_id", $apartment_id);

        foreach ($rooms as $room) {
            $room_type = $room["room_type"] == "1" ? "Single Type" : "Double Type";
            echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - ($room_type)" . "</option>";
        }
    }
    
    public function get_room_dropdown2() {
        $apartment_id = $this->input->post('apartment_id');
        $rooms = $this->cm->select_all_where("rooms", "apartment_id", $apartment_id);

        echo "<option value='0'>All</option>";
        foreach ($rooms as $room) {
            $room_type = $room["room_type"] == "1" ? "Single Type" : "Double Type";
            echo "<option value='" . $room['id'] . "'>" . $room['id'] . " - ($room_type)" . "</option>";
        }
    }

    public function get_search_result() {

        $input_apartment_id = $this->input->post('apartment_id');
        $input_room_id = $this->input->post('room_id');
        $input_date_from = $this->input->post('date_from');
        $input_date_to = $this->input->post('date_to');
        $data = array();
        if ($input_apartment_id == "0") {
            $apartments = $this->cm->select_all("apartment_detail");
        } else {
            $apartments = $this->cm->select_all_where("apartment_detail", "id", $input_apartment_id);
        }
        $rooms = array();
        $booked = array();

        $all_rent_from_date = array();
        $all_rent_to_date = array();

        foreach ($apartments as $apartment) {
            $apartment_id = $apartment["id"];
            if ($input_room_id != "0") {
                $all_rooms = $this->cm->select_all_with_2_where("rooms", "apartment_id", $apartment_id, "id", $input_room_id);
            } else {
                $all_rooms = $this->cm->select_all_where("rooms", "apartment_id", $apartment_id);
            }

            //apartmentwise booked room selection    
            foreach ($all_rooms as $value) {
                $room_id = $value["id"];
                
                //select all the booked schedules of a particular room
                $booked[$apartment_id][$room_id] = $this->calendar_model->select_booked_list_by_room_id($apartment_id, $room_id);
                
                //now, from each booking
                foreach($booked[$apartment_id][$room_id] as $booking) {
                    $count = count($booking);
                    if($input_date_from != "") {
                        if($count) {$all_rent_from_date[$apartment_id][] = sqldate($input_date_from,"-","d-m-Y"); }
                    } else {
                        if($count) {$all_rent_from_date[$apartment_id][] = $booking["rent_from"]; }
                        //$all_rent_from_date[$apartment_id][] = count($booking) ? $booking["rent_from"] : "0000-00-00";
                    }
                    
                    if($input_date_to != "") {
                        if($count) {$all_rent_to_date[$apartment_id][] = sqldate($input_date_to,"-","d-m-Y"); }
                        //$all_rent_to_date[$apartment_id][] = count($booking) ? date("Y-m-d", strtotime($input_date_to)) : "0000-00-00";
                    } else {
                         if($count) {$all_rent_to_date[$apartment_id][] = $booking["rent_to"]; }
                        //$all_rent_to_date[$apartment_id][] = count($booking) ? $booking["rent_to"] : "0000-00-00";
                    }
                }
            }

            $rooms[$apartment["id"]] = $all_rooms;
        }
        //echo $this->input->post("apartment_id");
        $data["apartments"] = $apartments;
        $data["rooms"] = $rooms;
        $data["booked"] = $booked;
        $data["all_rent_from_date"] = $all_rent_from_date;
        $data["all_rent_to_date"] = $all_rent_to_date;
        echo $this->load->view("calendar_view_ajax", $data, true);
    }
    
    
    public function newc() {
        
        $current_month_number = date("n");
        $this->session->set_userdata('month', $current_month_number);
        $this->session->set_userdata('year', date("Y"));
        
        $data = array();
        $data['header']['title'] = "Calendar";
        $data['header']['menu_base'] = "slot";
        $data['body']['page'] = "calendar";
        $data['body']["month_number"] = $current_month_number;
        $data['body']["month_name"] = get_month_name($current_month_number);
        $data['body']["month_days"] = get_month_days($current_month_number);
        $data['body']["year"] = date("Y");
        $data['body']['apartments'] = $this->cm->select_all("apartment_detail");
        
        makeTemplateAdmin($data);
    }
    
    public function next_previous()
    {
        $month_number = $this->session->userdata("month");
        $year = $this->session->userdata("year");
        
        $next_or_previous = $this->input->post("next_or_previous");
        $apartment_id = $this->input->post("apartment_id");
        
        if($next_or_previous == "next"){
            $m = $month_number+1;
            
            if($m>12) {
                $month_number = 1;
                $year = $year+1;
            }
            else {
                $month_number = $m;
            }
        }
        
        if($next_or_previous == "previous"){
            $m = $month_number-1;
            
            if($m == 0) {
                $month_number = 12;
                $year = $year-1;
            }
            else {
                $month_number = $m;
            }
        }
        
        $this->session->set_userdata('year', $year);
        $this->session->set_userdata('month', $month_number);
        
        $data = array();
        $data["month_number"] = $month_number;
        $data["month_name"] = get_month_name($month_number);
        $data["month_days"] = get_month_days($month_number);
        
        if($apartment_id) {
            $data["apartments"] = $this->cm->select_all_where("apartment_detail","id",$apartment_id);
        } 
        else {
            $data["apartments"] = $this->cm->select_all("apartment_detail");
        }
        
        $data["year"] = $year;
        $data["form_room_id"] = $this->input->post("room_id");
        echo $this->load->view("calendar_new_ajax",$data, true);
    }

}

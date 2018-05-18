<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Generalcost_model
 * This class is for managing reports
 * @author Md. Asif Rahman
 */
class Reports_model extends CI_Model {

    /**
     * This method is used to list the cost per apartment
     * @param null
     * @return $obj
     */
    public function per_apartment_inout_cash() {
        if($this->input->get('from_month') && $this->input->get('to_month') && $this->input->get('apartment_id')) {
            $fromdate = str_replace('/', '-', $this->input->get('from_month'));
            $start_date = date('Y-m-01', strtotime($fromdate));

            $todate = str_replace('/', '-', $this->input->get('to_month'));
            $query_date = date('Y-m-01', strtotime($todate));
            $end_date = date('Y-m-t', strtotime($query_date));

            //$this->db->select('*,sum(oc_amount) as total_cost,sum(revenue_amount) as total_revenue');
            $this->db->select('*,oc_amount as total_cost, revenue_amount as total_revenue');
            $this->db->from('cost');
            //$this->db->group_by('apartment_id');
            $this->db->where('apartment_id', $this->input->get('apartment_id'));
            $this->db->where('date(payment_status_update_date) BETWEEN "'. $start_date. '" and "'. $end_date.'"');
            $this->db->where('payment_status', 1);
            return $this->db->get()->result();
        } else {
            return false;
        }
    }

    /**
     * This method is used to list the cost per tenant
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    public function get_rooms_in_apartment($apartment_id){
        $this->db->select('a.*, b.address');
        $this->db->from('rooms a');
        $this->db->join('apartment_detail b', 'a.apartment_id = b.id');

        if($apartment_id>0) {
            $this->db->where('a.apartment_id', $apartment_id);
        }
        $this->db->order_by('a.apartment_id', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * This method is used to filter by app id, room id, period date
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    public function get_rooms_by_filter(){
        $apartment_id = $this->input->get('apartment_id');
        $room_id = $this->input->get('room_id');
        $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
        $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

        if($apartment_id && $room_id && $from_month && $to_month) {
            /*SELECT b.*, c.address, c.floor, a.rent_from, a.rent_to FROM apartment_booked_list a
            join rooms b on a.room_id = b.id
            join apartment_detail c on a.apartment_id = c.id
            WHERE UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('2017-01-01') AND UNIX_TIMESTAMP(a.rent_to) <= UNIX_TIMESTAMP('2017-11-30')
            AND a.room_id = '1'
            AND a.apartment_id = '3' group by b.id order by a.room_id asc*/

            $this->db->select('b.*, a.room_id, c.address, c.floor, a.rent_from, a.rent_to');
            $this->db->from('apartment_booked_list a');

            $this->db->join('rooms b', 'a.room_id = b.id');
            $this->db->join('apartment_detail c', 'a.apartment_id = c.id');

            if($apartment_id>0) {
                $this->db->where('a.apartment_id', $apartment_id);
            }
            if($room_id>0) {
                $this->db->where('a.room_id', $room_id);
            }

            //$this->db->where("(UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')) AND (UNIX_TIMESTAMP(a.rent_to) <= UNIX_TIMESTAMP('$to_month'))");
            $this->db->where("(UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')) AND (UNIX_TIMESTAMP(a.rent_from) <= UNIX_TIMESTAMP('$to_month'))");
            $this->db->group_by('b.id');
            $this->db->order_by('a.room_id', 'asc');

            $query = $this->db->get();
            $filter_data = $query->result_array();
            array_walk($filter_data, function(&$val){
                $val['period'] = $this->get_empty_period($val['apartment_id'], $val['id']);
                $val['first_from_date'] = $this->get_first_booking_from_date($val['apartment_id'], $val['id']);
                $val['last_from_date'] = $this->get_last_booking_from_date($val['apartment_id'], $val['id']);
                $val['last_to_date'] = $this->get_last_booking_to_date($val['apartment_id'], $val['id']);
            });
            /*echo "<pre>";
            print_r($filter_data).exit;*/
            return $filter_data;
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
     * This method is used to filter by app id, room id, period date
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    private function get_empty_period($apartment_id, $room_id) {

        //$apartment_id = $this->input->get('apartment_id');
        //$room_id = $this->input->get('room_id');
        $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
        $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

        /*$query = $this->db->query("select *from apartment_booked_list a
        where date(a.rent_from) >= '2017-04-01' and date(a.rent_to) <= '2017-11-25' and
        a.room_id = '1' and a.apartment_id = '3' order by a.rent_from asc");*/

        $this->db->select('*');
        $this->db->from('apartment_booked_list a');
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')");
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) <= UNIX_TIMESTAMP('$to_month')");
        $this->db->where('a.room_id', $room_id);
        $this->db->where('a.apartment_id', $apartment_id);
        $this->db->order_by('a.rent_from', 'asc');
        $query = $this->db->get();

        $bookings = $query->result_array();

        $count = count($bookings);
        $period = array();
        foreach ($bookings as $key=>$val) {
            $rent_from = $val['rent_from'];
            $rent_to = $val['rent_to'];

            $newFromDate = $rent_to;

            if($key == $count-1) {
                $newToDate = $newFromDate;//date('Y-m-d');
            } else {
                $newToDate = $bookings[$key+1]['rent_from']; //$key+1 means next day from date
            }

            $different = $this->date_diff_now($newFromDate, $newToDate);

            if($different > 1) {
                $pre_date1 = date('d-m-Y', strtotime($newFromDate . ' +1 day'));
                $pre_date2 = date('d-m-Y', strtotime($newToDate . ' -1 day'));
                $period[$key]['period_date'] = $pre_date1." to ".$pre_date2;
                $period[$key]['period_day'] = $different-1;
            }
        }
        return $period;
    }


    /**
     * This method is used to filter by app id, room id and get last booking TO DATE
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    private function get_last_booking_to_date($apartment_id, $room_id) {
        $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
        $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

        /*SELECT a.rent_to FROM `apartment_booked_list` `a` WHERE UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('2017-01-01') AND UNIX_TIMESTAMP(a.rent_to) <= UNIX_TIMESTAMP('2017-11-30') AND `a`.`room_id` = '1' AND `a`.`apartment_id` = '3' ORDER BY `a`.`rent_to` desc limit 1*/

        $this->db->select('a.rent_to');
        $this->db->from('apartment_booked_list a');
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')");
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) <= UNIX_TIMESTAMP('$to_month')");

        $this->db->where('a.room_id', $room_id);
        $this->db->where('a.apartment_id', $apartment_id);

        $this->db->order_by('a.rent_to', 'desc');
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row('rent_to');
    }

    /**
     * This method is used to filter by app id, room id and get last booking FROM DATE
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    private function get_last_booking_from_date($apartment_id, $room_id) {
        $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
        $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

        /*SELECT a.rent_to FROM `apartment_booked_list` `a` WHERE UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('2017-01-01') AND UNIX_TIMESTAMP(a.rent_to) <= UNIX_TIMESTAMP('2017-11-30') AND `a`.`room_id` = '1' AND `a`.`apartment_id` = '3' ORDER BY `a`.`rent_to` desc limit 1*/

        $this->db->select('a.rent_from');
        $this->db->from('apartment_booked_list a');
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')");
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) <= UNIX_TIMESTAMP('$to_month')");

        $this->db->where('a.room_id', $room_id);
        $this->db->where('a.apartment_id', $apartment_id);

        $this->db->order_by('a.rent_from', 'desc');
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row('rent_from');
    }

    /**
     * This method is used to filter by app id, room id and get last booking FROM DATE
     * @param null
     * @return array
     * @author Razib Mahmud
     */
    private function get_first_booking_from_date($apartment_id, $room_id) {
        $from_month = sqldate($this->input->get('from_month'),'-','d-m-Y');
        $to_month = sqldate($this->input->get('to_month'),'-','d-m-Y');

        /*SELECT a.rent_to FROM `apartment_booked_list` `a` WHERE UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('2017-01-01') AND UNIX_TIMESTAMP(a.rent_to) <= UNIX_TIMESTAMP('2017-11-30') AND `a`.`room_id` = '1' AND `a`.`apartment_id` = '3' ORDER BY `a`.`rent_to` desc limit 1*/

        $this->db->select('a.rent_from');
        $this->db->from('apartment_booked_list a');
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) >= UNIX_TIMESTAMP('$from_month')");
        $this->db->where("UNIX_TIMESTAMP(a.rent_from) <= UNIX_TIMESTAMP('$to_month')");

        $this->db->where('a.room_id', $room_id);
        $this->db->where('a.apartment_id', $apartment_id);

        $this->db->order_by('a.rent_from', 'asc');
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row('rent_from');
    }


    /**
     * This method is used to list the cost per tenant
     * @param null
     * @return $obj
     */
    public function per_tenant_inout_cash() {
        if($this->input->get('from_month') && $this->input->get('to_month') && $this->input->get('tenant_user_id')) {
            $fromdate = str_replace('/', '-', $this->input->get('from_month'));
            $start_date = date('Y-m-01', strtotime($fromdate));

            $todate = str_replace('/', '-', $this->input->get('to_month'));
            $query_date = date('Y-m-01', strtotime($todate));
            $end_date = date('Y-m-t', strtotime($query_date));

            //$this->db->select('c.*,u.name,u.family_name,sum(c.oc_amount) as total_cost, sum(c.revenue_amount) as total_revenue');
            $this->db->select('c.*,u.name,u.family_name,c.oc_amount as total_cost, c.revenue_amount as total_revenue');
            $this->db->from('cost as c');
            $this->db->join('user as u', 'u.id=c.tenant_user_id');
            //$this->db->group_by('c.tenant_user_id');
            //$this->db->where('c.tenant_user_id!=', 0);

            if($this->input->get('tenant_user_id') > 0) {
                $this->db->where('tenant_user_id', $this->input->get('tenant_user_id'));
            }
            $this->db->where('date(payment_status_update_date) BETWEEN "'. $start_date. '" and "'. $end_date.'"');
            $this->db->where('payment_status', 1);

            return $this->db->get()->result();
        } else {
            return false;
        }
    }

    public function per_owner_inout_cash() {
        if($this->input->get('from_month') && $this->input->get('to_month') && $this->input->get('onwers_id')) {
            $fromdate = str_replace('/', '-', $this->input->get('from_month'));
            $start_date = date('Y-m-01', strtotime($fromdate));

            $todate = str_replace('/', '-', $this->input->get('to_month'));
            $query_date = date('Y-m-01', strtotime($todate));
            $end_date = date('Y-m-t', strtotime($query_date));
            //$this->db->select('c.*,ad.owner,u.name,u.family_name,sum(c.oc_amount) as total_cost, sum(c.revenue_amount) as total_revenue');
            $this->db->select('c.*,u.id,u.name,u.family_name,c.oc_amount as total_cost, c.revenue_amount as total_revenue');
            $this->db->from('cost as c');
            //$this->db->join('apartment_detail as ad', 'ad.id=c.apartment_id');
            $this->db->join('user as u', 'u.id='.$this->input->get('onwers_id'));
            $this->db->where('date(payment_date) BETWEEN "'. $start_date. '" and "'. $end_date.'"');
            //$this->db->group_by('ad.owner');
            $this->db->where('c.payment_status', 1);
            return $this->db->get()->result();
        } else {
            return false;
        }
    }

    /**
     * This method is used to return cost details object
     * on the basis of the apartment id passed as parameter
     * @param $apartment_id int
     * @return $obj
     */
    public function cost_details($apartment_id) {
        $this->db->select('cost_type,sum(oc_amount) as total_cost');
        $this->db->from('cost');
        $this->db->where('apartment_id', $apartment_id);
        $this->db->group_by('cost_type');
        return $this->db->get()->result_array();
    }

    /**
     * This method is used to return revenue details object
     * on the basis of the apartment id passed as parameter
     * @param $apartment_id int
     * @return $obj
     */
    public function revenue_details($apartment_id) {
        $this->db->select('cost_type,sum(revenue_amount) as total_revenue');
        $this->db->from('cost');
        $this->db->where('apartment_id', $apartment_id);
        $this->db->group_by('cost_type');
        return $this->db->get()->result_array();
    }

    /**
     * This method is used to return cost details object
     * on the basis of the apartment id passed as parameter
     * @param $tenant int
     * @return $obj
     */
    public function cost_details_per_tenant($tenant_id) {
        $this->db->select('cost_type,sum(oc_amount) as total_cost');
        $this->db->from('cost');
        $this->db->where('tenant_user_id', $tenant_id);
        $this->db->group_by('cost_type');
        return $this->db->get()->result_array();
    }

    /**
     * This method is used to return revenue details object
     * on the basis of the apartment id passed as parameter
     * @param $apartment_id int
     * @return $obj
     */
    public function revenue_details_per_tenant($tenant_id) {
        $this->db->select('cost_type,sum(revenue_amount) as total_revenue');
        $this->db->from('cost');
        $this->db->where('tenant_user_id', $tenant_id);
        $this->db->group_by('cost_type');
        return $this->db->get()->result_array();
    }

    public function cost_details_per_owner($owner_id){

        $this->db->select('c.cost_type,sum(c.oc_amount) as total_cost');
        $this->db->from('cost as c');
        $this->db->join('apartment_detail as ad', 'ad.id=c.apartment_id');

        $this->db->group_by('c.cost_type');
        $this->db->where("(ad.owner = $owner_id AND c.payment_status = 1)");
        return $this->db->get()->result_array();
    }

    public function revenue_details_per_owner($owner_id){
        $this->db->select('c.cost_type,sum(c.revenue_amount) as total_revenue');
        $this->db->from('cost as c');
        $this->db->join('apartment_detail as ad', 'ad.id=c.apartment_id');
        $this->db->group_by('c.cost_type');
        $this->db->where("(ad.owner = $owner_id AND c.payment_status = 1)");
        return $this->db->get()->result_array();
    }

    public function apartments_allotment(){
        $this->db->select('abl.*,ad.address,ad.floor,rm.room_type,rm.qty');
        $this->db->from('apartment_booked_list as abl');
        $this->db->join('apartment_detail as ad', 'ad.id=abl.apartment_id');
        $this->db->join('rooms as rm','rm.id=abl.room_id');
        $this->db->group_by('abl.id');
        return $this->db->get()->result_array();
    }

    public function cash_flow($year){
        //$this->db->select('*,sum(oc_amount) as total_cost,sum(revenue_amount) as total_revenue');
        $this->db->select('cost.*, invoice.*,oc_amount as total_cost, owner.id as ui, tenant.id as ti, revenue_amount as total_revenue, apartment_detail.address as apt_address, apartment_detail.floor as apt_floor, CONCAT(owner.name," ",owner.family_name) as apt_owner, CONCAT(tenant.name," ",tenant.family_name) as apt_tenant, CONCAT(supplier.name," ",supplier.surname) as supplier,supplier.id as supplier_id, bm.movement_amount, bm.movement_type, supplier.company as supplier_company, r.room_description');
        $this->db->from('cost');
        $this->db->join('apartment_detail','apartment_detail.id = cost.apartment_id', 'LEFT');
        $this->db->join('user as owner','owner.id = cost.owner_user_id OR owner.id = cost.tenant_user_id', 'LEFT');
        $this->db->join('user as tenant','tenant.id = cost.tenant_user_id', 'LEFT');
        $this->db->join('suppliers as supplier','supplier.id = cost.supplier_id', 'LEFT');
        $this->db->join('bank_movement as bm','bm.cost_id = cost.id', 'LEFT');
        $this->db->join('rooms r','r.id = cost.room_id','LEFT');
        $this->db->join('invoice', 'cost.invoice_id = invoice.id', 'LEFT');
        if($year){
            $this->db->where("DATE(payment_date) BETWEEN '".date('Y-m-d')."' AND '".$year."'");
        }else{
            $this->db->where("DATE(payment_date) BETWEEN '".date('Y').'-01-01'."' AND '".date('Y').'-12-31'."'");
        }
        $this->db->order_by('payment_date','ASC');
        //$this->db->where("payment_status",1);
        return $this->db->get()->result();
    }

    public function previous_year_initial_amount($year) {
        if($year){
            $year = (date('Y',  strtotime($year))-1);
        }else{
            $year = (date('Y')-1);
        }
        $this->db->select('(sum(revenue_amount)-sum(oc_amount)) as initial_amount');
        $this->db->from('cost');
        $this->db->where("YEAR(payment_date) = $year");
        //$this->db->where("payment_status",1);
        return $this->db->get()->row('initial_amount');
    }

    public function get_filtered_booking_date($apartment_id, $room_id, $from_date, $to_date)
    {
        $this->db->select('rent_from,rent_to');
        $this->db->from('apartment_booked_list');
        $this->db->where('apartment_id',$apartment_id);
        $this->db->where('room_id',$room_id);
         $this->db->where("UNIX_TIMESTAMP(rent_from) >= UNIX_TIMESTAMP('$from_date') AND UNIX_TIMESTAMP(rent_from) <= UNIX_TIMESTAMP('$to_date')");
         return $this->db->get()->result_array();
    }
}

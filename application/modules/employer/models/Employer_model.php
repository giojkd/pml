<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class Employer_Model extends CI_Model {

    function get_all_requests($user_id = 0) {
        if ($user_id) {
            $this->db->where('assigned_to', $user_id);
        } else {
            $this->db->select('tenant_request.*, user.name, user.family_name');
            $this->db->join('user', 'user.id = user_id');
        }
        $query = $this->db->get('tenant_request');
        return $query->result_array();
    }

    function get_feedback_messages($request_id, $last_id = 0) {
        $this->db->select('request_feedback.*, DATE_FORMAT(request_feedback.create_date, "%d-%b-%Y %h:%i %p") as create_date,user.name, user.family_name');
        $this->db->from('request_feedback');
        $this->db->join('user', 'user.id = request_feedback.user_id', 'LEFT');
        $this->db->where('request_id', $request_id);
        $this->db->where('request_feedback.id > ' . $last_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function make_all_feedback_seen($request_id) {
        $user_id = getUserdata('user_id');
        $this->db->where('request_id', $request_id);
        $this->db->where('user_id !=' . $user_id);
        $this->db->where('seen', 0);
        return $this->db->update('request_feedback', array('seen' => 1));
    }

    function get_unseen_feedback_message_requests($request_ids) {
        $this->db->select('request_feedback.request_id');
        $this->db->from('request_feedback');
        $this->db->where_in('request_id', $request_ids);
        $this->db->where('user_id !=' . getUserdata('user_id'));
        $this->db->where('seen', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_feedback($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    function get_feedback_images($request_id = 0) {

        $this->db->where('request_id', $request_id);
        $query = $this->db->get('request_feedback_image');
        return $query->result_array();
    }
    
    public function insert_feedback_images($file_name, $orig_name, $req_id)
    {
        

                $data_feed['request_id'] = $req_id;
                $data_feed['image_name'] = $file_name;
                $data_feed['orig_name'] = $orig_name;

                $this->db->insert('request_feedback_image', $data_feed);


                copy("./uploads/feedback_temp/" . $file_name, "./uploads/feedback_file/" . $file_name);
                unlink("./uploads/feedback_temp/" . $file_name);
                return true;
    }
    
     function get_all($table_name, $select = '*', $conditions = array(), $order = array(), $range = array(), $group_by = array(), $is_object = TRUE) {
        $this->db->select($select);
        $this->db->from($table_name);

        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $result = $this->db->get();
        return $result->result_array();
     }

}

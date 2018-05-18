<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class User_Model
 */
class Settings_model extends CI_Model {

    public function get_settings() {

        return $this->db->get('settings');
    }

    public function update_settings($settings) {
        $set = $this->input->post();
        //print_r($set).exit;
        $count = 0;
        foreach ($set as $name => $value) {
            $this->db->from('settings');
            $this->db->where('set_name', $name);
            $is_exist = $this->db->count_all_results();
            if ($is_exist) {
                $this->db->where('set_name', $name);
                $data = array('set_value' => $value);
                $this->db->update('settings', $data);
                $count = $count + $this->db->affected_rows();
            }else{
                $data['set_value'] = $value;
                $data['set_name'] = $name;
                $this->db->insert('settings', $data);
            }
        }

        if(isset($_FILES["home_banner"]) && $_FILES["home_banner"]["name"]) {
            $file_name = "banner_"."_".time();
            $upload_return = uploadImage("home_banner",$file_name, 'slideshow/');
            $images_name = $upload_return['upload_data']['file_name'];

            $this->db->from('settings');
            $this->db->where('set_name', 'home_banner');
            $is_exist = $this->db->count_all_results();

            if ($is_exist) {
                $this->db->where('set_name', 'home_banner');
                $data = array('set_value' => $images_name);
                $this->db->update('settings', $data);
                $count = $count + $this->db->affected_rows();
            } else {
                $data['set_value'] = $images_name;
                $data['set_name'] = 'home_banner';
                $this->db->insert('settings', $data);
            }
        }
        //exit;


        //Below is only for email settings
        if ($settings == "email_settings") {
            if (!$this->input->post('ini_notification')) {
                $this->db->where('set_name', 'ini_notification');
                $data = array('set_value' => '0');
                $this->db->update('settings', $data);
                $count = $count + $this->db->affected_rows();
            }
        }


        return $count;
    }

}

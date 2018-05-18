<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * Authentication Model
 *
 * @author Md. Faisal Alam
 */
class Authentication_model  extends CI_Model {
    //put your code here

    public function check_credential($email,$password){
        $user_password_crypt = md5($password);
        $is_user = $this->db->where('email',$email)
                ->where('password',$user_password_crypt)
                ->where('status',1)
                ->get('user');
        if($is_user->num_rows()){
            $user = $is_user->row();
            $userdata['user_email'] = $user->email;
            $userdata['user_type'] = user_type_text($user->type);
            $userdata['user_name'] = $user->name;
            $userdata['user_family_name'] = $user->family_name;
            $userdata['user_id'] = $user->id;
            if($user->type == 1){
                $userdata['is_admin'] = TRUE;
            }else{
                $userdata['is_admin'] = FALSE;
            }
            return $userdata;
        }else{
            return false;
        }
    }

    public function activate_account($id){
        $data["status"] = 1;
        $data["update_date"] = date("Y-m-d H:i:s");
        $this->db->where("id",$id);
        return $this->db->update("user",$data);
    }
    
    public function check_email($email){
        $this->db->from("user");
        $this->db->where("email",$email);
        return $this->db->count_all_results();
    }
    
    // public function forgot_pw_token($user_email){
    //     $data['pw_forgot_token'] = random_string('alnum', 16);
    //     $data['pw_forgot_email'] = $user_email;
    //     $data['pw_forgot_req_date'] = date("Y-m-d H:i:s");
    //     if($this->db->insert("user_forgot_pw",$data)){
    //         return $data['pw_forgot_token'];
    //     }else{
    //         return FALSE;
    //     }
    // }
    
    // public function chk_forgot_pw_token($email,$token){
    //     $this->db->where("pw_forgot_email",$email);
    //     $this->db->order_by("pw_forgot_req_date","desc");
    //     $this->db->limit(1);
    //     $query = $this->db->get("user_forgot_pw");
    //     if($query->num_rows()){
    //         $row = $query->row();
    //         if($row->pw_forgot_token == $token){
    //             return TRUE;
    //         }else{
    //             return FALSE;
    //         }
    //     }else{
    //         return FALSE;
    //     }
    // }
    
    // public function reset_pw($email,$token){
    //     if($this->chk_forgot_pw_token($email,$token)){
    //         $user_password = $this->input->post("user_pw");
    //         $user_password_crypt = crypt($user_password,$this->config->item('pwsalt'));
            
    //         $this->db->where("pw_forgot_token",$token)
    //                 ->where("pw_forgot_email",$email)
    //                 ->update("user_forgot_pw",array("pw_forgot_status"=>1));
            
    //         return $this->db->where("user_email",$email)
    //                 ->update("user",array("user_password"=>$user_password_crypt));
    //     }else{
    //         return FALSE;
    //     }
    // }

}

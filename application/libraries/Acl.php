<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl {



    /**
     * This function is called from hook when a controller constructor is just loaded. This function checks if a usertype has access in provided controller/methods. The rule is written in config/config_acl
     * @param string $controller
     * @param string $method
     * @param string $user_type
     * @return boolean If TRUE, got access otherwise restricted
     * @author Ashikur Rahman
     */
    public function check_access($controller, $method, $user_type){
        $CI = &get_instance();
        //$CI->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
        if($user_type){
            $logged_in = TRUE;
        }else{
            $logged_in = FALSE;
        }

        /*if ( ! $acl_config = $CI->cache->get('config_acl'))
        {
            $acl_config = $CI->load->config("config_acl",TRUE);
            $CI->cache->save('acl_config', $acl_config, 300);
            // Save into the cache for 5 minutes
        }        */

        $acl_config = $CI->load->config("config_acl",TRUE);
        $acl = $acl_config['acl'];
        //$acl_allow = isset($acl_config['acl']['allow'])?$acl_config['acl']['allow']:array();
        //$acl_restrict = isset($acl_config['acl']['restrict'])?$acl_config['acl']['restrict']:array();
        $return = FALSE;


        if(isset($acl[$controller]["_allow"])){
           //Checking if this controller is whitelisted for this user type
            if($logged_in && in_array($user_type, $acl[$controller]["_allow"])){
                $return = TRUE;  //allowed for this user type
            }elseif($logged_in && in_array("logged_in", $acl[$controller]["_allow"])){
                $return = TRUE;  //restricted for guest user type
            }elseif(in_array("all_users", $acl[$controller]["_allow"])){
                $return = TRUE;  //any user is allowed
            }elseif(!$logged_in && in_array("guest", $acl[$controller]["_allow"])){
                $return = TRUE;  //only for guest user type
            }
        }

        if(isset($acl[$controller][$method]["_allow"])){
           //Checking if this method is whitelisted for this user type
            if($logged_in && in_array($user_type, $acl[$controller][$method]["_allow"])){
                $return = TRUE;  //allowed for this user type
            }elseif($logged_in && in_array("logged_in", $acl[$controller][$method]["_allow"])){
                $return = TRUE;  //restricted for guest user type
            }elseif(in_array("all_users", $acl[$controller][$method]["_allow"])){
                $return = TRUE;  //any user is allowed
            }elseif(!$logged_in && in_array("guest", $acl[$controller][$method]["_allow"])){
                $return = TRUE;  //only for guest user type
            }
        }

        if(isset($acl[$controller][$method]["_allow_only"])){
           //Checking if this controller is whitelisted for this user type
            if($logged_in && in_array($user_type, $acl[$controller][$method]["_allow_only"])){
                $return = TRUE;  //allowed for this user type
            }else{
                $return = FALSE; // Otherwise restricts, might overwrite _allow
            }
        }



        if(isset($acl[$controller]["_restrict"])){
           //Checking if this controller is blacklisted for this user type
            if($logged_in && in_array($user_type, $acl[$controller]["_restrict"])){
                $return = FALSE;  //restricted for this user type
            }elseif(!$logged_in && in_array("guest", $acl[$controller]["_restrict"])){
                $return = FALSE;  //restricted for guest user type
            }elseif($logged_in && in_array("logged_in", $acl[$controller]["_restrict"])){
                $return = FALSE;  //restricted for logged in users
            }
        }

        if(isset($acl[$controller][$method]["_restrict"])){
            //Checking if this method is blacklisted for this user type
            if($logged_in && in_array($user_type, $acl[$controller][$method]["_restrict"])){
                $return = FALSE;  //restricted for this user type
            }elseif(!$logged_in && in_array("guest", $acl[$controller][$method]["_restrict"])){
                $return = FALSE;  //restricted for guest user type
            }elseif($logged_in && in_array("logged_in", $acl[$controller][$method]["_restrict"])){
                $return = FALSE;  //restricted for logged in users
            }
        }

        return TRUE;#TEMPFIX

        if($return === TRUE){
           // echo "allowed";
            return TRUE;
        }else{
          //  echo "restricted";
            return FALSE;
        }
    }

}

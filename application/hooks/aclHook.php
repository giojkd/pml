<?php
/**
 * This hook class will be loaded on post_controller_constructor event
 * @author Ashikur Rahman
 */
class aclHook{
    /**
     * This function is called on post-controller-constructor event to decide the language
     * 
     */
 
    
    public function process_acl(){
        $CI = &get_instance();
        $CI->load->library("acl");
        $class = $CI->router->fetch_class();
        $method = $CI->router->fetch_method();
        $type = getUserdata("user_type");
        $check = $CI->acl->check_access($class,$method,$type);
        if($check !== TRUE){
            if($CI->input->is_ajax_request()){
                if(getUserdata() === FALSE){
                    echo "logged out";
                }else{
                    echo "restricted";
                }
                die();
            }else{
                echo "You are not authorized here...";
                sleep(2);
                if(getUserdata() === FALSE){
                    redirect_tr('authentication/login?redirectto='.current_url_tr());
                }else{
                    redirect_tr();
                }
                die();
            }
            
        }
    }
    
}
?>

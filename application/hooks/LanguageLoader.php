<?php
class LanguageLoader
{
    public function language_set(){
        
        $CI = &get_instance();
        
        $lang = language_array(); //calling helper function to load all languages in an array

        $lang_code = $CI->uri->segment(1,'cn');
        if($lang_code){
            if(array_key_exists($lang_code, $lang)){
                //$CI->config->set_item('base_url', $CI->config->item('base_url').$lang_code.'/');
                
                $language = array(
                    "lang_code"=>$lang_code,
                    "lang_name"=>$lang[strtolower($lang_code)]['lang_name'],
                    "lang_flag"=>$lang[strtolower($lang_code)]['lang_flag']
                );    
                
            }else{
                
                $language = array(
                    "lang_code"=>$CI->config->item('lang_code_default'),
                    "lang_name"=>$CI->config->item('lang_default'),
                    "lang_flag"=>$CI->config->item('lang_flag_default')
                );      
                
            }
                $CI->session->set_userdata($language);
                $CI->config->set_item('language', $language["lang_name"]);
                $CI->lang->load('common');
                //$CI->config->set_item('base_url', base_url().$language["lang_code"].'/');  
        }
        
    }
	
    /**
     * This method is used to load controller-wise language file. 
     * Controller-wise language mapping is kept in config_lang (in config folder)
     * @author Ashikur Rahman
     */
    public function language_load() {
        $CI = &get_instance();
        $lang_map = $CI->load->config('config_lang', TRUE, TRUE);
        $class = $CI->router->fetch_class();

        if (array_key_exists($class, $lang_map)) {

            if (is_array($lang_map[$class])) {
                foreach ($lang_map[$class] as $lang) {
                    $CI->lang->load($lang);
                }
            } else {
                $CI->lang->load($lang_map[$class]);
            }
        }
    }
	
}
<?php
/**
 * @package helper functions
 */
/** 
 * This function will generate template for the admin panel
 * @param array $data array that should contain atleast $data['body']['page'] as it is responsible to load the declared page!
 * @author Ashikur Rahman
 */

function makeTemplateAdmin($data=array()){
    $CI = &get_instance();
    extract($data);
    $header['menu_base'] = isset($header['menu_base'])?$header['menu_base']:"";
    $header['menu_sub'] = isset($header['menu_sub'])?$header['menu_sub']:"";
    $header = isset($header)?$header:"";
    $footer = isset($footer)?$footer:"";
    $CI->load->view('admin/header',$header);
    $CI->load->view($body['page'],$body);
    $CI->load->view('admin/footer',$footer);
}

/**
* This function will generate front end template
*/
function makeTemplate($data=array()){
    $CI = &get_instance();
    extract($data);
    $header = isset($header)?$header:"";
    $footer = isset($footer)?$footer:"";
    $CI->load->view('header',$header);
    $CI->load->view($body['page'],$body);
    $CI->load->view('footer',$footer);
}


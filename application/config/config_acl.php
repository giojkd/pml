<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This is the configuration file for user management
 * user types: admin
 * Parameters are: _allow, _allow_only, _restrict
 * User type: all_users, logged_in, guest
 */
//acl management
$config['acl']['dashboard']["_allow"] = array("logged_in");

$config['acl']['authentication']["_allow"] = array("all_users");
$config['acl']['common_ajax']["_allow"] = array("all_users");
$config['acl']['app_api']["_allow"] = array("all_users");

$config['acl']['settings']["_allow"] = array("admin");
$config['acl']['user']["_allow"] = array("admin");
$config['acl']['user']['edit']["_allow"] = array("all_users");
$config['acl']['user']['editsave']["_allow"] = array("all_users");
$config['acl']['apartment']["_allow"] = array("admin");
$config['acl']['apartment']["_allow"] = array("admin","sales");
$config['acl']['calendar']["_allow"] = array("admin");

$config['acl']['stock']["_allow"] = array("backend_user","admin");
$config['acl']['general_cost']["_allow"] = array("backend_user","admin");
$config['acl']['outgoing']["_allow"] = array("backend_user","admin");
$config['acl']['revenue']["_allow"] = array("backend_user","admin");
$config['acl']['tenant']["_allow"] = array("tenant","backend_user","admin");
$config['acl']['tenant']["request_feedback"]["_allow"] = array("employer","external_maintainer","admin");
$config['acl']['tenant']["send_message"]["_allow"] = array("employer","external_maintainer","admin");
$config['acl']['tenant']["refresh_feedback"]["_allow"] = array("employer","external_maintainer","admin");
$config['acl']['tenant']["refresh_feedback_request_list"]["_allow"] = array("employer","external_maintainer","admin");
$config['acl']['tenant']["make_all_feedback_seen"]["_allow"] = array("employer","external_maintainer","admin");
$config['acl']['employer']["_allow"] = array("employer","external_maintainer","admin");


$config['acl']['reports']["_allow"] = array("backend_user","admin");


$config['acl']['cron']["_allow"] = array("all_users");
$config['acl']['test']["_allow"] = array("all_users");

$config['acl']['wifirouter']["_allow"] = array("backend_user","admin");
$config['acl']['mobilepackage']["_allow"] = array("backend_user","admin");

$config['acl']['invoice']["_allow"] = array("backend_user","admin");
$config['acl']['bank']["_allow"] = array("backend_user","admin");

$config['acl']['supplier']["_allow"] = array("admin");
$config['acl']['docusign']["_allow"] = array("all_users");

/*
 * Added by Razib Mahmud
 * */
$config['acl']['utilitybills']["_allow"] = array("admin");

/*
 * Added by Imrul Hossain
 * */
$config['acl']['cleaning']["_allow"] = array("backend_user","admin");
$config['acl']['source']["_allow"] = array("admin");


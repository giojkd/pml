<?php

/**
 * @package helper functions
 */

/**
 * Return cost type by string
 * @param int $id
 * @return string
 * @author Razib Mahmud
 */
function get_cost_type_label($id) {
    switch($id) {
    case '1':
        $cost_type='Water';
        break;
    case '2':
        $cost_type='Gas';
        break;
    case '3':
        $cost_type='Electricity';
        break;
    case '4':
         $cost_type='Internet';
        break;
    case '5':
         $cost_type='Council Tax';
        break;
    default:
         $cost_type='';
    }
    return $cost_type;
}

/**
 * Return multilingual url depending on the current language
 * @param string $url
 * @return string
 * @author Ashikur Rahman
 */
function base_url_tr($url = "") {
    $CI = & get_instance();
    $lang = $CI->session->userdata('lang_code');
    if (!$lang || ($lang == $CI->config->item('lang_code_default'))) {
        return base_url($url);
    } else {
        return base_url() . $lang . '/' . $url;
    }
}

/**
 * Return translated current url based on language passed
 * @param string $lang_code
 * @return string
 * @author Ashikur Rahman
 */
function current_url_tr($lang_code = "") {
    $CI = &get_instance();
    if ($CI->config->item('lang_code_default') == $lang_code) {
        $lang_code = "";
    }
    $uri_string = uri_string();
    $current_uri = "";
    $current_uri_seg = explode("/", $uri_string);
    if (strlen($current_uri_seg[0]) == 2) {
        $current_uri_seg[0] = $lang_code;
        $current_uri = implode("/", $current_uri_seg);
    } else {
        $current_uri = $lang_code . '/' . $uri_string;
    }
    if ($_SERVER['QUERY_STRING']) {
        $current_uri .= "?" . $_SERVER['QUERY_STRING'];
    }
    $current_uri = base_url($current_uri);
    return $current_uri;
}

/**
 * Modified redirect() function to direct user to url with proper language
 * @param string $url
 * @author Ashikur Rahman
 */
function redirect_tr($url = "") {
    redirect(base_url_tr($url), 'refresh');
}

/**
 * Helper function to get an array of avalable language stored in db
 * @return array eg: array("en"=>array("lang_code"=>"en","lang_name"=>"english","lang_flag"=>"gb"))
 * @author Ashikur Rahman
 */
function language_array() {

    $ci = & get_instance();
    $ci->load->database();

    $ci->db->select('lang_code, lang_name, lang_flag');
    $ci->db->where('lang_status', 1);
    $ci->db->order_by('lang_order', 'asc');
    $query = $ci->db->get('language');

    $languages = array();

    foreach ($query->result_array() as $row) {
        $languages[$row['lang_code']] = $row;
    }

    //$_SESSION["languages"] = $languages;

    return $languages;
}

/**
 * helper function to generate language select selector dropdown html (bootstrap compatible)
 * @return string html codes
 * @author Ashikur Rahman
 */
function language_selector() {
    $CI = & get_instance();

    $selector = "";
    $current_lang = ucfirst($CI->session->userdata('lang_name'));
    $selector = '<li class="dropdown dropdown-language"><a type="button"class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="flag-icon flag-icon-' . $CI->session->userdata('lang_flag') . '"></i> ' . $current_lang . '<i class="fa fa-angle-down"></i></a> ';
    $selector .= '<ul class="dropdown-menu dropdown-menu-default">';

    $languages = language_array();
    foreach ($languages as $code => $lang) {
        $selector .= '<li><a href="' . current_url_tr($lang['lang_code']) . '"><i class="flag-icon flag-icon-' . $lang['lang_flag'] . '"></i> ' . ucfirst($lang['lang_name']) . '</a></li>';
    }

    $selector .= '</ul></li>';
    //$selector .= '</select>'."\n";
    return $selector;
}

/**
 * helper function to generate language selector dropdown html (bootstrap compatible). This is the smaller version used in logged in top nav
 * @return string html codes
 * @author Ashikur Rahman
 */
function language_selector_small() {
    $CI = & get_instance();

    $selector = "";

    $selector = '<button type="button"  data-toggle="dropdown"  class="btn btn-danger dropdown-toggle artdata_curla artdata_curla_top" id="menu_language"><i class="flag-' . $CI->session->userdata('lang_flag') . '"></i> <span class="caret"></span></button>';
    $selector .= '<ul class="dropdown-menu artdata_curla_drop languageClass" role="menu">';

    $languages = language_array();
    foreach ($languages as $code => $lang) {
        $selector .= '<li><a class="change_language" id="' . $lang['lang_code'] . '" href="' . current_url_tr($lang['lang_code']) . '"><i class="flag-' . $lang['lang_flag'] . '"></i> ' . ucfirst($lang['lang_name']) . '</a></li>';
    }

    $selector .= '</ul>';
    //$selector .= '</select>'."\n";
    return $selector;
}

function get_preferences($user_id, $column = NULL) {
    $CI = & get_instance();
    $result = $CI->db->where('user_id', $user_id)->get('preferences')->row();
    if (!empty($column) && !empty($result)) {
        return $result->$column;
    }
    return $result;
}

/**
 * Helper function to get sql formatted date
 * @param string $date input date that needs to be formatted
 * @param string $seperator default seperator is "-". It is provided to identify date seperator properly
 * @param string $format default format is d-m-Y
 * @return string date in SQL format
 * @author Ashikur Rahman
 */
function sqldate($date, $seperator = "-", $format = "d-m-Y") {
    if ($date) {
        $d = explode($seperator, $date);
        $f = explode($seperator, $format);

        $dd[$f[2]] = $d[2];
        $dd[$f[1]] = $d[1];
        $dd[$f[0]] = $d[0];

        //$finaldate = $m;
        return $dd['Y'] . "-" . $dd['m'] . "-" . $dd['d'];
    } else {
        return false;
    }
}

/**
 * Get d-m-Y formatted date from sql formatted date
 * @param string $d sql formatted date
 * @return string d-m-Y formatted date
 * @author Jamiul Hasan
 */
function mydate($d, $seperator = "-") {
    if ($d == "0000-00-00") {
        return "";
    }
    $d = explode("-", $d);
    $year = $d[0];
    $month = $d[1];
    $day = $d[2];

    $finaldate = $day . $seperator . $month . $seperator . $year;
    return $finaldate;
}

/**
 * This function is used to generate password hash
 * @param string $user_password
 * @return string hashed password. Hash string is set in configuration page
 * @author Ashikur Rahman
 */
function adPWCrypt($user_password) {
    $CI = & get_instance();
    $pwsalt = $CI->config->item('pwsalt');
    return crypt($user_password, $pwsalt);
}

/**
 * This is a helper function to set an alert (by setting up flash session) and redirect to the desired url. So after redirection, alert will be displayed
 * @param string $url
 * @param string $alert alert message that needs to be displayed
 * @param string $alertType
 * @author Ashikur Rahman
 */
function redirectAlert($url, $alert, $alertType = "success") {
    $CI = & get_instance();
    $CI->session->set_flashdata('alertmsg', $alert);
    $CI->session->set_flashdata('alertType', $alertType);
    redirect_tr($url);
}

/**
 * @ignore
 */
function showAlert($msg) {
    $CI = & get_instance();
    $CI->output->append_output("<script>show_alert('$msg');</script>");
}

/**
 * This function has been used to identify the default language
 * @param string $lang_code
 * @return boolean
 * @author Ashikur Rahman
 */
function chkDefaultLang($lang_code) {
    $CI = & get_instance();
    if ($lang_code && ($lang_code == $CI->config->item('lang_code_default'))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * This function has been used to identify the default language
 * @param string $lang_code
 * @return boolean
 * @author Ashikur Rahman
 */
function chkCurrentLang($lang_code) {
    $CI = & get_instance();
    if ($lang_code && ($lang_code == getLanguage())) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * This function has been used to fetch the default language code
 * @return string
 * @author Ashikur Rahman
 */
function getDefaultLang() {
    $CI = & get_instance();
    return $CI->config->item('lang_code_default');
}

/**
 * This function has been used to fetch the current loaded language code
 * @return string
 * @author Ashikur Rahman
 */
function getLanguage() {
    $CI = & get_instance();
    return $CI->session->userdata('lang_code');
}

/**
 * This function has been used to upload an image
 * @param string $field_name
 * @param string $file_name
 * @param string $folder
 * @param integer
  x_width
 * @param integer $max_height
 * @return array
 * @author Ashikur Rahman
 */
function uploadImage($field_name = "userfile", $file_name = "", $folder = "feedback_temp/", $max_width = "6000", $max_height = "6000", $min_width = "200", $min_height = "200") {
    $CI = & get_instance();
    $config['upload_path'] = './uploads/' . $folder;
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '6144';
    $config['max_width'] = $max_width;
    $config['max_height'] = $max_height;
    $config['min_width'] = $min_width;
    $config['min_height'] = $min_height;
    if ($file_name) {
        $config['file_name'] = $file_name;
    } else {
        $config['encrypt_name'] = TRUE;
    }


    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload($field_name)) {

        return array('error' => $CI->upload->display_errors());
    } else {
        return array('upload_data' => $CI->upload->data());
    }
}

/**
 * This function has been used to upload a file
 * @param string $field_name
 * @param string $file_name
 * @param string $folder
 * @param integer $max_size
 * @return array
 * @author Ashikur Rahman
 * @author Jamiul Hasan
 */
function uploadFile($field_name = "userfile", $file_name = "", $folder = "feedback_temp/", $max_size = "10000") {
    $CI = & get_instance();
    $config['upload_path'] = './uploads/' . $folder;
    $config['allowed_types'] = 'doc|docx|pdf|txt|mp3|wav|m4a|oga|jpg|csv|jpg|jpeg|png';
    $config['max_size'] = $max_size;
    if ($file_name) {
        $config['file_name'] = $file_name;
    } else {
        $config['encrypt_name'] = TRUE;
    }

    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload($field_name)) {
        return array('error' => $CI->upload->display_errors());
    } else {
        return array('upload_data' => $CI->upload->data());
    }
}

/**
 * This function has been used to resize an image during upload
 * @param string $imgsrc
 * @param integer $width
 * @param integer $height
 * @param string $newimgsrc
 * @param boolean $maintainratio
 * @author Ashikur Rahman
 */
function resizeImage($imgsrc, $width, $height, $newimgsrc = "", $maintainratio = TRUE) {
    $CI = & get_instance();
    $CI->load->library('image_lib');
    $config['image_library'] = 'gd2';
    $config['source_image'] = $imgsrc;
    if ($newimgsrc) {
        $config['new_image'] = $newimgsrc;
    }
    $config['maintain_ratio'] = $maintainratio;
    $config['width'] = $width;
    $config['height'] = $height;
    $CI->image_lib->initialize($config);

    $CI->image_lib->resize();
    $CI->image_lib->clear();
}

/**
 * This function has been used to save cropped images
 * @param integer $x1
 * @param integer $x2
 * @param integer $y1
 * @param integer $y2
 * @param string $imgsrc
 * @param string $newimgsrc
 * @param integer $cropwidth
 * @param integer $cropheight
 * @return boolean
 * @author Ashikur Rahman
 */
function saveCroppedImage($x1, $x2, $y1, $y2, $imgsrc, $newimgsrc, $cropwidth = 100, $cropheight = 100) {
    $CI = & get_instance();
    $data = array();
    $filename = $imgsrc;
    $image_info = getimagesize($filename);
    if ($image_info['mime'] == 'image/png') {
        $image = imagecreatefrompng($filename);
    } else if ($image_info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($filename);
    } else {
        $image = imagecreatefromjpeg($filename);
    }

    $width = imagesx($image);
    $height = imagesy($image);
    if (($x1 == "") && ($y1 == "") && ($x2 == "") && ($y2 == "")) {
        $realrat = $width / $height;
        $croprat = $cropwidth / $cropheight;

        if ($realrat < $croprat) {
            $factor = $width / $cropwidth;
            $cropwidth_new = $width;
            $cropheight_new = $cropheight * $factor;
        } else {
            $factor = $height / $cropheight;
            $cropwidth_new = $cropwidth * $factor;
            $cropheight_new = $height;
        }

        $x1 = $width / 2 - $cropwidth_new / 2;
        $x2 = $width / 2 + $cropwidth_new / 2;
        $y1 = $height / 2 - $cropheight_new / 2;
        $y2 = $height / 2 + $cropheight_new / 2;
    }

    $resized_width = ((int) $x2) - ((int) $x1);
    $resized_height = ((int) $y2) - ((int) $y1);
    //$resized_width = 340;  //We are maintaining the ratio in clientside. Now lets resize to our required size
    // $resized_height = 230;
    $resized_image = imagecreatetruecolor($resized_width, $resized_height);
    //$resized_image = imagecreatetruecolor(340, 230);
    imagecopyresampled($resized_image, $image, 0, 0, (int) $x1, (int) $y1, $width, $height, $width, $height);
    $new_file_name = $newimgsrc;
    imagejpeg($resized_image, $new_file_name);
    //$data['cropped_image'] = $img_name;
    //$data['cropped_image_axis'] = (int)$x1.",".(int)$y1.",".(int)$x2.",".(int)$y2;
    imagedestroy($resized_image);
    return true;
}

/**
 * @ignore
 */
function afterSubmitProcess($pagename, $url, $msg, $type, $alert_type = 1) {
    $CI = & get_instance();
    if (!$CI->input->is_ajax_request()) {
        redirectAlert($url, $msg, $type);
    } else {
        $url = $url ? base_url_tr($url) : "";
        showAlertGrowl($msg, $type, $url, $pagename, $alert_type);
    }
}

/**
 * @ignore
 */
function showAlertGrowl($msg, $type, $url = "", $pagename = "", $alert_type = 1) {
    echo json_encode(array("msg" => $msg, "type" => $type, "url" => $url, "pagename" => $pagename, "alert_type" => $alert_type));
}

/**
 * Get user detail of current user (from session)
 * @param type $key Provide if only particular field should be returned (email,type,displayName,user_id,is_admin)
 * @return mixed
 */
function getUserdata($key = "") {

    $CI = & get_instance();
    if ($CI->session->userdata('userdata')) {
      #print_r($CI->session->userdata('userdata'));
        $userdata = $CI->session->userdata('userdata');
        if ($key) {
            return @$userdata[$key];
        } else {
            return $userdata;
        }
    } else {
        return FALSE;
    }
}

/**
 * Helper function to get user detail
 * @param integer $user_id
 * @param string $field if blank, all fields are returned as object. If NOT blank, only provided field is returned.
 * @return mixed
 * @author Ashikur Rahman
 */
function getUser($user_id, $field = "") {
    $CI = & get_instance();
    $CI->db->where("id", $user_id);
    $result = $CI->db->get("user");

    if ($result->num_rows()) {
        $row = $result->row();
        if ($field != "") {
            return $row->$field;
        } else {
            return $row;
        }
    } else {
        return FALSE;
    }
}

/**
 * This function has been used to check whether a particular user is loggoed-in or not
 * @param integer $user_id
 * @return boolean
 * @author Ashikur Rahman
 */
function isLoggedIn($user_id = "") {
    $CI = & get_instance();
    if ($user_id == "") {
        if ($CI->session->userdata('userdata')) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if ($user_id == getUserdata("user_id")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/**
 * This function has been used to check whether an email address exists in db or not
 * @param string $email
 * @return boolean
 * @author Ashikur Rahman
 */
function isEmailExist($email) {
    $CI = & get_instance();
    $CI->db->where("email", $email);
    $result = $CI->db->get("user");

    if ($result->num_rows()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Makes an array of settings table. Return all the rows and makes an array like this: field1 => value1, field2 => value2
 * @return array
 * @author Jamiul Hasan
 * @author Ashikur Rahman
 */
function getSettings() {
    $CI = & get_instance();

    //select settings rows from settings table
    $result = $CI->db->get("settings")->result_array();

    $settings = array();
    foreach ($result as $value) {
        $settings[$value["set_name"]] = $value["set_value"];
    }

    return $settings;
}

/**
 * This function returns a specific settings value
 * @return array
 * @author Jamiul Hasan
 * @author Ashikur Rahman
 */
function getSettingSingle($set_name) {
    $CI = & get_instance();

    //select settings rows from settings table
    $CI->db->where("set_name", $set_name);
    $q = $CI->db->get("settings");

    if ($q->num_rows()) {
        return $q->row()->set_value;
    } else {
        return FALSE;
    }
}

/**
 * @ignore
 * @param date $date
 * @return boolean
 */
function isDateZero($date) {
    if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * @ignore
 * @param date $date
 * @return boolean
 */
function getValidDate($date) {
    if ($date == '0000-00-00') {
        return "";
    } else {
        return $date;
    }
}

/**
 * This function fetches the city name from the given city ID
 * @param integer $city_id
 * @return string|boolean
 * @author Ashikur Rahman
 */
function getCityName($city_id) {
    $CI = & get_instance();
    $CI->db->select("city_name");
    $CI->db->where("city_id", $city_id);
    $city = $CI->db->get("city");
    if ($city->num_rows()) {
        return $city->row()->city_name;
    } else {
        return FALSE;
    }
}

/**
 * This function fetches the country name from the given country ID
 * @param integer $country_id
 * @return string|boolean
 * @author Ashikur Rahman
 */
function getCountryName($country_id) {
    $CI = & get_instance();
    $CI->db->select("country_shortName");
    $CI->db->where("country_id", $country_id);
    $country = $CI->db->get("country");
    if ($country->num_rows()) {
        return $country->row()->country_shortName;
    } else {
        return FALSE;
    }
}

/**
 * This function fetches the all country name
 * @param null
 * @return object|boolean
 * @author Md. Asif Rahman
 */
function getAllCountry() {
    $CI = & get_instance();
    $CI->db->select('country_id,country_shortName');
    $CI->db->from('country');
    return $CI->db->get()->result();
}

/**
 * This function fetches the all country name
 * @param null
 * @return object|boolean
 * @author Md. Asif Rahman
 */
function getAllCounty() {
    $CI = & get_instance();
    $CI->db->select('county_code,county_name');
    $CI->db->order_by('county_name','ASC');
    $CI->db->from('ini_provinces_regions');
    return $CI->db->get()->result();
}

/**
 * This function returns the latitude and longitude from the given address
 * @param string $address
 * @return array
 * @author Jamiul Hasan
 */
function getGeocode($address) {
    $cityclean = str_replace(" ", "+", str_replace("#", " ", $address)); //str_replace("-"," "$address)
    //$cityclean = urlencode($address);
    $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $cityclean . "&sensor=false";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $details_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $geoloc = json_decode(curl_exec($ch), true);

    if ($geoloc['status'] != "OK") {//when there is error
        return array("lat" => "", "long" => "");
    } else {
        $lat = $geoloc["results"][0]["geometry"]["location"]["lat"];
        $long = $geoloc["results"][0]["geometry"]["location"]["lng"];
        return array("lat" => $lat, "long" => $long);
    }
}

/**
 * This function converts from one currency to another
 * @param float $amount
 * @param string $from
 * @param integer $symbol_flag
 * @return float
 * @author Jamiul Hasan
 * @author Ashikur Rahman
 */
function currency_convert($amount, $from = "", $symbol_flag = 0, $to = "") {
    $CI = & get_instance();
    //$CI->load->helper("");
    $settings = getSettings();
    if ($from == "") {
        $from = $settings["currency_code"];
    }

    if ($to == "") {
        $to = get_currency();
    }


    if ($from == $to) {

        if ($symbol_flag == "1") {
            return ($amount * 1) . " " . getCurrencySymbol($to);
        } else {
            return ($amount * 1);
        }
    } else {
        $cokiename = $from . $to;
        if ($CI->input->cookie($cokiename)) {
            $dollarValue = $CI->input->cookie($cokiename);
        } else {
            $url = 'http://download.finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=' . $from . $to . '=X';
            $handle = fopen($url, 'r');

            if ($handle) {
                $result = fgets($handle, 4096);
                fclose($handle);
            }
            $allData = explode(',', $result); /* Get all the contents to an array */
            $dollarValue = $allData[1];

            $CI->input->set_cookie($cokiename, $dollarValue, 43200);
        }

        if ($symbol_flag == "1") {
            return number_format(($dollarValue * $amount), 2, '.', '') . " " . getCurrencySymbol();
        } else {
            return number_format(($dollarValue * $amount), 2, '.', '');
        }

        //return number_format(($dollarValue*$amount), 2, '.', '');
        //return $dollarValue*$amount;
    }
}

/**
 * This function returns the current systen currency code i.e. EUR, USD etc
 * @return string
 * @author Jamiul Hasan
 * @author Ashikur Rahman
 */
function get_currency() {
    $CI = & get_instance();

    $userdata = $CI->session->userdata('userdata');
    $user_id = $userdata['user_id'];

    if ($user_id) {
        if ($userdata['is_admin']) {
            $currency = $CI->db->where('admin_id', $user_id)->get('admin')->row()->admin_currencyCode;
        } else {
            $currency = $CI->db->where('user_id', $user_id)->get('user')->row()->user_currency;
        }


        if ($currency != "") {
            return $currency;
        } elseif ($CI->input->cookie('currency')) {
            return $CI->input->cookie('currency');
        } else {
            return "EUR";
        }
    } elseif (isset($_COOKIE['currency'])) {
        return $_COOKIE['currency'];
    } else {
        return "EUR";
    }
}

/**
 * This function returns the currency symbol from the given curreny code
 * @param string $currency_code
 * @return string|boolean
 * @author Jamiul Hasan
 * @author Ashikur Rahman
 */
function getCurrencySymbol($currency_code = "") {
    if ($currency_code == "") {
        $currency_code = get_currency();
    }

    $CI = & get_instance();
    $CI->db->select("currency_symbol");
    $CI->db->where("currency_code", $currency_code);
    $row = $CI->db->get("currency");
    if ($row->num_rows()) {
        return $row->row()->currency_symbol;
    } else {
        return FALSE;
    }
}

/**
 * This function returns the base currency code i.e. EUR
 * @return string
 * @author Ashikur Rahman
 * @author Jamiul Hasan
 */
function getBaseCurrency() {
    //$CI = & get_instance();
    $settings = getSettings();
    return $settings["currency_code"];
}

/**
 * This function returns symbol of the base currency
 * @return string|boolean
 * @author Ashikur Rahman
 * @author Jamiul Hasan
 */
function getBaseCurrencySymbol() {
    $currency_code = getBaseCurrency();
    $CI = & get_instance();
    $CI->db->select("currency_symbol");
    $CI->db->where("currency_code", $currency_code);
    $row = $CI->db->get("currency");
    if ($row->num_rows()) {
        return $row->row()->currency_symbol;
    } else {
        return FALSE;
    }
}

function prepare_language_field($field_name, $lang_code, $current_language = false) { //$field_name is array
    if ($field_name[$lang_code] == "") {
        if ($current_language == true) {
            $lang = getLanguage();
            return $field_name[$lang];
        } else {
            $lang = getDefaultLang();
            return $field_name[$lang];
        }
    } else {
        return $field_name[$lang_code];
    }
}

/**
 * Generates pagination links
 * @param string $base_url
 * @param int $total_rows
 * @param int $per_page
 * @return string
 * @author Ashikur Rahman
 */
function prepare_pagination($base_url, $total_rows, $per_page) {
    $CI = & get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = base_url($base_url);
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['uri_segment'] = $CI->uri->total_segments();

    $config["last_tag_close"] = "</li>";
    $config['full_tag_open'] = '<ul class="pagination pull-right margin-top-0 noti_paging" type="' . $base_url . '">';
    $config['full_tag_close'] = '</ul>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

/**
 * Updates user currency selection
 * @param int $user_id
 * @param string $currency
 */
function change_currency($user_id, $currency) {
    $CI = & get_instance();
    if ($user_id) {
        $CI->db->where('user_id', $user_id)->update('user', array("user_currency" => $currency));
    } else {
        setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/');
    }
}

/**
 * This function is used to get user_id from user_email
 */
function get_user_id_from_email($user_email) {
    $CI = & get_instance();
    $CI->db->select("user_id");
    $CI->db->where("user_email", $user_email);
    $q = $CI->db->get("user");
    if ($q->num_rows()) {
        $row = $q->row();
        return $row->user_id;
    } else {
        return FALSE;
    }
}

function make_no_cache() {
    header("cache-Control: no-store, no-cache, must-revalidate");
    header("cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}

function getTimeDiff($timeFirst, $timeSecond) {
    $timeFirst = strtotime($timeFirst);
    $timeSecond = strtotime($timeSecond);
    $seconds = $timeSecond - $timeFirst;

    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours * 3600)) / 60);
    $secs = floor($seconds % 60);

    return sprintf("%1$02d:%2$02d:%3$02d", $hours, $mins, $secs);
}

function print_user_log_status($log_status) {
    $log_status_string = '';

    if ($log_status == 1) {
        $log_status_string = 'Logged In';
    } elseif ($log_status == 2) {
        $log_status_string = 'Logged Out';
    } elseif ($log_status == 3) {
        $log_status_string = 'Bad Login';
    } elseif ($log_status == 4) {
        $log_status_string = 'Inactive Account';
    }

    return $log_status_string;
}

function setUserSession($data) {
    $CI = & get_instance();
    $CI->session->set_userdata('userdata', $data);
}

function getOS() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "Unknown OS Platform";

    $os_array = array(
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
            break;
        }
    }

    return $os_platform;
}

function nlang($lang, $arguments = array()) {

    $lang_value = lang($lang);
    if ($arguments) {
        foreach ($arguments as $key => $value) {
            $lang_value = str_replace("{{" . $key . "}}", $value, $lang_value);
        }
    }
//    $key1 = array_keys($arguments);
//    $key = array_map(function($val) { return '{{'.$val.'}}'; }, $key1);
//    $value = array_keys($arguments);
//    $lang_value = str_replace($key, $value, $lang_value);



    return $lang_value;
}

function get_currencies() {
    $CI = &get_instance();

    $CI->db->select("*");
    $CI->db->where("currency_status", 1);
    $CI->db->order_by("currency_order ASC, currency_code ASC");
    $results = $CI->db->get("currency")->result_array();
    $currencies = array();
    foreach ($results as $row) {
        $currencies[] = $row;
    }

    return $currencies;
}

function getTranslatedDate($date) {
    $converted_date = new DateTime($date);
    return lang('month_' . $converted_date->format('M')) . " " . $converted_date->format("j Y");
}

function breadCrumb() {
    $CI = & get_instance();
    $CI->load->library('router');
    $controller = $CI->router->fetch_class();
    $method = $CI->router->fetch_method();
    $method = ($method == 'index') ? '' : $method;
    echo '<li><a href="' . base_url($controller) . '"> ' . ucfirst(str_replace('_', ' ', $controller)) . ' </a><i class="fa fa-angle-right"></i> ' . ucfirst(str_replace('_', ' ', $method)) . ' </i></li>';
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */
if (!function_exists('array_column')) {

    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null) {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                    'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2]) && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }

}

function get_user_types() {
    $user_types = array(
        array(
            'type_code' => 1,
            'display_text' => 'Admin',
            'name' => 'admin',
        ),
        array(
            'type_code' => 2,
            'display_text' => 'Administration',
            'name' => 'backend_user',
        ),
        array(
            'type_code' => 3,
            'display_text' => 'Employer',
            'name' => 'employer',
        ),
        array(
            'type_code' => 4,
            'display_text' => 'External Maintainer',
            'name' => 'external_maintainer',
        ),
        array(
            'type_code' => 5,
            'display_text' => 'Occupant',
            'name' => 'tenant',
        ),
        array(
            'type_code' => 6,
            'display_text' => 'Owner',
            'name' => 'owner',
        ),
        array(
            'type_code' => 7,
            'display_text' => 'Commercial',
            'name' => 'sales',
        ),
        array(
            'type_code' => 8,
            'display_text' => 'Marketing',
            'name' => 'marketing',
        ),
        array(
            'type_code' => 9,
            'display_text' => 'Finance',
            'name' => 'credit',
        ),
    );
    return $user_types;
}

function user_type_text($type_id) {
    switch ($type_id):
        case '1':
            return 'admin';
            break;
        case '2':
            return 'backend_user';
            break;
        case '3':
            return 'employer';
            break;
        case '4':
            return 'external_maintainer';
            break;
        case '5':
            return 'tenant';
            break;
        case '6':
            return 'owner';
            break;
        case '7':
            return 'sales';
            break;
        case '8':
            return 'marketing';
            break;
        case '9':
            return 'credit';
            break;
        default :
            return'unknown';
            break;
    endswitch;
}
function user_type_code($type_text) {
    switch ($type_text):
        case 'admin':
            return '1';
            break;
        case 'backend_user':
            return '2';
            break;
        case 'employer':
            return '3';
            break;
        case 'external_maintainer':
            return '4';
            break;
        case 'tenant':
            return '5';
            break;
        case 'owner':
            return '6';
            break;
        case 'sales':
            return '7';
            break;
        case 'marketing':
            return '8';
            break;
        case 'credit':
            return '9';
            break;
        default :
            return'0';
            break;
    endswitch;
}

/**
 * This method is used to change status from 0 to 1 and 1 to 0
 */
function text_to_display($text) {
    return ucfirst(str_replace('_', ' ', $text));
}

/**
 * this function will change the status from 1 to 0 or 0 to 1
 * @author
 */
function change_column_status($id, $table, $col_to_change, $where_column, $redirect = NULL) {
    $CI = & get_instance();
    if (isset($id)) {
        $CI->db->query("UPDATE $table SET $col_to_change = 1 - $col_to_change, update_date='" . date('Y-m-d H:i:s') . "' WHERE 1=1 and $where_column=$id");
    }
    if ($CI->db->affected_rows() > 0) {
        redirect(base_url_tr($redirect));
    }
}

/**
 * This method is used to get all apartments data
 * according to the parameters passed
 * @param [string] $[select] [columns with comaseparated]
 * @return [odject] [objects of apartments data]
 * @author Md. Asif Rahman
 */

function get_apartments($select="*")
{
    $CI =& get_instance();
    $CI->db->select($select);
    $CI->db->from('apartment_detail');
    return $CI->db->get()->result();
}

/**
 * This method is used to format a date according to the format provided
 * in the second parameter
 * @param  [string] $date   [description]
 * @param  [string]   $format [description]
 * @return formatted_date
 * @author Md. Asif Rahman
 */

function formatted_date($date,$format)
{
    return date_format(date_create($date),$format);
}


/**
 * This method is used to list all service charges type
 * @return [array]
 * @author Asif Rahman
 * @author Jamiul Hasan
 */
function service_charges($service_type=0)
{
    $all_service_types = array(
        '1'=>'Water',
        '2'=>'Gas',
        '3'=>'Electricity',
        '4'=>'Internet',
        '5'=>'Council Tax',
    );

    if($service_type){
        return $all_service_types[$service_type];
    }
    else{
        return $all_service_types;
    }
}

    function related_to($r_to=0)
    {
        $related = array(
            //'1'=>'Owner',
            '2'=>'External',
            //'3'=>'Sales',
            '4'=>'Employer'
//            '5'=>'Tenant'
        );

        if($r_to){
            return $related[$r_to];
        }
        else{
            return $related;
        }
    }

    function related_to_for_list($r_to=0)
    {
        $related = array(
            '1'=>'Owner',
            '2'=>'External',
            '3'=>'Sales',
            '4'=>'Employer',
            '5'=>'Occupant'

        );

        if($r_to){
            return $related[$r_to];
        }
        else{
            return $related;
        }
    }

    function get_single_table_data_by_id($id="", $field = "", $table = "",$where_field="",$where_val="") {
    $CI = & get_instance();
    if($where_field)
    {
        $CI->db->where($where_field, $where_val);
    }
    else{
         $CI->db->where("id", $id);
    }

    $result = $CI->db->get($table);

    if ($result->num_rows()) {
        $row = $result->row();
        if ($field != "") {
            return $row->$field;
        } else {
            return $row;
        }
    } else {
        return FALSE;
    }
}

/**
     * This method is used to get delay payment alert
     * @return [obj]
     * @param null
     * @author Md. Asif Rahman
     */
    function get_delaya_payments_alert(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('cost as c');
        $CI->db->where('c.tenant_user_id !=',0);
        $CI->db->where('c.expired_date < ',date("Y-m-d"));
        $CI->db->where('c.payment_status_update_date','0000-00-00');
        // $CI->db->join('user', 'user.id = c.tenant_user_id');
        return $CI->db->get()->result();
    }

    function return_first_date($month_year)
    {
        $ymd = date("Y-m-d",strtotime($month_year));
        $x = explode("-",$ymd);
        return $x[0]."-".$x[1]."-"."01";
    }


    function get_tenant_name($invoice_for, $oc_id = 0, $installment_id = 0)
    {
        $CI =& get_instance();

        if($invoice_for == "1") { //installment
            $cost_details = $CI->cm->select_single_row("cost","id",$installment_id);
            $tenant_user_id = $cost_details["tenant_user_id"];
            $user_details = $CI->cm->select_single_row("user","id",$tenant_user_id);
            return $user_details["name"]." ".$user_details["family_name"]." ".($user_details["company_name"]?"(".$user_details["company_name"].")":"");
        }

        if($invoice_for == "2") { //oc
            $cost_details = $CI->cm->select_single_row("cost","id",$oc_id);

            if($cost_details["if_to_tenant"]){
                $tenant_user_id = $cost_details["tenant_user_id"];
                $user_details = $CI->cm->select_single_row("user","id",$tenant_user_id);
                return $user_details["name"]." ".$user_details["family_name"]." ".($user_details["company_name"]?"(".$user_details["company_name"].")":"");
            }
            else {
                return "";
            }
        }
    }

    function get_month_days($month_number)
    {
        $months = array("1"=>31,"2"=>28,"3"=>31,"4"=>30,"5"=>31,"6"=>30,"7"=>31,"8"=>31,"9"=>30,"10"=>31,"11"=>30,"12"=>31);
        return $months[$month_number];
    }

    function get_month_name($month_number)
    {
        $months = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
        return $months[$month_number];
    }

    function alertIconShow() {
        $CI = & get_instance();
        $CI->db->select('apartment_booked_list.*,user.name,user.family_name, apartment_detail.id as apartment_id, apartment_detail.address, apartment_booked_list.id as booking_id');
        $CI->db->from('apartment_booked_list');
        $CI->db->join('user', 'apartment_booked_list.user_id = user.id');
        $CI->db->join('apartment_detail', 'apartment_booked_list.apartment_id = apartment_detail.id');
        $CI->db->where('apartment_booked_list.accounting_notify_status',"1");
        $CI->db->order_by("apartment_booked_list.rent_to","asc");
        $row = $CI->db->get();

        if ($row->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

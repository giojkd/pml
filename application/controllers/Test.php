<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent :: __construct();
        /* if (!$this->input->is_ajax_request()) {
          redirect('404');
          } */
    }

    public function index() {
        
    }

    public function abc() {
        //create_pdf($this->load->view("card/card_fm","",true));
        $this->load->view("card/card_fm2");
    }

    public function success() {
        $data = array();
        $data['body']['page'] = 'success';
        $data['header']['page_active'] = "home";
        $data['header']['page_title'] = "Success";

        makeTemplate($data);
    }

    public function lookup($string) {

        $string = str_replace(" ", "+", urlencode($string));
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $string . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            return null;
        }

        //print_r($response);
        $geometry = $response['results'][0]['geometry'];

        $array = array(
            'latitude' => $geometry['location']['lat'],
            'longitude' => $geometry['location']['lng'],
            'location_type' => $geometry['location_type'],
        );

        return $array;
    }

    public function mapu() {


        $city = 'Via Mannelli, 147 50132 Florence, Italy';

        $array = $this->lookup($city);
        print_r($array);
    }

    public function chosen() {
        $data = array();
        $data['body']['page'] = 'success';
        $data['header']['page_active'] = "home";
        $data['header']['page_title'] = "Success";

        makeTemplate($data);
    }

    public function check_mail() {
        $this->load->library('dataemail');
        //$this->dataemail->email_for_fisherman_pdf_card_test(18);
        //$this->dataemail->send_email_by_gmail_smtp("jamiulh@gmail.com", "Test Email", "This is a test email Jami");
        $this->dataemail->send_email_phpmailer_by_gmail_smtp("jamiulh@gmail.com", "Test Email", "This is a test email Jami");
    }

    public function copyfm() {
        $CI = &get_instance();
        $all_fm = $CI->common_model->select_all("fisherman");
        $x = 0;

        foreach ($all_fm as $fm) {
            $fm_id = $fm["fm_id"];
            $exist = $CI->common_model->exist_or_not("user", "fm_id", $fm_id);

            if (!$exist) {
                $data = array();
                $data["user_type"] = "fisherman";
                $data["shop_id"] = 0;
                $data["fm_id"] = $fm_id;
                $data["user_email"] = $fm["fm_email"];
                $data["user_password"] = md5("789789");
                $data["entry_date"] = date("Y-m-d");
                $data["update_date"] = date("Y-m-d");

                $CI->common_model->insert("user", $data);

                $x++;
            }
        }

        echo "Complete = " . $x;
    }

    public function date1() {
        echo "Ccurrent Date Time: " . date("Y-m-d H:i:s"), "<br><br>";
        $day = 5;
        $rent_from = "2018-03-01";
        $rent_to = "2018-04-10";



        $temp_payment_date = date("Y-m") . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
        $next_month_date = date('Y-m-d', strtotime("+1 months", strtotime($temp_payment_date)));

        $installment_date = strtotime($temp_payment_date) > strtotime($rent_from) ? $temp_payment_date : $next_month_date;


        $total_rented_month = date_diff(new DateTime($rent_to), new DateTime($rent_from));

        for ($i = 0; $i < $total_rented_month->m; $i++) {
            $timestamp = strtotime("+$i months", strtotime($installment_date)); // returns timestamp
            echo $next_installment_date = date('Y-m-d', $timestamp), "<br>";
        }

        //var_dump($d1->diff($d2)->m); // int(4)
    }

    public function ashraf() {
        $rent_from = "2018-11-01";
        $rent_to = "2022-01-28";

        $year1 = date('Y', strtotime($rent_from));
        $year2 = date('Y', strtotime($rent_to));

        $month1 = date('m', strtotime($rent_from));
        $month2 = date('m', strtotime($rent_to));

        $year_diff = $year2 - $year1;

        if ($year_diff > 0) {
            echo ((12-$month1)+1)+$month2+(($year_diff-1)*12);
        } else {
            echo ($month2 - $month1) + 1;
        }
    }
    
    
    public function asif()
    {
        //var_dump($d1->diff($d2)->m); // int(4)
        $d1 = new DateTime("2018-03-01");
        $d2 = new DateTime("2019-06-30");

        echo ($d1->diff($d2)->m)+1; // int(4)
    }

    /*
      public function abcd()
      {
      $result = $this->db->query("SELECT user_type,user_email, COUNT(*) c FROM user GROUP BY user_email HAVING c > 1");
      $rows = $result->result_array();

      //echo "<pre>";
      //print_r($rows);

      foreach($rows as $value)
      {
      $user_email = $value["user_email"]; //user email that is getting repeated
      $same_email_users = $this->common_model->select_all_where("user","user_email",$user_email);

      //print_r($same_email_users);

      foreach($same_email_users as $user)
      {
      if($user["user_type"] == "fisherman")
      {
      $fm_id = $user["fm_id"];

      if($fm_id != "0")
      {
      //update the fisherman table
      $fisherman_table = array();
      $fisherman_table["fm_email"] = "";
      $fisherman_table["fm_email_alternative"] = $user["user_email"];

      $this->db->where("fm_id",$fm_id);
      $this->db->update("fisherman",$fisherman_table);

      //update the user table
      $user_table = array();
      $user_table["user_email"] = "";

      $this->db->where("fm_id",$fm_id);
      $this->db->update("user",$user_table);
      }
      }
      }

      }


      echo "complete";
      }
     */
    
    public function test_email()
    {
        $this->load->library("email_manager");
        $x = $this->email_manager->send_email("federico@ict-euro.com","test email","this is a test email","jami@ict-euro.com", "");
        
        if($x)
        {
            echo "ok";
        }
        else
        {
            echo "not ok";
        }
        
    }
    
    
    function docusign(){
        echo '<pre>';
        $info = $this->docusign_login_information();
        print_r($info);
        // construct the authentication header:
        $header = '{
                        "status": "sent",
                        "emailSubject": "Request a signature via email example",
                        "documents": [
                          {
                            "documentId": "1",
                            "name": "contract.pdf",
                            "fileExtension": "pdf",
                            "documentBase64": "'.chunk_split(base64_encode(file_get_contents('uploads/p.pdf'))).'"
                          }
                        ],
                        "recipients": {
                          "signers": [
                            {
                              "name": "Ashraful",
                              "email": "ashraf@yopmail.com",
                              "recipientId": "1",
                              "tabs": {
                                "signHereTabs": [
                                  {
                                    "xPosition": "25",
                                    "yPosition": "50",
                                    "documentId": "1",
                                    "pageNumber": "1"
                                  }
                                ]
                              }
                            }
                          ]
                        }
                    }';

        /////////////////////////////////////////////////////////////////////////////////////////////////
        // STEP 1
        /////////////////////////////////////////////////////////////////////////////////////////////////
        $url = "https://demo.docusign.net/restApi/v2/accounts/$info->accountId/envelopes";
        //echo $url;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-DocuSign-Authentication: $header"));
        
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        print curl_error($curl);
        echo $status;
        if ($status != 200) {
            echo '<br>'."Error webservice 2nd part, status is:" . $status;
            exit(-1);
            //return false;
        }
        echo '<pre>';
        print_r(json_decode($json_response));
//        $response = json_decode($json_response);
//        return $response->loginAccounts[0];
    }

    function docusign_login_information() {
        
        // Input your info here:
        $integratorKey = '42593062-832d-47b7-aa3c-f271ff83ceba';
        $email = 'ashraf@ict-euro.com';
        $password = 'tushar01670514940';
        $name = 'Tushar';

        // construct the authentication header:
        $header = '{"Username": "'.$email.'","Password": "'.$password.'","IntegratorKey": "'.$integratorKey.'"}';

        /////////////////////////////////////////////////////////////////////////////////////////////////
        // STEP 1 - Login (to retrieve baseUrl and accountId)
        /////////////////////////////////////////////////////////////////////////////////////////////////
        $url = "https://demo.docusign.net/restapi/v2/login_information";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-DocuSign-Authentication: $header"));
        
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($status != 200) {
//            echo "Error calling webservice, status is:" . $status;
//            exit(-1);
            return false;
        }
//        echo '<pre>';
//        print_r(json_decode($json_response));
        $response = json_decode($json_response);
        return $response->loginAccounts[0];
    }
    
    
    
    public function abcd()
    {
        $this->load->library("docusign");
        $testConfig = $this->docusign->signatureRequest();
        
        //echo "<pre>";
        //print_r($testConfig);
        
        /*
        if(!empty($testConfig->getAccountId())){
            echo "login ok";
        } 
        */
    }
}

<?php
require_once(APPPATH."third_party/DocuSign/autoload.php");
//require_once(APPPATH."third_party/DocuSign/testConfig.php");

class Docusign
{
    public function signatureRequest($recipient_email="", $recipient_name="", $documentFileName="", $documentName="")
    {
        $username = "massimiliano@mgc-group.it";
        $password = "Massimassi";
        $integrator_key = "93fd25d2-168d-44f1-bca0-2dae7523249e"; 
        
        
        //$username = "jami789@yopmail.com";
        //$password = "123456";
        //$integrator_key = "b725121b-da0b-45ae-a4bc-48f93f712893";     

        // change to production (www.docusign.net) before going live
        $host = "https://demo.docusign.net/restapi";

        // create configuration object and configure custom auth header
        $config = new DocuSign\eSign\Configuration();
        $config->setHost($host);
        $config->setSSLVerification(false);
        $config->addDefaultHeader("X-DocuSign-Authentication", "{\"Username\":\"" . $username . "\",\"Password\":\"" . $password . "\",\"IntegratorKey\":\"" . $integrator_key . "\"}");

        // instantiate a new docusign api client
        $apiClient = new DocuSign\eSign\ApiClient($config);
        $accountId = null;
        
        try 
        {
            //*** STEP 1 - Login API: get first Account ID and baseURL
            $authenticationApi = new DocuSign\eSign\Api\AuthenticationApi($apiClient);
            $options = new \DocuSign\eSign\Api\AuthenticationApi\LoginOptions();
            $loginInformation = $authenticationApi->login($options);
            
            if(isset($loginInformation) && count($loginInformation) > 0)
            {
                
                $loginAccount = $loginInformation->getLoginAccounts()[0];
                $host = $loginAccount->getBaseUrl();
                $host = explode("/v2",$host);
                $host = $host[0];
	
                // UPDATE configuration object
                $config->setHost($host);
		
                // instantiate a NEW docusign api client (that has the correct baseUrl/host)
                $apiClient = new DocuSign\eSign\ApiClient($config);
	
                if(isset($loginInformation))
                {
                    $accountId = $loginAccount->getAccountId();
                    if(!empty($accountId))
                    {
                        $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi($apiClient);
                        
                        // webhook notifications to use from the DocuSign platform    
                        $envelope_events = [
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("sent"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("delivered"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("completed"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("declined"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("voided"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("sent"),
                            (new \DocuSign\eSign\Model\EnvelopeEvent())->setEnvelopeEventStatusCode("sent")
                        ];

                        $recipient_events = [
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("Sent"),
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("Delivered"),
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("Completed"),
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("Declined"),
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("AuthenticationFailed"),
                            (new \DocuSign\eSign\Model\RecipientEvent())->setRecipientEventStatusCode("AutoResponded")
                        ];
                        
                        $webhook_url = base_url()."apartment/docusign/reply";
                        
                        $event_notification = new \DocuSign\eSign\Model\EventNotification();
                        //$event_notification->setUrl("https://www.scuolamusicafiesole.it/smfonline/test/reply");
                        $event_notification->setUrl($webhook_url);
                        $event_notification->setLoggingEnabled("false");
                        $event_notification->setRequireAcknowledgment("true");
                        $event_notification->setUseSoapInterface("false");
                        $event_notification->setIncludeCertificateWithSoap("false");
                        $event_notification->setSignMessageWithX509Cert("false");
                        $event_notification->setIncludeDocuments("false");
                        $event_notification->setIncludeEnvelopeVoidReason("true");
                        $event_notification->setIncludeTimeZone("true");
                        $event_notification->setIncludeSenderAccountAsCustomField("false");
                        $event_notification->setIncludeDocumentFields("false");
                        $event_notification->setIncludeCertificateOfCompletion("false");
                        $event_notification->setEnvelopeEvents($envelope_events);
                        $event_notification->setRecipientEvents($recipient_events);
                        
                        //select the document to send for signature
			$document = new DocuSign\eSign\Model\Document();
			$document->setDocumentBase64(base64_encode(file_get_contents($documentFileName)));
			$document->setName($documentName);
			$document->setDocumentId("1");

			// set the signature position in the documwnt
			$signHere = new \DocuSign\eSign\Model\SignHere();
			$signHere->setXPosition("375");
			$signHere->setYPosition("680");
			$signHere->setDocumentId("1");
			$signHere->setPageNumber("16");
			$signHere->setRecipientId("1");

			$tabs = new DocuSign\eSign\Model\Tabs();
			$tabs->setSignHereTabs(array($signHere));

			$signer = new \DocuSign\eSign\Model\Signer();
			$signer->setEmail($recipient_email);
			$signer->setName($recipient_name);
			$signer->setRecipientId("1");
			$signer->setTabs($tabs);
                        
                        // Add a recipient to sign the document
			$recipients = new DocuSign\eSign\Model\Recipients();
			$recipients->setSigners(array($signer));

                        // instantiate a new envelope object and configure settings
                        $envelop_definition = new DocuSign\eSign\Model\EnvelopeDefinition();
                        $envelop_definition->setEmailSubject("Signature Request in Contract");
                        $envelop_definition->setRecipients($recipients);
			$envelop_definition->setDocuments(array($document));
                        $envelop_definition->setEventNotification($event_notification);
                        
                        // set envelope status to "sent" to immediately send the signature request
                        $envelop_definition->setStatus("sent");

                        // optional envelope parameters
                        $options = new \DocuSign\eSign\Api\EnvelopesApi\CreateEnvelopeOptions();
                        $options->setCdseMode(null);
                        $options->setMergeRolesOnDraft(null);

                        // create and send the envelope (aka signature request)
                        //$envelopeApi = new DocuSign\eSign\Api\EnvelopesApi($apiClient);
                        $envelop_summary = $envelopeApi->createEnvelope($accountId, $envelop_definition, $options);
                        
                        if(!empty($envelop_summary))
                        {
                            //echo $webhook_url;
                            return $envelop_summary;
                        }
                    }
                }
            }
        }
        catch (DocuSign\eSign\ApiException $ex)
        {
            //echo "Exception: " . $ex->getMessage() . "\n";
            return 0;
        }
    }
    
    	
    
    
    
    
    
}

?>
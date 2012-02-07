<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * New Yorker Hotel
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file without previous authorization.
 * Mark all changes made to the original file
 *
 * @category    NYH
 * @package     libraries - OWS
 * @author 		Nam Bok Rausis
 * @copyright   Copyright (c) 2011 New Yorker Hotel Management Co. (http://www.nyhotel.com)
 * @license     EULA
**/

class OWS_soap extends OWS_xml
{
	/*
	 * Variables
	 */
	
	/**
	 * response
	 * 
	 * @var		string
	 * @access	public
	 */
	public $response;
	
	/**
	 * response_success
	 * 
	 * @var		bool
	 * @access	public
	 */
	public $response_success;
	
	/**
	 * response_error
	 * 
	 * @var		string
	 * @access	public
	 */
	public $response_error;
	
	/**
	 * endpoint_url
	 * 
	 * @var		string
	 * @access	protected
	 */
	protected $endpoint_url;
	
	/**
	 * request_file
	 * 
	 * @var		string
	 * @access	protected
	 */
	protected $request_file;
	
	/**
	 * base request file
	 * 
	 * @var		string
	 * @access	protected
	 */
	protected $base_request_file;
	
	/**
	 * query
	 * 
	 * @var		string
	 * @access	private
	 */
	private $query;
	
	// --------------------------------------------------------------------
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function __construct()
	{	
		parent::__construct();
		
		require_once APPPATH.'libraries/nuSOAP/nusoap.php';
		
		$this->base_request_file = $this->CI->ny_core->__get_config("reservations/ows_api/base");
		
		$this->response = "";
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * set_request
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	protected function __set_request($end_point_url)
	{
		$this->endpoint_url = $end_point_url;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * __run
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	protected function __run($xml_request, $soap_action, $GSD_err = FALSE)
	{
		//get service status
		$status_service = $this->CI->model_admin_system->check_service("OWS");
		
		$this->response_success = FALSE;
			
		$client = new nusoap_client($this->endpoint_url, true);
	  	
		$client->soap_defencoding = 'utf-8';
  		
		$client->useHTTPPersistentConnection();
		
		//$proxy = $client->getProxy();
		
  		$this->response = $client->send($xml_request, $this->base_request_file.$soap_action);
  		
		if ($client->fault) 
		{
			$this->response_success = FALSE;
		} 
		else 
		{
			// Check for errors
			$err = $client->getError();
			if ($err) 
			{
				$this->response_error = $err;
				$this->response_success = FALSE;
				
				error_log("server encounter a problem while sending a request to ".$this->endpoint_url, 0);
				
				//if notification has not been sent
				if($status_service->status == "active")
				{
					$data["service"] = "OWS";
					$data["status"]	 = "down";
					$data["message"] = "server encounter a problem while sending a request";
					$data["err"]	 = $err;
					
					$email_cotent = $this->CI->load->view("email/OWS/server_system_health_error", $data, TRUE);
					
					$this->CI->load->library('NY_emailer');
					$this->CI->ny_emailer->set_message($email_cotent);
					
					//notify administrators
					$this->CI->ny_emailer->send("itgroup@nyhotel.com", "SYSTEM NOTIFICATION - SERVICE OWS DOWN");
					
					$this->CI->ny_emailer->send("nrausis@unification.org", "SYSTEM NOTIFICATION - SERVICE OWS DOWN");
						
					$this->CI->model_admin_system->Update("OWS", "down");
				}
				
			} 
			else 
			{
				//if service is restore
				if($status_service->status == "down")
				{
					$data["service"] = "OWS";
					$data["status"]	 = "active";
					$data["message"] = "service OWS restored";
						
					$email_cotent = $this->CI->load->view("email/OWS/server_system_health_error", $data, TRUE);
						
					$this->CI->load->library('NY_emailer');
					$this->CI->ny_emailer->set_message($email_cotent);
					
					//notify administrators
					$this->CI->ny_emailer->send("itgroup@nyhotel.com", "SYSTEM NOTIFICATION - SERVICE OWS RESTORED");

					$this->CI->ny_emailer->send("nrausis@unification.org", "SYSTEM NOTIFICATION - SERVICE OWS DOWN");
						
					
					$this->CI->model_admin_system->Update("OWS", "active");
				
				}
				
				if(key_exists("!resultStatusFlag", $this->response["Result"]) )
				{	
					if($this->response["Result"]["!resultStatusFlag"] == "SUCCESS")
						$this->response_success = TRUE;
				}

				if(!$this->response_success) 
				{					
					if(!key_exists("Text", $this->response["Result"]) )
						$GSD_err = TRUE;
						
					if($GSD_err)
					{
						if(key_exists("GDSError", $this->response["Result"]))
							$this->response_error = "<b>Error (code ".$this->response["Result"]["GDSError"]["!errorCode"].") </b><br />".$this->response["Result"]["GDSError"]["!"];
						else 
							$this->response_error = $this->response["Result"]["Text"]["TextElement"];		
					}
					else
						$this->response_error = $this->response["Result"]["Text"]["TextElement"];
				}
			}
		}
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_soap Class

/* End of file OWS_soap.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_soap.php */
?>
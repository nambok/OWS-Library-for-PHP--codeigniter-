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

class OWS_core
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
	 * @var		bool
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
		require_once APPPATH.'libraries/nuSOAP/nusoap.php';
		
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
	protected function __run($xml_request, $soap_action)
	{		
		$client = new nusoap_client($this->endpoint_url, true);
	  	
		$client->soap_defencoding = 'utf-8';
  		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();

  		$this->response = $proxy->send($xml_request, $soap_action);
  		
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
			} 
			else 
			{
				$this->response_success = TRUE;
			}
		}
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_core Class

/* End of file OWS_core.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_core.php */
?>
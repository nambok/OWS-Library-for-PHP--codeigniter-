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

class OWS_soap_security extends OWS_soap
{
	/*
	 * Variables
	 */
	
	/**
	 * 
	 * 
	 * @var		
	 * @access	
	 */
	
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
		
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/security"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Authenticate User
 	 * 
 	 * Authenticates a user and returns the name identifier, given 
 	 * the membership number, lastname, and password
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function AuthenticateUser($data)
	{
		$soap_request = $this->__build_request("Security/AuthenticateUser.xml", $data);
		
		parent::__run($soap_request, "Security.wsdl#AuthenticateUser");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * GeneratePassword
 	 * 
 	 * 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function GeneratePassword($data)
	{
		$soap_request = $this->__build_request("Security/GeneratePassword.xml", $data);
		
		parent::__run($soap_request, "Security.wsdl#GeneratePassword");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdatePassword
 	 * 
 	 * 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function UpdatePassword($data)
	{
		$soap_request = $this->__build_request("Security/UpdatePassword.xml", $data);
		
		parent::__run($soap_request, "Security.wsdl#UpdatePassword");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_soap_security Class

/* End of file OWS_soap_security.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_soap_security.php */
?>
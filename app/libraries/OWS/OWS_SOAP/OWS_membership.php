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

class OWS_membership extends OWS_soap
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
		
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/membership"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchEnrollmentCode
 	 * 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FetchEnrollmentCode($data)
	{
		$soap_request = $this->__build_request("Membership/FetchEnrollmentCode.xml", $data);
		
		parent::__run($soap_request, "Membership.wsdl#FetchEnrollmentCode");
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdateEnrollmentCode
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function UpdateEnrollmentCode($data)
	{
		$soap_request = $this->__build_request("Membership/UpdateEnrollmentCode.xml", $data);
		
		parent::__run($soap_request, "Membership.wsdl#UpdateEnrollmentCode");
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_membership Class

/* End of file OWS_membership.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_membership.php */
?>
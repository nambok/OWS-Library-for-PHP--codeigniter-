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

class OWS_availability extends OWS_soap
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
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/availability"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Retireves a list of availables rooms and rates. The user should provideat
 	 * least date range, hotel criteria, number of rooms, total guests, and 
 	 * number of children. Rate range or plans, rate tiers, alternate date
 	 * searches, and search by membership number, specific room type or
 	 * block criteria are also allowed
 	 * 
 	 * Setting the summaryOnly flag to true resuts in General Availability
 	 * request and setting the flag to false results in Detail Availability
 	 * request
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function Availability($data)
	{
		$soap_request = $this->__build_request("Availability/GeneralAvailability.xml", $data);
		
		parent::__run($soap_request, "Availability.wsdl#Availability", TRUE);
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* @access public
	* @param
	* @return
	*/
	public function FetchExpectedChargesRequest($data)
	{
		$soap_request = $this->__build_request("Availability/FetchExpectedChargesRequest.xml", $data);
	
		parent::__run($soap_request, "Availability.wsdl#FetchExpectedCharges", TRUE);
	
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * fetch available items
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FetchAvailableItems()
	{
		$soap_request = file_get_contents("http://67.227.134.38/test/FetchAvailableItems.xml");
		
		parent::__run($soap_request, "Availability.wsdl#FetchAvailableItems");
		
		return $this->response;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * fetch available items groups
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FetchItemGroups()
	{
		$soap_request = file_get_contents("http://67.227.134.38/test/FetchItemGroups.xml");
		
		parent::__run($soap_request, "Availability.wsdl#FetchItemGroups");
		
		return $this->response;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Retrieves a least of available add-on packages and package group by
 	 * date. The user should provide at least a date range and hotel criteria.
 	 * Room type or block, adult or child guest counts, and rate plan
 	 * information are also allowed 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FetchAvailablePackages()
	{
		$soap_request = $this->__build_request("Availability/FetchAvailablePackages.xml");
		
		parent::__run($soap_request, "Availability.wsdl#FetchAvailablePackages");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_availability Class

/* End of file OWS_availability.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_availability.php */
?>
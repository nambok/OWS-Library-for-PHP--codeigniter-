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

class OWS_information extends OWS_soap
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
		
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/information"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Query Hotel Information
 	 * 
 	 * Retrieves information about the hotel, given the hotel criteria. 
 	 * Contract and location details as well as information about 
 	 * facilities, amenities, services, and alternative properties are
 	 * provided
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function QueryHotelInformation()
	{
		$soap_request = $this->__build_request("Information/QueryHotelInformation.xml");
		
		parent::__run($soap_request, "Information.wsdl#QueryHotelInformation");
		
		return $this->response;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Query Rate
 	 * 
 	 * Retrieves rate information, given the hotel and rate codes. A 
 	 * date range is also allowed. The information includes policies,
 	 * requirements, restrictions, and other descriptive details 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function QueryRate()
	{
		$soap_request = $this->__build_request("Information/QueryRate.xml");
		
		parent::__run($soap_request, "Information.wsdl#QueryRate");
		
		return $this->response;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Query Lov
 	 * 
 	 * Retrieves a list of values, given the query type string. A wide
 	 * variety of resort configuration details are viewable 
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function QueryLov($data)
	{
		$soap_request = $this->__build_request("Information/QueryLov.xml", $data);
		
		parent::__run($soap_request, "Information.wsdl#QueryLov");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_information Class

/* End of file OWS_information.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_information.php */
?>
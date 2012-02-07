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

class OWS_reservation extends OWS_soap
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
		
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/reservation"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * create booking
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function CreateBooking($data)
	{
		$soap_request = $this->__build_request("Reservation/CreateBooking.xml", $data);
		
		parent::__run($soap_request, "Reservation.wsdl#CreateBooking", TRUE);
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* create booking
	*
	* @access public
	* @param
	* @return
	*/
	public function CreateBookingGuest($data)
	{
		$soap_request = $this->__build_request("Reservation/CreateBookingGuest.xml", $data);
		
		parent::__run($soap_request, "Reservation.wsdl#CreateBooking", TRUE);
	
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FutureBookingSummary
 	 * 
 	 * Retrieves a list of reservations for future dates, given some
 	 * filtering criteria. The filtering may be by date range (booked
 	 * or arrival date), name or coporate identifier, last name, first
 	 * name, credit card number, search level (subgroup, group, or 
 	 * booker), and/or defined filters (creating date, contract 
 	 * identifier, membership record, hotel criteria, confirmation
 	 * identifier, reservation identifier, and a key track data). Source
 	 * and Origin codes for reservations can also be returned in
 	 * the response
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FutureBookingSummary($data)
	{
		$soap_request = $this->__build_request("Reservation/FutureBookingSummary.xml", $data);
		
		parent::__run($soap_request, "Reservation.wsdl#FutureBookingSummary", TRUE);	
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchBooking
 	 * 
 	 * Retireves a reservation, given at least the confirmation
 	 * identifier or GDS identifier or customer reference identifier.
 	 * Hotel criteria, leg confirmation identifier, and external hotel
 	 * reference and leg confirmation number are also allowed. 
 	 * Details are provided on the room stay, guest profile, and 
 	 * confirmation instructions
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function FetchBooking($data)
	{
		$soap_request = $this->__build_request("Reservation/FetchBooking.xml", $data);
		
		parent::__run($soap_request, "Reservation.wsdl#FetchBooking", TRUE);	
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * CancelBooking
 	 * 
 	 * Cancels a reservation and returns a cancellation identifier,
 	 * given at least the hotel criteria, confirmation identifier, and 
 	 * cancellation type summary. GDS identifier and Leg
 	 * confirmation identifier are also allowed
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function CancelBooking($data)
	{
		$soap_request = $this->__build_request("Reservation/CancelBooking.xml", $data);
		
		parent::__run($soap_request, "Reservation.wsdl#CancelBooking", TRUE);	
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	
	
}

// END OWS_reservation Class

/* End of file OWS_reservation.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_reservation.php */
?>
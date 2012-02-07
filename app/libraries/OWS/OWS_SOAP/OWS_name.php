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

class OWS_name extends OWS_soap
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
		
		parent::__set_request($this->CI->ny_core->__get_config("reservations/ows_api/name"));
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Register Name
 	 * 
 	 * Creates a new profile and its name identifier, given at least the
 	 * person's name record. Native name record, birth date, gender, 
 	 * address record, phone record, passport record, login name,
 	 * and login password are also allowed. Specifying the login 
 	 * information also creates a web user
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function RegisterName($data)
	{
		$soap_request = $this->__build_request("Name/RegisterName.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#RegisterName");
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * Name Lookup
 	 * 
 	 * Retrieves a list of profile records, given the name look-up
 	 * credit card or membership criteria
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function NameLookup($data)
	{
		$soap_request = $this->__build_request("Name/NameLookup.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#NameLookup");
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchName
 	 * 
 	 * Retrieves the name record from a profile, including any 
 	 * birthday and gender information, given the name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchName($data)
	{
		$soap_request = $this->__build_request("Name/FetchName.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchName");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchAddressList
 	 * 
 	 * Retrieves a list of address records from a profile, given the
 	 * name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchAddressList($data)
	{
		$soap_request = $this->__build_request("Name/FetchAddressList.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchAddressList");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * InsertAdrress
 	 * 
 	 * Adds an address record to a profile, given the name identifier
 	 * and address information to insert
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function InsertAddress($data)
	{
		$soap_request = $this->__build_request("Name/InsertAddress.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#InsertAddress");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdateAdrress
 	 * 
 	 * Modifies an address record in a profile, given the address
 	 * information
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function UpdateAddress($data)
	{
		$soap_request = $this->__build_request("Name/UpdateAddress.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#UpdateAddress");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * DeleteAdrress
 	 * 
 	 * Deletes a specific address from a profile, given the address
 	 * identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function DeleteAddress($data)
	{
		$soap_request = $this->__build_request("Name/DeleteAddress.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#DeleteAddress");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchEmailList
 	 * 
 	 * Retrieves a list of e-mail address records from a profile, 
 	 * given the name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchEmailList($data)
	{
		$soap_request = $this->__build_request("Name/FetchEmailList.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchEmailList");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * InsertEmail
 	 * 
 	 * Adds an email address record to a profile, given the name
 	 * identifier and e-mail to insert
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function InsertEmail($data)
	{
		$soap_request = $this->__build_request("Name/InsertEmail.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#InsertEmail");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdateEmail
 	 * 
 	 * Modifies an e-mail record in a profile, given e-mail
 	 * address information
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function UpdateEmail($data)
	{
		$soap_request = $this->__build_request("Name/UpdateEmail.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#UpdateEmail");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * DeleteEmail
 	 * 
 	 * Deletes a specific e-mail record from a profile, given the e-mail
 	 * identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function DeleteEmail($data)
	{
		$soap_request = $this->__build_request("Name/DeleteEmail.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#DeleteEmail");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchPhoneList
 	 * 
 	 * Retrieves the list of phone records from a profile, given the
 	 * name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchPhoneList($data)
	{
		$soap_request = $this->__build_request("Name/FetchPhoneList.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchPhoneList");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * InsertPhone
 	 * 
 	 * Adds a phone record to a profile, given the name identifier and
 	 * phone information to insert
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function InsertPhone($data)
	{
		$soap_request = $this->__build_request("Name/InsertPhone.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#InsertPhone");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * DeletePhone
 	 * 
 	 * Deletes a specific phone record from a profile, given the phone
 	 * record identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function DeletePhone($data)
	{
		$soap_request = $this->__build_request("Name/DeletePhone.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#DeletePhone");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdatePhone
 	 * 
 	 * Modifies a phone record in a profile, given the phone
 	 * information
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function UpdatePhone($data)
	{
		$soap_request = $this->__build_request("Name/UpdatePhone.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#UpdatePhone");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchCreditCardList
 	 * 
 	 * Retrieves the list of phone records from a profile, given the
 	 * name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchCreditCardList($data)
	{
		$soap_request = $this->__build_request("Name/FetchCreditCardList.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchCreditCardList");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * InsertCreditCard
 	 * 
 	 * Adds a credit card record to a profile, given the name identifier
 	 * and credit card information to insert
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function InsertCreditCard($data)
	{
		$soap_request = $this->__build_request("Name/InsertCreditCard.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#InsertCreditCard");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdateCreditCard
 	 * 
 	 * Modifies a credit card record in a profile, given the credit card
 	 * information
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function UpdateCreditCard($data)
	{
		$soap_request = $this->__build_request("Name/UpdateCreditCard.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#UpdateCreditCard");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * DeleteCreditCard
 	 * 
 	 * Deletes a specific credit card record from a profile, given the address
 	 * credit card identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function DeleteCreditCard($data)
	{
		$soap_request = $this->__build_request("Name/DeleteCreditCard.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#DeleteCreditCard");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
		//return $this->response["IDs"]["IDPair"]["!operaId"];
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * FetchGuestCardList
 	 * 
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function FetchGuestCardList($data)
	{
		$soap_request = $this->__build_request("Name/FetchGuestCardList.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#FetchGuestCardList");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * UpdateGuestCardList
 	 * 
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function UpdateGuestCard($data)
	{
		$soap_request = $this->__build_request("Name/UpdateGuestCard.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#UpdateGuestCard");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * InsertGuestCard
 	 * 
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function InsertGuestCard($data)
	{
		$soap_request = $this->__build_request("Name/InsertGuestCard.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#InsertGuestCard");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * GetPassport
 	 * 
 	 * Retrieves the passport information from a profile, given the 
 	 * name identifier
 	 *
 	 * @access public	
 	 * @param 
 	 * @return	
  	 */
	public function GetPassport($data)
	{
		$soap_request = $this->__build_request("Name/GetPassport.xml", $data);
		
		parent::__run($soap_request, "Name.wsdl#GetPassport");
		
		return array("response" => $this->response, "success" => $this->response_success, "err_message" => $this->response_error);
		
	}
	
	// --------------------------------------------------------------------
}

// END OWS_name Class

/* End of file OWS_name.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_name.php */
?>
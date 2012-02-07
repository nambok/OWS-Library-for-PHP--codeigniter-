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

class Name extends OWS_core
{
	/*
	 * Variables
	 */
	
	/**
	*
	*/
	private $membershipType = "WWR";
	
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
		
		parent::load_soap("OWS_name");
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * Register
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function RegisterName($loginName, $password, $nameTitle, $firstName, $middleName, $lastName, $BirthDate, $Gender, $email)
	{		
		
		$data = array();
		
		$data["loginName"]		= $loginName;
		$data["password"]		= $password;
		$data["nameTitle"]		= $nameTitle;
		$data["firstName"]		= $firstName;
		$data["middleName"]		= $middleName;
		$data["lastName"]		= $lastName;
		$data["BirthDate"]		= $BirthDate;
		$data["Gender"]			= $Gender;
		$data["email"]			= $email;
		
		$result = $this->CI->ows_name->RegisterName($data);
		
		return $result;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Name
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchName($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->FetchName($data);
		
		if($result["success"])
		{
			unset($result["response"]["Result"]);
			$result["Profile"] = $result["response"];
		}
		
		unset($result["response"]);	
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Address List
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchAddressList($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->FetchAddressList($data);
		
		if($result["success"])
		{
			if(key_exists("NameAddressList", $result["response"]))
			{
				if(!key_exists("!operaId", $result["response"]["NameAddressList"]["NameAddress"]) )
					$result["AddressList"] = $result["response"]["NameAddressList"]["NameAddress"];
				else 
					$result["AddressList"][0] = $result["response"]["NameAddressList"]["NameAddress"];
			}
			else 
			{
				$result["AddressList"] = array();
			}
		}
		
		unset($result["response"]);	
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Address
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function InsertAddress($NameID, $addressType, $AddressLine, $AddressLine2, $AddressLine3, $cityName, $stateProv, $countryCode, $postalCode)
	{
		$data = array();
		
		$data["NameID"] 		= $NameID;
		$data["addressType"] 	= $addressType;
		$data["AddressLine"]	= $AddressLine;
		$data["AddressLine2"]	= $AddressLine2;
		$data["AddressLine3"] 	= $AddressLine3;
		$data["cityName"]		= $cityName;
		$data["stateProv"]	 	= $stateProv;
		$data["countryCode"]	= $countryCode;
		$data["postalCode"]	 	= $postalCode;		
		
		$result = $this->CI->ows_name->InsertAddress($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update Address
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function UpdateAddress($operaId, $addressType, $AddressLine, $AddressLine2, $AddressLine3, $cityName, $stateProv, $countryCode, $postalCode)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;
		$data["addressType"] 	= $addressType;
		$data["AddressLine"]	= $AddressLine;
		$data["AddressLine2"]	= $AddressLine2;
		$data["AddressLine3"] 	= $AddressLine3;
		$data["cityName"]		= $cityName;
		$data["stateProv"]	 	= $stateProv;
		$data["countryCode"]	= $countryCode;
		$data["postalCode"]	 	= $postalCode;		
		
		$result = $this->CI->ows_name->UpdateAddress($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Address
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function DeleteAddress($operaId)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;	
		
		$result = $this->CI->ows_name->DeleteAddress($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Email List
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchEmailList($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->FetchEmailList($data);
		
		if($result["success"])
		{
			if(key_exists("NameEmailList", $result["response"]))
			{
				if(!key_exists("!operaId", $result["response"]["NameEmailList"]["NameEmail"]))
				{
					$result["EmailList"] = $result["response"]["NameEmailList"]["NameEmail"];
				}
				else 
				{
					$result["EmailList"][0] = $result["response"]["NameEmailList"]["NameEmail"];	
				}
			}
			else 
				$result["EmailList"] = array();
		}
		
		unset($result["response"]);	
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Email
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function InsertEmail($NameID, $email)
	{
		$data = array();
		
		$data["NameID"]    = $NameID;
		$data["NameEmail"] = $email;
		
		$result = $this->CI->ows_name->InsertEmail($data);
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;			
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update Email
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function UpdateEmail($operaId, $email)
	{
		$data = array();
		
		$data["operaId"]   = $operaId;
		$data["NameEmail"] = $email;
		
		$result = $this->CI->ows_name->UpdateEmail($data);
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;			
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Email
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function DeleteEmail($operaId)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;	
		
		$result = $this->CI->ows_name->DeleteEmail($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Phone List
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchPhoneList($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->FetchPhoneList($data);
		
		if($result["success"])
		{
			if(key_exists("NamePhoneList", $result["response"]))
			{				
				if(!key_exists("!operaId", $result["response"]["NamePhoneList"]["NamePhone"]) )
				{
					$result["PhoneList"] = $result["response"]["NamePhoneList"]["NamePhone"];
				}
				else 
				{
					$result["PhoneList"][0] = $result["response"]["NamePhoneList"]["NamePhone"];
				}
			}
			else 
			{
				$result["PhoneList"] = array();
			}	
		}
		
		unset($result["response"]);
		
		return $result;	
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Phone
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function InsertPhone($NameID, $PhoneNumber, $phoneType)
	{
		$data = array();
		
		$data["NameID"] 		= $NameID;
		$data["PhoneNumber"] 	= $PhoneNumber;
		$data["phoneType"]		= $phoneType;
		
		$result = $this->CI->ows_name->InsertPhone($data);
		
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update Phone
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function UpdatePhone($operaId, $PhoneNumber, $phoneType)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;
		$data["PhoneNumber"] 	= $PhoneNumber;
		$data["phoneType"]		= $phoneType;
		
		$result = $this->CI->ows_name->UpdatePhone($data);
		
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Phone
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function DeletePhone($operaId)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;	
		
		$result = $this->CI->ows_name->DeletePhone($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Credit Card List
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchCreditCardList($NameID, $mask_number = TRUE)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->FetchCreditCardList($data);
		
		if($result["success"])
		{
			if(key_exists("CreditCardList", $result["response"]))
			{
				if(!key_exists("!operaId", $result["response"]["CreditCardList"]["NameCreditCard"]))
				{
					$result["CreditCardList"] = $result["response"]["CreditCardList"]["NameCreditCard"];
				}
				else 
					$result["CreditCardList"][0] = $result["response"]["CreditCardList"]["NameCreditCard"];		
				
				if($mask_number)
				{
					foreach ($result["CreditCardList"] as &$cc_record)
					{
						$cc_record["cardNumber"] = "***".substr($cc_record["cardNumber"],-4,4);
					}
				}
			}
			else 
				$result["CreditCardList"] = array();
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Name Lookup
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function NameLookup($LastName, $FirstName, $MembershipType, $MembershipNumber)
	{
		$data = array();
		
		$data["LastName"]			= $LastName;
		$data["FirstName"]			= $FirstName;	
		$data["MembershipType"] 	= $MembershipType;	 
		$data["MembershipNumber"]	= $MembershipNumber;
		
		$result = $this->CI->ows_name->NameLookup($data);
		
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;			
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Credit Card
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function InsertCreditCard($NameID, $cardType, $cardHolderName, $cardNumber, $expirationDate)
	{
		$data = array();
		
		$data["NameID"] 		= $NameID;
		$data["cardType"] 		= $cardType;
		$data["cardHolderName"] = $cardHolderName;
		$data["cardNumber"]		= $cardNumber;
		$data["expirationDate"]	= $expirationDate;		 
		
		$result = $this->CI->ows_name->InsertCreditCard($data);
		
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;			
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Credit Card
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function DeleteCreditCard($operaId)
	{
		$data = array();
		
		$data["operaId"] 		= $operaId;	
		
		$result = $this->CI->ows_name->DeleteCreditCard($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			//$result["id"] = $result["response"]["IDs"]["IDPair"]["!operaId"];
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Fetch Membership
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function FetchGuestCardList($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;	
		
		$result = $this->CI->ows_name->FetchGuestCardList($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
			if(key_exists("GuestCardList", $result["response"]))
			{
				if(!key_exists("!operaId", $result["response"]["GuestCardList"]["NameMembership"]))
				{
					$result["MembershipList"] = $result["response"]["GuestCardList"]["NameMembership"];
				}
				else
				{
					$result["MembershipList"][0] = $result["response"]["GuestCardList"]["NameMembership"];
				}
			}
			else 
				$result["MembershipList"] = array();
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update Membership
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function UpdateGuestCard($operaId, $membershipNumber, $memberName)
	{
		$data = array();
		
		$data["operaId"] 			= $operaId;	
		$data["membershipNumber"]	= $membershipNumber;
		$data["membershipType"]		= $this->membershipType;
		$data["memberName"]			= $memberName;
		
		$result = $this->CI->ows_name->UpdateGuestCard($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Membership
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function InsertGuestCard($NameID, $membershipNumber, $memberName)
	{
		$data = array();
		
		$data["NameID"] 			= $NameID;	
		$data["membershipNumber"]	= $membershipNumber;
		$data["membershipType"]		= $this->membershipType;
		$data["memberName"]			= $memberName;
		
		$result = $this->CI->ows_name->InsertGuestCard($data);
		
		//$this->response["IDs"]["IDPair"]["!operaId"]
		if($result["success"])
		{
		}
		
		unset($result["response"]);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Passport
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function GetPassport($NameID)
	{
		$data = array();
		
		$data["NameID"] = $NameID;
		
		$result = $this->CI->ows_name->GetPassport($data);
		
		return $result;		
	}
	
	// --------------------------------------------------------------------
}

// END Name Class

/* End of file Name.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/Name.php */
?>
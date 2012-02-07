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

class OWS_name
{
	/*
	 * Variables
	 */	
	
	/**
	 * loginName
	 * 
	 * @var		string
	 * @access	public
	 * 
	 */
	public $loginName;
	
	/**
	 * nameTitle
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $nameTitle;
	
	/**
	 * firstName
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $firstName;
	
	/**
	 * middleName
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $middleName;
	
	/**
	 * lastName
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $lastName;
	
	/**
	 * BirthDate
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $BirthDate;
	
	/**
	 * Gender
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $Gender;
	
	/**
	 * AddressLine
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $AddressLine;
	
	/**
	 * cityName
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $cityName;
	
	/**
	 * stateProv
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $stateProv;
	
	/**
	 * countryCode
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $countryCode;
	
	/**
	 * PostalCode
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $PostalCode;
	
	/**
	 * email
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $email;
	
	
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
		$this->set_Room($ows_description, $code, $maxOccupancy, $rates);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * create_Room
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function	set_Room()
	{
		$this->code				= $code;
		
		if($this->get_custom_data())
		{		
			$this->title 			= '';
			$this->RoomDescription	= $ows_description;
			$this->__convert_ows_description();
		}
		
		$this->maxOccupancy		= $maxOccupancy;
		$this->rates			= $rates;
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_rooms Class

/* End of file OWS_rooms.php */
/* Location: ./app/libraries/OWS/OWS_models/OWS_rooms.php */
?>
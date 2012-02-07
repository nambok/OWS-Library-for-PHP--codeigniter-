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

class OWS_rooms
{
	/*
	 * Variables
	 */	
	
	/**
	 * title
	 * 
	 * @var		varchar(255)
	 * @access 	public
	 * 
	 */
	public $title;
	
	/**
	 * RoomDescription
	 * 
	 * @var		text
	 * @access 	public
	 * 
	 */
	public $RoomDescription;
	
	/**
	 * code
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $code;
	
	/**
	 * maxOccupancy
	 * 
	 * @var		int(10)
	 * @access 	public
	 * 
	 */
	public $maxOccupancy;
	
	/**
	 * price
	 * 
	 * @var		float
	 * @access 	public
	 * 
	 */
	public $price;
	
	/**
	 * rateCode
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $rateCode;
	
	/**
	 * media
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $media;
	
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
	public function	create_Room($title, $RoomDescription, $code, $maxOccupancy, $price, $rateCode)
	{		
		$this->title 			= $title;
		$this->RoomDescription	= $RoomDescription;
		$this->code				= $code;
		$this->maxOccupancy		= $maxOccupancy;
		$this->rateCode			= $rateCode;
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_rooms Class

/* End of file OWS_rooms.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_rooms.php */
?>
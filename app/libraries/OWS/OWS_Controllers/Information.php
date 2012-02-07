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

class Information extends OWS_core
{
	/*
	 * Variables
	 */
	
	/**
	 * 
	 * Room list
	 * 
	 * @var		Array()
	 * @access	public
	 * 
	 */
	public $roomList;
	
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
		
		parent::load_soap("OWS_information");
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * get rooms
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function __getRooms()
	{
		parent::load_model("OWS_rooms");
		
		$this->roomList = array();
		
		$result = $this->CI->ows_information->QueryHotelInformation();
		
		$roomList = $result["HotelInformation"]["HotelExtendedInformation"]["FacilityInfo"]["GuestRooms"]["GuestRoom"];
		
		foreach ($roomList as $room)
		{
			$roomObject = new OWS_rooms($room["RoomDescription"]["Text"]["TextElement"]["!"], $room["!code"], $room["!maxOccupancy"]);
			$this->roomList[] = $roomObject;
		}
		
		return $this->roomList;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * query Lov
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function queryLov($LovIdentifier)
	{
		$data= array();
		
		$data["LovIdentifier"] = $LovIdentifier;
		
		$result = $this->CI->ows_information->QueryLov($data);
		
		if($result["success"])
		{
			if(key_exists("LovValue", $result["response"]["LovQueryResult"]))
				$result["LovValue"] = $result["response"]["LovQueryResult"]["LovValue"];
			else 
				$result["LovValue"] = $result["response"]["LovQueryResult"];
		}
		
		unset($result["response"]);
		
		return $result;
	}
	
	// --------------------------------------------------------------------
	
}

// END Information Class

/* End of file Information.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/OWS_core.php */
?>
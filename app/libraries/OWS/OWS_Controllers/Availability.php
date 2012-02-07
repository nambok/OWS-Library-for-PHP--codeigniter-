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

class Availability extends OWS_core
{
	/*
	 * Variables
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
		
		parent::load_soap("OWS_availability");
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * check availabilty
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function general_availability($StartDate, $EndDate, $totalNumberOfGuests, $numberOfChildren, $numberOfRooms, $roomTypeCode = "ALL", $ratePlanCode = "", $availReqType = "Room", $invBlockCode = "", $promotionCode = '')
	{
		parent::load_model("OWS_rooms");
		parent::load_model("OWS_rates");
		
		$this->roomList = array();
		
		$roomOccupancy = $totalNumberOfGuests + $numberOfChildren;
		
		$data = array();
		
		$data["summaryOnly"] 			= 1;		
		$data["availReqType"] 			= $availReqType;
		$data["roomTypeCode"]			= $roomTypeCode;
		$data["ratePlanCode"]			= $ratePlanCode;
		$data["StartDate"]				= $StartDate;
		$data["EndDate"]				= $EndDate;
		$data["numberOfRooms"]			= $numberOfRooms;
		//$data["roomOccupancy"]		= $totalNumberOfGuests;
		$data["totalNumberOfGuests"] 	= $totalNumberOfGuests;
		$data["numberOfChildren"]	 	= $numberOfChildren;
		$data["promotionCode"]			= $promotionCode;
		$data["invBlockCode"]			= $invBlockCode;
		
		$data["qualifyingIdValue"]  = ""; 
		$data["qualifyingIdType"]	= "";
		if($ratePlanCode)
		{
			$data["qualifyingIdValue"]  = $ratePlanCode; 
			$data["qualifyingIdType"]	= "CORPORATE";
		}
		
		
		$resultArray = $this->CI->ows_availability->Availability($data);
		
		//if request is successful
		if($resultArray["success"])
		{
			try 
			{
				$result = $resultArray["response"]; 
				
				if($data["roomTypeCode"] == "ALL")
					$rooms			= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"]["RoomType"];
				else 
					$rooms			= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"];
					
				$rooms_rates 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"]["RoomRate"];
				$rooms_ratePlans	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"]["RatePlan"];
				
				
				//check if requested for a group code
				if(empty($invBlockCode))
				{				
					$single_plan = FALSE;
					
					$ratePlans = array();
					foreach ($rooms_ratePlans as $room_ratePlan)
					{
						if(!is_array($room_ratePlan) || !array_key_exists("!ratePlanCode", $room_ratePlan))
						{
							$single_plan = TRUE;
							break;
						}
											
						$ratePlans[$room_ratePlan["!ratePlanCode"]] = $room_ratePlan;
					}
					
					if($single_plan)
					{
						$rooms_ratePlans = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"];
					
						foreach ($rooms_ratePlans as $room_ratePlan)
						{
							if(!is_array($room_ratePlan) || !array_key_exists("!ratePlanCode", $room_ratePlan))
							{
								$single_plan = TRUE;
								break;
							}
												
							$ratePlans[$room_ratePlan["!ratePlanCode"]] = $room_ratePlan;
						}
					}
					
					//single rate returned
					$single_rate = FALSE;
					
					$rates = array();
					foreach ($rooms_rates as $room_rate)
					{
						if(!is_array($room_rate) || !array_key_exists("!ratePlanCode", $room_rate))
						{
							$single_rate = TRUE;
							break;
						}			
						$ratePlanObject = new OWS_rates($room_rate["!ratePlanCode"], $ratePlans[$room_rate["!ratePlanCode"]]["!hold"], $ratePlans[$room_rate["!ratePlanCode"]]["CancellationDateTime"], $ratePlans[$room_rate["!ratePlanCode"]]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"]);	
							
						$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
					}
					
					if($single_rate)
					{
						$rooms_rates = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"];
												
						foreach ($rooms_rates as $room_rate)
						{
							if(key_exists("!ratePlanCode", $room_rate))	
								$ratePlanObject = new OWS_rates($room_rate["!ratePlanCode"], $ratePlans[$room_rate["!ratePlanCode"]]["!hold"], $ratePlans[$room_rate["!ratePlanCode"]]["CancellationDateTime"], $ratePlans[$room_rate["!ratePlanCode"]]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"]);	
							else 
								$ratePlanObject = new OWS_rates("", $ratePlans["!hold"], $ratePlans["CancellationDateTime"], $ratePlans["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"]);
								
							$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
						}
					}
				}
				//if group code
				else
				{
					$rooms_rates 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"]["RoomRate"];
					$rooms_ratePlans	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"];
									
					$ratePlans = array();
					
					foreach ($rooms_ratePlans as $room_ratePlan)
					{											
						$ratePlans[$invBlockCode] = $room_ratePlan;
					}
					
					$rates = array();
					$single_rate = FALSE;
					
					foreach ($rooms_rates as $room_rate)
					{
						if(!is_array($room_rate) || !array_key_exists("!suppressRate", $room_rate))
						{
							$single_rate = TRUE;
							break;
						}
					
						$ratePlanObject = new OWS_rates("", $ratePlans[$invBlockCode]["!hold"], $ratePlans[$invBlockCode]["CancellationDateTime"], $ratePlans[$invBlockCode]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"], $invBlockCode);
							
						$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
					}
					
					if($single_rate)
					{
						$rooms_rates = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"];
					
						foreach ($rooms_rates as $room_rate)
						{
							$ratePlanObject = new OWS_rates("", $ratePlans[$invBlockCode]["!hold"], $ratePlans[$invBlockCode]["CancellationDateTime"], $ratePlans[$invBlockCode]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"], $invBlockCode);
							
							$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
						}
					}
				}
				
				
				$single_room = FALSE; 
				
				foreach ($rooms as $room)
				{
					if(!is_array($room) || !array_key_exists("!roomTypeCode", $room))
					{
						$single_room = TRUE;
						break;
					}
							
					$rate = array();
					if (array_key_exists($room["!roomTypeCode"], $rates))
						$rate = $rates[$room["!roomTypeCode"]];
					
					$roomObject = new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', $rate, '','');
					$this->roomList[] = $roomObject;
				}
				
				if($single_room)
				{
					$rooms	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"];
									
					
					foreach ($rooms as $room)
					{
						/*
						if(!is_array($room) || array_key_exists("!roomTypeCode", $room))
						{
							$resultArray["success"] = FALSE;
							$resultArray["err_message"] = "No Rooms Available on the dates provided. Contact us for more info";
							die("test");
							break;
						}
						*/
							       
						$rate = array();
						if (array_key_exists($room["!roomTypeCode"], $rates))
							$rate = $rates[$room["!roomTypeCode"]];
							
						$roomObject = new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', $rate, '','');
						$this->roomList[] = $roomObject;
					}
				}
				
				//return $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"];
				
				$resultArray["roomList"]  = $this->roomList;
			}
			catch (Exception $ex)
			{
				$resultArray["success"] = FALSE;
				$resultArray["err_message"] = "No Rooms Available on the dates provided. Contact us for more info";
			}
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * detail availabilty
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function detail_availability($StartDate, $EndDate, $totalNumberOfGuests, $numberOfChildren, $numberOfRooms, $roomTypeCode = "ALL", $ratePlanCode = "", $availReqType = "Room", $invBlockCode = "", $promotionCode = '')
	{
		parent::load_model("OWS_rooms");
		parent::load_model("OWS_rates");
		
		$this->roomList = array();
		
		$roomOccupancy = $totalNumberOfGuests + $numberOfChildren;
		
		$data = array();
		
		$data["summaryOnly"] 			= "false";	 	
		$data["availReqType"] 			= $availReqType;
		$data["roomTypeCode"]			= $roomTypeCode;
		$data["ratePlanCode"]			= $ratePlanCode;
		$data["StartDate"]				= $StartDate;
		$data["EndDate"]				= $EndDate;
		$data["numberOfRooms"]			= $numberOfRooms;
		//$data["roomOccupancy"]			= $totalNumberOfGuests;
		$data["totalNumberOfGuests"] 	= $totalNumberOfGuests;
		$data["numberOfChildren"]	 	= $numberOfChildren;
		$data["promotionCode"]			= $promotionCode;
		$data["invBlockCode"]			= $invBlockCode;
		$data["qualifyingIdValue"]  	= ""; 
		$data["qualifyingIdType"]		= "";
		
		$resultArray = $this->CI->ows_availability->Availability($data);
		
		if($resultArray["success"])
		{
		
			try 
			{
				$result = $resultArray["response"]; 
				
				if($data["roomTypeCode"] == "ALL")
					$rooms			= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"]["RoomType"];
				else 
					$rooms			= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"];
					
				$rooms_rates 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"]["RoomRate"];
				$rooms_ratePlans	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"]["RatePlan"];
				
				//check if requested for a group code
				if(empty($invBlockCode))
				{	
					$single_plan = FALSE;
					
					$ratePlans = array();
					foreach ($rooms_ratePlans as $room_ratePlan)
					{
						if(!is_array($room_ratePlan) || !array_key_exists("!ratePlanCode", $room_ratePlan))
						{
							$single_plan = TRUE;
							break;
						}
											
						$ratePlans[$room_ratePlan["!ratePlanCode"]] = $room_ratePlan;
					}
					
					if($single_plan)
					{
						$rooms_ratePlans = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"];
						
						foreach ($rooms_ratePlans as $room_ratePlan)
						{
							if(!is_array($room_ratePlan) || !array_key_exists("!ratePlanCode", $room_ratePlan))
							{
								$single_plan = TRUE;
								break;
							}
												
							$ratePlans[$room_ratePlan["!ratePlanCode"]] = $room_ratePlan;
						}
					}
					
					$single_rate = FALSE;
					
					$rates = array();
					
					foreach ($rooms_rates as $room_rate)
					{
						if(!is_array($room_rate) || !array_key_exists("!ratePlanCode", $room_rate))
						{
							$single_rate = TRUE;
							break;
						}			
						$ratePlanObject = new OWS_rates($room_rate["!ratePlanCode"], "", "CancellationDateTime", $ratePlans[$room_rate["!ratePlanCode"]]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"]);	
							
						$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
					}
					
					if($single_rate)
					{
						$rooms_rates = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"];
						
						foreach ($rooms_rates as $room_rate)
						{	
							$cancellation = $ratePlans[$room_rate["!ratePlanCode"]]["AdditionalDetails"]["AdditionalDetail"][1]["AdditionalDetailDescription"]["Text"];

							/*
							$cancellation = $this->CI->ny_core->__get_config("reservation/cancellation/default");
							
							$non_rd = str_replace(" ", "", $this->CI->ny_core->__get_config("reservations/rates/nonrefundable"));
							
							$non_rd_array = explode(',', $non_rd);
							if(is_array($non_rd_array) && sizeof($non_rd_array) > 0)
							{
								foreach($non_rd_array as $non_rd_single)
								{
									if($room_rate["!ratePlanCode"] == $non_rd_single)
									{
										$cancellation = "Non Refundable Rate";
										break;
									}
								}
							}
							else
							{
								if($room_rate["!ratePlanCode"] == $non_rd)
								{
									$cancellation = "<b>Non Refundable Rate</b>";
									break;
								}
							}
							*/
								
							
							$ratePlanObject = new OWS_rates($room_rate["!ratePlanCode"], "", $cancellation, $ratePlans[$room_rate["!ratePlanCode"]]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"]);	
								
							$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
						}
					}
					
				}
				//if group code
				else
				{
					$rooms_rates 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"]["RoomRate"];
					$rooms_ratePlans	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RatePlans"];
									
					$ratePlans = array();
					
					foreach ($rooms_ratePlans as $room_ratePlan)
					{									
						$ratePlans[$invBlockCode] = $room_ratePlan;
					}
					
					$rates = array();
					$single_rate = FALSE;
					
					foreach ($rooms_rates as $room_rate)
					{
						if(!is_array($room_rate) || !array_key_exists("!suppressRate", $room_rate))
						{
							$single_rate = TRUE;
							break;
						}
						
						$ratePlanObject = new OWS_rates("", $ratePlans[$invBlockCode]["!hold"], $ratePlans[$invBlockCode]["CancellationDateTime"], $ratePlans[$invBlockCode]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"], $invBlockCode);
							
						$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
					}
					
					if($single_rate)
					{
						$rooms_rates = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomRates"];
					
						foreach ($rooms_rates as $room_rate)
						{
							$cancellation = $ratePlans[$invBlockCode]["AdditionalDetails"]["AdditionalDetail"][1]["AdditionalDetailDescription"]["Text"];
								
							/*
							$cancellation = $this->CI->ny_core->__get_config("reservation/cancellation/gcode");
							
							$non_rd = str_replace(" ", "", $this->CI->ny_core->__get_config("reservations/rates/nonrefundable"));
								
							$non_rd_array = explode(',', $non_rd);
							if(is_array($non_rd_array) && sizeof($non_rd_array) > 0)
							{
								foreach($non_rd_array as $non_rd_single)
								{
									if($invBlockCode == $non_rd_single)
									{
										$cancellation = "Non Refundable Rate";
										break;
									}
								}
							}
							else
							{
								if($invBlockCode == $non_rd)
								{
									$cancellation = "<b>Non Refundable Rate</b>";
									break;
								}
							}
							*/
							
							$ratePlanObject = new OWS_rates("", "", $cancellation, $ratePlans[$invBlockCode]["RatePlanDescription"]["Text"], $room_rate["Total"]["!"], $room_rate["Total"]["!currencyCode"], $invBlockCode);
							
							$rates[$room_rate["!roomTypeCode"]][] = $ratePlanObject;
						}
					}					
				}
				
				$resultArray["ratePlan"] =  $ratePlanObject;
							
				$single_room = FALSE; 
				
				foreach ($rooms as $room)
				{
					if(!is_array($room) || !array_key_exists("!roomTypeCode", $room))
					{
						$single_room = TRUE;
						break;
					}
							
					$rate = array();
					if (array_key_exists($room["!roomTypeCode"], $rates))
						$rate = $rates[$room["!roomTypeCode"]];
					
					$roomObject = new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', $rate, '','');
					$this->roomList = $roomObject;
				}
				
				if($single_room)
				{
					$rooms	= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["RoomTypes"];
									
					
					foreach ($rooms as $room)
					{
						/*
						if(!is_array($room) || array_key_exists("!roomTypeCode", $room))
						{
							$resultArray["success"] = FALSE;
							$resultArray["err_message"] = "No Rooms Available on the dates provided. Contact us for more info";
							die("test");
							break;
						}
						*/
							       
						$rate = array();
						if (array_key_exists($room["!roomTypeCode"], $rates))
							$rate = $rates[$room["!roomTypeCode"]];
							
						$roomObject = new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', $rate, '','');
						$this->roomList = $roomObject;
					}
				}
				
				//return $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"];
				
				$resultArray["roomList"]  = $this->roomList;
			}
			catch (Exception $ex)
			{
				$resultArray["success"] = FALSE;
				$resultArray["err_message"] = "No Rooms Available on the dates provided. Contact us for more info";
			}
			
			if(key_exists("0", $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["ChargesForPostingDate"]))
				$ExpectedCharges = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["ChargesForPostingDate"][0]["TaxesAndFees"]["Charges"];
			 else
			 	$ExpectedCharges = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["ChargesForPostingDate"]["TaxesAndFees"]["Charges"];
			 
			 
			 $resultArray["ExpectedCharges"]= Array();
			 
			 foreach ($ExpectedCharges as $charge)
			 {
			 	//if($charge["Amount"]["!"] != "0")
			 		$resultArray["ExpectedCharges"][] = $charge; 
			 }
			 
			 $resultArray["Totals"]["TotalRoomRateAndPackages"] = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["!TotalRoomRateAndPackages"];
			 $resultArray["Totals"]["TotalTaxesAndFees"] 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["!TotalTaxesAndFees"];
			 $resultArray["Totals"]["Total"]					= $resultArray["Totals"]["TotalRoomRateAndPackages"] + $resultArray["Totals"]["TotalTaxesAndFees"];
			
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
	*
	* detail availabilty
	*
	* @access protected
	* @param
	* @return
	*/
	public function rate_only($StartDate, $EndDate, $totalNumberOfGuests, $numberOfChildren, $numberOfRooms, $roomTypeCode = "ALL", $ratePlanCode = "", $availReqType = "Room", $invBlockCode = "", $promotionCode = '')
	{	
		$roomOccupancy = $totalNumberOfGuests + $numberOfChildren;
	
		$data = array();
	
		$data["summaryOnly"] 			= "false";
		$data["availReqType"] 			= $availReqType;
		$data["roomTypeCode"]			= $roomTypeCode;
		$data["ratePlanCode"]			= $ratePlanCode;
		$data["StartDate"]				= $StartDate;
		$data["EndDate"]				= $EndDate;
		$data["numberOfRooms"]			= $numberOfRooms;
		//$data["roomOccupancy"]			= $totalNumberOfGuests;
		$data["totalNumberOfGuests"] 	= $totalNumberOfGuests;
		$data["numberOfChildren"]	 	= $numberOfChildren;
		$data["promotionCode"]			= $promotionCode;
		$data["invBlockCode"]			= $invBlockCode;
		$data["qualifyingIdValue"]  	= "";
		$data["qualifyingIdType"]		= "";
	
		$resultArray = $this->CI->ows_availability->Availability($data);
	
		if($resultArray["success"])
		{	
			$result = $resultArray["response"];
			$resultArray["Totals"]["TotalRoomRateAndPackages"] = $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["!TotalRoomRateAndPackages"];
			$resultArray["Totals"]["TotalTaxesAndFees"] 		= $result["AvailResponseSegments"]["AvailResponseSegment"]["RoomStayList"]["RoomStay"]["ExpectedCharges"]["!TotalTaxesAndFees"];
			$resultArray["Totals"]["Total"]					= $resultArray["Totals"]["TotalRoomRateAndPackages"] + $resultArray["Totals"]["TotalTaxesAndFees"];		
		}
	
		unset($resultArray["response"]);
	
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 
	 * Fetch Available Packages
	 * 
	 * Fetch available packages
	 * @access	public
	 * @return
	 * 
	 */
	public function FetchAvailablePackages()
	{		
		$resultArray = $this->CI->ows_availability->FetchAvailablePackages();
		
		if($resultArray["success"])
		{
		
			try 
			{
				
			}
			catch(Exception $ex)
			{
				
			}
		}
		
		echo "<pre>";
		print_r($resultArray);
		echo "</pre>";
		
		
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
	*
	* Fetch Available Packages
	*
	* Fetch available packages
	* @access	public
	* @return
	*
	*/
	public function FetchExpectedChargesRequest($StartDate, 
												$EndDate, 
												$totalNumberOfGuests, 
												$numberOfChildren, 
												$numberOfRooms, 
												$roomTypeCode = "ALL", 
												$ratePlanCode = "", 
												$invBlockCode = "", 
												$promotionCode = '')
	{		
		$data = array();
		
		$data["roomTypeCode"]			= $roomTypeCode;
		$data["ratePlanCode"]			= $ratePlanCode;
		$data["StartDate"]				= $StartDate;
		$data["EndDate"]				= $EndDate;
		$data["numberOfRooms"]			= $numberOfRooms;
		$data["totalNumberOfGuests"] 	= $totalNumberOfGuests;
		$data["numberOfChildren"]	 	= $numberOfChildren;
		$data["promotionCode"]			= $promotionCode;
		$data["invBlockCode"]			= $invBlockCode;
		
		$resultArray = $this->CI->ows_availability->FetchExpectedChargesRequest($data);
	
		if($resultArray["success"])
		{
	
			try
			{
	
			}
			catch(Exception $ex)
			{
	
			}
		}
	
		echo "<pre>";
		print_r($resultArray);
		echo "</pre>";
	
	
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
}

// END Availability Class

/* End of file Availability.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/Availability0.php */
?>
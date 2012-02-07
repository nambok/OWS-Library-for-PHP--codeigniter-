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

class Reservation extends OWS_core
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
		//load admin constructor
		parent::__construct();
		
		parent::load_soap("OWS_reservation");
		
		$this->CI->load->helper('xml');
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * create booking
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function CreateBooking(	$UniqueID, 
									$ratePlanCode, 
									$roomTypeCode, 
									$numberOfUnits, 
									$adults, 
									$children, 
									$StartDate, 
									$EndDate, 
									$cardCode, 
									$cardHolderName, 
									$cardNumber, 
									$expirationDate,
									$email,
									$Comments = "",
									$invBlockCode = "",
									$coporateCode = FALSE)
	{		
		
		parent::load_model("OWS_rooms");
		$data = array();
		
		$data["UniqueID"]		= $UniqueID;
		$data["ratePlanCode"]	= $ratePlanCode;
		$data["roomTypeCode"]	= $roomTypeCode;
		$data["numberOfUnits"]	= $numberOfUnits;
		$data["adults"]		 	= $adults;
		$data["children"]		= $children; 
		$data["StartDate"]		= $StartDate;
		$data["EndDate"]		= $EndDate;
		$data["cardCode"]		= $cardCode;
		$data["cardHolderName"] = xml_convert($cardHolderName);
		$data["cardNumber"]		= $cardNumber;
		$data["expirationDate"] = $expirationDate;
		$data["Email"] 			= xml_convert($email);
		$data["Comments"]	 	= xml_convert($Comments);
		$data["invBlockCode"]	= $invBlockCode;
		
		$data["qualifyingIdType"]	= "";
		$data["qualifyingIdValue"]	= "";
		
		if($coporateCode)
		{
			$data["qualifyingIdType"]	= "CORPORATE";
			$data["qualifyingIdValue"]	= $ratePlanCode;
		}
		
		$resultArray = $this->CI->ows_reservation->CreateBooking($data);
		
		if($resultArray["success"])
		{
			$resultArray["reservationsList"] = array();
			try 
			{
				$reservation = $resultArray["response"]["HotelReservation"];
				
				$resultReservation["id"] 			= $reservation["UniqueIDList"]["UniqueID"]["0"];
				
				$resultReservation["TimeSpan"]		= $reservation["RoomStays"]["RoomStay"]["TimeSpan"];
				$resultReservation["ratePlan"]		= $reservation["RoomStays"]["RoomStay"]["RatePlans"]["RatePlan"];
								
				$resultReservation["Guest"]		= $reservation["ResGuests"]["ResGuest"]["Profiles"]["Profile"];
				
				if(!key_exists("Customer", $resultReservation["Guest"]))
				{
					$resultReservation["Guest"]		= $reservation["ResGuests"]["ResGuest"]["Profiles"]["Profile"][0];
				}
				
				if(!empty($invBlockCode))
				{
					$resultReservation["ratePlan"]["RatePlanDescription"] =  array("Text" => "Group Code: ".$invBlockCode);
				}
				
				if($coporateCode)
				{
					$resultReservation["ratePlan"]["AdditionalDetails"]["AdditionalDetail"][0]["AdditionalDetailDescription"]["Text"] = $resultReservation["ratePlan"]["AdditionalDetails"]["AdditionalDetail"][1]["AdditionalDetailDescription"]["Text"];
				}
				
				$resultReservation["Total"]			= $reservation["RoomStays"]["RoomStay"]["Total"]["!"];
				$resultReservation["roomFee"]		= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalRoomRateAndPackages"];
				$resultReservation["TaxesAndFees"]	= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalTaxesAndFees"];
				$room								= $reservation["RoomStays"]["RoomStay"]["RoomTypes"]["RoomType"];					
				$resultReservation["GuestCounts"] 	= $reservation["RoomStays"]["RoomStay"]["GuestCounts"]["GuestCount"];
				$resultReservation["Room"] 			= new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', '', '','');
				$resultReservation["status"]		= "RESERVED";
				$resultReservation["Payment"]		= $reservation["RoomStays"]["RoomStay"]["Guarantee"]["GuaranteesAccepted"]["GuaranteeAccepted"]["GuaranteeCreditCard"];
				$resultReservation["Payment"]["cardNumber"] = "***".substr($resultReservation["Payment"]["cardNumber"],-4,4);
				
				$resultReservation["core_totals"]   = $this->CI->ny_core->__get_total_tax(	$roomTypeCode,
																							$resultReservation["roomFee"],
																							$resultReservation["TaxesAndFees"],
																							GetDays($StartDate,$EndDate)
																						);
					 
				
				/*
				if(key_exists("CancelTerm", $reservation["RoomStays"]["RoomStay"]))
					$resultReservation["cancelTerm"]	= $reservation["RoomStays"]["RoomStay"]["CancelTerm"];
				else
					$resultReservation["cancelTerm"]    = "Please contact us for more info";
				*/
				
				$resultArray["reservationsList"]	= $resultReservation;
				
			}
			catch (Exception $ex)
			{
			}
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	*
	* create booking
	*
	* @access protected
	* @param
	* @return
	*/
	public function CreateBookingGuest(	$firstName,
										$lastName,
										$AddressLine,
										$cityName,
										$stateProv,
										$countryCode,
										$postalCode,
										$ratePlanCode,
										$roomTypeCode,
										$numberOfUnits,
										$adults,
										$children,
										$StartDate,
										$EndDate,
										$cardCode,
										$cardHolderName,
										$cardNumber,
										$expirationDate,
										$email,
										$Comments = "",
										$invBlockCode = "",
										$coporateCode = FALSE)
	{
	
		parent::load_model("OWS_rooms");
		$data = array();
		
		$data["firstName"]		= xml_convert($firstName);
		$data["lastName"]		= xml_convert($lastName);
		$data["AddressLine"]	= xml_convert($AddressLine);
		$data["cityName"]		= xml_convert($cityName);
		$data["stateProv"]		= xml_convert($stateProv);
		$data["countryCode"]	= $countryCode;
		$data["postalCode"]		= $postalCode;
		$data["ratePlanCode"]	= $ratePlanCode;
		$data["roomTypeCode"]	= $roomTypeCode;
		$data["numberOfUnits"]	= $numberOfUnits;
		$data["adults"]		 	= $adults;
		$data["children"]		= $children;
		$data["StartDate"]		= $StartDate;
		$data["EndDate"]		= $EndDate;
		$data["cardCode"]		= $cardCode;
		$data["cardHolderName"] = xml_convert($cardHolderName);
		$data["cardNumber"]		= $cardNumber;
		$data["expirationDate"] = $expirationDate;
		$data["Email"] 			= $email;
		$data["Comments"]	 	= xml_convert($Comments);
		$data["invBlockCode"]	= $invBlockCode;
	
		$data["qualifyingIdType"]	= "";
		$data["qualifyingIdValue"]	= "";
	
		if($coporateCode)
		{
			$data["qualifyingIdType"]	= "CORPORATE";
			$data["qualifyingIdValue"]	= $ratePlanCode;
		}
	
		$resultArray = $this->CI->ows_reservation->CreateBookingGuest($data);
		
		if($resultArray["success"])
		{
			$resultArray["reservationsList"] = array();
			try
			{
				$reservation = $resultArray["response"]["HotelReservation"];
	
				$resultReservation["id"] 			= $reservation["UniqueIDList"]["UniqueID"]["0"];
	
				$resultReservation["TimeSpan"]		= $reservation["RoomStays"]["RoomStay"]["TimeSpan"];
				$resultReservation["ratePlan"]		= $reservation["RoomStays"]["RoomStay"]["RatePlans"]["RatePlan"];
				
				$resultReservation["Guest"]		= $reservation["ResGuests"]["ResGuest"]["Profiles"]["Profile"];
				
				if(!key_exists("Customer", $resultReservation["Guest"]))
				{
					$resultReservation["Guest"]		= $reservation["ResGuests"]["ResGuest"]["Profiles"]["Profile"][0];
				}
				
				if(!empty($invBlockCode))
				{
					$resultReservation["ratePlan"]["RatePlanDescription"] =  array("Text" => "Group Code: ".$invBlockCode);
				}
				
				if($coporateCode)
				{
					$resultReservation["ratePlan"]["AdditionalDetails"]["AdditionalDetail"][0]["AdditionalDetailDescription"]["Text"] = $resultReservation["ratePlan"]["AdditionalDetails"]["AdditionalDetail"][1]["AdditionalDetailDescription"]["Text"];
				}
				
				$resultReservation["Total"]			= $reservation["RoomStays"]["RoomStay"]["Total"]["!"];
				$resultReservation["roomFee"]		= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalRoomRateAndPackages"];
				$resultReservation["TaxesAndFees"]	= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalTaxesAndFees"];
				$room								= $reservation["RoomStays"]["RoomStay"]["RoomTypes"]["RoomType"];
				$resultReservation["GuestCounts"] 	= $reservation["RoomStays"]["RoomStay"]["GuestCounts"]["GuestCount"];
				$resultReservation["Room"] 			= new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', '', '','');
				$resultReservation["status"]		= "RESERVED";
				$resultReservation["Payment"]		= $reservation["RoomStays"]["RoomStay"]["Guarantee"]["GuaranteesAccepted"]["GuaranteeAccepted"]["GuaranteeCreditCard"];
				$resultReservation["Payment"]["cardNumber"] = "***".substr($resultReservation["Payment"]["cardNumber"],-4,4);
				
				$resultReservation["core_totals"]   = $this->CI->ny_core->__get_total_tax(	$roomTypeCode,
																							$resultReservation["roomFee"],
																							$resultReservation["TaxesAndFees"],
																							GetDays($StartDate,$EndDate)
																						);
				/*
				if(key_exists("CancelTerm", $reservation["RoomStays"]["RoomStay"]))
					$resultReservation["cancelTerm"]	= $reservation["RoomStays"]["RoomStay"]["CancelTerm"];
				else
					$resultReservation["cancelTerm"]    = "Please contact us for more info";
				*/
	
				$resultArray["reservationsList"]	= $resultReservation;
	
			}
			catch (Exception $ex)
			{
			}
		}
	
		unset($resultArray["response"]);
	
		return $resultArray;
	
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * create booking
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function FutureBookingSummary($NameID)
	{
		$data["NameID"] = $NameID;		
		parent::load_model("OWS_rooms");
		
		$resultArray = $this->CI->ows_reservation->FutureBookingSummary($data);
		
		if($resultArray["success"])
		{
			$resultArray["reservationsList"] = array();
			try 
			{
				$reservations = array();
				$reservations = $resultArray["response"]["HotelReservations"]["HotelReservation"];
				
				foreach ($reservations as $reservation)
				{
					if(!key_exists("UniqueIDList", $reservation))
					{
						$reservations = $resultArray["response"]["HotelReservations"];
					}
					break;
				}
				
				foreach($reservations as $reservation)
				{				
					$resultReservation["id"] 			= $reservation["UniqueIDList"]["UniqueID"];
					$resultReservation["TimeSpan"]		= $reservation["RoomStays"]["RoomStay"]["TimeSpan"];
					$resultReservation["Total"]			= $reservation["RoomStays"]["RoomStay"]["Total"]["!"];
					$room								= $reservation["RoomStays"]["RoomStay"]["RoomTypes"]["RoomType"];					
					$resultReservation["GuestCounts"] 	= $reservation["RoomStays"]["RoomStay"]["GuestCounts"]["GuestCount"];
					$resultReservation["Room"] 			= new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', '', '','');
					$resultReservation["status"]		= $reservation["!reservationStatus"];
					$resultArray["reservationsList"][]	= $resultReservation;
				}
			}
			catch (Exception $ex)
			{
			}
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * fetch booking
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function FetchBooking($ConfirmationNumber)
	{
		$data["ConfirmationNumber"] = $ConfirmationNumber;		
		parent::load_model("OWS_rooms");
		
		$resultArray = $this->CI->ows_reservation->FetchBooking($data);
		
		if($resultArray["success"])
		{
			$resultArray["reservationsList"] = array();
			try 
			{
				$reservation = $resultArray["response"]["HotelReservation"];
				
				$resultReservation["id"] 			= $reservation["UniqueIDList"]["UniqueID"]["0"];
				
				$resultReservation["TimeSpan"]		= $reservation["RoomStays"]["RoomStay"]["TimeSpan"];
				
				$resultReservation["Total"]			= $reservation["RoomStays"]["RoomStay"]["Total"]["!"];
				$resultReservation["TaxesAndFees"]	= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalTaxesAndFees"];
				$resultReservation["roomFee"]		= $reservation["RoomStays"]["RoomStay"]["ExpectedCharges"]["!TotalRoomRateAndPackages"];
				$room								= $reservation["RoomStays"]["RoomStay"]["RoomTypes"]["RoomType"];					
				$resultReservation["GuestCounts"] 	= $reservation["RoomStays"]["RoomStay"]["GuestCounts"]["GuestCount"];
				$resultReservation["Room"] 			= new OWS_rooms($room["RoomTypeDescription"]["Text"], $room["!roomTypeCode"], '', '', '','');
				$resultReservation["status"]		= $reservation["!reservationStatus"];
				$resultReservation["Payment"]		= $reservation["RoomStays"]["RoomStay"]["Guarantee"]["GuaranteesAccepted"]["GuaranteeAccepted"]["GuaranteeCreditCard"];
				$resultReservation["Payment"]["cardNumber"] = "***".substr($resultReservation["Payment"]["cardNumber"],-4,4);
				$resultReservation["ratePlan"]		= $reservation["RoomStays"]["RoomStay"]["RatePlans"]["RatePlan"];
				
				if(!key_exists("RatePlanDescription", $resultReservation["ratePlan"]))
				{
					$resultReservation["ratePlan"]["RatePlanDescription"] = array("Text" => "Group Code: ".$room["!invBlockCode"]);
				}
				
				$StartDate = explode("T", $resultReservation["TimeSpan"]["StartDate"], 2);
				$EndDate = explode("T", $resultReservation["TimeSpan"]["EndDate"], 2);
				
				$StartDate = date("Y-m-d", strtotime($StartDate[0]));
				$EndDate = date("Y-m-d", strtotime($EndDate[0]));
				
				$resultReservation["core_totals"]["tax"] = 0;
				$resultReservation["core_totals"]["total"] = $resultReservation["Total"];
				/*
				$resultReservation["core_totals"]   = $this->CI->ny_core->__get_total_tax(	$room,
																							$resultReservation["roomFee"],
																							$resultReservation["TaxesAndFees"],
																							GetDays($StartDate,$EndDate)
																						);
				*/

				if(key_exists("CancelTerm", $reservation["RoomStays"]["RoomStay"]))
					$resultReservation["cancelTerm"]	= $reservation["RoomStays"]["RoomStay"]["CancelTerm"];
					
				$resultArray["reservationsList"]	= $resultReservation;
				
			}
			catch (Exception $ex)
			{
			}
			
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
		
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * cancel booking
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	public function CancelBooking($ConfirmationNumber, $CancelReason)
	{
		$data["ConfirmationNumber"] = $ConfirmationNumber;
		$data["CancelReason"]		= $CancelReason;		
		
		$resultArray = $this->CI->ows_reservation->CancelBooking($data);
		
		if($resultArray["success"])
		{
			try 
			{
				$resultArray["confNumber"] = $resultArray["response"]["Result"]["IDs"]["IDPair"]["!operaId"];
			}
			catch (Exception $ex)
			{
			}
		}
		
		unset($resultArray["response"]);
		
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
}

// END Reservation Class

/* End of file Reservation.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/Reservation.php */
?>
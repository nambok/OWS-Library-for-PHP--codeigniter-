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

class Membership extends OWS_core
{
	/*
	 * Variables
	 */
	
	/**
	 * 
	 */
	private $type = "WWR";
	
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
		
		parent::load_soap("OWS_membership");
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	* FetchEnrollmentCode
	*
	* @access public
	* @param
	* @return
	*/
	public function FetchEnrollmentCode($NameID)
	{
		$data = array();
	
		$data["MembershipId"] = $NameID;
		$data["type"] = $this->type;
	
		$result = $this->CI->ows_membership->FetchEnrollmentCode($data);
	
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
	* UpdateEnrollmentCode
	*
	* @access public
	* @param
	* @return
	*/
	public function UpdateEnrollmentCode($NameID)
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
	
}

// END Membership Class

/* End of file Membership.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/Membership.php */
?>
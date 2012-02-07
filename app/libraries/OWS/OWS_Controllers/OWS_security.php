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

class OWS_security extends OWS_core
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
		$this->load_session();
		
		parent::load_soap("OWS_soap_security");
				
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
	public function AuthenticateUser($loginName, $password)
	{		
		$data = array();
		
		$data["loginName"]		= $loginName;
		$data["password"]		= $password;
		
		$resultArray = $this->CI->ows_soap_security->AuthenticateUser($data);
		
		if($resultArray["success"])
		{
			$this->CI->ows_session_core->session_init($resultArray["response"]["NameID"], $loginName);
		}
		
		unset($resultArray["response"]); 
		
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 *
	 *
	 * @access public
	 * @param
	 * @return
	 */
	public function UpdatePassword($loginName, $oldPassword, $newPassword)
	{	
		$data = array();
	
		$data["loginName"]		= $loginName;
		$data["oldPassword"]	= $oldPassword;
		$data["newPassword"]	= $newPassword;
	
		$resultArray = $this->CI->ows_soap_security->UpdatePassword($data);
	
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 *
	 *
	 * @access public
	 * @param
	 * @return
	 */
	public function GeneratePassword($loginName)
	{	
		$data = array();
	
		$data["loginName"]		= $loginName;
	
		$resultArray = $this->CI->ows_soap_security->GeneratePassword($data);
	
		return $resultArray;
	}
	
	// --------------------------------------------------------------------
	
}

// END Name Class

/* End of file Name.php */
/* Location: ./app/libraries/OWS/OWS_Controllers/Name.php */
?>
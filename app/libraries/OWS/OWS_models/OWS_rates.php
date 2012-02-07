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

class OWS_rates
{
	/*
	 * Variables
	 */	
	
	/**
	 * ratePlanCode
	 * 
	 * @var		varchar(255)
	 * @access 	public
	 * 
	 */
	public $ratePlanCode;
	
	/**
	 * Total
	 * 
	 * @var		float
	 * @access 	public
	 * 
	 */
	public $Total;
	
	/**
	 * currencyCode
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $currencyCode;
	
	/**
	 * hold
	 * 
	 * @var		bool
	 * @access 	public
	 * 
	 */
	public $hold;
	
	/**
	 * invBlockCode
	 * 
	 * @var		string
	 * @access 	public
	 * 
	 */
	public $invBlockCode;
	
	/**
	 * CancellationDateTime
	 * 
	 * @var		Array
	 * @access 	public
	 * 
	 */
	public $CancelationDateTime;
	
	/**
	 * description
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $description;
	
	// --------------------------------------------------------------------
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function __construct($ratePlanCode = '', $hold = '', $CancellationDateTime = '', $description = '', $Total = '', $currencyCode = '', $invBlockCode = '')
	{	
		$this->set_Rate($ratePlanCode, $hold, $CancellationDateTime, $description, $Total, $currencyCode, $invBlockCode);
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
	public function	set_Rate($ratePlanCode, $hold, $CancellationDateTime, $description, $Total, $currencyCode, $invBlockCode)
	{		
		$this->ratePlanCode			= $ratePlanCode;
		$this->hold					= $hold;
		$this->CancelationDateTime	= $CancellationDateTime;
		$this->description		 	= $description;
		$this->Total				= $Total;
		$this->currencyCode			= $currencyCode;
		$this->invBlockCode			= $invBlockCode;
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_rates Class

/* End of file OWS_rates.php */
/* Location: ./app/libraries/OWS/OWS_models/OWS_rates.php */
?>
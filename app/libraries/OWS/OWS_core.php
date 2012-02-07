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

class OWS_core
{
	/*
	 * Variables
	 */
	
	/**
	 * CI object
	 * 
	 * @var		CI Object
	 * @access	public
	 */
	public $CI;
	
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
		$this->CI =& get_instance();
		
		$this->CI->load->library("OWS/OWS_SOAP/OWS_xml");
		$this->CI->load->library("OWS/OWS_SOAP/OWS_soap");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * load
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function load($controller)
	{	
		if(!empty($controller))
			$this->CI->load->library("OWS/OWS_Controllers/".$controller);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * load session
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function load_session()
	{	
		$this->CI->load->library("OWS/OWS_session_core");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * load protected
	 * 
	 * @access protected
	 * @param
	 * @return
	 */
	protected function load_soap($soap_library)
	{	
		if(!empty($soap_library))
			$this->CI->load->library("OWS/OWS_SOAP/".$soap_library);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * load model
	 * 
	 * @access protected
	 * @param
	 * @return
	 */
	protected function load_model($model)
	{	
		if(!empty($model))
			$this->CI->load->library("OWS/OWS_models/".$model);
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_core_controller Class

/* End of file OWS_core.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_core.php */
?>
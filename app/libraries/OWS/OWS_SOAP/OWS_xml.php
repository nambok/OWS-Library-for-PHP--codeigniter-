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

class OWS_xml
{
	/*
	 * Variables
	 */
	
	/**
	 * template
	 * 
	 * @var		string
	 * @access	protected
	 */
	protected $template;
	
	/**
	 * timezone offset
	 * 
	 * @var		string
	 * @access	public
	 */
	private $timezone_offset;

	/**
	 * data
	 * 
	 * @var		CI Object
	 * @access	public
	 */
	public $data;
	
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
		
		$this->timezone_offset = "-05:00";
		
		$this->data = array("chainCode" 		=> "CHA",
							"hotelCode"			=> "12542",
							"transactionID"		=> "000032");
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * create request
 	 *
 	 * @access protected	
 	 * @param
 	 * @return	
  	 */
	protected function __build_request($requestFile, $data = array())
	{
		if(!empty($requestFile))
		{
			$parse_data = array_merge($this->data, $data);
			
			$parse_data["timeStamp"] = date("Y-m-d",time())."T".date("H:i:s.0000000", time()).$this->timezone_offset;
			
			$xml_request = '<?xml version="1.0" encoding="utf-8"?>';
			
			$xml_request .= $this->CI->parser->parse('OWS/'.$requestFile, $parse_data, TRUE);
			
			return $xml_request;
		}
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_xml Class

/* End of file OWS_xml.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_xml.php */
?>
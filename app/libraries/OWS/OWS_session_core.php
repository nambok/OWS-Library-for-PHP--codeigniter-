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

class OWS_session_core
{
	/*
	 * Variables
	 */
	
	/**
	 * 
	 * CI object
	 * 
	 * @var 	CI object
	 * @access	public
	 * 
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
				
		$this->CI->load->library('session');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * session_init
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function session_init($operaID, $loginName)
	{	
		$user_data = array(
                   'operaID'   		=> $operaID,
                   'OWS_logged_in' 	=> TRUE,
				   'OWS_loginName'	=> $loginName,
				   'OWS_token'		=> $this->make_token(128)
               );

		$this->CI->session->set_userdata($user_data);
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * Is logged in
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function isLoggedIn($token = '')
	{		
		//if(empty($token))
		//{
			//$this->session_destroy();
			//return FALSE;
		//}
		
		if($this->verify_token($token) && $this->CI->session->userdata("OWS_logged_in"))
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * get user data
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function getUserData($data)
	{		
		return $this->CI->session->userdata($data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * logout
	 * 
	 * @access public
	 * @param
	 * @return
	 */
	public function session_destroy()
	{	
		$this->CI->session->sess_destroy();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create a token for login
	 *
	 * @param	int
	 * @return	string
	 */
	private function make_token( $length ) 
	{
	   $this->CI->load->helper('string');
	   
	   return random_string('sha1', $length);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Verify toke_key
	 *
	 * @param	string
	 * @return	bool
	 */
	function verify_token( $token ) 
	{
		return TRUE;
		/*
	   if($token == $this->ci->session->userdata('OWS_token'))
	   {
	   		return TRUE;
	   }
	   else 
	   {
	   		$this->session_destroy();
	   		return FALSE;
	   }*/
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_session_core Class

/* End of file OWS_session_core.php */
/* Location: ./app/libraries/OWS/OWS_SOAP/OWS_session_core.php */
?>
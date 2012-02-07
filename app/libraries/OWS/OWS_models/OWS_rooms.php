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
	 * short_description
	 * 
	 * @var		text
	 * @access 	public
	 * 
	 */
	public $short_description;
	
	/**
	 * category
	 * 
	 * @var		int
	 * @access 	public
	 * 
	 */
	public $category;
	
	/**
	 * code
	 * 
	 * @var		varchar(25)
	 * @access 	public
	 * 
	 */
	public $code;
	
	/**
	 * website_bestrate
	 * 
	 * @var		int
	 * @access 	public
	 * 
	 */
	public $website_bestrate;
	
	/**
	 * maxOccupancy
	 * 
	 * @var		int(10)
	 * @access 	public
	 * 
	 */
	public $maxOccupancy;
	
	/**
	 * rates
	 * 
	 * @var		OWS_rates model
	 * @access 	public
	 * 
	 */
	public $rates;
	
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
	public function __construct($ows_description ='', $code ='', $maxOccupancy ='', $rates = array())
	{			
		$this->set_Room($ows_description, $code, $maxOccupancy, $rates);
		
		if(is_array($rates))
		{
			$this->website_bestrate = $this->get_websitebest_rate();
		
			$this->sortRates();
		}
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
	public function	set_Room($ows_description, $code, $maxOccupancy, $rates)
	{
		$this->code				= $code;
		
		if($this->get_custom_data())
		{		
			$this->title 			= '';
			$this->RoomDescription	= $ows_description;
			$this->__convert_ows_description();
		}
		
		$this->maxOccupancy		= $maxOccupancy;
		$this->rates			= $rates;
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * get Lowest Rate
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function	getLowestRate()
	{
		try
		{
			$lowest_rate = 0;
			$lowest_rate_index = 0;
			$counter = 0;
			foreach($this->rates as $rate)
			{
				if($counter == 0)
				{
					$lowest_rate = $rate->Total;
					++$counter;
					continue;
				}

				if($rate->Total < $lowest_rate)
				{
					$lowest_rate_index = $counter;
					$lowest_rate = $rate->Total;		
				}
				
				++$counter;
			}

			return $this->rates[$lowest_rate_index];
		}
		catch (Exception $ex)
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * Sort Rates
 	 *
 	 * @access private	
 	 * @param
 	 * @return	
  	 */
	private function sortRates()
	{
		try
		{
			$CI =& get_instance();
			$rates_sorted = array();
			
			if(intval($CI->ny_core->__get_config("reservations/availability/number_rates")) > 0)
			{
				$counter = 0;
				$rates = array();
				
				foreach($this->rates as $key => $rate)
				{
					if($rate->ratePlanCode == $CI->ny_core->__get_config("reservations/availability/websitebest_rate"))
						continue;
					
					$rates[$rate->ratePlanCode] = $rate->Total; 
				}
				
				asort($rates);
				
				foreach($rates as $key => $value)
				{
					$i = 0;
					foreach($this->rates as $rate)
					{
						if($rate->ratePlanCode == $key)
						{
							$rates_sorted[] = $rate;
							unset($this->rates[$i]);
							break;
						}
						++$i;
					}
					
					if($counter >= intval($CI->ny_core->__get_config("reservations/availability/number_rates")) -1 )
						break;
					
					++$counter;
				}
			}

			$this->rates = $rates_sorted;
		}
		catch (Exception $ex)
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
 	 * 
 	 * get main_thumbnail
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function	get_main_thumbnail()
	{
		try
		{
			$counter = 0;
			foreach($this->media as $media)
			{
				if($media->role == "main")
				{
					return $this->media[$counter];
					break;
				}
				++$counter;
			}
			
			return FALSE;
			
		}
		catch (Exception $ex)
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	*
	* get banner_images
	*
	* @access public
	* @param
	* @return
	*/
	public function	get_banner_images()
	{
		try
		{
			$counter = 0;
			$banner_img = array();
			
			foreach($this->media as $media)
			{
				if($media->role == "banner")
				{
					$banner_img[] = $this->media[$counter];
				}
				++$counter;
			}
		
			return $banner_img;
		
		}
		catch (Exception $ex)
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	
	/**
 	 * 
 	 * get website_best Rate
 	 *
 	 * @access public	
 	 * @param
 	 * @return	
  	 */
	public function	get_websitebest_rate()
	{
		try
		{
			$CI =& get_instance();
			
			$counter = 0;
			foreach($this->rates as $rate)
			{
				if($rate->ratePlanCode == $CI->ny_core->__get_config("reservations/availability/websitebest_rate"))
					return $this->rates[$counter];
				++$counter;
			}

			return FALSE;
		}
		catch (Exception $ex)
		{
			return 0;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * ows_smart_description
	 * 
	 * @access private
	 * @param
	 * @return
	 */
	private function __convert_ows_description()
	{	
		$this->title 		   		= preg_replace('/^([^.]*).*$/', '$1', $this->RoomDescription);	
		$this->RoomDescription 		= preg_replace('/^[^.]*.\s*/', '$1', $this->RoomDescription);
		$this->short_description	= $this->RoomDescription;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * get_custom_data
	 * 
	 * @access private
	 * @param
	 * @return
	 */
	private function get_custom_data()
	{
		$CI =& get_instance();
		
		$this->media = $CI->Model_rooms_media->GetMedia($this->code);
		
		$room_tmp = $CI->Model_rooms->Get($this->code);
		
		if($room_tmp->custom_data)
		{
			$this->title 				= $room_tmp->title;
			$this->RoomDescription		= $room_tmp->RoomDescription;
			$this->short_description	= $room_tmp->short_description; 
			$this->category				= $room_tmp->category;
			return FALSE;
		}
		
		return TRUE;
		
	}
	
	// --------------------------------------------------------------------
	
}

// END OWS_rooms Class

/* End of file OWS_rooms.php */
/* Location: ./app/libraries/OWS/OWS_models/OWS_rooms.php */
?>
<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


use david63\langgroup\controller\main_controller;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \david63\langgroup\controller\main_controller */
	protected $main_controller;

   /**
	* Constructor for listener
	*
	* @param \david63\langgroup\controller\main_controller 	$main_controller	Main Controller
	*
	* @access public
	*/
	public function __construct(main_controller $main_controller)
	{
		$this->main_controller = $main_controller;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_prefs_personal_update_data'	=> 'user_prefs',
			'core.ucp_register_register_after'		=> 'user_reg',
		);
	}

	public function user_reg($event)
	{
		$this->main_controller->lang_group($event, true);
	}

	/**
	* Process the User UCP data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_prefs($event)
	{
		$this->main_controller->lang_group($event, false);
	}
}

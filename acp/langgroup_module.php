<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\acp;

class langgroup_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name 	= 'lang_group_manage';
		$this->page_title	= $phpbb_container->get('language')->lang('LANG_GROUP');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.langgroup.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->option_settings();
	}
}

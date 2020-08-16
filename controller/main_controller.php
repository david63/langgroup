<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\controller;

use phpbb\config\config;
use phpbb\user;
use phpbb\log\log;
use david63\langgroup\core\utils;

/**
* Main controller
*/
class main_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log */
	protected $log;

	/** @var \david63\langgroup\core\utils */
	protected $utils;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpBB extension */
	protected $php_ext;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config			$config			Config object
	* @param \phpbb\user					$user			User object
	* @param \phpbb\log\log					$log			Log object
	* @param \david63\langgroup\core\utils	$utils			Utilities for the extension
	* @param string							$root_path		phpBB root path
	* @param string							$php_ext		phpBB extension
	*
	* @return \phpbb\langgroup\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, user $user, utils $utils, log $log, string $root_path, string $php_ext)
	{
		$this->config		= $config;
		$this->user			= $user;
		$this->log			= $log;
		$this->utils		= $utils;
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function lang_group($event, $new_reg)
	{
		$data_lang 		= $event['data']['lang'];
		$current_lang	= $this->user->data['user_lang'];

		if (!function_exists('group_user_add'))
		{
			include_once($this->root_path . '\includes\functions_user.' . $this->php_ext);
		}

		if (!group_memberships($this->config['lg_exclude_group'], $this->user->data['user_id'], true) && $this->config['lg_exclude_group_enable'])
		{
			// Has the language changed?
			if (($data_lang != $current_lang) || $new_reg)
			{
				// Does the new language group exist?
				if ($this->utils->group_name_exist($data_lang))
				{
					$user_id = ($new_reg) ? $event['user_id'] : $this->user->data['user_id'];

					// Add the user to the language group
					group_user_add($this->utils->get_group_id($data_lang), $user_id);

					// Do we need to remove the user from another group?
					// Does the old language group exist?
					if ($this->utils->group_name_exist($current_lang) && !$new_reg)
					{
						$group_id = $this->utils->get_group_id($current_lang);

						// Is the user a member of this group?
						if (group_memberships($group_id, $this->user->data['user_id'], true))
						{
							// Delete the user from the group
							group_user_del($group_id, $this->user->data['user_id'], false, false, false);
						}
					}
				}
				else
				{
					// Add a log entry that the language group does not exist
					$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_LANG_GROUP_MISSING', time(), array($data_lang));
				}
			}
		}
	}
}

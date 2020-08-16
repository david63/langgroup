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
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;
use david63\langgroup\core\functions;
use david63\langgroup\core\utils;

/**
* Admin controller
*/
class admin_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log */
	protected $log;

	/** @var \david63\langgroup\core\functions */
	protected $functions;

	/** @var \david63\langgroup\core\utils */
	protected $utils;

	/** @var string phpBB tables */
	protected $tables;

	/** @var string */
	protected $ext_images_path;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpBB extension */
	protected $php_ext;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config				$config				Config object
	* @param \phpbb\db\driver\driver_interface	$db					Database object
	* @param \phpbb\request\request				$request			Request object
	* @param \phpbb\template\template			$template			Template object
	* @param \phpbb\user						$user				User object
	* @param \phpbb\language\language			$language			Language object
	* @param \phpbb\log\log						$log				Log object
	* @param \david63\langgroup\core\functions	$functions			Functions for the extension
	* @param \david63\langgroup\core\utils		$utils				Utilities for the extension
	* @param array								$tables				phpBB db tables
	* @param string								$ext_images_path	Path to this extension's images
	* @param string								$phpbb_root_path    phpBB root path
	* @param string								$php_ext            phpBB extension
	*
	* @return \david63\langgroup\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, driver_interface $db, request $request, template $template, user $user, language $language, log $log, functions $functions, utils $utils, array $tables, string $ext_images_path, string $root_path, string $php_ext)
	{
		$this->config			= $config;
		$this->db  				= $db;
		$this->request			= $request;
		$this->template			= $template;
		$this->user				= $user;
		$this->language			= $language;
		$this->log				= $log;
		$this->functions		= $functions;
		$this->utils			= $utils;
		$this->tables			= $tables;
		$this->ext_images_path	= $ext_images_path;
		$this->root_path  		= $root_path;
		$this->php_ext			= $php_ext;
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function option_settings()
	{
		// Add the language files
		$this->language->add_lang(array('acp_langgroup', 'acp_common'), $this->functions->get_ext_namespace());

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$php_valid 		= $valid[0] ? true : false;
		$phpbb_valid	= $valid[1] ? true : false;

		// Create a form key for preventing CSRF attacks
		$form_key = 'langgroups';
		add_form_key($form_key);

		// Is the options form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LANGUAGE_GROUPS_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Is the sync form being submitted
		if ($this->request->is_set_post('sync'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Get installed languages/language groups
			$lang_ary = [];

			$sql = 'SELECT lang_iso
					FROM ' . $this->tables['lang'];

			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($this->utils->group_name_exist($row['lang_iso']))
				{
					$row['group_id'] = $this->utils->get_group_id($row['lang_iso']);
					$lang_ary[] = $row;
				}
			}

			$this->db->sql_freeresult($result);

			// If we have language groups then we can continue
			if (count($lang_ary))
			{
				// Get the users
				$user_ary = [];

				$sql = 'SELECT user_id, user_lang, user_type
						FROM ' . $this->tables['users'];

				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_ary[] = $row;
				}

				$this->db->sql_freeresult($result);

				// Add the user functions
				if (!function_exists('group_user_add'))
				{
					include_once($this->root_path . '\includes\functions_user.' . $this->php_ext);
				}

				foreach ($lang_ary as $group_data)
				{
					$user_del_ary = $user_add_ary = [];

					foreach ($user_ary as $user_data)
					{
						if ($user_data['user_lang'] != 0 || $user_data['user_type'] != USER_IGNORE)
						{
							// Let's start by finding the users of the groups
							if (group_memberships($group_data['group_id'], $user_data['user_id'], true))
							{
								$user_del_ary[] = $user_data['user_id'];
							}

							// Now create the users to add
							if ($user_data['user_lang'] == $group_data['lang_iso'])
							{
								if (!$this->config['lg_exclude_group_enable'])
								{
									$user_add_ary[] = $user_data['user_id'];
								}
								else if (!group_memberships($this->config['lg_exclude_group'], $user_data['user_id'], true))
								{
									$user_add_ary[] = $user_data['user_id'];
								}
							}
						}
					}

					// Now we can delete the users from the group
					group_user_del($group_data['group_id'], $user_del_ary, false, false, false);

					// Now add the users to their correct group
					// Does the new language group exist?
					if ($this->utils->group_name_exist($group_data['lang_iso']))
					{
						// Add the users to the language group
						group_user_add($group_data['group_id'], $user_add_ary);
					}
				}

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LANGUAGE_GROUPS_SYNC');

				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->language->lang('GROUPS_SYNCD') . adm_back_link($this->u_action));
			}
			else
			{
				// No language groups to sync
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LANGUAGE_GROUPS_NOT_SYNC');
				trigger_error($this->language->lang('GROUPS_NOT_SYNCD') . adm_back_link($this->u_action));
			}
		}

		// Template vars for header panel
		$version_data	= $this->functions->version_check();

		$this->template->assign_vars(array(
			'DOWNLOAD'			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH' 	=> $this->ext_images_path,

			'HEAD_TITLE'		=> $this->language->lang('LANGUAGE_GROUPS'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('LANGUAGE_GROUPS_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID'			=> $php_valid,
			'PHPBB_VALID'		=> $phpbb_valid,

			'S_VERSION_CHECK'	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER'	=> $this->functions->get_meta('version'),
		));

		$exclude_group	 = isset($this->config['lg_exclude_group']) ? $this->config['lg_exclude_group'] : 0;

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'EXCLUDE_ENABLE'	=> isset($this->config['lg_exclude_group_enable']) ? $this->config['lg_exclude_group_enable'] : '',
			'EXCLUDE_GROUP'		=> group_select_options($this->config['lg_exclude_group'], false, false),

			'U_ACTION'			=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('lg_exclude_group', $this->request->variable('lg_exclude_group', 0));
		$this->config->set('lg_exclude_group_enable', $this->request->variable('lg_exclude_group_enable', 0));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}

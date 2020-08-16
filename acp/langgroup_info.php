<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\acp;

class langgroup_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\langgroup\acp\langgroup_module',
			'title'		=> 'LANG_GROUP_MANAGE',
			'modes'		=> array(
				'manage'	=> array('title' => 'LANG_GROUP_MANAGE', 'auth' => 'ext_david63/langgroup && acl_a_profile', 'cat' => array('ACP_GROUPS')),
			),
		);
	}
}

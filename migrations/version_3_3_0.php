<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('lg_exclude_group', 0)),
			array('config.add', array('lg_exclude_group_enable', 0)),

			// Add the ACP module
			array('module.add', array(
				'acp', 'ACP_GROUPS', array(
					'module_basename'	=> '\david63\langgroup\acp\langgroup_module',
					'modes'				=> array('manage'),
				),
			)),
		);
	}
}

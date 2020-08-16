<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\langgroup\core;

use phpbb\db\driver\driver_interface;

/**
* functions
*/
class utils
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string phpBB tables */
	protected $tables;

	/**
	* Constructor for functions
	*
	* @param \phpbb\db\driver\driver_interface 	$db			Db object
	* @param array	                            $tables		phpBB db tables
	*
	* @access public
	*/
	public function __construct(driver_interface $db, array $tables)
	{
		$this->db  		= $db;
		$this->tables	= $tables;
	}

	/**
	* Check if a group name exists
	*
	* @param $default
	*
	* @return string $row
	* @access protected
	*/
	public function group_name_exist($group)
	{
		$sql = 'SELECT group_name
			FROM ' . $this->tables['groups'] . "
			WHERE LOWER(group_name) = '$group'";

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$this->db->sql_freeresult($result);

		return ($row) ? true : false;
	}

	/**
	* Get a group id from a group name
	*
	* @param $default
	*
	* @return string $row
	* @access protected
	*/
	public function get_group_id($group)
	{
		$sql = 'SELECT group_id
			FROM ' . $this->tables['groups'] . "
			WHERE LOWER(group_name) = '$group'";

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$this->db->sql_freeresult($result);

		return $row['group_id'];
	}
}

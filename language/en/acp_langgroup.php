<?php
/**
*
* @package Language Group Extension
* @copyright (c) 2020 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'EXCLUDE_ENABLE'			=> 'Enable the use of the “Exclude Group”',
	'EXCLUDE_ENABLE_EXPLAIN'	=> 'Enabling this will mean that any members of the “Exclude Group” will not be subject to being in any of the language groups.',
	'EXCLUDE_GROUP'				=> 'Select exclude group',
	'EXCLUDE_GROUP_EXPLAIN'		=> 'The members of this group will not be moved into any of the language groups.',

	'GROUPS_NOT_SYNCD'			=> 'No language groups to synchronise',
	'GROUPS_SYNCD'				=> 'Language groups synchronised',

	'LANG_GROUP'				=> 'Language group',
	'LANGUAGE_GROUPS'			=> 'Language Groups',
	'LANGUAGE_GROUPS_EXPLAIN'	=> 'Here you can manage the options for the language groups.',

	'OPTIONS'					=> 'Options',

	'SYNC'						=> 'Sync',
	'SYNC_EXPLAIN'				=> 'Synchronise/re-synchronise the language groups for all users.',
	'SYNCHRONISE'				=> 'Synchronise',
));

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
	'EXCLUDE_ENABLE'			=> 'Activer l‘utilisation du "Groupe d‘exclusion"',
	'EXCLUDE_ENABLE_EXPLAIN'	=> 'L‘activation de cette option signifie que les membres du «Groupe d‘exclusion» ne seront soumis à aucun des groupes linguistiques.',
	'EXCLUDE_GROUP'				=> 'Sélectionnez un groupe d‘exclusion',
	'EXCLUDE_GROUP_EXPLAIN'		=> 'Les membres de ce groupe ne seront déplacés dans aucun des groupes linguistiques.',

	'GROUPS_NOT_SYNCD'			=> 'Aucun groupe de langues à synchroniser',
	'GROUPS_SYNCD'				=> 'Groupes de langues synchronisés',

	'LANG_GROUP'				=> 'Groupe de langues',
	'LANGUAGE_GROUPS'			=> 'Groupes de langues',
	'LANGUAGE_GROUPS_EXPLAIN'	=> 'Ici, vous pouvez gérer les options pour les groupes de langues.',

	'OPTIONS'					=> 'Options',

	'SYNC'						=> 'Synchroniser',
	'SYNC_EXPLAIN'				=> 'Synchroniser/resynchroniser les groupes de langues pour tous les utilisateurs.',
	'SYNCHRONISE'				=> 'Synchroniser',
));

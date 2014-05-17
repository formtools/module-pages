<?php


/**
 * The uninstallation script for the Pages module. This basically does a little clean up
 * on the database to ensure it doesn't leave any footprints. Namely:
 *   - the module_pages table is removed
 *   - any references in client or admin menus to any Pages are removed
 *   - if the default login page for any user account was a Page, it attempts to reset it to
 *     a likely login page (the Forms page for both).
 *
 * The message returned by the script informs the user the module has been uninstalled, and warns them
 * that any references to any of the Pages in the user accounts has been removed.
 *
 * @return array [0] T/F, [1] success message
 */
function pages__uninstall($module_id)
{
	global $g_table_prefix, $LANG;

	$pages = mysql_query("SELECT page_id FROM {$g_table_prefix}module_pages");
	while ($row = mysql_fetch_assoc($pages))
	{
	  $page_id = $row["page_id"];
	  mysql_query("DELETE FROM {$g_table_prefix}menu_items WHERE page_identifier = 'page_{$page_id}");
	}

	// delete the Pages module table
	$result = mysql_query("DROP TABLE {$g_table_prefix}module_pages");

	// update sessions in case a Page was in the administrator's account menu
	ft_cache_account_menu($account_id = $_SESSION["ft"]["account"]["account_id"]);

	return array(true, $LANG["pages"]["notify_module_uninstalled"]);
}
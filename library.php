<?php

/**
 * This file defines all functions relating to the Pages module.
 *
 * @copyright Encore Web Studios 2008
 * @author Encore Web Studios <formtools@encorewebstudios.com>
 * @package 2-0-0
 * @subpackage Pages
 */


// ------------------------------------------------------------------------------------------------

// this logs the location of the page.php page linked to by menu items for all pages
$g_pages["custom_page"] = "/modules/pages/page.php";


/**
 * Updates the (one and only) setting on the Settings page.
 *
 * @param array $info
 * @return array [0] true/false
 *               [1] message
 */
function pg_update_settings($info)
{
  global $L;

  $settings = array("num_pages_per_page" => $info["num_pages_per_page"]);
  ft_set_module_settings($settings);

  return array(true, $L["notify_settings_updated"]);
}


/**
 * Adds a new page to the module_pages table.
 *
 * @param array $info
 * @return array standard return array
 */
function pg_add_page($info)
{
	global $g_table_prefix, $LANG;

	$info = ft_sanitize($info);

  $page_name = $info["page_name"];
  $heading   = $info["heading"];
  $content   = $info["page_html"];

  mysql_query("
    INSERT INTO {$g_table_prefix}module_pages (page_name, heading, content)
    VALUES ('$page_name', '$heading', '$content')
      ");
  $page_id = mysql_insert_id();

  if ($page_id != 0)
  {
  	$success = true;
  	$message = $LANG["notify_page_added"];
  }
  else
  {
  	$success = false;
  	$message = $LANG["notify_page_not_added"];
  }

  return array($success, $message);
}


/**
 * Deletes a page.
 *
 * TODO: delete this page from any menus.
 *
 * @param integer $page_id
 */
function pg_delete_page($page_id)
{
	global $g_table_prefix, $L;

	mysql_query("DELETE FROM {$g_table_prefix}module_pages WHERE page_id = $page_id");

	return array(true, $L["notify_delete_page"]);
}


/**
 * Returns all information about a particular Page.
 *
 * @param integer $page_id
 * @return array
 */
function pg_get_page($page_id)
{
	global $g_table_prefix;

	$query = mysql_query("SELECT * FROM {$g_table_prefix}module_pages WHERE page_id = $page_id");
	return mysql_fetch_assoc($query);
}


/**
 * Returns a page worth of Pages from the Pages module.
 *
 * @param mixed $num_per_page a number or "all"
 * @param integer $page_num
 * @return array
 */
function pg_get_pages($num_per_page, $page_num = 1)
{
	global $g_table_prefix;

	if ($num_per_page == "all")
	{
		$query = mysql_query("
		  SELECT *
	    FROM   {$g_table_prefix}module_pages
	    ORDER BY heading
	      ");
	}
	else
	{
	  // determine the offset
	  if (empty($page_num)) { $page_num = 1; }
		$first_item = ($page_num - 1) * $num_per_page;

	  $query = mysql_query("
	    SELECT *
	    FROM   {$g_table_prefix}module_pages
	    ORDER BY heading
	    LIMIT $first_item, $num_per_page
		    ") or handle_error(mysql_error());
	}

	$count_query = mysql_query("SELECT count(*) as c FROM {$g_table_prefix}module_pages");
	$count_hash = mysql_fetch_assoc($count_query);
  $num_results = $count_hash["c"];

  $infohash = array();
	while ($field = mysql_fetch_assoc($query))
    $infohash[] = $field;

  $return_hash["results"] = $infohash;
  $return_hash["num_results"] = $num_results;

  return $return_hash;
}


/**
 * Updates a page.
 *
 * @param integer $page_id
 * @param array
 */
function pg_update_page($page_id, $info)
{
	global $g_table_prefix, $LANG;

	$info = ft_sanitize($info);
	$page_name = $info["page_name"];
  $heading   = $info["heading"];
  $content   = $info["page_html"];

	mysql_query("
	  UPDATE {$g_table_prefix}module_pages
	  SET    page_name = '$page_name',
	         heading = '$heading',
	         content = '$content'
	  WHERE  page_id = $page_id
	    ");

	return array(true, $LANG["notify_page_updated"]);
}


/**
 * The installation script for the Pages module. This creates the module_pages
 * database table.
 */
function pages__install($module_id)
{
	global $g_table_prefix, $LANG;

	// our create table query
	$query = "
		CREATE TABLE {$g_table_prefix}module_pages (
	    page_id mediumint(8) unsigned NOT NULL auto_increment,
	    page_name varchar(50) NOT NULL,
	    heading varchar(255) default NULL,
	    content text,
	    PRIMARY KEY  (page_id)
	   ) ENGINE=InnoDB
  ";

	$result = mysql_query($query);

	$message = "";
	if ($result)
		$success = true;
	else
	{
		$success = false;

		// get the error message
		$mysql_error = mysql_error();
		$message =  ft_eval_smarty_string($LANG["pages"]["notify_problem_installing"], array("error" => $mysql_error));
	}

	return array($success, $message);
}


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
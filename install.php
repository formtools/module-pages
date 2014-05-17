<?php


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
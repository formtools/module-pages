<?php

require("../../global/library.php");
ft_init_module_page();

$folder = dirname(__FILE__);
require_once("$folder/library.php");

$request = array_merge($_POST, $_GET);
$page_id = $request["page_id"];
$page_info = pg_get_page($page_id);


// ------------------------------------------------------------------------------------------------

$page_vars = array();
$page_vars["head_title"] = "{$LANG["pages"]["word_page"]} - {$page_info["heading"]}";
$page_vars["page_info"] = $page_info;

ft_display_module_page("templates/view.tpl", $page_vars);
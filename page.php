<?php

require("../../global/session_start.php");
ft_check_permission("user");
ft_include_module("pages");

$request = array_merge($_POST, $_GET);
$page_id = $request["id"];
$page_info = pg_get_page($page_id);

// ------------------------------------------------------------------------------------------------

$page_vars = array();
$page_vars["page"]      = "custom_page";
$page_vars["page_url"]  = ft_get_page_url("custom_page");
$page_vars["head_title"] = "{$LANG["pages"]["word_page"]} - {$page_info["heading"]}";
$page_vars["page_info"] = $page_info;

ft_display_page("../../modules/pages/templates/page.tpl", $page_vars);
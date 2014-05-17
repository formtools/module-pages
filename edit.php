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
$page_vars["head_title"] = $L["phrase_edit_page"];
$page_vars["page_id"] = $page_id;
$page_vars["page_info"] = $page_info;
$page_vars["head_string"] = "
	<script type=\"text/javascript\" src=\"$g_root_url/global/tiny_mce/tiny_mce.js\"></script>
	<script type=\"text/javascript\" src=\"$g_root_url/global/scripts/wysiwyg_settings.js\"></script>
";

$content_css = "$g_root_url/global/css/tinymce.css";

$page_vars["head_js"] = "
// load up any WYWISYG editors in the page
editors[\"advanced\"].elements = \"page_html\";
editors[\"advanced\"].theme_advanced_toolbar_location = \"top\";
editors[\"advanced\"].theme_advanced_toolbar_align = \"left\";
editors[\"advanced\"].theme_advanced_path_location = \"bottom\";
editors[\"advanced\"].theme_advanced_resizing = true;
editors[\"advanced\"].content_css = \"$content_css\";
tinyMCE.init(editors[\"advanced\"]);
	";

ft_display_module_page("templates/edit.tpl", $page_vars);
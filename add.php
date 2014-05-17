<?php

require("../../global/library.php");
ft_init_module_page();

$page_vars = array();
$page_vars["head_title"] = $L["phrase_add_page"];
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


ft_display_module_page("templates/add.tpl", $page_vars);
<?php

require("../../global/library.php");
ft_init_module_page();

$page_vars = array();
$page_vars["head_title"] = $L["phrase_add_page"];
$page_vars["head_string"] =<<< EOF
  <script type="text/javascript" src="$g_root_url/global/tiny_mce/tiny_mce.js"></script>
  <script type="text/javascript" src="$g_root_url/global/scripts/wysiwyg_settings.js"></script>
  <script type="text/javascript" src="$g_root_url/global/codemirror/js/codemirror.js"></script>
  <script type="text/javascript" src="scripts/pages.js"></script>
EOF;

$page_vars["head_js"] =<<< EOF
// load up any WYWISYG editors in the page
editors["advanced"].elements = "wysiwyg_content";
editors["advanced"].theme_advanced_toolbar_location = "top";
editors["advanced"].theme_advanced_toolbar_align = "left";
editors["advanced"].theme_advanced_path_location = "bottom";
editors["advanced"].theme_advanced_resizing = true;
editors["advanced"].content_css = "$g_root_url/global/css/tinymce.css";
tinyMCE.init(editors["advanced"]);

if (typeof pages_ns == undefined)
  var pages_ns = {};

pages_ns.current_editor = "tinymce";

var rules = [];

rsv.onCompleteHandler = function()
{
  $("use_wysiwyg_hidden").value = ($("uwe").checked) ? "yes" : "no";
  ft.select_all(document.pages_form["selected_client_ids[]"]);
 
	return true;
}
EOF;

ft_display_module_page("templates/add.tpl", $page_vars);
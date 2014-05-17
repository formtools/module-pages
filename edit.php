<?php

require("../../global/library.php");
ft_init_module_page();
$folder = dirname(__FILE__);
require_once("$folder/library.php");

$request = array_merge($_POST, $_GET);
$page_id = isset($request["page_id"]) ? $request["page_id"] : "";

if (isset($_POST["add_page"]))
  list($g_success, $g_message, $page_id) = pg_add_page($_POST);

if (empty($page_id))
{
  header("location: index.php");
	exit;
}

if (isset($_POST["update_page"]))
  list($g_success, $g_message) = pg_update_page($_POST["page_id"], $_POST);

$page_info = pg_get_page($page_id);


// this stores the default editor in the page. The values are either "codemirror", "tinymce": all
// code editing is done through one of those editors
$editor = ($page_info["content_type"] == "html" && $page_info["use_wysiwyg"] == "yes") ? "tinymce" : "codemirror";

// ------------------------------------------------------------------------------------------------

$page_vars = array();
$page_vars["head_title"] = $L["phrase_edit_page"];
$page_vars["page_id"] = $page_id;
$page_vars["page_info"] = $page_info;
$page_vars["head_string"] =<<<EOF
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

pages_ns.current_editor = "$editor";

var rules = [];

rsv.onCompleteHandler = function()
{
  $("use_wysiwyg_hidden").value = ($("uwe").checked) ? "yes" : "no";
  ft.select_all(document.pages_form["selected_client_ids[]"]);
 
	return true;
}
EOF;

ft_display_module_page("templates/edit.tpl", $page_vars);
/**
 * Contains all the relevant JS for 
 */
var pages_ns = {};
pages_ns.current_editor = null; // this is overwritten by the page onload. Values: "codemirror", "tinymce"

pages_ns.toggle_access_type = function(form_type)
{
  switch (form_type)
  {
    case "admin":
      $("custom_clients").hide();
      break;
    case "public":
      $("custom_clients").hide();
      break;
    case "private":
      $("custom_clients").show();
      break;
  }
}

pages_ns.toggle_wysiwyg_field = function(is_checked)
{
  if (is_checked)
    pages_ns.enable_editor("tinymce");
  else
    pages_ns.enable_editor("codemirror");
}

/**
 * Whenever the user changes the content type (HTML, PHP or Smarty), the appropriate editor - Code Mirror
 * or TinyMCE needs to be shown & the content copied over. Also, the "Use WYSIWYG Editor" button may
 * or may not be relevant.
 */
pages_ns.change_content_type = function(content_type)
{
  var is_html = (content_type == "html") ? true : false;

  // the "Use WYSIWYG editor" checkbox is only enabled if the user is entering HTML
  $("uwe").disabled = !is_html;
  
  // if the user just switched to HTML and the "Use WYWIWYG" editor is checked, display tinyMCE
  if (is_html && $("uwe").checked && pages_ns.current_editor != "tinymce")
    pages_ns.enable_editor("tinymce");

  if (!is_html && pages_ns.current_editor != "codemirror")
    pages_ns.enable_editor("codemirror");  
}

/**
 * This function handles toggling between editors. Basically it checks that the latest content
 * is always inserted into the appropriate editor.
 *
 * @param string editor "tinymce" or "codemirror"
 */
pages_ns.enable_editor = function(editor)
{
  if (editor == "tinymce")
  {
    $("wysiwyg_div").show();
    $("codemirror_div").hide();    

	  // update the WYSIWYG content
    tinyMCE.setContent(html_editor.getCode());
  }
  else
  {
	  // update the CodeMirror content
	  html_editor.setCode(tinyMCE.getContent("wysiwyg_content"));

    $("wysiwyg_div").hide();
    $("codemirror_div").show();
  }
  
  pages_ns.current_editor = editor;
}
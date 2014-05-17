{include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0">
  <tr>
    <td width="45"><a href="index.php"><img src="images/icon_pages.gif" border="0" width="34" height="34" /></a></td>
    <td class="title">{$L.phrase_add_page|upper}</td>
  </tr>
  </table>

  {include file='messages.tpl'}

  <form action="index.php" method="post">

	  <table cellspacing="1" cellpadding="1" border="0">
	  <tr>
	    <td width="100">{$L.phrase_page_name}</td>
	    <td>
	      <input type="text" name="page_name" value="" style="width:100px" maxlength="50" />
	      <span class="light_grey">{$L.text_page_name_desc}</span>
	    </td>
	  </tr>
	  <tr>
	    <td width="100">{$L.phrase_page_heading}</td>
	    <td><input type="text" name="heading" style="width:550px" /></td>
	  </tr>
	  <tr>
	    <td valign="top">{$L.phrase_page_content}</td>
	    <td>
	      <textarea name="page_html" id="page_html" style="width:550px; height:200px"></textarea>
	    </td>
	  </tr>
	  </table>

	  <p>
	    <input type="submit" name="add_page" value="{$L.phrase_add_page}" />
	  </p>

  </form>
{include file='modules_footer.tpl'}
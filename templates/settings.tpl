{include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0">
  <tr>
    <td width="45"><a href="index.php"><img src="images/icon_pages.gif" border="0" width="34" height="34" /></a></td>
    <td class="title"><a href="index.php">{$L.module_name|upper}</a> &raquo; {$LANG.word_settings|upper}</td>
  </tr>
  </table>

	{include file='messages.tpl'}

	<form action="{$same_page}" method="post">

	  <div>
	    Num Pages listed per page: <input type="text" size="5" name="num_pages_per_page" value="{$num_pages_per_page}" />
	  </div>

		<p>
		  <input type="submit" name="update" value="{$LANG.word_update|upper}" />
		</p>

	</form>
	
{include file='modules_footer.tpl'}
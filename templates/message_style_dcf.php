<?php
$body = <<<END
   <table class="$border_class" cellspacing="0" cellpadding="0" 
   width="$table_width"><tr><td><table border="0" width="100%"
   cellspacing="1" cellpadding="3"><tr><td class="dcdark" colspan="2">
   <table border="0" cellspacing="0" cellpadding="3" 
   width="100%"><tr><td class="dcdark" width="100%">
   <a name="$row[id]"></a>$author</td><td 
   class="dcdark" align="right" nowrap>$mesg_date</td></tr>
   <tr><td class="dcdark" width="100%">
   $member_since
   $member_stat
   </td><td class="dcdark"
   align="right">$mesg_icon</td></tr></table></td></tr>
   <tr><td class="dclite" colspan="2">
   $mesg_id "$subject"<br />
   $in_response_to
   $last_updated_notice
   <br />
   <table border="0" cellspacing="0" cellpadding="5" 
   width="100%"><tr><td class="dclite" nowrap>$avatar
   <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <td class="dclite" width="100%">
   $message
   <p>&nbsp;&nbsp;</p>
   </td>
   </tr></table>
   <table border="0" cellspacing="0" cellpadding="0" 
   width="100%"><tr><td class="dcmenu" width="100%">$left_links</td>
   <td class="dcmenu" align="right" nowrap>$right_links</td>
   </tr></table></td></tr></table></td></tr></table>
END;
?>

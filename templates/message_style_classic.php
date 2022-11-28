<?php
$body = <<< END
   <table class="$border_class" cellspacing="0" cellpadding="0" 
   width="$table_width"><tr><td>
   <table border="0" width="100%"
   cellspacing="1" cellpadding="5"><tr><td class="dcdark" align="right" nowrap>
   <span class="dcinfo">$mesg_id</span></td><td class="dcdark">
   "$subject"</td></tr><tr>
   <td class="dcdark" align="right" width="140" nowrap>
   <a name="$row[id]"></a><span class="dcinfo">Author</span></td><td class="dcdark" width="100%">
   $author&nbsp;&nbsp;&nbsp;&nbsp; $mesg_icon</td></tr>
   <tr><td class="dcdark" align="right" nowrap>
   <span class="dcinfo">Author Info</span></td><td class="dcdark">
   $member_since
   $member_stat</td></tr><tr>
   <td class="dcdark" align="right">
   <span class="dcinfo">Date</span></td><td class="dcdark">
   $mesg_date</td></tr><tr><td class="dcdark" align="right">
   <span class="dcinfo">Message</span><br />&nbsp;&nbsp;<br />
   $avatar<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="dclite"><p>
   $in_response_to
   $last_updated_notice</p>
   $message
   <p>&nbsp;&nbsp;</p>
   <table border="0" cellspacing="0" cellpadding="0" 
   width="100%"><tr><td class="dcmenu" width="100%">$left_links</td>
   <td class="dcmenu" align="right" nowrap>$right_links</td>
   </tr></table></td></tr></table></td></tr></table>
END;
?>

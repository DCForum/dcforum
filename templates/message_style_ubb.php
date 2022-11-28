<?php
$body = <<< END
         <table class="$border_class" cellspacing="0" cellpadding="0" 
         width="$table_width"><tr><td>
         <table border="0" width="100%"
         cellspacing="1" cellpadding="5"><tr><td class="dcdark" 
         rowspan="3" width="150" nowrap>
         <a name="$row[id]"></a>
         $avatar
         $author<br />
         $spacer<br />
         $mesg_icon <br />
         <p class="dccaption">$member_since
         $member_stat</p>
         </td><td class="dcdark" width="100%">
         $mesg_id $subject<br />
         $mesg_date</tr>
         <tr><td class="dclite">
         <p>
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

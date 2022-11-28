<?php
///////////////////////////////////////////////////////////////////////
//
// view_attachment.php
//
// DCForum+ Version 1.27
// September 30, 2009
//
//
//    This file is part of DCForum+
//
//    DCForum+ is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    DCForum+ is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with DCForum+; if not, write to the Free Software
//    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
//
//
// 	$Id: view_attachment.php,v 1.1 2003/04/14 09:33:18 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

function view_attachment() {

   // global variables
   global $in;

   // Check input parameter
   if (! is_alphanumeric($in['file_id'])) {
      output_error_mesg("Invalid Input Parameter");
      return;
   }

   // get attachment info
   $row = get_attachment($in['file_id']);

   $file = $row['id'] . "." . $row['file_type'];
   
   if ($row['id'] and file_exists(USER_DIR . "/" . $file)) {
      // Refersh page
      $refresh_url = USER_URL . "/" . $file;
      print_no_cache_header();
      print_refresh_page($refresh_url,0);
   }
   else {
      output_error_mesg("Missing Attachment");
   }

}

/////////////////////////////////////////////////////////////////////////
//
// function get_attachment
//
/////////////////////////////////////////////////////////////////////////
function get_attachment($file_id) {

   $q = "SELECT *
           FROM " . DB_UPLOAD . "
          WHERE id = '$file_id' ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   return $row;

}
?>

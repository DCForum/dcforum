<?php
///////////////////////////////////////////////////////////////
//
// forum_manager_reconcile.php
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
// 	$Id: forum_manager_reconcile.php,v 1.1 2003/04/14 08:50:40 david Exp $	
//
///////////////////////////////////////////////////////////////

function forum_manager_reconcile() {

   global $in;

   include (INCLUDE_DIR . "/form_info.php");

   // Reconcile topics and messages
   $q = "SELECT id 
           FROM " . DB_FORUM . "
          WHERE type < 99 ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      reconcile_forum($row['id']);
   }
   db_free($result);


   print "Done";


}


?>

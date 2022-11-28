<?php
//////////////////////////////////////////////////////////
//
// forum_stat.php
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
//
//
//////////////////////////////////////////////////////////
function forum_stat() {

   // global variables
   global $in;

   include('forum_stat_lib.php');

   print_head("Administration program - forum usage statistics");

   include_top();

   switch ($in['saz']) {

      case 'access';
         include('forum_stat_access.php');
         forum_stat_access();
         break;

      case 'user';
         include('forum_stat_user.php');
         forum_stat_user();
         break;
 
      default:
         // do nothing
         break;

   }

   include_bottom();

   print_tail();

}

?>

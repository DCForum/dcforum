<?php
///////////////////////////////////////////////////////////////
//
// general.php
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
// 	$Id: general.php,v 1.1 2003/04/14 08:50:54 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function general() {

   // global variables
   global $in;

   print_head("Administration program - General function manager");

   include_top();

   switch ($in['saz']) {

      case 'start_forum':
         include('general_start_forum.php');
         general_start_forum();
         break;

      case 'shutdown_forum':
         include('general_shutdown_forum.php');
         general_shutdown_forum();
         break;

      case 'send_email':
         include('general_send_email.php');
         general_send_email();
         break;

      case 'manage_user_files':
         include('general_manage_user_files.php');
         general_manage_user_files();
         break;

      case 'update_setup_table':
         include('general_update_setup_table.php');
         general_update_setup_table();
         break;

      case 'manage_blocked_ips':
         include('general_manage_blocked_ips.php');
         general_manage_blocked_ips();
         break;

      default:
         // do nothing
         break;

   }

   include_bottom();

}

?>

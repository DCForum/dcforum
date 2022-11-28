<?php
/////////////////////////////////////////////////////////////////////////
//
// upgrade_manager.php
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
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
// 	$Id: upgrade_manager.php,v 1.4 2005/08/09 23:01:55 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function upgrade_manager() {

   // global variables
   global $in;

   // Auto mode
   if ($in['saz'] != 'import_forum_mesg') {
      print_head('Administration Utility - upgrade manager');
      include_top();
      include("menu.php");
   }
 
   switch ($in['saz']) {

      case 'import_forum_info';
         include('upgrade_manager_import_forum_info.php');
         upgrade_manager_import_forum_info();
         break;

      case 'import_forum_mesg';
         include('upgrade_manager_import_forum_mesg.php');
         upgrade_manager_import_forum_mesg();
         break;


      case 'import_forum_log';
         include('upgrade_manager_import_forum_log.php');
         upgrade_manager_import_forum_log();
         break;

      case 'import_user';
         include('upgrade_manager_import_user.php');
         upgrade_manager_import_user();
         break;

      case 'import_misc_user_info';
         include('upgrade_manager_import_misc_user_info.php');
         upgrade_manager_import_misc_user_info();
         break;

      case 'import_misc_user_inbox';
         include('upgrade_manager_import_misc_user_inbox.php');
         upgrade_manager_import_misc_user_inbox();
         break;      case 'import_misc_user_info';
         include('upgrade_manager_import_misc_user_info.php');
         upgrade_manager_import_misc_user_info();
         break;

      case 'import_misc_user_inbox';
         include('upgrade_manager_import_misc_user_inbox.php');
         upgrade_manager_import_misc_user_inbox();
         break;


      case 'update_from_beta';
         include('upgrade_manager_update_from_beta.php');
         upgrade_manager_update_from_beta();
         break;

      case 'update_from_1000_1001';
         include('upgrade_manager_update_from_1000_1001.php');
         upgrade_manager_update_from_1000_1001();
         break;

      case 'update_from_100x_11';
         include('upgrade_manager_update_from_100x_11.php');
         upgrade_manager_update_from_100x_11();
         break;

      case 'update_from_11_12';
         include('upgrade_manager_update_from_11_12.php');
         upgrade_manager_update_from_11_12();
         break;

      case 'update_from_12_122';
         include('upgrade_manager_update_from_12_122.php');
         upgrade_manager_update_from_12_122();
         break;

      case 'update_from_123_124';
         include('upgrade_manager_update_from_123_124.php');
         upgrade_manager_update_from_123_124();
         break;

	 //      case 'update_from_125_126';
         //include('upgrade_manager_update_from_125_126.php');
         //upgrade_manager_update_from_125_126();
         //break;

      default:
        // do nothing
        break;

   }

   include_bottom();

}

?>

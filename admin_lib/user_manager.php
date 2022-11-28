<?php
//////////////////////////////////////////////////////////
//
// user_manager.php
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
//////////////////////////////////////////////////////////////////////////
function user_manager() {

   // global variables
   global $in;

   print_head("Administration program - user manager");

   include_top();

   switch ($in['saz']) {

      case 'create':
         include('user_manager_create.php');
         user_manager_create();
         break;

      case 'modify':
         include('user_manager_modify.php');
         user_manager_modify();
         break;

      case 'activate':
         include('user_manager_activate.php');
         user_manager_activate();
         break;

      case 'deactivate':
         include('user_manager_deactivate.php');
         user_manager_deactivate();
         break;

      case 'inactive':
         include('user_manager_inactive.php');
         user_manager_inactive();
         break;

 
      case 'remove':
         include('user_manager_remove.php');
         user_manager_remove();
         break;

      case 'remove_deactivated_accounts':
         include('user_manager_remove_deactivated_accounts.php');
         user_manager_remove_deactivated_accounts();
         break;


      default:
         // do nothing
         break;

   }

   /*
      case 'import';
         include('user_manager_import.php');
         user_manager_import();
         break;

   */


   include_bottom();

   print_tail();

}

?>

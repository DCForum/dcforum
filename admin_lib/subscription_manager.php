<?php
//////////////////////////////////////////////////////////
//
// subscription_manager.php
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
//////////////////////////////////////////////////////////////////////////
function subscription_manager() {

   // global variables
   global $in;

   print_head("Administration program - Subscription Manager");

   include_top();

   switch ($in['saz']) {

      case 'send';
         include('subscription_manager_send.php');
         subscription_manager_send();
         break;

      case 'forum';
         include('subscription_manager_forum.php');
         subscription_manager_forum();
         break;

      case 'user';
         include('subscription_manager_user.php');
         subscription_manager_user();
         break;

      case 'view';
         include('subscription_manager_view.php');
         subscription_manager_view();
         break;


      default:
         // do nothing
         break;

   }

   include_bottom();

   print_tail();

}

?>

<?php
//////////////////////////////////////////////////////////
//
// forum_manager.php
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
// 	$Id: forum_manager.php,v 1.1 2003/04/14 08:50:33 david Exp $	
//
//////////////////////////////////////////////////////////
function forum_manager() {

   // global variables
   global $in;

   print_head("Administration program - forum manager");

   include_once(ADMIN_LIB_DIR . "/forum_manager_lib.php");

   include_top();

   switch ($in['saz']) {

         case 'create';
            include('forum_manager_create.php');
            forum_manager_create();
            break;

         case 'modify';
            include('forum_manager_modify.php');
            forum_manager_modify();
            break;

         case 'remove';
            include('forum_manager_remove.php');
            forum_manager_remove();
            break;

         case 'reorder';
            include('forum_manager_reorder.php');
            forum_manager_reorder();
            break;

         case 'reconcile';

            include('forum_manager_reconcile.php');
            forum_manager_reconcile();
            break;

         default:
           // do nothing
           break;

   }

   include_bottom();
   print_tail();

}

?>

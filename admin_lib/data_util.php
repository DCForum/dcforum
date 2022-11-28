<?php
//////////////////////////////////////////////////////////
//
// data_util.php
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
// 	$Id: data_util.php,v 1.1 2003/04/14 08:50:20 david Exp $	
//
//////////////////////////////////////////////////////////
function data_util() {

   // global variables
   global $in;

   print_head("Administration program - forum");

   include_top();

   switch ($in['saz']) {

      case 'list';
         include('data_util_list.php');
         data_util_list();
         break;

      case 'optimize';
         include('data_util_optimize.php');
         data_util_optimize();
         break;

      case 'backup';
         include('data_util_backup.php');
         data_util_backup();
         break;

      case 'tar';
         include('data_util_tar.php');
         data_util_tar();
         break;

      case 'recover_tar':
         include('data_util_recover_tar.php');
         data_util_recover_tar();
         break;

      case 'recover':
         include('data_util_recover.php');
         data_util_recover();
         break;

 
      default:
         // do nothing
         break;

   }

   include_bottom();

   print_tail();

}

?>

<?php
///////////////////////////////////////////////////////////////
//
// data_util_optimize.php
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
// 	$Id: data_util_optimize.php,v 1.1 2003/04/14 08:50:25 david Exp $	
//
///////////////////////////////////////////////////////////////

function data_util_optimize()
{

    // global variables
    global $in;

    include_once(ADMIN_LIB_DIR . '/menu.php');

    $sub_cat = $cat[$in['az']]['sub_cat'];
    $title = $sub_cat[$in['saz']]['title'];
    $desc = $sub_cat[$in['saz']]['desc'];

    begin_table([
        'border'      => '0',
        'cellspacing' => '1',
        'cellpadding' => '5',
        'class'       => '',
    ]);

    // Title component
    print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

    print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

    $database = DB_NAME;

    $q = "show table status";
    $result = db_query($q);

    while ($row = db_fetch_array($result)) {
        $table_name = $row['Name'];
        $qq = "OPTIMIZE TABLE " . $table_name;
        db_query($qq);
        print "<li> optimized $table_name </li>\n";
    }
    db_free($result);


    print "</td></tr>";
    end_table();

}

?>

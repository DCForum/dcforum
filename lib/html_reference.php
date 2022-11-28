<?php
////////////////////////////////////////////////////////////////////////
//
// html_reference.php
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
         'cellpadding' => '5',
         'class'=>'') );

  foreach($in['lang']['html_ref'] as $key => $this_array) {

     // $key is table heading
      print "<tr class=\"dcheading\"><td 
         class=\"dcheading\" colspan=\"2\">$key</td></tr>";
     foreach($this_array as $this_key => $this_val) {
         print "<tr class=\"dcdark\"><td 
            class=\"dcdark\">$this_key</td><td 
            class=\"dclite\">$this_val</td>
            </tr>";

      }
   
   }

   end_table();

   print_tail();

}

?>
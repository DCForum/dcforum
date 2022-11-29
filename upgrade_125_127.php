<?php
////////////////////////////////////////////////////////
//
// upgrade_125_127.php
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
include("dcsetup.php");

// include various library files
// These library files do not require language
// module
include(INCLUDE_DIR . "/dclib.php");
include(INCLUDE_DIR . "/dcinit.php");
include(INCLUDE_DIR . "/dchtmllib.php");
include(INCLUDE_DIR . "/dcfilterlib.php");
include(INCLUDE_DIR . "/mysqldb.php");

// Connect to database
$dbh = db_connect() or my_die("Couldn't connect to the database.  Please make sure
      all the information in dcsetup.php is correct.");

// include various library files
// These library files require language
// module.  So, they must be called after
// initialize function, which declears user's
// language preference
include(INCLUDE_DIR . "/dcmesg.php");
include(INCLUDE_DIR . "/dcflib.php");
include(INCLUDE_DIR . "/dcmenulib.php");
include(INCLUDE_DIR . "/dcdatelib.php");


   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // Title component
   print "<tr class=\"dcheading\"><td><span class=\"dcstrong\">$title</span>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td><p class=\"dcmessage\">\n";

   print "Adding default upload file to the setup table...";
   $q = "INSERT INTO " . DB_SETUP . "
                 VALUES(null,'file_upload_default','txt','user_option') ";

   db_query($q);
   print "...done.<br />";

   print "Adding user preference for daylight savings time to user db...";
   $q = "ALTER TABLE " . DB_USER . " ADD COLUMN utt ENUM('yes','no') NULL DEFAULT 'no' AFTER ut ";

   db_query($q);
   print "...done.<br />";

   print "Adding user preference for daylight savings time to session db...";
   $q = "ALTER TABLE " . DB_SESSION . " ADD COLUMN utt ENUM('yes','no') NULL DEFAULT 'no' AFTER ut ";

   db_query($q);
   print "...done.<br />";



   print "<p>DONE...</p></td></tr>";

 
// Close database
   db_close($dbh);
   end_table();



?>

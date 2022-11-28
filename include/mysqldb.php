<?php
//////////////////////////////////////////////////////////
//
// mysqldb.php
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
// wrapper for mysql db API's
//
// 	$Id: mysqldb.php,v 1.3 2005/03/14 02:31:41 david Exp david $	
//
//////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////
//
// function db_connect
//
//////////////////////////////////////////////////////////
function db_connect () {
   $dbh = @mysql_connect(DB_HOST,
                     DB_USERNAME,
                     DB_PASSWORD);
   if ($dbh && mysql_select_db(DB_NAME)) {
      return ($dbh);
   }
   else {
      return (FALSE);
   }
}

//////////////////////////////////////////////////////////
//
// function db_free
//
//////////////////////////////////////////////////////////
function db_free ($result) {
      mysql_free_result($result);
      return;
}

//////////////////////////////////////////////////////////
//
// function db_close
//
//////////////////////////////////////////////////////////
function db_close($dbh) {
   mysql_close($dbh);
   return;
}

//////////////////////////////////////////////////////////
//
// function db_query
//
//////////////////////////////////////////////////////////
function db_query($sql) {

  global $in;
   $result = mysql_query($sql) 
      or my_die("Query error - Please notify administrator of this site");

   $in['num_q']++;
   return $result;
}

//////////////////////////////////////////////////////////
//
// function db_fetch_array
//
//////////////////////////////////////////////////////////
function db_fetch_array($result) {
   $row = mysql_fetch_array($result);
   return $row;
}

//////////////////////////////////////////////////////////
//
// function db_fetch_row
//
//////////////////////////////////////////////////////////
function db_fetch_row($result) {
   $row = mysql_fetch_row($result);
   return $row;
}

//////////////////////////////////////////////////////////
//
// function db_num_rows
//
//////////////////////////////////////////////////////////
function db_num_rows($result) {
   return mysql_num_rows($result);
}

//////////////////////////////////////////////////////////
//
// function db_escape_string
//
//////////////////////////////////////////////////////////
function db_escape_string ($str) {
   return mysql_escape_string($str);
}

//////////////////////////////////////////////////////////
//
// function db_data_seek
//
//////////////////////////////////////////////////////////
function db_data_seek($result, $row) {
   mysql_data_seek($result,$row);
   return $result;
}

//////////////////////////////////////////////////////////
//
// function db_insert_id
//
//////////////////////////////////////////////////////////
function db_insert_id() {
   return mysql_insert_id();
}

//////////////////////////////////////////////////////////
//
// function db_affected_rows
//
//////////////////////////////////////////////////////////
function db_affected_rows() {
   return mysql_affected_rows();
}

?>

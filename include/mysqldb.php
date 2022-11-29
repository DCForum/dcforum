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
function db_connect()
{
    global $__dbh;
    $__dbh = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    return $__dbh ?: false;
}

//////////////////////////////////////////////////////////
//
// function db_free
//
//////////////////////////////////////////////////////////
function db_free($result)
{
    mysqli_free_result($result);
}

//////////////////////////////////////////////////////////
//
// function db_close
//
//////////////////////////////////////////////////////////
function db_close($dbh)
{
    mysqli_close($dbh);
}

//////////////////////////////////////////////////////////
//
// function db_query
//
//////////////////////////////////////////////////////////
function db_query($sql)
{

    global $in;
    global $__dbh;
    $result = mysqli_query($__dbh, $sql)
    or my_die("Query error - Please notify administrator of this site");

    $in['num_q']++;
    return $result;
}

//////////////////////////////////////////////////////////
//
// function db_fetch_array
//
//////////////////////////////////////////////////////////
function db_fetch_array($result)
{
    return mysqli_fetch_array($result);
}

//////////////////////////////////////////////////////////
//
// function db_fetch_row
//
//////////////////////////////////////////////////////////
function db_fetch_row($result)
{
    return mysqli_fetch_row($result);
}

//////////////////////////////////////////////////////////
//
// function db_num_rows
//
//////////////////////////////////////////////////////////
function db_num_rows($result)
{
    return mysqli_num_rows($result);
}

//////////////////////////////////////////////////////////
//
// function db_escape_string
//
//////////////////////////////////////////////////////////
function db_escape_string($str)
{
    global $__dbh;
    return mysqli_escape_string($__dbh, $str);
}

//////////////////////////////////////////////////////////
//
// function db_data_seek
//
//////////////////////////////////////////////////////////
function db_data_seek($result, $row)
{
    mysqli_data_seek($result, $row);
    return $result;
}

//////////////////////////////////////////////////////////
//
// function db_insert_id
//
//////////////////////////////////////////////////////////
function db_insert_id()
{
    global $__dbh;
    return mysqli_insert_id($__dbh);
}

//////////////////////////////////////////////////////////
//
// function db_affected_rows
//
//////////////////////////////////////////////////////////
function db_affected_rows()
{
    global $__dbh;
    return mysqli_affected_rows($__dbh);
}

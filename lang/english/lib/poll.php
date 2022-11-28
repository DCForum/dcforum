<?php
///////////////////////////////////////////////////////////////
//
// poll.php
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
// 	$Id: poll.php,v 1.1 2003/04/14 08:56:38 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function poll

$in['lang']['e_guest'] = "You must be a registered user to start poll.";

$in['lang']['e_subject_blank'] = "Question field must not be blank";
$in['lang']['e_name_blank'] = "Name must not be left blank.  Please submit your name";

$in['lang']['e_name_invalid'] = "Your name contains non-word characters";
$in['lang']['e_name_long'] = "The name field is too long.  The maximum number of
                              characters allowed is";

$in['lang']['e_name_dup'] = "Your name you submitted is a 
            registered user...please use another name";

$in['lang']['page_title'] = "Create a survey";

$in['lang']['e_header'] = "Posting error";

?>
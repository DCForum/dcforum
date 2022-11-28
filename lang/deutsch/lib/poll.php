<?php
///////////////////////////////////////////////////////////////
//
// poll.php
//
// DCForum+ Version 1.2
// April 4, 2003
// Copyright 1997-2003 DCScripts
// A division of DC Business Solutions
// All Rights Reserved
//
//
// As part of the installation process, you will be asked
// to accept the terms of Agreement outlined in the readme.html
// included with this distribution. This Agreement is
// a legal contract, which specifies the terms of the license
// and warranty limitation between you and DCScripts.
// You should carefully read this terms agreement before
// installing or using this software.  Unless you have a different license
// agreement obtained from DCScripts, installation or use of this software
// indicates your acceptance of the license and warranty limitation terms
// contained in this Agreement. If you do not agree to the terms of this
// Agreement, promptly delete and destroy all copies of this software
//
//
//
// 	$Id: poll.php,v 1.1 2003/03/27 07:54:06 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function poll

$in['lang']['e_guest'] = "Du musst ein registrierter User sein, um ein Abstimmung zu beginnen.";

$in['lang']['e_subject_blank'] = "Das Abstimmungsthema darf nicht leer sein";
$in['lang']['e_name_blank'] = "Der Name darf nicht leer sein. Bitte trag deinen Namen ein";

$in['lang']['e_name_invalid'] = "Dein Name enthält unzulässuge Zeichen";
$in['lang']['e_name_long'] = "Das Namensfeld ist zu lang. Das erlaubte Maximum an Zeichen ist";

$in['lang']['e_name_dup'] = "Der von dir eingegebene Name wird von einem registrierten User benutzt ... bitte gib einen anderen Namen an";

$in['lang']['page_title'] = "Abstimmung erstellen";

$in['lang']['e_header'] = "Fehler beim Eintragen";

?>
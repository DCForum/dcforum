<?php
///////////////////////////////////////////////////////////////
//
// poll.php
//
// DCForum+ Version 1.21
// April 14, 2003
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
// 	$Id: poll.php,v 1.1 2003/04/14 08:56:38 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function poll

$in['lang']['e_guest'] = "Vous devez être membre pour d&eacute;marrer un sondage"; //You must be a registered user to start poll.

$in['lang']['e_subject_blank'] = "Le champ question ne peut pas être vide"; //Question field must not be blank
$in['lang']['e_name_blank'] = "Le champ nom ne peut pas être vide. Veuillez inscrire votre nom"; //Name must not be left blank.  Please submit your name

$in['lang']['e_name_invalid'] = "Votre nom contient des caract&egrave;res invalides"; //Your name contains non-word characters
$in['lang']['e_name_long'] = "Le champ nom est trop long. Le maximum de caract&egrave;res permis est ";
//The name field is too long.  The maximum number of characters allowed is

$in['lang']['e_name_dup'] = "Votre nom est celui d'un membre... veuillez utiliser un autre nom";
//Your name you submitted is a registered user...please use another name

$in['lang']['page_title'] = "Cr&eacute;er un sondage"; //Create a survey

$in['lang']['e_header'] = "Erreur &agrave; l'envoi"; //Posting error

?>

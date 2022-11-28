<?php
///////////////////////////////////////////////////////////////
//
// post.php
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
// 	$Id: post.php,v 1.1 2003/04/14 08:56:41 david Exp $	
//


// main function post
$in['lang']['e_subject_blank'] = "Les champ sujet et message ne peuvent pas être vides"; //Subject and message fields must not be blank
$in['lang']['e_name_blank'] = "Le champ nom ne peut pas être vide. Veuillez entrer votre nom"; //Name must not be left blank.  Please submit your name

$in['lang']['e_name_invalid'] = "Votre nom contient des caract&egrave;res invalides"; //Your name contains non-word characters
$in['lang']['e_name_long'] = "Le champ nom est trop long. Le maximum de caract&egrave;res permis est ";
//The name field is too long.  The maximum number of characters allowed is

$in['lang']['e_name_dup'] = "Ce nom de membre existe d&eacute;j&agrave; sur ce forum... Veuillez choisir un autre nom";
//Your name you submitted is a  registered user...please use another name

$in['lang']['page_title'] = "Poster un messager"; //Post a message

$in['lang']['e_header'] = "Erreur en postant"; //Posting error


// function notify_admin

$in['lang']['email_subject'] = "Arriv&eacute;e d'un nouveau message"; //New message notification
$in['lang']['email_message'] = "Un nouveau message a &eacute;t&eacute; post&eacute; dans votre forum.\nIl a &eacute;t&eacute; post&eacute; par ";
//A new message has been posted in your forum.\nFollowing message was posted by

// function show_queue_message

$in['lang']['q_header'] = "Message post&eacute;"; //Post message notice

$in['lang']['q_message'] = "<p>Merci d'utiliser notre forum.</p>
            <p>Le message que vous avez post&eacute; a &eacute;t&eacute; transmis au mod&eacute;rateur pour &eacute;valuation</p>";
//<p>Thank you for using our forum.</p>
//<p>The message you posted has been submitted for review by the forum moderator.</p>

$in['lang']['q_option'] = "<p>Choisir une option suivante</p>"; //<p>Select from following options</p>
$in['lang']['q_option_1'] = "Aller &agrave; la liste des forums"; //Goto forum listings
$in['lang']['q_option_2'] = "Aller &agrave; la liste des discussions"; //Goto topic listings

?>

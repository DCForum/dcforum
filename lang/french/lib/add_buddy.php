<?php
///////////////////////////////////////////////////////////
//
// add_buddy.php
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
// 	$Id: add_buddy.php,v 1.1 2003/04/14 08:56:17 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// function add_buddy

$in['lang']['page_title'] = "Ajouter un membre &agrave; votre liste de copains"; //Adding a user to your buddy list

$in['lang']['e_header'] = "Erreur dans la liste de copains"; //Adding buddy error

$in['lang']['e_already'] = "Vous ne pouvez ajouter ce membre car il est d&eacute;j&agrave; dans votre liste.";
//You cannot add this user to your buddy list
//because this user is already in your list.

$in['lang']['e_self'] = "Vous ne pouvez vous ajouter vous-même &agrave; votre liste"; //You cannot add yourself to your buddy list.

$in['lang']['e_no_such_user'] = "Votre requête ne peut être ex&eacute;cut&eacute;e car ce membre n'existe pas";
//Your request could not be completed because
//there is no such user in our database.

$in['lang']['page_header'] = "Mise &agrave; jour de la liste des copains"; //Buddy list updated
$in['lang']['ok_mesg'] = "Ce membre a &eacute;t&eacute; ajout&eacute; &agrave; votre liste de copains"; //The user has been added to your buddy list.
$in['lang']['select_option'] = "Choisir une option suivante"; //Select from following options
$in['lang']['option_1'] = "Aller &agrave; la liste des forums"; //Goto forum listings
$in['lang']['option_2'] = "Retour &agrave; la page pr&eacute;c&eacute;dente"; //Go back to previous page
$in['lang']['option_3'] = "G&eacute;rer la liste des copains"; //Manager your buddy list





?>

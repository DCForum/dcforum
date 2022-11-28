<?php
//////////////////////////////////////////////////////////////////
//
// register.php
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
// 	$Id: register.php,v 1.1 2003/04/14 08:56:54 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Page d'inscription du membre"; //User registration page
$in['lang']['page_header'] = "Formulaire d'inscription"; //Registration form
$in['lang']['email_subject'] = "Nouveau membre inscrit"; //New user registration notice
$in['lang']['email_message'] = "Nouveau membre s'est inscrit pour utiliser votre forum.\n\n"; //New user has registered to use your forum.\n\n
$in['lang']['username'] = "Nom de membre"; //Username
$in['lang']['password'] = "Mot de passe"; //Password
$in['lang']['email'] = "Courriel"; //Email
$in['lang']['name'] = "Nom"; //Name

$in['lang']['ok_mesg'] = "Votre inscription est un succ&egrave;s.  Un mot de passe al&eacute;atoire vous a &eacute;t&eacute; envoy&eacute; par courriel";
//User account was successfully created. A random password was sent to your email address.

$in['lang']['ok_mesg_2'] = "Votre inscription a &eacute;t&eacute; effectu&eacute;e."; //User account created successfully.

$in['lang']['click_to_login'] = "Cliquez ici pour vous identifier."; //Click here to login.


$in['lang']['inst_mesg'] = "Veuillez remplir le formulaire suivant pour vous inscrire &agrave; ce forum"; //Please complete the form below to register to use this forum:

$in['lang']['i_agree'] = "J'accepte"; //I agree
$in['lang']['i_do_not_agree'] = "Je refuse"; //I do not agree

$in['lang']['disagree_mesg'] = "Vous avez choisi de ne pas accepter nos r&egrave;gles et conditions d'usage.
	Vous ne pouvez donc pas devenir membre et utiliser ce forum. S'il sagit
	d'une erreur, revenez &agrave; la page pr&eacute;c&eacute;dente et cliquez sur le bouton 'J'accepte'.";
//You have elected not to agree to our forum acceptable
//use policy.  Therefore, you are not allowed to register to
//use the forum.  If this is a mistake, please go back and
//review our acceptable use policy and click on 'I agree' button.";




?>

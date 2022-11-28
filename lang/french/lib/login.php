<?php
///////////////////////////////////////////////////////////////////////
//
// login.php
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
// 	$Id: login.php,v 1.1 2003/04/14 08:56:34 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

$in['lang']['e_referer'] = "Probl&egrave;me HTTP Referer"; //HTTP Referer problem
$in['lang']['e_referer_desc'] = "Pour des raisons de s&eacute;curit&eacute; ce programe
		n&eacute;cessite que votre ordinateur ait activ&eacute; l'option REFERER LOGGING.
		Veuillez v&eacute;rifier dans votre fureteur ou dans
		votre logiciel de s&eacute;curit&eacute; que cette option est activ&eacute;e.";
//For security reasons,
//this program requires that your PC setting has REFERER LOGGING option
//set to enabled.  Please check your browser or your PC's internet
//security software to make sure that this option is enabled.

$in['lang']['e_cookie'] = "Probl&egrave;me de cookie"; //Cookie problem
$in['lang']['e_cookie_desc'] = "Vous devez activer vos cookies pour que DCForum
	puisse vous identifier. Veuillez les activer et essayer &agrave; nouveau.";
//DCForum login system requires that you have
//your cookie enabled on your browser.  Please enable it now
//and try again.

$in['lang']['page_header'] = "Identification en cours,...veuillez patienter"; //Login in progress...please wait
$in['lang']['no_refresh'] = "Si cette page ne se rafraîchit pas, cliquez ici."; //If this page does not refresh, please click here.

$in['lang']['login_form'] = "Formulaire d'identification du membre"; //User login form

$in['lang']['h_password'] = "Mot de passe oubli&eacute;?"; //Don't remember your password?
$in['lang']['h_password_desc'] = "Cliquez ici pour recevoir un nouveau mot de passe par courriel"; //Click here to receive a new password for your account

$in['lang']['h_firsttime'] = "Premi&egrave;re identification"; //Firsttime loggin user

$in['lang']['h_firsttime_desc'] = "C'est la premi&egrave;re fois que vous vous identifiez. Veuillez remplir
	le formulaire suivant pour cr&eacute;er votre profil et choisir vos pr&eacute;f&eacute;rences.";
//This is the first time you are logging on.  Please
//complete the following form to create your profiles 
//and preference settings.

$in['lang']['e_header'] = "Il y a des erreurs dans les informations que vous avez soumises. Lire ci-dessous pour plus de renseignements:";
//There were errors in the information you submitted.
//Please check below for more info:

$in['lang']['info_updated'] = "Votre profil et vos pr&eacute;f&eacute;rences ont &eacute;t&eacute; mis &agrave; jour.
	Si vous souhaitez les modifier plus tard, utilisez l'option au menu membre.";
//Your profile and preference has been updated.
//If you wish to modify them at a later time, use the
//options in user menu.

$in['lang']['click_here'] = "Cliquez ici pour aller &agrave; la page principale du forum"; //Click here to goto the main forum

$in['lang']['h_guest'] = "Vous devez être membre pour poster dans ce forum. Si vous l'êtes, entrez votre nom de membre et mot de passe";
//You must be a registered user to post in this forum.<br />
//If you are a registered user, please enter your username
//and password.


$in['lang']['login_desc'] = "Veuillez entrer votre nom de membre et mot de passe pour vous identifier"; //Please enter your username and password to login

$in['lang']['new_user_1'] = "Si vous d&eacute;sirez vous inscrire comme nouveau membre sur ce forum, "; //If you are a new user and wish to register to use this forum, 

$in['lang']['new_user_2'] = "utilisez ce formulaire pour vous inscrire"; //please use this form and register

$in['lang']['new_user_3'] = "Si vous êtes un nouveau membre, contactez l'administrateur du site pour obtenir votre acc&egrave;s";
//If you are a new user, please contact the site administrator  to obtain user account.

$in['lang']['retrieve_password'] = "Mot de passe oubli&eacute;?"; //Don't remember your password?


$in['lang']['retrieve_password_desc'] = "Cliquez ici pour recevoir un nouveau mot de passe";
//Click here to receive a new password for your account





?>

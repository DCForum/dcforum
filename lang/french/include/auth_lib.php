<?php
//
//
// auth_lib.php
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
// 	$Id: auth_lib.php,v 1.1 2003/04/14 08:57:45 david Exp $	
//


// function check_user
$in['lang']['no_access'] = "Vous n'avez pas acc&egrave;s &agrave; cette section. <br />
Veuillez, <a href=\"" . DCF . "?az=logout\">quitter</a>
et vous indentifier &agrave; nouveau comme administrateur.";

//You do not have access to program.  <br />Please
//<a href=\"" . DCF . "?az=logout\">logout</a> 
//and login again as adminstrator.


// function login_form
$in['lang']['username'] = "Nom de membre"; //Username
$in['lang']['password'] = "Mot de passe"; //Password
$in['lang']['remember_later'] = "Rester identifi&eacute; lors de ma prochaine visite"; // Remain logged on when I return later?
$in['lang']['login'] = "Identification"; //Login (?)

// function authenticate
$in['lang']['error_username'] = "ERREUR: Votre nom de membre contient des caract&egrave;res invalides"; //ERROR: Your username contains invalid characters
$in['lang']['no_such_user'] = "Ce membre n'existe pas..."; //No such user...
$in['lang']['deactivated_account'] = "Votre acc&egrave;s est suspendu"; //Your account in deactivated //(in->is ?)
$in['lang']['incorrect_password'] = "Mot de passe invalide"; //Incorrect password
$in['lang']['insufficient'] = "Vous n'avez pas acc&egrave;s &agrave; cette section"; //Insufficient previlege to access this program

// function registration_form
$in['lang']['again'] = "encore"; //again
$in['lang']['group'] = "Groupe"; //Group
$in['lang']['status'] = "Statut"; //Status
$in['lang']['submit'] = "Soumettre le formulaire"; //Submit Form


// function registration_user
$in['lang']['reg_error'] = "ERREUR: Il y a une erreur dans votre formulaire d'identification. Veuillez les corriger ci-dessous:";
//ERROR: There were errors in your registration form. Please correct them below:

// function check_reg_info
// following is to display error message that tells the
// user that a particular login info is blank or empty
$in['lang']['is_empty'] = " est vide"; // is empty
$in['lang']['invalid_characters'] = " contient des caract&egrave;res invalides"; // contains characters that are not allowed.
$in['lang']['too_long'] = " contient trop de caract&egrave;res. Le maximum permis est "; 
// contains too many characters.  The maximum number of characters allowed is 
$in['lang']['different_passwords'] = "Les deux mots de passe ne corespondent pas"; //Two passwords do not match
$in['lang']['dup_username'] = "Le nom de membre choisi existe d&eacute;j&agrave;. Veuillez en choisir un autre.";
//The username you chose is already in our database.  Please select another username.
$in['lang']['dup_email_1'] = "Adresse de courriel existe d&eacute;j&agrave;"; //Duplicate email address
$in['lang']['dup_email_2'] = " cette adresse de courriel existe d&eacute;j&agrave;. Veuillez choisir un autre courriel.";
// is already using that email address.  Please choose another email address.
$in['lang']['blocked_email'] = "Pour des raisons de s&eacute;curit&eacute;, l'administrateur de ce forum a activ&eacute; le filtrage
de certains services de courriel. Il vous est impossible de vous enregistrer avec cette adresse de courriel. Veuillez en choisir une autre.";
//For security reasons, the administrator
//of this forum has enabled email filtering that which
//denies registration using certain email services.
//Please choose another email address.

$in['lang']['bad_email'] = "Adresse de courriel invalide"; //Invalid Email Syntax


// function user_account_form
$in['lang']['cannot_change_username'] = "Le nom de membre ne peut &ecirc;tre chang&eacute;"; //Username cannot be changed.

// following are already defined
//$in['lang']['again'] = " encore"; // again
//$in['lang']['group'] = "Groupe"; //Group
//$in['lang']['status'] = "Statut"; //Status
//$in['lang']['submit_form'] = "Soumettre le formulaire"; //Submit Form

?>

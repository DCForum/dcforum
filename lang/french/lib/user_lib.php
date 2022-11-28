<?php
//
//
// user_lib.php
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
// 	$Id: user_lib.php,v 1.1 2003/04/14 08:57:22 david Exp $	

// function preference_form
$in['lang']['update'] = "Mise &agrave; jour"; //Update

// function profile_form_fields
$in['lang']['local_avatar'] = "Cliquez ici pour choisir un avatar disponible."; //Click here to choose from available avatars.

$in['lang']['remote_avatar_ok'] = "Vous pouvez aussi utiliser une image sur un autre serveur.<br />
		Pour ce faire, entrer l'URL de l'image. <br /> pour de meilleurs r&eacute;sultats, l'image
		devrait mesurer 48x48 pixel.<br />";
//You may also use an image file on a remote server.<br />
//To do so, enter the image URL.<br />For best result, 
//it should be 48 x 48 in size.<br />


$in['lang']['remote_avatar_disabled'] = "L'utilisation d'images de d'autres serveurs n'est pas disponible.";
//The use of image files on a remote 
//server has been disabled by the administrator.

//function update_user_setting
$in['lang']['error_icq'] = "Un id ICQ ne contient que des chiffres"; //ICQ ID can only contain numbers
$in['lang']['error_aol'] = "Un id AOL IM ne contient que des lettres"; //AOL IM ID can only contain word characters
$in['lang']['error_avatar'] = "Image d'avatar invalide"; //Invalid avatar image
$in['lang']['error_gender'] = "Le genre ne peut être que homme ou femme"; //Gender field can only be mail or female
$in['lang']['error_city'] = "Le nom de ville ne peut contenir que des lettres"; //City field can only contain word characters
$in['lang']['error_state'] = "Le champ province ne peut contenir que des lettres"; //State field can only contain word characters
$in['lang']['error_country'] = "Le champ pays ne peut contenir que des lettres"; //Country field can only contain word characters
$in['lang']['error_homepage'] = "L'URL de la page personnelle est invalide"; //Homepage URL in invalid
$in['lang']['error_yes_no'] = "Cette option ne peut être que oui ou non"; //option can only be yes or no


//function full_setting_form
$in['lang']['your_profile'] = "Votre profil"; //Your profile
$in['lang']['your_preference'] = "Vos pr&eacute;f&eacute;rences"; //Your preference
$in['lang']['submit'] = "Soumettre"; //Submit

?>

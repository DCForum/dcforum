<?php
//
//
// user_profiles.php
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
// 	$Id: user_profiles.php,v 1.1 2003/04/14 08:57:24 david Exp $	


$in['lang']['page_title'] = "Liste des profils"; //User profiles listing
$in['lang']['header'] = "Voir le profil des membres"; //Viewing user profiles

$in['lang']['invalid_index'] = "Index invalide"; //Invalid index
$in['lang']['invalid_index_mesg'] = "L'index choisi a une syntaxe invalide. S&eacute;lectionner un index
	du tableau ou rechercher un mot qui ne contient que des caract&egrave;res alphanum&eacute;riques.";
//The index you chose
//has invalid syntax.  Please make sure you only select from the index table
//or enter search string that only contains alphanumeric characters.


$in['lang']['invalid_id'] = "Id de membre invalide"; //invalid user ID
$in['lang']['invalid_id_mesg'] = "L'ID du membre est invalide. V&eacute;rifier que l'ID ne contient que des chiffres";
//he user ID you chose invalid.  Please make sure that user ID only contains numbers

$in['lang']['inst_mesg'] = "Pour afficher le profil d'un membre, s&eacute;lectionner un membre dans l'index dans le menu de gauche.<br />
             Vous pouvez aussi utiliser le formualaire de recherche sous l'index.";
//To display a list of user profiles,
//select an index from the user index table on the left hand menu.<br />
//Or, you can use the search form below the index table.


// function view_profile
$in['lang']['no_such_user'] = "Profil inexistant"; //No such user profile
$in['lang']['no_such_user_mesg'] = "Ce membre a d&eacute;sactiv&eacute; son profil."; //The user has disabled his/her user profile.

$in['lang']['username'] = "Nom de membre"; //Username
$in['lang']['click_to_send_email'] = "Cliquez ici pour envoyer un courriel"; //Click to send email to this author
$in['lang']['click_to_send_message'] = "Cliquez ici pour envoyer un message priv&eacute;"; //Click to send private message to this author
$in['lang']['click_to_add_buddy'] = "Cliquez ici pour ajouter &agrave; votre liste de copains"; //Click to add this author to your buddy list
$in['lang']['click_to_aol'] = "Cliquez ici pour envoyer un message par AOL IM"; //Click to send message via AOL IM
$in['lang']['click_to_view_profile'] = "Cliquez ici pour voir le profil"; //Click to view this author's profile
$in['lang']['click_to_icq'] = "Cliquez ici pour envoyer un message par ICQ"; //Click to send message via ICQ

$in['lang']['send_email']  = "Envoyer un courriel au membre"; //Send email to user
$in['lang']['send_mesg']  = "Envoyer un message priv&eacute; au membre"; //Send private message to user"
$in['lang']['add_buddy']  = "Ajouter le membre &agrave; votre liste de copains"; //Add user to your buddy list
$in['lang']['view_profile']  = "Voir le profil"; //View profile
$in['lang']['send_aol']  = "Page sur AOL IM"; //Page on AOL IM
$in['lang']['send_icq']  = "Page sur ICQ"; //Page on ICQ

$in['lang']['profile_name'] = "Nom du profil"; //Profile name
$in['lang']['profile_value'] = "Valeur du profil"; //Profile value

$in['lang']['no_such_profile'] = "Profil du membre inexistant"; //No such user profile
$in['lang']['no_such_profile_mesg'] = "Le profil du membre demand&eacute; n'existe pas. V&eacute;rifier que l'ID du membre est correct.";
//The profile of the user ID you requested 
//does not exist in the profile database. Please make sure that the user ID correct.


$in['lang']['others'] = "AUTRES"; //OTHERS
$in['lang']['options'] = "Options"; //Options

// global index_menu
$in['lang']['search_by_index'] = "Rechercher par index"; //Search by index
$in['lang']['search_by_username'] = "Rechercher par nom"; //Search by username
$in['lang']['search_by_username_desc'] = "Entrer les premiers caract&egrave;res<br />du nom que vous recherchez";
//Enter first few characters of <br /> the user you are looking for
$in['lang']['go'] = "Allez"; //Go




?>

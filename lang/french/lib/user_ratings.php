<?php
//
//
// user_ratings.php
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
// 	$Id: user_ratings.php,v 1.1 2003/04/14 08:57:25 david Exp $	
//

// main function

$in['lang']['page_title'] = "Liste des &eacute;valuations de membres"; //User ratings listing

$in['lang']['header'] = "Voir les &eacute;valuations"; //Viewing user ratings
$in['lang']['click_on_user'] = "Cliquez sur un nom pour voir les d&eacute;tails de son &eacute;valuation";
//Click on a username to view a detailed rating information

$in['lang']['invalid_syntax'] = "Syntaxe invalide"; //Invalid syntax
$in['lang']['invalid_syntax_mesg'] = "L'index choisi a une syntaxe invalide. V&eacute;rifier qu'il soit pr&eacute;sent dans l'index
	ou d'avoir entr&eacute; &agrave; la recherche seulement des mots qui contiennent des caract&egrave;res alphanum&eacute;riques.";
//The index you chose
//has invalid syntax.  Please make sure you only select from the index table
//or enter search string that only contains alphanumeric characters.


$in['lang']['invalid_id'] = "Id de membre invalide"; //Invalid user ID
$in['lang']['invalid_id_mesg'] = "l'id de membre choisi a une syntaxe invalide. V&eacute;rifier qu'il ne contient que des chiffres";
//The user ID you chose
//has invalid syntax.  Please make sure that user ID only contain numbers.


$in['lang']['list_mesg'] = "Pour afficher l'&eacute;valuation d'un membre,
	s&eacute;lectionner un nom dans l'index &agrave; gauche du menu.<br />
	Vous pouvez aussi utiliser le formulaire de recherche sous l'index.";
//To display a list of user ratings,
//select an index from the user index table on the left hand menu.<br />
//Or, you can use the search form below the index table.

// function view_rating
$in['lang']['no_rating'] = "&eacute;valuation inexistante"; //No such user rating
$in['lang']['disabled_rating__mesg'] = "Ce membre a d&eacute;sactiv&eacute; l'&eacute;valuation"; //The user has disabled his/her user rating.
$in['lang']['no_user_rating'] = "L'&eacute;valuation de ce membre n'existe pas. V&eacute;rifier que l'id du membre est correct";
//The ratings of the user you requested does not exist.  Please make sure that user ID is correct

$in['lang']['inactive_user'] = "membre inactif"; //inactive user
$in['lang']['rating_for'] = "&eacute;valuation de"; //Rating information for
$in['lang']['feedbacks'] = "Nombre total de r&eacute;ponses"; //Total number of feedbacks
$in['lang']['total_score'] = "R&eacute;sultat total"; //Total score
$in['lang']['points'] = "points"; //points

$in['lang']['positive'] = "positive"; //positives
$in['lang']['neutral'] = "neutre"; //neutrals
$in['lang']['negative'] = "n&eacute;gative"; //negatives

$in['lang']['rate_this_user'] = "&eacute;valuer ce membre"; //Rate this user
$in['lang']['view_profile'] = "Voir profil"; //View profile
$in['lang']['date'] = "Date"; //Date
$in['lang']['user'] = "Membre"; //User"
$in['lang']['score'] = "R&eacute;sultat"; //Score
$in['lang']['comment'] = "Commentaire"; //Comment


// function list_ratings
$in['lang']['number_of_feedbacks'] = "Nombre de r&eacute;ponses"; //Number of feedbacks

// function index_menu
$in['lang']['search_by_index'] = "Recherche par index"; //Search by index
$in['lang']['search_by_username'] = "Recherche par nom"; //Search by username
$in['lang']['search_by_username_desc'] = "Entrer les premi&egrave;res lettres du<br />nom que vous rechercher:";
//Enter the first few characters of <br /> the user you are looking for:
$in['lang']['others'] = "AUTRES"; //OTHERS
$in['lang']['go'] = "Allez!"; //Go!


?>

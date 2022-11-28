<?php
//
//
// dcmesg.php
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
// 	$Id: dcmesg.php,v 1.1 2003/04/14 08:58:23 david Exp $	
//
//


// print_error_mesg
$in['lang']['error'] = "ERREUR"; //ERROR

// output_error_mesg
$in['lang']['invalid_forum_id'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car l'ID du forum est invalide.
L'ID du forum doit &ecirc;tre un nombre entier.";
//The page you requested cannot be displayed because
//the forum ID syntax is not valid.  The forum ID must
//be an integer number.


$in['lang']['missing_forum'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car ce forum n'existe plus.
L'administrateur du site peut avoir supprim&eacute; le forum que vous recherchez.";
//The page you requested cannot be displayed because
//there is no such forum.  The administrator of this
//site may have removed the forum you are looking for.



$in['lang']['message_posting_denied'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car vous n'&ecirc;tez pas
autoris&eacute; &agrave; poster sur ce forum. Contacter l'administrateur du site pour plus d'information.";
//The page you requested cannot be displayed because
//you do not have POST access to this forum.  Please
//contact the administrator of this site for more info.




$in['lang']['access_denied'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car vous n'avez pas acc&egrave;s &agrave; ce forum
ou ce forum est hors d'usage. Pour acc&eacute;der &agrave; ce forum, contacter l'administrateur.";
//The page you requested cannot be displayed because
//you do not have access to this forum or this forum is currently offline.
//If you wish to access this forum, please contact the
//administrator of this site.



$in['lang']['invalid_topic_id'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car la syntax de l'ID de la discussion est invalide
L'ID de la discussion doit &ecirc;tre un nombre entier.";
//The page you requested cannot be displayed because
//the topic ID syntax is not valid.  The topic ID must
//be an integer number.


$in['lang']['missing_topic'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car cette discussion n'existe pas.
L'administrateur du site peut avoir supprim&eacute; la discussion que vous recherchez.";
//The page you requested cannot be displayed because
//there is no such topic.  The administrator of this
//site may have removed the topic that you are looking for.


$in['lang']['invalid_message_id'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car la syntax de l'ID du message est invalide.
L'ID du message doit &ecirc;tre un nombre entier.";
//The page you requested cannot be displayed because
//the message ID syntax is not valid.  The message ID must
//be an integer number.


$in['lang']['missing_message'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car ce message n'existe pas.
L'administrateur du site peut avoir supprim&eacute; le message que vous recherchez";
//The page you requested cannot be displayed because
//there is no such message.  The administrator of this
//site may have deleted the message that you are looking for.


$in['lang']['disabled_option'] = "L'information demand&eacute;e ne peut &ecirc;tre affich&eacute;e car vous
tentez d'acc&eacute;der &agrave; des options r&eacute;serv&eacute;es aux utilisateurs inscrits ou l'administrateur du site a
d&eacute;sactiv&eacute; cette option.";
//The information you requested cannot be displayed because
//you are trying to access options for registered users or
//the administrator of this site has disabled that option.


$in['lang']['missing_attachment'] = "La pi&egrave;ce jointe demand&eacute;e n'est plus disponible.
Elle a peut-&ecirc;tre &eacute;t&eacute; supprim&eacute;e par l'administrateur.";
//The attachment you requested is no longer available.
//It may have been deleted by the forum administrator.


$in['lang']['missing_module'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car les modules n&eacute;cessaires sont manquants";
//The page you requested cannot be displayed because
//the neccessary module is missing.

$in['lang']['invalid_input_parameter'] = "L'information demand&eacute;e ne peut &ecirc;tre affich&eacute;e, un ou plusieurs param&egrave;tres d'entr&eacute;e sont invalides.";
//The information you requested cannot be displayed one
//or more input parameters has invalid syntax.


$in['lang']['invalid_referer'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e car votre requ&ecirc;te a &eacute;chou&eacute;
le test de 'HTTP referer'. Si vous utilisez un logiciel de s&eacute;curit&eacute; (ex.: Norton Internet Security) ou
un navigateur qui permet de d&eacute;sactiver 'REFERER LOGGING', veuillez vous assurer que
cette option soit activ&eacute;e";
//The page you requested cannot be displayed because
//your request failed HTTP referer check.  If you are running
//a PC security software (e.g., Norton Internet Security)
//or browser that allows disabling of REFERER LOGGING, please
//make sure that you ENABLE that option.




$in['lang']['denied_request'] = "Vous devez &ecirc;tre inscrit pour utiliser cette fonction.
Veuillez vous <a href=\"" . DCF . "?az=login\">identifier</a>.";
//You must be a registered user
//to be able to use this function.  Please 
//<a href=\"" . DCF . "?az=login\">login</a> first.


$in['lang']['default'] = "L'information demand&eacute;e ne peut &ecirc;tre affich&eacute;e car elle n'est plus disponible.
Si vous pensez qu'il sagit d'une erreur, veuillez aviser l'administrateur du site.";
//The information you requested cannot be displayed
//because it is no longer available.  If you think this is in
//error, please contact the site administrator.



// print_error_page
$in['lang']['request_error'] = "Erreur de requ&ecirc;te"; //Request error
$in['lang']['cannot_be_displayed'] = "La page demand&eacute;e ne peut &ecirc;tre affich&eacute;e"; //The page you requested cannot be displayed.
$in['lang']['contact_admin'] = "Si vous avez des questions, contacter l'administrateur du site."; //If you have any questions, please contact the site administrator.
$in['lang']['click_to_goback'] = "Cliquez ici pour revenir &agrave; la page pr&eacute;c&eacute;dente."; //Click here to go back to the previous page.

// print_alert_page
$in['lang']['request_alert'] = "Alerte de requ&ecirc;te"; //Request alert

// print_success_page
$in['lang']['request_completed'] = "Requ&ecirc;te compl&eacute;t&eacute;e"; // Request completed



?>

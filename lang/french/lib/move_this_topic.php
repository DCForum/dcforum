<?php
//////////////////////////////////////////////////////////////////////////
//
// move_this_topic.php
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
// 	$Id: move_this_topic.php,v 1.1 2003/04/14 08:56:37 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function move_this_topic

$in['lang']['access_denied'] = "Acc&egrave;s refus&eacute;"; //Access denied
$in['lang']['access_denied_message'] = "La page demand&eacute;e ne peut être affich&eacute;e car vous n'avez 
pas acc&egrave;s &agrave; cette fonction. Contactez l'administrateur du site pour plus de renseignements.";
//The page you requested cannot be displayed because
//you do not have access to this function. Please contact the
//administrator of this site for more info.


$in['lang']['page_title'] = "Programme d'administration - Gestion des discussions - D&eacute;placer une discussion";
//Administration program - Topic manager - Move a topic

$in['lang']['e_move'] = "Erreur en d&eacute;placant cette discussion"; //Error in moving this topic
$in['lang']['e_move_desc_1'] = "Vous avez s&eacute;lectionn&eacute; une conf&eacute;rence comme destination. Vous ne pouvez pas
		d&eacute;placer une discussion dans une conf&eacute;rence. Veuillez choisir un autre forum";
//You selected a conference for the destination forum.  You
//cannot move a topic to a conference.  Please choose another forum.


$in['lang']['e_move_desc_2'] = "Vous avez choisi le même forum de destination. Vous ne pouvez pas d&eacute;placer une discussion
	dans le même forum. Veuillez choisir un autre forum.";
//You selected same destination forum.  You
//cannot move a topic to the same forum.  Please choose another forum.

$in['lang']['page_header'] = "D&eacute;placer une discussion dans un autre forum"; //Moving a topic to another forum
$in['lang']['ok_mesg'] = "La discussion choisie a &eacute;t&eacute; d&eacute;plac&eacute;e"; //The topic you chose was moved.

$in['lang']['which_forum'] = "D&eacute;placer la discussion vers quel forum?"; //Move topics to which forum?
$in['lang']['which_forum_desc'] = "Notez que vous ne pouvez pas d&eacute;placer une discussion vers une conf&eacute;rence"; //Plese note that you cannot move topics to a conference.


// function move_this_topic_form() {
$in['lang']['move_topic_from'] = "D&eacute;placer une discussion de"; //Move a topic from
$in['lang']['move_button'] = "D&eacute;placer cette discussion"; //Move this topic


// 1.24 addition - need to translate these

$in['lang']['old_topic'] = "What do you want to do with the old topic?";
$in['lang']['old_topic_copy'] = "Leave the topic unchanged";
$in['lang']['old_topic_mark'] = "Mark the topic as moved";
$in['lang']['old_topic_delete'] = "Delete the topic";


?>

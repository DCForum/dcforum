<?php
//
//
// show_topics.php
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
// 	$Id: show_topics.php,v 1.1 2003/04/14 08:57:14 david Exp $	
//

$in['lang']['page_title'] = "Voir discussion dans"; //Viewing topics in
$in['lang']['pages'] = "Pages"; //Pages

$in['lang']['pinned'] = "Indique une discussion &eacute;pingl&eacute;e"; //Indicates pinned topic
$in['lang']['new_icon'] = "Les icones de couleur indiquent les nouveaux messages"; //Color icons indicate new messages

$in['lang']['sort_by_id'] = "Id du message"; //message ID
$in['lang']['sort_by_subject'] = "Sujet du message"; //message subject
$in['lang']['sort_by_author'] = "Nom de l'auteur"; //author's username
$in['lang']['sort_by_last_date'] = "Date de modification"; //last modified date
$in['lang']['sort_by_replies'] = "Nombre de r&eacute;ponses"; //number of replies
$in['lang']['sort_by_views'] = "Nombre de lectures"; //number of views

$in['lang']['sf_header'] = "Dossiers additionels dans cette discussion"; //Additional folders in this discussion
$in['lang']['sf_header_2'] = "Sujets dans cette discussion"; //Topics in this discussion
$in['lang']['sf_name'] = "Nom du forum et description"; //Forum name and description
$in['lang']['sf_last_date'] = "Dernière mise &agrave; jour par date/sujet/auteur"; //Last updated date/topic/author
$in['lang']['sf_info'] = "Information additionnelle"; //Additional information

$in['lang']['moderators'] = "Mod&eacute;rateur"; //Moderators
$in['lang']['by'] = "par"; //by

$in['lang']['t_header'] = "Discussions class&eacute;es par"; //Topics sorted by
$in['lang']['t_id'] = "ID du message"; //Message ID
$in['lang']['t_topic'] = "Discussion"; //Topic
$in['lang']['t_author'] = "Auteur"; //Author

// NOTE for t_date, use &nbsp; in place of a blank space
$in['lang']['t_date'] = "Dernière&nbsp;mise &agrave; jour&nbsp;date"; //Last&nbsp;updated&nbsp;date
$in['lang']['t_replies'] = "R&eacute;ponses"; //Replies
$in['lang']['t_views'] = "Vu"; //Views
$in['lang']['t_rating'] = "&eacute;valuation"; //Rating

// Following are also in /lang/english/include/dcmenulib.php
$in['lang']['unpin'] =             'D&eacute;pingler'; //Unpin
$in['lang']['pin'] =               '&eacute;pingler'; //Pin
$in['lang']['lock'] =              'Verrouiller'; //Lock
$in['lang']['unlock'] =            'D&eacute;verrouiller'; //Unlock
$in['lang']['delete'] =            'Supprimer'; //Delete
$in['lang']['hide'] =              'Cacher'; //Hide
$in['lang']['move'] =              'D&eacute;placer'; //Move

$in['lang']['confirm_unpin'] =     'Êtes-vous certain de vouloir D&eacute;PINGLER cette discussion?'; //Are you sure you want to UNPIN this topic?
$in['lang']['confirm_pin'] =       'Êtes-vous certain de vouloir &eacute;PINGLER cette discussion?'; //Are you sure you want to PIN this topic?
$in['lang']['confirm_lock'] =      'Êtes-vous certain de vouloir VERROUILLER cette discussion?'; //Are you sure you want to LOCK this topic?
$in['lang']['confirm_unlock'] =    'Êtes-vous certain de vouloir D&eacute;VERROUILLER cette discussion?'; //Are you sure you want to UNLOCK this topic?
$in['lang']['confirm_delete'] =    'Êtes-vous certain de vouloir SUPPRIMER cette discussion?'; //Are you sure you want to DELETE this topic?
$in['lang']['confirm_hide'] =      'Êtes-vous certain de vouloir CACHER cette discussion?'; //Are you sure you want to HIDE this topic?
$in['lang']['confirm_move'] =      'Êtes-vous certain de vouloir D&eacute;PLACER cette discussion?'; //Are you sure you want to MOVE this topic?






$in['lang']['replies_to'] = "R&eacute;pondre &agrave; cette discussion:"; //Replies to this topic:
$in['lang']['view_all'] = "Tout voir"; //View all
?>

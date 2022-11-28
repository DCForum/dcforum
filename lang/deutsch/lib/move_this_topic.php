<?php
//////////////////////////////////////////////////////////////////////////
//
// move_this_topic.php
//
// DCForum+ Version 1.2
// April 4, 2003
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
// 	$Id: move_this_topic.php,v 1.2 2003/03/27 08:15:45 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function move_this_topic

$in['lang']['access_denied'] = "Zugriff verweigert";
$in['lang']['access_denied_message'] = "Die angeforderte Seite kann nicht angezeigt werden weil
         du keinen Zugriff auf diese Funktion hast.
         Wenn du Fragen dazu hast, wende dich bitte an den Administrator.";

$in['lang']['page_title'] = "Administration - Themenmanager - Thema verschieben";

$in['lang']['e_move'] = "Fehler beim verschieben des Themas";
$in['lang']['e_move_desc_1'] = "Du hast als Ziel eine Forengruppe gew�hlt. Es ist nicht m�glich, 
                           ein Thema in eine Forengruppe zu verschieben. Bitte w�hle ein anderes Forum als Ziel.";

$in['lang']['e_move_desc_2'] = "Du hast das selbe Forum als Ziel gew�hlt. Es ist nicht m�glich,
                           ein Thema in das selbe Forum zu verschieben. Bitte w�hle ein anderes Forum als Ziel.";

$in['lang']['page_header'] = "Thema verschieben";
$in['lang']['ok_mesg'] = "Das von dir gew�hlte Thema wurde verschoben.";

$in['lang']['which_forum'] = "In welches Forum verschieben?";
$in['lang']['which_forum_desc'] = "Beachte, dass du Themen nicht in Forengruppen verschieben kannst.";


// function move_this_topic_form() {
$in['lang']['move_topic_from'] = "Thema verschieben aus";
$in['lang']['move_button'] = "Dieses Thema verschieben";


// added for 1.24...need to translate this part
$in['lang']['old_topic'] = "What do you want to do with the old topic?";
$in['lang']['old_topic_copy'] = "Leave the topic unchanged";
$in['lang']['old_topic_mark'] = "Mark the topic as moved";
$in['lang']['old_topic_delete'] = "Delete the topic";

?>
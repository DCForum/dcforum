<?php
//
//
// show_topics.php
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
// 	$Id: show_topics.php,v 1.7 2003/04/07 15:42:43 david Exp $	
//

$in['lang']['page_title'] = "Anzeige der Themen in";
$in['lang']['pages'] = "Seiten";

$in['lang']['pinned'] = "Weist auf oben festgesetztes Thema hin";
$in['lang']['new_icon'] = "Farbige Icons weisen auf neue Beiträge hin";

$in['lang']['sort_by_id'] = "Beitrags-ID";
$in['lang']['sort_by_subject'] = "Betreff";
$in['lang']['sort_by_author'] = "Username";
$in['lang']['sort_by_last_date'] = "letztem Änderungsdatum";
$in['lang']['sort_by_replies'] = "Anzahl der Antworten";
$in['lang']['sort_by_views'] = "Anzahl der Views";

$in['lang']['sf_header'] = "Weitere Ordner in diesem Forum";
$in['lang']['sf_header_2'] = "Themen in diesem Forum";
$in['lang']['sf_name'] = "Forenname und Beschreibung";
$in['lang']['sf_last_date'] = "Letzte Änderung Datum/Thema/Autor";
$in['lang']['sf_info'] = "Weitere Informationen";

$in['lang']['moderators'] = "Moderatoren";
$in['lang']['by'] = "von";

$in['lang']['t_header'] = "Themen sortiert nach";
$in['lang']['t_id'] = "Beitrags-ID";
$in['lang']['t_topic'] = "Thema";
$in['lang']['t_author'] = "Autor";

// NOTE for t_date, use &nbsp; in place of a blank space
$in['lang']['t_date'] = "Letzte&nbsp;Änderung";
$in['lang']['t_replies'] = "Antworten";
$in['lang']['t_views'] = "Views";
$in['lang']['t_rating'] = "Bewertung";

// Following are also in /lang/deutsch/include/dcmenulib.php
$in['lang']['unpin'] =             'Loslösen';
$in['lang']['pin'] =               'Festsetzen';
$in['lang']['lock'] =              'Sperren';
$in['lang']['unlock'] =            'Freigeben';
$in['lang']['delete'] =            'Löschen';
$in['lang']['hide'] =              'Verstecken';
$in['lang']['move'] =              'Verschieben';

$in['lang']['confirm_unpin'] =     'Bist du dir sicher, dass du dieses Thema LOSLÖSEN willst?';
$in['lang']['confirm_pin'] =       'Bist du dir sicher, dass du dieses Thema FESTSETZEN willst?';
$in['lang']['confirm_lock'] =      'Bist du dir sicher, dass du dieses Thema SPERREN willst?';
$in['lang']['confirm_unlock'] =    'Bist du dir sicher, dass du dieses Thema FREIGEBEN willst?';
$in['lang']['confirm_delete'] =    'Bist du dir sicher, dass du dieses Thema LÖSCHEN willst?';
$in['lang']['confirm_hide'] =      'Bist du dir sicher, dass du dieses Thema VERSTECKEN willst?';
$in['lang']['confirm_move'] =      'Bist du dir sicher, dass du dieses Thema VERSCHIEBEN willst?';


$in['lang']['replies_to'] = "Antworten zu diesem Thema:";
$in['lang']['view_all'] = "Alle anzeigen";
?>
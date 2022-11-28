<?php
///////////////////////////////////////////////////////////////
//
// search.php
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
// 	$Id: search.php,v 1.2 2003/03/26 10:16:22 david Exp $	
//

$in['lang']['page_title'] = "Foren durchsuchen";
$in['lang']['sf_header'] = "Suchformular";

$in['lang']['keyword_blank'] = "Du hast keinen Suchbegriff eingegeben. Bitte nochmal versuchen.";

// this sentence ends "Only displaying first x pages."
$in['lang']['too_many_hits'] = "Deine Suche ergab zu viele Ergebnisse. Es werden nur die ersten";
$in['lang']['pages'] = "Seiten angezeigt.";

$in['lang']['no_match'] = "Deine Suche brachte kein Ergebnis. Bitte nochmal versuchen.";

// function display_help

$in['lang']['advanced_help'] = "
         <p>Das Forum mit dem erweiterten Formular durchsuchen</p>
         <ol>
         <li> Gib ein oder mehrere Suchbegriffe ein. Bei mehreren Suchbegriffen müssen die einzelnen Wörter durch ein Leerzeichen getrennt sein.</li>
         <li> Bestimme deine Suchkriterien. Wähle \"Wort\" wenn die Suchbegriffe als ganzes Wort zutreffen sollen. Andernfalls wähle \"Schema\" wenn die Suchbegriffe als Teile von Wörtern gefunden werden sollen.</li>
         <li> Wenn du mehr als einen Suchbegriff angegeben hast, bestimme die Suchlogik. Bei einer logischen \"Oder\" Verknüpfung erhälst du die Themen, in denen mindestens einer der Suchbegriffe auftaucht. Bei einer logischen \"Und\" Verknüpfung erhälst du die Themen, in denen deine Suchbegriffe komplett vorkommen.</li>
         <li> Wähle eine Forengruppe oder ein Forum zum durchsuchen. Bei einer Forengruppe werden auch die Foren darin durchsucht HINWEIS: Eine Einschränkung auf bestimmte Foren ist schneller.</li>
         <li> Wenn du rekursiv suchen lassen möchtest, wähle hier \"Ja\" aus.</li>
         <li> Bestimme ein spezielles Feld das du durchsuchen lassen möchtest.</li>
         <li> Gib den Zeitraum der Themen an, in denen gesucht werden soll.</li>
         <li> Leg fest, wieviele Ergebnisse pro Seite angezeigt werden sollen.</li>
         </ol> ";

$in['lang']['simple_help'] = "
      <p>Das Forum mit dem einfachen Formular durchsuchen</p>
         <ol>
         <li> Gib ein oder mehrere Suchbegriffe ein. Bei mehreren Suchbegriffen müssen die einzelnen Wörter durch ein Leerzeichen getrennt sein.</li>
         <li> Die einfache Suche benutzt eine logische \"Oder\" Verknüpfung. Wenn du eine logische \"Und\" Verknüpfung nutzen möchtest, ruf bitte das erweitere Suchformular auf.</li>
         <li> In der einfachen Suche werden der Betreff und der Beitrag nach den Suchbegriffen durchsucht. Die Suche bezieht sich auf alle Foren. Für eine schnellere, gezieltere Suche solltest du das erweiterte Suchformular aufrufen.</li>
         </ol> ";


// function search_form

$in['lang']['search_all_forums'] = "Alle Foren durchsuchen";

$in['lang']['sf_yes'] = "Ja";
$in['lang']['sf_no'] = "Nein";

$in['lang']['sf_or'] = "Oder";
$in['lang']['sf_and'] = "Und";

$in['lang']['sf_word'] = "Wort";
$in['lang']['sf_pattern'] = "Schema";

// search fields
$in['lang']['sf_subject_message'] = "Betreff und Beitrag";
$in['lang']['sf_subject'] = "Nur Betreff";
$in['lang']['sf_message'] = "Nur Beitrag";
$in['lang']['sf_author'] = "Autor";

// search days
$in['lang']['sd_0'] = "Alle Themen";
$in['lang']['sd_1'] = "Themen der letzten 24 Tage";
$in['lang']['sd_7'] = "Themen der letzten Woche";
$in['lang']['sd_14'] = "Themen der letzten zwei Wochen";
$in['lang']['sd_30'] = "Themen des letzten Monats";


$in['lang']['sa_header'] = "Mit dem erweiterten Formular suchen";
$in['lang']['sa_link'] = "Zum erweiterten Suchformular";

$in['lang']['ss_header'] = "Mit dem einfachen Formular suchen";
$in['lang']['ss_link'] = "Zum einfachen Suchformular";

$in['lang']['sf_keyword'] = "Suchbegriff(e)";
$in['lang']['sf_logic'] = "Suchlogik";
$in['lang']['sf_which_forum'] = "In welchen Foren suchen?";
$in['lang']['sf_children'] = "Wenn anwendbar, untergeordnete Foren rekursiv durchsuchen?";
$in['lang']['sf_which_field'] = "In welchen Feldern suchen?";
$in['lang']['sf_days'] = "Über welchen Zeitraum suchen?";
$in['lang']['sf_pages'] = "Anzahl der Ergebnisse pro Seite";
$in['lang']['sf_button'] = "Jetzt suchen!";

?>
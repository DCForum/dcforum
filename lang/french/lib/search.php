<?php
///////////////////////////////////////////////////////////////
//
// search.php
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
// 	$Id: search.php,v 1.1 2003/04/14 08:56:58 david Exp $	
//

$in['lang']['page_title'] = "Recherche dans les forums"; //Search the forums
$in['lang']['sf_header'] = "Formulaire de recherche"; //Search form

$in['lang']['keyword_blank'] = "Aucun mot cl&eacute; sp&eacute;cifi&eacute;. Veuillez essayer encore";
//You left keyword text  box blank.  Please try again

// this sentence ends "Only displaying first x pages."
$in['lang']['too_many_hits'] = "Vos crit&egrave;res de recherche couvrent trop de discussions. Seules les premi&egrave;res";
//Your search criteria returned too many topics.  Only displaying first

$in['lang']['pages'] = "pages seront affich&eacute;es"; //pages

$in['lang']['no_match'] = "Vos crit&egrave;res de recherche n'ont rien trouv&eacute;. Veuillez essayer encore.";
//Your search criteria return  no matched results.  Please try again

// function display_help

$in['lang']['advanced_help'] = "
         <p>Comment utiliser les fonctions avanc&eacute;es pour trouver une discussion</p>
         <ol>
         <li> Entrer un ou plusieurs mots cl&eacute;s.  Si vous entrez plusieurs mots cl&eacute;s, s&eacute;parez les avec un espace.</li>
         <li> Sp&eacute;cifier les crit&egrave;res de recherche. Choisir 'mot' si vous voulez que le mot cl&eacute;
		corresponde &agrave; un mot. Autrement choisir 'Expression' pour que le mot cl&eacute; corresponde
		&agrave; une partie du message</li>
         <li> Si vous entrez plusieurs mots cl&eacute;s, vous pouvez utiliser le 'ou' et le 'et' logique.
		Choisir 'Ou' logique et la recherche retrouvera toutes les discussions
		qui contiennent l'un ou l'autre des mots cl&eacute;s entr&eacute;s.
		Choisir 'Et' logique et la recherche retrouvera toutes les discussions
		qui contiennent chacun des mots cl&eacute;s entr&eacute;s. </li>
         <li> Choisir une conf&eacute;rence ou un forum &agrave; chercher. Si vous choisissez une conf&eacute;rence,
		la recherche sera effectu&eacute;e dans tous les forums de cette derni&egrave;re.
		Note: Limiter le nombre de forums sera plus rapide. </li>
         <li> Si vous voulez rechercher dans tous les sous forums, choisir 'Oui'
		&agrave; cette option.</li>
         <li> Sp&eacute;cifier un champ particulier pour pr&eacute;ciser votre recherche.</li>
         <li> Sp&eacute;cifier un &eacute;cart de date pour pr&eacute;ciser votre recherche</li>.
         <li> Sp&eacute;cifier le nombre de r&eacute;sultats &agrave; afficher par page.</li>
         </ol> ";
/*
         <p>How to search the discussion forums using advanced search form</p>
         <ol>
         <li> Enter a keyword or keywords.  If you are submitting more than one keyword,
              use a blank space to separate each keyword.</li>
         <li> Specify search criteria.  Select 'Word' if you want the keywords
              to match as a word.  Otherwise, select 'Pattern' to match
              keywords as a part of words.</li>
         <li> If you specified more than one keyword, define search logic.  
              If you choose 'Or' logic, the search will return
              any topics containing any one of the keywords.  If you choose 'And' logic,
              the search will return topics that matches the entire string.</li>
         <li> Select a conference or a forum to search.  If you select a conference,
              it will search all the forums in that conference.
              NOTE: Limiting the number of forums to search will be much quicker.</li>
         <li> If you wish to recursively search a forum and all its children forums,
              select 'Yes' for this option.</li>
         <li> Specify a particular field you wish to search.</li>
         <li> Specify the date range of topics you wish to search</li>.
         <li> Specify the number of results to display per page </li>
         </ol>
*/







$in['lang']['simple_help'] = "
      <p>Comment utiliser les fonctions simples pour trouver une discussion</p>
         <ol>
         <li> Entrer un ou plusieurs mots cl&eacute;s.  Si vous entrez plusieurs mots cl&eacute;s, s&eacute;parez les avec un espace.</li>
         <li> La recherche simple utilise le 'Ou' logique. Pour utiliser le 'Et' employez la recherche avanc&eacute;e.</li>
         <li> La recherche simple cherche les sujets et messages de tous les forums. Pour acc&eacute;l&eacute;rer votre recherche
		pr&eacute;cisez la avec la recherche avanc&eacute;e.</li>
         </ol> ";
/*
      <p>How to search the discussion forums using simple search form</p>
         <ol>
         <li> Enter a keyword or keywords.  If you are submitting more than one keyword,
              use a blank space to separate each keyword.</li>
         <li> Simple search uses 'Or' search logic.  If you wish to use 'And' logic, please use
              the advanced search form.</li>
         <li> Simple search will search subject and message for the provided
              keyword(s).  It will search all forums.  For quicker search, you may use
              the advanced search form.</li>
         </ol>
*/


// function search_form

$in['lang']['search_all_forums'] = "Rechercher dans tous les forums"; //Search all forums

$in['lang']['sf_yes'] = "Oui"; //Yes
$in['lang']['sf_no'] = "Non"; //No

$in['lang']['sf_or'] = "Ou"; //Or
$in['lang']['sf_and'] = "Et"; //And

$in['lang']['sf_word'] = "Mot"; //Word
$in['lang']['sf_pattern'] = "Expression"; //Pattern

// search fields
$in['lang']['sf_subject_message'] = "Sujet et message"; //Subject and message
$in['lang']['sf_subject'] = "Sujet seulement"; //Subject only
$in['lang']['sf_message'] = "Message seulement"; //Message only
$in['lang']['sf_author'] = "Auteur"; //Author

// search days
$in['lang']['sd_0'] = "Rechercher dans toutes les discussions"; //Search all topics
$in['lang']['sd_1'] = "Rechercher les discussions dans les derni&egrave;res 24 heures"; //Search topics from last 24 hours
$in['lang']['sd_7'] = "Rechercher les discussions dans la derni&egrave;re semaine"; // Search topics from last one week
$in['lang']['sd_14'] = "Rechercher les discussions dans les deux derni&egrave;res semaines"; //Search topics from last two weeks
$in['lang']['sd_30'] = "Rechercher les discussions dans le dernier mois"; //Search topics from last one month


$in['lang']['sa_header'] = "Rechercher avec le formulaire avanc&eacute;"; //Search using advanced search form
$in['lang']['sa_link'] = "Utiliser la recherche avanc&eacute;e"; //Use advanced search form

$in['lang']['ss_header'] = "Rechercher avec le formulaire simple"; //Search using simple search form
$in['lang']['ss_link'] = "Utiliser la recherche simple"; //Use simple search form

$in['lang']['sf_keyword'] = "Mot(s) cl&eacute;(s)"; //Keyword(s)
$in['lang']['sf_logic'] = "Recherche logique"; //Search logic
$in['lang']['sf_which_forum'] = "Rechercher dans quel forum?"; //Search which forum?
$in['lang']['sf_children'] = "Si applicable, rechercher dans tous les sous forums?"; //If applicable, recursively search all children forums?
$in['lang']['sf_which_field'] = "Rechercher quel(s) champ(s)?"; //Search which field(s)?
$in['lang']['sf_days'] = "Rechercher combien de jours pass&eacute;s?"; //Search how many days in the past?
$in['lang']['sf_pages'] = "Nombre de r&eacute;sultats par page"; //Number of results per page
$in['lang']['sf_button'] = "Rechercher maintenant!"; //Search now!

?>

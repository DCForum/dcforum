<?php
//
//
// dcmenulib.php
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
// 	$Id: dcmenulib.php,v 1.1 2003/04/14 08:58:22 david Exp $	
//
//
//

// text used in function nav_menu
$in['lang']['add_bad_ip'] =            'Ajouter mauvaise adresse IP'; //Adding bad IP address
$in['lang']['add_buddy'] =             'Ajouter un membre &agrave; votre liste de copains'; //Adding a user to your buddy list
$in['lang']['alert'] =                 'Envoyer un message d\'alerte &agrave; l\'administrateur'; //Send alert message to administrator
$in['lang']['announcement'] =          'Forum d\'annonces'; //Forum announcements
$in['lang']['edit_poll'] =             'Modifier sondage'; //Edit poll
$in['lang']['email_to_friend'] =       'Envoyer un courriel au membre'; //Send email to a user
$in['lang']['faq'] =                   'FAQ du forum'; //Forum FAQ
$in['lang']['login'] =                 'Page d\'identification'; //Login page
$in['lang']['poll'] =                  'Questionnaire du sondage'; //Poll form
$in['lang']['post'] =                  'Formulaire pour poster'; //Post form
$in['lang']['read_new'] =              'Lire nouveaux messages'; //Reading new messages
$in['lang']['send_email'] =            'Formulaire de courriel'; //Email form
$in['lang']['send_mesg'] =             'Formulaire pour envoi d\'un message priv&eacute;'; //Send private message form
$in['lang']['user'] =                  'Menu du membre inscrit'; //Registered user menu
$in['lang']['whos_online'] =           'Voir qui est en-ligne'; //Checking to see who\'s online
$in['lang']['register'] =              'Formulaire d\'inscription'; //User registration form
$in['lang']['retrieve_password'] =     'Aide, mot de passe perdu'; //Lost password help
$in['lang']['search'] =                'Recherche dans les forums'; //'Search the forums
$in['lang']['guest_user'] =            'Menu d\'utilisateur invit&eacute;'; //Guest user menu
$in['lang']['user_ratings'] =          '&Eacute;valuation de membres'; //User ratings
$in['lang']['user_profiles'] =         'Profil des membres'; // User profiles
$in['lang']['view_ip'] =               'Voir l\'adresse IP de l\'auteur'; //Viewing author\'s IP address
$in['lang']['calendar'] =              '&Eacute;v&eacute;nement au calendrier'; //Event calendar


// text used in function button_menu
$in['lang']['login'] =             'Identification'; //Login
$in['lang']['logout'] =            'Quitter'; //Logout
$in['lang']['faq'] =               'Aide'; //FAQ
$in['lang']['user_profiles'] =     'Profiles';  //Profiles
$in['lang']['user'] =              'Menu des membres'; //User menu
$in['lang']['guest_user'] =        'Option des invit&eacute;s'; //Guest options
$in['lang']['rating'] =            'Evaluation'; //Rating
$in['lang']['read_new'] =          'Lire nouveau'; //Read new
$in['lang']['post'] =              'Poster'; //Post'
$in['lang']['poll'] =              'Sondage'; //Poll
$in['lang']['search'] =            'Recherche'; //Search
$in['lang']['admin'] =             'Admin'; //Admin
$in['lang']['mark'] =              'Marquer'; //Mark
$in['lang']['goback'] =            'Retour'; //Go back
$in['lang']['subscribe'] =         'Abonner'; // Subscribe
$in['lang']['topic_subscribe'] =   'Abonner &agrave; cette discussion'; //Subscribe to this topic
$in['lang']['topic_unsubscribe'] = 'D&eacute;sabonner de cette discussion'; //Unsubscribe to this topic
$in['lang']['printer_friendly'] =  'Format d\'impresion'; //Printer-friendly copy
$in['lang']['email_to_friend'] =   'Envoyer un courriel de cette discussion &agrave; un ami'; //Email this topic to a friend
$in['lang']['calendar'] =          'Calendrier'; // Calendar
$in['lang']['bookmark'] =          'Mettre cette discussion en signet'; //Bookmark this topic


// function option_menu
$in['lang']['top'] =               'Haut'; //Top
$in['lang']['show_all_folders'] =  'Montrer tous les forums'; //Show all folders
$in['lang']['whos_online'] =       'Voir qui est en-ligne'; //Check who\'s online
$in['lang']['expand_topics'] =     '&Eacute;tendre les discussions'; //Expand topics
$in['lang']['collapse_topics'] =   'Grouper les discussions'; //Collapse topics
$in['lang']['linear_mode'] =       'Voir en mode lin&eacute;aire'; //View in linear mode
$in['lang']['threaded_mode'] =     'Voir en mode hi&eacute;rarchique'; //View in threaded mode
$in['lang']['linear_off'] =        'Mode lin&eacute;aire d&eacute;sactiv&eacute;'; //Linear discussion mode disabled
$in['lang']['subscribe'] =         'S\'abonner &agrave; ce forum'; //Subscribe to this forum
$in['lang']['days'] =              'jours'; //days
$in['lang']['listing_days'] =      'Liste des discussions: '; //Listing topics: '
$in['lang']['listing'] =           'Lister '; //Listing 

$in['lang']['unpin'] =             'D&eacute;pingler'; //Unpin
$in['lang']['pin'] =               '&Eacute;pingler'; //Pin
$in['lang']['lock'] =              'Verrouiller'; //Lock
$in['lang']['unlock'] =            'D&eacute;verrouiller'; //Unlock
$in['lang']['delete'] =            'Supprimer'; //Delete
$in['lang']['hide'] =              'Cacher'; //Hide
$in['lang']['move'] =              'D&eacute;placer'; //Move

$in['lang']['confirm_unpin'] =     'Êtes-vous certain de vouloir D&Eacute;PINGLER cette discussion?'; //Are you sure you want to UNPIN this topic?
$in['lang']['confirm_pin'] =       'Êtes-vous certain de vouloir &Eacute;PINGLER cette discussion?'; //Are you sure you want to PIN this topic?
$in['lang']['confirm_lock'] =      'Êtes vous certain de vouloir VERROUILLER cette discussion?'; //Are you sure you want to LOCK this topic?
$in['lang']['confirm_unlock'] =    'Êtes-vous certain de vouloir D&Eacute;VERROUILLER cette discussion?'; //Are you sure you want to UNLOCK this topic?
$in['lang']['confirm_delete'] =    'Êtes-vous certain de vouloir SUPPRIMER cette discussion?'; //Are you sure you want to DELETE this topic?
$in['lang']['confirm_hide'] =      'Êtes-vous certain de vouloir CACHER cette discussion?'; //Are you sure you want to HIDE this topic?
$in['lang']['confirm_move'] =      'Êtes-vous certain de vouloir D&Eacute;PLACER cette discussion?'; //Are you sure you want to MOVE this topic?


// jump to forum menu

$in['lang']['jump_to'] = "Allez &agrave; un autre forum"; //Jump to another forum
$in['lang']['forum_listing'] = "Accueil des forums"; //Main forum listings

// last add for new hack
$in['lang']['select_classic_mode'] =   'Affichage classique'; //Choose classic view
$in['lang']['select_dcf_mode'] =     'Affichage dcf '; //Choose dcf view


// expand conference
$in['lang']['expand_conference'] = "Etendre conf&eacute;rences"; //Expand conferences
$in['lang']['collapse_conference'] = "Grouper conf&eacute;rences"; //Collapse conferences

?>

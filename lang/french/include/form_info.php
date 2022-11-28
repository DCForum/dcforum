<?php
//
//
// form_info.php
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
// language file for form_info.php
//


// login parameters
$in['lang']['username_title'] = 'Nom de membre'; //Username
$in['lang']['username_desc'] = 'Le nom de membre est sensible aux caract&egrave;res<br />
		Il doit contenir seulement des caract&egrave;res alphanum&eacute;riques, soulign&eacute;s ou espace blanc.<br />
		Il ne peut contenir plus de 30 caract&egrave;res.';
//Username is case-insensitive.<br />
//It must only contain alphanumeric characters, underscore, or
//blank space.<br />
//It must not be longer than 30 characters.


$in['lang']['password_title'] = 'Mot de passe'; //Password
$in['lang']['password_desc'] = 'Le mot de passe est sensible aux caract&egrave;res.<br />
		Il ne peut contenir plus de 30 caract&egrave;res.';
//Password is case-sensitive.<br />
//It must not be longer than 30 characters.


$in['lang']['name_title'] = 'Pr&eacute;nom et Nom'; //Name
$in['lang']['name_desc'] = 'Le pr&eacute;nom et le nom doivent contenir que des caract&egrave;res alphanum&eacute;riques, soulign&eacute;s ou espace blanc.<br />
		Ils ne peuvent contenir plus de 50 caract&egrave;res.';
//It must only contain alphanumeric characters, underscore, or
//blank space.<br />
//It must not be longer than 50 characters.


$in['lang']['email_title'] = 'Adresse courriel'; //EMail Address
$in['lang']['email_desc'] = 'Le courriel ne peut contenir plus de 50 caract&egrave;res.'; //It must not be longer than 50 characters.


// profile parameters

$in['lang']['pa_title'] = 'ICQ'; //ICQ
$in['lang']['pa_desc'] = 'Votre num&eacute;ro d\'identification ICQ<br />
		Ne pas remplir si vous n\'&ecirc;tes pas un utilisateur ICQ';
//Your Numeric ICQ user ID<br />
//Leave this field blank to disable ICQ use

$in['lang']['pb_title'] = 'Messagerie instantann&eacute;e de AOL'; // AOL instant messenger
$in['lang']['pb_desc'] = 'Votre nom d\'utilisateur sur AOL<br /> 
		Ne pas remplir si vous n\'&ecirc;tes pas un utilisateur AOLIM';
//Your AOL instant messenger screen name<br /> 
//Leave this field blank to disable AOLIM use




$in['lang']['pc_title'] = 'Image avatar'; //Avatar Image
$in['lang']['pc_desc'] = '';


$in['lang']['pd_title'] = 'Sexe'; // Gender
$in['lang']['pd_desc'] = '';

$in['lang']['pd_male'] = 'homme'; // male
$in['lang']['pd_female'] = 'femme'; //female


$in['lang']['pe_title'] = 'Ville'; // City
$in['lang']['pe_desc'] = '';

$in['lang']['pf_title'] = 'Province'; //State
$in['lang']['pf_desc'] = '';

$in['lang']['pg_title'] = 'Pays'; //Country
$in['lang']['pg_desc'] =  '';

$in['lang']['ph_title'] = 'Site internet personnel'; // Homepage
$in['lang']['ph_desc'] = 'Si vous avez un site internet personnel, inscrivez son URL.'; //If you have a homepage, its URL

$in['lang']['pi_title'] = 'Passe-temps'; //Hobby
$in['lang']['pi_desc'] = '';

$in['lang']['pj_title'] = 'Commentaires'; //Comment'
$in['lang']['pj_desc'] = 'Commentaires que vous souhaitez partager avec les autres membres.<br />
		Texte simple seulement. Tous les codes HTML seront supprim&eacute;s.<br />
		Maximum de 255 caract&egrave;res';
//Any comments that you wish to share with other users<br />
//Plain text only...HTML tags will be removed.<br />
//Maximum number of characters allowed in 255

$in['lang']['pk_title'] = 'Signature'; //Signature
$in['lang']['pk_desc'] = 'Signature que vous souhaitez ajouter &agrave; la fin de vos messages<br />
		Maximum de 255 caract&egrave;res';
//Signature that you wish to use in your messages<br />
//Maximum number of characters allowed is 255


// preference parameters

$in['lang']['ut_title'] = 'Votre fuseau horaire'; //Your time zone
$in['lang']['ut_desc'] = 'Choisir un fuseau horaire diff&eacute;rent pour afficher
	la date et l\'heure dans votre fuseau horaire. GTM est utilis&eacute; par d&eacute;faut';
//Select different time zone if you wish to 
//display all the date and time in your zone.  The default is GMT


$in['lang']['uu_title'] = 'Limite des dates'; //Date limit
$in['lang']['uu_desc'] = 'Afficher les discussions dont les dates de modification sont comprises entre cette limite'; //List topics whose modified date is within this date limit

$in['lang']['uv_title'] = 'Apparence des messages'; //Message layout style
$in['lang']['uv_desc'] = 'Choissir le style des messages'; //Choose a message layout style

$in['lang']['uw_title'] = 'Langue pr&eacute;f&eacute;r&eacute;e'; //Preferred language
$in['lang']['uw_desc'] = 'Choisir une langue pour afficher les menus et ent&ecirc;te du forum'; //Choose a preferred language for displaying forum menus and headers

$in['lang']['ua_title'] = 'Cacher votre profil?'; //Hide your profile? 
$in['lang']['ua_desc'] = 'Choisir "oui" pour rendre votre profil invisible'; //Select "yes" if do not want anyone to view your profile

$in['lang']['ub_title'] = 'Activer votre messagerie priv&eacute;e?'; //Use private message system?
$in['lang']['ub_desc'] = 'Choisir "oui" pour activer la messagerie priv&eacute;e du forum.
Cela vous permet d\'envoyer des courriels priv&eacute;s aux membres de ce forum tout en vous permettant de recevoir les leurs.'; 
//Select "yes" to enable forum\'s private 
//messaging system. Doing so will allow you 
//to send and receive messages from other registered users.

$in['lang']['uc_title'] = 'Permettre aux membres inscrits de vous contacter par courriel?'; //Allow other registered users to send you emails?
$in['lang']['uc_desc'] = 'Choisir "oui" pour permettre aux autres membres de vous contacter par courriel.';
//Selecting "yes" will allow other registered users to send you emails';

$in['lang']['ud_title'] = 'Permettre &agrave; l\'administrateur de vous contacter par courriel?'; // Allow administrator to send you email notices?
$in['lang']['ud_desc'] = 'Choisir "oui" permet &agrave; l\'administrateur de vous contacter par courriel.';
//Selecting "yes" will allow administrator to send you email notices


$in['lang']['ue_title'] = 'Permettre au forum de m&eacute;moriser mon identit&eacute;?'; //Remain logged on when you return to use the forum at a later time?
$in['lang']['ue_desc'] = 'Choisir "oui" permet au forum de m&eacute;moriser votre identit&eacute;.
	Cette fonction prendra effet la prochaine fois que vous vous identifierez.';
//Select "yes" if you want to be logged on when you return at a later time.
//This feature will be in effect the next time you login.

$in['lang']['uf_title'] = 'Vous aviser par courriel des messages priv&eacute;s en attente?'; //Notify via email when you receive a private message?
$in['lang']['uf_desc'] = 'Choisir "oui" pour recevoir un courriel vous avisant d\'un nouveau message priv&eacute;.';
//Select "yes" if you wish to receive an email 
//notification when you receive a private message.

$in['lang']['ug_title'] = 'Participer &agrave; l\'&eacute;valuation des messages des membres?'; //Participate in user rating and feedback?
$in['lang']['ug_desc'] = 'Choisir "oui" si vous voulez &eacute;valuer les messages des autres membres et permettre aux membres d\'&eacute;valuer les v&ocirc;tres.';
//Select "yes" if you wish to rate other users and allow other users to rate you.

$in['lang']['uh_title'] = 'Activer le marquage des messages lus?'; //Use MARK time stamp feature?
$in['lang']['uh_desc'] = 'Choisir "oui" si vous voulez marquer manuellement les forums
		dont vous avez lu les messages. Autrement, la date de votre derni&egrave;re visite servira &agrave; d&eacute;terminer
		les nouveaux messages';
//Select "yes" if you wish to use the MARK time 
//stamp feature to keep track of new messages.
//In this mode, you manually mark forums when you
//finish reading all the messages in that forum.
//Otherwise, your last visit time stamp is used to 
//keep track of new messages.


$in['lang']['ui_title'] = 'Vous aviser par courriel quand un membre vous ajoute &agrave; sa liste de copains?'; //Notify via email when you are added to a buddy list?
$in['lang']['ui_desc'] = 'Choisir "oui" si vous souhaitez &ecirc;tre avis&eacute; par courriel';
//Select "yes" if you wish to be notified when another registered user
//adds your name to his/her buddy list


$in['lang']['uj_title'] = 'Rendre votre signature modifiable &agrave; tous les messages?'; //Make signature editable for each post?
$in['lang']['uj_desc'] = 'Choisir "oui" si vous voulez que votre signature apparaisse dans la fen&ecirc;tre de composition des messages sous forme de texte modifiable.
		Ceci vous permettra d\'effacer votre signature lorsque vous ne voulez pas l\'inclure dans un message.
		Autrement, votre signature sera ajout&eacute;e automatiquement &agrave; vos messages. Note: votre signature doit &ecirc;tre d&eacute;finie dans votre profil'; 
//Select "yes" if you want your signature to appear in the
//message textarea as a part of your message text.  This way, you
//can edit or remove your signature.  Otherwise,
//your signature will be added when the message is created. Note:
//your signature must be defined in your profiles.


// forum parameters
// do need to modify this section...only affects admin program

$in['lang']['id_title'] = 'ID du forum'; //Forum ID
$in['lang']['id_desc'] = '';

$in['lang']['type_title'] = 'Type de forum'; //Forum Type
$in['lang']['type_desc'] = 'Choisir le type de forum d&eacute;sir&eacute;.<br />
	S\'il sagit d\'un sous forum, le type doit &ecirc;tre le m&ecirc;me que celui qui le contient.';
//Select type of forum you wish to create.<br />
//If this forum is a child forum, then the forum type will
//be at least the forum type of the parent forum.


$in['lang']['parent_id_title'] = 'Forum parent'; //Parent Forum
$in['lang']['parent_id_desc'] = 'Choisir un forum parent pour contenir ce forum<br />
	Le type du forum doit &ecirc;tre le m&ecirc;me que le forum qui le contient.';
//Select a parent forum to create this new forum within this forum.<br />
//The forum type you choose must be at least the forum type of this parent forum.

$in['lang']['forum_name_title'] = 'Nom du forum'; //Forum name
$in['lang']['forum_name_desc'] = '';

$in['lang']['description_title'] = 'Description du forum'; //Forum description
$in['lang']['description_desc'] = 'Les codes HTML peuvent &ecirc;tre utilis&eacute;s';
//HTML tags may be used in the forum description

$in['lang']['moderator_title'] = 'Mod&eacute;rateur du forum'; //Forum moderators
$in['lang']['moderator_desc'] = 'Choisir un ou plusieurs mod&eacute;rateurs pour ce forum. Ce champ ne s\'applique
	pas si vous cr&eacute;ez une conf&eacute;rence.';
//Select one or more moderators for this forum.  This field
//is not applicable if you are creating a conference.
                
$in['lang']['mode_title'] = 'Option de mod&eacute;ration'; //Moderated forum option
$in['lang']['mode_desc'] = 'S&eacute;lectionner \'off\' pour un forum non-mod&eacute;r&eacute; ou \'on\' pour un forum mod&eacute;r&eacute;.
	Ne s\'applique pas pour les forums';
//Select \'off\' for non-moderated forum or \'on\' for moderated forum mode.
//Not applicable for forums.


$in['lang']['status_title'] = 'Statut du forum'; //Forum status
$in['lang']['status_desc'] = '';

$in['lang']['top_template_title'] = 'Mod&egrave;le du haut'; //Top template
$in['lang']['top_template_desc'] = 'Ce mod&egrave;le est inclu dans le haut de chaque page. Il doit &ecirc;tre
	disponible dans le r&eacute;pertoire des mod&egrave;les.';
//This template is included at the top of each forum output.
//This template must reside in the templates directory.

$in['lang']['bottom_template_title'] = 'Mod&egrave;le du bas'; //Bottom template
$in['lang']['bottom_template_desc'] = 'Ce mod&egrave;le est inclu dans le bas de chaque page. Il doit
	&ecirc;tre disponible dans le r&eacute;pertoire des mod&egrave;les.';
//This template is included at the bottom of each forum output.
//This template must reside in the templates directory.     
                 


// days to list topics

$in['lang']['days_7'] = '1 semaine'; //one week
$in['lang']['days_14'] = '2 semaines'; //two weeks
$in['lang']['days_30'] = '1 mois'; //one month
$in['lang']['days_90'] = '3 mois'; //three months
$in['lang']['days_182'] = '6 mois'; //siz months
$in['lang']['days_365'] = '1 an'; //one year
$in['lang']['days_0'] = 'toutes les discussions'; //all available topics



// Topic icon titles

$in['lang']['topic_icons_0'] = 'G&eacute;n&eacute;ral'; //General
$in['lang']['topic_icons_1'] = 'Sondage'; //Poll
$in['lang']['topic_icons_2'] = 'Question'; //Question
$in['lang']['topic_icons_3'] = 'Aidez-moi'; //I need help
$in['lang']['topic_icons_4'] = 'Je cherche'; //I\'m looking for
$in['lang']['topic_icons_5'] = 'Nouveaux'; //News

// Poll choice titles

$in['lang']['poll_choice_1'] = 'Choix 1'; //Choice 1
$in['lang']['poll_choice_2'] = 'Choix 2'; //Choice 2
$in['lang']['poll_choice_3'] = 'Choix 3'; //Choice 3
$in['lang']['poll_choice_4'] = 'Choix 4'; //Choice 4
$in['lang']['poll_choice_5'] = 'Choix 5'; //Choice 5
$in['lang']['poll_choice_6'] = 'Choix 6'; //Choice 6

// allowed files to upload in upload form

$in['lang']['allowed_files_html'] = 'Fichier HTML'; //HTML file
$in['lang']['allowed_files_txt'] = 'Fichier texte'; //Plain text file
$in['lang']['allowed_files_jpg'] = 'Fichier d\'image JPEG'; //JPEG image file
$in['lang']['allowed_files_gif'] = 'Fichier d\'image GIF'; //GIF image file
$in['lang']['allowed_files_zip'] = 'Fichier compress&eacute; Zip'; //Zip compressed file
$in['lang']['allowed_files_tar'] = 'Fichier d\'archive tar'; //tar compressed file






?>

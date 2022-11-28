<?php
//
//
// user.php
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
// 	$Id: user.php,v 1.1 2003/04/14 08:57:21 david Exp $	
//

// main function
$in['lang']['page_title'] = "Menu du membre"; //User menu
$in['lang']['page_header'] = "Options du membre"; //User options


// function change_account_info
$in['lang']['name_blank'] = "Le champ nom est vide"; //The name field was left blank
$in['lang']['name_invalid'] = "Le nom soumis contient des caract&egrave;res invalides";
//The name you submitted contains characters that are not allowed

$in['lang']['email_blank'] = "Le champ courriel est vide"; //The email field was left blank
$in['lang']['email_invalid'] = "L'adresse de courriel est invalide"; //Your email syntax is invalid

$in['lang']['dup_email_1'] = "Adresse de courriel en double"; //Duplicate email address
$in['lang']['dup_email_2'] = "ce courriel est d&eacute;j&agrave; utilis&eacute;. Veuillez choisir un autre courriel.";
//is already using that email address. Please choose another email address.

$in['lang']['error_mesg'] = "Il y a des erreurs dans les informations soumises."; //There were errors in the information you submitted.


$in['lang']['name'] = "Nom"; //Name
$in['lang']['email_address'] = "Courriel"; //Email address
$in['lang']['updated_mesg'] = "La base de donn&eacute;es a &eacute;t&eacute; mise &agrave; jour.<br />
	Ci-dessous, la mise &agrave; jour des informations:";
//The database has been updated.<br />
//This updated information is shown below:

$in['lang']['account_form_mesg'] = "Modifier et soumettre les informations suivantes pour mettre &agrave; jour votre inscription.";
//Modify the information below and submit this form to
//modify your account information.

$in['lang']['update'] = "Mettre &agrave; jour"; //Update


// function change_password
$in['lang']['new_password_blank'] = "Le champ du nouveau mot de passe est vide"; //New password field was left blank
$in['lang']['current_password_incorrect'] = "Le mot de passe actuel soumis est erron&eacute;"; //Current password you submitted in incorrect.
$in['lang']['two_passwords_different'] = "Les deux nouveaux mots de passe ne corespondent pas."; //The two new passwords are submitted are different.
$in['lang']['password_errors'] = "Il y a des erreurs dans les informations soumises"; //There were errors in the information you submitted
$in['lang']['password_changed_1'] = "Votre mot de passe a &eacute;t&eacute; chang&eacute; pour:"; //Your password has been changed.  Your new password is:
$in['lang']['password_changed_2'] = "Vous pouvez imprimer et sauvegarder cette page au cas ou vous l'oublieriez";
//You may want to print and save this page just in case you forget it.
$in['lang']['password_form'] = "Remplir le formulaire suivant pour changer votre mot de passe."; //Complete the form below to change to your password.

// function password_form
$in['lang']['current_password'] = "Mot de passe actuel"; //Current password
$in['lang']['new_password'] = "Nouveau mot de passe"; //New password
$in['lang']['new_password_again'] = "Confirmation"; //New password again


// function change_profile
$in['lang']['change_error'] = "Il y a des erreurs. Corrigez les ci-dessous:"; //There were errors.  Please correct them below:
$in['lang']['profile_updated'] = "Votre profil a &eacute;t&eacute; mis &agrave; jour.<br />
	Ci-dessous les nouveaux param&egrave;tres:";
//Your profile has been updated. <br />
//The new values are listed below:

$in['lang']['profile_form_mesg'] = "Modifier les informations suivantes pour changer votre profil.
         <br />Lorsque termin&eacute;, cliquez sur le bouton '" . $in['lang']['update'] . "'. ";
//Edit the information in the form below to
//modify your profile.
//<br />When done, click on " . $in['lang']['update'] . " button to finish.

// function change_preference
$in['lang']['preference_updated'] = "Vos pr&eacute;f&eacute;rences ont &eacute;t&eacute; mises &agrave; jour.<br />
                                     Ci-dessous les nouveaux param&egrave;tres:";
//Your preference has been updated. <br />
//Below is the list of new values:


$in['lang']['preference_form_mesg'] = "Modifier les informations suivantes pour changer vos pr&eacute;f&eacute;rences..
         <br />Lorsque termin&eacute;, cliquez sur le bouton '" . $in['lang']['update'] . "'."; 
//Edit the information in the form below to
//modify your preference..
//<br />When done, click on " . $in['lang']['update'] . " button to finish.

// function forum_subscription
$in['lang']['forum_subscription_updated'] = "Votre liste d'abonnements au forum a &eacute;t&eacute; mise &agrave; jour.."; //Your list of forum subscription has been updated.

$in['lang']['forum_subscription_form'] = "S&eacute;lectionner les forums auxquels vous voulez vous abonner en cochant
		la case &agrave; gauche.<br />Si la case est d&eacute;j&agrave; coch&eacute;e, c'est que vous êtes d&eacute;j&agrave; abonn&eacute;.<br />
		Vous pouvez alors vous d&eacute;sabonner en enlevant le crochet de la case.";
//Select forums you wish to subscribe to by clicking on the
//checkbox on the left.<br />If the box is already checked, then
//you are already subscribed to that forum. <br />
//Unchecking checked boxes will remove you from those forums.


$in['lang']['select'] = "Choisir"; //Select
$in['lang']['forum_name'] = "Nom du forum"; //Forum name
$in['lang']['forum_form_button'] = "Abonnez-moi aux forums coch&eacute;s"; //Add checked forums to subscription list


// function topic_subscription
$in['lang']['topic_subscription_updated'] = "Votre abonnement a &eacute;t&eacute; mis &agrave; jour."; //Your list of topic subscription has been updated.

$in['lang']['topic_subscription_form'] = "Pour g&eacute;rer votre abonnement aux discussions, cliquez sur le sujet pour voir la discussion<br />
            Pour vous d&eacute;sabonner &agrave; une discussion, choisir le sujet en cochant la case &agrave; droite.<br />
            Pour terminer, soumettre le formulaire en cliquant sur le bouton.";

//To manage topic subscription list, you may view the topic
//by clicking on the subject.<br />
//To remove yourself from a
//topic subscription list, select that topic by clicking on the
//checkbox on the left.<br />
//To finish, submit this form by click on the button below.


$in['lang']['select'] = "Choisir"; //Select
$in['lang']['id'] = "ID"; //ID
$in['lang']['subject'] = "Sujet"; //Subject
$in['lang']['author'] = "Auteur"; //Author
$in['lang']['last_date'] = "Date de derni&egrave;re modification"; //Last modified date
$in['lang']['topic_form_button'] = "Effacer les discussions s&eacute;lectionn&eacute;es"; //Delete selected topics
$in['lang']['empty_topic_subscription'] = "Vous n'êtes abonn&eacute; &agrave; aucune discussion."; //You are not subscribed to any topics.

// function bookmark
$in['lang']['bookmark_updated'] = "Vos signets ont &eacute;t&eacute; mis &agrave; jour"; //Your bookmark list has been updated
$in['lang']['bookmark_form'] = "Pour g&eacute;rer vos signets, cliquez sur le sujet pour voir la discussion.<br />
	Pour supprimer la discussion de vos signets, s&eacute;lectionner ces discussions en cochant la case &agrave; gauche.<br />
	Pour terminer, soumettre ce formulaire en cliquant sur le bouton.";
  
//To manage your bookmark,  you may view the topic
//by clicking on the subject. <br />To remove topics from 
//your bookmark list, select those topics by clicking on the
//checkbox on the left.<br />  To finish, submit this form by click
//on the button below

$in['lang']['bookmark_form_button'] = "Supprimer les discussions s&eacute;lectionn&eacute;es de vos signets"; //Delete selected topics from your bookmark
$in['lang']['empty_bookmark'] = "Aucun signet d'enregistr&eacute;."; //You do not have any entries in your bookmark.


// function inbox
$in['lang']['reading_message_inbox'] = "Lire les messages dans votre boîte de r&eacute;ception"; //Reading messages in your inbox
$in['lang']['from'] = "De"; //From
$in['lang']['date'] = "Date"; //Date
$in['lang']['dalete'] = "Supprimer"; //Delete
$in['lang']['reply'] = "R&eacute;pondre"; //Reply

$in['lang']['inbox_marked'] = "Le message reçu a &eacute;t&eacute; marqu&eacute; lu"; //Your inbox message have been marked as read.
$in['lang']['inbox_updated'] = "Votre boîte de r&eacute;ception a &eacute;t&eacute; mise &agrave; jour"; //Your inbox list has been updated.

$in['lang']['inbox_desc'] = "Voici les messages qui sont dans votre boîte de r&eacute;ception.<br />
	Pour voir un message, cliquez sur son sujet.<br />
	Pour supprimer les vieux messages, cochez les messages concern&eacute;s et soumettre ce formulaire.";
//Following is the list of message you have in your inbox.<br />
//To view the message, click on the subject.<br />
//To prune old messages, select the messages you wish to remove
//from your inbox and submit this form.

$in['lang']['click_to_mark_inbox'] = "Cliquez ici pour marquer le message lu"; //Click here to mark inbox messages as read
$in['lang']['sender'] = "Exp&eacute;diteur"; //Sender
$in['lang']['inbox_form_button'] = "Supprimer les messages s&eacute;lectionn&eacute;s"; //Delete selected messages
$in['lang']['empty_inbox'] = "Votre boîte de r&eacute;ception est vide."; //You do not have any entries in your inbox.


// function buddy_list
$in['lang']['buddy_updated'] = "Votre liste de copains a &eacute;t&eacute; mise &agrave; jour"; //Your buddy list has been updated
$in['lang']['buddy_form'] = "Voici les membres qui sont dans votre liste de copains.<br />
		Pour voir leur profil, cliquez sur leur nom ou leur icone de profil.<br />
		Pour supprimer un membre de votre liste de copains, cochez la case dans la colonne de s&eacute;lection
		puis soumettre ce formulaire.";
//Following is the list of users you currently have
//in your buddy list.<br />To view user profile, click on the username
//or the profile icon.<br />To remove a user from your list, check the
//checkbox in the select column and then submit this form.


$in['lang']['buddy_form_button'] = "Supprimer les membres s&eacute;lectionn&eacute;s de ma liste"; //Remove selected users from my list
$in['lang']['empty_buddy'] = "Votre liste de copains est vide"; //You do not have any records in your buddy list.
$in['lang']['actions'] = "Actions"; //Actions


// function display_help
$in['lang']['dh_header'] = "Choisir une option suivante:"; //Choose from following functions:
$in['lang']['dh_account'] = "Modifier les informations sur votre inscription"; // Edit account information
$in['lang']['dh_password'] = "Changer votre mot de passe"; //Change your password
$in['lang']['dh_profile'] = "Modifier votre profil"; //Edit your profile
$in['lang']['dh_preference'] = "Modifier vos pr&eacute;f&eacute;rences"; //Edit your preference
$in['lang']['dh_forum'] = "Abonnement au forum"; //Forum Subscription
$in['lang']['dh_topic'] = "Abonnement &agrave; la discussion"; //Topic Subscription
$in['lang']['dh_bookmark'] = "Signets"; //Bookmarks
$in['lang']['dh_inbox'] = "Boîte de r&eacute;ception"; //Inbox
$in['lang']['dh_buddy'] = "Liste des copains"; //Buddy list

$in['lang']['dh_account_desc'] = "Utiliser cette option pour modifier votre nom et adresse de courriel."; //Use this option to change your name and email address.
$in['lang']['dh_password_desc'] = "Utiliser cette option pour modifier votre mot de passe"; //Use this option to change your password
$in['lang']['dh_profile_desc'] = "Utiliser cette option pour modifier votre profil"; //Use this option to make changes to your profile
$in['lang']['dh_preference_desc'] = "Utiliser cette option pour modifier vos pr&eacute;f&eacute;rences"; //Use this option to set your forum preference
$in['lang']['dh_forum_desc'] = "G&eacute;rer votre abonnement aux forums"; //Use this option to manage subscription to forums
$in['lang']['dh_topic_desc'] = "G&eacute;rer votre abonnement aux discussions"; //Use this option to manage subscription to topics
$in['lang']['dh_bookmark_desc'] = "G&eacute;rer vos signets"; //Manage your bookmark links
$in['lang']['dh_inbox_desc'] = "Lire et envoyer des messages priv&eacute;s"; //Read and send private messages
$in['lang']['dh_buddy_desc'] = "Liste de vos copains"; //List of your buddies

// function send_mesg
$in['lang']['invalid_user_id'] = "Id de membre invalide"; //Invalid user ID
$in['lang']['you_are_trying'] = "Vous essayez de vous envoyer un message"; //You are trying to send a message to yourself
$in['lang']['no_such_user'] = "Ce membre n'existe pas"; //No such user
$in['lang']['send_mesg_error'] = "Il y a des erreurs dans votre requête"; //There were errors in your request
$in['lang']['empty_subject'] = "Champ du sujet vide"; //Empty subject field
$in['lang']['empty_message'] = "Champ du message vide"; //Empty message field
$in['lang']['mesg_subect'] = "Vous avez reçu un message de"; //You have following message from
$in['lang']['subject'] = "Sujet"; //Subject
$in['lang']['message'] = "Message"; //Message
$in['lang']['ok_mesg'] = "Votre message a &eacute;t&eacute; envoy&eacute;"; //Your message was sent!
$in['lang']['send_mesg_inst'] = "Remplir le forumulaire suivant pour envoyer un message &agrave;"; //Complete the following form to send a message to

?>

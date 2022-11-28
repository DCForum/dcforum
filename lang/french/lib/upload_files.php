<?php
//
//
// upload_files.php
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
// 	$Id: upload_files.php,v 1.1 2003/04/14 08:57:20 david Exp $	
//

// main function
$in['lang']['page_title'] = "Utilitaire de t&eacute;l&eacute;d&eacute;chargement"; //File upload utility

$in['lang']['delete_header'] = "S&eacute;lectionner les pi&egrave;ces jointes que vous voulez supprimer."; //Select attachments you wish to delete.

$in['lang']['delete_attachment_mesg'] = "Les pi&egrave;ces jointes s&eacute;lectionn&eacute;es ont &eacute;t&eacute; supprim&eacute;es.<br />
		Vous pouvez joindre d'autres pi&egrave;ces en utilisant le formulaire suivant.<br />";
//The attachments you selected have been deleted.<br />
//You may include additional attachments using the form below.<br />

$in['lang']['close_this_window'] = "Fermer cette fenêtre"; //Close this window

$in['lang']['didnot_delete_attachement_mesg'] = "Vous avez choisi de ne pas supprimer vos pi&egrave;ces jointes.<br />
		Utiliser le formulaire suivant pour les supprimer.";
//You have elected  not to deleted any attachments.
//<br />Please use the form below to delete them.

$in['lang']['select_file_mesg'] = "S&eacute;lectionner un fichier &agrave; t&eacute;l&eacute;d&eacute;charger"; //Please select a file to upload

$in['lang']['max_file_invalid'] = "La taille maximum du fichier est incorrect"; //Maximum file size allowed is incorrect

$in['lang']['select_file_type_mesg'] = "S&eacute;lectionner le type de fichier appropri&eacute;"; //Please select a file type

$in['lang']['invalid_file_type'] = "Type de fichier invalide"; //Invalid file type

$in['lang']['error_header'] = "Il y a des erreurs lors du t&eacute;l&eacute;d&eacute;chargement"; //There were errors in uploading files

$in['lang']['ok_mesg'] = "Le fichier choisi a &eacute;t&eacute; t&eacute;l&eacute;d&eacute;charg&eacute; vers le serveur.<br /> L'URL de ce fichier est ";
//The file you chose was sucessfully uploaded to the server.<br /> The URL of this file is 

$in['lang']['upload_failed_mesg'] = "&eacute;chec de t&eacute;l&eacute;d&eacute;chargement.. votre fichier est plus
	gros que la limite permise par l'administrateur du site. Veuillez essayer &agrave; nouveau.";
//Upload failed...the file you tried to upload exceeds the maximum limit
//set by the administrator of this site.  Please try again.


$in['lang']['max_exceeded'] = "Votre message contient le maximum de pi&egrave;ces jointes permis.";
//Your post now contains maximum number of attachments allowed.

$in['lang']['max_exceeded_mesg'] = "Le nombre maximum de pi&egrave;ces jointes permis est atteint<br />
		Vous devez supprimer une ou plusieurs de vos pi&egrave;ces jointes avant de pouvoir en ajouter
		d'autres.";
//Maximum number of files allowed exceeded.<br />
//You must deelete one of more of your current 
//attachments before you can upload additional files.


$in['lang']['select_another'] = "Si vous voulez t&eacute;l&eacute;d&eacute;charger plus de fichiers, utilisez le formulaire suivant. Autrement, "; 
//If you wish to upload additional files, please use 
//the form below to do so. Otherwise, 

// function uploade_form
$in['lang']['step_1'] = "Etape 1. Cliquez sur le bouton 'Browse...' pour s&eacute;lectionner un fichier.";
//Step 1. Click on 'Browse...' button to choose your attachment file.

$in['lang']['maximum_size'] = "taille maximum permise"; //maximum size allowed

$in['lang']['kbytes'] = "Koctets"; //KBytes

$in['lang']['step_2'] = "Etape 2. D&eacute;finir le type de votre fichier"; //Step 2. Define your attachment type

$in['lang']['check_embed'] = "Cochez ici pour inclure l'URL de ce fichier &agrave; même votre message.";
//Check this box if you wish to embed 
//attachment URL in the message text box.


$in['lang']['step_3'] = "Etape 3. Cliquez sur le bouton 'T&eacute;l&eacute;d&eacute;charger' pour terminer.
	Le nom du fichier sera automatiquement ajout&eacute; &agrave; votre liste de pi&egrave;ces jointes.";
//Step 3. Click on 'Upload File!' button to finish.  The
//uploaded file name will automatically be added to the attachment textbox.


$in['lang']['button_upload'] = "T&eacute;l&eacute;d&eacute;charger"; //Upload file!
$in['lang']['button_reset'] = "Recommencer"; //Reset


// fucntion delete_upload_files

$in['lang']['select_file_to_delete'] = "S&eacute;lectionner les pi&egrave;ces jointes que vous voulez supprimer"; //Select attachments you wish to remove
$in['lang']['button_delete'] = "Fichiers supprim&eacute;s!"; //Delete selected files!

?>

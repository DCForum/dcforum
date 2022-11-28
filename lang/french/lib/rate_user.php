<?php
//////////////////////////////////////////////////////////////////////////
//
// rate_user.php
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
// 	$Id: rate_user.php,v 1.1 2003/04/14 08:56:49 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Formulaire d'&eacute;valuation d'un membre"; // User rating form"

$in['lang']['e_guest_user'] = "Vous devez être membre pour &eacute;valuer un membre"; //You must be a registered user to rate users.
$in['lang']['close_this_window'] = "Fermer cette fenêtre"; //Close this window
$in['lang']['e_rate_self'] = "Vous ne pouvez vous &eacute;valuer vous-même"; //You can't rate yourself
$in['lang']['e_rate_again'] = "Vous avez d&eacute;j&agrave; &eacute;valu&eacute; ce membre"; //You already rated this user!

$in['lang']['e_invalid_score'] = "R&eacute;sultat invalide - doit être un nombre"; //Invalid score - must be a number
$in['lang']['e_invalid_score_1'] = "R&eacute;sultat invalide - doit être -1, 0, ou 1"; //Invalid score - must be -1, 0, or 1
$in['lang']['e_invalid_user_id'] = "ID de membre invalide"; //Invalid user ID

$in['lang']['e_header'] = "Il y a des erreurs dans votre requête:"; //There were errors in your request:

$in['lang']['ok_mesg'] = "Votre r&eacute;sultat a &eacute;t&eacute; enregistr&eacute;"; //Your score has been recorded.


$in['lang']['f_desc'] = "Comment d&eacute;crivez-vous la contribution de ce membre aux discussions?";
//How would you describe this user's contribution to the discussions?
$in['lang']['f_desc_1'] = "Une &eacute;valuation positive donne au membre  +1 point.  
                         Une &eacute;valuation neutre donne au membre 0 point.
                         Une &eacute;valuation n&eacute;gative donne au membre -1 point.";
//A positive rating gives the user +1 point.  
//A neutral rating gives the user 0 point.
//A negative rating gives the user -1 point.

$in['lang']['positive'] = "Positive"; //Positive
$in['lang']['neutral'] = "Neutre"; //Neutral
$in['lang']['negative'] = "N&eacute;gative"; //Negative

$in['lang']['any_comments'] = "Commentaires?"; //Any comments?

$in['lang']['any_comments_1'] = "&eacute;crire un commentaire double votre r&eacute;sultat.  
            <br />Texte simple seulement. Toutes les balises HTML et liens vers des images seront effac&eacute;s.";
//Leaving comments will double your rating score.  
//<br />Plain text only.  All HTML tags and image links
//will be removed.

$in['lang']['rate_user'] = "&eacute;valuer le membre"; //Rate user

?>

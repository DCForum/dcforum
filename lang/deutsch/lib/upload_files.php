<?php
//
//
// upload_files.php
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
// 	$Id: upload_files.php,v 1.2 2003/03/24 14:39:32 david Exp $	
//

// main function
$in['lang']['page_title'] = "Datei-Upload";

$in['lang']['delete_header'] = "W�hle die Anh�nge, die du l�schen m�chtest.";

$in['lang']['delete_attachment_mesg'] = "Die ausgew�hlten Anh�nge wurden gel�scht.<br />
                          Wenn du m�chtest, kannst du weitere Anh�nge mit dem nachstehenden Formular hochladen.<br />";

$in['lang']['close_this_window'] = "Fenster schliessen";

$in['lang']['didnot_delete_attachement_mesg'] = "Du hast keine Anh�nge gel�scht.
                          <br />Bitte benutze das nachstehende Formular, um welche zu l�schen.";

$in['lang']['select_file_mesg'] = "Bitte w�hle eine Datei zum heraufladen";

$in['lang']['max_file_invalid'] = "Die maximale Dateigr��e stimmt nicht.";

$in['lang']['select_file_type_mesg'] = "Bitte w�hle einen Dateityp";

$in['lang']['invalid_file_type'] = "Ung�ltiger Dateityp";

$in['lang']['error_header'] = "Es sind Fehler im Datei-Upload aufgetreten.";

$in['lang']['ok_mesg'] = "Die gew�hlte Datei wurde erfolgreich heraufgeladen.<br />
                        Die Adresse dieser Datei lautet ";

$in['lang']['upload_failed_mesg'] = "Upload fehlgeschlagen ... die Datei, die du heraufladen wolltest �bersetigt das vom Administrator gesetzte Limit. Bitte versuchs nochmal.";

$in['lang']['max_exceeded'] = "Dein Beitrag enth�lt die maximale Anzahl an Anh�ngen, die erlaubt ist.";

$in['lang']['max_exceeded_mesg'] = "Die maximale Anzahl an Anh�ngen, die erlaubt ist wurde �berschritten.<br />
                                    Du musst ein oder mehrere Dateien deiner momentanen Anh�nge l�schen, 
                                    bevor du weitere Dateien heraufladen kannst.";

$in['lang']['select_another'] = "Wenn du weitere Dateien heraufladen m�chtest, benutze daf�r das folgende Formular. Ansonsten ";


// function uploade_form
$in['lang']['step_1'] = "Schritt 1. Klick auf den 'Durchsuchen...' Button um eine Datei auszuw�hlen.";

$in['lang']['maximum_size'] = "maximal erlaubte Dateigr��e";

$in['lang']['kbytes'] = "KBytes";

$in['lang']['step_2'] = "Schritt 2. Gib den Dateityp deines Anhangs an";

$in['lang']['check_embed'] = "Markiere diese Checkbox, wenn du die Adresse zum Anhang in das Eingabefeld einf�gen m�chtest.";

$in['lang']['step_3'] = "Schritt 3. Klick auf den 'Heraufladen!' Button um die Aktion abzuschliessen. 
         Der Name der der heraufgeladenen Datei wird automatisch in das Feld f�r Anh�nge eingef�gt.";
          
$in['lang']['button_upload'] = "Heraufladen!";
$in['lang']['button_reset'] = "Zur�cksetzen";


// fucntion delete_upload_files

$in['lang']['select_file_to_delete'] = "W�hle die Anh�nge, die du entfernen m�chtest";
$in['lang']['button_delete'] = "Ausgew�hlte Dateien l�schen!";

?>
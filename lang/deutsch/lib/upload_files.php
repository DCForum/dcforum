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

$in['lang']['delete_header'] = "Wähle die Anhänge, die du löschen möchtest.";

$in['lang']['delete_attachment_mesg'] = "Die ausgewählten Anhänge wurden gelöscht.<br />
                          Wenn du möchtest, kannst du weitere Anhänge mit dem nachstehenden Formular hochladen.<br />";

$in['lang']['close_this_window'] = "Fenster schliessen";

$in['lang']['didnot_delete_attachement_mesg'] = "Du hast keine Anhänge gelöscht.
                          <br />Bitte benutze das nachstehende Formular, um welche zu löschen.";

$in['lang']['select_file_mesg'] = "Bitte wähle eine Datei zum heraufladen";

$in['lang']['max_file_invalid'] = "Die maximale Dateigröße stimmt nicht.";

$in['lang']['select_file_type_mesg'] = "Bitte wähle einen Dateityp";

$in['lang']['invalid_file_type'] = "Ungültiger Dateityp";

$in['lang']['error_header'] = "Es sind Fehler im Datei-Upload aufgetreten.";

$in['lang']['ok_mesg'] = "Die gewählte Datei wurde erfolgreich heraufgeladen.<br />
                        Die Adresse dieser Datei lautet ";

$in['lang']['upload_failed_mesg'] = "Upload fehlgeschlagen ... die Datei, die du heraufladen wolltest übersetigt das vom Administrator gesetzte Limit. Bitte versuchs nochmal.";

$in['lang']['max_exceeded'] = "Dein Beitrag enthält die maximale Anzahl an Anhängen, die erlaubt ist.";

$in['lang']['max_exceeded_mesg'] = "Die maximale Anzahl an Anhängen, die erlaubt ist wurde überschritten.<br />
                                    Du musst ein oder mehrere Dateien deiner momentanen Anhänge löschen, 
                                    bevor du weitere Dateien heraufladen kannst.";

$in['lang']['select_another'] = "Wenn du weitere Dateien heraufladen möchtest, benutze dafür das folgende Formular. Ansonsten ";


// function uploade_form
$in['lang']['step_1'] = "Schritt 1. Klick auf den 'Durchsuchen...' Button um eine Datei auszuwählen.";

$in['lang']['maximum_size'] = "maximal erlaubte Dateigröße";

$in['lang']['kbytes'] = "KBytes";

$in['lang']['step_2'] = "Schritt 2. Gib den Dateityp deines Anhangs an";

$in['lang']['check_embed'] = "Markiere diese Checkbox, wenn du die Adresse zum Anhang in das Eingabefeld einfügen möchtest.";

$in['lang']['step_3'] = "Schritt 3. Klick auf den 'Heraufladen!' Button um die Aktion abzuschliessen. 
         Der Name der der heraufgeladenen Datei wird automatisch in das Feld für Anhänge eingefügt.";
          
$in['lang']['button_upload'] = "Heraufladen!";
$in['lang']['button_reset'] = "Zurücksetzen";


// fucntion delete_upload_files

$in['lang']['select_file_to_delete'] = "Wähle die Anhänge, die du entfernen möchtest";
$in['lang']['button_delete'] = "Ausgewählte Dateien löschen!";

?>
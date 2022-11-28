<?php
///////////////////////////////////////////////////////////////////////////
//
// faq.php
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
// 	$Id: faq.php,v 1.2 2003/03/28 11:27:14 david Exp $	
//
///////////////////////////////////////////////////////////////////////////

$in['lang']['page_title'] = "Hilfe/FAQs";
$in['lang']['page_header'] = "W�hle aus der Liste der oft gestellten Fragen (FAQs)";

$in['lang']['faq_topic'] = array(
       'gen_faq' => 'Allgemeine Fragen',
       'reg_faq' => 'Fragen zur Registrierung',
       'ico_faq' => 'Fragen zu den Icons',
       'uh_faq' => 'Fragen zum Umgang mit dem Forum',
       'uf_faq' => 'Fragen zu den User-Funktionen'
);

// Please be careful when editing following section
// Only edit text in 'q' and 'a'....the values correspoding
// to 'a' and 'q' are in double quotes.  So, if are going to use " in
// your translation, make sure you escape it (\")

// q and a for general FAQ
//
$in['lang']['gen_faq'] = array(

   '1' => array(

      'q' => "Was ist ein Forum?",

      'a' => "Ein Forum ist eine Sammlung von zusammenh�ngenden Themen. Wenn du ein Forum betrittst, bekommst du eine Liste aktueller Beitr�ge in diesem Forum zu sehen. Jedes Thema enth�lt den Startbeitrag und, falls vorhanden, Antworten darauf. Wenn ein Forum umfangreicher wird, ist es sinnvoll Unterordner anzulegen. Daher kann ein Forum auch weitere Foren enthalten."

         ),

   '2' => array(

      'q' => "Was ist ein Thema?",

      'a' => "Jedes Thema enth�lt einen Startbeitrag und die Antworten darauf. Standardm��ig ist die Darstellung der Beitr�ge vollst�ndig einger�ckt. Unterhalb des Startbeitrags gibt es eine Art Inhaltsverzeichnis, in dem der Diskussionsverlauf dargestellt wird. Falls vom Administrator der linerare Stil eingestellt wurde, werden die Antworten in chronologischer Reihenfolge dargestellt."

	 ),

   '3' => array(

      'q' => "Warum gibt es so viele unterschiedliche Forentypen?",

      'a' => "Es gibt in diesem Forensystem vier Forentypen mit unterschiedlichen Zugriffsberechtigungen: �ffentlich, Gesch�tzt, Eingeschr�nkt und Privat.
              <ul>
              <li> <strong>�ffentliches Forum</strong>: Erfordert keine Registrierung um daran teilzunehmen. Jeder darf Beitr�ge lesen und schreiben.</li>
              <li> <strong>Gesch�tztes Forum</strong>: Diese Foren sind f�r nicht registrierte User nur lesbar. Zum schreiben muss man sich registrieren.</li>
              <li> <strong>Eingeschr�nktes Forum</strong>: Ist nur f�r registrierte User aus einer der User-Gruppen admin, moderator, team oder member aufrufbar.</li>
              <li> <strong>Privates Forum</strong>: F�r die privaten Foren muss man als registrierter User vom Admin manuell freigeschaltet werden.</li>
              </ul>"

         ),

   '4' => array(

      'q' => "Wie bekomme ich Zugriff auf eingeschr�nkte oder private Foren?",

      'a' => "Nur ein Administrator kann dir Zugriff auf die eingeschr�nkten oder privaten Foren geben. Meistens sind daf�r bestimmte Voraussetzungen notwendig, ohne die dir kein Administrator Einblick in die privaten Foren gibt."

       ),

   '5' => array(

      'q' => "Im einen Forum wird ein neuer Beitrag angezeigt, aber in einem anderen Forum nicht. Warum?",

      'a' => "H�chstwahrscheinlich hast du deinen Beitrag in einem moderierten Forum geschrieben. Jedes Forum kann vom Administrator auf 'offen' oder 'moderiert' gesetzt werden. Bei moderierten Foren werden alle neuen Beitr�ge und Antworten in eine Warteschleife gespeichert, damit sie vom Moderator des Forums oder dem Administrator �berpr�ft werden k�nnen. Moderierte Foren erkennt man an den Icons <img src=\"" . IMAGE_URL . "/new_locked_folder.gif\" alt=\"Moderiertes Forum\" align=\"middle\" /> oder <img src=\"" . IMAGE_URL . "/locked_folder.gif\" alt=\"Moderiertes Forum\" align=\"middle\" />"

       )

);


// q and a for registration faq
//
$in['lang']['reg_faq'] = array(

   '1' => array(

      'q' => "Muss ich mich registrieren??",

      'a' => "Die Registrierung h�ngt von den unterschiedlichen Forentypen ab. In <strong>�ffentlichen</strong> Foren k�nnen alle auch ohne Registrierung lesen und schreiben. In <strong>gesch�tzten</strong> Foren k�nnen zwar alle lesen, aber schreiben ist nur f�r registrierte Besucher m�glich. In <strong>eingeschr�nkten</strong> eingeschraenkten Foren k�nnen nur registrierte Besucher mit einem bestimmten Status lesen und schreiben. In <strong>privaten</strong> Foren k�nnen nur registrierte Besucher mit bestimmten Zugriffsrechten lesen und schreiben."
 
	),

   '2' => array(

      'q' => "Warum sollte ich mich registrieren?",

      'a' => " Zus�tzlich zur Teilnahme in nicht-�ffentlichen Foren erm�glicht eine Registrierung noch andere Dinge. Man kann z.B. Foren und Beitr�ge abonnieren, eMails und Inbox nutzen, die Profile der anderen Besucher einsehen, eine Freundesliste erstellen, Notizzettel nutzen, etc. "

	),

   '3' => array(

      'q' => "Wie registriere ich mich?",

      'a' => " Zum Registrieren muss man nur auf den Link <strong>Bitte anmelden</strong> in der Lobby klicken und das Eingabeformular ausf�llen."

	),

    '4' => array(

       'q' => "Bei der Registrierung wurde mir mitgeteilt, dass ich eine falsche eMail-Adresse eingegeben habe. Was bedeutet das?",

       'a' => " Die eMail-Adresse kann ein falschen Format enthalten, richtig w�re z.B. <strong>username@domain.com</strong>. Administratoren k�nnen aus Sicherheitsgr�nden einige Freemail-Adressen ausschliessen, wie z.B. von hotmail oder yahoo."

    )
         
);


// q and a for icon FAQ
//
$in['lang']['ico_faq'] = array(      

   '1' => array(
   
      'q' => "Was kann ich mit den Menu-Icons alles machen?",

      'a' => "Die Icons symbolisieren unterschiedliche Funktionen:<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/login.gif\" alt=\"Login\" align=\"middle\" /> 
              bedeutet, dass man hier zum Eingabeformular zum Einloggen kommt.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/help.gif\" alt=\"Hilfe\" align=\"middle\" /> 
              bedeutet, dass man die Hilfe/FAQs aufrufen kann, die du gerade liest.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/search.gif\" alt=\"Suchen\" align=\"middle\" /> 
              bringt einen zur Suchfunktion.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/read_new.gif\" alt=\"Neue lesen\" align=\"middle\" /> 
              bedeutet, dass alle neuen Beitr�ge seit dem letzten Besuch angezeigt werden k�nnen.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" align=\"middle\" /> 
              ruft das Usermen� auf.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Markieren\" align=\"middle\" /> 
              markiert die Beitr�ge oder Foren der aktuellen Seite als 'gelesen'.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile.gif\" alt=\"Profile\" align=\"middle\" /> 
              f�hrt zu den Userprofilen der registrierten Besucher.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Benutzerbewertung\" align=\"middle\" /> 
              bringt einen zu den User-Beurteilungen, wo man auch selber beurteilen kann. <br />"

    ),

   '2' => array(

      'q' => "Warum haben manche Beitr�ge flammende Icons?",

      'a' => "Flammen signalisieren einen Beitrag mit besonders vielen Antworten.<br />(Kann vom Administrator ausgestellt worden sein)"

    ),

   '3' => array(

      'q' => "Warum zeigen manche Foren-Icons ein Schloss?",

      'a' => " Das ist das Zeichen f�r ein moderiertes Forum. In moderierten Foren m�ssen die Beitr�ge erst durch den Moderator freigegeben werden. Die Beitr�ge werden also nicht sofort ver�ffentlicht."

	),

   '4' => array(

      'q' => "Warum haben manche Themen-Icons ein Schloss?",

      'a' => " Das bedeutet, dass der Beitrag durch den Administrator oder Moderator geschlossen wurde und nur noch gelesen werden kann. Antworten auf diesen Beitrag sind dann nicht mehr m�glich."

      ),

   '5' => array(

      'q' => "Warum steht neben manchen Themen [Alle anzeigen]?",

      'a' => "Themen mit sehr vielen Antworten zeigen automatisch lediglich eine Antwort an, aber mit einer anklickbaren Liste aller Antworten darunter. 
             Klickt man auf <strong>[Alle anzeigen]</strong> wird das komplette Thema inklusive aller Antworten angezeigt."

      ),

   '6' => array(

      'q' => "Was bedeuten all die Icons in den Antworten nahe des Usernamens?",

      'a' => "Die Icons zeigen verschiedene Informationen �ber den User an. Die Sterne bedeuten, dass er an der User-Bewertung teilnimmt. Viele Sterne bedeuten eine hohe Bewertung. <img src=\"" . IMAGE_URL . "/admin_icon.gif\" alt=\"Admin \" /> zeigt an, dass der User auch Administrator ist. <img src=\"" . IMAGE_URL . "/guest.gif\" alt=\"Gast\"> bedeutet, dass der User ein unregistrierter Gast ist."

      ),


   '7' => array(

      'q' => "Was bedeuten all die Icons in der oberen Ecke eines Beitrags, unter dem Datum und der Zeit?",

      'a' => "Diese Icons bedeuten bestimmte bestimmte Funktionen in Bezug auf einzelne User. Durch Klicken auf<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/email.gif\" alt=\"eMail senden\" align=\"middle\" /> 
             kann dem User eine eMail geschickt werden.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg.gif\" alt=\"Private Mitteilung senden\" align=\"middle\" /> 
             kann dem User eine private Nachricht in die Inbox geschrieben werden.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile_small.gif\" alt=\"Profil anschauen\" align=\"middle\" /> 
             kann man das Profil des Users ansehen.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" alt=\"In Freundesliste aufnehmen\" align=\"middle\" /> 
             kann der User auf die eigene Freundesliste gesetzt werden.<br /> "
   )

);


// q and a for user how-to FAQ
//
$in['lang']['uh_faq'] = array(

  '1' => array(

      'q' => "Wie navigiere ich?",

      'a' => "Von der Lobby aus erreicht man jedes Forum oder jede Foren-Gruppe (abh�ngig von der eigenen Foreneinstellung) durch das Klicken auf ein Icon oder den entsprechenden Link rechts von dem Icon. Dasselbe gilt auch f�r Themenseiten.<br /> 
              Wenn man auf einer Themen-Seite ist, genauer gesagt auf der Seite mit den aktuellen Beitr�gen, dann sieht man dort <strong>Vorheriges Thema | N�chstes Thema</strong> �ber dem obersten Beitrag, auf der rechten Seite.<br />
              Diese Links erm�glichen einen, in den Themen vor- und zur�ckzubl�ttern.<br /> 
              Unter dem letzten Beitr�g zu einem Thema, kann man folgende Links sehen: <br /> 
              <strong>Forenlobby | Foren | Themen | Vorheriges Thema | N�chstes Thema</strong>.
              Durch das Klicken auf <strong>Forenlobby</strong> kommt man auf die Seite, in der alle Forengruppen aufgelistet sind. 
              Mit Klick auf <strong>Foren</strong> gelangt man zur Auflistung der Foren.<br /> 
              Der Link <strong>Themen</strong> bringt einen zu der Seite, auf der die Beitr�ge eines Forums aufgelistet sind.<br /> 
              Mit <strong>Vorheriger Beitrag | N�chster Beitrag</strong> kann man innerhalb der Beitr�ge vor- und zur�ckbl�ttern.<br /> 
               Man kann ebenfalls durch das Klicken auf <strong>Forenlobby -> Forum -> Thema</strong> in Leiste unterhalb der Icons navigieren (2. Tabellenzeile von oben)."

      ),
 
   '2' => array(

      'q' => "Wie beginne ich ein neues Thema?",

      'a' => " Auf der Themenseite, durch Klicken auf <img src=\"" . IMAGE_URL . "/post.gif\" alt=\"Neuer Beitrag\" /> <strong>Neuer Beitrag</strong>."

      ),

  '3' => array(

     'q' => "Wie starte ich eine neue Abstimmung?",

     'a' => " Auf der Themenseite, durch Klicken auf <img src=\"" . IMAGE_URL . "/poll.gif\" alt=\"Neue Abstimmung\" /> <strong>Neue Abstimmung</strong> und Eingeben der Frage und bis zu sechs Antwortm�glichkeiten. Dann einfach das Formular absenden."
      ),

   '4' => array(

      'q' => "Wie antworte ich auf einen Beitrag?",

      'a' => " Jeder Beitrag in einem Thema enth�lt <strong>Antworten | Mit Zitat antworten</strong>. 'Antworten mit Zitat' bedeutet, dass der Text des Beitrags, auf den geantwortet werden soll, in den eigenen Beitrag mit �bernommen wird."

   ),

   '5' => array(

      'q' => "Wie verfolge ich neue Nachrichten?",

      'a' => " Man kan entweder manuel oder durch einen Cookie auf neue Beitr�ge seit dem letzten Besuch aufmerksam gemacht werden. In den <strong>Voreinstellungen</strong> kann das festgelegt werden. W�hlt man ja aus f�r <strong>Manuelle Markierungsfunktion nutzen?</strong>, , k�nnen die neuen Beitr�ge manuell (durch Klicken auf <img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Markieren\"> auf der Themenseite) als gelesen markiert werden. Wenn man dann das n�chste Mal das Forum besucht, werden nur die Beitr�ge als neu angezeigt, die nach dem Markieren geschrieben wurden. Erkennen kann man das an den farbigen Icons. Falls die Markierungs-Option nicht genutzt wird, werden automatisch die neuesten Beitr�ge durch die farbigen Icons seit dem letzten Besuch des Forums angezeigt."

      ),

   '6' => array(

      'q' => "Wie kann ich meine Zugangsdaten �ndern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong>  kommt man in das Usermen�."

   ),

   '7' => array(

      'q' => "Wie kann ich mein Passwort �ndern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /> <strong>Usermen� </strong> -> <strong>Passwort �ndern</strong>"
      ),

  '8' => array(

      'q' => "Wie kann ich mein Profil bearbeiten?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /> <strong>Usermen� </strong> -> <strong>Profil bearbeiten</strong>"
   ),

  '9' => array(

      'q' => "Wie kann ich meine Foren-Voreinstellungen �ndern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /> <strong>Usermen� </strong> -> <strong>Einstellungen �ndern</strong>"

   ),

  '10' => array(

	'q' => "Wie kann ich Foren abonnieren?",

        'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong> Usermen� </strong> -> <strong>Foren-Abonnements</strong>. Dort k�nnen die gew�nschten Foren markiert werden."
		
   ),

   '11' => array(

       'q' => "Wie verwalte ich die Themen-Abonnements?",

       'a' => " Um Themen zu abonnieren, klickt man auf <img src=\"" . IMAGE_URL . "/subscribe_thread.gif\" alt=\"Thema abonnieren\" align=\"middle\" /> in der oberen Reihe der Beitragsseite. Man kann ebenfalls ein Thema abonnieren, in dem man bei <strong>Dieses Thema abonnieren. Du erh�lst dann eine eMail, wenn eine neue Antwort eingetragen wurde.</strong> im Antwortformular ein H�kchen macht. Um Themen wieder von der Abonnementsliste zu entfernen, kann man im <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong> -> <strong>Themen-Abonnements</strong> alle die Themen markieren, die von der Liste wieder gel�scht werden sollen."

       ),

   '12' =>array(

      'q' => "Wie kann ich mein Profil verbergen oder die eMail-Funktion deaktivieren?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong> -> <strong>Einstellung �ndern</strong>. 'Ja' ausw�hlen bei <strong>Profil verbergen?</strong> und 'Ja ' bei <strong>Anderen registrierten Usern erlauben, dir eMails zu schicken??</strong>"

   ),

   '13' =>array(

      'q' => "Wie kann ich eine Avatar-Grafik in meinen Beitr�gen einsetzen?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong> -> <strong>Profil bearbeiten</strong>. Es gibt einige Avatars (User-Grafiken), die durch das Klicken auf <strong>Vorhandene Grafiken</strong> ausgew�hlt werden k�nnen. Um ein eigenes zu nutzen, braucht man nur die URL der entsprechenden Grafik in die Textbox schreiben. <strong>Spezielle HTML-Befehle (img) sind nicht n�tig</strong>, einfach nur die URL."

   ),

   '14' =>array(

      'q' => "Wie kann ich Signaturen in meinen Beitr�gen nutzen?",

      'a' => "Durch Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong>> -> <strong>Profil bearbeiten</strong>. Dort gibt es ein Textfeld f�r die Signatur."
   ),

   '15' => array(

      'q' => "Wie benutze ich HTML-Tags in meinen Beitr�gen?",

      'a' => " Anstelle von spitzen Klammern < > nutzt man einfach eckige Klammern [ ] in den Beitr�gen. Der Administrator kann diese Funktion allerdings deaktivieren."

   ),

   '16' => array(

      'q' => "Wie kann ich Grafiken einf�gen?",

      'a' => " Man kann ebenfalls die URL einer Grafik (z.B. http://www.deindomain.de/images/grafik.gif) in den Beitrag setzen. Oder eine Grafik auf den Server laden (diese Funktion kann vom Administrator deaktiviert werden) durch das Klicken auf <strong>Hier klicken um Anhang auszuw�hlen</strong> im Eingabeformular. Dadurch wird ein neues Fenster ge�ffnet, in dem man die gew�schte Datei zum Upload ausw�hlen kann. Wenn die Datei markiert wurde, wird sie automatisch in die Textbox im Eingabeformular �bertragen. Alle Dateien werden dabei umbenannt. Bitte nicht vergessen, dass es ein Limit bei der Dateigr�sse gibt."
   ),

   '17' => array(

      'q' => "Wie nutze ich HTML-Links?",

      'a' => " HTML-Links werden durch einfaches Schreiben der kompletten URL in eine Nachricht gesetzt, so etwa in der Art wie zB http://www.spiegel.de "

   )

);


// q and a for user functions FAQ
//
$in['lang']['uf_faq'] = array(

   '1' => array(

      'q' => "Was ist ein Abonnement?",

      'a' => "Bei einem Abonnement bekommt man eine eMail sobald neue Antworten oder Themen geschrieben wurden."
        
       ),

   '2' => array(

      'q' => "Was ist eine Inbox?",

      'a' => "Die Inbox ist ein Ordner f�r private Mitteilungen innerhalb des Forensystems f�r registrierte Besucher."

    ),

   '3' => array(

      'q' => "Was ist ein Lesezeichen?",

      'a' => "Ein Lesezeichen ist vergleichbar mit den Bookmarks eines Browsers. Es erm�glicht einem, sich ein bestimmtes Thema zu merken, um es sp�ter zu lesen."

    ),

   '4' =>array(

      'q' => "Was ist eine Freundesliste?",

      'a' => "Das ist eine pers�nliche Kontaktliste mit registrierten Usern, die einem schnellen Zugang zu eMail, Inbox, ICQ, und den Profilen erm�glicht "

      ),

   '5' => array(

      'q' => "Was ist ein Notizzettel?",

      'a' => "Das ist eine einfach Notizm�glichkeit."

   ),

   '6' => array(

      'q' => "Was ist ein Themen-Bewertungssystem?",

      'a' => "Damit k�nnen User die Qualit�t von Themen bewerten."

      ),

   '7' => array(

      'q' => "Wie kann ich ein Thema bewerten?",

      'a' => "In der unteren rechten Ecke einer Beitragsseite kann man auf <img src=\"" . IMAGE_URL . "/topic_rating.gif\" alt=\"Thema bewerten\" /> <strong>Thema bewerten</strong> klicken, falls der Administrator diese Funktion nicht deaktiviert hat."

   ),

   '8' => array(

      'q' => "Was ist das User-Bewertungssystem?",

      'a' => "Es erm�glicht Usern die Bewertung von anderen Usern, und wie diese sich im Forensystem eingebracht haben, falls der Administrator diese Funktion nicht deaktiviert hat."

      ),

   '9' => array(

      'q' => "Wie kann ich daran teilnehmen? Muss ich daran teilnehmen?",

      'a' => "Es liegt an jedem selber, ob er daran teilnehmen m�chte. In den Voreinstellungen kann das jeder selber festlegen. Klick auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermen�\" /><strong>Usermen� </strong>  -> <strong>Einstellungen �ndern</strong> und dann <strong>yes/Ja</strong> oder <strong>no/Nein</strong> ausw�hlen bei <strong>An der Userbewertung teilnehmen?</strong>"

      ),

   '10' => array(

      'q' => "Wie bewerte ich andere User?",

      'a' => "Es gibt verschiedene M�glichkeiten. Man kann auf <strong>User bewerten</strong> klicken oder den <strong>xx Punkte</strong>-Link neben dem Usernamen in jedem Beitrag. Bei Klick auf <strong>User bewerten</strong>. �ffnet sich ein neues Fenster, dass das Eingabeformular f�r die Bewertung enth�hlt.<br />Eine andere M�glichkeit ist, auf <img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Userbewertung\" align=\"middle\" /> <strong>Userbewertung</strong> zu klicken, wodurch man auf eine Seite kommt, in der alle User aufgelistet sind, die am Bewertungssystem teilnehmen. Die Usernamen sind alphabethisch sortiert. Durch das Klicken auf einen Buchstaben, kommt man zu einer Auflistung der User, die mit diesem Buchstaben beginnen. Durch Klicken auf einen Usernamen kommt man auf eine Seite mit der bisherigen �bersicht aller Bewertungen dieses Users. Man kann auf <strong>User bewerten</strong> klicken, um ein neues Fenster mit dem Bewertungsformular zu �ffnen. ."

     )

);



   

?>

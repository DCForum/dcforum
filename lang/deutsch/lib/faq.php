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
$in['lang']['page_header'] = "Wähle aus der Liste der oft gestellten Fragen (FAQs)";

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

      'a' => "Ein Forum ist eine Sammlung von zusammenhängenden Themen. Wenn du ein Forum betrittst, bekommst du eine Liste aktueller Beiträge in diesem Forum zu sehen. Jedes Thema enthält den Startbeitrag und, falls vorhanden, Antworten darauf. Wenn ein Forum umfangreicher wird, ist es sinnvoll Unterordner anzulegen. Daher kann ein Forum auch weitere Foren enthalten."

         ),

   '2' => array(

      'q' => "Was ist ein Thema?",

      'a' => "Jedes Thema enthält einen Startbeitrag und die Antworten darauf. Standardmäßig ist die Darstellung der Beiträge vollständig eingerückt. Unterhalb des Startbeitrags gibt es eine Art Inhaltsverzeichnis, in dem der Diskussionsverlauf dargestellt wird. Falls vom Administrator der linerare Stil eingestellt wurde, werden die Antworten in chronologischer Reihenfolge dargestellt."

	 ),

   '3' => array(

      'q' => "Warum gibt es so viele unterschiedliche Forentypen?",

      'a' => "Es gibt in diesem Forensystem vier Forentypen mit unterschiedlichen Zugriffsberechtigungen: Öffentlich, Geschützt, Eingeschränkt und Privat.
              <ul>
              <li> <strong>Öffentliches Forum</strong>: Erfordert keine Registrierung um daran teilzunehmen. Jeder darf Beiträge lesen und schreiben.</li>
              <li> <strong>Geschütztes Forum</strong>: Diese Foren sind für nicht registrierte User nur lesbar. Zum schreiben muss man sich registrieren.</li>
              <li> <strong>Eingeschränktes Forum</strong>: Ist nur für registrierte User aus einer der User-Gruppen admin, moderator, team oder member aufrufbar.</li>
              <li> <strong>Privates Forum</strong>: Für die privaten Foren muss man als registrierter User vom Admin manuell freigeschaltet werden.</li>
              </ul>"

         ),

   '4' => array(

      'q' => "Wie bekomme ich Zugriff auf eingeschränkte oder private Foren?",

      'a' => "Nur ein Administrator kann dir Zugriff auf die eingeschränkten oder privaten Foren geben. Meistens sind dafür bestimmte Voraussetzungen notwendig, ohne die dir kein Administrator Einblick in die privaten Foren gibt."

       ),

   '5' => array(

      'q' => "Im einen Forum wird ein neuer Beitrag angezeigt, aber in einem anderen Forum nicht. Warum?",

      'a' => "Höchstwahrscheinlich hast du deinen Beitrag in einem moderierten Forum geschrieben. Jedes Forum kann vom Administrator auf 'offen' oder 'moderiert' gesetzt werden. Bei moderierten Foren werden alle neuen Beiträge und Antworten in eine Warteschleife gespeichert, damit sie vom Moderator des Forums oder dem Administrator überprüft werden können. Moderierte Foren erkennt man an den Icons <img src=\"" . IMAGE_URL . "/new_locked_folder.gif\" alt=\"Moderiertes Forum\" align=\"middle\" /> oder <img src=\"" . IMAGE_URL . "/locked_folder.gif\" alt=\"Moderiertes Forum\" align=\"middle\" />"

       )

);


// q and a for registration faq
//
$in['lang']['reg_faq'] = array(

   '1' => array(

      'q' => "Muss ich mich registrieren??",

      'a' => "Die Registrierung hängt von den unterschiedlichen Forentypen ab. In <strong>öffentlichen</strong> Foren können alle auch ohne Registrierung lesen und schreiben. In <strong>geschützten</strong> Foren können zwar alle lesen, aber schreiben ist nur für registrierte Besucher möglich. In <strong>eingeschränkten</strong> eingeschraenkten Foren können nur registrierte Besucher mit einem bestimmten Status lesen und schreiben. In <strong>privaten</strong> Foren können nur registrierte Besucher mit bestimmten Zugriffsrechten lesen und schreiben."
 
	),

   '2' => array(

      'q' => "Warum sollte ich mich registrieren?",

      'a' => " Zusätzlich zur Teilnahme in nicht-öffentlichen Foren ermöglicht eine Registrierung noch andere Dinge. Man kann z.B. Foren und Beiträge abonnieren, eMails und Inbox nutzen, die Profile der anderen Besucher einsehen, eine Freundesliste erstellen, Notizzettel nutzen, etc. "

	),

   '3' => array(

      'q' => "Wie registriere ich mich?",

      'a' => " Zum Registrieren muss man nur auf den Link <strong>Bitte anmelden</strong> in der Lobby klicken und das Eingabeformular ausfüllen."

	),

    '4' => array(

       'q' => "Bei der Registrierung wurde mir mitgeteilt, dass ich eine falsche eMail-Adresse eingegeben habe. Was bedeutet das?",

       'a' => " Die eMail-Adresse kann ein falschen Format enthalten, richtig wäre z.B. <strong>username@domain.com</strong>. Administratoren können aus Sicherheitsgründen einige Freemail-Adressen ausschliessen, wie z.B. von hotmail oder yahoo."

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
              bedeutet, dass alle neuen Beiträge seit dem letzten Besuch angezeigt werden können.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" align=\"middle\" /> 
              ruft das Usermenü auf.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Markieren\" align=\"middle\" /> 
              markiert die Beiträge oder Foren der aktuellen Seite als 'gelesen'.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile.gif\" alt=\"Profile\" align=\"middle\" /> 
              führt zu den Userprofilen der registrierten Besucher.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Benutzerbewertung\" align=\"middle\" /> 
              bringt einen zu den User-Beurteilungen, wo man auch selber beurteilen kann. <br />"

    ),

   '2' => array(

      'q' => "Warum haben manche Beiträge flammende Icons?",

      'a' => "Flammen signalisieren einen Beitrag mit besonders vielen Antworten.<br />(Kann vom Administrator ausgestellt worden sein)"

    ),

   '3' => array(

      'q' => "Warum zeigen manche Foren-Icons ein Schloss?",

      'a' => " Das ist das Zeichen für ein moderiertes Forum. In moderierten Foren müssen die Beiträge erst durch den Moderator freigegeben werden. Die Beiträge werden also nicht sofort veröffentlicht."

	),

   '4' => array(

      'q' => "Warum haben manche Themen-Icons ein Schloss?",

      'a' => " Das bedeutet, dass der Beitrag durch den Administrator oder Moderator geschlossen wurde und nur noch gelesen werden kann. Antworten auf diesen Beitrag sind dann nicht mehr möglich."

      ),

   '5' => array(

      'q' => "Warum steht neben manchen Themen [Alle anzeigen]?",

      'a' => "Themen mit sehr vielen Antworten zeigen automatisch lediglich eine Antwort an, aber mit einer anklickbaren Liste aller Antworten darunter. 
             Klickt man auf <strong>[Alle anzeigen]</strong> wird das komplette Thema inklusive aller Antworten angezeigt."

      ),

   '6' => array(

      'q' => "Was bedeuten all die Icons in den Antworten nahe des Usernamens?",

      'a' => "Die Icons zeigen verschiedene Informationen über den User an. Die Sterne bedeuten, dass er an der User-Bewertung teilnimmt. Viele Sterne bedeuten eine hohe Bewertung. <img src=\"" . IMAGE_URL . "/admin_icon.gif\" alt=\"Admin \" /> zeigt an, dass der User auch Administrator ist. <img src=\"" . IMAGE_URL . "/guest.gif\" alt=\"Gast\"> bedeutet, dass der User ein unregistrierter Gast ist."

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

      'a' => "Von der Lobby aus erreicht man jedes Forum oder jede Foren-Gruppe (abhängig von der eigenen Foreneinstellung) durch das Klicken auf ein Icon oder den entsprechenden Link rechts von dem Icon. Dasselbe gilt auch für Themenseiten.<br /> 
              Wenn man auf einer Themen-Seite ist, genauer gesagt auf der Seite mit den aktuellen Beiträgen, dann sieht man dort <strong>Vorheriges Thema | Nächstes Thema</strong> über dem obersten Beitrag, auf der rechten Seite.<br />
              Diese Links ermöglichen einen, in den Themen vor- und zurückzublättern.<br /> 
              Unter dem letzten Beiträg zu einem Thema, kann man folgende Links sehen: <br /> 
              <strong>Forenlobby | Foren | Themen | Vorheriges Thema | Nächstes Thema</strong>.
              Durch das Klicken auf <strong>Forenlobby</strong> kommt man auf die Seite, in der alle Forengruppen aufgelistet sind. 
              Mit Klick auf <strong>Foren</strong> gelangt man zur Auflistung der Foren.<br /> 
              Der Link <strong>Themen</strong> bringt einen zu der Seite, auf der die Beiträge eines Forums aufgelistet sind.<br /> 
              Mit <strong>Vorheriger Beitrag | Nächster Beitrag</strong> kann man innerhalb der Beiträge vor- und zurückblättern.<br /> 
               Man kann ebenfalls durch das Klicken auf <strong>Forenlobby -> Forum -> Thema</strong> in Leiste unterhalb der Icons navigieren (2. Tabellenzeile von oben)."

      ),
 
   '2' => array(

      'q' => "Wie beginne ich ein neues Thema?",

      'a' => " Auf der Themenseite, durch Klicken auf <img src=\"" . IMAGE_URL . "/post.gif\" alt=\"Neuer Beitrag\" /> <strong>Neuer Beitrag</strong>."

      ),

  '3' => array(

     'q' => "Wie starte ich eine neue Abstimmung?",

     'a' => " Auf der Themenseite, durch Klicken auf <img src=\"" . IMAGE_URL . "/poll.gif\" alt=\"Neue Abstimmung\" /> <strong>Neue Abstimmung</strong> und Eingeben der Frage und bis zu sechs Antwortmöglichkeiten. Dann einfach das Formular absenden."
      ),

   '4' => array(

      'q' => "Wie antworte ich auf einen Beitrag?",

      'a' => " Jeder Beitrag in einem Thema enthält <strong>Antworten | Mit Zitat antworten</strong>. 'Antworten mit Zitat' bedeutet, dass der Text des Beitrags, auf den geantwortet werden soll, in den eigenen Beitrag mit übernommen wird."

   ),

   '5' => array(

      'q' => "Wie verfolge ich neue Nachrichten?",

      'a' => " Man kan entweder manuel oder durch einen Cookie auf neue Beiträge seit dem letzten Besuch aufmerksam gemacht werden. In den <strong>Voreinstellungen</strong> kann das festgelegt werden. Wählt man ja aus für <strong>Manuelle Markierungsfunktion nutzen?</strong>, , können die neuen Beiträge manuell (durch Klicken auf <img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Markieren\"> auf der Themenseite) als gelesen markiert werden. Wenn man dann das nächste Mal das Forum besucht, werden nur die Beiträge als neu angezeigt, die nach dem Markieren geschrieben wurden. Erkennen kann man das an den farbigen Icons. Falls die Markierungs-Option nicht genutzt wird, werden automatisch die neuesten Beiträge durch die farbigen Icons seit dem letzten Besuch des Forums angezeigt."

      ),

   '6' => array(

      'q' => "Wie kann ich meine Zugangsdaten ändern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong>  kommt man in das Usermenü."

   ),

   '7' => array(

      'q' => "Wie kann ich mein Passwort ändern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /> <strong>Usermenü </strong> -> <strong>Passwort ändern</strong>"
      ),

  '8' => array(

      'q' => "Wie kann ich mein Profil bearbeiten?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /> <strong>Usermenü </strong> -> <strong>Profil bearbeiten</strong>"
   ),

  '9' => array(

      'q' => "Wie kann ich meine Foren-Voreinstellungen ändern?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /> <strong>Usermenü </strong> -> <strong>Einstellungen ändern</strong>"

   ),

  '10' => array(

	'q' => "Wie kann ich Foren abonnieren?",

        'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong> Usermenü </strong> -> <strong>Foren-Abonnements</strong>. Dort können die gewünschten Foren markiert werden."
		
   ),

   '11' => array(

       'q' => "Wie verwalte ich die Themen-Abonnements?",

       'a' => " Um Themen zu abonnieren, klickt man auf <img src=\"" . IMAGE_URL . "/subscribe_thread.gif\" alt=\"Thema abonnieren\" align=\"middle\" /> in der oberen Reihe der Beitragsseite. Man kann ebenfalls ein Thema abonnieren, in dem man bei <strong>Dieses Thema abonnieren. Du erhälst dann eine eMail, wenn eine neue Antwort eingetragen wurde.</strong> im Antwortformular ein Häkchen macht. Um Themen wieder von der Abonnementsliste zu entfernen, kann man im <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong> -> <strong>Themen-Abonnements</strong> alle die Themen markieren, die von der Liste wieder gelöscht werden sollen."

       ),

   '12' =>array(

      'q' => "Wie kann ich mein Profil verbergen oder die eMail-Funktion deaktivieren?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong> -> <strong>Einstellung ändern</strong>. 'Ja' auswählen bei <strong>Profil verbergen?</strong> und 'Ja ' bei <strong>Anderen registrierten Usern erlauben, dir eMails zu schicken??</strong>"

   ),

   '13' =>array(

      'q' => "Wie kann ich eine Avatar-Grafik in meinen Beiträgen einsetzen?",

      'a' => "Durch das Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong> -> <strong>Profil bearbeiten</strong>. Es gibt einige Avatars (User-Grafiken), die durch das Klicken auf <strong>Vorhandene Grafiken</strong> ausgewählt werden können. Um ein eigenes zu nutzen, braucht man nur die URL der entsprechenden Grafik in die Textbox schreiben. <strong>Spezielle HTML-Befehle (img) sind nicht nötig</strong>, einfach nur die URL."

   ),

   '14' =>array(

      'q' => "Wie kann ich Signaturen in meinen Beiträgen nutzen?",

      'a' => "Durch Klicken auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong>> -> <strong>Profil bearbeiten</strong>. Dort gibt es ein Textfeld für die Signatur."
   ),

   '15' => array(

      'q' => "Wie benutze ich HTML-Tags in meinen Beiträgen?",

      'a' => " Anstelle von spitzen Klammern < > nutzt man einfach eckige Klammern [ ] in den Beiträgen. Der Administrator kann diese Funktion allerdings deaktivieren."

   ),

   '16' => array(

      'q' => "Wie kann ich Grafiken einfügen?",

      'a' => " Man kann ebenfalls die URL einer Grafik (z.B. http://www.deindomain.de/images/grafik.gif) in den Beitrag setzen. Oder eine Grafik auf den Server laden (diese Funktion kann vom Administrator deaktiviert werden) durch das Klicken auf <strong>Hier klicken um Anhang auszuwählen</strong> im Eingabeformular. Dadurch wird ein neues Fenster geöffnet, in dem man die gewüschte Datei zum Upload auswählen kann. Wenn die Datei markiert wurde, wird sie automatisch in die Textbox im Eingabeformular übertragen. Alle Dateien werden dabei umbenannt. Bitte nicht vergessen, dass es ein Limit bei der Dateigrösse gibt."
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

      'a' => "Die Inbox ist ein Ordner für private Mitteilungen innerhalb des Forensystems für registrierte Besucher."

    ),

   '3' => array(

      'q' => "Was ist ein Lesezeichen?",

      'a' => "Ein Lesezeichen ist vergleichbar mit den Bookmarks eines Browsers. Es ermöglicht einem, sich ein bestimmtes Thema zu merken, um es später zu lesen."

    ),

   '4' =>array(

      'q' => "Was ist eine Freundesliste?",

      'a' => "Das ist eine persönliche Kontaktliste mit registrierten Usern, die einem schnellen Zugang zu eMail, Inbox, ICQ, und den Profilen ermöglicht "

      ),

   '5' => array(

      'q' => "Was ist ein Notizzettel?",

      'a' => "Das ist eine einfach Notizmöglichkeit."

   ),

   '6' => array(

      'q' => "Was ist ein Themen-Bewertungssystem?",

      'a' => "Damit können User die Qualität von Themen bewerten."

      ),

   '7' => array(

      'q' => "Wie kann ich ein Thema bewerten?",

      'a' => "In der unteren rechten Ecke einer Beitragsseite kann man auf <img src=\"" . IMAGE_URL . "/topic_rating.gif\" alt=\"Thema bewerten\" /> <strong>Thema bewerten</strong> klicken, falls der Administrator diese Funktion nicht deaktiviert hat."

   ),

   '8' => array(

      'q' => "Was ist das User-Bewertungssystem?",

      'a' => "Es ermöglicht Usern die Bewertung von anderen Usern, und wie diese sich im Forensystem eingebracht haben, falls der Administrator diese Funktion nicht deaktiviert hat."

      ),

   '9' => array(

      'q' => "Wie kann ich daran teilnehmen? Muss ich daran teilnehmen?",

      'a' => "Es liegt an jedem selber, ob er daran teilnehmen möchte. In den Voreinstellungen kann das jeder selber festlegen. Klick auf <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Usermenü\" /><strong>Usermenü </strong>  -> <strong>Einstellungen ändern</strong> und dann <strong>yes/Ja</strong> oder <strong>no/Nein</strong> auswählen bei <strong>An der Userbewertung teilnehmen?</strong>"

      ),

   '10' => array(

      'q' => "Wie bewerte ich andere User?",

      'a' => "Es gibt verschiedene Möglichkeiten. Man kann auf <strong>User bewerten</strong> klicken oder den <strong>xx Punkte</strong>-Link neben dem Usernamen in jedem Beitrag. Bei Klick auf <strong>User bewerten</strong>. öffnet sich ein neues Fenster, dass das Eingabeformular für die Bewertung enthählt.<br />Eine andere Möglichkeit ist, auf <img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Userbewertung\" align=\"middle\" /> <strong>Userbewertung</strong> zu klicken, wodurch man auf eine Seite kommt, in der alle User aufgelistet sind, die am Bewertungssystem teilnehmen. Die Usernamen sind alphabethisch sortiert. Durch das Klicken auf einen Buchstaben, kommt man zu einer Auflistung der User, die mit diesem Buchstaben beginnen. Durch Klicken auf einen Usernamen kommt man auf eine Seite mit der bisherigen Übersicht aller Bewertungen dieses Users. Man kann auf <strong>User bewerten</strong> klicken, um ein neues Fenster mit dem Bewertungsformular zu öffnen. ."

     )

);



   

?>

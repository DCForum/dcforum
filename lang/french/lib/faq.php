<?php
///////////////////////////////////////////////////////////////////////////
//
// faq.php
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
// 	$Id: faq.php,v 1.1 2003/04/14 08:56:30 david Exp $	
//
///////////////////////////////////////////////////////////////////////////


$in['lang']['page_title'] = "Aide"; //"FAQ";
$in['lang']['page_header'] = "Page d'aide du forum"; //"Select from following list of FAQs";


$in['lang']['faq_topic'] = array(
       'gen_faq' => 'Aide : Information g&eacute;n&eacute;rale', //General FAQ
       'reg_faq' => 'Aide : Inscription', //Registration FAQ
       'ico_faq' => 'Aide : Icônes', //Icons FAQ
       'uh_faq' => 'Aide : Utilisation du forum', //User How-to FAQ
       'uf_faq' => 'Aide :  Fonctions interactives' //User Functions FAQ
);

// Please be careful when editing following section
// Only edit text in 'q' and 'a'....the values correspoding
// to 'a' and 'q' are in double quotes.  So, if are going to use " in
// your translation, make sure you escape it (\")

// q and a for general FAQ
//
$in['lang']['gen_faq'] = array(

   '1' => array(

      'q' => "Que veut dire le mot forum?", //What is a forum?,

      'a' => "Un forum r&eacute;unit toutes les discussions sur plusieurs th&egrave;mes.
             Ainsi, quand on entre sur un forum, on voit toutes les discussions (messages).
             Chaque discussion contient le message d'origine et les r&eacute;ponses &agrave; ce message, s'il y a lieu."
             //Forum is a collection of related topics. When you 
             // enter a forum, you will see a listing of current topics in that forum. Each topic contains 
             // the original message and, if applicable, replies to that message.  As a forum grows, it may
             // be better organized if there were sub-folders.  Therefore, a forum can also
             // contain additional forums as well.
         ),

   '2' => array(

      'q' => "Que veut dire le mot discussion/sujet?", //"What is a thread/topic?",

      'a' => "Discussion est synonyme de sujet de discussion. Chaque discussion contient un 
              message d'origine et les r&eacute;ponses &agrave; ce message. Par d&eacute;faut, les discussions sont pr&eacute;sent&eacute;es 
              en mode discussions. Si l'option d'affichage lin&eacute;aire est choisie par l'administrateur,
              les messages et r&eacute;ponses seront pr&eacute;sent&eacute;s par ordre chronologique."
              //"Thread is another word for topic. Each thread contains one 
              //original message and replies to that message. The default thread display mode is 
              //fully-threaded. There is a table of content below the original message which shows 
              //you the flow of discussion. If the linear style option is chosen by the 
              //administrator, the thread will display the replies in chronological order."

	 ),

   '3' => array(

      'q' => "Pourquoi tant de forums diff&eacute;rents?", //"Why are there so many different types of forums?",


      'a' => "Il y a quatre types de forums, chacun varie selon son degr&eacute; d'acc&egrave;s: 
              Public, Prot&eacute;g&eacute;, Exclusif et Priv&eacute;.
              <ul>
              <li> <strong>Forum public</strong>: Le Forum public est accessible &agrave; tous 
              sans restriction pour lire ou poster un message.</li>
              <li> <strong>Forum prot&eacute;g&eacute;</strong>: Seuls les membres inscrits peuvent poster un message.
              Cependant, les visiteurs non-inscrits peuvent lire les messages.</li>
              <li> <strong>Forum exclusif</strong>: Seuls les membres inscrits appartenant aux groupes 
              suivants ont acc&egrave;s &agrave; ce type de forum: admin, mod&eacute;rateur, &eacute;quipe et membre.</li>
              <li> <strong>Forum priv&eacute;</strong>: Ce type de forum est accessible seulement aux membres 
              inscrits qui ont reçu une autorisation sp&eacute;ciale de l'administrateur.</li>
              </ul>"
              
              //"There are four types of forums, each with varying degree of access control: 
              //Public, Protected, Restricted, and Private.
              //<ul>
              //<li> <strong>Public Forum</strong>: Public forum does not require prior 
              //registration for the user to particiapate. 
              //It is read and post for everyone.</li>
              //<li> <strong>Protected Forum</strong>: Protected forum is read-only 
              //for non-registered members. The user must be registered and logged on to post.</li>
              //<li> <strong>Restricted Forum</strong>: Restricted forum is only accessible 
              //by registered members in following user groups: admin, moderator, team, and member.</li>
              //<li> <strong>Private Forum</strong>: Private forum is only accessible by registered 
              //members with access privilege manually granted by the administrator.</li>
              //</ul>"


         ),

   '4' => array(

      'q' => "Comment acc&eacute;der aux forums exclusifs et priv&eacute;s?", //"How do I get access to restricted and private forums?",

      'a' => "Seul l'administrateur peut vous donner acc&egrave;s aux forums exclusifs et priv&eacute;s.
              Une fois votre inscription compl&eacute;t&eacute;e, contactez l'admin pour obtenir l'acc&egrave;s &agrave; ce type de forums."
              //"Only the administrator 
              //can grant you access to restricted and 
              //private forums. Contact your administrator and request access 
              //to these restricted and private forums."

       ),

   '5' => array(

      'q' => "Quand je poste un message dans un forum, ça fonctionne, mais, je ne peux pas poster dans un autre forum. Pourquoi?",
             //"When I post a message in one forum, it posts ok. But in another forum, it won't post.  Why?",


      'a' => "Vous avez probablement post&eacute; dans un forum mod&eacute;r&eacute;. Chaque forum peut &ecirc;tre 'public' et 'mod&eacute;r&eacute;' par l'admin.
              Si le forum est mod&eacute;r&eacute;, les messages doivent &ecirc;tre au pr&eacute;alable approuv&eacute;s manuellement par l'admin ou le mod&eacute;rateur. 
              Les forums mod&eacute;r&eacute;s sont indiqu&eacute;s par l'icône <img src=\"" . 
              IMAGE_URL . "/new_locked_folder.gif\" alt=\"forum mod&eacute;r&eacute;\" align=\"middle\" /> ou
              <img src=\"" . IMAGE_URL . "/locked_folder.gif\" alt=\"forum mod&eacute;r&eacute;\" align=\"middle\" />"
             //"Most likely, you are posting to a moderated forum. Any forum can be set to 'open' or 'moderated' mode 
             // by the administrator. Enabling moderation on a forum will force all messages 
             // into a queue to be reviewed by the administrator or the moderator. 
             // Moderated forums are indicated by <img src=\"" . 
             // IMAGE_URL . "/new_locked_folder.gif\" alt=\"moderated forum\" align=\"middle\" /> or
             // <img src=\"" . IMAGE_URL . "/locked_folder.gif\" alt=\"moderated forum\" align=\"middle\" />"


       )

);


// q and a for registration faq
//
$in['lang']['reg_faq'] = array(

   '1' => array(

      'q' => "Dois-je m'inscrire?", //"Do I have to register?",


      'a' => "L'inscription est optionnelle ou obligatoire selon le type de forum.
              <strong>Public</strong> forum public ouvert &agrave; tous pour lire et poster des messages.
	      <strong>Prot&eacute;g&eacute;</strong> lecture accessible pour tous, inscription obligatoire pour poster des messages. 
              <strong>Exclusif</strong> seuls les membres inscrits autoris&eacute;s peuvent lire et poster. 
              <strong>Priv&eacute;</strong> seuls les membres inscrits ayant un acc&egrave;s privil&eacute;gi&eacute; autoris&eacute; par l'admin
              peuvent lire et poster."
 
             //"Registration may be optional depending on the forum type.
             // <strong>Public</strong> forums are open for read and post to everyone.
	     // <strong>Protected</strong> is open for read to everyone, post for registered. 
             // <strong>Restricted</strong> requires registration and at least member status for read and post. 
             // <strong>Private</strong> requires registration and access privilege granted by the administrator on per user basis
             // for read and post."

	),

   '2' => array(

      'q' => "Pourquoi devrais-je m'inscrire?", //"Why should I register?",


      'a' => "En plus de l'acc&egrave;s au forum non-public, l'inscription permet plusieurs fonctions avanc&eacute;es telles les
             abonnements aux forums ou aux discussions, la messagerie priv&eacute;e, la gestion du profil, la liste des copains,
             le carnet de note, etc."

              //"In addition to participation in non-public forums, registration allows access to various user features such as subscription, 
              //email, inbox, profile, buddy list, scratch pad, etc."

	),

   '3' => array(

      'q' => "Comment faire pour s'inscrire?", //"How do I register?",


      'a' => "Pour vous inscrire, cliquez sur <strong>Veuillez vous inscrire</strong> &agrave; la page d'accueil du forum."
              
              //"You can register by clicking on the <strong>Please Register</strong> link in the lobby 
              //and completing the registration form."

	),

    '4' => array(

       'q' => "Quand je m'inscris, le syst&egrave;me me dit que mon adresse de courriel est invalide.  Pourquoi?",
              //"The registration process tells me that I have an invalid email address.  What's up with that?",


       'a' => "Votre adresse de courriel doit correspondre au format usuel, i.e. <strong>membre@domain.com</strong>. 
	  L'administrateur peut aussi interdire des courriels gratuits abusifs comme hotmail et yahoo."
              //"The email address has to be in valid email address format, i.e. <strong>username@domain.com</strong>. 
	  //Administrators can also selectively ban free webmail addresses such as hotmail and yahoo mail."

    )
         
);


// q and a for icon FAQ
//
$in['lang']['ico_faq'] = array(      

   '1' => array(
   
      'q' => "Que permet de faire chacune des icônes?", //"What does each menu icon allow me to do?",


      'a' => "En cliquant sur <img src=\"" . IMAGE_URL . "/login.gif\" alt=\"Identification\" align=\"middle\" /> 
              on acc&egrave;de &agrave; la fen&ecirc;tre pour identification.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/help.gif\" alt=\"Aide\" align=\"middle\" /> 
              m&egrave;ne &agrave; la page d'aide, comme celle-ci.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/search.gif\" alt=\"Chercher\" align=\"middle\" /> 
              m&egrave;ne &agrave; la page recherche.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/read_new.gif\" alt=\"Nouveaux\" align=\"middle\" /> 
              montre tous les nouveaux messages depuis votre derni&egrave;re visite ou dernier marquage.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" align=\"middle\" /> 
              m&egrave;ne au menu des pr&eacute;f&eacute;rences. <br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Marquer\" align=\"middle\" /> 
              marque les discussions et forums lus.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile.gif\" alt=\"Membres\" align=\"middle\" /> 
              m&egrave;ne au profil de tous les membres inscrits.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Evaluation\" align=\"middle\" /> 
              m&egrave;ne &agrave; la page d'&eacute;valuation des membres. <br />"

              //"Clicking on <img src=\"" . IMAGE_URL . "/login.gif\" alt=\"login\" align=\"middle\" /> 
              //retrieves the login window.<br />
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/help.gif\" alt=\"help\" align=\"middle\" /> 
              //retrieves the FAQ page like this one.<br />
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/search.gif\" alt=\"search\" align=\"middle\" /> 
              //retrieves the search form page.<br />
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/read_new.gif\" alt=\"read new\" align=\"middle\" /> 
              //retrieves all topics containing new messages since your last mark or visit.<br /> 
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" align=\"middle\" /> 
              //retrieves the user menu.<br /> 
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Mark\" align=\"middle\" /> 
              //timestamps the topics or forums of the current page as read.<br />
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile.gif\" alt=\"Profiles\" align=\"middle\" /> 
              //retrieves links to all registered user profiles.<br />
              //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"User Rating\" align=\"middle\" /> 
              //retrieves the page where you can view individual user ratings and rate other users. <br />"

    ),

   '2' => array(

      'q' => "Pourquoi certaines icônes sont-elles en flammes?", //"Why do some file icons display flame?",


      'a' => "Les flammes indiquent une discussion chaude; elle d&eacute;passe un certain nombre de r&eacute;ponses.",  //"Flame indicates heavy user activity."


    ),

   '3' => array(

      'q' => "Pourquoi certains forums montrent une icône en forme de cadenas?", //"Why do some forum folder icons display a lock?",


      'a' => "Il indique des forums mod&eacute;r&eacute;s. Tous les messages post&eacute;s dans ces forums doivent &ecirc;tre autoris&eacute;s 
              par le mod&eacute;rateur avant d'&ecirc;tre affich&eacute;s."
              //"It indicates moderation. Moderated forums will force all messages into a queue for 
             //review by the moderator. The messages will not be immediately posted."

	),

   '4' => array(

      'q' => "Pourquoi certaines discussions montrent une icône en forme de cadenas?", //"Why do some topic icons display a lock?",


      'a' => "Il indique que la discussion a &eacute;t&eacute; ferm&eacute;e par l'administrateur pour lecture seulement.
              On ne peut plus y poster de messages."
             //"It indicate that the thread has been locked by the administrator as read only. 
              //Further replies are not allowed."

      ),

   '5' => array(

      'q' => "Pourquoi certaines discussions ont un lien [voir tous] pr&egrave;s du sujet?", //"Why do some topics have [view all] next to the subject?",


      'a' => "Le syst&egrave;me se met en mode autogestion lorsqu'il y a plusieurs r&eacute;ponses au message.
              Le lien<strong>voir tous</strong> est alors affich&eacute; pour visualiser toutes les r&eacute;ponses en m&ecirc;me temps."
             //"Topics with many replies will automatically display one message at a time with a clickable table of 
             //content. Clicking on <strong>view all</strong> will retrieve the entire thread with all the replies."

      ),

   '6' => array(

      'q' => "C'est quoi les petites icônes &agrave; la droite du nom de membre?", //"What are all those icons immediately to the right of the username?",


      'a' => "Ces icônes donnent certains renseignements sur le membre. Les &eacute;toiles indiquent que le membre a &eacute;t&eacute; &eacute;valu&eacute; par d'autres.
             Plus le membre a d'&eacute;toiles, plus l'&eacute;valuation est positive. <img src=\"" . IMAGE_URL . "/admin_icon.gif\" alt=\"admin \" /> indique le statut d'administrateur.
              <img src=\"" . IMAGE_URL . "/guest.gif\" alt=\"invit&eacute;\"> indique le statut d'invit&eacute; (non-inscrit)"
             //"The icons indicate certain information about the user. The stars indicate user rating. More stars mean 
              //higher rating. <img src=\"" . IMAGE_URL . "/admin_icon.gif\" alt=\"admin \" /> indicates admin status.
              //<img src=\"" . IMAGE_URL . "/guest.gif\" alt=\"guest\"> indicates the user is a guest who is unregistered."

      ),


   '7' => array(

      'q' => "C'est quoi toutes ces icônes en haut au coin droit de chaque message?",
             //"What are all those icons to the upper right corner of each message below the date and time?",

      'a' => "Ces icônes permettent une action avec un membre concern&eacute;. Par exemple,<br /> 
             cliquez sur <img src=\"" . IMAGE_URL . "/email.gif\" alt=\"Envoyer un courriel &agrave; ce membre\" align=\"middle\" /> 
             pour envoyer un courriel &agrave; ce membre.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg.gif\" alt=\"Envoyer un message priv&eacute;\" align=\"middle\" /> 
             pour envoyer un message priv&eacute; &agrave; ce membre.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile_small.gif\" alt=\"Profil de ce membre\" align=\"middle\" /> 
             m&egrave;ne au profil de ce membre.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" alt=\"Ajouter ce membre &agrave; votre liste de copains\" align=\"middle\" /> 
             pour ajouter ce membre &agrave; votre liste de copains.<br /> "

             //"Those icons indicate actions specific to the username. For example,<br /> 
             //clicking on the <img src=\"" . IMAGE_URL . "/email.gif\" alt=\"email user\" align=\"middle\" /> 
             //will retrieve the form to send email to that user.<br /> 
             //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg.gif\" alt=\"private message\" align=\"middle\" /> 
             //will send a private message to the user's inbox.<br /> 
             //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile_small.gif\" alt=\"Profile\" align=\"middle\" /> 
             //will retrieve that user\'s profile.<br /> 
             //&nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" alt=\"Add buddy\" align=\"middle\" /> 
             //will add that user to your buddy list.<br /> "

   )

);


// q and a for user how-to FAQ
//
$in['lang']['uh_faq'] = array(

  '1' => array(

      'q' => "Comment naviguer sur ce forum?",  //"How do I navigate?",


      'a' => "À partir du lobby, vous pouvez entrer dans chaque forum ou conf&eacute;rence 
              en cliquant sur l'icône ou le lien correspondant. La m&ecirc;me proc&eacute;dure s'applique pour
              entrer dans les discussions.<br /> 
              Une fois dans la discussion, vous pouvez voir tous les messages,<br /> 
              vous pouvez voir les liens <strong>Discussion pr&eacute;c&eacute;dente | Discussion suivante</strong> 
              au-dessus du premier message &agrave; droite.<br /> 
              Ces liens vous permettent d'aller directement d'une discussion 
              &agrave; une autre sans avoir &agrave; revenir &agrave; la liste des discussions du lobby.<br /> 
              Selon la configuration de votre forum, ces liens sont aussi en bas du dernier message<br /> 
              <strong>Conf&eacute;rences | Forums | Discussion | Discussion pr&eacute;c&eacute;dente | Discussion suivante</strong>.
              Les liens suivants<strong>Conf&eacute;rences</strong> vous ram&egrave;nent au lobby 
              <strong>Forums</strong> &agrave; la liste des forums.<br /> 
              <strong>Discussions</strong> &agrave; la liste des discussions
              Vous pouvez aussi naviger en cliquant sur les liens suivants : 
              <strong>Discussion pr&eacute;c&eacute;dente | Discussion suivante</strong> <br /> 
              <strong>Conf&eacute;rences->Forums-> Discussions</strong>."

              //"From the lobby, you can enter each forum or conference (depending on your board\'s display option) by 
              //clicking on the folder icon or the link to the right of the icon.
              //The same applies for topics page.<br /> 
              //Once you are in the topic, meaning the page with the actual messages,<br /> 
              //you can see <strong>Previous Topic | Next Topic</strong> links 
              //located above the first message to the right.<br /> 
              //Those links will allow you to view the previous and the next 
              //topics relative to your current topic as listed in the topics page.<br /> 
              //Below the last message in your current 
              //topic, you can see the following links -<br /> 
              //<strong>Conferences | Forums | Topics | Previous Topic | Next Topic</strong>.
              //Clicking on the <strong>Conferences</strong> link will bring you back to the page listing all conferences. 
              //<strong>Forums</strong> will bring you out to the page listing all forums.<br /> 
              //<strong>Topics</strong> will bring you out to the topic listing
              //<strong>Previous Topic | Next Topic</strong> are identical to the links above.<br /> 
              //You can also navigate back by clicking on the links 
              //<strong>Conferences->Forums-> Topics</strong> located in the row below the feature 
              //icons(2nd table row from the top)."

      ),
 
   '2' => array(

      'q' => "Comment poster une nouvelle discussion?", //"How do I start a new topic?",


      'a' => "À la page du forum, cliquez sur <img src=\"" . IMAGE_URL . "/post.gif\" alt=\"poster\" />."
             //"At the topics page, click on <img src=\"" . IMAGE_URL . "/post.gif\" alt=\"post\" />."

      ),

  '3' => array(

     'q' => "Comment cr&eacute;er un vote?",  //"How do I start a new poll?",


     'a' => "À la page du forum, cliquez sur <img src=\"" . IMAGE_URL . "/poll.gif\" alt=\"vote\" /> 
             pour d&eacute;finir une question et ses options. Par la suite, cliquez sur soumettre."
             //"At the topics page, click on <img src=\"" . IMAGE_URL . "/poll.gif\" alt=\"poll\" /> 
             //and define the question and choices. 
             //Then click on submit."

      ),

   '4' => array(

      'q' => "Comment r&eacute;pondre &agrave; un message?", //"How do I reply to an existing message?",


      'a' => "Au bas de chaque message, apparaissent les liens suivants <strong>R&eacute;pondre | R&eacute;pondre avec citation</strong>. 
              R&eacute;pondre avec citation est une option qui ins&egrave;re le texte du message auquel vous r&eacute;pondez dans le vôtre,
              vous donnant ainsi la possibilit&eacute; de le citer."
              //"Each message table in a thread will contain <strong>Reply | Reply With Quote</strong>. 
              //Reply with quote will populate the upcoming post form text area with the body 
              //of the message to which you're replying."

   ),

   '5' => array(

      'q' => "Comment savoir o&ugrave; sont les nouveaux messages?",  //"How do I keep track of new messages?",


      'a' => "Vous pouvez choisir de marquer manuellement les messages lus ou demander qu'ils soient marqu&eacute;s automatiquement depuis votre derni&egrave;re visite. 
             Dans vos pr&eacute;f&eacute;rences<strong>Pr&eacute;f&eacute;rences</strong>, si vous choisissez oui pour <strong>Marquer?</strong>, vous obtiendrez 
             le marquage manuel (en cliquant sur <img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"marquer\"> &agrave; la page de discussion) 
             du forum consult&eacute;. La prochaine fois que vous visiterez le forum, seuls les nouveaux messages post&eacute;s apr&egrave;s votre visite 
             seront indiqu&eacute;s par une icône en couleur. Si vous ne choisissez pas l'option marquage, 
             les nouveaux messages seront indiqu&eacute;s selon votre derni&egrave;re visite au forum."
             

             //"You can either use manual mark or last visit cookie to keep track of new messages. 
             //In your <strong>user preference</strong>, if you select yes for <strong>Use MARK time stamp feature?</strong>, you will have 
             //to manually mark (by clicking on <img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"mark\"> at the topics page) 
             //a forum you just read. This will timestamp the forum so the next time you return, only the topics containing messages posted 
             //after the mark timestamp will be indicated by the color icons. If you choose not to use the mark option, 
             //new messages will be indicated according to the time of your last visit to the forum."
             
      ),

   '6' => array(

      'q' => "Comment modifier mon inscription?", //"How do I change my account information?",


      'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>User Menu </strong> Ce lien vous m&egrave;ne &agrave; votre page de pr&eacute;f&eacute;rences."
             //"Clicking on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> will bring you to your user menu."

   ),

   '7' => array(

      'q' => "Comment changer mon mot de passe?", //"How do I change my password?",


      'a' => "Cliquez sur<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" />
               <strong>Pr&eacute;f&eacute;rences</strong> -> <strong>Changez votre mot de passe</strong>"
             //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
              // <strong>User Menu </strong> -> <strong>Change your password</strong>"

      ),

  '8' => array(

      'q' => "Comment modifier mon profil?", //"How do I edit my profile?",


      'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" />
              <strong>Pr&eacute;f&eacute;rences </strong> -> <strong>Changez votre profil</strong>"
             //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
             // <strong>User Menu </strong> -> <strong>Edit your profile</strong>"

   ),

  '9' => array(

      'q' => "Comment modifier mes pr&eacute;f&eacute;rences?", //"How do I edit my forum preference?",


      'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" />
              <strong>Pr&eacute;f&eacute;rences</strong> -> <strong>Changez vos pr&eacute;f&eacute;rences</strong>"
             //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
              //<strong>User Menu </strong> -> <strong>Edit your preference</strong>"

   ),

  '10' => array(

	'q' => "Comment m'abonner aux forums?", //"How do I subscribe to forums?",


        'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>
                User Menu </strong> -> <strong>Abonnez-vous aux forums</strong> et s&eacute;lectionnez
                les forums auxquels vous souhaitez vous abonner."

                //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>
               // User Menu </strong> -> <strong>Forum Subscription</strong> and then check
               // off all forums you wish to subscribe to."

		
   ),

   '11' => array(

       'q' => "Comment g&eacute;rer mes abonnements aux discussions?", //"How do I manage subscription to topics?",


       'a' => "Pour ajouter des discussions &agrave; votre liste d'abonnements, cliquez sur <img src=\"" . IMAGE_URL . "/subscribe_thread.gif\"
               alt=\"Abonnement aux discussions\" align=\"middle\" /> situ&eacute; en haut de la page de discussion.
               Vous pouvez aussi choisir l'option
               <strong>Abonnez-vous &agrave; cette discussion pour recevoir un avis par courriel lorsqu'un nouveau message y est post&eacute;.
               </strong>Pour effacer des discussions de votre liste d'abonnements,
               cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" />
               <strong>Pr&eacute;f&eacute;rences</strong> -> <strong>Abonnement aux discussions</strong>
               vous pourrez retirer les discussions auxquelles vous ne souhaitez plus &ecirc;tre abonn&eacute;es."

               //"To add topics to your subscription, you can click on <img src=\"" . IMAGE_URL . "/subscribe_thread.gif\"
               //alt=\"Subscribe to this thread\" align=\"middle\" /> located in the top row of the message page.
               //You can also request subscription by filling
               //<strong>Subscribe to this topic to receive email notification when a new message is submitted.</strong> 
               //checkbox on the post form
               //when you post or reply. To delete topics from the subscription list,
               //you can click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> <strong>Topic 
               //Subscription </strong> which will retrieve a checkbox form of all
               //your subscribed topics."

       ),

   '12' =>array(

      'q' => "Comment cacher mon profil ou d&eacute;sactiver mes fonctions de courriel?", //"How do I hide my profile or disable email functions?",


      'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>Pr&eacute;f&eacute;rences</strong> -> 
             <strong>Changez vos pr&eacute;f&eacute;rences</strong>.
             Choisir oui pour<strong>Cacher votre profil?</strong>
             et oui pour<strong>Souhaitez-vous recevoir des messages par courriel des autres membres?</strong>"

             //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> 
             //<strong>Edit your preference</strong>.
             //Choose yes for <strong>Hide your profile?</strong>
             //and yes for <strong>Allow other registered users to send you emails?</strong>"

   ),

   '13' =>array(

      'q' => "Comment ins&eacute;rer une image d'avatar dans mes messages?",  //"How do I use an avatar image in my messages?",


      'a' => "Cliquez sur<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>Pr&eacute;f&eacute;rences</strong> -> 
              <strong>Changez votre profil</strong>.
              Il y a quelques avatars de base sous le lien <strong>images suivantes</strong>.
              Pour utiliser vos propres images, entrer l'URL vers ces images.
              <strong>Vous n'avez pas besoin d'utiliser de codes HTML</strong>, seulement l'URL."

              //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> 
              //<strong>Edit your profile</strong>.
              //There are default avatars availble which can be
              //accessed by clicking on <strong>following images</strong> link. To use your own, simply enter the imageurl of your
              //avatar in the textbox. <strong>You do not need to use img src html tags</strong>, just the url."

   ),

   '14' =>array(

      'q' => "Comment ins&eacute;rer une signature dans mes messages?", //"How do I use signatures in my messages?",


      'a' => "Cliquez sur <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>Pr&eacute;f&eacute;rences </strong>> -> 
             <strong>Changez votre profil</strong>.
             Il y a un champs pour la signature."

             //"Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong>> -> 
             //<strong>Edit your profile</strong>.
             //There is a textarea for your signature."

   ),

   '15' => array(

      'q' => "Comment utiliser des codes HTML dans mes messages?", //"How do I use HTML tags in my messages?",

      'a' => "Si les codes HTML sont autoris&eacute;s par l'administrateur, utilisez le symbole suivant [et] au lieu de <et>."

              //"Instead of angle brackets <> use square brackets [] in your message. The administrator has the option of
             // disabling html tags for the board."

   ),

   '16' => array(

      'q' => "Comment ins&eacute;rer des images dans mes messages?", //"How do I post images?",


      'a' => "Il suffit d'entrer l'adresse URL o&ugrave; se trouve l'image( ex.: http://www.somedomain.com/Images/cool.gif) dans votre message.
              Si l'administrateur le permet, vous pouvez aussi transf&eacute;rer une image en cliquant sur
              <strong>Cliquez ici pour inclure une pi&egrave;ce jointe</strong>. Ceci va ouvrir une fen&ecirc;tre
              &agrave; partir de laquelle vous pouvez s&eacute;lectionner le fichier que vous d&eacute;sirez transf&eacute;rer
              et sp&eacute;cifier le type de fichier. Une fois le fichier s&eacute;lectionn&eacute;, il sera automatiquement
              transf&eacute;r&eacute; &agrave; votre message. Tous les fichiers sont renomm&eacute;s de façon al&eacute;atoire.
              La taille des fichiers transf&eacute;rables est limit&eacute;e."
              
              //"You can just include the imageurl ( i.e. http://www.somedomain.com/Images/cool.gif) in your message.
             // Or you can also upload an image(this option has to be enabled by the administrator) by clicking
              //on <strong>Click here to choose your file</strong> on the post form. This will launch a remote
              //window through which you can specify the file extension and browse your disk to select the file you wish to
              //upload. Once the file is selected, the attachment textbox will automatically be populated with the name of
              //your uploaded file. All files are randonmly renamed. Keep in mind that there is a size limitation to file upload."

   ),

   '17' => array(

      'q' => "Comment activer les liens HTML dans mes messages?",  //"How do I use HTML links?",


      'a' => "Ins&eacute;rer tout simplement l'adresse URL. Elle sera activ&eacute;e automatiquement. Ex.:http://www.somedomain.com"
             //"You can include the html links by simply typing in the url with your message. Something like http://www.somedomain.com"


   )

);


// q and a for user functions FAQ
//
$in['lang']['uf_faq'] = array(

   '1' => array(

      'q' => "C'est quoi un abonnement?", //"What is a subscription?",


      'a' => "En vous abonnant, vous pouvez recevoir des avis automatiques par courriel lorsqu'il y a des nouveaux messages
              post&eacute;s sur le forum."
             //"By requesting subscription you can receive email notifcations when new replies or topics are posted."
        

       ),

   '2' => array(

      'q' => "C'est quoi la messagerie priv&eacute;e?",  //"What is an inbox?",


      'a' => "La messagerie priv&eacute;e, accessible sous le lien Pr&eacute;f&eacute;rences est une messagerie personnelle.
              Vous pouvez recevoir des messages priv&eacute;s de d'autres membres et en envoyer."
              //"Inbox is a private message box provided by the board for communication among registered users."


    ),

   '3' => array(

      'q' => "C'est quoi un signet?", //"What is a bookmark?",


      'a' => "Le signet est une option qui vous permet de mettre en m&eacute;moire vos discussions pr&eacute;f&eacute;r&eacute;es
              dans votre zone de signets personnels pour consultation ult&eacute;rieure."
           //"Bookmark is similar to your browser's bookmark. It allows you to make note of a topic with comment for
          //further reading in the future"

    ),

   '4' =>array(

      'q' => "C'est quoi une liste de copains?",  //"What is a buddy list?",


      'a' => "C'est une liste personnelle de contacts qui vous permet un acc&egrave;s rapide &agrave; leur courriel, messages priv&eacute;s,
              ICQ, et leur profil."
             //"It is a personalized contact list of registered users which provides you with quick access to email, private message, icq,
          //and their profiles"

      ),

   '5' => array(

      'q' => "C'est quoi un carnet de note?", //"What is a scratch pad?",


      'a' =>  "C'est un carnet sur lequel vous pouvez inscrire des notes personnelles (rappels, informations, etc.)."
              //"It is a note box viewable by subject. You can use it to jot down notes."


   ),

   '6' => array(

      'q' => "C'est quoi les &eacute;valuations des discussions?", //"What is topic rating system?",


      'a' => "Ce syst&egrave;me permet aux membres d'&eacute;valuer les discussions des autres afin d'en indiquer la qualit&eacute;."
             //"It allows users to rate specific topics to indicate the quality of the topic."


      ),

   '7' => array(

      'q' => "Comment &eacute;valuer une discussion?", //"How do I rate topics?",


      'a' => "A droite au bas de la page contenant le message, cliquez sur 
              <img src=\"" . IMAGE_URL . "/topic_rating.gif\" alt=\"Evaluation de cette discussion\" />
              <strong>Evaluez cette discusssion</strong>"
              //"At the bottom right corner of the message page, click on 
              //<img src=\"" . IMAGE_URL . "/topic_rating.gif\" alt=\"Topic rating\" />
              //<strong>Rate this topic</strong>"

   ),

   '8' => array(

      'q' => "C'est quoi les &eacute;valuations des membres?", //"What is user rating system?",

      'a' => "Cet option permet aux membres d'&eacute;valuer d'autres membres en fonction de leur contribution
              individuelle sur les forums."
             //"It allows users to rate the level of contribution a specific user makes to the community."


      ),

   '9' => array(

      'q' => "Comment participer?  Est-ce obligatoire?", //"How do I participate?  Do I have to participate?",


      'a' => "Chaque membre a le choix de participer ou non. Pour ne pas participer, cliquez sur
             <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"Pr&eacute;f&eacute;rences\" /><strong>Pr&eacute;f&eacute;rences </strong>  ->
             <strong>Changez vos pr&eacute;f&eacute;rences</strong> et choisissez <strong>non</strong> 
             &agrave; l'option <strong>Activer votre syst&egrave;me d'&eacute;valuation?</strong>"
            
	       //"It is up to the user to participate. There is a setting in your preference. To abstain, click on
             //<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong>  ->
             //<strong>Edit your preference</strong> and select <strong>no</strong> 
             //for the setting <strong>Participate in user rating and feedback?</strong>"

      ),

   '10' => array(

      'q' => "Comment &eacute;valuer les autres membres?", //"How do I rate other users?",


      'a' => "Il y a deux façons de faire. Sur la page du message post&eacute;, vous pouvez cliquez sur <strong>Evaluer ce membre</strong> ou 
             <strong>xx points</strong> &agrave; côt&eacute; du nom du membre que vous d&eacute;sirez &eacute;valuer.              
             <strong>Evaluer ce membre</strong>. Quand vous cliquez, un formulaire d'&eacute;valuation du membre apparaît.<br />
             Une autre m&eacute;thode lorsque vous cliquez sur <img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"Evaluation de membres\" align=\"middle\" />
             <strong>Evaluation</strong>. Ce lien m&egrave;ne &agrave; une liste des membres sous forme d'index alphab&eacute;tique.  En cliquant sur une lettre,  
             vous obtenez une liste des membres participant au syst&egrave;me d'&eacute;valuation.  S&eacute;lectionnez la lettre qui correspond
             au nom du membre, puis cliquez sur <strong>Evaluer ce membre</strong> pour commencer l'&eacute;valuation."
             
             //"There are a couple of ways. You can click on <strong>Rate this user</strong> or 
             //<strong>xx points</strong> link next to the username in each
             //message which will retrieve the page listing the feedbacks and ratings. 
             //On that page there is a link called
             //<strong>Rate this user</strong>. When clicked, 
             //a remote window will be launched which will contain a form to rate that user.<br />
             //Another method is to click on <img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"User Ratings\" align=\"middle\" />
             //<strong>Ratings</strong> which will bring you 
            // to a page listing the index of users participating in user rating. The users are arranged alphabetically. 
             //By clicking on a letter, you can access a list of usernames beginning with 
             //that letter. Clicking on a username on the page will retrieve a list of feed backs and ratings that user has received. You can
             //click on <strong>Rate this user</strong> link to launch the remote window containing the rating form."


     )

);



   

?>

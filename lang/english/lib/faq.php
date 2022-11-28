<?php
///////////////////////////////////////////////////////////////////////////
//
// faq.php
//
// DCForum+ Version 1.27
// September 30, 2009
//
//
//    This file is part of DCForum+
//
//    DCForum+ is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    DCForum+ is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with DCForum+; if not, write to the Free Software
//    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
//
//
// 	$Id: faq.php,v 1.1 2003/04/14 08:56:30 david Exp $	
//
///////////////////////////////////////////////////////////////////////////

$in['lang']['page_title'] = "FAQ";
$in['lang']['page_header'] = "Select from following list of FAQs";

$in['lang']['faq_topic'] = array(
       'gen_faq' => 'General FAQ',
       'reg_faq' => 'Registration FAQ',
       'ico_faq' => 'Icons FAQ',
       'uh_faq' => 'User How-to FAQ',
       'uf_faq' => 'User Functions FAQ'
);

// Please be careful when editing following section
// Only edit text in 'q' and 'a'....the values correspoding
// to 'a' and 'q' are in double quotes.  So, if are going to use " in
// your translation, make sure you escape it (\")

// q and a for general FAQ
//
$in['lang']['gen_faq'] = array(

   '1' => array(

      'q' => "What is a forum?",

      'a' => "Forum is a collection of related topics. When you 
              enter a forum, you will see a listing of current topics in that forum. Each topic contains 
              the original message and, if applicable, replies to that message.  As a forum grows, it may
              be better organized if there were sub-folders.  Therefore, a forum can also
              contain additional forums as well."

         ),

   '2' => array(

      'q' => "What is a thread/topic?",

      'a' => "Thread is another word for topic. Each thread contains one 
              original message and replies to that message. The default thread display mode is 
              fully-threaded. There is a table of content below the original message which shows 
              you the flow of discussion. If the linear style option is chosen by the 
              administrator, the thread will display the replies in chronological order."

	 ),

   '3' => array(

      'q' => "Why are there so many different types of forums?",

      'a' => "There are four types of forums, each with varying degree of access control: 
              Public, Protected, Restricted, and Private.
              <ul>
              <li> <strong>Public Forum</strong>: Public forum does not require prior 
              registration for the user to particiapate. 
              It is read and post for everyone.</li>
              <li> <strong>Protected Forum</strong>: Protected forum is read-only 
              for non-registered members. The user must be registered and logged on to post.</li>
              <li> <strong>Restricted Forum</strong>: Restricted forum is only accessible 
              by registered members in following user groups: admin, moderator, team, and member.</li>
              <li> <strong>Private Forum</strong>: Private forum is only accessible by registered 
              members with access privilege manually granted by the administrator.</li>
              </ul>"

         ),

   '4' => array(

      'q' => "How do I get access to restricted and private forums?",

      'a' => "Only the administrator 
              can grant you access to restricted and 
              private forums. Contact your administrator and request access 
              to these restricted and private forums."

       ),

   '5' => array(

      'q' => "When I post a message in one forum, it posts ok. But in another forum, it won't post.  Why?",

      'a' => "Most likely, you are posting to a moderated forum. Any forum can be set to 'open' or 'moderated' mode 
              by the administrator. Enabling moderation on a forum will force all messages 
              into a queue to be reviewed by the administrator or the moderator. 
              Moderated forums are indicated by <img src=\"" . 
              IMAGE_URL . "/new_locked_folder.gif\" alt=\"moderated forum\" align=\"middle\" /> or
              <img src=\"" . IMAGE_URL . "/locked_folder.gif\" alt=\"moderated forum\" align=\"middle\" />"

       )

);


// q and a for registration faq
//
$in['lang']['reg_faq'] = array(

   '1' => array(

      'q' => "Do I have to register?",

      'a' => "Registration may be optional depending on the forum type.
              <strong>Public</strong> forums are open for read and post to everyone.
	      <strong>Protected</strong> is open for read to everyone, post for registered. 
              <strong>Restricted</strong> requires registration and at least member status for read and post. 
              <strong>Private</strong> requires registration and access privilege granted by the administrator on per user basis
              for read and post."
 
	),

   '2' => array(

      'q' => "Why should I register?",

      'a' => "In addition to participation in non-public forums, registration allows access to various user features such as subscription, 
              email, inbox, profile, buddy list, scratch pad, etc."

	),

   '3' => array(

      'q' => "How do I register?",

      'a' => "You can register by clicking on the <strong>Please Register</strong> link in the lobby 
              and completing the registration form."

	),

    '4' => array(

       'q' => "The registration process tells me that I have an invalid email address.  What's up with that?",

       'a' => "The email address has to be in valid email address format, i.e. <strong>username@domain.com</strong>. 
	  Administrators can also selectively ban free webmail addresses such as hotmail and yahoo mail."

    )
         
);


// q and a for icon FAQ
//
$in['lang']['ico_faq'] = array(      

   '1' => array(
   
      'q' => "What does each menu icon allow me to do?",

      'a' => "Clicking on <img src=\"" . IMAGE_URL . "/login.gif\" alt=\"login\" align=\"middle\" /> 
              retrieves the login window.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/help.gif\" alt=\"help\" align=\"middle\" /> 
              retrieves the FAQ page like this one.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/search.gif\" alt=\"search\" align=\"middle\" /> 
              retrieves the search form page.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/read_new.gif\" alt=\"read new\" align=\"middle\" /> 
              retrieves all topics containing new messages since your last mark or visit.<br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" align=\"middle\" /> 
              retrieves the user menu. 
              <br /> 
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"Mark\" align=\"middle\" /> 
              timestamps the topics or forums of the current page 
              as read.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile.gif\" alt=\"Profiles\" align=\"middle\" /> 
              retrieves links to all registered user profiles.<br />
              &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"User Rating\" align=\"middle\" /> 
              retrieves the page where you can view 
              individual user ratings and rate other users. <br />"

    ),

   '2' => array(

      'q' => "Why do some file icons display flame?",

      'a' => "Flame indicates heavy user activity."

    ),

   '3' => array(

      'q' => "Why do some forum folder icons display a lock?",

      'a' => "It indicates moderation. Moderated forums will force all messages into a queue for 
              review by the moderator. The messages will not be immediately posted."

	),

   '4' => array(

      'q' => "Why do some topic icons display a lock?",

      'a' => "It indicate that the thread has been locked by the administrator as read only. 
              Further replies are not allowed."

      ),

   '5' => array(

      'q' => "Why do some topics have [view all] next to the subject?",

      'a' => "Topics with many replies will automatically display one message at a time with a clickable table of 
             content. Clicking on <strong>view all</strong> will retrieve the entire thread with all the replies."

      ),

   '6' => array(

      'q' => "What are all those icons immediately to the right of the username?",

      'a' => "The icons indicate certain information about the user. The stars indicate user rating. More stars mean 
              higher rating. <img src=\"" . IMAGE_URL . "/admin_icon.gif\" alt=\"admin \" /> indicates admin status.
              <img src=\"" . IMAGE_URL . "/guest.gif\" alt=\"guest\"> indicates the user is a guest who is unregistered."

      ),


   '7' => array(

      'q' => "What are all those icons to the upper right corner of each message below the date and time?",

      'a' => "Those icons indicate actions specific to the username. For example,<br /> 
             clicking on the <img src=\"" . IMAGE_URL . "/email.gif\" alt=\"email user\" align=\"middle\" /> 
             will retrieve the form to send email to that user.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg.gif\" alt=\"private message\" align=\"middle\" /> 
             will send a private message to the user's inbox.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/profile_small.gif\" alt=\"Profile\" align=\"middle\" /> 
             will retrieve that user\'s profile.<br /> 
             &nbsp;&nbsp;&nbsp;<img src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" alt=\"Add buddy\" align=\"middle\" /> 
             will add that user to your buddy list.<br /> "
   )

);


// q and a for user how-to FAQ
//
$in['lang']['uh_faq'] = array(

  '1' => array(

      'q' => "How do I navigate?",

      'a' => "From the lobby, you can enter each forum or conference (depending on your board\'s display option) by 
              clicking on the folder icon or the link to the right of the icon.
              The same applies for topics page.<br /> 
              Once you are in the topic, meaning the page with the actual messages,<br /> 
              you can see <strong>Previous Topic | Next Topic</strong> links 
              located above the first message to the right.<br /> 
              Those links will allow you to view the previous and the next 
              topics relative to your current topic as listed in the topics page.<br /> 
              Below the last message in your current 
              topic, you can see the following links -<br /> 
              <strong>Conferences | Forums | Topics | Previous Topic | Next Topic</strong>.
              Clicking on the <strong>Conferences</strong> link will bring you back to the page listing all conferences. 
              <strong>Forums</strong> will bring you out to the page listing all forums.<br /> 
              <strong>Topics</strong> will bring you out to the topic listing
              <strong>Previous Topic | Next Topic</strong> are identical to the links above.<br /> 
              You can also navigate back by clicking on the links 
              <strong>Conferences->Forums-> Topics</strong> located in the row below the feature 
              icons(2nd table row from the top)."

      ),
 
   '2' => array(

      'q' => "How do I start a new topic?",

      'a' => "At the topics page, click on <img src=\"" . IMAGE_URL . "/post.gif\" alt=\"post\" />."

      ),

  '3' => array(

     'q' => "How do I start a new poll?",

     'a' => "At the topics page, click on <img src=\"" . IMAGE_URL . "/poll.gif\" alt=\"poll\" /> 
             and define the question and choices. 
             Then click on submit."
      ),

   '4' => array(

      'q' => "How do I reply to an existing message?",

      'a' => "Each message table in a thread will contain <strong>Reply | Reply With Quote</strong>. 
              Reply with quote will populate the upcoming post form text area with the body 
              of the message to which you're replying."

   ),

   '5' => array(

      'q' => "How do I keep track of new messages?",

      'a' => "You can either use manual mark or last visit cookie to keep track of new messages. 
             In your <strong>user preference</strong>, if you select yes for <strong>Use MARK time stamp feature?</strong>, you will have 
             to manually mark (by clicking on <img src=\"" . IMAGE_URL . "/mark.gif\" alt=\"mark\"> at the topics page) 
             a forum you just read. This will timestamp the forum so the next time you return, only the topics containing messages posted 
             after the mark timestamp will be indicated by the color icons. If you choose not to use the mark option, 
             new messages will be indicated according to the time of your last visit to the forum."

      ),

   '6' => array(

      'q' => "How do I change my account information?",

      'a' => "Clicking on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> will bring you to your user menu."

   ),

   '7' => array(

      'q' => "How do I change my password?",

      'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
               <strong>User Menu </strong> -> <strong>Change your password</strong>"
      ),

  '8' => array(

      'q' => "How do I edit my profile?",

      'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
              <strong>User Menu </strong> -> <strong>Edit your profile</strong>"
   ),

  '9' => array(

      'q' => "How do I edit my forum preference?",

      'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" />
              <strong>User Menu </strong> -> <strong>Edit your preference</strong>"

   ),

  '10' => array(

	'q' => "How do I subscribe to forums?",

        'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>
                User Menu </strong> -> <strong>Forum Subscription</strong> and then check
                off all forums you wish to subscribe to."
		
   ),

   '11' => array(

       'q' => "How do I manage subscription to topics?",

       'a' => "To add topics to your subscription, you can click on <img src=\"" . IMAGE_URL . "/subscribe_thread.gif\"
               alt=\"Subscribe to this thread\" align=\"middle\" /> located in the top row of the message page.
               You can also request subscription by filling
               <strong>Subscribe to this topic to receive email notification when a new message is submitted.</strong> 
               checkbox on the post form
               when you post or reply. To delete topics from the subscription list,
               you can click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> <strong>Topic 
               Subscription </strong> which will retrieve a checkbox form of all
               your subscribed topics."

       ),

   '12' =>array(

      'q' => "How do I hide my profile or disable email functions?",

      'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> 
             <strong>Edit your preference</strong>.
             Choose yes for <strong>Hide your profile?</strong>
             and yes for <strong>Allow other registered users to send you emails?</strong>"

   ),

   '13' =>array(

      'q' => "How do I use an avatar image in my messages?",

      'a' => "Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong> -> 
              <strong>Edit your profile</strong>.
              There are default avatars availble which can be
              accessed by clicking on <strong>following images</strong> link. To use your own, simply enter the imageurl of your
              avatar in the textbox. <strong>You do not need to use img src html tags</strong>, just the url."

   ),

   '14' =>array(

      'q' => "How do I use signatures in my messages?",

      'a' => "Click on Click on <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong>> -> 
             <strong>Edit your profile</strong>.
             There is a textarea for your signature."
   ),

   '15' => array(

      'q' => "How do I use HTML tags in my messages?",

      'a' => "Instead of angle brackets <> use square brackets [] in your message. The administrator has the option of
              disabling html tags for the board."

   ),

   '16' => array(

      'q' => "How do I post images?",

      'a' => "You can just include the imageurl ( i.e. http://www.somedomain.com/Images/cool.gif) in your message.
              Or you can also upload an image(this option has to be enabled by the administrator) by clicking
              on <strong>Click here to choose your file</strong> on the post form. This will launch a remote
              window through which you can specify the file extension and browse your disk to select the file you wish to
              upload. Once the file is selected, the attachment textbox will automatically be populated with the name of
              your uploaded file. All files are randonmly renamed. Keep in mind that there is a size limitation to file upload."
   ),

   '17' => array(

      'q' => "How do I use HTML links?",

      'a' => "You can include the html links by simply typing in the url with your message. Something like http://www.somedomain.com"

   )

);


// q and a for user functions FAQ
//
$in['lang']['uf_faq'] = array(

   '1' => array(

      'q' => "What is a subscription?",

      'a' => "By requesting subscription you can receive email notifcations when new replies or topics are posted."
        
       ),

   '2' => array(

      'q' => "What is an inbox?",

      'a' => "Inbox is a private message box provided by the board for communication among registered users."

    ),

   '3' => array(

      'q' => "What is a bookmark?",

      'a' => "Bookmark is similar to your browser's bookmark. It allows you to make note of a topic with comment for
          further reading in the future"

    ),

   '4' =>array(

      'q' => "What is a buddy list?",

      'a' => "It is a personalized contact list of registered users which provides you with quick access to email, private message, icq,
          and their profiles"

      ),

   '5' => array(

      'q' => "What is a scratch pad?",

      'a' =>         "It is a note box viewable by subject. You can use it to jot down notes."

   ),

   '6' => array(

      'q' => "What is topic rating system?",

      'a' => "It allows users to rate specific topics to indicate the quality of the topic."

      ),

   '7' => array(

      'q' => "How do I rate topics?",

      'a' => "At the bottom right corner of the message page, click on 
              <img src=\"" . IMAGE_URL . "/topic_rating.gif\" alt=\"Topic rating\" />
              <strong>Rate this topic</strong>"

   ),

   '8' => array(

      'q' => "What is user rating system?",

      'a' => "It allows users to rate the level of contribution a specific user makes to the community."

      ),

   '9' => array(

      'q' => "How do I participate?  Do I have to participate?",

      'a' => "It is up to the user to participate. There is a setting in your preference. To abstain, click on
             <img src=\"" . IMAGE_URL . "/user.gif\" alt=\"User Menu\" /><strong>User Menu </strong>  ->
             <strong>Edit your preference</strong> and select <strong>no</strong> 
             for the setting <strong>Participate in user rating and feedback?</strong>"

      ),

   '10' => array(

      'q' => "How do I rate other users?",

      'a' => "There are a couple of ways. You can click on <strong>Rate this user</strong> or 
             <strong>xx points</strong> link next to the username in each
             message which will retrieve the page listing the feedbacks and ratings. 
             On that page there is a link called
             <strong>Rate this user</strong>. When clicked, 
             a remote window will be launched which will contain a form to rate that user.<br />
             Another method is to click on <img src=\"" . IMAGE_URL . "/user_rating.gif\" alt=\"User Ratings\" align=\"middle\" />
             <strong>Ratings</strong> which will bring you 
             to a page listing the index of users participating in user rating. The users are arranged alphabetically. 
             By clicking on a letter, you can access a list of usernames beginning with 
             that letter. Clicking on a username on the page will retrieve a list of feed backs and ratings that user has received. You can
             click on <strong>Rate this user</strong> link to launch the remote window containing the rating form."

     )

);



   

?>

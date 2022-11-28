<?php
////////////////////////////////////////////////////////////////////////
//
// upload_files.php
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
//
// MODIFICATION HISTORY
//
// mod.2002.11.07.08 - upload_file bug
// Sept 1, 2002 - v1.0 released
//
////////////////////////////////////////////////////////////////////////
function upload_files() {

   // Global variables
   global $in;

   select_language("/lib/upload_files.php");

   include(INCLUDE_DIR . "/form_info.php");

   $ip = $_SERVER['REMOTE_ADDR'];

   if (SETUP_FILE_UPLOAD != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   // maximum files per post allowed
   $file_upload_limit = SETUP_FILE_UPLOAD_LIMIT > 10 ? 10 : SETUP_FILE_UPLOAD_LIMIT;

   // access control
   if (!$in['access_list'][$in['forum']]) {
      header("Location: " . DCF);
      return;
   }   

   print_head($in['lang']['page_title']);

   // Post ID....need to keep track of how many attachements
   // were uploaded with this post.
   $post_cookie = unzip_cookie($in[DC_POST_COOKIE]);
   $post_id = $post_cookie['post_id'];


   if ($in['saz'] == 'delete_select') {
      print_inst_mesg($in['lang']['delete_header']);

         delete_upload_files_form($post_id,$in['mesg_id']);

         return;         
   }
   // If user needs to delete attachments, do this now
   elseif ($in['saz'] == 'delete') {

     if ($in['delete']) {
        // delete selected uploaded files
         delete_upload_files($post_id,$in['mesg_id']);

         // Need to determine remaining attachments so that
         // it can be added back to the attachment textbox
         $new_list = array();
         $attachments = upload_file_list($post_id,$in['mesg_id']); 
         while (list($id,$type) = each($attachments)) {
            $file = $id . "." . $type;
            array_push($new_list,$file);
         }
         // Put em there, buddy....
         $attachment = implode(",",$new_list);
         print "<body onLoad='self.opener.document.thisform.attachments.value = \"$attachment\\n\"'>";

         print_inst_mesg($in['lang']['delete_attachment_mesg'] . "<a 
                href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a>.");

     }
     else {

         print_inst_mesg($in['lang']['didnot_delete_attachment_mesg'] . "<a 
                href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a>.");

         delete_upload_files_form($post_id,$in['mesg_id']);
         return;         

     }
   }

   // Compute
   $num_upload_files = num_upload_files($post_id,$in['mesg_id']);
   $max_size = SETUP_FILE_UPLOAD_SIZE * 1024;
   $error = array();
   // Get the number of uploaded file for this post form
   if ($num_upload_files >= SETUP_FILE_UPLOAD_LIMIT) {
         print_error_mesg($in['lang']['max_exceeded_mesg']);

         delete_upload_files_form($post_id,$in['mesg_id']);
         return;         
   }


   // Ok, file upload request...
 
  if ($in['saz'] and $in['saz'] != 'delete') {

      // If $_FILES['file_upload'] is empty and file_upload text is not there...
    //      if ($_FILES['file_upload'] == '' and $in['file_upload'] == '') {
      if ($_FILES['file_upload'] == '' and $in['file_upload']) {
         array_push($error, $in['lang']['select_file_mesg']);
         log_error($in['user_info']['id'],'File upload error','Invalid file type');
      }


      // See if MAX_FILE_SIZE was altered
      if ($in[MAX_FILE_SIZE] != $max_size) {
	 array_push($error,$in['lang']['max_file_invalid']);
         log_error($in['user_info']['id'],'File upload error','Maximum file size has beeb altered');
      }

      // See if the file has valid extension type
      if ($in['file_type'] == '') {
         array_push($error, $in['lang']['select_file_type_mesg']);
         log_error($in['user_info']['id'],'File upload error','Invalid file type');
      }
      elseif (! $allowed_files[$in['file_type']]) {
         array_push($error, $in['lang']['invalid_file_type']);
         log_error($in['user_info']['id'],'File upload error','Invalid file type');
      }

      if (count($error) > 0 and $in['saz'] != 'delete') {
         print_error_mesg($in['lang']['error_header'], $error);         
         upload_form();

      }
      else {

	// Check and make sure the number of attachments is no greater than the max         
         if (is_uploaded_file($_FILES['file_upload']['tmp_name'])) {

            $file_id = log_upload($in['user_info']['id'],$in['forum'],$post_id,$in['file_type']);
            $filename = $file_id . "." . $in['file_type'];
            $this_url = USER_URL. "/" . $filename;

            move_uploaded_file($_FILES['file_upload']['tmp_name'],USER_DIR . "/" . $filename);

            $attachment = $file_id . "." . $in['file_type'];

            if ($in['embed_link']) {
               print "<body onLoad='if (self.opener.document.thisform.attachments.value) { 
                     self.opener.document.thisform.attachments.value 
                      = self.opener.document.thisform.attachments.value + \",$attachment\\n\";
                     } 
                     else {
                        self.opener.document.thisform.attachments.value = \"$attachment\\n\";
                     }
                     self.opener.document.thisform.message.value
                      = self.opener.document.thisform.message.value + \"\\n\\n$this_url\\n\"'>";
            }
            else {
               // mod.2002.11.07.08
               // upload_file bug
               print "<body onLoad='if (self.opener.document.thisform.attachments.value) { 
                     self.opener.document.thisform.attachments.value 
                      = self.opener.document.thisform.attachments.value + \",$attachment\";
                     } 
                     else {
                        self.opener.document.thisform.attachments.value = \"$attachment\";
                     }'>";


            }


            $output = $in['lang']['ok_mesg'] . "<br />&nbsp;<br />$this_url<br />&nbsp;<br />";

            $num_upload_files ++;

         }
         else {

	   $output = $in['lang']['upload_failed_mesg'];

         }

         if ($num_upload_files >= $file_upload_limit) {
            $output .= $in['lang']['max_exceeded'] . "
                <br /><a href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a>";
            print_inst_mesg($output);
         }
         else {

            $output .= $in['lang']['select_another'] . "<a 
                       href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a>";

            print_inst_mesg($output);
            upload_form();

         }

      }  

   }
   else {

         upload_form();
   }

   print_tail();

}

///////////////////////////////////////////////////////////////////////
//
// function upload_form
//
///////////////////////////////////////////////////////////////////////
function upload_form() {

   global $in;

   $max_size = SETUP_FILE_UPLOAD_SIZE * 1024;

   include(INCLUDE_DIR . "/form_info.php");

   begin_form(DCF,"MULTIPART/FORM-DATA");

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","update","");
   print form_element("forum","hidden","$in[forum]","");
   if ($in['mesg_id'])
      print form_element("mesg_id","hidden","$in[mesg_id]","");
   print form_element("MAX_FILE_SIZE","hidden","$max_size","");

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   $size_limit = SETUP_FILE_UPLOAD_SIZE;

   print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\" colspan=\"2\">" .
         $in['lang']['step_1'] . "<br />
         (" . $in['lang']['maximum_size'] . " = " .  $size_limit . " " .
         $in['lang']['kbytes'] . ")</td></tr>
         <tr class=\"dclite\"><td class=\"dclite\" colspan=\"2\">
         <input type=\"file\" name=\"file_upload\" size=\"50\" /></td></tr>
         <tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\">" . 
         $in['lang']['step_2']. ":</td></tr>";


   print "<tr class=\"dclite\"><td class=\"dclite\"><select name=\"file_type\">";

   while(list($key,$val) = each($allowed_files)) {

      if ($key == SETUP_FILE_UPLOAD_DEFAULT) {
	$checked = 'selected';
      }
      else {
	$checked = '';
      }

      print "<option value=\"$key\" $checked/> " . $allowed_files[$key]['title'] . "</option>";
   }


   print "</select></td></tr>";


   print "<tr class=\"dclite\"><td class=\"dclite\" colspan=\"2\">
         <input type=\"checkbox\" name=\"embed_link\" value=\"1\" /> <strong>" .  
         $in['lang']['check_embed'] . "</strong></td>
         <tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\" colspan=\"2\">" . 
         $in['lang']['step_3'] . "</td></tr>
         <tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\" colspan=\"2\">
         <input type=\"submit\" value=\"" . $in['lang']['button_upload'] . "\" />
         <input type=\"reset\" value=\"" . $in['lang']['button_reset'] . "\" /> 
         <a href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a>
         </td></tr>";

   end_table();
   end_form();

}

/////////////////////////////////////////////////////////////////
//
// function log_error
//
/////////////////////////////////////////////////////////////////
function log_error($u_id,$event,$event_info) {

  $remote_addr = $_SERVER['REMOTE_ADDR'];

   $q = "INSERT INTO " . DB_SECURITY . "
          VALUES ('',
                  '$u_id',
                  '$event',
                  '$event_info',
                  '$remote_addr',
                  NOW() )";

   db_query($q);


}

/////////////////////////////////////////////////////////////////
//
// function log_upload
//
/////////////////////////////////////////////////////////////////
function log_upload($u_id,$forum_id,$post_id,$file_type) {


  $remote_addr = $_SERVER['REMOTE_ADDR'];

   $q = "INSERT INTO " . DB_UPLOAD . "
          VALUES ('',
                  '$u_id',
                  '$forum_id',
                  '0',
                  '$post_id',
                  '$file_type',
                  '$remote_addr',
                  NOW() )";

   db_query($q);

   return db_insert_id($q);

}

////////////////////////////////////////////////////////////////
//
// function num_upload_files
//
////////////////////////////////////////////////////////////////
function num_upload_files($post_id,$mesg_id) {

   
   $q = "SELECT count(id) as count
           FROM " . DB_UPLOAD;

   if ($post_id) {
      if ($mesg_id) {
         $q .= "
               WHERE post_id = '$post_id'
               OR mesg_id = '$mesg_id' ";
      }
      else {
         $q .= "
               WHERE post_id = '$post_id' ";
      }
   }
   else {
         $q .= "
               WHERE mesg_id = '$mesg_id' ";
   }

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row['count'];

}

////////////////////////////////////////////////////////////////
//
// function upload_file_list
//
////////////////////////////////////////////////////////////////
function upload_file_list($post_id,$mesg_id) {


   $upload_files = array();
   
   $q = "SELECT id,file_type
           FROM " . DB_UPLOAD;

   if ($post_id) {
      if ($mesg_id) {
         $q .= "
               WHERE post_id = '$post_id'
               OR mesg_id = '$mesg_id' ";
      }
      else {
         $q .= "
               WHERE post_id = '$post_id' ";
      }
   }
   else {
         $q .= "
               WHERE mesg_id = '$mesg_id' ";
   }

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $upload_files[$row['id']] = $row['file_type'];
   }

   db_free($result);

   return $upload_files;

}


////////////////////////////////////////////////////////////////
//
// function delete_upload_files
//
////////////////////////////////////////////////////////////////
function delete_upload_files($post_id,$mesg_id) {

   global $in;

   foreach ($in['delete'] as $id) {

      $q = "SELECT file_type
              FROM " . DB_UPLOAD . "
             WHERE id = '$id' ";
      $result = db_query($q);
      $row = db_fetch_array($result);
      $filename = $id . "." . $row['file_type'];
      db_free($result);

      $q = "DELETE FROM " . DB_UPLOAD . "
            WHERE id = '$id' ";
      db_query($q);

      if (file_exists(USER_DIR . "/$filename")) {
               unlink(USER_DIR . "/$filename");
      }
   }

}

////////////////////////////////////////////////////////////////
//
// function delete_upload_files_form
//
////////////////////////////////////////////////////////////////
function delete_upload_files_form($post_id,$mesg_id) {

   global $in;

   $max_size = SETUP_FILE_UPLOAD_SIZE * 1024;

   include(INCLUDE_DIR . "/form_info.php");

   begin_form(DCF);

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","delete","");
   print form_element("forum","hidden","$in[forum]","");

   if ($in['mesg_id'])
      print form_element("mesg_id","hidden","$in[mesg_id]","");

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\" colspan=\"2\">" . 
     $in['lang']['select_file_to_delete'] . ":</td></tr>";

   $attachments = upload_file_list($post_id,$mesg_id);

   while (list($id,$type) = each($attachments)) {
         $file = USER_URL . "/" . $id . "." . $type;
         print "<tr class=\"dclite\"><td class=\"dclite\">
         <input type=\"checkbox\" name=\"delete[]\" value=\"$id\" /> 
         <a href=\"$file\" target=\"_blank\">$file</a></td></tr>";
   }

   print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"100%\" colspan=\"2\">
         <input type=\"submit\" value=\"" . $in['lang']['button_delete'] . "\" />
         <input type=\"reset\" value=\"" . $in['lang']['reset'] . "\" /> <a 
         href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a></td></tr>";

   end_table();
   end_form();

}
?>
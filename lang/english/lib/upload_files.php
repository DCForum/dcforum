<?php
//
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

// main function
$in['lang']['page_title'] = "File upload utility";

$in['lang']['delete_header'] = "Select attachments you wish to delete.";

$in['lang']['delete_attachment_mesg'] = "The attachments you selected have been deleted.<br />
                          You may include additional attachments using the form below.<br />";

$in['lang']['close_this_window'] = "Close this window";

$in['lang']['didnot_delete_attachement_mesg'] = "You have elected  not to deleted any attachments.
                          <br />Please use the form below to delete them.";

$in['lang']['select_file_mesg'] = "Please select a file to upload";

$in['lang']['max_file_invalid'] = "Maximum file size allowed is incorrect";

$in['lang']['select_file_type_mesg'] = "Please select a file type";

$in['lang']['invalid_file_type'] = "Invalid file type";

$in['lang']['error_header'] = "There were errors in uploading files";

$in['lang']['ok_mesg'] = "The file you chose was sucessfully uploaded to the server.<br />
                        The URL of this file is ";

$in['lang']['upload_failed_mesg'] = "Upload failed...the file you tried to upload exceeds the maximum limit
               set by the administrator of this site.  Please try again.";

$in['lang']['max_exceeded'] = "Your post now contains maximum number of attachments allowed.";

$in['lang']['max_exceeded_mesg'] = "Maximum number of files allowed exceeded.<br />
                                    You must deelete one of more of your current 
                                    attachments before you can upload additional files.";

$in['lang']['select_another'] = "If you wish to upload additional files, please use 
                                 the form below to do so. Otherwise, ";


// function uploade_form
$in['lang']['step_1'] = "Step 1. Click on 'Browse...' button to choose your attachment file.";

$in['lang']['maximum_size'] = "maximum size allowed";

$in['lang']['kbytes'] = "KBytes";

$in['lang']['step_2'] = "Step 2. Define your attachment type";

$in['lang']['check_embed'] = "Check this box if you wish to embed 
            attachment URL in the message text box.";

$in['lang']['step_3'] = "Step 3. Click on 'Upload File!' button to finish.  The
         uploaded file name will automatically be added to the attachment textbox.";
          
$in['lang']['button_upload'] = "Upload file!";
$in['lang']['button_reset'] = "Reset";


// fucntion delete_upload_files

$in['lang']['select_file_to_delete'] = "Select attachments you wish to remove";
$in['lang']['button_delete'] = "Delete selected files!";

?>
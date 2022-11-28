<?php
//////////////////////////////////////////////////////////////////////
//
// eula.php
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
// Sept 1, 2002 - v1.0 released
//
//
//
////////////////////////////////////////////////////////////////////////
function eula() {

   global $in;

   // disclaimer and EULA statement

    $disclaimer =<<<END
<form method="post">
<textarea name="eula" rows="20" cols="60" wrap="virtual">DCSCRIPTS DCFORUM+ END-USER LICENSE AGREEMENT

You may use this software only as described in this license.  

If you do not agree to the terms of this license, do not download, install or use the software.

1. Software.
----------------------------
The term "Software" used below refers to the software above, any updates to the software, any supplemental code provided to you by DCScripts, the User's Guide, any associated software components, any related media and printed materials, and any "online" or electronic documentation.

2. Grant of License.
----------------------------
Redistribution: Redistribution or reselling any contents of this Software, including images, text, and scripts, is strictly forbidden without the prior written consent of DCScripts.

Unauthorized Removal of Copyright Statement:  Removal or alteration of the copyright statement without the expressed written consent of DCScripts will result in immediate annulment of the license without monetary compensation to the license holder. The terms of the license, including the agreed upon benefits extended to the license holder, shall be null and void. Any usage of our product following the annulment of the license shall be considered illegal.   We also reserve the right to pursue appropriate legal actions against those in violation of the copyright policy, specifically those whose intent is to misrepresent and falsely claim credit or ownership of the script by altering the copyright statement which may or may not result in improper financial gains for the those responsible for the violation

2.  Copyright.
----------------------------
You acknowledge that you have only the limited, non-exclusive right to use and copy the Software as expressly stated in this license and that DCScripts retains all other rights.  You agree not to remove or modify any copyright, trademark or other proprietary notices which appear in the Software.  The Software is protected by United States copyright law and international treaty provision.

3. Export Restrictions.
----------------------------
You agree that you will not export or re-export the Software to any country, person, entity, or end user subject to U.S.A. export restrictions. Restricted countries currently include, but are not necessarily limited to Cuba, Iran, Iraq, Libya, North Korea, Serbia, Sudan, and Syria. 

4. NO WARRANTIES.
----------------------------
The Software is provided "as is" without warranty of any kind, either express or implied, including, without limitation, the implied warranties of merchantability, fitness for a particular purpose, or noninfringement.   The Software is provided with all faults and the entire risk as to satisfactory quality, performance, accuracy and effort is with you.

5.  LIMITATION OF LIABILITY.
----------------------------
DCScripts expressly disclaims all representations and warranties of any kind regarding the contents or use of the information including, but not limited to express and implied warranties of accuraccy, completeness, merchantability, fitness for a particular use, or non-infringement. In no event shall DCScripts be liable for any direct, indirect, special, incidental or consequential damages, including lost profits, business or data, resulting from the use or reliance upon the information, even if DCScripts has been advised of the possibility of such damages. Some jurisdictions do not allow the exclusion of implied warranties, so the above exclusion may not apply to you. 

6. U.S. Government Restricted Rights.
----------------------------
The Software is provided with the commercial rights and descriptions described in this license, and is otherwise provided with RESTRICTED RIGHTS.  Use, duplication, or disclosure by the Government is subject to restrictions as set forth in subparagraph (c)(1)(ii) of The Rights in Technical Data and Computer Software clause of DFARS 252.227-7013 or subparagraphs (c)(i) and (2) of the Commercial Computer Software-Restricted Rights at 48 CFR 52.227-19, as applicable.  Manufacturer is DCScripts, 26 Jamaica Rd Suite 3, Brookline, MA 02445, USA.

7. MISCELLANEOUS.
----------------------------
If you acquired the Software in the United States, this license is governed by the laws of the state of Massachusetts.  If you acquired the Software outside of the United States, then local laws may apply.  


Should you have any questions concerning this license, or if you desire to contact DCScripts for any reason, please contact DCScripts by mail at: 26 Jamaica Rd Suite 3, Brookline, MA 02445, or by electronic mail at: support@dcscripts.com.
</textarea><br />&nbsp;&nbsp;<br />
<input type="submit" name="agree" value="Yes, I AGREE" /> 
<input type="submit" name="donotagree" value="No, I DO NOT AGREE" />
</form>

END;


   if ($in['agree']) {
      
      if ($fh = fopen(TEMP_DIR . "/eula.lock","w")) {
         fclose($fh);
         return 0;
      }
      else {
         $error = "The installation script could not create a lock file in 
         temp directory. 
         It is currently set to:
         <br />&nbsp;<br />
         " . TEMP_DIR . "
         </p>
         <p>
         Please check and make sure that this directory
         does exists and that it is set to the
         correct permission before you run dcadmin again.
         </p>";

         print_eula_page("Error in creating eula lock file",$error,
         "DCForum+ Installation Error");
         return 1;
      }
   }
   elseif ($in['donotagree']) {
         print_eula_page("End-user license agreement problem",
            "You have elected not to agree to the terms outlined in the End-User
            License Agreement.  If this is a mistake, please go back
            try again.","DCForum+ Installation Error");

      return 1;
   }
   else {
      print_eula_page("",          
            "Please read the following End-User License
            Agreement.<br />
            To continue with installation, click on \"Yes, I AGREE\" button.
            </p>
            $disclaimer","DCFORUM+ End-User Licensing Agreement");

      return 1;
   }

}

///////////////////////////////////////////////////////
// function print_eula_page
///////////////////////////////////////////////////////
function print_eula_page($error_heading,$errors,$title = '') {

   print_head("End user license agreement page");

   if ($title == '') {
      $title = "The page you requested cannot be displayed.";
   }

   if (is_array($errors)) {
      foreach ($errors as $error) {
         $temp .= "<li> $error</li>";
      }
      $errors = $temp;
   }

   // include top template file
   include_top('error.html');

   begin_table(array(
         'border'=>'0',
         'width' => '600',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

   $missing = "<img src=\"" . IMAGE_URL . "/missing.gif\" alt=\"\" />";

   print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrortitle\">$title<br />
          <span class=\"dcerrorsubject\">$error_heading</span></p></td></tr>";
   print "<tr class=\"dclite\"><td colspan=\"2\">$errors
          <p>
           If you have any questions, please contact the site administrator.<br />
          <a href=\"javascript:history.back()\">Click here to go back to previous page.</a></p>
          </td></tr>";
 
   end_table();


   print_tail();


}



?>

##### intellectual property rights notice

I've created this repository for a few reasons:

1. Persevere original DCForum+.
2. Bring the project to basic current day PHP support (8.x). (not intended for production!)
3. Eventually a complete rewrite of the project based on [Laravel](https://laravel.com).

I was active on several DCForum based boards during the early 2000's,    
And it is very nostalgic to me, I wish to bring it back to life,  
I have no commercial plans for the outcome of this project.  
DCFroum was a commercial project but in its last stages was released under GPL license.  
I maid several attempts to find the original owner of the rights (DC Scripts),  
But I did not have much success.  
If you have claims to any of the rights related to this project (code, artwork, trademarks, etc.)   
Please create a [github issue](https://github.com/DCForum/dcforum/issues/new) with your claim and I will address it
ASAP.

### Requirements

1. PHP 4.x
2. MySQL 3.23.x

### Changelog

#### Dev

* Converted "while each" loops to `foreach`.
* Migrated `mysql` functions to `mysqli`.
* Migrated `define` statements to `const`.
* Renamed `dcsetup.php` to `dcsetup.example.php` and added to gitignore.
* Added `dd` and `dump` functions to `dclib.php`.
* Migrated `array_push` on singles elements to `[]`.
* Removed timestamp size from mysql tables.
* Migrated empty strings on auto increment to null on sql inserts.
* Wrapped all array access in strings to `'{$arr['key']}'`.
* Changed all `NOT NULL DEFAULT...` to `NULL DEFAULT...`.
* Added `legacy_each` in `dclib.php`.
* Replaced `each` with `legacy_each`.
* Migrated `split('[\|]',` to `explode('|',`.
* Modified `check_email` to use `filter_var`.

#### 1.27.1

* Converted all files to utf-8.

#### --- Original readme file converted to markdown ---

DCForum+ Readme File
--------------------

DCForum+ Version 1.27  
Release Date 9-30-2006  
©1997-2005 DCScripts

This program is free software; you can redistribute it and/or modify  
it under the terms of the [GNU General Public License](./docs/license.html) as published by  
the Free Software Foundation; either version 2 of the License, or  
(at your option) any later version.

This program is distributed in the hope that it will be useful,  
but WITHOUT ANY WARRANTY; without even the implied warranty of  
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the  
GNU General Public License for more details.

You should have received a copy of the GNU General Public License  
along with this program; if not, write to the Free Software  
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

Getting Started...
------------------

Thank you for choosing DCForum+!

DCForum+ is a complete web conferencing software for building and managing an online discussion community. DCForum+ is
PhP/MySQL implementation of highly popular DCForum. Whether you are managing your company's online support program or
simply providing an interactive environment for internet users of common interest, you'll find the proven technology you
need in DCForum.

DCForum+ is developed to meet the following design goals:

1. **Easy Installation** - A typical DCForum+ installation requires editing only one setup file.
2. **PhP/MySQL**   - DCForum+ inherits its design from popular DCForum. Unlike DCForum, which is written in Perl and
   supports text-delimited database, DCForum+ is implemented using PhP with MySQL backend support and is capable of
   handling increased traffic.
3. **Clean and Intuitive User Interface** - The interface is the most important aspect of a good forum software. It is
   imperative to keep it clean, intuitive, and user-friendly.
4. **Easily Customizable Interface** - The overall layout of the forum must be easily customizable in order to expedite
   the integration process of the forum to the rest of your site. You can accomplish this by modifying two template
   files
5. **Fully Threaded Style of Discussion** - While users can select to use  **linear discussion style**, we strongly
   believe that the fully threaded discussion format is the ideal style for a web conferencing software. Unlike the
   linear messaging style boards, DCForum allows one-to-one interaction among forum users and reduces the difficulty of
   subscribing to a particular thread among thousands of posts.
6. **NEW - Multiple language option** - With DCF+ 1.2, you can now allow your users to use different language to display
   forum information. The initial release will only include English modules but future release will contain additional
   modules

DCForum+ supports a wide variety of web servers running on both UNIX (LINUX, SOLARIS, FREEBSD, etc) and Windows server
platforms. The only requirement for running DCForum+ is that your web server supports PhP application with MySQL backend
support. With proven software backed by our devoted support staff, you can now begin focusing on building your
community.

Thank you again for choosing DCForum+.

David S. Choi  
President  
DCScripts.com

DCForum Features and Overview
-----------------------------

Installation
------------

Following is a list of installation documents. Please choose a document that meets your installation needs:

* New Installation
    * [Non-Windows Server](./docs/install_unix.html)
    * [Windows Server](./docs/install_nt.html)
* Upgrade Installation
    * [Upgrading from DCForum Version 6.2x](./docs/upgrade_623.html)
    * [Upgrading from DCForum+ 1.0x](./docs/upgrade_10x_12.html)
    * [Upgrading from DCForum+ 1.1x](./docs/upgrade_11x_12.html)
    * [Upgrading from DCForum+ 1.2 - 1.25](./docs/upgrade_12_122.html)

To upgrade from an older version of DCForum, please first upgrade to DCForum Version 6.23 and use above documentation.

We also offer new and upgrade installation service. The service charge for a new installation is $85 while upgrade
installation prices vary depending on which version of DCForum you are currently running. Please email us at
support@dcscripts.com for more information.

After you install DCForum, please read the [Administrator User's Guide](./docs/admin.html) for post-installation
instructions to complete your forum setup.

Need Help?
----------

The best place to look for DCForum help is our support forums. Please check it out at

[http://www.dcscripts.com/dc/dcboard.php](http://www.dcscripts.com/dc/dcboard.php)

You can also email our support at support@dcscripts.com for any questions regarding DCForum.

* * *

© 1997-2005 DCScripts.com - All rights reserved  
DCScripts.com is a division of DC Business Solutions
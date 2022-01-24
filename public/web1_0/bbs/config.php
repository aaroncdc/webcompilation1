<?php

// The title of your BBS. This will be displayed in the header.
$bbs_title = "BBS";

// The CSS file for your BBS.
$bbs_css = "blog.css";

// Root directory (Where the board structure is stored)
$root = "boards/";

// Enables the use of a MOTD file. Set it to 'false' if you don't want one.
$enable_motd = true;

// Location of your MOTD file. Will be displayed in the header.
$motd_file = "motd.md";

//  Salt used by the Crypt function
$salt = "insert a long, random string here for the salt and don't tell your friends about it.";

// Salt rounds. The higher the safest, but also the most CPU consuming.
$crypt_sha_rounds = 5000;

// Maximum length for the name field. Values higher than this will be trimed down to this value.
$max_name_length = 32;

// Permissions for topic folders.
$folder_chmod = 0770;

// Date format for the posts.
$post_dateformat = 'l j \o\f F \o\f Y H:i:s';

// Minimum number of characters required for your post. This can't be less than 0.
$minimum_message_characters = 5;

// Maximum character limit for the posts.
$char_limit = 4089; 

?>
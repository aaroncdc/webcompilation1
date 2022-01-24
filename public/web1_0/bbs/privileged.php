<?php

/*
* VERIFIED USERS
* "Verified" users are just trustworthy users from the BBS. Their name hash
* will be highlighted in a blue color. This hints other users that their
* content can be somewhat trustworthy. Regular users won't see their name
* highlighted in any way.
*
* To verify an user, add their name hash to the following array. The name
* hash is a hash code that identifies each user. This hash is produced by
* using the Crypt() function on their name, so the name they enter in the
* Name field when posting will produce a specific hash code that never
* changes for that Name, identifying them while still remaining anonymous.
*
* The function uses SHA-256 as it's hashing algorithm. This should be safe
* against collisions. However, to be completely safe, I made it so that it
* also produces a hash of the name reversed, and interlaces both hashes into
* one single hash string. If the user also inputs a strong user name with
* 20 or more characters and using all sort of characters (a password,
* essentially), it should be pretty resilient against bruteforce attacks too.
*
* This doesn't grant any extra privileges to the users, it's just a trust
* system in a completely anonymous environment. The administrator has their
* name highlighted in purple with two exclamation signs at the beginning.
*
*/

$privileged = [
	"",
];

/* This is the name hash of the admin. */
$admin = "";

?>
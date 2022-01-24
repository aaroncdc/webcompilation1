<?php
    
/* !! VERY IMPORTANT !! This file must be HIDDEN from the server */
	
	// HOSTNAME: Name of the host to connect to. Usually localhost, 127.0.0.1, whatever.
	$hostname_ = 'localhost';
	
	// DB USERNAME: Username of the database administrator.
	$dbusername = 'server';
	
	// DB PASSWORD: Password of the database administrator.
	$dbpassword = 'xZ34_n$6gY';
	
	/* !!! - DO NOT MODIFY THE FOLLOWING LINES IF YOU HAVE ALREADY INSTALLED ZULAIJEN - !!! */
	
	// DB NAME: Name of the database to use.
	// REMEMBER TO CHANGE THE DATABASE NAME IN SQL/INSTALL.SQL ACCORDINGLY
	$dbname = 'safeme';
	
	// TABLE PREFIX: Every table name will start with this prefix.
	// This is usefull when you are installing Zulaijen in a database with existing tables,
	// so it's easy to distinguish which tables are Zulaijen's.
	$tabprefix = 'sm_';
	
	//MD5 Hash: Key to use for RNG and encryption.
	$md5hash_ = '9e8dgj7we1kma+`zxc´çñak53h23ihcv097756qk235m,zgc`p23\'9svkl@3';
	
	// CHECK CLIENT ADDRESS: This is only for the autoinstaller script. When set to TRUE,
	// the autoinstaller will check if the requester IP/HOST address is within a list of
	// trusted addresses. If it is, it will continue the installation. Otherwise, it wont.
	// When set to FALSE, it will proceed with the installation disgregarding where it is
	//being called from.
	
	// I recommend setting this to TRUE, but don't forget to add your address to the list,
	// in SQL/.trusted.php. If set to FALSE, delete the install.php files inside the root
	// directory after you are done with the installation, or set this var back to TRUE.
	$checkclientaddr = true;
	
	/*--  DO NOT TOUCH THESE LINES --*/
    define('hostname', $hostname_);
    define('db_username', $dbusername);
    define('db_password',$dbpassword);
    define('db_name', $dbname);
    define('tab_prefix', $tabprefix);
    define('md5hash', $md5hash_);
	define('autoconnect', true);
?>
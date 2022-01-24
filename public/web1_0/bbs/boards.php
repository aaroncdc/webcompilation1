<?php

/*
* HOW TO ADD MORE BOARDS
*
* 1. Create the board structure in the 'boards' folder. Example:
* for a board named 'alt.memes', you would create a folder named
* 'alt' inside of 'boards', then a subdirectory named 'memes' inside
* of 'alt'. Give it permissions if needed.
* 2. Add the structure to this array, as "domain.board" => "Description".
* Example: "alt.memes" => "Much memes!",
* 3. Add an empty 'index.html' file into each of the directories.
* 4. Done.
*
* HOW DO TOPICS AND POSTS WORK
* 
* Topics are essentially folders inside the board directory, and posts are
* just markdown files (.md) inside the topic directories. The first post of
* every topic is called "main.md", and the replies have the date and time of
* the post as it's name, in "YYYYMMDDHHmmSS" format.
*
* Example: A post made on Sunday 22 of February of 2021 at 17:12:29 would
* have it's name set to "20210221171229.md".
* This makes it easier to implement additional server software for the BBS,
* as all you have to do is to read or write in your file structure, having
* your posts organized alphabetically if you want to read them recursively.
* No databases needed or any sort of complex stuff.
*
*/

$boards = [
	"alt.anime" => "Japanese animation",
	"alt.ascii" => "ASCII art",
	"alt.bbs" => "BBS meta board",
	"alt.cats" => "Meow!",
	"alt.cats.arebeautiful" => ";-)",
	"alt.compooters" => "Computers",
	"alt.electronics" => "Bread boards are not edible",
	"alt.finances" => "Stonk market",
	"alt.finances.crypto" => "Bankers hate them",
	"alt.games" => "Games in general",
	"alt.hacking" => "How to PWN this server",
	"alt.news" => "How does the world suck today?",
	"alt.politics" => "Controversial",
	"alt.politics.left" => "Left and communism",
	"alt.politics.right" => "Right and capitalism",
	"alt.random" => "Random stuff",
	"alt.videogames" => "For the gamerz!!!1! lulz",
];


?>
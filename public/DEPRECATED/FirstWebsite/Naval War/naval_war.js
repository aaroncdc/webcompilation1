
<!-- THREE STEPS TO INSTALL BATTLESHIP:

  1.  Copy the coding into the HEAD of your HTML document
  2.  Add the last code into the BODY of your HTML document
  3.  Save the battleship images into your web site directory  -->

<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

<HEAD>

<style type="text/css">
.intro { font-size:10pt; font-style:italic }
.heading { font-size:14pt; font-weight:bold; font-family:sans-serif }
.title { font-size:18pt; font-weight:bold; background-color:navy; color:white; text-align:center; font-family:sans-serif }
</style>
</HEAD>

<!-- STEP TWO: Copy this code into the BODY of your HTML document  -->

<BODY>

<SCRIPT LANGUAGE="JavaScript">
<!-- Original:  Jason Hotchkiss (jasonhotchkiss@home.com) -->
<!-- Web Site:  http://www.members.home.com/jasonhotchkiss -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
/* Information used to draw the ships
*/
var ship =  [[[1,5], [1,2,5], [1,2,3,5], [1,2,3,4,5]], [[6,10], [6,7,10], [6,7,8,10], [6,7,8,9,10]]];

/* Information used to draw sunk ships
*/
var dead = [[[201,203], [201,202,203], [201,202,202,203], [201,202,202,202,203]], [[204,206], [204,205,206], [204,205,205,206], [204,205,205,205,206]]];

/* Information used to describe ships
*/
var shiptypes = [["Minesweeper",2,4],["Frigate",3,4],[ "Cruiser",4,2],[ "Battleship",5,1]];

var gridx = 16, gridy = 16;
var player = [], computer = [], playersships = [], computersships = [];
var playerlives = 0, computerlives = 0, playflag=true, statusmsg="";

/* Function to preload all the images, to prevent delays during play
*/
var preloaded = [];
function imagePreload() {
var i,ids = [1,2,3,4,5,6,7,8,9,10,100,101,102,103,201,202,203,204,205,206];
window.status = "Preloading images...please wait";
for (i=0;i<ids.length;++i) {
var img = new Image, name = "batt"+ids[i]+".gif";
img.src = name;
preloaded[i] = img;
}
window.status = "";
}

/* Function to place the ships in the grid
*/
function setupPlayer(ispc) {
var y,x;
grid = [];
for (y=0;y<gridx;++y) {
grid[y] = [];
for (x=0;x<gridx;++x)
grid[y][x] = [100,-1,0];
}

var shipno = 0;
var s;
for (s=shiptypes.length-1;s>=0;--s) {
var i;
for (i=0;i<shiptypes[s][2];++i) {
var d = Math.floor(Math.random()*2);
var len = shiptypes[s][1], lx=gridx, ly=gridy, dx=0, dy=0;
if ( d==0) {
lx = gridx-len;
dx=1;
}
else {
ly = gridy-len;
dy=1;
}
var x,y,ok;
do {
y = Math.floor(Math.random()*ly);
x = Math.floor(Math.random()*lx);
var j,cx=x,cy=y;
ok = true;
for (j=0;j<len;++j) {
if (grid[cy][cx][0] < 100) {
ok=false;
break;
}
cx+=dx;
cy+=dy;
   }
} while(!ok);
var j,cx=x,cy=y;
for (j=0;j<len;++j) {
grid[cy][cx][0] = ship[d][s][j];
grid[cy][cx][1] = shipno;
grid[cy][cx][2] = dead[d][s][j];
cx+=dx;
cy+=dy;
}
if (ispc) {
computersships[shipno] = [s,shiptypes[s][1]];
computerlives++;
}
else {
playersships[shipno] = [s,shiptypes[s][1]];
playerlives++;
}
shipno++;
   }
}
return grid;
}

/* Function to change an image shown on a grid
*/
function setImage(y,x,id,ispc) {
if ( ispc ) {
computer[y][x][0] = id;
document.images["pc"+y+"_"+x].src = "batt"+id+".gif";
}
else {
player[y][x][0] = id;
document.images["ply"+y+"_"+x].src = "batt"+id+".gif";
   }
}

/* Function to insert HTML source for a grid
*/
function showGrid(ispc) {
var y,x;
for (y=0;y<gridy;++y) {
for (x=0;x<gridx;++x) {
if ( ispc )
document.write ('<a href="javascript:gridClick('+y+','+x+');"><img name="pc'+y+'_'+x+'" src="batt100.gif" width=16 height=16></a>');
else
document.write ('<a href="javascript:void(0);"><img name="ply'+y+'_'+x+'" src="batt'+player[y][x][0]+'.gif" width=16 height=16></a>');
}
document.write('<br>');
   }
}

/* Handler for clicking on the grid
*/
function gridClick(y,x) {
if ( playflag ) {
if (computer[y][x][0] < 100) {
setImage(y,x,103,true);
var shipno = computer[y][x][1];
if ( --computersships[shipno][1] == 0 ) {
sinkShip(computer,shipno,true);
alert("You sank my "+shiptypes[computersships[shipno][0]][0]+"!");
updateStatus();
if ( --computerlives == 0 ) {
alert("You win! Press the Refresh button on\n"+
"your browser to play another game.");
playflag = false;
}
   }
if ( playflag ) computerMove();
}
else if (computer[y][x][0] == 100) {
setImage(y,x,102,true);
computerMove();
      }
   }
}

/* Function to make the computers move. Note that the computer does not cheat, oh no!
*/
function computerMove() {
var x,y,pass;
var sx,sy;
var selected = false;

/* Make two passes during 'shoot to kill' mode
*/
for (pass=0;pass<2;++pass) {
for (y=0;y<gridy && !selected;++y) {
for (x=0;x<gridx && !selected;++x) {
/* Explosion shown at this position
*/
if (player[y][x][0]==103) {
sx=x; sy=y;
var nup=(y>0 && player[y-1][x][0]<=100);
var ndn=(y<gridy-1 && player[y+1][x][0]<=100);
var nlt=(x>0 && player[y][x-1][0]<=100);
var nrt=(x<gridx-1 && player[y][x+1][0]<=100);
if ( pass == 0 ) {
/* On first pass look for two explosions
   in a row - next shot will be inline
*/
var yup=(y>0 && player[y-1][x][0]==103);
var ydn=(y<gridy-1 && player[y+1][x][0]==103);
var ylt=(x>0 && player[y][x-1][0]==103);
var yrt=(x<gridx-1 && player[y][x+1][0]==103);
if ( nlt && yrt) { sx = x-1; selected=true; }
else if ( nrt && ylt) { sx = x+1; selected=true; }
else if ( nup && ydn) { sy = y-1; selected=true; }
else if ( ndn && yup) { sy = y+1; selected=true; }
}
else {
/* Second pass look for single explosion - 
   fire shots all around it
*/
if ( nlt ) { sx=x-1; selected=true; }
else if ( nrt ) { sx=x+1; selected=true; }
else if ( nup ) { sy=y-1; selected=true; }
else if ( ndn ) { sy=y+1; selected=true; }
            }
         }
      }
   }
}
if ( !selected ) {
/* Nothing found in 'shoot to kill' mode, so we're just taking
   potshots. Random shots are in a chequerboard pattern for 
   maximum efficiency, and never twice in the same place
*/
do{
sy = Math.floor(Math.random() * gridy);
sx = Math.floor(Math.random() * gridx/2)*2+sy%2;
} while( player[sy][sx][0]>100 );
}
if (player[sy][sx][0] < 100) {
/* Hit something
*/
setImage(sy,sx,103,false);
var shipno = player[sy][sx][1];
if ( --playersships[shipno][1] == 0 ) {
sinkShip(player,shipno,false);
alert("I sank your "+shiptypes[playersships[shipno][0]][0]+"!");
if ( --playerlives == 0 ) {
knowYourEnemy();
alert("I win! Press the Refresh button on\n"+
"your browser to play another game.");
playflag = false;
      }
   }
}
else {
/* Missed
*/
setImage(sy,sx,102,false);
   }
}

/* When whole ship is hit, show it using changed graphics
*/
function sinkShip(grid,shipno,ispc) {
var y,x;
for (y=0;y<gridx;++y) {
for (x=0;x<gridx;++x) {
if ( grid[y][x][1] == shipno )
if (ispc) setImage(y,x,computer[y][x][2],true);
else setImage(y,x,player[y][x][2],false);
      }
   }
}

/* Show location of all the computers ships - when player has lost
*/
function knowYourEnemy() {
var y,x;
for (y=0;y<gridx;++y) {
for (x=0;x<gridx;++x) {
if ( computer[y][x][0] == 103 )
setImage(y,x,computer[y][x][2],true);
else if ( computer[y][x][0] < 100 )
setImage(y,x,computer[y][x][0],true);
      }
   }
}

/* Show how many ships computer has left
*/
function updateStatus() {
var f=false,i,s = "Computer has ";
for (i=0;i<computersships.length;++i) {
if (computersships[i][1] > 0) {
if (f) s=s+", "; else f=true;
s = s + shiptypes[computersships[i][0]][0];
   }
}
if (!f) s = s + "nothing left, thanks to you!";
statusmsg = s;
window.status = statusmsg;
}
function setStatus() {
window.status = statusmsg;
}
/* Start the game!
*/
imagePreload();
player = setupPlayer(false);
computer = setupPlayer(true);
document.write("<center><table><tr><td align=center><p class='heading'>COMPUTER'S FLEET</p></td>"+
"<td align=center><p class='heading'>PLAYER'S FLEET</p></td></tr><tr><td>");
showGrid(true);
document.write("</td><td>");
showGrid(false);
document.write("</td></tr></table></center>");
updateStatus();
setInterval("setStatus();", 500);
//  End -->
</script>

<p class="intro">"...We have located the enemy fleet under the command of Admiral Komp�ter,
but do not yet have visual contact. We suggest the best course of action is to fire
at random into their vicinity and listen for the impact of the shells...</p>
<p class="intro">...Our intelligence sources indicate the composition of the enemy fleet is the same 
as our own, and has likewise been forced to resort to the same tactics as ourselves. In accordance with 
the rules of war, fire will be exchanged one shell at a time and vessels lost will be announced 
immediately...</p>
<p class="intro">...As per your orders you have been placed directly in command of the fleet's guns. Select the target
location by clicking in the left-hand grid above. The right hand grid shows the status of our own fleet.
Information as to the remaining strength of the enemy will be relayed directly to your status bar...</p>
<p class="intro">...We believe this battle will not be over until one or other fleet is sunk in it's entirety. Our gunners 
await your commands. We're counting on you, Sir..."</p>

<!-- STEP THREE: Save the battleship images into your web site directory

You can get the zip file by going to

http://javascript.internet.com/img/battleship/battleship.zip

then unzip the images and upload to your site.  -->

<p><center>
<font face="arial, helvetica" size="-2">Free JavaScripts provided<br>
by <a href="http://javascriptsource.com">The JavaScript Source</a></font>
</center><p>

<!-- Script Size:  9.06 KB -->
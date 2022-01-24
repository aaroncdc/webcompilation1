<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.:: El Depredador Rojo ::.</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	font-size: 24px;
	color: #000000;
}
.Estilo2 {font-size: 18px}
-->
</style>
</head>

<body>
<table width="779" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td style="border:solid #000000" height="110" colspan="2" valign="top"><img src="header.png" width="771" height="110" /></td>
  </tr>
  <tr>
    <td width="230" height="37" valign="top"  style="border:solid #000000"><span class="Estilo2">&Uacute;LTIMAS ENTRADAS </span></td>
    <td width="549" valign="top" style="border:solid #000000"><span class="Estilo1"><a href="blog.php">BLOG</a> | <a href="archive.php">ARCHIVO</a> | <a href="/4img/index.php">IMAGENES</a> | <a href="personal.php">PERSONAL</a> </span></td>
  </tr>
  
  <tr>
    <td height="531" align="left" valign="top"  style="border:solid #000000">
	<marquee direction="down" scrolldelay="200">

      <div align="left">
        <?php
	require("res/connect.php");
	$count = 0;
	$result = mysql_query('SELECT id, titulo FROM entradas ORDER BY id DESC');
	do {
		$count++;
		if($row['id'] != 0 || $row['id'] !=null){
		echo "<font size=2> <a href=\"blog.php?entry=" . $row['id'] . "\">· " . $row['titulo'] . " ·</a></font><br><br>";
		if($count == 10){
		echo '<br><a href="archive.php">- Mas -</a>';
			exit;
		}
		}
} while ($row = mysql_fetch_array($result));
echo '<br><a href="archive.php">- Mas -</a>';
	?>
        </div>
	</marquee>	&nbsp;
	<div align="center"><br />
	  - SHOUTBOX - <br />
	  <style type="text/css">
 #yellbox { width: 160px; text-align: center; }
 #yellbox iframe { height: 300px; border: 1px inset; margin: 0px; width: 90%; }
 #yellbox input { width: 90%; }
 #yellbox button { height: 25px; }
      </style>
	  
	  </div>	<div id="yellbox">
 <div align="center">
   <script language="Javascript" type="text/javascript" src="http://www.yellbox.com/ybscript.js"></script>
   <noscript>
     <a href="http://www.yellbox.com">Shoutbox</a>, <a href="http://www.imsdb.com">Movie Scripts</a>, <a href="http://resizepic.com">Resize Images</a>, <a href="http://www.domainsellout.com">Domains for sale</a>, <a href="http://www.wallpaperist.com">Wallpapers</a>, <a href="http://www.avatarist.com">Avatars</a>, <a href="http://www.wiisworld.com">Wii</a>, <a href="http://www.tonyhawkguide.com">Tony Hawk</a>, <a href="http://www.rateslist.com">Exchange Rates</a>
     </noscript>
   
 </div>
 <iframe name="ybframe" frameborder="0" src="http://www.yellbox.com/yellbox.php?name=magnus9998"></iframe>

 <form action="http://www.yellbox.com/addmessage.php" method="post" target="ybframe" name="yellform" style="margin: 1px;"> 
   <div align="center">
     <input type="hidden" name="sub_username" value="magnus9998" />
     <input name="sub_name" value="Name" maxlength="10" onfocus="if(this.value == 'Name')this.value = '';" />
     <br />
     <input name="sub_message" value="Message" maxlength="255" onfocus="if(this.value == 'Message')this.value = '';" />
     <br />
     <button onclick="return clearMessageBox();" style="width: 70%;">Say</button>
     <button onclick="javascript:makeNewWindow(); return false;" style="width: 20%; border: none; background-color: transparent;"><img src="http://www.yellbox.com/images/smile.gif" alt="Smileys" /></button>
   </div>
 </form>
</div></td>
  <td valign="top" style="border:solid #000000"><?php include("main.php"); ?>      &nbsp;</td>
  </tr>
</table>
</body>
</html>
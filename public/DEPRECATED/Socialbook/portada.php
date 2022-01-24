<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
	session_start();
	require_once('tools/jbbinit.php');
    require_once ('tools/sbtools.php');
	getAndCheck();
	$_SESSION['lastpost'] = null;
?>
<html>
    <head>
        <title>Socialbook - Portada</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/socialbook.css" rel="stylesheet" type="text/css"/>
		<script src="js/jquery-1.12.0.js" type="text/javascript"></script>
		<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
		<script src="js/dropzone.js" type="text/javascript"></script>
		
		<script>
		tinymce.init({
			selector:'#ttextarea',
			skin:'custom',
			plugins : "bbcode colorpicker image imagetools textcolor emoticons link",
			imagetools_proxy: 'imgproxy.php',
			toolbar: "undo redo | styleselect | bold italic | justifyleft justifycenter justifyright | bullist numlist | link image | forecolor | emoticons ",
			imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
			theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "bottom",
			theme_advanced_toolbar_align : "center",
			theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
			entity_encoding : "raw",
			add_unload_trigger : false,
			remove_linebreaks : false,
			inline_styles : false,
			convert_fonts_to_spans : false
		});
		
		 
		function updatecover(){
			$.ajax({
				url: "container.php",
				method: "POST",
				type: "POST",
				data: {
					usermail: usmail,
					usersid: ussid
				},
				success:function(data){
					if(data != "" && data != null && data != ".!E")
						$("#entradas").prepend(data);
					else if(data.indexOf(".!E") != -1)
						$("#entradas").prepend("<article><center><b>ERROR: " + data.substring(3) +" </b></center></article>");
				}
			});
		}
		
		function newpost(){
			$.ajax({
				url: "post_text.php",
				method: "POST",
				type: "POST",
				data: {
					usermail: usmail,
					usersid: ussid,
					txtentrada: tinymce.get('ttextarea').getContent()
				},
				success:function(data){
					if(data=="update")
					{
						updatecover();
						txtentrada: tinymce.get('ttextarea').setContent("");
					}else{
						alert("Error al enviar el mensaje");
					}
					//alert("vale");
				}
			});
		}
		
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) {
				var c = ca[i];
					while (c.charAt(0)==' ') c = c.substring(1);
						if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
			}
			return "";
		}
		
		var ussid = unescape(getCookie("sessionid"));
		var usmail = unescape(getCookie("sessionmail"));
		
		</script>
		
    </head>
    <body>
		<?php include('template/head.php'); ?>
        <aside class="hiddenlist" id="side-list"><center>
		<?php
			$lf = listAllFriends($usmail, $ussid);
			while($fid = $mysqlman->sqlfetchassoc_ns($lf))
			{
				$res = $mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE IDNO = $fid[REL]");
				$fdata = $mysqlman->sqlfetchassoc_ns($res);
				$extensions = array('.jpg','.png','.gif');
				$imgurl = "";
				for($i = 0; $i < sizeof($extensions); $i++)
				{
					if(file_exists("perfiles/$fid[REL]/$fid[REL]$extensions[$i]"))
						$imgurl = "perfiles/$fid[REL]/$fid[REL]$extensions[$i]";
				}
					
				if($imgurl == "")
					$imgurl = "static/person.png";
				
				echo("<a href=\"perfil.php?uid=$fid[REL]\"><img src=\"$imgurl\" class=\"prof-side\"/></a>");
			}
		?></center>
		<div class="listborder" id="listborder"></div>
		</aside>
        <br/><br/><br/><br/>
        <!-- Artículo -->
		<article id="newentry" name="newentry">
        <?php
			if(!isLoggedIn())
			{
				echo("<center><b>NO HAS INICIADO SESIÓN</b></center>");
			}else{
				echo("<center><b>Hola, " . $usname . "</b></center>");
			}
		?>
		<center>¡Cuentanos algo!<br/>
			<form name="newentry" action="post_text.php" method="post">
				<textarea id="ttextarea" name="txtentrada" cols="30" rows="6" class="entrada"></textarea><br>
				<input type="button" class="button" value="¡Dale!" id="newpost" />
			</form>
		</center>
		</article>
		<div id="entradas">
		<script type="text/javascript">
		
		$(document).ready(function(){
		
			$("#newpost").click(function(){
				newpost();
			});
			
			$("#newentry").dropzone({
				url: "tools/imgupload.php",
				//previewsContainer: false,
				acceptedFiles: "image/*",
				//createImageThumbnails: false,
				autoProcessQueue: true
			});
			
			$("#ttextarea").dropzone({
				url: "tools/imgupload.php",
				//previewsContainer: false,
				acceptedFiles: "image/*",
				//createImageThumbnails: false,
				//autoProcessQueue: true
			});
			
			var flist_status = false;
			
			$("#listborder").click(function(){
				flist_status = !flist_status;
				if(!flist_status)
					$("#side-list").attr("class", "hiddenlist");
				else
					$("#side-list").attr("class", "friendlist");
			});
			
			Dropzone.options.newentry={
				paramName: "file",
				maxFilesize: 2,
				//autoProcessQueue: true,
				accept: function(file) {
					alert(file.name);
				}
			};
			
			Dropzone.options.ttextarea={
				paramName: "file",
				maxFilesize: 2,
				autoProcessQueue: true,
				accept: function(file) {
					alert(file.name);
				}
			};
			
			btnEvents();
			updatecover();
			setInterval("updatecover()", 5000);
		});
		</script>
    </body>
</html>
<?php
	$mysqlman->endconnection();
?>
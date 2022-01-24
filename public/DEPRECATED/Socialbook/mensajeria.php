<?php
	session_start();
	require_once('tools/jbbinit.php');
    require_once ('tools/sbtools.php');
	
	if(isset($_GET['uid']))
		$foreign = $_GET['uid'];
	
	if(!isset($foreign))
	{
		if(!getAndCheck())
			die('Error en la sesión');
	
		$usinfo = getUsInfo($usmail, $ussid);
		if(!$usinfo)
			die('Error en el usuario');
		$id = getUsId($usmail, $ussid);
	}else{
		$mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE IDNO='$foreign'");
		$usinfo = $mysqlman->sqlfetchassoc();
	}
	
	$_SESSION['lastpost'] = null;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Socialbook - Mensajería</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8"/>
        <link href="css/socialbook.css" rel="stylesheet" type="text/css"/>
		<script src="js/jquery-1.12.0.js" type="text/javascript"></script>
		<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		function friendDeny(a,b) {
			window.location.href='amistad.php?aid='+a+'&bid='+b+'&act=-1';
		}
		
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
		
		function newpost(){
			$.ajax({
				url: "post_message.php",
				method: "POST",
				type: "POST",
				data: {
					usermail: usmail,
					usersid: ussid,
					//dest_input: $('#txtDest').val(),
					dest_select: $('#lCont').val(),
					txtentrada: tinymce.get('ttextarea').getContent()
				},
				success:function(data){
					if(data==".!S")
					{
						txtentrada: tinymce.get('ttextarea').setContent("");
						alert("Mensaje enviado con éxito!");
					}else{
						alert(data.substring(3));
					}
				}
			});
		}
		
		function update(){
			$.ajax({
				url: "updatemsg.php",
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
		
		function delmsg(msgid){
			$.ajax({
				url: "commands.php",
				method: "POST",
				type: "POST",
				data: {
					usermail: usmail,
					usersid: ussid,
					command: 0,
					param: msgid
				},
				success:function(data){
					if(data != "" && data != null && data.search(".!E") == 0){
						alert("MENSAJE BORRADO");
						$("#entradas").html = "";
						update();
					}else if(data.substring(0,3) == ".!E")
						alert("ERROR: " + data.substring(3));
				}
			});
		}
		
		$(document).ready(function(){
			$('#newpost').click(function(){
				newpost();
				update();
			});
			
			update();
			setInterval("update()", 3000);
		});
		</script>
	</head>
	<body>
	<?php include('template/head.php'); ?>
	<br/><br/><br/>
    
    <article id="newentry" name="newentry">
				<center><b>Nuevo Mensaje</b><br/></center>
			<form name="newmessage" action="post_message.php" method="post">
            <table>
            <tr>
            	<!--<td><label for="dest">Para: </label></td>
                <td><input type="text" name="dest" id="txtDest" class="text" placeholder="Destinatario" style="width: 256px"></td>-->
                </tr><tr><td><label for="">Destinatario: </label></td>
                <td><select id="lCont" name="selContactos">
                <?php
					$friends = listAllFriends($usmail, $ussid);
					while($list = $mysqlman->sqlfetchassoc_ns($friends))
					{
						$friend = $mysqlman->sqlquery("SELECT NOM, APE1, APE2 FROM USUARIOS WHERE IDNO=$list[REL]");
						$fdata = $mysqlman->sqlfetchassoc_ns($friend);
						echo("<option value=".$list['REL'].">" . $fdata['NOM'] . " " . $fdata['APE1'] . " " . $fdata['APE2'] . "</option>");
					}
				?>
                </select></td></tr>
               </table>
                <hr/>
				<center><textarea id="ttextarea" name="txtentrada" cols="30" rows="6" class="entrada"></textarea><br>
				<input type="button" class="button" value="¡Dale!" id="newpost" />
			</form>
		</center>
	</article>
    <div id="entradas">

	</div>
	</body>
</html>
<?php
	$mysqlman->endconnection();
?>
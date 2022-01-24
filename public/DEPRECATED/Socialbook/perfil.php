<?php
	require_once('tools/jbbinit.php');
    require_once ('tools/sbtools.php');
	
	if(isset($_GET['uid']))
		$foreign = $_GET['uid'];
	
		if(!getAndCheck())
			die('Error en la sesión');
	
		$usinfo = getUsInfo($usmail, $ussid);
		if(!$usinfo)
			die('Error en el usuario');
		$id = getUsId($usmail, $ussid);
	if(isset($foreign)){
		$mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE IDNO='$foreign'");
		$usinfo = $mysqlman->sqlfetchassoc();
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width-device-width, initial-scale=1"/>
<meta charset="utf-8"/>
<link href="css/socialbook.css" rel="stylesheet" type="text/css"/>
<title>Mi perfíl - Socialbook</title>
<script src="js/jquery-1.12.0.js" type="text/javascript"></script>
<script type="text/javascript">
function friendRequest(a,b) {
	window.location.href='amistad.php?aid='+a+'&bid='+b+'&act=1';
}
function bloqRequest(a,b) {
	window.location.href='amistad.php?aid='+a+'&bid='+b+'&act=-2';
}
function ignoreRequest(a,b) {
	window.location.href='amistad.php?aid='+a+'&bid='+b+'&act=2';
}
</script>
</head>
<body>
		<?php include('template/head.php'); ?>
		<br/><br/><br/><br/>
        <center>
		<table class="profile-table">
		<tr>
		<td valign="top">
		<img src=<?php
			$maindir = 'perfiles/'.$usinfo['IDNO'].'/'.$usinfo['IDNO'];
			$extensions = array('.jpg','.png','.gif');
			$found = false;
			for($i = 0; $i < sizeof($extensions); $i++)
			{
				if(file_exists('perfiles/'.$usinfo['IDNO'].'/'.$usinfo['IDNO'].$extensions[$i]))
				{
					echo('"perfiles/'.$usinfo['IDNO'].'/'.$usinfo['IDNO'].$extensions[$i].'"');
					$found = true;
				}
			}
			if(!$found)
				echo('"static/person.png"');
		?>class="profile-pic" id="profile-pic"/>
		<div style="opacity: 0; position:fixed;">
		<input type="file" name="imgfile" id="imgfile"/>
		</div>
		<script type="text/javascript">
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
		var data = new FormData();
			$("#profile-pic").click(function(){
			<?php
				if(!isset($foreign) || $foreign != $usinfo['IDNO'])
					echo("$(\"#imgfile\").trigger('click');");
			?>
				
				$("#imgfile").change(function(){
					
					$.each(jQuery("#imgfile")[0].files, function(i,file){ data.append('file-'+i, file); });
					data.append('usmail', usmail);
					data.append('ussid', ussid);
					
					$.ajax({
						url: 'tools/uploader.php',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function(data){
							var d = new Date();
							<?php
							if(!isset($foreign))
								echo("$(\"#profile-pic\").attr(\"src\",data+\"?\"+d.getTime());");
								?>
						},
						error: function(){
								
						}
					});
					
				});
			});
			
			btnEvents();
		</script>
		<br/>
		<p align="center" class="p-caption">Click en la imágen para cambiarla</p></td>
		<td valign="top" class="perfil">
				<b>Nombre: </b><br/>
				<?php echo $usinfo['NOM']; ?><br/><br/>
				<b>Apellidos: </b><br/>
				<?php echo $usinfo['APE1'] . " " . $usinfo['APE2']; ?><br/><br/>
				<b>Dirección: </b><br/>
				<?php echo $usinfo['DIRECC']; ?><br/><br/>
				<b>País: </b><br/>
				<?php echo $usinfo['PAIS']; ?><br/><br/>
				<?php
					if(isset($foreign) && !isFriend($foreign, $id))
					{
						if($foreign != $id)
							echo('<input type="button" class="button" value="Solicitúd de amistad" onclick="friendRequest('.$usinfo['IDNO'].','.$id.');"/>');
					}else if(isset($foreign) && isFriend($foreign, $id))
					{
							echo('<input type="button" class="button" value="Dejar de seguir" onclick="ignoreRequest('.$usinfo['IDNO'].','.$id.');"/>');
							echo('<input type="button" class="button" value="Bloquear" onclick="bloqRequest('.$usinfo['IDNO'].','.$id.');"/>');
					}
				?>
		</td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="perfil">
				<b>Fecha de Nacimiento: </b><br/>
				<?php echo $usinfo['BDATE']; ?><br/><br/>
				<b>Teléfono (Fijo): </b><br/>
				<?php echo $usinfo['TELF1']; ?><br/><br/>
				<b>Teléfono (Movil): </b><br/>
				<?php echo $usinfo['TELF2']; ?><br/><br/>
				<b>Correo:</b><br/>
				<?php echo $usinfo['USMAIL']; ?><br/><br/>
				<b>Tu descripción: </b><br/>
				<?php echo $usinfo['DESCRIP']; ?><br/><br/>
        
        </td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="perfil">
        
        
        </td>
		</tr>
		</table>
        </center>
</body>
</html>
<?php
	$mysqlman->endconnection();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width-device-width, initial-scale=1"/>
        <link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
		<link href="css/solarized.css" rel="stylesheet" type="text/css"/>
        
        <script src="res/country-esp.js" type="text/javascript"></script>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
        <script src="js/jquery.kwicks-1.5.1.pack.js" type="text/javascript"></script>
        <title>Register in CMS network</title>
        
        <script type="text/javascript">
		var dirclear = false;
                function calcularDias(){
                    
                    var mes = parseInt($("#selMes").val());
                    var anyo = parseInt($("#selAnyo").val());
                    $("#selDia").html("");
                    var limite = 30;
                    if(mes != 2 && mes % 2 != 0)
                        limite = 31
                    else if(mes == 2){
                        if(anyo % 4 == 0 && anyo % 100 != 0 || (anyo % 100 == 0 && anyo % 400 == 0))
                            limite = 29;
                        else
                            limite = 28;
                    }
                    for(var y = 1; y <= limite; y++)
                      $("#selDia").append("<option value=\"" + y + "\">" + y + "</option>");
                }
            $().ready(function() {
                $('.kwicks').kwicks({
                    max : 300,
                    spacing : 5,
                    isVertical : true
                });
                
                $("#f1_on").fadeOut(0,0);
                $("#f2_on").fadeOut(0,0);
                $("#f3_on").fadeOut(0,0);
                $("#f4_on").fadeOut(0,0);
                
                $("#kwick_1").hover(function(){
                    $("#f1_on").fadeIn(1000,0);
                });
                $("#kwick_1").mouseleave(function(){
                    $("#f1_on").fadeOut(1000,0);
                });
                $("#kwick_2").hover(function(){
                    $("#f2_on").fadeIn(1000,0);
                });
                $("#kwick_2").mouseleave(function(){
                    $("#f2_on").fadeOut(1000,0);
                });

                $("#kwick_3").hover(function(){
                    $("#f3_on").fadeIn(1000,0);
                });
                $("#kwick_3").mouseleave(function(){
                    $("#f3_on").fadeOut(1000,0);
                });

                $("#kwick_4").hover(function(){
                    $("#f4_on").fadeIn(1000,0);
                });
                $("#kwick_4").mouseleave(function(){
                    $("#f4_on").fadeOut(1000,0);
                });

                $("#txtDir").click(function(){
                    if(!dirclear){
                       $("#txtDir").text("");
                       dirclear = true;
                    }
                    
                });
                
                var date = new Date();

                for(var n = 0; n < listapaises.length; n++)
                {
                    $("#selPais").append("<option value=\"" + listapaises[n] + "\">" + listapaises[n] + "</option>");
                }

                $("#selAnyo").html("");
                $("#selMes").html("");
                $("#selDia").html("");
                
                for(var x = date.getFullYear() - 120; x <= date.getFullYear(); x++) {
                    $("#selAnyo").append("<option value=\"" + x + "\">" + x + "</option>");   
                }
                for(var y = 1; y <= 31; y++){
                    if(y <= 12)
                        $("#selMes").append("<option value=\"" + y + "\">" + y + "</option>");
                    $("#selDia").append("<option value=\"" + y + "\">" + y + "</option>");
                }
                
                //jQuery.get('file.txt', function(data){});
                for(var n = 0; n < listapaises.length; n++)
                {
                    $("#selPais").append("<option value=\"" + listapaises[n] + "\">" + listapaises[n] + "</option>");
                }
                
                $("#selAnyo").change(function(){calcularDias();});
                $("#selMes").change(function(){calcularDias();});
                
            });
	</script>
    </head>
    <body>
        <header>
            <a href="" class="headref"><img src="static/logo512.png" class="sitelogo" width="64" height="64"/>
                <h1 class="title">CMS Network</h1></a>
        </header>
	<center><br/><br/><br/>
        <h1>One more step
        <?php
			require_once('tools/hashgen.php');
            if(isset($_POST['txtNombre']))
            {
               echo ", " . $_POST['txtNombre'];
            }
			
			$ushash = genhash();
			$password = md5($_POST['txtPasswd'], false);
        ?>...</h1>
    
        <article class="description">Estás a un sólo paso de unirte a nuestra red. Pero antes, nos gustaría
        conocer un poco más acerca de tí.</article><br/>
        <form name="form1" action="completar.php" method="post">
            <ul class="kwicks">
                <li id="kwick_1">
                    <div class="f1" id="f1_off"><h2>¿Cuando naciste?</h2>
                        <div class="f1" id="f1_on"><p>Seleccione su fecha de nacimiento en los siguientes campos: </p>
                            <table border="0">
                                <tr>
                                    <th>Año</th><th>Mes</th><th>Dia</th>
                                </tr><tr>
									<td><select name="selAnyo" id="selAnyo"></select></td>
									<td><select name="selMes" id="selMes"></select></td>
                                    <td><select name="selDia" id="selDia"></select></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li id="kwick_2">
                    <div class="f1" id="f2_off"><h2>¿Donde vives?</h2>
                        <div class="f1" id="f2_on"><p>Introduzca su dirección en el siguiente campo: </p>
                            <textarea cols="40" rows="4" name="txtDir" id="txtDir" placeholder="Vivo en..."></textarea>
                            <p>Seleccione su país: <select name="selPais" id="selPais"></select></p>
                        </div>
                        </div>
                    </div>
                </li>
                <li id="kwick_3">
                    <div class="f1" id="f3_off"><h2>¿Cómo podemos contactar contigo?</h2>
                    <div class="f1" id="f3_on">
                        <br/><input type="number" name="txtFijo" id="txtFijo" placeholder="Teléfono fijo" class="text"/><br/><br/>
                        <input type="number" name="txtMovil" id="txtMovil" placeholder="Teléfono movil" class="text"/>
                    </div>    
                    </div>
                    </div>
                </li>
                <li id="kwick_4">
                    <div class="f1" id="f4_off"><h2>Cuentanos algo sobre tí</h2>
                    <div class="f1" id="f4_on">
                        <p>Si quieres decir algo más sobre tí, hazlo aquí: </p>
                        <textarea cols="40" rows="6" name="txtDesc" id="txtDesc" placeholder="Acerca de mi..."></textarea>
                    </div>    
                    </div>
                    </div>
            </ul>
			<?php
			if(isset($_POST['txtNombre']))
				echo "<input type=\"hidden\" name=\"txtNombre\" id=\"txtNombre\" value=\"" . $_POST['txtNombre'] . "\"/>";
			if(isset($_POST['txtApe1']))
				echo "<input type=\"hidden\" name=\"txtApe1\" id=\"txtApe1\" value=\"" . $_POST['txtApe1'] . "\"/>";
			if(isset($_POST['txtApe2']))
				echo "<input type=\"hidden\" name=\"txtApe2\" id=\"txtApe1\" value=\"" . $_POST['txtApe2'] . "\"/>";
			if(isset($_POST['txtMail']))
				echo "<input type=\"hidden\" name=\"txtMail\" id=\"txtMail\" value=\"" . $_POST['txtMail'] . "\"/>";
			if(isset($_POST['txtPasswd']))
				echo "<input type=\"hidden\" name=\"txtPasswd\" id=\"txtPasswd\" value=\"" . $password . "\"/>";
			echo "<input type=\"hidden\" name=\"txtHash\" id=\"txtHash\" value=\"" . $ushash . "\"/>";
			?>
			<article class="description">¿Estás listo para unirte? ¡Haz click en el siguiente botón para completar tu registro,
			y empezar a formar parte de nuestra comunidad!</article>
			<input type="submit" class="button" value="Registrar"/><br/><br/>
        </form>
    </center>
    </body>
</html>

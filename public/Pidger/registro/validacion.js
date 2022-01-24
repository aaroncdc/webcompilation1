//var req = "";

/*function sendPOST(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "registro.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("Content-length", req.length);
    xhttp.setRequestHeader("Connection", "close");

	xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            window.location = xhttp.responseText;
        }
    }

	xhttp.send(req);
}*/

function userExists(user){
	var exists = false;
	$.ajax({
		url: "simularUsuario.php",
		async: false,
		type: "POST",
		data: { op: 0, data: user },
		success: function(data){
			if(data.includes("ERR"))
				exists = true;
			else if(data.includes("OK"))
				exists = false;
			else
				exists = true;
		},
		error: function(data){
			
		}
	});
	return exists;
}

function mailExists(mail){
	var exists = false;
	$.ajax({
		url: "simularUsuario.php",
		async: false,
		type: "POST",
		data: { op: 1, data: mail },
		success: function(data){
			if(data.includes("ERR"))
				exists = true;
			else if(data.includes("OK"))
				exists = false;
			else
				exists = true;
		},
		error: function(data){
			
		}
	});
	return exists;
}

function error(obj, msg){
	$(obj).html("<strong>Error:</strong> " + msg);
	$(obj).fadeIn(300);
}

function dismissError(obj)
{
	$(obj).fadeOut(300);
}

function checkDate(datestr)
{
	var dateitems = datestr.split("-");
	var year = parseInt(dateitems[0]);
	var month = parseInt(dateitems[1]);
	var day = parseInt(dateitems[2]);

	var date = new Date();
	if(year >= date.getFullYear() || year <= date.getFullYear()-120)
		return false;
	if(month <= 0 || month > 12)
		return false;
	if(month == 2 && day > 28 && (year%4!=0))
		return false;
	else if(month == 2 && day > 29 && (year%4==0))
		return false;
	else if(month%2==0 && day > 31)
		return false;
	else if(month != 2 && month%2!=0 && day > 30)
		return false;

	return true;
}

function validar(){
	req = "";
	var ok = true;
	var mailreg = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/g;
	var usuario = $('input[name="vUsuario"]').val();
	var password = $('input[name="vPassword"]').val();
	var rpassword = $('input[name="vRPassword"]').val();
	var nombre = $('input[name="vNombre"]').val();
	var nacimiento = $('input[name="vNacimiento"]').val();
	var correo = $('input[name="vCorreo"]').val();
	var a1 = $('input[name="vCondiciones"]').is(":checked");
	var a2 = $('input[name="vCookies"]').is(":checked");
	var a3 = $('input[name="vPrivacidad"]').is(":checked");

	if(usuario == "" || usuario.length < 4 || usuario.match(/[ ,+\-!@#$%\^*();\/|<>"'?=:\t-\n~\[\]]+/g))
	{
		error("#alert-1", "El nombre de usuario debe contener al menos 4 caracteres, sin espacios ni símbolos (salvo la raya baja)");
		$('input[name="vUsuario"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		if(userExists(usuario))
		{
			error("#alert-1", "Ese nombre de usuario ya exíste");
			$('input[name="vUsuario"]').css("box-shadow", "0px 0px 6px #a81e1e");
			ok = false;
		}else{
			dismissError("#alert-1");
			$('input[name="vUsuario"]').css("box-shadow", "0px 0px 6px #28ce23");
		}
	}

	if(password == "" || password.length < 6 || !password.match(/[a-zA-Z]+/g) || !password.match(/[0-9]+/g))
	{
		error("#alert-2", "La contraseña debe contener al menos 6 caracteres, combinando letras y números.");
		$('input[name="vPassword"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-2");
		$('input[name="vPassword"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(rpassword == "" || rpassword != password)
	{
		error("#alert-3", "Las contraseñas no coinciden");
		$('input[name="vRPassword"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-3");
		$('input[name="vRPassword"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(nombre == "" || nombre.length < 4 || nombre.match(/[0-9 ,.+\-_!@#$%\^*();\/|<>"'?=:\t-\n~\[\]]+/g))
	{
		error("#alert-4", "El nombre debe contener al menos 4 caracteres, sin espacios ni símbolos, ni números.");
		$('input[name="vNombre"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-4");
		$('input[name="vNombre"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(nacimiento == "" || !nacimiento.match(/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/) || !checkDate(nacimiento))
	{
		//alert(nacimiento);
		error("#alert-5", "Introduzca una fecha de nacimiento válida.");
			$('input[name="vNacimiento"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		checkDate(nacimiento);
		dismissError("#alert-5");
		$('input[name="vNacimiento"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(correo == "" || !correo.match(mailreg) || correo.match(/[ ,+!#$%\^*();\/|<>"'?=:\t-\n~\[\]]+/g))
	{
		error("#alert-6", "Introduzca un correo electrónico válido (Por ejemplo, correo@servidor.com)");
		$('input[name="vCorreo"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		if(mailExists(correo))
		{
			error("#alert-6", "Parece que ya tienes una cuenta asignada a ese correo.");
			$('input[name="vCorreo"]').css("box-shadow", "0px 0px 6px #a81e1e");
			ok = false;
		}else{
			dismissError("#alert-6");
			$('input[name="vCorreo"]').css("box-shadow", "0px 0px 6px #28ce23");
		}
	}

	if(!a1)
	{
		error("#alert-7", "Debes leer y aceptar nuestras condiciones de uso, marcando la correspondiente casilla.");
		$('input[name="vCondiciones"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-7");
		$('input[name="vCondiciones"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(!a2)
	{
		error("#alert-8", "Debes leer y aceptar nuestra politica de cookies, marcando la correspondiente casilla.");
		$('input[name="vCookies"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-8");
		$('input[name="vCookies"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(!a3)
	{
		error("#alert-9", "Debes leer y aceptar nuestra politica de privacidad, marcando la correspondiente casilla.");
		$('input[name="vPrivacidad"]').css("box-shadow", "0px 0px 6px #a81e1e");
		ok = false;
	}else{
		dismissError("#alert-9");
		$('input[name="vPrivacidad"]').css("box-shadow", "0px 0px 6px #28ce23");
	}

	if(!ok)
	{
		$("#error").fadeIn(500);
		window.setTimeout(function(){
			$("#error").fadeOut(500);
		},10000)
	}
	else
		$("#error").fadeOut(500);

	return ok;
}

$(window).on('load', function(){
	$('[data-toggle="tooltip"]').tooltip();
	$("div .alert-danger").each(function(){
		$(this).fadeOut(1);
	});

	$("#subm").click(function(){
		validar();
		if(validar())
			return true;

		return false;
	});

	$("#error").fadeOut(1);

	$('select[name="vNacionalidad"]').change(function(){
		$('input[name="vTelefono"]').val("+"+$('select[name="vNacionalidad"] option:selected').attr("name"));
	});

	$('input[name="vTelefono"]').focus(function(){
		if($(this).val()[0] != "+")
			$(this).val("+"+$('select[name="vNacionalidad"] option:selected').attr("name") + $(this).val());
	});
	$('input[name="vTelefono"]').val("+93");
	//error("#alert-1", "El nombre debe contener 6 caracteres, sin espacios ni símbolos.");
});
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Prueba de grafica de datos</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<canvas id="canvas" width="400" height="300">Tu navegador no soporta el elemento CANVAS de HTML5.</canvas>
</body>
<?php require_once("datos.php"); ?>
<script>
	var gdatos = [];
	function getData(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
			   if(gdatos.length >= 12)
				gdatos.shift();
			gdatos.push(this.responseText);
		  }
		};
		xhttp.open("GET", "datos.php", true);
		xhttp.send();
	}

	var c = document.getElementById("canvas");
	var ctx = c.getContext("2d");

	function draw()
	{
		ctx.font="12px Arial";
		ctx.fillStyle = "black";
		ctx.fillRect(0,0,c.width,c.height);

		ctx.strokeStyle = "gray";
		for(var x = 0; x < c.width; x+=32)
		{
			ctx.beginPath();
			ctx.moveTo(x,0);
			ctx.lineTo(x,c.height);
			ctx.stroke();
		}
		var radio = 6;
		var escala = 5;
		var maxval = Math.max.apply(null, gdatos);
		var segments = Math.ceil(maxval/50);
		var anterior = null;
		for(var p = 0; p < gdatos.length; p++)
		{
			var py = Math.ceil(gdatos[p]/escala);
			ctx.beginPath();
			ctx.arc((32*p+32),(c.height - py)-16, radio, 0, 2 * Math.PI, false);
			ctx.fillStyle = "cyan";
			ctx.fill();
			ctx.beginPath();
			ctx.fillText(gdatos[p],(32*p+32)-10,c.height-5);
			if(anterior != null)
			{
				ctx.beginPath();
				ctx.strokeStyle = "cyan";
				ctx.lineWidth=2;
				ctx.moveTo(anterior.x, anterior.y);
				ctx.lineTo((32*p+32), (c.height - py)-16);
				ctx.stroke();
			}
			anterior = {
				x: (32*p+32),
				y: (c.height - py)-16
			};
		}
	}

	window.setInterval(getData,500);
	window.setInterval(draw,5);
</script>
</html>
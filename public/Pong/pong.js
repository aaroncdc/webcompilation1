/* 		pon.js					*
	Por Aarón CdC 	*/

var btn = document.getElementsByName("bMandar")[0];
var c = document.getElementById("can");
var ctx = c.getContext("2d");
var meter = document.getElementById("mscore");
var barreras = document.getElementById("barreras");

var delta = 0;
var rr = 1;
var maxrr = 200;
var rrmode = 1;

/* Tamaño de paletas */
var paleta = {
	ancho: 30, //30
	alto: 7 //7
};

/* Informacion jugador uno */
var p1 = {
	x: 0, //0
	y: 0, //0
	s: 0, //0
	escalaw: 1, //1
	escalah: 1, //1
	vel: 3.25 //1
};

/* Informacion jugador dos */
var p2 = {
	x: 0, //0
	y: c.height - paleta.alto, //c.height - paleta.alto
	s: 0, //0
	escalaw: 1, //1
	escalah: 1, //1
	vel: 3 //1
};

/* Informacíon de la bola */
var bola = {
	x: 50, //50
	y: 50, //50
	dirx: 0, //0
	diry: -1, //-1
	speed: .5, //.5
	speedmul: 0, //0
	sinc: .0001 //.0001
};

/* Direccion de los controles */
var controles = {
	dir: 0 //0
};

dibujarPantalla();

/* Convertir valores RGB a hexadecimal web */
/*function RGB2Color(r,g,b)
{
	return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
}*/

/* Convertir valor decimal en hexadecimal */
/*function byte2Hex(n)
{
	var nybHexString = "0123456789ABCDEF";
	return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}*/

/* Funcion que realiza un ciclo de colores */
function nextColor(offset=0)
{
	//return RGB2Color(red,green,blue);
	return glitter(delta+offset);
}

/* Dibuja una rejilla en la pantalla */
function dibujarRejilla() {
	var x = 0, y =0;
	var r = 0;
	//for(r = 0; r < c.width; r += 10)
	if(rr < 1) rr = 1;
	for(r = 0; r < c.width; r += rr)
	{
		ctx.strokeStyle=nextColor(10);
		ctx.beginPath();
		ctx.arc(c.width/2,c.height/2,r,0,2*Math.PI*r);
		ctx.stroke();
	}
}

/* Redibujar la pantalla */
function dibujarPantalla(){
	ctx.fillStyle = "black";
	ctx.fillRect(0,0,c.width,c.height);

	dibujarRejilla();

	ctx.fillStyle="cyan";
	ctx.fillRect(p1.x,p1.y,paleta.ancho*p1.escalaw,paleta.alto*p1.escalah);

	ctx.fillStyle="red";
	ctx.fillRect(p2.x,p2.y,paleta.ancho*p2.escalaw,paleta.alto*p2.escalah);
	
	ctx.fillStyle="rgba(255,255,255,.75)";
	ctx.fillRect(bola.x-bola.dirx*(3+bola.speedmul),bola.y-bola.diry*(3+bola.speedmul),5,5);
	ctx.fillStyle="rgba(255,255,255,.5)";
	ctx.fillRect(bola.x-bola.dirx*(6+bola.speedmul),bola.y-bola.diry*(6+bola.speedmul),5,5);
	ctx.fillStyle="rgba(255,255,255,.25)";
	ctx.fillRect(bola.x-bola.dirx*(9+bola.speedmul),bola.y-bola.diry*(9+bola.speedmul),5,5);

	ctx.fillStyle="white";
	ctx.fillRect(bola.x,bola.y,5,5);
	
	meter.value = 0.5 + (p1.s * 0.1) - (p2.s * 0.1);
}

document.onkeydown = function(e) {
    switch (e.keyCode) {
        case 37:
        	controles.dir = -1;
            break;
        case 38:
            //up
            break;
        case 39:
        	controles.dir = 1;
            break;
        case 40:
            //down
            break;
    }
}

document.onkeyup = function(e) {
	if(e.keyCode == 37 || e.keyCode == 39)
		controles.dir = 0;
}

var rf = setInterval(function(){
	delta+=.25;
	
	rr += rrmode * 0.1;
	
	if(rrmode == 1 && rr >= maxrr)
	{
		rrmode = -1;
	}
	if(rrmode == -1 && rr < 1)
	{
			rrmode = 1;
	}
		
	console.log("rr: " + rr + "\nrrmode: " + rrmode);
	bola.speedmul += bola.sinc;
	p1.x += controles.dir * 1;
	
	if(p1.x < 0)
		p1.x = 0;
	
	else if(p1.x+(paleta.ancho*p1.escalaw) >= c.width)
		p1.x = c.width - (paleta.ancho*p1.escalaw);
	
	bola.x += bola.dirx * (bola.speed + bola.speedmul);
	bola.y += bola.diry * (bola.speed + bola.speedmul);
	
	if(bola.x <= 0)
	{
		bola.x = 0;
		bola.dirx = 1;
	}
	if(bola.x >= c.width)
	{
		bola.x = c.width;
		bola.dirx = -1;
	}

	if(barreras.checked)
	{
		if(bola.y <= 0)
		{
			bola.y = 0;
			bola.diry = 1;
		}
		if(bola.y >= c.width)
		{
			bola.y = c.width;
			bola.diry = -1;
		}
	}

	if(bola.y < -10)
	{
		bola.y = c.width/2;
		bola.x = c.height/2;
		bola.diry = (Math.random() > .5)?1:-1;
		bola.speedmul = 0;
		p2.s += 1;
	}
	else if(bola.y > c.height + 10)
	{
		bola.y = c.width/2;
		bola.x = c.height/2;
		bola.diry = (Math.random() > .5)?1:-1;
		bola.speedmul = 0;
		p1.s += 1;
	}

	if((bola.x >= p1.x && bola.x <= p1.x + (paleta.ancho*p1.escalaw)) && (bola.y >= p1.y && bola.y <= p1.y+(paleta.alto*p1.escalah)))
	{
		bola.diry=1;
		if(bola.x < p1.x + ((paleta.ancho/2)-3))
			bola.dirx = -1;
		else if (bola.x > p1.x + ((paleta.ancho/2)+3))
			bola.dirx = 1;
		else
		{
			bola.dirx = (document.getElementById("piloto").checked)?(Math.random()*3)-1:0;
		}
	}

	if((bola.x >= p2.x && bola.x <= p2.x + (paleta.ancho*p2.escalaw)) && (bola.y >= p2.y && bola.y <= p2.y+(paleta.alto*p2.escalah)))
	{
		bola.diry=-1;
		if(bola.x < p2.x + ((paleta.ancho/2)-3))
			bola.dirx = -1;
		else if (bola.x > p2.x + ((paleta.ancho/2)+3))
			bola.dirx = 1;
		else
		{
			bola.dirx = (Math.random()*3)-1;
		}
	}

	if(bola.diry == 1)
	{
		if(p2.x+((paleta.ancho*p2.escalaw)/2) > bola.x)
			p2.x -= p2.vel;
		else if(p2.x+((paleta.ancho*p2.escalaw)/2) < bola.x)
			p2.x += p2.vel;
	}

	if(p2.x < 0)
		p2.x = 0;
	else if(p2.x+(paleta.ancho*p2.escalaw) >= c.width)
		p2.x = c.width - (paleta.ancho*p2.escalaw);

	if(document.getElementById("piloto").checked && bola.diry == -1)
	{
		if(p1.x+((paleta.ancho*p1.escalaw)/2) > bola.x)
		p1.x -= p1.vel;
	else if(p1.x+((paleta.ancho*p1.escalaw)/2) < bola.x)
		p1.x += p1.vel;
	}
	dibujarPantalla();
},5);

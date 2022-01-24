		var sin = Math.sin;
		var cos = Math.cos;
		var tan = Math.tan;
		var sinh = Math.sinh;
		var cosh = Math.cosh;
		var tanh = Math.tanh;
		var atan = Math.atan;
		var round = Math.round;
		var floor = Math.floor;
		var ceil = Math.ceil;
		var sqrt = Math.sqrt;
		var cbrt = Math.cbrt;
		var exp = Math.exp;
		var pi = Math.PI;
		var e = Math.E;
		var rand = Math.random;
		var abs = Math.abs;
		var mst = 0.00;

		var c;
		var ctx;
		var frequency = Math.PI*2;
		var step = 0;
		var stepincrement = .01;
		var phase = 0;
		var wlength = 1.0;
		var center = 128;
		var width = 127;
		var length = 128;
		var red = 0;
		var green = 0;
		var blue = 0;
		var rColor;
		var gTimer = 0;
		var x = 0;
		var y = 0;
		var yexp = "sin(x*.04)";
		var xexp = "x";
		var speed = 1;
		var delta = 0;
		var offset = 0;
		var mousePos = { x: -1, y: -1 };
		var dragging;

		var plotter = {
			x: 0,
			y: 0
		};

		var previousPointX = 0;
		var previousPointY = 0;

$(window).on('load', function(){
		c = document.getElementById("canvas");
		ctx = c.getContext('2d');
		ctx.canvas.width = window.innerWidth;
		ctx.canvas.height = window.innerHeight;
		ctx.fillStyle = "black";
		ctx.fillRect(0,0,ctx.canvas.width,ctx.canvas.height);
		grid();

		$(document).mousemove(function(event) {
		        mousePos.x = event.pageX;
		        mousePos.y = event.pageY;
		    });

		$("#bEv").click(function(){
			previousPointY = 0;
			previousPointX = 0;
			ctx.canvas.width = window.innerWidth;
			ctx.canvas.height = window.innerHeight;
			ctx.fillStyle = "black";
			ctx.fillRect(0,0,ctx.canvas.width,ctx.canvas.height);
			grid();
			tt = 0;
			gTimer = 0;
			plotter.x = 0;
			plotter.y = 0;
			y = 0;
			x = 0;
			delta = 0;
			xexp = $("#xexpression").val();
			yexp = $("#yexpression").val();

			plotFunc();
		});

		$("#yexpression").val(yexp);
		$("#xexpression").val(xexp);

		$("#vSpeed").change(function(){
			speed = $(this).val();
			$("#ival").html($(this).val());
		});

		$("#vLength").change(function(){
			wlength = $(this).val();
			$("#leval").html($(this).val());
		});

		$("#vOffset").change(function(){
				offset = $("#vOffset").val();
				$("#ival2").html($("#vOffset").val());
				console.log(offset);
			});		

		$(".handle").each(function(){
			$(this).click(function(){
				if(dragging != null)
				{
					dragging = null;
					return;
				}
				dragging = $(this);
			});
		});

		function RGB2Color(r,g,b)
		{
			return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
		}

		function byte2Hex(n)
		{
			var nybHexString = "0123456789ABCDEF";
			return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
		}

		function nextColor()
		{
			red   = Math.sin(frequency*step + 2 + phase) * width + center;
			green = Math.sin(frequency*step + 0 + phase) * width + center;
			blue  = Math.sin(frequency*step + 4 + phase) * width + center;

			step+=stepincrement;
			if(step >= length)
				step = 0;

			return RGB2Color(red,green,blue);
		}

		function grid(){
			ctx.strokeStyle = "#353535";
			for(ex = 0; ex < ctx.canvas.width; ex += 50)
			{
				ctx.beginPath();
				ctx.moveTo(ex,0);
				ctx.lineTo(ex,ctx.canvas.height);
				ctx.stroke();
			}
			for(ex = 0; ex < ctx.canvas.width; ex += 50)
			{
				ctx.beginPath();
				ctx.moveTo(0,ex);
				ctx.lineTo(ctx.canvas.width,ex);
				ctx.stroke();
			}
		}

		function draw(){
			ctx.fillStyle = rColor;
			ctx.strokeStyle = rColor;
			//ctx.fillRect(parseInt(offset) + plotter.x,(ctx.canvas.height/2)+plotter.y,2,2);
			/*ctx.beginPath();
			ctx.moveTo(previousPointX, previousPointY);
			ctx.lineTo(plotter.x, (ctx.canvas.height/2)+plotter.y);
			ctx.stroke();*/

			/*var previousPointX = plotter.x;
			var previousPointY = (ctx.canvas.height/2)+plotter.y;*/
		}

		function plotFunc(){
			var px = 0;
			var py = 0;

			ctx.fillStyle = "black";
			ctx.fillRect(0,0,ctx.canvas.width,ctx.canvas.height);
			grid();
			ctx.fillStyle = rColor;
			ctx.strokeStyle = rColor;
			for(x = -ctx.canvas.width; x < ctx.canvas.width*2; x+=5)
			{
				x = eval(xexp);
				y = -eval(yexp)*100*speed;
				ctx.fillRect(parseInt(offset) + x - 2,(ctx.canvas.height/2)+y,5,5);

				ctx.beginPath();
				ctx.moveTo(px, py);
				ctx.lineTo(parseInt(offset) + x,(ctx.canvas.height/2)+y);
				ctx.lineWidth = 2;
				ctx.stroke();


				px = parseInt(offset) + x;
				py = (ctx.canvas.height/2)+y;
			}
			

		}

		//window.setInterval(draw, 1);
		//window.setInterval(plotFunc, 1);
		window.setInterval(function(){
			$("#vOffset").attr("max", ctx.canvas.width);
			if($("#vOffset").val()>ctx.canvas.width)
				$("#vOffset").val()=ctx.canvas.width;
			delta += 1;
			plotFunc();
			gTimer++;
			if(gTimer >= 1)
			{
				rColor = nextColor();
				gTimer = 0;
			}
			if(dragging != null)
			{
				dragging.parent().css("top",mousePos.y-5 + "px");
				dragging.parent().css("left",mousePos.x-135 + "px");
			}
		}, 1);

		/*window.setInterval(function(){

			$("#vOffset").attr("max", ctx.canvas.width);
			if($("#vOffset").val()>ctx.canvas.width)
				$("#vOffset").val()=ctx.canvas.width;
			delta+=1;
			y = -eval(yexp)*100;
			x+=1*speed;
			plotter.x = eval(xexp);
			previousPointX = plotter.x;
			plotter.y = y;
			previousPointY = plotter.y;
			gTimer++;
			if(gTimer >= 1)
			{
				rColor = nextColor();
				gTimer = 0;
			}
			if(dragging != null)
			{
				dragging.parent().css("top",mousePos.y-5 + "px");
				dragging.parent().css("left",mousePos.x-135 + "px");
			}

			st += 1;
		},1);*/
		window.setInterval(function(){ mst += 0.01; }, 0.01);
		plotFunc();
});
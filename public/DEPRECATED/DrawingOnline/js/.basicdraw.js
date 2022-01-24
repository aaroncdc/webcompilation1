/*****************************************************************************************/
/*							BASICDRAW.JS												*/
/*					   BY AARON C.D.C (c) 2016											*/
/*				You can not use this program for commercial use.						*/
/*				You can not claim this program as yours.								*/
/*				You can use it for non-commercial purposes.								*/
/*				You can share this program "as it is".									*/
/*				Always credit the original author.										*/
/*****************************************************************************************/
"use strict";

/****************************************************************************************/
/*								GLOBAL FUNCTIONS AND VARS	
/*
/****************************************************************************************/


/* Toolset */
var toolset = [];
toolset["toolPencil"] = 0;		// Pencil tool
toolset["toolAirbrush"] = 1;	// Air brush
toolset["toolHarmony"] = 2;		// Harmony brush
toolset["toolEraser"] = 3;		// Eraser

/* Function that converts a color component to an hex HTML value */
function componentToHex(c) {
    var hexx = (+c).toString(16).toUpperCase();
    return hexx.length == 1 ? "0" + hexx : hexx;
}

/* Function that converts an rgb color to it's equivalent HTML hex value */
function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

/* Function that converts an HTML hex color to it's RGB equivalent */
function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

/* Calculates the distane between two points */
function distanceBetween(point1, point2) {
  return Math.sqrt(Math.pow(point2.x - point1.x, 2) + Math.pow(point2.y - point1.y, 2));
}

/* Calculates the angle between two points */
function angleBetween(point1, point2) {
  return Math.atan2( point2.x - point1.x, point2.y - point1.y );
}

/* Calculates the middle point between two points */
function midPoint(p1, p2) {
	return {
		x: p1.x + (p2.x - p1.x) / 2,
		y: p1.y + (p2.y - p1.y) / 2,
	};
}
/****************************************************************************************/
/*									MAIN PROGRAM	
/*
/****************************************************************************************/


$(document).ready(function(){
	
	$('[data-toggle="tooltip"]').tooltip();
	
	var cv = $("#canvas");
	var ctx = cv[0].getContext('2d');
	
	var canvasWidth = cv.innerWidth()*2;
	var canvasHeight = cv.innerHeight()*2;
	
/****************************************************************************************/
/*									DRAWING TOOLS	
/*
/****************************************************************************************/


function pencil(e, obj, user) {
	user.points.push({ x: e.offsetX, y: e.offsetY });
	if(user.points.length > 2)
		user.points.shift();
	var p1 = user.points[0];
	var p2 = user.points[1];
	
	ctx.globalCompositeOperation = user.mode;
	
	ctx.beginPath();
	ctx.moveTo(p1.x, p1.y);
	//console.log(points);
	
	for(var i = 1, len = user.points.length; i < len; i++){
		var mPoint = midPoint(p1,p2);
		ctx.quadraticCurveTo(p1.x, p1.y, mPoint.x, mPoint.y);
		p1 = user.points[i];
		p2 = user.points[i+1];
	}
	
	ctx.lineTo(p1.x, p1.y);
	ctx.lineWidth = user.size;
	ctx.lineCap = 'round';
	ctx.strokeStyle = 'rgba('+user.r+', '+user.g+', '+user.b+', '+user.a+')';
	ctx.stroke();
}

function airBrush(e, obj, user){
		//var currentPoint = {x: e.pageX - obj.offsetLeft, y: e.pageY - obj.offsetTop };
		var currentPoint = {x: e.offsetX, y: e.offsetY };
		var dist = distanceBetween(user.lastPoint, currentPoint);
		var angle = angleBetween(user.lastPoint, currentPoint);
		var dsize = user.size*2;
		var hsize = user.size/2;
		var fblur = 0.01*user.blur;
		var mblur = (0.4*user.blur);
		
		ctx.globalCompositeOperation = user.mode;
		
		for (var i = 0; i < dist; i+=user.size/2) {
			
			var x = user.lastPoint.x + (Math.sin(angle) * i);
			var y = user.lastPoint.y + (Math.cos(angle) * i);
			
			var radgrad = ctx.createRadialGradient(x,y,user.size-mblur-1,x,y,user.size);
			
			radgrad.addColorStop(0, 'rgba('+user.r+','+user.g+','+user.b+','+user.a+')');
			if(user.blur > 0)
				radgrad.addColorStop(0.5-fblur, 'rgba('+user.r+','+user.g+','+user.b+','+user.a*0.5+')');
			radgrad.addColorStop(1, 'rgba('+user.r+','+user.g+','+user.b+',0)');

			ctx.fillStyle = radgrad;
			ctx.fillRect(x-user.size, y-user.size, dsize, dsize);
		}
		  
		user.lastPoint = currentPoint;
}

function eraser(e, obj, user){
		//var currentPoint = {x: e.pageX - obj.offsetLeft, y: e.pageY - obj.offsetTop };
		var currentPoint = {x: e.offsetX, y: e.offsetY };
		var dist = distanceBetween(user.lastPoint, currentPoint);
		var angle = angleBetween(user.lastPoint, currentPoint);
		var dsize = user.size*2;
		var hsize = user.size/2;
		var fblur = 0.01*user.blur;
		var mblur = (0.4*user.blur);
		
		ctx.globalCompositeOperation = user.mode;
		
		for (var i = 0; i < dist; i+=user.size/2) {
			
			var x = user.lastPoint.x + (Math.sin(angle) * i);
			var y = user.lastPoint.y + (Math.cos(angle) * i);
			
			var radgrad = ctx.createRadialGradient(x,y,user.size-mblur-1,x,y,user.size);
			
			radgrad.addColorStop(0, 'rgba(255,255,255,1)');
			if(user.blur > 0)
				radgrad.addColorStop(0.5-fblur, 'rgba(255,255,255,0.5)');
			radgrad.addColorStop(1, 'rgba(255,255,255,0)');

			ctx.fillStyle = radgrad;
			ctx.fillRect(x-user.size, y-user.size, dsize, dsize);
		}
		  
		user.lastPoint = currentPoint;
}

function harmonyBrush(e, obj, user){
	user.points.push({ x: e.offsetX, y: e.offsetY });
	if(user.points.length > 50)
		user.points.shift();
	
	ctx.globalCompositeOperation = user.mode;
	if(user.points.length > 2) {
		ctx.beginPath();
		ctx.lineWidth = user.size;
		ctx.lineCap = 'round';
		ctx.strokeStyle = 'rgba('+user.r+', '+user.g+', '+user.b+', '+user.a+')';
		ctx.moveTo(user.points[user.points.length - 2].x, user.points[user.points.length - 2].y);
		ctx.lineTo(user.points[user.points.length - 1].x, user.points[user.points.length - 1].y);
		ctx.stroke();
	}
	
	for(var i = 1, len = user.points.length; i < len; i++){
		var dx = user.points[i].x - user.points[user.points.length-1].x;
		var dy = user.points[i].x - user.points[user.points.length-1].x;
		var d = dx * dx + dy * dy;
		
		if(d < 1000) {
			ctx.beginPath();
			ctx.lineWidth = user.size;
			ctx.lineCap = 'round';
			ctx.strokeStyle = 'rgba('+user.r+', '+user.g+', '+user.b+', '+user.a+')';
			ctx.moveTo(user.points[user.points.length-1].x + (dx*0.2), user.points[user.points.length-1].y + (dy * 0.2));
			ctx.lineTo(user.points[i].x - (dx*0.2), user.points[i].y - (dy * 0.2));
			ctx.stroke();
		}
		
	}
}

/****************************************************************************************/
/*									USER CLASS
/*
/****************************************************************************************/	
	
	class User {
		constructor(name){
			this.name = name;				// User name
			this.online = false;		    // Is the user online?
			this.roomid = -1;			    // Internal ID of the room the user is in.
			this.drw = false;				// Is the user drawing?
			this.mx = 0;					// Mouse X coordinates
			this.my = 0;					// Mouse Y coordinates
			this.lastPoint;					// Previous mouse coordinates
			this.color = "#000000";			// Drawing color
			this.r = 0;						// Red value
			this.g = 0;						// Green value
			this.b = 0;						// Blue value
			this.a = 1.0;					// Alpha value
			this.size = 1;					// Brush size
			this.blur = 0;					// Blur value
			this.mode = 'source-over';		// Blending mode
			this.points = [];				// List of mouse coordinates
			this.tool = 0;					// Current active tool
		}
	}
	
	var me = new User("DefaultUser");		// Client user (This is you)

	
/****************************************************************************************/
/*									MAIN PROGRAM
/*
/****************************************************************************************/
	
	$(window).resize(function(){
		resize();
	});
	
	function clear(){
		ctx.globalCompositeOperation = 'source-over';
		ctx.beginPath();
		ctx.rect(0,0,canvasWidth,canvasHeight);
		ctx.fillStyle = '#fff';
		ctx.fill();
		ctx.lineWidth = 0;
		ctx.strokeStyle = '#fff';
		ctx.stroke();
		ctx.globalCompositeOperation = me.mode;
	}
	
	function resetMouse(){
		me.mx = 0;
		me.my = 0;
		me.points = [];
		me.lastPoint = 0;
	}
	
	function resize()
	{
		canvasWidth = cv.innerWidth()*2;
		canvasHeight = cv.innerHeight()*2;
		
	}
	
	function userDraw(e, obj, user)
	{
		if(!user.drw)
			return;
		switch(user.tool)
		{
			case 0:
				pencil(e, obj, user);
			break;
			case 1:
				airBrush(e, obj, user);
			break;
			case 2:
				harmonyBrush(e, obj, user);
			break;
			case 3:
				eraser(e, obj, user);
			break;
			default:
				return;
		}
	}
	
	cv.mousedown(function(e){
		me.mx = e.offsetX;
		me.my = e.offsetY;
		me.drw = true;
		//me.lastPoint = {x: e.pageX - this.offsetLeft, y: e.pageY - this.offsetTop };
		me.lastPoint = {x: e.offsetX, y: e.offsetY };
	});
	
	cv.mousemove(function(e){
		me.mx = e.offsetX;
		me.my = e.offsetY;
		if(!me.drw)
			return;
		userDraw(e, this, me);
	});
	
	cv.mouseup(function(e){
		me.mx = e.offsetX;
		me.my = e.offsetY;
		me.drw = false;
		me.points = [];
		//me.currentPoint = me.lastPoint = 0;
	});
	cv.mouseleave(function(e){
		me.mx = -1;
		me.my = -1;
		resetMouse();
	});
	
	$('#rs').change(function(){
		me.size = $(this).val();
		$("#rst").val(me.size);
	});
	
	$('#rb').change(function(){
		me.blur = $(this).val();
		$("#rsb").val(me.blur);
	});
	
	$("#selcolor").change(function(){
		me.color = $(this).val();
		var decoded = hexToRgb(me.color);
		me.r = decoded.r;
		me.g = decoded.g;
		me.b = decoded.b;
		$("#rv").val(me.r);
		$("#redb").val(me.r);
		$("#gv").val(me.g);
		$("#greenb").val(me.g);
		$("#bv").val(me.b);
		$("#blueb").val(me.b);
		$("#hexcol").val(me.color);
	});
	
	$("#opacs").change(function(){
		me.a = $(this).val();
		$("#rso").val(me.a*100);
	});
	
	$("#selMode").change(function(){
		me.mode = $(this).val();
	});
	
	$("#redb").change(function(){
		me.r = $(this).val();
		var hexc = rgbToHex(me.r, me.g, me.b);
		me.color = hexc;
		document.getElementById('selcolor').value = hexc;
		$("#rv").val($(this).val());
		$("#hexcol").val(me.color);
	});
	
	$("#greenb").change(function(){
		me.g = $(this).val();
		var hexc = rgbToHex(me.r, me.g, me.b);
		me.color = hexc;
		document.getElementById('selcolor').value = hexc;
		$("#gv").val($(this).val());
		$("#hexcol").val(me.color);
	});
	
	$("#blueb").change(function(){
		me.b = $(this).val();
		var hexc = rgbToHex(me.r, me.g, me.b);
		me.color = hexc;
		document.getElementById('selcolor').value = hexc;
		$("#bv").val($(this).val());
		$("#hexcol").val(me.color);
	});
	
	$('#clearb').click(function(){
		clear();
	});
	
	$("#toolsetbar .btn").click(function(){
		var clk = $(this);
		me.tool = toolset[clk.attr('id')];
		clk.siblings().removeClass('active');
		clk.addClass('active');
	});
	
	clear();
	
});
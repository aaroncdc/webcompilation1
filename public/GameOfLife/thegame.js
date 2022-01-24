/* This script relies on JQuery for certain stuff. */
/* Click on each square to create or kill a cell. Click on Start to start the simulation.
		?Each cell must be surounded by at least other 2 cells to survive.
    ?Cells surounded by 4 or more cells will die of overpopulation.
    ?Cells surounded by 1 or no cells will die of solitude.
    ?If a dead cell is surounded by 3 cells, it will give birth to another cell.

*/

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
var dimensions = 500; //Dimension of the canvas, in pixels.
var ced = 13; //Dimension of a grid square
var ls = Math.ceil(dimensions / ced); //How many squares per row / column
var squares = Math.pow(Math.ceil(dimensions / ced), 2); //How many squares in the entire canvas
var cells = new Array(squares); // Array of cells
var simulating = false; //Is the simulation running?
var times = 100; //Time interval between updates (in ms)
var showgrid = true; // Show the grid?
var usecolors = true;

var ccr = 0x0;
var ccg = 0x4c;
var ccb = 0x99;

/* Function that converts decimal numbers into an hex string with padding */
function decimalToHex(d, padding) {
  var hex = Number(d).toString(16);
  padding = typeof(padding) === "undefined" || padding === null ? padding = 2 : padding;

  while (hex.length < padding) {
    hex = "0" + hex;
  }

  return hex;
}

/* Function that creates an array */
function createArray(length) {
  var arr = new Array(length || 0),
    i = length;

  if (arguments.length > 1) {
    var args = Array.prototype.slice.call(arguments, 1);
    while (i--) arr[length - 1 - i] = createArray.apply(this, args);
  }

  return arr;
}

// Creates the array of cells
var cells = createArray(ls, ls);

/* Function to draw the background */
function drawbackground() {
  //Background color

  if (usecolors) {
    var grd = ctx.createLinearGradient(0, 0, 0, dimensions);
    grd.addColorStop(0, "black");
    grd.addColorStop(1, "#00141e");

    ctx.fillStyle = grd;
    ctx.fillRect(0, 0, dimensions, dimensions);
  } else {
    //ctx.fillStyle = "#00343e";
    ctx.fillStyle = "#00141e";
    ctx.fillRect(0, 0, dimensions, dimensions);
  }

  //Grid
  ctx.strokeStyle = "#003c79";
  if (showgrid)
    for (var i = 1; i < ls; i++) {
      ctx.beginPath();
      ctx.moveTo(ced * i, 0);
      ctx.lineTo(ced * i, dimensions);
      ctx.stroke();
      ctx.beginPath();
      ctx.moveTo(0, ced * i);
      ctx.lineTo(dimensions, ced * i);
      ctx.stroke();
    }

}

/* Function to render a cell */
function drawcell(posx, posy) {

  if (usecolors) {
    var gg = decimalToHex(Math.abs(Math.ceil((Math.sin(posy * 0.0025) * ccg))), 2);
    var rg = decimalToHex(Math.abs(Math.ceil((Math.sin(posx * 0.0020) * ccg))), 1);
    var hrgb = "#" + rg + gg + ccb;
  } else {
    var hrgb = "#004c99";
  }
  //console.log(hrgb);

  ctx.fillStyle = hrgb;
  ctx.strokeStyle = "#007cb9";
  ctx.fillRect(posx * ced, posy * ced, ced, ced);
  ctx.strokeRect(posx * ced, posy * ced, ced, ced);
}

/* Function that renders all alive cells in the cell array */
function drawcells() {
  for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++)
      if (cells[x][y] > 0)
        drawcell(x, y);
}

/* Function to set the status of a cell */
function modcell(posx, posy, value) {
  if (posx >= ls || posy >= ls)
    return;
  cells[posx][posy] = value;
}

/* Function to clear all the cells in the array */
function clearcells() {
  for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++)
      cells[x][y] = 0;
  drawbackground();
  drawcells(); //Theorically not necessary, but proves it is clear indeed.
}

/* Function to check the population around a given cell */
// It takes into account the borders. Cells marked for death are also taken into account.

var prev = 0; //Previous checked cell state.
function checkPopulation(px, py) {
  var result = 0;

  if (px < 0 || py < 0 || px >= ls || py >= ls) {
    console.log("Warning: cells[" + px + "][" + py + "] out of range");
    return 0;
  }

  if (cells[px][py] == null) {
    console.log("Warning: cells[" + px + "][" + py + "] is undefined");
    return 0;
  }

  if (px | py != 0) {
    if (px > 0) {
      if (cells[px - 1][py] == 1 || cells[px - 1][py] == 3)
        result++;
    } else if (px == 0) {
      if (cells[ls - 1][py] == 1 || cells[ls - 1][py] == 3)
        result++;
    }
  } else {
    if (prev == 1 || prev == 3)
      result++;
  }

  prev = cells[px][py];


  if (py > 0) {
    if (cells[px][py - 1] == 1 || cells[px][py - 1] == 3)
      result++;
  } else if (py == 0) {
    if (cells[px][ls - 1] == 1 || cells[px][ls - 1] == 3)
      result++;
  }

  if (px < ls - 1) {
    if (cells[px + 1][py] == 1 || cells[px + 1][py] == 3)
      result++;
  } else if (px == ls - 1) {
    if (cells[0][py] == 1 || cells[0][py] == 3)
      result++;
  }

  if (py < ls - 1) {
    if (cells[px][py + 1] == 1 || cells[px][py + 1] == 3)
      result++;
  } else if (py == ls - 1) {
    if (cells[px][0] == 1 || cells[px][0] == 3)
      result++;
  }

  if (px > 0 && py > 0) {
    if (cells[px - 1][py - 1] == 1 || cells[px - 1][py - 1] == 3)
      result++;
  } else if (px == 0 && py == 0) {
    if (cells[ls - 1][ls - 1] == 1 || cells[ls - 1][ls - 1] == 3)
      result++;
  }

  if (px < ls - 1 && py < ls - 1) {
    if (cells[px + 1][py + 1] == 1 || cells[px + 1][py + 1] == 3)
      result++;
  } else if (px == ls - 1 && py == ls - 1) {
    if (cells[0][0] == 1 || cells[0][0] == 3)
      result++;
  }

  if (px > 0 && py < ls - 1) {
    if (cells[px - 1][py + 1] == 1 || cells[px - 1][py + 1] == 3)
      result++;
  } else if (px == 0 && py == ls - 1)
    if (cells[ls - 1][0] == 1 || cells[ls - 1][0] == 3)
      result++;

  if (px < ls - 1 && py > 0) {
    if (cells[px + 1][py - 1] == 1 || cells[px + 1][py - 1] == 3)
      result++;
  } else if (px == ls - 1 && py == 0)
    if (cells[0][ls - 1] == 1 || cells[0][ls - 1] == 3)
      result++;

  return result;
}

/* Performs the logic of the simulation */
function doLogic() {

  /* First stage marks each cell for modification. 2 means birth, 3 means death. */
  for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++) {
      var popul = checkPopulation(x, y);
      if (cells[x][y] > 0) {
      //Marks the cell for death if it's overpopulated or underpopulated.
        if (popul < 2)
          cells[x][y] = 3;
        if (popul > 3)
          cells[x][y] = 3;
      }
      if (cells[x][y] == 0) {
      //If the population is 3, mark for birth
        if (popul == 3)
          cells[x][y] = 2;
      }
    }

  /* Second stage perform the modifications in the array (Gives birth on 2, and kill all 3. Ignore anything else.)*/
  for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++)
      if (cells[x][y] == 3)
        cells[x][y] = 0;
      else if (cells[x][y] == 2)
    cells[x][y] = 1;
}

/* Updates the game and the canvas */
function update() {
  doLogic();
  //ctx.clearRect(0,0,dimensions,dimensions);
  drawbackground();
  drawcells();
  first = false;
}

/* Check for mouse clicks on the canvas, and toggle the clicked cell */
myCanvas.addEventListener("mousedown", togglecell, false);

function togglecell(event) {
  var x = event.x;
  var y = event.y;

  var canvas = document.getElementById("myCanvas");
  var rect = canvas.getBoundingClientRect();

  x = event.clientX - rect.left;
  y = event.clientY - rect.top;

  //alert("x:" + x + " y:" + y);
  var cx = Math.floor(x / ced);
  var cy = Math.floor(y / ced);
  //alert("x:" + cx + " cy:" + cy);

  if (cells[cx][cy] == 1)
    cells[cx][cy] = 0;
  else
    cells[cx][cy] = 1;

  //ctx.clearRect(0,0,dimensions,dimensions);
  drawbackground();
  drawcells();
}

function modgrid(size) {
  ced = size;
  ls = Math.ceil(dimensions / ced);
  squares = Math.pow(Math.ceil(dimensions / ced), 2);
  cells = createArray(ls, ls);
  clearcells();
}

/* Draws a glidder gun */
clearcells();
modcell(1, 5, 1);
modcell(2, 5, 1);
modcell(1, 6, 1);
modcell(2, 6, 1);

modcell(11, 5, 1);
modcell(11, 6, 1);
modcell(11, 7, 1);
modcell(12, 4, 1);
modcell(12, 8, 1);
modcell(13, 3, 1);
modcell(13, 9, 1);
modcell(14, 3, 1);
modcell(14, 9, 1);
modcell(15, 6, 1);

modcell(16, 4, 1);
modcell(17, 5, 1);
modcell(17, 6, 1);
modcell(17, 7, 1);
modcell(16, 8, 1);
modcell(18, 6, 1);

modcell(21, 5, 1);
modcell(21, 4, 1);
modcell(21, 3, 1);
modcell(22, 5, 1);
modcell(22, 4, 1);
modcell(22, 3, 1);
modcell(23, 2, 1);
modcell(23, 6, 1);

modcell(25, 2, 1);
modcell(25, 1, 1);

modcell(25, 6, 1);
modcell(25, 7, 1);

modcell(35, 3, 1);
modcell(35, 4, 1);
modcell(36, 3, 1);
modcell(36, 4, 1);
drawbackground();
drawcells();

/* User interface (using JQuery) */
var timer;
$("#start").click(function() {
  if (!simulating) {
    timer = setInterval(update, times);
    simulating = true;
    $(this).val("Stop");
  } else {
    clearInterval(timer);
    simulating = false;
    $(this).val("Start");
  }
});

$("#csz").val(ced);
$("#csz").change(function() {
  //alert("Wot " + $(this).val());
  $("#zoom").html($(this).val());
  modgrid($(this).val());

});

$("#tmr").val(times);
$("#tmrz").html($("#tmr").val());
$("#tmr").change(function() {
  times = $(this).val();
  clearInterval(timer);
  if(simulating)
  	timer = setInterval(update, times);
  $("#tmrz").html($(this).val());
});

$("#sgrd").click(function() {
  showgrid = $("#sgrd").is(':checked');
  drawbackground();
  drawcells();
});

$("#clear").click(clearcells);

$("#random").click(function() {
  clearcells();
  for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++)
      if (Math.floor((Math.random() * 100) + 1) <= 10)
        cells[x][y] = 1;
  drawbackground();
  drawcells();
});

$("#colrs").click(function() {
  usecolors = !usecolors;
  drawbackground();
  drawcells();
});

$("#gdata").click(function() {
	$("#mdata").html('');
	var grg = "grid " + ced + "\n";
  
  $("#mdata").append(grg);
   for (var y = 0; y < ls; y++)
    for (var x = 0; x < ls; x++) {
    	if(cells[x][y] == 1)
      {
      	var crg = "add " + x + " " + y + "\n";
        $("#mdata").append(crg);
      }
    }
});

$("#ldata").click(function() {
  clearInterval(timer);
  simulating = false;
  var dt = $("#mdata").val().split('\n');
  var pamA = 0,
    pamB = 0,
    pamC = 0,
    pamD = 0;
  $.each(dt, function() {
  	console.log(dt[x]);
    
    if(this.charAt(0) != '#')
    if (~this.indexOf("grid")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]);
      modgrid(pamA);
    }
    else if (~this.indexOf("add")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]);
      pamB = parseInt(rt[2]);
      modcell(pamA, pamB, 1);
      drawbackground();
      drawcells();
    }
    else if (~this.indexOf("rem")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]);
      pamB = parseInt(rt[2]);
      modcell(pamA, pamB, 0);
      drawbackground();
      drawcells();
    }
    else if (~this.indexOf("block")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]);
      pamB = parseInt(rt[2]);
      pamC = parseInt(rt[3]);
      pamD = parseInt(rt[4]);
      //modcell(pamA, pamB, 1);
      for (var y = pamB; y <= pamD; y++)
        for (var x = pamA; x <= pamC; x++)
          modcell(x, y, 1);
      drawbackground();
      drawcells();
    }
    else if (~this.indexOf("hollow")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]);
      pamB = parseInt(rt[2]);
      pamC = parseInt(rt[3]);
      pamD = parseInt(rt[4]);
      //modcell(pamA, pamB, 1);
      for (var y = pamB; y <= pamD; y++)
        for (var x = pamA; x <= pamC; x++)
          if(y == pamB || y == pamD || x == pamA || x == pamC)
            modcell(x, y, 1);
      drawbackground();
      drawcells();
    }
    else if (~this.indexOf("line")) {
      var rt = this.split(' ');
      pamA = parseInt(rt[1]); //x1
      pamB = parseInt(rt[2]); //y1
      pamC = parseInt(rt[3]); //x2
      pamD = parseInt(rt[4]); //y2
      
      var dx = Math.abs(pamC-pamA);
      var dy = Math.abs(pamD-pamB);
      var sx = (pamA < pamC) ? 1 : -1;
      var sy = (pamB < pamD) ? 1 : -1;
      var err = dx - dy;
      var cnt = 0;
      
      while(true){
      	modcell(pamA,pamB,1);
        
        if((pamA==pamC)&&(pamB==pamD)) break;
        var e2 = 2*err;
        if(e2 >-dy){ err -= dy; pamA += sx; }
        if(e2 < dx){ err += dx; pamB += sy; }
        cnt++; //Watchdog
        if(cnt > dimensions)
        	break;
      }
      
      drawbackground();
      drawcells();
    }
    
    
  });
});
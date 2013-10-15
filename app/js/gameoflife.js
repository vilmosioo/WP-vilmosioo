'use strict';
var N = 125; // width
var M = Math.floor(N*666/1000); // height
var grid = new Array(N*M);
var change = new Array(N*M);
var running = false;
var context = null;
var canvas = null;
var width = 0, height = 0;

function alive(i, j){
	return grid[i*N+j] === 1;
}
function dying(i, j){
	return grid[i*N+j] >= 2;
}
function getCell(i, j){
	return grid[i*N+j];
}
function setCell(i, j, value){
	change[i*N+j] = value;
}
function changed(i, j){
	return change[i*N+j] !== grid[i*N+j];
}
function drawCell(i, j){
	var wunit = Math.floor(width/N);
	var hunit = Math.floor(height/M);
	if(changed(i,j)){
		if(change[i*N+j] === 1){
			context.fillStyle   = '#fff';
		} else if(change[i*N+j] >= 2){
			context.fillStyle   = 'rgba(65,180,255,'+(0.75*change[i*N+j]/10)+')';
		} else{
			context.fillStyle   = '#000';
		}
		context.fillRect(i*wunit, j*hunit, wunit, hunit);
		grid[i*N + j] = change[i*N+j];
	}
}
// return the number of alive neightbours
function neightboursCount(i, j){
	var counter = 0;
	if (alive(i,j-1)){
		counter++;
	}
	if (alive(i,j+1)){
		counter++;
	}
	if (alive(i-1,j-1)){
		counter++;
	}
	if (alive(i-1,j)){
		counter++;
	}
	if (alive(i-1,j+1)){
		counter++;
	}
	if (alive(i+1,j-1)){
		counter++;
	}
	if (alive(i+1,j)){
		counter++;
	}
	if (alive(i+1,j+1)){
		counter++;
	}
	if(i === 0){
		if (alive(N-1,j-1)){
			counter++;
		}
		if (alive(N-1,j)){
			counter++;
		}
		if (alive(N-1,j+1)){
			counter++;
		}
	}
	if(i === N-1){
		if (alive(0,j-1)){
			counter++;
		}
		if (alive(0,j)){
			counter++;
		}
		if (alive(0,j+1)){
			counter++;
		}
	}
	if(j === M-1){
		if (alive(i,0)){
			counter++;
		}
		if (alive(i-1,0)){
			counter++;
		}
		if (alive(i+1,0)){
			counter++;
		}
	}
	if(j === 0){
		if (alive(i,M-1)){
			counter++;
		}
		if (alive(i-1,M-1)){
			counter++;
		}
		if (alive(i+1,M-1)){
			counter++;
		}
	}
	return counter;
}
function draw(){
	if(running){
		// If a cell has either 0 or exactly 1 neighbour, it will die on underpopulation.
		// If a cell has exactly 4 or more neighbours, it will die on overpopulation
		// If an empty space has exactly 3 cells, the empty space will be populated by a new cell.
		var i = 0, j = 0;
		for(i = 0; i< N; i++){
			for(j = 0; j< M; j++){
				var count = neightboursCount(i, j);
				if(alive(i, j)){
					if(count <= 1){
						setCell(i, j, 2);
					} else if(count >= 4){
						setCell(i, j, 2);
					}
				}else{
					if(count === 3){
						setCell(i, j, 1);
					} else if(dying(i,j)){
						if(getCell(i, j) >= 10){
							setCell(i, j, 0);
						} else{
							setCell(i, j, getCell(i, j)+1);
						}
					}
				}
			}
		}
		for(i = 0; i< N; i++){
			for(j = 0; j< M; j++){
				drawCell(i, j);
			}
		}
	}
	window.requestAnimationFrame(function(){
		draw();
	});
}
function init(test){
	context.clearRect(0, 0, width, height);
	grid.length = 0;
	change.length = 0;
	// paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
	var lingrad = context.createRadialGradient(width/2, width/2, 100, width/2, width/2, width);
	lingrad.addColorStop(0, '#666');
	lingrad.addColorStop(1, '#000');
	for(var i=0; i< N; i++){
		for(var j=0; j< M; j++){
			var wunit = Math.floor(width/N);
			var hunit = Math.floor(height/M);
			context.fillStyle   = '#aaa';
			context.fillRect(i*wunit, j*hunit, wunit, hunit);
			context.globalAlpha = 0.1;
			context.beginPath();
			context.strokeStyle = '#666';
			context.lineWidth = 1;
			context.moveTo(i*wunit, j*hunit);
			context.lineTo(i*wunit + wunit, j*hunit);
			context.lineTo(i*wunit + wunit, j*hunit + hunit);
			context.lineTo(i*wunit, j*hunit + hunit);
			context.lineTo(i*wunit, j*hunit);
			context.stroke();
			context.globalAlpha = 1;
		}
	}
	// init grid
	var x = N/5;
	var index = 0;
	var row = 0;
	var column = 0;
	while(index < test.length){
		var c = test.charAt(index++);
		if(c === 'O'){ setCell(x+column, x+row, 1); }
		if(c === 'x'){
			column = -1;
			row++;
		}
		column++;
	}
	window.requestAnimationFrame(function(){
		draw();
	});
}
window.onload = function(){
	canvas = document.getElementById('canvas-gol');
	context = canvas.getContext('2d');
	width = 778;
	height = Math.floor(width*666/1000);
	canvas.width = width;
	canvas.height = height;
	canvas.style.width = width;
	canvas.style.height = height;
	var maxwidth = document.body.clientWidth - 20;
	if(maxwidth < width){
		width = maxwidth;
		height = 666/1000*width;
	}
	canvas.width = width;
	canvas.height = height;
	canvas.style.width = width+'px';
	canvas.style.height = height+'px';
	jQuery('#save').click(function () {
		window.location = canvas.toDataURL('image/png');
	});
	jQuery('#run').click(function(){
		if(running){ running = false; jQuery(this).text('Run');} else {running = true; jQuery(this).text('Pause');}
	});
	var glidergun = "........................Ox......................O.Ox............OO......OO............OOx...........O...O....OO............OOxOO........O.....O...OOxOO........O...O.OO....O.Ox..........O.....O.......Ox...........O...Ox............OO";
	var ship = "...Ox.O...OxOxO....OxOOOOO";
	var glider = ".Ox..OxOOO";
	var noah = "..........O.Ox.........Ox..........O..Ox............OOOxxxxxx.OxO.OxxO..Ox..OOx...O";
	var space = "...........OO.....OOOOx.........OO.OO...O...Ox.........OOOO........Ox..........OO.....O..Oxx........Ox.......OO........OOx......O.........O..Ox.......OOOOO....O..Ox........OOOO...OO.OOx...........O....OOxxxx..................OOOOxO..O.............O...Ox....O................OxO...O............O..Ox.OOOO";
	var pentomino = ".OOxOOx.O";
	jQuery('#glidergun').addClass('active');
	init(glidergun);
	jQuery('#ship').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(ship);
	});
	jQuery('#glidergun').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(glidergun);
	});
	jQuery('#pentomino').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(pentomino);
	});
	jQuery('#space').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(space);
	});
	jQuery('#noah').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(noah);
	});
	jQuery('#glider').click(function(){
		jQuery('#glider, #noah, #ship, #space, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(glider);
	});
};
/*CANVAS
createLinearGradient(x0, y0, x1, y1) paints along a line from (x0, y0) to (x1, y1).
createRadialGradient(x0, y0, r0, x1, y1, r1) paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
my_gradient.addColorStop(0, "black");
ctx.rect(x, y, width, height)
*/
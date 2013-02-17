window.onload = function(){
	var container = jQuery('#main .entry-content');
	width = jQuery('<canvas/>', {  
		id: 'canvas-gol',
		style: 'width: 100%'
	}).appendTo(container).width(); 
	
	addButtons();

	height = Math.floor(width*666/1000);
	wunit = Math.floor(width/N);
	hunit = Math.floor(height/M);
	woffset = Math.floor((width - wunit * N) / 2);
	hoffset = Math.floor((height - hunit * M) / 2);

	canvas = document.getElementById('canvas-gol');
	context = canvas.getContext('2d');
	
	canvas.width = width;
	canvas.height = height;
	canvas.style.width = width;
	canvas.style.height = height;

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
	init(glidergun, true);

	jQuery('#ship').click(function(){
		jQuery('#ship, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(ship);
	});
	jQuery('#glidergun').click(function(){
		jQuery('#ship, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(glidergun);
	});
	jQuery('#pentomino').click(function(){
		jQuery('#ship, #glidergun, #pentomino').removeClass('active');
		jQuery(this).addClass('active');
		init(pentomino);
	});
	setTimeout("jQuery('#run').click()", 2000);
};	

function addButtons(){
	jQuery('<a/>', {  
		class: 'button large blue',
		id: 'run',
		text: 'Run'
	}).insertBefore(jQuery('canvas'));
	jQuery('<a/>', {  
		class: 'button large blue',
		id: 'save',
		text: 'Save image'
	}).insertBefore(jQuery('canvas'));
	jQuery('<a/>', {  
		class: 'button large orange',
		id: 'glidergun',
		text: 'Glider Gun'
	}).insertBefore(jQuery('canvas'));
	jQuery('<a/>', {  
		class: 'button large orange',
		id: 'ship',
		text: 'Ship'
	}).insertBefore(jQuery('canvas'));
	jQuery('<a/>', {  
		class: 'button large orange',
		id: 'pentomino',
		text: 'F Pentomino'
	}).insertBefore(jQuery('canvas'));
}

var interval = 1000 / 60; // 60 frames for every 1000 ms
var N = 125; // width
var M = Math.floor(N*666/1000); // height
var grid = new Array(N*M);
var change = new Array(N*M);
var running = false;
var context = null;
var width, height, wunit, hunit, woffset, hoffset;
var cellMaxLives = 20;

window.requestAnimFrame = (function(callback){
    return window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.oRequestAnimationFrame ||
    window.msRequestAnimationFrame ||
    function(callback){
        window.setTimeout(callback, interval);
    };
})();

function init(test, call){
	context.clearRect(0, 0, width, height);
	grid.length = 0;
	change.length = 0;

	context.fillStyle   = '#fff'; 
	context.fillRect(0, 0, width, height);

	// init grid
	var x = N/5;
	var index = 0;
	var row = 0;
	var column = 0;
	while(index < test.length){
		
		var c = test.charAt(index++);
		if(c == 'O'){ setCell(x+column, x+row, 1); }
		if(c == 'x'){ 
			column = -1;
			row++;
		}
		column++;
	}

	if(call){
		requestAnimFrame(function(){
	        draw();
	    });
	}
}

function draw(){

	if(running){
		// If a cell has either 0 or exactly 1 neighbour, it will die on underpopulation.
	    // If a cell has exactly 4 or more neighbours, it will die on overpopulation
	    // If an empty space has exactly 3 cells, the empty space will be populated by a new cell. 
		for(i =0; i< N; i++){
			for(j =0; j< M; j++){

				var count = neightboursCount(i, j);

				if(alive(i, j)){
					if(count <= 1) setCell(i, j, 2);
					else if(count >= 4) setCell(i, j, 2);
				}else{
					if(count == 3) setCell(i, j, 1) 
					else if(dying(i,j)){
						if(getCell(i, j) >= cellMaxLives) setCell(i, j, 0); else setCell(i, j, getCell(i, j)+1);
					}
				}
			}
		}

		for(i =0; i< N; i++){
			for(j =0; j< M; j++){
				drawCell(i, j);
			}
		}
	}
	requestAnimFrame(function(){
        draw();
    });
	
}

// return the number of alive neightbours
function neightboursCount(i, j){

	var counter = 0;
 	
	if (alive(i,j-1)) counter++;
	if (alive(i,j+1)) counter++;
	if (alive(i-1,j-1)) counter++;
	if (alive(i-1,j)) counter++;
	if (alive(i-1,j+1)) counter++;
	if (alive(i+1,j-1)) counter++;
	if (alive(i+1,j)) counter++;
	if (alive(i+1,j+1)) counter++;

	if(i == 0){
		if (alive(N-1,j-1)) counter++;
		if (alive(N-1,j)) counter++;
		if (alive(N-1,j+1)) counter++;
	}
	if(i == N-1){
		if (alive(0,j-1)) counter++;
		if (alive(0,j)) counter++;
		if (alive(0,j+1)) counter++;
	}
	if(j == M-1){
		if (alive(i,0)) counter++;
		if (alive(i-1,0)) counter++;
		if (alive(i+1,0)) counter++;
	}
	if(j == 0){
		if (alive(i,M-1)) counter++;
		if (alive(i-1,M-1)) counter++;
		if (alive(i+1,M-1)) counter++;
	}

	return counter;
}

function alive(i, j){
	return grid[i*N+j] == 1;
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
	return change[i*N+j] != grid[i*N+j];
}

function drawCell(i, j){
	var x = woffset+i*wunit;
	var y = hoffset+j*hunit;
			
	var r0 = 65;
	var g0 = 180;
	var b0 = 255;

	if(changed(i,j)){
		if(change[i*N+j] == 1){
			context.fillStyle   = 'rgb('+r0+','+g0+','+b0+')'; 
			context.strokeStyle = 'rgb('+(r0-5)+','+(g0-5)+','+(b0-5)+')';
		} else if(change[i*N+j] >= 2){
			/*2..cellMaxLives*/
			var ratio = (change[i*N+j]-2) / (cellMaxLives-2);
			var r = Math.floor(r0+(255-r0)* ratio);
			var g = Math.floor(g0+(255-g0)* ratio);
			var b = Math.floor(b0+(255-b0)* ratio);

			context.fillStyle   = 'rgb('+r+','+g+','+b+')'; 
			context.strokeStyle = 'rgb('+(r-5)+','+(g-5)+','+(b-5)+')';
		} else{
			context.fillStyle   = '#fff'; 
			context.strokeStyle = "#fff";
		}
		context.fillRect(x, y, wunit, hunit);
		context.strokeRect(x, y, wunit, hunit);

		grid[i*N + j] = change[i*N+j];
	}
}




/*CANVAS
createLinearGradient(x0, y0, x1, y1) paints along a line from (x0, y0) to (x1, y1).
createRadialGradient(x0, y0, r0, x1, y1, r1) paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
my_gradient.addColorStop(0, "black");
ctx.rect(x, y, width, height)
*/
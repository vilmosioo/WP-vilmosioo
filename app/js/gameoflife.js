'use strict';

var VI_GOL = (function($, doc){
	var app = {},
		N = 125, // number of cells horizontally
		M = Math.floor(N*666/1000), // number of cells vertically
		canvas,
		select, run, screenshot,
		context,
		running = false,
		width = 1000,
		height = Math.floor(width*666/1000),
		patterns,
		grid = new Array(N*M), // the grid of cells
		change = new Array(N*M); // the cell changes recorded

	var _loadParams = function(){
		// initialise canvas
		canvas = document.getElementById('canvas-gol');
		// save reference to context
		context = canvas.getContext('2d');
		// calculate width/height
		width = Math.min(width, doc.body.clientWidth - 20);
		height = Math.floor(width * 666/1000);
		canvas.width = width;
		canvas.height = height;
		canvas.style.width = width + 'px';
		canvas.style.height = height + 'px';

		// initialise patterns
		patterns = {
			Glidergun: "........................Ox......................O.Ox............OO......OO............OOx...........O...O....OO............OOxOO........O.....O...OOxOO........O...O.OO....O.Ox..........O.....O.......Ox...........O...Ox............OO",
			Ship: "...Ox.O...OxOxO....OxOOOOO",
			Glider: ".Ox..OxOOO",
			Noah: "..........O.Ox.........Ox..........O..Ox............OOOxxxxxx.OxO.OxxO..Ox..OOx...O",
			Space: "...........OO.....OOOOx.........OO.OO...O...Ox.........OOOO........Ox..........OO.....O..Oxx........Ox.......OO........OOx......O.........O..Ox.......OOOOO....O..Ox........OOOO...OO.OOx...........O....OOxxxx..................OOOOxO..O.............O...Ox....O................OxO...O............O..Ox.OOOO",
			Pentomino: ".OOxOOx.O",
		};
	};

	var _addButtons = function(){
		select = $('<select class="form-control"></select>').width('300px');
		for(var key in patterns){
			if(patterns.hasOwnProperty(key)){
				select.append($('<option value="'+patterns[key]+'">'+key+'</option>'));
			}
		}
		run = $('<button class="active btn btn-primary">Pause</button>');
		screenshot = $('<button class="btn btn-primary">Save image</button>');
		$(canvas).before($('<p></p>').append(run).append('&nbsp;').append(screenshot));
		$(canvas).before($('<p></p>').append(select));
	};

	// takes a screenshot of the canvas and
	var _saveScreenshot = function () {
		window.location = canvas.toDataURL('image/png');
	};

	// run/pause the app
	var _run = function(){
		run.text(running ? 'Run' : 'Pause');
		run.toggleClass('active', !running);
		running = !running;
	};
	
	var _addHandlers = function(){
		screenshot.click(_saveScreenshot);
		run.click(_run);
		select.change(function(){
			_init(select.val());
		});
	};
	
	var _drawGrid = function(){
		// paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
		var lingrad = context.createRadialGradient(width/2, width/2, 100, width/2, width/2, width);
		lingrad.addColorStop(0, '#666');
		lingrad.addColorStop(1, '#000');
		for(var i=0; i < N; i++){
			for(var j=0; j < M; j++){
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
	};

	var _alive = function(i, j){
		return grid[i*N+j] === 1;
	};

	var _dying = function(i, j){
		return grid[i*N+j] >= 2;
	};

	var _getCell = function(i, j){
		return grid[i*N+j];
	};
	
	var _setCell = function(i, j, value){
		change[i*N+j] = value;
	};
	
	var _changed = function(i, j){
		return change[i*N+j] !== grid[i*N+j];
	};
	
	var _drawCell = function(i, j){
		var wunit = Math.floor(width/N);
		var hunit = Math.floor(height/M);
		if(_changed(i,j)){
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
	};

	// return the number of alive neightbours
	var _neightboursCount = function(i, j){
		var counter = 0;
		if(_alive(i,j-1)){
			counter++;
		}
		if(_alive(i,j+1)){
			counter++;
		}
		if(_alive(i-1,j-1)){
			counter++;
		}
		if(_alive(i-1,j)){
			counter++;
		}
		if(_alive(i-1,j+1)){
			counter++;
		}
		if(_alive(i+1,j-1)){
			counter++;
		}
		if(_alive(i+1,j)){
			counter++;
		}
		if(_alive(i+1,j+1)){
			counter++;
		}
		if(i === 0){
			if(_alive(N-1,j-1)){
				counter++;
			}
			if(_alive(N-1,j)){
				counter++;
			}
			if(_alive(N-1,j+1)){
				counter++;
			}
		}
		if(i === N-1){
			if(_alive(0,j-1)){
				counter++;
			}
			if(_alive(0,j)){
				counter++;
			}
			if(_alive(0,j+1)){
				counter++;
			}
		}
		if(j === M-1){
			if(_alive(i,0)){
				counter++;
			}
			if(_alive(i-1,0)){
				counter++;
			}
			if(_alive(i+1,0)){
				counter++;
			}
		}
		if(j === 0){
			if(_alive(i,M-1)){
				counter++;
			}
			if(_alive(i-1,M-1)){
				counter++;
			}
			if(_alive(i+1,M-1)){
				counter++;
			}
		}
		return counter;
	};

	var _loadGrid = function(pattern){
		// init grid
		var x = N/5,
			index = 0,
			row = 0,
			column = 0;

		while(index < pattern.length){
			var c = pattern.charAt(index++);
			if(c === 'O'){
				_setCell(x+column, x+row, 1);
			}
			if(c === 'x'){
				column = -1;
				row++;
			}
			column++;
		}
	};

	var _draw = function(){
		if(running){
			// If a cell has either 0 or exactly 1 neighbour, it will die on underpopulation.
			// If a cell has exactly 4 or more neighbours, it will die on overpopulation
			// If an empty space has exactly 3 cells, the empty space will be populated by a new cell.
			var i = 0, j = 0;
			for(i = 0; i< N; i++){
				for(j = 0; j< M; j++){
					var count = _neightboursCount(i, j);
					if(_alive(i, j)){
						if(count <= 1){
							_setCell(i, j, 2);
						} else if(count >= 4){
							_setCell(i, j, 2);
						}
					}else{
						if(count === 3){
							_setCell(i, j, 1);
						} else if(_dying(i,j)){
							if(_getCell(i, j) >= 10){
								_setCell(i, j, 0);
							} else{
								_setCell(i, j, _getCell(i, j)+1);
							}
						}
					}
				}
			}
			for(i = 0; i< N; i++){
				for(j = 0; j< M; j++){
					_drawCell(i, j);
				}
			}
		}
		window.requestAnimationFrame(_draw);
	};
	
	// load a pattern into the canvas
	var _init = function(pattern){
		// clear the canvas
		context.clearRect(0, 0, width, height);
		// empty the grids
		grid.length = 0;
		change.length = 0;
		
		_drawGrid();
		_loadGrid(pattern);
		window.requestAnimationFrame(_draw);
	};

	// initialise the app
	app.load = function(){
		_loadParams();
		_addButtons();
		_addHandlers();
		_run();
		_init(patterns.Glidergun);
	};

	return app;
})(jQuery, document);

jQuery(VI_GOL.load);
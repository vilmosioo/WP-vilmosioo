'use strict';

var interval = 1000 / 24, width = 0, height = 0, canvas;
var r = 65;
var g = 180;
var b = 255;

function mixf(xy1, xy2, mix){
	return {
		x: xy1.x * mix + xy2.x * (1-mix),
		y: xy1.y * mix + xy2.y * (1-mix)
	};
}

function f1(t){
	return {
		x: 13*Math.cos(t) - 6*Math.cos(11/6*t),
		y: 11*Math.sin(t) - 6*Math.sin(11/6*t)
	};
}

function f2(t){
	return {
		x: 3 * (Math.cos(3*t)),
		y: 5 * (3*Math.sin(t))
	};
}

function drawShape(time, alpha){
	var ctx = canvas.getContext('2d');
	var mix = Math.sin(time);
	ctx.globalAlpha = alpha;
	ctx.globalCompositeOperation = "lighter";
	ctx.lineWidth = 1.5;
	ctx.strokeStyle = "#ffffff";
	ctx.strokeStyle = "rgb("+r+","+g+","+b+")";
	ctx.beginPath();
	for (var xy,t=0; t<Math.PI*12; t+=Math.PI/32)
	{
		xy = mixf(f1(t), f2(t), mix);
		ctx.lineTo(width/2 + xy.x * 15, height/2 + -xy.y * 15);
	}
	ctx.closePath();
	ctx.stroke();
}

function fillGrid(){
	var context = canvas.getContext('2d');
	context.globalAlpha = 1;
	// paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
	var lingrad = context.createRadialGradient(width/2, width/2, 100, width/2, width/2, width);
	lingrad.addColorStop(0, '#666');
	lingrad.addColorStop(1, '#000');
	// assign gradients to fill and stroke styles
	context.fillStyle = lingrad;
	//context.fillStyle = '#111';
	context.fillRect(0,0,width,height);
	context.globalAlpha = 0.1;
	context.beginPath();
	context.strokeStyle = '#999';
	context.lineWidth = 1;
	for (var x = 0.5; x < width; x += 10) {
		context.moveTo(x, 0);
		context.lineTo(x, height);
	}
	for (var y = 0.5; y < height; y += 10) {
		context.moveTo(0, y);
		context.lineTo(width, y);
	}
	context.stroke();
}

function draw(){
	var ctx = canvas.getContext('2d');
	ctx.clearRect(0, 0, width, height);
	var time = Date.now() / 1600;
	fillGrid();
	for(var i=0; i < 5; i++){
		drawShape(time-i*0.02, (5-i)/5*0.95);
	}
	r = Math.round(r + 5*Math.random()-2.5);
	g = Math.round(g + 5*Math.random()-2.5);
	b = Math.round(b + 5*Math.random()-2.5);
	window.requestAnimFrame(function(){
		draw();
	});
}

window.onload = function(){
	canvas = document.getElementById('canvas-play');
	width = 778;
	height = Math.floor(width*666/1000);
	canvas.width = width;
	canvas.height = height;
	canvas.style.width = width;
	canvas.style.height = height;
	canvas.onclick = function () {
		window.location = canvas.toDataURL('image/png');
	};
	draw();
};

window.requestAnimFrame = (function(){
	return window.requestAnimationFrame ||
	window.webkitRequestAnimationFrame ||
	window.mozRequestAnimationFrame ||
	window.oRequestAnimationFrame ||
	window.msRequestAnimationFrame ||
	function(callback){
		window.setTimeout(callback, interval);
	};
})();

/*CANVAS
createLinearGradient(x0, y0, x1, y1) paints along a line from (x0, y0) to (x1, y1).
createRadialGradient(x0, y0, r0, x1, y1, r1) paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
my_gradient.addColorStop(0, "black");
ctx.rect(x, y, width, height)
*/
window.onload = function(){
	var container = jQuery('#main .entry-content');
	width = jQuery('<canvas/>', {  
		id: 'canvas-gol',
		style: 'width: 100%'
	}).appendTo(container).width(); 
	height = Math.floor(width*666/1000);
	aspect = width / height;
	canvas = document.getElementById('canvas-gol');
	canvas.width = width;
	canvas.height = height;
	canvas.style.width = width;
	canvas.style.height = height;

	if(!canvas.getContext("webgl") && !canvas.getContext("experimental-webgl")){
        alert("Your Browser Doesn't Support WebGL"); 
        return; 
    }
    else  
    {  
        gl = (canvas.getContext("webgl")) ? canvas.getContext("webgl") : canvas.getContext("experimental-webgl");  
       	gl.viewport(0, 0, canvas.width, canvas.height); 
		gl.clearColor(0, 0.5, 0, 1);
		gl.clear(gl.COLOR_BUFFER_BIT);
		
		// create shaders
		var v = document.getElementById("vertex").firstChild.nodeValue;
		var f = document.getElementById("fragment").firstChild.nodeValue;
		 
		var vs = gl.createShader(gl.VERTEX_SHADER);
		gl.shaderSource(vs, v);
		gl.compileShader(vs);
		 
		var fs = gl.createShader(gl.FRAGMENT_SHADER);
		gl.shaderSource(fs, f);
		gl.compileShader(fs);
		 
		// unify the shaders
		program = gl.createProgram();
		gl.attachShader(program, vs);
		gl.attachShader(program, fs);
		gl.linkProgram(program);

		// debug any problems
		if (!gl.getShaderParameter(vs, gl.COMPILE_STATUS)) 
		        console.log(gl.getShaderInfoLog(vs));
		 
		if (!gl.getShaderParameter(fs, gl.COMPILE_STATUS)) 
		        console.log(gl.getShaderInfoLog(fs));
		 
		if (!gl.getProgramParameter(program, gl.LINK_STATUS)) 
		        console.log(gl.getProgramInfoLog(program));

		// create a buffer array for the object
		var vertices = new Float32Array([
		        -0.5, 0.5*aspect, 0.5, 0.5*aspect,  0.5,-0.5*aspect,  // Triangle 1
		        -0.5, 0.5*aspect, 0.5,-0.5*aspect, -0.5,-0.5*aspect   // Triangle 2
		        ]);
		 
		vbuffer = gl.createBuffer();
		gl.bindBuffer(gl.ARRAY_BUFFER, vbuffer);                                       
		gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW);
		 
		itemSize = 2;
		numItems = vertices.length / itemSize;

	    gl.useProgram(program);
	     
	    // assign color to program
	    program.uColor = gl.getUniformLocation(program, "uColor");
	    gl.uniform4fv(program.uColor, [0.0, 0.3, 0.0, 1.0]);
	     
	    // assign vertex to program
	    program.aVertexPosition = gl.getAttribLocation(program, "aVertexPosition");
	    gl.enableVertexAttribArray(program.aVertexPosition);
	    gl.vertexAttribPointer(program.aVertexPosition, itemSize, gl.FLOAT, false, 0, 0);

	    // draw object
    	gl.drawArrays(gl.TRIANGLES, 0, numItems);

    }  

	// start the application
	requestAnimFrame(function(){
	    draw();
	});
};	

var interval = 1000 / 60; // 60 frames for every 1000 ms
var gl = null;
var width, height;
var aspect;

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


function draw(){

	requestAnimFrame(function(){
        draw();
    });
	
}

/*
THANKS TO:
https://developer.mozilla.org/en-US/docs/WebGL/Adding_2D_content_to_a_WebGL_context
http://www.netmagazine.com/tutorials/get-started-webgl-draw-square
*/

/*CANVAS
createLinearGradient(x0, y0, x1, y1) paints along a line from (x0, y0) to (x1, y1).
createRadialGradient(x0, y0, r0, x1, y1, r1) paints along a cone between two circles. The first three parameters represent the start circle, with origin (x0, y0) and radius r0. The last three parameters represent the end circle, with origin (x1, y1) and radius r1.
my_gradient.addColorStop(0, "black");
ctx.rect(x, y, width, height)
*/
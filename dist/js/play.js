/*! VilmosIoo - v1.3.4 */"use strict";function mixf(a,b,c){return{x:a.x*c+b.x*(1-c),y:a.y*c+b.y*(1-c)}}function f1(a){return{x:13*Math.cos(a)-6*Math.cos(11/6*a),y:11*Math.sin(a)-6*Math.sin(11/6*a)}}function f2(a){return{x:3*Math.cos(3*a),y:15*Math.sin(a)}}function drawShape(a,c){var d=canvas.getContext("2d"),e=Math.sin(a);d.globalAlpha=c,d.globalCompositeOperation="lighter",d.lineWidth=1.5,d.strokeStyle="#ffffff",d.strokeStyle="rgb("+r+","+g+","+b+")",d.beginPath();for(var f,h=0;h<12*Math.PI;h+=Math.PI/32)f=mixf(f1(h),f2(h),e),d.lineTo(width/2+15*f.x,height/2+15*-f.y);d.closePath(),d.stroke()}function fillGrid(){var a=canvas.getContext("2d");a.globalAlpha=1;var b=a.createRadialGradient(width/2,width/2,100,width/2,width/2,width);b.addColorStop(0,"#666"),b.addColorStop(1,"#000"),a.fillStyle=b,a.fillRect(0,0,width,height),a.globalAlpha=.1,a.beginPath(),a.strokeStyle="#999",a.lineWidth=1;for(var c=.5;width>c;c+=10)a.moveTo(c,0),a.lineTo(c,height);for(var d=.5;height>d;d+=10)a.moveTo(0,d),a.lineTo(width,d);a.stroke()}function draw(){var a=canvas.getContext("2d");a.clearRect(0,0,width,height);var c=Date.now()/1600;fillGrid();for(var d=0;5>d;d++)drawShape(c-.02*d,(5-d)/5*.95);r=Math.round(r+5*Math.random()-2.5),g=Math.round(g+5*Math.random()-2.5),b=Math.round(b+5*Math.random()-2.5),window.requestAnimationFrame(function(){draw()})}var width=0,height=0,canvas,r=65,g=180,b=255;window.onload=function(){canvas=document.getElementById("canvas-play"),width=778,height=Math.floor(666*width/1e3),canvas.width=width,canvas.height=height,canvas.style.width=width,canvas.style.height=height,canvas.onclick=function(){window.location=canvas.toDataURL("image/png")},draw()};
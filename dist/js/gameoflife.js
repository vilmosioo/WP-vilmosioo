/*! VilmosIoo - v1.1.0 */function init(a){context.clearRect(0,0,width,height),grid.length=0,change.length=0;var b=context.createRadialGradient(width/2,width/2,100,width/2,width/2,width);b.addColorStop(0,"#666"),b.addColorStop(1,"#000");for(var c=0;N>c;c++)for(var d=0;M>d;d++){var e=Math.floor(width/N),f=Math.floor(height/M);context.fillStyle="#aaa",context.fillRect(c*e,d*f,e,f),context.globalAlpha=.1,context.beginPath(),context.strokeStyle="#666",context.lineWidth=1,context.moveTo(c*e,d*f),context.lineTo(c*e+e,d*f),context.lineTo(c*e+e,d*f+f),context.lineTo(c*e,d*f+f),context.lineTo(c*e,d*f),context.stroke(),context.globalAlpha=1}for(var g=N/5,h=0,i=0,j=0;h<a.length;){var k=a.charAt(h++);"O"==k&&setCell(g+j,g+i,1),"x"==k&&(j=-1,i++),j++}requestAnimFrame(function(){draw()})}function draw(){if(running){for(i=0;N>i;i++)for(j=0;M>j;j++){var a=neightboursCount(i,j);alive(i,j)?1>=a?setCell(i,j,2):a>=4&&setCell(i,j,2):3==a?setCell(i,j,1):dying(i,j)&&(getCell(i,j)>=10?setCell(i,j,0):setCell(i,j,getCell(i,j)+1))}for(i=0;N>i;i++)for(j=0;M>j;j++)drawCell(i,j)}requestAnimFrame(function(){draw()})}function neightboursCount(a,b){var c=0;return alive(a,b-1)&&c++,alive(a,b+1)&&c++,alive(a-1,b-1)&&c++,alive(a-1,b)&&c++,alive(a-1,b+1)&&c++,alive(a+1,b-1)&&c++,alive(a+1,b)&&c++,alive(a+1,b+1)&&c++,0==a&&(alive(N-1,b-1)&&c++,alive(N-1,b)&&c++,alive(N-1,b+1)&&c++),a==N-1&&(alive(0,b-1)&&c++,alive(0,b)&&c++,alive(0,b+1)&&c++),b==M-1&&(alive(a,0)&&c++,alive(a-1,0)&&c++,alive(a+1,0)&&c++),0==b&&(alive(a,M-1)&&c++,alive(a-1,M-1)&&c++,alive(a+1,M-1)&&c++),c}function alive(a,b){return 1==grid[a*N+b]}function dying(a,b){return grid[a*N+b]>=2}function getCell(a,b){return grid[a*N+b]}function setCell(a,b,c){change[a*N+b]=c}function changed(a,b){return change[a*N+b]!=grid[a*N+b]}function drawCell(a,b){var c=Math.floor(width/N),d=Math.floor(height/M);changed(a,b)&&(context.fillStyle=1==change[a*N+b]?"#fff":change[a*N+b]>=2?"rgba(65,180,255,"+.75*change[a*N+b]/10+")":"#000",context.fillRect(a*c,b*d,c,d),grid[a*N+b]=change[a*N+b])}window.onload=function(){canvas=document.getElementById("canvas-gol"),context=canvas.getContext("2d"),width=778,height=Math.floor(666*width/1e3),canvas.width=width,canvas.height=height,canvas.style.width=width,canvas.style.height=height;var a=document.body.clientWidth-20;width>a&&(width=a,height=.666*width),canvas.width=width,canvas.height=height,canvas.style.width=width+"px",canvas.style.height=height+"px",jQuery("#save").click(function(){window.location=canvas.toDataURL("image/png")}),jQuery("#run").click(function(){running?(running=!1,jQuery(this).text("Run")):(running=!0,jQuery(this).text("Pause"))});var b="........................Ox......................O.Ox............OO......OO............OOx...........O...O....OO............OOxOO........O.....O...OOxOO........O...O.OO....O.Ox..........O.....O.......Ox...........O...Ox............OO",c="...Ox.O...OxOxO....OxOOOOO",d=".OOxOOx.O";jQuery("#glidergun").addClass("active"),init(b),jQuery("#ship").click(function(){jQuery("#ship, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(c)}),jQuery("#glidergun").click(function(){jQuery("#ship, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(b)}),jQuery("#pentomino").click(function(){jQuery("#ship, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(d)})};var interval=1e3/60,N=125,M=Math.floor(666*N/1e3),grid=new Array(N*M),change=new Array(N*M),running=!1,context=null;window.requestAnimFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){window.setTimeout(a,interval)}}();
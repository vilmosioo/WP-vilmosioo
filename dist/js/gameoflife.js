/*! VilmosIoo - v1.3.10 */"use strict";function alive(a,b){return 1===grid[a*N+b]}function dying(a,b){return grid[a*N+b]>=2}function getCell(a,b){return grid[a*N+b]}function setCell(a,b,c){change[a*N+b]=c}function changed(a,b){return change[a*N+b]!==grid[a*N+b]}function drawCell(a,b){var c=Math.floor(width/N),d=Math.floor(height/M);changed(a,b)&&(context.fillStyle=1===change[a*N+b]?"#fff":change[a*N+b]>=2?"rgba(65,180,255,"+.75*change[a*N+b]/10+")":"#000",context.fillRect(a*c,b*d,c,d),grid[a*N+b]=change[a*N+b])}function neightboursCount(a,b){var c=0;return alive(a,b-1)&&c++,alive(a,b+1)&&c++,alive(a-1,b-1)&&c++,alive(a-1,b)&&c++,alive(a-1,b+1)&&c++,alive(a+1,b-1)&&c++,alive(a+1,b)&&c++,alive(a+1,b+1)&&c++,0===a&&(alive(N-1,b-1)&&c++,alive(N-1,b)&&c++,alive(N-1,b+1)&&c++),a===N-1&&(alive(0,b-1)&&c++,alive(0,b)&&c++,alive(0,b+1)&&c++),b===M-1&&(alive(a,0)&&c++,alive(a-1,0)&&c++,alive(a+1,0)&&c++),0===b&&(alive(a,M-1)&&c++,alive(a-1,M-1)&&c++,alive(a+1,M-1)&&c++),c}function draw(){if(running){var a=0,b=0;for(a=0;N>a;a++)for(b=0;M>b;b++){var c=neightboursCount(a,b);alive(a,b)?1>=c?setCell(a,b,2):c>=4&&setCell(a,b,2):3===c?setCell(a,b,1):dying(a,b)&&(getCell(a,b)>=10?setCell(a,b,0):setCell(a,b,getCell(a,b)+1))}for(a=0;N>a;a++)for(b=0;M>b;b++)drawCell(a,b)}window.requestAnimationFrame(function(){draw()})}function init(a){context.clearRect(0,0,width,height),grid.length=0,change.length=0;var b=context.createRadialGradient(width/2,width/2,100,width/2,width/2,width);b.addColorStop(0,"#666"),b.addColorStop(1,"#000");for(var c=0;N>c;c++)for(var d=0;M>d;d++){var e=Math.floor(width/N),f=Math.floor(height/M);context.fillStyle="#aaa",context.fillRect(c*e,d*f,e,f),context.globalAlpha=.1,context.beginPath(),context.strokeStyle="#666",context.lineWidth=1,context.moveTo(c*e,d*f),context.lineTo(c*e+e,d*f),context.lineTo(c*e+e,d*f+f),context.lineTo(c*e,d*f+f),context.lineTo(c*e,d*f),context.stroke(),context.globalAlpha=1}for(var g=N/5,h=0,i=0,j=0;h<a.length;){var k=a.charAt(h++);"O"===k&&setCell(g+j,g+i,1),"x"===k&&(j=-1,i++),j++}window.requestAnimationFrame(function(){draw()})}var N=125,M=Math.floor(666*N/1e3),grid=new Array(N*M),change=new Array(N*M),running=!1,context=null,canvas=null,width=0,height=0;window.onload=function(){canvas=document.getElementById("canvas-gol"),context=canvas.getContext("2d"),width=1e3,height=Math.floor(666*width/1e3);var a=document.body.clientWidth-20;width>a&&(width=a,height=.666*width),canvas.width=width,canvas.height=height,canvas.style.width=width+"px",canvas.style.height=height+"px",jQuery("#save").click(function(){window.location=canvas.toDataURL("image/png")}),jQuery("#run").click(function(){running?(running=!1,jQuery(this).text("Run")):(running=!0,jQuery(this).text("Pause"))});var b="........................Ox......................O.Ox............OO......OO............OOx...........O...O....OO............OOxOO........O.....O...OOxOO........O...O.OO....O.Ox..........O.....O.......Ox...........O...Ox............OO",c="...Ox.O...OxOxO....OxOOOOO",d=".Ox..OxOOO",e="..........O.Ox.........Ox..........O..Ox............OOOxxxxxx.OxO.OxxO..Ox..OOx...O",f="...........OO.....OOOOx.........OO.OO...O...Ox.........OOOO........Ox..........OO.....O..Oxx........Ox.......OO........OOx......O.........O..Ox.......OOOOO....O..Ox........OOOO...OO.OOx...........O....OOxxxx..................OOOOxO..O.............O...Ox....O................OxO...O............O..Ox.OOOO",g=".OOxOOx.O";jQuery("#glidergun").addClass("active"),init(b),jQuery("#ship").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(c)}),jQuery("#glidergun").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(b)}),jQuery("#pentomino").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(g)}),jQuery("#space").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(f)}),jQuery("#noah").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(e)}),jQuery("#glider").click(function(){jQuery("#glider, #noah, #ship, #space, #glidergun, #pentomino").removeClass("active"),jQuery(this).addClass("active"),init(d)})};
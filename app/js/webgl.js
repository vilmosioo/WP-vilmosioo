'use strict';

var APP = (function (app, $) {
	var sphere, renderer, camera, scene, controls;
	
	app.load = function(source){
		var xhr = new XMLHttpRequest();
		xhr.open('GET', source, true);
		xhr.responseType = 'arraybuffer';
		xhr.onload = function() {
			if (this.status === 200) {
				app.parse(this.response); // our stl file as blob
			} else {
				console.log('error loading');
			}
		};
		xhr.send();
	};

	app.parse = function(data){
		var dv = new DataView(data);
		var header = '';
		var position = 0;
		while(position < 80){
			header += String.fromCharCode(dv.getUint8(position++));
		}
		var triangles = dv.getUint32(position, true);
		position += 4;
		var index = 0;
		var geometry = new THREE.Geometry();
		var minX = 0;
		var maxX = 0;
		var minY = 0;
		var maxY = 0;
		while(index < triangles){
			position += 12; // skip normal
			for(var j = 0; j<3; j++){
				var x = dv.getFloat32(position, true);
				position+=4;
				var y = dv.getFloat32(position, true);
				position+=4;
				var z = dv.getFloat32(position, true);
				position+=4;
				if(x < minX){
					minX = x;
				}
				if(x > maxX){
					maxX = x;
				}
				if(y < minY){
					minY = y;
				}
				if(y > maxY){
					maxY = y;
				}
				//console.log('Point: [' + x + ', '+ y + ', '+ z + ']');
				geometry.vertices.push(new THREE.Vector3(x,y,z));
				position += 12;
			}
			position += 2;
			//console.log('Face: [' + (index*3) + ', '+ (index*3+1) + ', '+ (index*3+2) + ']');
			geometry.faces.push( new THREE.Face3(index*3, index*3+1, index*3+2));
			index++;
		}
		geometry.computeFaceNormals();
		// console.log(object);
		// console.log('minX ' + minX + 'maxX ' + maxX + 'minY ' + minY + 'maxY ' + maxY);
	};

	app.init = function(){
		// get the DOM element to attach to
		// - assume we've got jQuery to hand
		var $container = $('#webgl');
		var img = $container.attr('data-src');

		// set the scene size
		var WIDTH = $container.width(),
			HEIGHT = $container.height();
		// set some camera attributes
		var VIEW_ANGLE = 45,
			ASPECT = WIDTH / HEIGHT,
			NEAR = 0.1,
			FAR = 10000;

		// create a WebGL renderer, camera
		// and a scene
		renderer = new THREE.WebGLRenderer({antialias:true});
		camera = new THREE.PerspectiveCamera(  VIEW_ANGLE, ASPECT, NEAR, FAR);
		scene = new THREE.Scene();
		// the camera starts at 0,0,0 so pull it back
		camera.position.set(0,400,1000);
		controls = new THREE.TrackballControls( camera );
		controls.rotateSpeed = 2.0;
		controls.zoomSpeed = 2.4;
		controls.panSpeed = 1.6;
		controls.noZoom = false;
		controls.noPan = false;
		controls.staticMoving = true;
		controls.dynamicDampingFactor = 0.3;
		controls.keys = [ 65, 83, 68 ];
		// start the renderer
		renderer.setSize(WIDTH, HEIGHT);
		renderer.setClearColor(0xFFFFFF, 1);
		// attach the render-supplied DOM element
		$container.append(renderer.domElement);

		// create the sphere's material
		var sphereMaterial = new THREE.MeshLambertMaterial({ map: THREE.ImageUtils.loadTexture(img) });
		var radius = 100, segments = 64, rings = 64;
		sphere = new THREE.Mesh(
			new THREE.SphereGeometry(radius, segments, rings),
			sphereMaterial
		);
		sphere.position.set(0,radius,0);
		// add the sphere to the scene
		scene.add(sphere);

		var planeW = 50; // pixels
		var planeH = 50; // pixels
		var numW = 200; // how many wide (50*50 = 2500 pixels wide)
		var numH = 200; // how many tall (50*50 = 2500 pixels tall)
		var plane = new THREE.Mesh(
			new THREE.PlaneGeometry( planeW*numW, planeH*numH, planeW, planeH ), //  width, height, segmentsWidth, segmentsHeight
			new THREE.MeshBasicMaterial( { color: 0x666666, wireframe: true } )
		);
		plane.rotation.set(Math.PI/2, 0, 0); // Set initial rotation
		scene.add(plane);
		// and the camera
		scene.add(camera);

		// create a point light
		var pointLight = new THREE.PointLight( 0xFFFFFF );
		// set its position
		pointLight.position.set(0,0,1000).normalize();
		// add to the scene
		scene.add(pointLight);

		var ambientLight = new THREE.AmbientLight(0x444444);
		scene.add(ambientLight);

		// directional lighting
		var directionalLight = new THREE.DirectionalLight(0xffffff);
		directionalLight.position.set(0,0,1000).normalize();
		scene.add(directionalLight);

		// draw!
		window.requestAnimationFrame(app.animloop);
	};

	app.animloop = function(){
		controls.update();
		sphere.rotation.y+=0.003;
		renderer.render(scene, camera);
		window.requestAnimationFrame(app.animloop);
	};

	return app;
}(APP || {}, jQuery));

jQuery(document).ready(APP.init);
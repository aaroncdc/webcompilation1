		var x=0;
		var i = 0;
		var wwidth = window.innerWidth;
		var wheight = window.innerHeight;
		var c = new THREE.WebGLRenderer();
		c.setSize(wwidth,wheight);
		document.body.appendChild(c.domElement);
		c.domElement.style.position = "absolute";
		c.domElement.style.top = "0";
		c.domElement.style.left = "0";

		var scale = 50;

		//u latitude, v longitude on sphere
		var paramFunction2 = function (u, v) {
			var fi = Math.tan((2*Math.PI*i)/200);
			var u = 4*Math.PI*u+fi;
			var v = 8*Math.PI*v+fi;
			var px = Math.sin(u)+Math.cos(u*2)+fi;
			var py = Math.cos(v*2)+fi*px;
			var pz = Math.cos(u)+fi*px;
			var retval = new THREE.Vector3(px*scale, py*scale, pz*scale);
            return retval;
        }

		var scene = new THREE.Scene;

		var geometry = new THREE.ParametricBufferGeometry( paramFunction2, 16, 16 );
		var material = new THREE.MeshBasicMaterial( { color: 0x202020 } );
		var cube = new THREE.Mesh( geometry, material );
		cube.material.side = THREE.DoubleSide;
		cube.position.z = -400;

		scene.add( cube );

		var cubeframe = new THREE.WireframeGeometry(geometry);
		var linemat = new THREE.LineBasicMaterial( { color: 0xffffff, linewidth: 2 } );
		var line = new THREE.LineSegments(cubeframe,linemat);

		line.position.z = -400;

		scene.add(line);

		var cam = new THREE.PerspectiveCamera(45,(wwidth/wheight),0.1,10000);
		cam.position.y = 160;
		cam.position.z = 700;

		scene.add(cam);

		var light1 = new THREE.PointLight(0xff0044);
		light1.position.set(120,260,100);

		var light2 = new THREE.PointLight(0x4499ff);
		light2.position.set(-100,100,200);

		scene.add(light1);
		scene.add(light2);

		var floorgeo = new THREE.PlaneGeometry(4089,4089,20,20);
		var lineframe = new THREE.WireframeGeometry(floorgeo);
		var floorlinemat = new THREE.LineBasicMaterial( { color: 0xffffff, linewidth: 1, transparent: true, opacity: .6 } );
		var floorline = new THREE.LineSegments(lineframe,floorlinemat);

		floorline.rotation.x = Math.PI*90/180;
		floorline.position.y = -100;

		scene.add(floorline);
		cam.lookAt(floorline.position);
		

		c.render(scene,cam);

		function regen()
		{
			scene.remove(cube);
			scene.remove(line);
			geometry = new THREE.ParametricBufferGeometry( paramFunction2, 16, 16 );
			material = new THREE.MeshBasicMaterial( { color: 0x202020 } );
			cube = new THREE.Mesh( geometry, material );
			cube.material.side = THREE.DoubleSide;
			cube.position.z = -400;

			scene.add( cube );

			cubeframe = new THREE.WireframeGeometry(geometry);
			linemat = new THREE.LineBasicMaterial( { color: 0xffffff, linewidth: 2 } );
			line = new THREE.LineSegments(cubeframe,linemat);

			line.position.z = -400;

			scene.add(line);
		}

		function render_scene(){
			c.domElement.style.width = "100%"
			c.domElement.style.height = "100%";

			var lrot = 2*Math.PI*Math.sin(x);
			cam.position.x = 200 * Math.sin(x+=.0025);
			cam.position.z = 200 * Math.sin(i/100);

			line.rotation.z = cube.rotation.z = lrot;
			line.rotation.x = cube.rotation.x = lrot;

			c.render(scene,cam);
			requestAnimationFrame(render_scene);

			var color = glitter(i+=1,"0x");
			regen();
			//cube.material.color.setHex(color);
			floorline.material.color.setHex(color);
		}

		window.addEventListener('resize', function (){
			cam.aspect = window.innerWidth / window.innerHeight;
			cam.updateProjectionMatrix();
			c.setSize(window.innerWidth, window.innerHeight);
		}, false);

		render_scene();
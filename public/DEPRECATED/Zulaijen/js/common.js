	var menustatus = false;
	
	function nav(index) {
		if(isNaN(index))
			index = 0;
		location.href = "index.php?mi=" + index;
	}

	function setCookie(cname, cvalue, exdays) {
	    /*var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "; expires="+d.toUTCString();
	    document.cookie = cname + "=" + cvalue + expires + "; path='/'; domain=127.0.0.1";*/
		$.cookie(cname, cvalue, { expires: exdays, path: '/Zulaijen' });
	}

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1);
					if (c.indexOf(name) == 0) return unescape(c.substring(name.length,c.length));
		}
		return "";
	}

	function sendlogin(usname, uspass) {
		$.ajax({
			url: 'utils/login.php',
			method: 'POST',
			data: {
				login_name: usname,
				login_password: uspass
			}
		}).done(function(data){
			var error = data.indexOf("@E.");
			var success = data.indexOf("@1.");
			
			if(error > -1 || success < 0)
			{
				alert(data.substring(error+4));
				return;
			}
				
			setCookie("Session", data.substring(success+4),30);
			setCookie("User", usname,30);
						
			//alert("You are now logged in!");
			$("#loginform").slideUp(500,function(){
				$("#namelabel").html("<b>Logged in as </b>" + usname);
				$("#userpanel").slideDown(500,0);
			});
			
		});
	}

	$(document).ready(function() {
		$("#userpanel").slideUp(0,0);
		$("#hmenu").slideUp(0,0);
		
		var user = getCookie("User");
		var session = getCookie("Session");
		
		if(user != "" && session != "")
		{
			$("#loginform").slideUp(0,function(){
				$("#namelabel").html("<b>Logged in as </b>" + user);
				$("#userpanel").slideDown(0,0);
			});

		}else{
			setCookie("User", "", -1);
			setCookie("Session", "", -1);
		}
		
		$('.entry').magnificPopup({
  			delegate: 'a.zoomin', // child items selector, by clicking on it popup will open
  			type: 'image',  // other options
  			image: {
			  markup: '<div class="mfp-figure">'+
			            '<div class="mfp-close"></div>'+
			            '<div class="mfp-img"></div>'+
			            '<div class="mfp-bottom-bar">'+
			              '<div class="mfp-title"></div>'+
			              '<div class="mfp-counter"></div>'+
			            '</div>'+
			          '</div>', // Popup HTML markup. `.mfp-img` div will be replaced with img tag, `.mfp-close` by close button
			
			  cursor: 'mfp-zoom-out-cur', // Class that adds zoom cursor, will be added to body. Set to null to disable zoom out cursor.
			
			  titleSrc: 'Image View', // Attribute of the target element that contains caption for the slide.
			  // Or the function that should return the title. For example:
			  // titleSrc: function(item) {
			  //   return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			  // }
			
			  verticalFit: false, // Fits image in area vertically
			  closeOnBgClick: true,
			  enableEscapeKey: true,
			  tError: '<a href="%url%">The image</a> could not be loaded.' // Error message
			}
		});
		
		$("#tgmenu").click(function(){
			if(!menustatus)
				$("#hmenu").slideDown(500,0);
			else
				$("#hmenu").slideUp(500,0);
			menustatus = !menustatus;
		});
		
		$("#loginb").click(function(){
			sendlogin($("#lname").val(), $("#lpass").val());
		});
		
		$("#logoutb").click(function(){
			setCookie("User", "", -1);
			setCookie("Session", "", -1);
			$("#userpanel").slideUp(500,function(){
				$("#namelabel").html("<b>You are not logged in</b>");
				$("#loginform").slideDown(500,0);
			});

		});
		
		$("#registerb").click(function(){
			document.location.href = "register.php";
		});
		
		$(document).scroll(function(){
			if($(document).scrollTop() > 84) {
				$("#mynav").attr("class", "navsnap");
				$("#hmenu").attr("class", "hmenusnap");

			}else{
				$("#mynav").attr("class", "");
				$("#hmenu").attr("class", "hmenu");
			}

		});
		
	});


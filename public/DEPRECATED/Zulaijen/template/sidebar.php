<sidebar>
	<div class="topb"></div>
	
	<h4>User Menu: </h4>
	<form class="login_form" id="loginform" method="POST" action="act_login.php">
		<label for="login_name" class="login_label">User Name:</label>
		<input type="text" id="lname" name="login_name" placeholder="Name" class="ui_login"/>
		<label for="login_password" class="login_label" style="margin-top: 3px;">Password:</label>
		<input type="password" id="lpass" name="login_password" placeholder="Password" class="ui_login"/>
		<input type="button" id="loginb" value="Login" class="button" style="margin-top: 3px;"/> <!-- id="loginb" -->
		<input type="button" id="registerb" value="Register" class="button" style="margin-top: 3px;"/>
	</form>
	
	<form class="login_form" id="userpanel">
	<label class="login_label" id="namelabel"><b>Not logged in</b></label>
	<input type="button" id="logoutb" value="Log Out" class="button" />
	</form>
	
	<h4>Tags: </h4>
	<ul class="taglist">
		<li class="tag"><a href="#"> ? + - Tag1</a></li>
		<li class="tag"><a href="#"> ? + - Tag2</a></li>
		<li class="tag"><a href="#"> ? + - Tag3</a></li>
		<li class="tag"><a href="#"> ? + - Tag4</a></li>
		<li class="album"><a href="#"> ? + - Album1</a></li>
		<li class="album"><a href="#"> ? + - Album2</a></li>
		<li class="album"><a href="#"> ? + - Album3</a></li>
		<li class="author"><a href="#"> ? + - Author1</a></li>
		<li class="author"><a href="#"> ? + - Author2</a></li>
		<li class="author"><a href="#"> ? + - Author3</a></li>
	</ul>				
	<div class="banner">
		<center><a href="#"><img src="static/banner.jpg" style="width: 100%; height: 100%" /></a></center>
	</div>
</sidebar>
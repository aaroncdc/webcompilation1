<div class="bg"></div>
    <header>
        <a href="portada.php" class="headref"><img src="static/logo512.png" class="sitelogo" width="64" height="64"/>
            <h1 class="title">Socialbook</h1></a>
			<div class="botonera">
			<div class="head-button" style="background-image: url('static/person.png');" onclick="javascript: window.location.href='perfil.php'"></div>
            <div class="head-button" id="btnMail" style="background-image: url('static/mail.png');" onclick="javascript: window.location.href='mensajeria.php'"></div>
			<div class="head-button" id="btnSearch" style="background-image: url('static/search.png');"></div>
			<form name="ussearch" id="ussearch" action="busqueda.php" method="get" style="float: left; z-index: 200;">
				<input type="text" placeholder="Buscar..." id="txtSearch" name="searchstr" class="searchtext"/>
			</form>
			<div class="head-button" id="btnClose" style="background-image: url('static/close.png');"></div>
			<!--<input type="button" class="button" value="Cerrar sesión" id="btnSesion" style="position: relative; left: 0px; top: 48px;"/>-->
		</div>
    </header>
	<script type="text/javascript">
	
	
	function btnEvents() {
		$("#txtSearch").keydown(function(ev){
			var kp = event.keyCode || event.which;
			if(kp == 13)
			{
				//alert($("#txtSearch").val());
				$("#ussearch").submit();
			}
		});
		$("#btnSearch").click(function(){
				//alert($("#txtSearch").val());
				$("#ussearch").submit();
		});
		$("#btnClose").click(function(){
			document.cookie = 'sessionid' + '=; Path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			document.cookie = 'sessionmail' + '=; Path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			window.location.href="index.html";
		});
		
	}
	
	</script>
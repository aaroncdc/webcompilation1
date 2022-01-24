        <div class="scalestate" id="scalestate" style="display: none;">
        <a href="#" id="bigger"><b> · This image was scaled. Click here to view the image in full resolution · </b></a>
        </div>
        <div class="imgdisplay">
		<?php
			if(!isset($_GET['id']))
				die("<h2>No ID specified</h2>");
				
				$imgid = (int)$_GET['id'];
				
				$dirlist = array_diff(scandir("static/dtest"), array('..', '.'));
				
				if(!isset($dirlist[$imgid]))
					die("<h2>The image does not exist</h2>");
				
				echo ("<img src=\"static/dtest/$dirlist[$imgid]\" class=\"fullimg\" id=\"imgd\"/>");
					
			?>
			</div>
            <div class="scalestate" id="scalestatex" style="display: none;">
        	<a href="#" id="smaller"><b> · Click here to fit the image to make the image smaller again. · </b></a>
       		</div>
  <script language="javascript">
  	
	var dw = $(window).width(); //-150px (sidebar)
	var imgw = $("#imgd").width();
	if(imgw > 0)
		if (dw-150 < imgw)
		{
			$("#imgd").attr("class", "dispimg");
			$("#scalestate").attr("style", "display: block");
		}
		
	//if imgw = 0, waits for imgd to be loaded
  
	$("#imgd").load(function(){
			imgw = $("#imgd").width();
			if (dw-150 < imgw)
			{
				$("#imgd").attr("class", "dispimg");
				$("#scalestate").attr("style", "display: block");
			}
		});
	$("#bigger").click(function(){
			$("#scalestate").slideUp(500, function(){
					$("#imgd").attr("class", "fullimg");
					$("#scalestatex").slideDown(500,0);
				});
		});
		
		$("#smaller").click(function(){
			$("#scalestatex").slideUp(0, function(){
					$("#imgd").attr("class", "dispimg");
					$("#scalestate").slideDown(500,0);
				});
		});
</script>
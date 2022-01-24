<?php
	//echo $_POST['file']['name'];
	copy($_FILES['file']['name'],'uploads/'.$_FILES['file']['name']);
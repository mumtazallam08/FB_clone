<?php
	$conn = mysqli_connect("localhost", "root", "", "clonesite");
	
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>
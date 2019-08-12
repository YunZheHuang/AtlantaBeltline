<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$site_select = $_GET["site_select"];
	$trans_type = $_GET["trans_type"];
	$route = $_GET["route"];
		
	$sql2 = "INSERT INTO Site_Connect_transit(Type,Route,Site_Name) VALUES ('$trans_type','$route', '$site_select') ;";
	$result2 = mysqli_query($link,$sql2);
	$num2 = mysqli_affected_rows($link);
	if($num2 <= 0){
		echo "error";
	}

	// mysqli_free_result($result1);
	// mysqli_free_result($result2);
	mysqli_close($link);
?>
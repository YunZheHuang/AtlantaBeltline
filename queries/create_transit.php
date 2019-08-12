<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$trans_type = $_GET["trans_type"];
	$route = $_GET["route"];
	$price = $_GET["price"];
	$price = floatval($price);
	
	$sql1 = "INSERT INTO Transit(Price,Type,Route) VALUES('$price', '$trans_type', '$route') ";
	$result1 = mysqli_query($link,$sql1);
	$num1 = mysqli_affected_rows($link);
	if($num1 <= 0){
		echo "error";
	}
	mysqli_close($link);
?>
<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$trans_type = $_GET["trans_type"];
	$new_route = $_GET["new_route"];
	$new_price = $_GET["new_price"];
	$sites = $_GET["sites"];

	$sql = "INSERT INTO Site_Connect_transit(Type,Route,Site_Name) VALUES( '$trans_type' , '$new_route' , '$sites' )";
	$result = mysqli_query($link,$sql);

	$num = mysqli_affected_rows($link);
	if($num < 0){
		echo "error";
	}

	mysqli_close($link);
?>
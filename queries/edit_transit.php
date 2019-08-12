<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$trans_type = $_GET["trans_type"];
	$old_route = $_GET["old_route"];
	$old_price = $_GET["old_price"];
	$new_route = $_GET["new_route"];
	$new_price = $_GET["new_price"];
	$sites = $_GET["sites"];


	$sql = "UPDATE Transit SET Route = '$new_route', Price = '$new_price' WHERE Type = '$trans_type' AND Route = '$old_route' ";
		
	$result = mysqli_query($link,$sql);

	$num = mysqli_affected_rows($link);
	if($num < 0){
		echo "error";
	}

	$sql3 = "DELETE FROM Site_Connect_transit WHERE Type = '$trans_type' AND Route = '$new_route';";
	$result3 = mysqli_query($link,$sql3);

	mysqli_close($link);
?>
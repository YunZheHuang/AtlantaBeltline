<?php
	$host="localhost";
	$port="3306";
	$user="root";
	$password="Database4400";
	$dbname="atlantabeltline";
	
	$link = mysqli_connect($host,$user,$password,$dbname);

	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$email = $_GET["email"];
	$route = $_GET["route"];
	$trans_type = $_GET["trans_type"];
	$transit_date = $_GET["transit_date"];

	$sql = "SELECT Username FROM Email WHERE Email = 'dsmith@outlook.com'";
	$result = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($result);
	$user_name = $row['Username'];

	$sql2 = "INSERT INTO User_Take_Transit(Transit_date,Username,Type,Route)
			VALUES ('$transit_date','$user_name','$trans_type','$route')";
	$result2 = mysqli_query($link,$sql2);

	$num = mysqli_affected_rows($link);
	if($num <= 0){
		echo "error";
	}

	mysqli_free_result($result);
	// mysqli_free_result($result2);


?>
<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$email = $_GET["email"];
	$event_name = $_GET["event_name"];
	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	$description = $_GET["description"];
	$price = $_GET["price"];
	$capacity = $_GET["capacity"];
	$min_req = $_GET["min_req"];

	$sql = "SELECT Site_Name FROM Site WHERE Username = (SELECT Username FROM Email WHERE Email = '$email')";
	$result = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($result);
	$site_name = $row["Site_Name"];
	
	$sql1 = "INSERT INTO Event(Description, MinStaffReq, Capacity, Price, EndDate, Event_Name, StartDate, Site_Name) VALUES
		('$description','$min_req','$capacity','$price','$end_date','$event_name','$start_date','$site_name')";
	$result1 = mysqli_query($link,$sql1);
	$num1 = mysqli_affected_rows($link);
	if($num1 <= 0){
		echo "error";
	}
	mysqli_close($link);
?>
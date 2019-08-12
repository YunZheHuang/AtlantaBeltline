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
	$username = $_GET["username"];

	$sql = "SELECT Site_Name FROM Site WHERE Username = (SELECT Username FROM Email WHERE Email = '$email')";
	$result = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($result);
	$site_name = $row["Site_Name"];
	
	$sql1 = "INSERT INTO Staff_Assign_To_Event(Event_Name,StartDate, Site_Name, Username) Values
			('$event_name','$start_date','$site_name','$username')";
	$result1 = mysqli_query($link,$sql1);
	
    $num1 = mysqli_affected_rows($link);
	if($num1 <= 0){
		echo "error";
	}

    mysqli_free_result($result);
	mysqli_close($link);
?>
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


	$sql = "SELECT Site_Name FROM Site WHERE Username = (SELECT Username FROM Email WHERE Email = '$email')";
	$result = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($result);
	$site_name = $row["Site_Name"];

	$sql2 = "SELECT StartDate,EndDate,Event_Name FROM Event WHERE Site_Name= '$site_name'";
	$result2 = mysqli_query($link,$sql2);
	$i = 0;
    while($row = mysqli_fetch_assoc($result2))
    {
    	if($i == 0)
    	{
    		echo "{$row['StartDate']},{$row['EndDate']},{$row['Event_Name']}";
    		$i++;
    	}
    	else
    	{
    		echo "|{$row['StartDate']},{$row['EndDate']},{$row['Event_Name']}";
    	}
    }

    mysqli_free_result($result);
    mysqli_free_result($result2);

	mysqli_close($link);
?>
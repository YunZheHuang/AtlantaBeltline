<?php
	include ("./db.php");
	$link = $db;

	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$event_name = $_GET["event_name"];
	$site_name = $_GET["site_name"];
	$start_date = $_GET["start_date"];



	$sql = "SELECT Description,MinStaffReq,Capacity,EndDate FROM atlantabeltline.Event
			WHERE Event_Name='$event_name' and StartDate='$start_date' and Site_Name ='$site_name'";
	

	$result = mysqli_query($link,$sql);
	// $user_array = array();


	$i = 0;
	
	while($row = mysqli_fetch_assoc($result)) 
	{
		if($i == 0)
		{
			echo "{$row["Description"]}^{$row["MinStaffReq"]}^{$row["Capacity"]}^{$row["EndDate"]}";
		    $i++;
		}
		else
		{
			echo "|{$row["Description"]}^{$row["MinStaffReq"]}^{$row["Capacity"]}^{$row["EndDate"]}";
		}
	}

	mysqli_free_result($result);
	mysqli_close($link);
?>




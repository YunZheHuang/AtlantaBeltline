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

	// if($event_name == ""){
	// 	$event_name = "";
	// }
	// else{
	// 	$event_name = " AND Event_Name= '$event_name'";
	// }

	// if($site_name == ""){
	// 	$site_name = "";
	// }
	// else{
	// 	$site_name = " AND Site_Name = '$site_name'";
	// }

	// if($start_date == "YYYY-MM-DD"){
	// 	$start_date = "";
	// }
	// else{
	// 	$start_date = " AND StartDate >= '$start_date'";
	// }


	$sql = "SELECT DISTINCT Username FROM
			(SELECT Username FROM 
			(SELECT Username FROM
			(SELECT Username FROM atlantabeltline.Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name)
			WHERE Event_Name = '$event_name' and StartDate = '$start_date' and Site_Name = '$site_name') AS A
			UNION
			(SELECT distinct Username From 
			 (SELECT * FROM Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name) ) AS B
			WHERE 
			StartDate > (SELECT DISTINCT EndDate FROM atlantabeltline.Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name)
			WHERE Event_Name = '$event_name' and StartDate = '$start_date' and Site_Name = '$site_name') OR EndDate < '$start_date') ) AS C
			UNION
			(SELECT Username FROM User JOIN Employee USING(Username) WHERE STATUS = 'Approved' and Username NOT IN ( SELECT Username FROM
			(SELECT Username FROM atlantabeltline.Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name)
			WHERE Event_Name = '$event_name' and StartDate = '$start_date' and Site_Name = '$site_name') AS D
			UNION
			(SELECT distinct Username From 
			 (SELECT * FROM Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name) ) AS E
			WHERE 
			StartDate > (SELECT DISTINCT EndDate FROM atlantabeltline.Staff_Assign_To_Event JOIN Event USING(Event_Name,StartDate,Site_Name)
			WHERE Event_Name = '$event_name' and StartDate = '$start_date' and Site_Name = '$site_name') OR EndDate < '$start_date') ) and Employee_type = 'Staff') ) as F";
	

	$result = mysqli_query($link,$sql);
	$user_array = array();
	while($row = mysqli_fetch_assoc($result)) 
	{
		array_push($user_array,$row["Username"]);
		// echo $row;
	}
	

	for($x=0;$x<count($user_array);$x++)
	{

		$sql = "SELECT Firstname, Lastname FROM User WHERE Username = '$user_array[$x]' ";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_assoc($result);
		echo "|";
		echo $row["Firstname"];
		echo "-";
		echo $row["Lastname"];
	}

	mysqli_free_result($result);
	mysqli_close($link);
?>




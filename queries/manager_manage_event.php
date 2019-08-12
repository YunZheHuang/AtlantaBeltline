<?php
	include ("./db.php");
	$link = $db;

	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$event_name = $_GET["event_name"];
	$descrip = $_GET["descrip"];
	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	$duration_start = $_GET["duration_start"];
	$duration_end = $_GET["duration_end"];
	$visit_high = $_GET["visit_high"];
	$visit_low = $_GET["visit_low"];
	$email = $_GET["email"];

	if($event_name == ""){
		$event_name = "";
	}
	else{
		$event_name = " AND Event_Name= '$event_name'";
	}

	if($descrip == ""){
		$descrip = "";
	}
	else{
		$descrip = " AND Description LIKE '%$descrip%'";
	}

	if($start_date == "YYYY-MM-DD"){
		$start_date = "";
	}
	else{
		$start_date = " AND StartDate >= '$start_date'";
	}

	if($end_date == "YYYY-MM-DD"){
		$end_date = "";
	}
	else{
		$end_date = " AND EndDate <= '$end_date'";
	}

	if($duration_start == 0){
		$duration_start = "";
	}
	else{
		$duration_start = " AND duration >= '$duration_start'";
	}

	if($duration_end == 0){
		$duration_end = "";
	}
	else{
		$duration_end = " AND duration <= '$duration_end'";
	}

	if($visit_high == 0){
		$visit_high = "";
	}
	else{
		$visit_high = " AND total_visits <= '$visit_high'";
	}

	if($visit_low == 0){
		$visit_low = "";
	}
	else{
		$visit_low = " AND total_visits >= '$visit_low'";
	}


	$sql = "SELECT Username FROM atlantabeltline.Email WHERE Email = '$email'";
	$result = mysqli_query($link,$sql);
	$row0 = mysqli_fetch_assoc($result);
	$username = $row0["Username"];

	$sql1 = "SELECT DISTINCT Event_Name, Staff_count, Datediff(EndDate+1,StartDate) AS duration, total_visits, Price,StartDate,Site_Name FROM 
    		(SELECT * FROM 
        	(SELECT * FROM    
			(SELECT B.Event_Name, B.StartDate, B.Site_Name, B.Username as staff_name, B.Description, B.MinStaffReq, B.Capacity, B.Price, B.EndDate FROM
			(SELECT * FROM atlantabeltline.Staff_Assign_To_Event 
			JOIN (SELECT * FROM atlantabeltline.Event) AS A 
			USING(Event_Name, StartDate, Site_Name) ) AS B ) AS C
            JOIN ( SELECT Event_Name, StartDate, Site_Name, Count(*) AS Staff_count FROM atlantabeltline.Staff_Assign_To_Event
			GROUP BY Event_Name, StartDate, Site_Name ) AS D USING(Event_Name, StartDate, Site_Name) ) AS E
            JOIN visitor_visit_event USING(Event_Name,StartDate, Site_Name) ) AS F
            JOIN ( SELECT Event_Name,Site_Name, StartDate, count(*) AS total_visits FROM atlantabeltline.visitor_visit_event GROUP BY  Event_Name,Site_Name, StartDate ) 
            AS E USING(Event_Name,Site_Name, StartDate)
            WHERE Site_Name = (SELECT Site_Name FROM atlantabeltline.Site WHERE Username = '$username') $event_name $descrip $start_date $end_date $duration_start $duration_end $visit_high $visit_low";
	$result1 = mysqli_query($link,$sql1);

	$i = 0;
	// echo $username;
	while($row = mysqli_fetch_assoc($result1)) 
	{
		if($i == 0)
		{
		  	echo "{$row["Event_Name"]},{$row["Staff_count"]},{$row["duration"]},{$row["total_visits"]},{$row["Price"]},{$row["StartDate"]},{$row["Site_Name"]}";
		    $i++;
		}
		else
		{
			echo "|{$row["Event_Name"]},{$row["Staff_count"]},{$row["duration"]},{$row["total_visits"]},{$row["Price"]},{$row["StartDate"]},{$row["Site_Name"]}";
		}
	}

	mysqli_free_result($result);
	mysqli_free_result($result1);
	mysqli_close($link);
?>
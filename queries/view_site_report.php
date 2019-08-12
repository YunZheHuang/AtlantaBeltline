<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	$event_count_low = $_GET["event_count_low"];
	$event_count_high = $_GET["event_count_high"];
	$staff_count_low = $_GET["staff_count_low"];
	$staff_count_high = $_GET["staff_count_high"];
	$visit_low = $_GET["visit_low"];
	$visit_high = $_GET["visit_high"];
	$Revenue_low = $_GET["Revenue_low"];
	$Revenue_high = $_GET["Revenue_high"];
	$email = $_GET["email"];

	$sql = "SELECT Site_Name FROM Site WHERE Username = (SELECT Username FROM Email WHERE Email = '$email')";
	$result = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($result);
	$site_name = $row["Site_Name"];
	
	$sql1 = "SELECT Firstname,Lastname,Username FROM USER WHERE Username IN
			(SELECT Username FROM Event JOIN Staff_Assign_To_Event USING(Site_Name,StartDate,Event_Name) WHERE StartDate > '$end_date' OR EndDate < '$start_date'
			UNION
			SELECT Username FROM (SELECT Username FROM Employee JOIN User USING(Username) Where Status='Approved' and Employee_type='Staff') AS A 
			WHERE A.Username NOT IN (SELECT Username FROM Staff_Assign_To_Event))";
	$result1 = mysqli_query($link,$sql1);
	$i = 0;
    while($row = mysqli_fetch_assoc($result1))
    {
    	if($i == 0)
    	{
    		echo "{$row['Firstname']},{$row['Lastname']},{$row['Username']}";
    		$i++;
    	}
    	else
    	{
    		echo "|{$row['Firstname']},{$row['Lastname']},{$row['Username']}";
    	}
    }

    mysqli_free_result($result);
    mysqli_free_result($result1);
	mysqli_close($link);
?>
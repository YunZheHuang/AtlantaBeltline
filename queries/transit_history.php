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

	$site_name = mysqli_real_escape_string($link,$_GET["site_name"]);
	$trans_type = $_GET["trans_type"];
	$route = $_GET["route"];
	$email = $_GET["email"];
	$end_date = $_GET["end_date"];
	$start_date = $_GET["start_date"];

	if($site_name == "--"){
		$site_name = "";
	}
	else{
		$site_name = " AND B.Site_Name= '$site_name'";
	}

	if($trans_type == "--ALL--"){
		$trans_type = "";
	}
	else{
		$trans_type = " AND B.Type = '$trans_type'";
	}

	if($route == ""){
		$route = "";
	}
	else{
		$route = " AND B.Route = '$route'";
	}

	if($end_date == "YYYY-MM-DD"){
		$end_date = "";
	}
	else{
		$end_date = " AND B.Transit_Date <= '$end_date'";
	}
	if($start_date == "YYYY-MM-DD"){
		$start_date = "";
	}
	else{
		$start_date = " AND B.Transit_Date >= '$start_date'";
	}

	$sql = "SELECT Username FROM atlantabeltline.Email WHERE Email = '$email'";
	$result = mysqli_query($link,$sql);
	$row0 = mysqli_fetch_assoc($result);
	$username = $row0["Username"];

	$sql1 = "SELECT DISTINCT B.Transit_Date, B.Route, B.Type,B.Price FROM 
			(SELECT A.Type, A.Route, A.Price, A.Site_Name, User_Take_Transit.Transit_Date, User_Take_Transit.Username FROM 
			(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,Site_Connect_transit.Site_Name FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route ) AS A
                JOIN User_Take_Transit Using(Type,Route) ) AS B
                WHERE B.Username = '$username' $site_name $trans_type $route $end_date $start_date";
	$result1 = mysqli_query($link,$sql1);

	$i = 0;
	// echo $site_name;
	while($row = mysqli_fetch_assoc($result1)) 
	{
		if($i == 0)
		{
		  	echo "{$row["Transit_Date"]},{$row["Route"]},{$row["Type"]},{$row["Price"]}";
		    $i++;
		}
		else
		{
			echo "|{$row["Transit_Date"]},{$row["Route"]},{$row["Type"]},{$row["Price"]}";
		}
	}

	mysqli_free_result($result);
	mysqli_free_result($result1);
	mysqli_close($link);
?>
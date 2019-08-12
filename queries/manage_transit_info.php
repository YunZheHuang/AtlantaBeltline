<?php
	// $host="localhost";
	// $port="3306";
	// $user="root";
	// $password="Database4400";
	// $dbname="atlantabeltline";
	
	// $link = mysqli_connect($host,$user,$password,$dbname);
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$site_name = $_GET["site_name"];                                  //1
	$trans_type = $_GET["trans_type"];								  //2
	$route = $_GET["route"];										  //4
	$low_price = $_GET["low_price"];								  //8
	$high_price = $_GET["high_price"];
	$low_price = floatval($low_price);
	$high_price = floatval($high_price);

// E.Route, E.Type, E.Price, E.num_of_sites, E.num_of_transit_log
	// echo $high_price;

	if($site_name == "--"){
		$site_name = "";
	}
	else{
		$site_name = "AND F.Site_Name = '$site_name'";
	}

	if($trans_type == "--ALL--"){
		$trans_type = "";
	}
	else{
		$trans_type = " AND F.Type = '$trans_type'";
	}

	if($route == ""){
		$route = "";
	}
	else{
		$route = " AND F.Route = '$route'";
	}

	$sql = "SELECT DISTINCT F.Route, F.Type, F.Price, F.num_of_sites, F.num_of_transit_log FROM
			(SELECT * FROM 
			(SELECT * FROM 
			(SELECT B.Route, B.Type, B.Price, B.num_of_sites, C.num_of_transit_log FROM 
			(SELECT A.*, COUNT(*) AS num_of_sites FROM
			(SELECT Type, Route, Price  FROM Transit JOIN Site_Connect_Transit USING(Type, Route) ) as A
			GROUP BY TYPE, ROUTE ) AS B 
			JOIN (SELECT *, COUNT(*) AS num_of_transit_log FROM (SELECT Type, Route FROM User_Take_Transit) AS A GROUP BY Type,Route) AS C
			USING(Type,Route) ) AS D JOIN User_Take_Transit USING(Type,Route) ) AS E JOIN Site_Connect_transit USING(Type,Route) ) AS F 
			WHERE F.Price >= $low_price AND F.Price <= $high_price $site_name $trans_type $route";
	$result = mysqli_query($link,$sql);


	$i = 0;
	
	while($row = mysqli_fetch_assoc($result)) 
	{
		if($i == 0)
		{
			
		  	echo "{$row["Route"]},{$row["Type"]},{$row["Price"]},{$row["num_of_sites"]},{$row["num_of_transit_log"]}";
		    $i++;
		}
		else
		{
			
			echo "|{$row["Route"]},{$row["Type"]},{$row["Price"]},{$row["num_of_sites"]},{$row["num_of_transit_log"]}";
		}
	}

	mysqli_free_result($result);
	mysqli_close($link);
?>
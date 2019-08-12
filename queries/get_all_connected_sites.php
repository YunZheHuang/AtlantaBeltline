<?php
	include ("./db.php");
	$link = $db;
	// Check connections
	if (mysqli_connect_errno())
	  {
	  echo "----Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	$trans_type = $_GET["trans_type"];
	$trans_route = $_GET["trans_route"];

	$sql = "SELECT Site_Name FROM atlantabeltline.Site;";

	$sql2 = "SELECT Site_Name FROM
	(SELECT * FROM atlantabeltline.Site LEFT JOIN Site_Connect_transit 
	USING(Site_Name)) AS A WHERE Type = '$trans_type' AND Route = '$trans_route';";
		
	$result = mysqli_query($link,$sql);
	$result2 = mysqli_query($link,$sql2);

	$i = 0;
	while($row = mysqli_fetch_assoc($result)){
		if($i == 0){
			echo "{$row['Site_Name']}";
			$i++;
		}
        else{
        	echo "|{$row['Site_Name']}";
        }
	}
	echo "~";

	$j = 0;
	while($row2 = mysqli_fetch_assoc($result2)){
		if($j == 0){
			echo "{$row2['Site_Name']}";
			$j++;
		}
        else{
        	echo "|{$row2['Site_Name']}";
        }
	}
	

	mysqli_free_result($result);
	mysqli_free_result($result2);
	mysqli_close($link);
?>
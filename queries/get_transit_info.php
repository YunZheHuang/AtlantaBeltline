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

	$site_name = $_GET["site_name"];
	$trans_type = $_GET["trans_type"];
	$low_price = $_GET["low_price"];
	$high_price = $_GET["high_price"];

	if($site_name == "--" and $trans_type == "--ALL--" and $low_price == 0 and $high_price == 10){
		$sql = "SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit JOIN atlantabeltline.Site_Connect_transit 
			on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
		    GROUP BY Route,Type;";
		$result = mysqli_query($link,$sql);
		
	}
	elseif($trans_type == "--ALL--" and $low_price == 0 and $high_price == 10){
		$sql = "SELECT C.Type, C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    WHERE C.Site_name = '$site_name'";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == "--" and $low_price == 0 and $high_price == 10){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type';";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == '--' and $trans_type == "--ALL--" and $high_price == 10){
		$sql = "SELECT distinct C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
				WHERE C.Price >= $low_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == '--' and $trans_type == "--ALL--" and $low_price == 0){
		$sql = "SELECT distinct C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
				WHERE C.Price <= $high_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($low_price == 0 and $high_price == 10){
		$sql = "SELECT C.Type, C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    WHERE C.Site_name = '$site_name' AND C.Type = '$trans_type';";
		$result = mysqli_query($link,$sql);
	}
	elseif($trans_type == "--ALL--" and $high_price == 10){
		$sql = "SELECT C.Type, C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    WHERE C.Site_name = '$site_name' AND C.Price >= $low_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($trans_type == "--ALL--" and $low_price == 0){
		$sql = "SELECT C.Type, C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    WHERE C.Site_name = '$site_name' AND C.Price <= $high_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == "--" and $low_price == 0){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price <= $high_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == "--" and $high_price == 10){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price >= $low_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == "--" and $trans_type == "--ALL--"){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Price >= $low_price AND C.Price <= $high_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($site_name == "--" ){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price <= $high_price AND C.Price >= $low_price;";
		$result = mysqli_query($link,$sql);
	}
	elseif($trans_type == "--ALL--"){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Price >= $low_price AND C.Price <= $high_price AND C.Site_name = '$site_name';";
		$result = mysqli_query($link,$sql);
	}
	elseif($low_price == 0){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price <= $high_price AND C.Site_name = '$site_name';";
		$result = mysqli_query($link,$sql);
	}
	elseif($high_price == 10){
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price >= $low_price AND C.Site_name = '$site_name';";
		$result = mysqli_query($link,$sql);
	}
	else{
		$sql = "SELECT DISTINCT C.Type , C.Route, C.Price, C.number_of_sites FROM 
				(SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM 
				(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
			    GROUP BY Route,Type) AS A
			    JOIN 
			    (SELECT * FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
			    USING(Type,Route)
			    ) as B
			    USING(Type,Route)) AS C
			    where C.Type = '$trans_type' AND C.Price >= $low_price AND C.Site_name = '$site_name' AND C.Price <= $high_price;";
		$result = mysqli_query($link,$sql);
	}


	if(mysqli_num_rows($result)==0) 
	{
		exit(1);
	}

	$i = 0;

	while($row = mysqli_fetch_assoc($result)) 
	{
		if($i == 0)
		{
		  	echo "{$row["Route"]},{$row["Type"]},{$row["Price"]},{$row["number_of_sites"]}";
		    $i++;
		}
		else
		{
			echo "|{$row["Route"]},{$row["Type"]},{$row["Price"]},{$row["number_of_sites"]}";
		}
	}

	mysqli_free_result($result);
?>
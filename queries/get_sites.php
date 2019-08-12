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

	$sql = "SELECT Site_Name FROM atlantabeltline.Site";
	$result = mysqli_query($link,$sql);
   
   if(mysqli_num_rows($result)==0) 
   {
      die('Could not get data: ' . mysqli_error());
   }
   
   $i = 0;
   while($row = mysqli_fetch_assoc($result)) 
   {
   	 	if($i == 0)
   	 	{
	      	echo "{$row['Site_Name']}";
	        $i++;
	    }
    	else
    	{
    		echo "|{$row['Site_Name']}";
    	}

   }

	mysqli_free_result($result);
?>
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
	$email = mysqli_real_escape_string($link,$_GET['email']);
	$pass = mysqli_real_escape_string($link,$_GET['pass']);

	$sql = "SELECT Password, Email FROM 
			(SELECT DISTINCT User.*, Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) as T WHERE Email = '$email' AND Password = md5('$pass');";
	$result = mysqli_query($link,$sql);

	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		//echo $row;
    } 
    else {
        echo "0 results";
    }

	$sql2 = "SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'no' AND is_visitor = 'no' AND Email = '$email'";
	$result2 = mysqli_query($link,$sql2);

	if (mysqli_num_rows($result2) != 0)
	{
		echo "user";
	}
	// else{
	// 	echo "2. DB Error, could not query the database\n";
	// }

	$sql3 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'no' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Admin'";
	$result3 = mysqli_query($link,$sql3);

	if (mysqli_num_rows($result3)!=0)
	{
		echo "admin_only";
	}
	// else{
	// 	echo "3. DB Error, could not query the database\n";
	// }

	$sql4 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'yes' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Admin'";
	$result4 = mysqli_query($link,$sql4);

	if (mysqli_num_rows($result4)!=0)
	{
		echo "admin_visitor";
	}
	// else{
	// 	echo "4. DB Error, could not query the database\n";
	// }

	$sql5 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'no' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Manager'";
	$result5 = mysqli_query($link,$sql5);

	if (mysqli_num_rows($result5) != 0)
	{
		echo "manager_only";
	}
	// else{
	// 	echo "5. DB Error, could not query the database\n";
	// }

	$sql6 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'yes' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Manager'";
	$result6 = mysqli_query($link,$sql6);

	if (mysqli_num_rows($result6)!=0)
	{
		echo "manager_visitor";
	}
	// else{
	// 	echo "6. DB Error, could not query the database\n";
	// }

	$sql7 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'no' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Staff'";
	$result7 = mysqli_query($link,$sql7);

	if (mysqli_num_rows($result7)!=0)
	{
		echo "staff_only";
	}
	// else{
	// 	echo "7. DB Error, could not query the database\n";
	// }

	$sql8 = "SELECT * FROM 
			(SELECT DISTINCT * FROM (SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'yes' AND is_visitor = 'yes' AND Email = '$email') AS R JOIN atlantabeltline.Employee USING(Username) ) AS K
			WHERE K.Employee_type = 'Staff'";
	$result8 = mysqli_query($link,$sql8);

	if (mysqli_num_rows($result8)!=0)
	{
		echo "staff_visitor";
	}
	// else{
	// 	echo "8. DB Error, could not query the database\n";
	// }

	$sql9 = "SELECT * FROM 
			(SELECT DISTINCT User.*,  Email.Email FROM atlantabeltline.Email JOIN atlantabeltline.User ON atlantabeltline.Email.Username = atlantabeltline.User.Username) 
			AS T WHERE is_employee = 'no' AND is_visitor = 'yes' AND Email = '$email' ";
	$result9 = mysqli_query($link,$sql9);

	if (mysqli_num_rows($result9)!=0)
	{
		echo "visitor_only";
	}
	// else{
	// 	echo "9. DB Error, could not query the database\n";
	// }

	mysqli_free_result($result);
	mysqli_free_result($result2);
	mysqli_free_result($result3);
	mysqli_free_result($result4);
	mysqli_free_result($result5);
	mysqli_free_result($result6);
	mysqli_free_result($result7);
	mysqli_free_result($result8);
	mysqli_free_result($result9);
	mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Screen28: Manage Staff</title>
  	<meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin_Employee Manage Profile</title>
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="../assets/js/screen28.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen19.css">
    <link rel="icon" href="data:;base64,=">
</head>
<body>
<fieldset>
	<legend>MANAGE SITE</legend>
	<form>
		<div id="div1"  style="postion: relative;  width: 200px">
    <label id="siteLable" for ='site'>Site Name</label>
    <select id='siteDroptDown' name='selectedSite'>
      <option value="allSite" id="all">--All--</option>
        <?php
      include('../queries/db.php');
      if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } 
      $sql='SELECT Site_Name from Site;';
      if($result = $db->query($sql)){
          while($row=$result->fetch_assoc()){
            $sitename=$row['Site_Name'];
            echo "<option id='$sitename' value= '$sitename' >$sitename</option>";
          }
          $result->free();
        }
     ?>  
    </select>
    <label id="managerLabel" for ='managerName'>Manager</label>
    <select id='managerDroptDown' name='selectedManager' >
      <option value="allManager">--All--</option>
      <?php
      $sql='SELECT  U.Firstname, U.Lastname,U.Username
            FROM Site as S
            JOIN User as U 
            ON U.Username=S.Username;';
      if($result = $db->query($sql)){
          while($row=$result->fetch_assoc()){
            $name=$row['Firstname']. "   " .$row['Lastname'] ;
            $username=$row['Username'];
            echo "<option id='$username' value= '$username' >$name</option>";
          }
          $result->free();
        }
     ?>
    </select>
    
  </div >
	</form>
</fieldset>
</body>
</html>
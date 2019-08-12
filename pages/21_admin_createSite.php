<?php  
    
    include('../queries/db.php');
    if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();}
    $errors=array();
    $msg="";
    if(isset($_GET['create'])){
        $sitename=mysqli_real_escape_string($db,$_GET['Sitename']);
        $sql="Select Site_Name from Site Where Site_Name='$sitename';";
        
        $result=mysqli_query($db,$sql);
        if(mysqli_num_rows($result) > 0 ){
            $msg="this site name already exits in the database!!!";
        }
        else{
            $zipcode=mysqli_real_escape_string($db,$_GET['Zipcode']);
            $username=mysqli_real_escape_string($db,$_GET['ManagerUsername']);
            $check_open=mysqli_real_escape_string($db,$_GET['openEveryday']);
            $address=mysqli_real_escape_string($db,$_GET['Address']);
            $sql="INSERT INTO Site(Site_Name,Address,Zipcode,OpenEveryday, Username)
                 VALUES( '$sitename','$address','$zipcode','$check_open', '$username')";
            if ($db->query($sql) === TRUE) {
                $msg= "The site ".$sitename ." was created successfully!!!";
            } else {
                $msg= "Error: " . $sql . "<br>" . $db->error;
            }
        }
    }
    $sitename=$_GET['SiteName'];
    $zipcode=$_GET['Zipcode'];
    $address=$_GET['Address'];
    if (strlen($msg) >0){
    echo '<script language="javascript">';
    echo "alert('$msg')"; 
    echo '</script>';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>screen21</title>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin_editSite</title>
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen21.css">
    <link rel="icon" href="data:;base64,=">
</head>
<body>
<fieldset>
    <legend>CREATE SITE</legend>
    <form method="GET" action="">
    <table id='table1' align="center">
        <tr>
            <td height="23" style="font-weight: bold"><div align="right"><label for="name">SiteName</label></div></td>
            <td ><input name="Sitename" type="text" class="input" required="" /></td>
            <td height="23" style="font-weight: bold"><div align="right"><label for="zipcode">Zipcode</label></div></td>
            <td><input placeholder="5 digits" name="Zipcode" type="text" inputmode="numeric" pattern="[0-9]{5}" class='input' required /></td>
        </tr>
    <table id='addressTable' align="center">
        <tr>
            <td  height="23" style="font-weight: bold"><div align="right"><label for="address">Address</label></div></td>
            <td ><input name="Address" type="text" class="input" size="50"   /></td>
        </tr>
    </table>
     <div id="div2" style="height: auto;margin-left:11%">
      <label >Manager </label> 
      <select name="ManagerUsername">
    <?php
            
            $first_username=$_GET['UserName'];
            $sql="SELECT Firstname,Lastname,Username from User 
                    where Username not in (
                    SELECT  Username
                    FROM Site ) and Username in(SELECT Username from Employee where Employee_type='Manager' and Status='Approved')
                     ;";
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
    </div>
    <div id='div1' style="height: auto;margin-left:11%;margin-top: 1em;" >
      <label  id='label2' for='ifOpen'>Open EveryDay</label> 
        <label class ='label1'><input type='radio'  name='openEveryday' value='Yes' required>Yes</label>
        <label class ='label1'><input type='radio'  name='openEveryday' value='No' >No</label>
        
     <table id='buttonTable' align="center">
        <tr  align='center'>
          <td><input type="submit" name="create" value="Create" ></td>
          <td><input type='submit' onclick="window.location.href='19_admin_manageSite.php'" value='Back' ></td></td> 
        </tr>
  </table>     
  </div>
    </div>
    </table>
</fieldset>
</body>
</html>

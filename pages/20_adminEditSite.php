<?php  
    session_start();
    //var_dump($_SESSION);
    include('../queries/db.php');
    if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();}

    $username= $_SESSION['page19'][0];
    $sitename=$_SESSION['page19'][1];
    $openEveryday=$_SESSION['page19'][2];
    $zipcode=$_SESSION['page19'][3];
    $address=$_SESSION['page19'][4];
    $firstname=$_SESSION['page19'][5];
    $lastname=$_SESSION['page19'][6];
    $full_name=$firstname." ".$lastname;
    if(isset($_GET['update'])) {
        $sitename=mysqli_real_escape_string($db,$_GET['Sitename']);
        $zipcode=mysqli_real_escape_string($db,$_GET['Zipcode']);
        $username=mysqli_real_escape_string($db,$_GET['ManagerUsername']);
        $check_open=mysqli_real_escape_string($db,$_GET['openEveryday']);
        $address=mysqli_real_escape_string($db,$_GET['Address']);
        $sql="UPDATE Site 
              SET Site_Name='$sitename', Address='$address',Zipcode='$zipcode', OpenEveryday='$check_open'
              Where Username='$username';"; //this is update cascade
        
        if ($db->query($sql) === TRUE) {
                $msg= "The site  was editted successfully!!!";
            } else {
                $msg= "Error: " . $sql . "<br>" . $db->error;
            }
}
if (strlen($msg) >0){
    echo '<script language="javascript">';
    echo "alert('$msg')"; 
    echo '</script>';
    }
unset($_SESSION['page19']);   
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
    <link rel="stylesheet" type="text/css" href="../assets/css/screen20.css">
    <link rel="icon" href="data:;base64,=">
    <script>
        function goBack()
          {window.history.back()}
</script>
</head>
<body>
<fieldset>
    <legend>EDIT SITE</legend>
    <form method="GET" action="">
    <table id='table1' align="center">
        <tr>
            <td height="23" style="font-weight: bold"><div align="right"><label for="name">SiteName</label></div></td>
            <td ><input name="Sitename" type="text" class="input" value='<?php echo $sitename;?>' required /></td>
            <td height="23" style="font-weight: bold"><div align="right"><label for="zipcode">Zipcode</label></div></td>
            <td><input placeholder="5 digits" name="Zipcode" type="text" inputmode="numeric" pattern="[0-9]{5}" class='input' value='<?php echo $zipcode;?>' required /></td>
        </tr>
    <table id='addressTable' align="center">
        <tr>
            <td  height="23" style="font-weight: bold"><div align="right"><label for="address">Address</label></div></td>
            <td ><input name="Address" type="text" class="input" size="53" value='<?php echo $address;?>'  /></td>
        </tr>
    </table>
     <div id="div2" style="height: auto;margin-left:11%">
      <label >Manager </label> 
      <select name="ManagerUsername">
    <?php
        echo "<option id='$username' value= '$username' >$full_name</option>";
        $sql="SELECT  Firstname, Lastname, Username
            FROM User
            where Username not in (
            Select Username from Site) and Username in (SELECT Username from Employee where Employee_type='Manager' and Status='Approved');";
        echo $sql;
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
        <label class ='label1'>Yes</label><input type='radio'  name='openEveryday' value='Yes' checked > 
        <label class ='label1'>No</label><input type='radio'  name='openEveryday' value='No'>  
        
     <table id='buttonTable' align="center">
        <tr  align='center'>
          <td><input type="submit" name="update" value="Update" ></td>
          <td><input type='button' onclick="goBack();" value='back' ></td></td> 
        </tr>
  </table>
      
        
  </div>
    </div>
        

    </table>
</fieldset>

</body>
</html>
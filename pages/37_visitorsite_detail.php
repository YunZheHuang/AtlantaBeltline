<?php  
    session_start();
    //var_dump($_SESSION);
    include('../queries/db.php');
    if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();}
    $msg="";
    $address="";
    //var_dump($_SESSION['page35']);
    $sitename=$_SESSION['page35'][0];
    $openEveryday=$_SESSION['page35'][1];
    $sql="SELECT * from Site where Site_Name='$sitename' and OpenEveryDay='$openEveryday';"; //this is update cascade
    //echo $sql;
        if($result = $db->query($sql)){
               while($row=$result->fetch_assoc()){
                $address=$row['Address'];
            }
      }
    if(isset($_GET['log_visit'])) {
      $log_date=mysqli_real_escape_string($db,$_GET['visit_date']);
      $username="visitor1"; //Di you should change in here
      $sitename=$_SESSION['page35'][0];
      $check_log="SELECT * from Visitor_Visit_Site where Username='$username' and Site_Name='$sitename' and visit_date='$log_date' ;";
      //echo $check_log;
      $result=mysqli_query($db,$check_log);
        if(mysqli_num_rows($result) > 0 ){
          $msg="you already logged";
        }else{
          $sql="INSERT INTO Visitor_Visit_Site VALUES('$log_date','$sitename','$username');";
          //echo $sql;
          if ($db->query($sql) === TRUE) {
                $msg= "You logged visit successfully. You cannot log anymore site today!!!";
            } else {
                $msg= "Error: " . $sql . "<br>" . $db->error;
            }
        } 
        //unset($_SESSION['page35']);          
}//if user hit log_visit button
if (strlen($msg) >0){
    echo '<script language="javascript">';
    echo "alert('$msg')"; 
    echo '</script>';
    }

?>           
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen37.css">
    <link rel="icon" href="data:;base64,=">
<script>
        function goBack()
          {window.history.back()}
</script>

</head>
  <body>
    <form method="GET" action="">
      <fieldset>
        <legend>SITE DETAIL</legend>
        <div>
          <table align="center">
            <tr>
              <td>Site</td>
              <td><input type="text" name="site_name" class="input" value="<?php echo $sitename;?>" disabled></td>
              <td>Open Everyday</td>
              <td><input type="text" name="openEveryday" class="input" value='<?php echo $openEveryday;?>' disabled></td>
            </tr>
            <tr>
              <td>Visit Date</td>
              <!--<td><input type="date" name="visit_date" class="input"></td>-->
              <td><input type="date" name="visit_date" value="<?php echo date("Y-m-d"); ?>"></td>
              
            </tr>       
          </table>
        </div>
        <div style="text-align: center;">
          <label>Address<input type="text" name="address" class="input" size ='50' value='<?php echo $address;?>' disabled></label> 
        </div>
        <div style="text-align: center;" >
          <input type="submit" name="log_visit" value="Log Visit">
          <input type="button" onclick="history.back(-1)" name="back" value="BACK">
        </div>


      </fieldset>
    </form>
  </body>
</html>

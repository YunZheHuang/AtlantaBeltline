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

    if(isset($_GET['log_transit']) && !isset($_GET['chk'])){
      $msg="you have to select one row to log transit";
    }
    if(isset($_GET['log_transit']) && isset($_GET['chk'])) {
      $log_date=mysqli_real_escape_string($db,$_GET['transit_date']);
      $username="visitor1"; //Di you should change in here      
      $route=explode(";", $_GET['chk'])[0];
      $type=explode(";", $_GET['chk'])[1];
      $check_log="SELECT * from User_Take_Transit where Username='$username' and Transit_date='$log_date' ;";
      //echo $check_log;
      $result=mysqli_query($db,$check_log);
        if(mysqli_num_rows($result) > 0 ){
          $msg="you already logged";
        }else{
          $sql="INSERT INTO User_Take_Transit VALUES('$log_date','$username','$type','$route');";
          //echo $sql;
          if ($db->query($sql) === TRUE) {
                $msg= "You logged visit successfully. You cannot log anymore site today!!!";
            } else {
                $msg= "Error: " . $sql . "<br>" . $db->error;
            }
        }        
   }//if user hit log_transit button
  
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
    <link rel="stylesheet" type="text/css" href="../assets/css/screen36.css">
    <link rel="icon" href="data:;base64,=">
<script>
        function goBack()
          {window.history.back()}
</script>

</head>
  <body>
    <form method="GET" action="">
      <fieldset>
        <legend>TRANSIT DETAIL</legend>
        <div style="text-align: center;">      
            <label>Site Name</label>
            <input id="inputSITE" type="text" name="site_name" size="30" class="input" value="<?php echo $sitename;?>" disabled>
            <label>Transport Type</label>
            <select name="transport_type">
              <?php
                  include("../queries/db.php");
                  if (mysqli_connect_errno()) {
                  printf("Connect failed: %s\n", mysqli_connect_error());
                  exit();} 
                  $sql="SELECT * from Transit;";
                  echo $sql;
                  if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                        $type=$row['Type'];                       
                        echo "<option  value= '$type' >$type</option>";
                      }
                      $result->free();
                    }
                ?>           
            </select> 
        </div>

        <div tyle="text-align: center;">
            <label>Sort By</label>
            <select name="sort">
            <option value="Route">Route</option>
            <option value="Type">Type</option>
            <option value="Price">Price</option>
            <option value="numconnect"># Connected Sites</option>            
            </select>
            <input type="submit" name="View" value="View"> 
        </div>
        <div style="text-align: center;">
          <table align="center">
            <thead>
              <tr>
                <th></th>
                <th> Route</th>
                <th> Transport Type</th>
                <th> Price</th>
                <th> #Connected Sites</th>
              </tr>
            </thead>
            <tbody>
               <?php
              function buildTable($route, $type,$price,$numconnect){
              echo "<tr >   
                        <td><input type='radio'  name='chk' value='$route;$type;$price;$numconnect' ></td> 
                        <td class='col-siteName' value='$route'>$route</td>
                        <td class='col-managerName' value='$type'>$type</td>
                        <td class='col-openEverDay' value='$price'>$price</td>
                        <td class='col-openEverDay' value='$numconnect'>$numconnect</td>
                      </tr>";
            }//end clause for build table
              if(isset($_GET['View'])){
              if($_GET['sort']==''){
                $msg='you have to select Sort by option to view!!!';
              }else{
                $sort=$_GET['sort'];
                $transport_type=$_GET['transport_type'];
                $sql="SELECT t.Route, t.Type, t.Price, j.numconnect
                      from
                      Transit as t
                      join
                      Site_Connect_transit as s on s.type=t.type and s.Route=t.Route
                      left join
                      (select Site_Name, count(*) as 'numconnect'
                      from Site_Connect_transit
                      group by Site_Name) as j on j.Site_Name=s.Site_Name
                      where s.Site_Name='$sitename' and t.type='$transport_type'
                      group by s.type, s.Route
                      order by $sort ;";
                if($result = $db->query($sql)){ 
                  while($row=$result->fetch_assoc()){
                    buildTable($row['Route'],$row['Type'],$row['Price'],$row['numconnect']);
                  }
                }

              }

            }
            if (strlen($msg) >0){
            echo '<script language="javascript">';
            echo "alert('$msg')"; 
            echo '</script>';
            }
            //unset($_SESSION['page35']); 

               ?>
            </tbody>
            
          </table>
          
        </div>
        

        <div style="text-align: center;">
          <label>Transit Date</label>
          <input type="date" name="transit_date" value="<?php echo date("Y-m-d"); ?>">
          
        </div>

        <div style="text-align: center;" >
          <input type="submit" name="log_transit" value="Log Transit">
          <input type="button" onclick="history.back(-1)" name="back" value="BACK">
        </div>


      </fieldset>
    </form>
  </body>
</html>

<?php  
    session_start();
    include('../queries/db.php');
    if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();}
    //var_dump($_SESSION);
    
    
      $event_name=$_SESSION['page31'][0];
      $site_name=$_SESSION['page31'][1];
      $start_date=$_SESSION['page31'][2];
      $end_date=$_SESSION['page31'][3];
      $staff_count=$_SESSION['page31'][4];
      $duration=$_SESSION['page31'][5];
      $price=$_SESSION['page31'][6];
      $capacity=$_SESSION['page31'][7];
      $description=$_SESSION['page31'][8];
      $staff_assigned=$_SESSION['page31'][9];
      $staff_names="";
      if (count($staff_assigned)==1){$staff_names=$staff_assigned[0];}
      else{
        foreach ($staff_assigned as $s) {
          $staff_names=$staff_names . $s ." ; "   ;   }
      }
      
      
    
        unset($_SESSION['page31']);
?>           
<!DOCTYPE html>
<html>
<head>
    <title>Screen31: ViewSchedule</title>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">  </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen31.css">
    <link rel="icon" href="data:;base64,=">
</head>
<body>
<form method="GET" action="">
<fieldset>

    <legend>EVENT DETAIL</legend>

    <table  align="center" cellspacing="10" >
        <tr>
            <td height="23" style="font-weight: bold"><div align="right"><label >Event</label></div></td>
            <td > <?php echo $event_name;?> </td>
            <td height="23" style="font-weight: bold"><div align="right"><label >Site Name</label></div></td>
            <td ><?php echo $site_name;?></td> 
        </tr>

        <tr>
            <td style="font-weight: bold"><div align="right"><label >Start Date</label></div></td>
            <td><?php echo $start_date;?></td>
            <td style="font-weight: bold"><div align="right"><label >End Date</label></div></td>
            <td><?php echo $end_date;?></td>
            
        </tr>
        <tr>
            <td  style="font-weight: bold"><div align="right"><label >Duration Days</label></div></td>
            <td><?php echo $duration;?></td> 
            
            <td  style="font-weight: bold"><div align="right"><label >Price</label></div></td>
            <td><?php echo $price;?></td>           
        </tr>
        <tr>
            <td  style="font-weight: bold"><div align="right"><label >Capacity</label></div></td>
            <td><?php echo $capacity;?></td>
            <td  style="font-weight: bold"><div align="right"><label >Staff(s) Assigned</label></div></td>

            <td><?php echo $staff_names?></td>       
        </tr>
        
    </table>
    <div id="div1" align="center">
        <label >Description</label>
        <p><?php echo $description;?></p>
    </div>
    <table id='buttonTable' align="center">
        <tr  align='center'>
          <td><input type='button' onClick="location.href='./31_staff_view_schedule.php';" value='back' ></td></td> 
        </tr>
  </table>
    
</fieldset>
</form>
</body>
</html>
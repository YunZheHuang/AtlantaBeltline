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
    <legend>VIEW SCHEDULE</legend>
    <table id="dateTable" align="center" cellspacing="10" >
        <tr>
            <td  style="font-weight: bold"><div align="right"><label for="start date">Start Date</label></div></td>
            <td><input name="start_date" type="date" class="input"  style="width:193px" /></td>
            <td></td>
            <td  style="font-weight: bold"><div align="right"><label for="end date">End Date</label></div></td>
            <td><input name="end_date" type="date" class="input"  style="width:193px"  /></td>   
        </tr>
    </table>
    <div>
        <label id="sortLabel" >Sort By</label>
        <select name='sort' >
            <option></option>
            <option value='Event_Name'>Event Name</option>
            <option value='Site_Name'>Site Name</option>
            <option value='StartDate'>Start Date</option>
            <option value='EndDate'>End Date</option>
            <option value='staff_count'>Staff Count</option>
            
        </select>
        <label><input type="radio" name="order" value="asc" > Ascending</label>
        <label><input type="radio" name="order" value="desc"> Descending</label>
    </div>

    <table id='buttonTable' align="center">
        <tr  align='center'>
          <td> <input type='submit' name='filter' value='Filter'></td></td>
          <td> <input type='submit' name='view' value='View Event'></td></td>
          <td><input type='button' onclick='history.go(-1)' value='back' ></td></td>
        </tr>
      </table>
<div style="position: relative;  height: 200px; overflow-y: auto" id="div2" >
      <table id='resultTable' align="center" class="sortable" cellpadding="5" >
        <thead >
           <tr>
            <th></th>
            <th>Event Name</th>
            <th>Site Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Staff Count</th>
           </tr>
        </thead>
        <tbody>
                
          <?php 
          session_start();
          include('../queries/db.php');
          if (mysqli_connect_errno()) {
              printf("Connect failed: %s\n", mysqli_connect_error());
              exit();
          }
          function buildTable($event_name,$site_name,$start_date,$end_date,$staff_count){
            echo "<tr >   
                      <td><input type='radio'  name='chk' value='$event_name;$site_name;$start_date;$end_date;$staff_count' ></td> 
                      <td class='col-evenName' value='$event_name'>$event_name</td>
                      <td class='col-siteName' value='$site_name'>$site_name</td>
                      <td class='col-sdate' value='$start_date'>$start_date</td>
                      <td class='col-sdate' value='$end_date'>$end_date</td>
                      <td class='col-sdate' value='$staff_count'>$staff_count</td>
                  </tr>";
          }//end clause for build table

          if(isset($_GET["filter"]))  {

              $msg = "";
              $errors=array();
              $sort=mysqli_real_escape_string($db,$_GET['sort']); 
              if($sort==''){
              $msg="you have to select the Sort by option";
             }
              $end_date=mysqli_real_escape_string($db,$_GET['end_date']);
              $start_date=mysqli_real_escape_string($db,$_GET['start_date']);
              //$keyword=mysqli_real_escape_string($db,$_GET['keyword']); 
              
              $order=mysqli_real_escape_string($db,$_GET['order']); 
              mysqli_query($db,"drop view if exists temp;") or die(mysqli_error($db));

              $sql1="create view temp as 
                    select C.* from
                    (select E.*,S.Username,User.Firstname,User.Lastname from Event as E
                    join Staff_Assign_To_Event as S
                    join User on User.Username=S.Username
                    on E.Site_Name = S.Site_Name and E.StartDate=S.StartDate and E.Event_Name=S.Event_Name)C ;";
              mysqli_query($db,$sql1) or die();
              if($start_date =='' && $end_date==''){
              $sql="select Site_Name, Event_Name,StartDate,EndDate,count(*) as staff_count from temp 
                      group by Site_Name,Event_Name,StartDate,EndDate
                      order by $sort $order;";

              if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                          buildTable($row['Event_Name'],$row['Site_Name'],$row['StartDate'],$row['EndDate'],$row['staff_count']);
                      }
                      $result->free();
                 }     
             }//if start date and end date is not filled
             if($start_date !='' && $end_date==''){
                $sql="select Site_Name, Event_Name,StartDate,EndDate,count(*) as staff_count from temp 
                      where StartDate >= '$start_date'
                      group by Site_Name,Event_Name,StartDate,EndDate
                      order by $sort $order;";

                  if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                          buildTable($row['Event_Name'],$row['Site_Name'],$row['StartDate'],$row['EndDate'],$row['staff_count']);
                      }
                      $result->free();
                 } 
          }//if start date is filled

              if($start_date =='' && $end_date!=''){               
                $sql="select Site_Name, Event_Name,StartDate,EndDate,count(*) as staff_count from temp 
                      where EndDate <= '$end_date'
                      group by Site_Name,Event_Name,StartDate,EndDate
                      order by $sort $order;";

                  if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                          buildTable($row['Event_Name'],$row['Site_Name'],$row['StartDate'],$row['EndDate'],$row['staff_count']);
                      }
                      $result->free();
                 } 
          }//if end date is filled

          if($start_date !='' && $end_date!=''){
                $sql="select Site_Name, Event_Name,StartDate,EndDate,count(*) as staff_count from temp 
                      where EndDate between $start_date and '$end_date' 
                      and StartDate between '$start_date' and '$end_date'
                      group by Site_Name,Event_Name,StartDate,EndDate
                      order by $sort $order;";
                  if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                          buildTable($row['Event_Name'],$row['Site_Name'],$row['StartDate'],$row['EndDate'],$row['staff_count']);
                      }
                      $result->free();
                 } 
          }//if end date ,start dateis filled
      } 
      //echo count($_GET['chk']);
      if(isset($_GET["view"]) && count($_GET['chk'])>0){
        $event_name=explode(";", $_GET['chk'])[0];
        $site_name=explode(";", $_GET['chk'])[1];
        $start_date=explode(";", $_GET['chk'])[2];
        $end_date=explode(";", $_GET['chk'])[3];
        $staff_count=explode(";", $_GET['chk'])[4];
        $_SESSION['page31']=array();
        $_SESSION['page31'][]=$event_name; $_SESSION['page31'][]=$site_name; $_SESSION['page31'][]=$start_date; $_SESSION['page31'][]=$end_date; $_SESSION['page31'][]=$staff_count;
        
        $sql="select DATEDIFF('$end_date','$start_date') as diff;";
        $result=mysqli_query($db,$sql);
        if(!$result){ 
         $msg="cannot execute database: ".mysqli_error() ;
        }
        $diff=mysqli_fetch_array($result)['diff']  ;
        $_SESSION['page31'][]=$diff;//6th  
        $sql="select Description,Capacity,Price,Username,Firstname,Lastname from temp 
              where Site_Name='$site_name' and Event_Name='$event_name' and StartDate='$start_date' and EndDate='$end_date';";
          $fullname_array=array();
         if($result = $db->query($sql)){
              while($row=$result->fetch_assoc()){
                  $username_array[]=$row['Username'];
                  $describ=$row['Description'];
                  $price=$row['Price'];
                  $capacity=$row['Capacity']; 
                  $first_name=$row['Firstname'];
                  $last_name=$row['Lastname']  ;
                  $fullname_array[]=$first_name.' '.$last_name;               
                  }
                      $result->free();
              } 

        $_SESSION['page31'][]=$price;$_SESSION['page31'][]=$capacity;$_SESSION['page31'][]=$describ;$_SESSION['page31'][]=$fullname_array;
        header("location: 32_event_detail.php?");
    } 
    if(isset($_GET["view"]) && count($_GET['chk'])==0){
      $msg .=" you need to select one row to view!!!";
    } 
  if (strlen($msg) >0){
  echo '<script language="javascript">';
  echo "alert('$msg')"; 
  echo '</script>';
  }                  
  ?>                             
    </tbody>
  </table>
</div>
</fieldset>
</form>
</body>
</html>
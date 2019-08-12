
<!DOCTYPE html>
<html>
<head>
    <title>Screen29: SITE REPORT</title>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen29.css">
    <link rel="icon" href="data:;base64,=">
    <script>
        function goBack()
          {window.history.back()}
</script>
</head>
<body>
<fieldset>
    <legend>SITE REPORT</legend>
    <form method="GET" action="">
        
        <div class="div1" style="text-align: center;">
            <label>Start Date</label>
            <input name="start_date" type="date" class="input"   />
            <label>End Date</label>
            <input name="end_date" type="date" class="input"   />           
        </div>
        <div class="div1" style="text-align: center;">
            <label>Event Count Range </label>
            <input type="number" name="event_count_low" value="0" id="event_count_low" >
          -- <input type="number" name="event_count_high" value="10" id="event_count_high" >
            <label>Staff Count Range</label>
             <input type="number" name="staff_count_low" value="0" id="staff_count_low" >
          -- <input type="number" name="staff_count_high" value="10" id="staff_count_high" >            
        </div>

        <div class="div2" style="text-align: center;">
            <label>Total Visits Range</label>
            <input type="number" name="visit_low" value="0"  >
          -- <input type="number" name="visit_high" value="100"  >
            <label>Total Revenue Range</label>
             <input type="number" name="revenue_low" value="0"  >
          -- <input type="number" name="revenue_high" value="500"  >            
        </div>

        <div style="text-align: center;">
            <label id="sortLabel" >Sort By</label>
            <select name='sort'  >
                <option value='Visit_date'>Date</option>
                <option value='event_count'>Events Count</option> 
                <option value="staff_count">Staff Count</option> 
                <option value='total_visit'>Total Visits</option>  
                <option value='total_revenue'>Total Revenue(s)</option>       
            </select>
            <label><input type="radio" name="order" value="asc" checked> Ascending</label>
            <label><input type="radio" name="order" value="desc"> Descending</label>
            <input type='submit' name='filter' value='Filter'>
        </div>
        
        <div>
            <table id='buttonTable' align="center">
            <tr  align='center'>
              <td> <input type='submit' name='daily_detail' value="Daily Detail"  ></td></td>
              <td><input type='button' onclick="goBack();" class="back-button" value='Back' ></td></td>
            </tr>
      </table>
        </div>
        <div style="postion: relative;  height: 150px; overflow-y: auto" id="div2" >
            <table align="center">
            <thead>
                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Event Count</th>
                    <th>Staff Count</th>
                    <th>Total Visits</th>
                    <th>Total Revenue(s)</th>
                </tr>
            </thead>
            <tbody>                
    <?php
    session_start();
       include('db.php') ;        
    function buildTable($date, $event_count,$staff_count,$total_visit,$total_revenue){
          echo "<tr >   
                    <td><input type='radio'  name='chk' value='$date;$event_count;$staff_count;$total_visit;$total_revenue' ></td> 
                    <td class='col-date' value='$date'>$date</td>
                    <td class='col-event' value='$event_count'>$event_count</td>
                    <td class='col-staff' value='$staff_count'>$staff_count</td>
                    <td class='col-visit' value='$total_visit'>$total_visit</td>
                    <td class='col-revenue' value='$total_revenue'>$total_revenue</td>
                  </tr>";
        }//end clause for build table
    $errors=array();
    $msg="";
    /*$prompt_msg = "Please type your username.";
    $username = promptUsername($prompt_msg);*/

   if(isset($_GET["filter"])){
    $start_date=mysqli_real_escape_string($db,$_GET['start_date']);
    $end_date=mysqli_real_escape_string($db,$_GET['end_date']);
    $sort=mysqli_real_escape_string($db,$_GET['sort']);
    $event_count_low=mysqli_real_escape_string($db,$_GET['event_count_low']);
    $event_count_high=mysqli_real_escape_string($db,$_GET['event_count_high']);
    $staff_count_low=mysqli_real_escape_string($db,$_GET['staff_count_low']);
    $staff_count_high=mysqli_real_escape_string($db,$_GET['staff_count_high']);
    $visit_low=mysqli_real_escape_string($db,$_GET['visit_low']);
    $visit_high=mysqli_real_escape_string($db,$_GET['visit_high']);
    $revenue_low=mysqli_real_escape_string($db,$_GET['revenue_low']);
    $revenue_high=mysqli_real_escape_string($db,$_GET['revenue_high']);


    if(isset($_GET['order'])){
        $order=mysqli_real_escape_string($db,$_GET['order']);
    }else{$order='';}
    if($start_date==''|| $end_date==''){
        array_push($errors, "missing dates");
        $msg ="you have to enter the start and end date";
    }
    
    if($event_count_low==''||$event_count_high==''||$staff_count_high==''||$staff_count_low==''||$visit_low==''|| $visit_high==''||$revenue_high==''|| $revenue_low==''){
        array_push($errors, "missing range option");
        $msg ="you have to specify the range";
    }
    if(count($errors)==0){
        //program
        $site_name="Inman Park";//Di modify here!!!
        $sql="SELECT * from (SELECT b.Visit_date,coalesce(d.event_count,0) as 'event_count',coalesce(c.staff_count,0) as 'staff_count',coalesce(a.event_visit,0)+coalesce(b.site_visit,0) as 'total_visit' , coalesce(a.total_revenue,0) as 'total_revenue' 
            from (select Visit_date,count(*) as 'event_visit' ,sum(Price) as 'total_revenue' from  visitor_visit_event JOIN Event 
            using(Event_Name,StartDate,Site_Name)
            where Site_Name='$site_name' 
            group by Visit_date) as a 
            JOIN (SELECT visit_date,count(*) as 'site_visit' from Visitor_Visit_Site
            join Event using(Site_Name)
            where Site_Name='$site_name' 
            group by visit_date) as b 
            on a.Visit_date=b.visit_date
            left join(Select E.StartDate, count(S.Username) as 'staff_count' 
            from Event as E
            join Staff_Assign_To_Event as S
            USING (Event_Name, StartDate,Site_Name)
            where Site_Name='$site_name'
            and StartDate between  '$start_date' and '$end_date' and EndDate between  '$start_date' and '$end_date'
            group by E.StartDate) as c
            on a.Visit_date=c.StartDate
            left join (
            SELECT StartDate, count(Event_Name) as 'event_count' FROM Event 
            where Site_Name='$site_name'
            and StartDate between '$start_date' and '$end_date' and EndDate between  '$start_date' and '$end_date'
            group by StartDate) as d
            on c.StartDate=d.StartDate ) AS big
            where event_count between $event_count_low and $event_count_high
            and staff_count between $staff_count_low and $staff_count_high
            and total_visit between $visit_low and $visit_high
            and total_revenue between $revenue_low and $revenue_high
            order by $sort $order; ";
            //echo $sql;
            if($result = $db->query($sql)){ 
               while($row=$result->fetch_assoc()){
                buildTable($row['Visit_date'],$row['event_count'],$row['staff_count'],$row['total_visit'],$row['total_revenue']);
            }
         }//execute query*/
       
        
    }// if no error, can proceed with building table
   }//if filter is hit
   //echo $_GET['chk'];
   if(isset($_GET['daily_detail']) && isset($_GET['chk'])){
    
     if(isset($_SESSION['page29'])){unset($_SESSION['page29']);}
     $_SESSION['page29']=array();
     $_SESSION['page29'][]=explode(";", $_GET['chk'])[0];//visit day
     //$_SESSION['page29'][]=explode(";", $_GET['chk'])[1];//event count
     //$_SESSION['page29'][]=explode(";", $_GET['chk'])[2];
     //$_SESSION['page29'][]=explode(";", $_GET['chk'])[3];
     //$_SESSION['page29'][]=explode(";", $_GET['chk'])[4];
     //var_dump($_SESSION['page29']);
     header("location: ./30_daily_detail.php");
    /*echo '<script type="text/javascript">
        alert(\'' . "directing to site detail page" . '\');
        window.location.replace("./30_daily_detail.php")</script>';*/
   }//if hit site deail

   if(isset($_GET['daily_detail']) && !isset($_GET['chk'])){

    $msg="you need to select one row to see Transit Detail";
   }
   
if (strlen($msg) >0){
    echo '<script language="javascript">';
    echo "alert('$msg')"; 
    echo '</script>';
    }    
mysqli_close($db); 
?>
            </tbody>
                
            </table>
        </div>
    </form>
</fieldset>

</body>
</html>

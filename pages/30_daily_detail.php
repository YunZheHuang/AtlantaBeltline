<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Site Detail</title>
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
    <form>
      <fieldset>
        <legend>DAILY DETAIL</legend>
        <div style="text-align: center;">
          <label id="sortLabel" >Sort By</label>
            <select name='sort'  >
                <option value='Event_Name'>Event Name</option> 
                <option value="staffs">Staff Names</option> 
                <option value='visits'>Visits</option>  
                <option value='total_revenue'>Revenues</option>       
            </select>
            <label><input type="radio" name="order" value="asc" checked> Ascending</label>
            <label><input type="radio" name="order" value="desc"> Descending</label>
            <input type='submit' name='filter' value='Filter'>
        </div>
        <div  style="text-align: center;postion: relative;  height: 150px; overflow-y: auto" id="div2">
          <table align="center">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Staff Name</th>
                    <th>Visits</th>
                    <th>Revenues</th>
                </tr>
            </thead>
            <tbody>
              <?php
    session_start();
       include('db.php') ;        
    function buildTable($event_name,$staff_name,$total_visit,$total_revenue){
          echo "<tr >  
                    <td class='col-event' value='$event_name'>$event_name</td> 
                    <td class='col-event' value='$staff_name'>$staff_name</td>
                    <td class='col-visit' value='$total_visit'>$total_visit</td>
                    <td class='col-revenue' value='$total_revenue'>$total_revenue</td>
                  </tr>";
        }//end clause for build table
        if(isset($_GET['filter'])){
          $order=mysqli_real_escape_string($db,$_GET['order']);
        $sort=mysqli_real_escape_string($db,$_GET['sort']);
         $visit_day=$_SESSION['page29'][0];
         $sitename="Inman Park";//Di change this 
         $sql="SELECT * from (SELECT e.Event_Name,k.staff, v.visits, v.visits * e.Price as 'total_revenue' 
              from Event as e
              left join
              (select StartDate, Event_Name, Site_Name, count(*) as 'visits' from visitor_visit_event
              group by StartDate, Event_Name, Site_Name
              )as v 
              on e.Event_Name=v.Event_Name and e.Site_Name=v.Site_Name and e.StartDate=v.StartDate
              join
              (select s.Event_Name, s.Site_Name, s.StartDate, group_concat(u.name separator ', ') as 'staff'
              from (select * from staff_assign_to_event) as s join
              (select concat(FirstName,LastName) as 'name', Username from User)as u
              on u.Username = s.Username
              group by Event_Name, Site_Name, StartDate)
              as k on k.StartDate=e.StartDate and k.Event_Name=e.Event_Name and k.Site_Name=e.Site_Name
              where e.Site_Name='$sitename' and '$visit_day' between e.StartDate and e.EndDate) as big 
              order by $sort $order ;";
              //echo $sql;
        if($result = $db->query($sql)){ 
               while($row=$result->fetch_assoc()){
                buildTable($row['Event_Name'],$row['staff'],$row['visits'],$row['total_revenue']);
            }
        }
            unset($_SESSION['page29']);
      }//if filter is hit
  
    
mysqli_close($db); 
?>
              
            </tbody>    
        </div>
        <div style="text-align: center;">
          <input type='button' onclick="goBack();" class="back-button" value='Back' >
          
        </div>
      </fieldset>
    </form>
  </body>
</html>

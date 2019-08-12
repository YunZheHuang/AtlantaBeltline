
<!DOCTYPE html>
<html>
<head>
    <title>Screen35: explore site</title>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen35.css">
    <link rel="icon" href="data:;base64,=">
    <script>
        function goBack()
          {window.history.back()}
</script>
</head>
<body>
<fieldset>
    <legend>EXPLORE SITE</legend>
    <form method="GET" action="">
        <div id='dropdownDiv' style="text-align: center;" >
            <label id ="labelO" for='ifOpen'>SiteName</label> 
              <select name="site_name">
                <option value='all_site'>--All--</option>
                <?php
                    if(session_id() == '') {
    session_start();
}     
                    include("../queries/db.php");
                    if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                } 
                  $sql="SELECT Site_Name from Site;";
                  echo $sql;
                  if($result = $db->query($sql)){
                      while($row=$result->fetch_assoc()){
                        $site_name=$row['Site_Name'];                       
                        echo "<option  value= '$site_name' >$site_name</option>";
                      }
                      $result->free();
                    }
                ?>            
              </select>
            <label id ="labelO" for='ifOpen'>Open EveryDay</label> 
              <select name="openEveryday">
                <option value="yes"> Yes </option>
                <option value="no"> No </option>
              </select>
        </div>
        <div class="div1" style="text-align: center;">
            <label>Start Date</label>
            <input name="start_date" type="date" class="input"   />
            <label>End Date</label>
            <input name="end_date" type="date" class="input"   />           
        </div>
        <div class="div1" style="text-align: center;">
            <label>Total Visits Range </label>
            <input name="visit_lower_bound" type="number" class="input"   />--
            <input name="visit_upper_bound" type="number" class="input"    /> 
            <label>Event Count Range</label>
            <input name="event_lower_bound" type="number" class="input"   />--
            <input name="event_upper_bound" type="number" class="input"  />            
        </div>
        <div style="text-align: center;">
            <input type="checkbox"  name="include_visit" > Include Visited
        </div>
        <div style="text-align: center;">
            <label id="sortLabel" >Sort By</label>
            <select name='sort'  >
                <option></option>
                <option value='Site_Name'>Site_Name</option>
                <option value='event_count'>Events Count</option> 
                <option value="total_visit">Total Visits</option> 
                <option value='my_visit'>My Visits</option>         
            </select>
            <label><input type="radio" name="order" value="asc" > Ascending</label>
            <label><input type="radio" name="order" value="desc"> Descending</label>
            <input type='submit' onclick="promptUsername()"name='filter' value='Filter'>
        </div>
        
        <div>
            <table id='buttonTable' align="center">
            <tr  align='center'>
              <td> <input type='submit' name='Site_Detail' value="Site Detail"  ></td></td>
             
              <td> <input type='submit' name='Transit_Detail' value="Transit Detail" ></td></td>
              <td><input type='button' onclick="goBack();" class="back-button" value='Back' ></td></td>
            </tr>
      </table>
        </div>
        <div style="postion: relative;  height: 200px; overflow-y: auto" id="div2" >
            <table align="center">
            <thead>
                <tr>
                    <th></th>
                    <th>Site Name</th>
                    <th>Event Count</th>
                    <th>Total Visits</th>
                    <th>My Visits</th>
                </tr>
            </thead>
            <tbody>                
    <?php
                
    function buildTable($sitename, $event_count,$total_visit,$my_visit,$openEveryday){
          echo "<tr >   
                    <td><input type='radio'  name='chk' value='$sitename;$event_count;$total_visit;$my_visit;$openEveryday' ></td> 
                    <td class='col-siteName' value='$sitename'>$sitename</td>
                    <td class='col-managerName' value='$event_count'>$event_count</td>
                    <td class='col-openEverDay' value='$total_visit'>$total_visit</td>
                    <td class='col-openEverDay' value='$my_visit'>$my_visit</td>
                  </tr>";
        }//end clause for build table
    $errors=array();
    $msg="";
    /*$prompt_msg = "Please type your username.";
    $username = promptUsername($prompt_msg);*/

   if(isset($_GET["filter"])){
    $sitename=mysqli_real_escape_string($db,$_GET['site_name']);
    $start_date=mysqli_real_escape_string($db,$_GET['start_date']);
    $end_date=mysqli_real_escape_string($db,$_GET['end_date']);
    $sort=mysqli_real_escape_string($db,$_GET['sort']);
    $visit_lower_bound=mysqli_real_escape_string($db,$_GET['visit_lower_bound']);
    $visit_upper_bound=mysqli_real_escape_string($db,$_GET['visit_upper_bound']);
    $event_lower_bound=mysqli_real_escape_string($db,$_GET['event_lower_bound']);
    $event_upper_bound=mysqli_real_escape_string($db,$_GET['event_upper_bound']);
    $openEveryday=mysqli_real_escape_string($db,$_GET['openEveryday']);
    if(isset($_GET['order'])){
        $order=mysqli_real_escape_string($db,$_GET['order']);
    }else{$order='';}
    if($start_date=='' || $end_date==''){
        array_push($errors, "missing dates");
        $msg ="you have to enter the start and end date";
    }
    if($sort==''){
        array_push($errors, "missing sort option");
        $msg ="you have to select the Sort By option";
    }
    if($visit_upper_bound==''||$visit_lower_bound==''||$event_lower_bound==''||$event_upper_bound==''){
        array_push($errors, "missing range option");
        $msg ="you have to specify the range";
    }
    if(count($errors)==0){
        //program
        $username='visitor1'; //I hard code this, Di you should change it
        $sql="
            SELECT A1.*,A2.total_visit,A3.my_visit from
            (SELECT G1.Site_Name,count(*) as'event_count'  from(
            SELECT S.Site_Name,E.StartDate,E.EndDate,E.Event_Name from Site as S
            join Event as E
            on S.Site_Name=E.Site_Name and S.OpenEveryday='$openEveryday'
            ) as G1
            where  StartDate between '$start_date' and '$end_date' 
            and EndDate between '$start_date' and '$end_date'
            group by Site_Name) as A1
            join 
            (SELECT G2.Site_Name,count(*) as total_visit from(
            SELECT V.* from
            Site as S
            join Visitor_Visit_Site as V
            on S.Site_Name=V.Site_Name and S.OpenEveryday='$openEveryday'
            and V.visit_date between '$start_date' and '$end_date') as G2
            group by Site_Name) as A2
            on A1.Site_Name=A2.Site_Name
            join
            (SELECT G3.Site_Name,count(*) as 'my_visit' from(
            SELECT V.* from
            Site as S
            join Visitor_Visit_Site as V
            on S.Site_Name=V.Site_Name and S.OpenEveryday='$openEveryday'
            and V.visit_date between '$start_date' and '$end_date' and V.Username='$username') as G3
            group by Site_Name ) as A3
            on A1.Site_Name=A3.Site_Name
            where event_count between $event_lower_bound and $event_upper_bound
            and total_visit between $visit_lower_bound and $visit_upper_bound ";
        if($sitename=='all_site'){
            $sql .=" order by '$sort' $order  ;";
            if($result = $db->query($sql)){
               while($row=$result->fetch_assoc()){
                buildTable($row['Site_Name'],$row['event_count'],$row['total_visit'],$row['my_visit'],$openEveryday);
            }
         }//execute query*/
        }//if all site is selected
        if($sitename!='all_site'){
            $sql .=" and A1.Site_Name= '$sitename' order by '$sort' $order ;";
            //echo $sql;
            if($result = $db->query($sql)){ 
               while($row=$result->fetch_assoc()){
                buildTable($row['Site_Name'],$row['event_count'],$row['total_visit'],$row['my_visit'],$openEveryday);
            }
         }//execute query*/
        }//if specific site is selected
        
    }// if no error, can proceed with building table
   }//if filter is hit
   //echo $_GET['chk'];
   if(isset($_GET['Site_Detail']) && !isset($_GET['chk'])){
    $msg="you need to select one row to see Site Detail";
   }
   if(isset($_GET['Site_Detail']) && isset($_GET['chk'])){
    
     if(isset($_SESSION['page35'])){unset($_SESSION['page35']);}
     $_SESSION['page35']=array();
     $_SESSION['page35'][]=explode(";", $_GET['chk'])[0];//site
     $_SESSION['page35'][]=explode(";", $_GET['chk'])[4];//openEveryday
    echo '<script type="text/javascript">
        alert(\'' . "directing to site detail page" . '\');
        window.location.replace("./37_visitorsite_detail.php")</script>';
   }//if hit site deail

   if(isset($_GET['Transit_Detail']) && !isset($_GET['chk'])){

    $msg="you need to select one row to see Transit Detail";
   }
   if(isset($_GET['Transit_Detail']) && isset($_GET['chk'])){
    
    if(isset($_SESSION['page35_ftransit'])){unset($_SESSION['page35_ftransit']);}
     if(isset($_SESSION['page35'])){unset($_SESSION['page35']);}
     $_SESSION['page35']=array();
     $_SESSION['page35'][]=explode(";", $_GET['chk'])[0];//site
     $_SESSION['page35'][]=explode(";", $_GET['chk'])[4];//openEveryday    
     echo '<script type="text/javascript">
        alert(\'' . "directing to transit detail page" . '\');
        window.location.replace("./36_transit_detail.php")</script>';
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

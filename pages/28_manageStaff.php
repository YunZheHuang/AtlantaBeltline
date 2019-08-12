<!DOCTYPE html>
<html>
<head>
    <title>Screen28: Manage Staff</title>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen28.css">
    <link rel="icon" href="data:;base64,=">
</head>
<body>
<fieldset>
    <legend>MANAGE STAFF</legend>
    <form method="GET" action="">
    <div id="siteDiv"  >
        <label id="siteLabel" for ='site'>Site Name</label>
        <select id='siteDroptDown' name='selectedSite'>        
        <?php 
            include('../queries/db.php');
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }       
            $sql="select Site_Name from Site;";
            if($result = $db->query($sql)){
                while($row=$result->fetch_assoc()){
                    $sitename=$row['Site_Name'];
                    //echo "<option id='$row['Site_Name']' value= '' ></option>";
                    echo "<option id='$sitename' value= '$sitename' >$sitename</option>";
                }
                $result->free();
            }                       
       ?>              
        </select>
    </div >

    
    <table id="selectorTable" align="center" cellspacing="10" >
        <tr>
            <td  style="font-weight: bold"><div align="right"><label for="fname">First Name</label></div></td>
            <td><input name="first_name" type="text" class="input"   /></td>
            <td></td>
            <td  style="font-weight: bold"><div align="right"><label for="lname">Last Name</label></div></td>
            <td><input name="last_name" type="text" class="input"   /></td>
        </tr>
        <tr>
            <td  style="font-weight: bold"><div align="right"><label for="start date">Start Date</label></div></td>
            <td><input name="start_date" type="date" class="input"   required /></td>
            <td></td>
            <td  style="font-weight: bold"><div align="right"><label for="end date">End Date</label></div></td>
            <td><input name="end_date" type="date" class="input"  required /></td>
            
        </tr>
    </table>
    <div style="text-align: center;">
        <label id="sortLabel" >Sort By</label>
        <select name='sort' required >
            <option></option>
            <option value='staff_name'>Staff Name</option>
            <option value='eventCount'>#Event Shifts</option>           
        </select>
        <label><input type="radio" name="order" value="asc" required> Ascending</label>
        <label><input type="radio" name="order" value="desc"> Descending</label>
    </div >
    <table id='buttonTable' align="center">
        <tr  align='center'>
          <td> <input type='submit' name='filter' value='Filter'></td></td>
          <td><input type='submit' onclick='history.go(-1)' value='back' ></td></td>
        </tr>
      </table>
    </form>

<div style="postion: relative;  height: 200px; overflow-y: auto" id="div2" >
    <table id='resultTable' align="center" class="sortable"  >
        <thead>
           <tr>
            <th>Staff Name</th>
            <th>#Event Shifts</th>
           </tr>
        </thead>
        <tbody>               
            <?php 
                
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            function buildTable($staffname, $count){
              echo "<tr>   
                        <td class='col-staffName' value='$staffname'>$staffname</td>
                        <td class='col-shiftCount' value='$count'>$count</td>
                      </tr>";
            }//end clause for build table

            if(isset($_GET["filter"]))  {
                $msg = "";
                $errors=array();
                $sitename=mysqli_real_escape_string($db,$_GET['selectedSite']);
                $first_name=mysqli_real_escape_string($db,$_GET['first_name']);
                $last_name=mysqli_real_escape_string($db,$_GET['last_name']);
                $start_date=mysqli_real_escape_string($db,$_GET['start_date']);
                $end_date=mysqli_real_escape_string($db,$_GET['end_date']); 
                $sort_type=mysqli_real_escape_string($db,$_GET['sort']);
                $order=mysqli_real_escape_string($db,$_GET['order']);
                //echo $end_date;      
                $sql= "SELECT CONCAT(U.Firstname,' ', U.Lastname) as 'staff_name',U.Lastname,U.Username,U.Firstname,count(*) as 'eventCount'
                        from Staff_assign_to_event as S
                        JOIN Event AS E ON S.Site_Name = E.Site_Name and E.StartDate=S.StartDate
                        JOIN User as U ON U.Username=S.Username
                        where S.Site_Name='$sitename' and E.StartDate = '$start_date' 
                        and E.EndDate = '$end_date' ";
                if(strlen($first_name)>0 && strlen($last_name)>0){
                    $sql .=" and U.Firstname = '$first_name' and Lastname='$last_name'
                            group by U.Username 
                            order by '$sort_type' $order ;";
                    if($result = $db->query($sql)){
                        while($row=$result->fetch_assoc()){
                            buildTable($row['staff_name'],$row['eventCount']);
                        }
                        $result->free();
                    }
                }
                if(strlen($first_name)>0 && strlen($last_name)==0){
                    $sql .=" and U.Firstname = '$first_name'
                            group by U.Username 
                            order by '$sort_type' $order ;";
                    if($result = $db->query($sql)){
                        while($row=$result->fetch_assoc()){
                            buildTable($row['staff_name'],$row['eventCount']);
                        }
                        $result->free();
                    }
                }
                if(strlen($first_name)==0 && strlen($last_name)>0){
                    $sql .=" and Lastname='$last_name'
                            group by U.Username 
                            order by '$sort_type' $order ;";
                    echo $sql;
                    if($result = $db->query($sql)){
                        while($row=$result->fetch_assoc()){
                            buildTable($row['staff_name'],$row['eventCount']);
                        }
                        $result->free();
                    }
                }
                if(strlen($first_name)==0 && strlen($last_name)==0){
                    $sql .=" group by U.Username 
                            order by '$sort_type' $order ;";
                    
                    if($result = $db->query($sql)){
                        while($row=$result->fetch_assoc()){
                            buildTable($row['staff_name'],$row['eventCount']);
                        }
                        $result->free();
                    }
                }
        } 
mysqli_close($db);                          
?>              
       
            </tbody>
        </table>
    </div>
</fieldset>

</body>
</html>
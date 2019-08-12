
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Screen18:Admin_Employee Manage User</title>
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
    <script src="../assets/js/screen18.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen18.css">
    <link rel="icon" href="data:;base64,=">

</head>
<body>
  <form method="GET" action=" " >
    <fieldset>
   <legend>MANAGE USER</legend>
    <div id="div1" style="text-align: center;">
        <label id="sortLabel" >Sort By</label>
        <select name='sort' >
            <option></option>
            <option value='Username'>Username</option>
            <option value='email_count'>Email Count</option>
            <option value='user_type'>User Type</option>
            <option value='Status'>Status</option>           
        </select>

        <label><input type="radio" name="order" value="asc" > Ascending</label>
        <label><input type="radio" name="order" value="desc"> Descending</label>


    <table id="optionTable" align="center">
    <tr>
        <td>
    <label for="type">User Type 
        <select name="user_type" id="usertype_dropdown" > 
            <option ></option>
              <option value="User">User</option>
              <option value="Visitor">Visitor</option>
              <option value='Staff'>Staff</option>
              <option value='Manager'>Manager</option>
        </select> 
    </label>
        </td>
        <td>
        <label for="user_status"> Status
            <select name="user_status" id="userstatus_dropdown">
             <option value="all_status">--All--</option>
              <option value="Approved">Approved</option>
              <option value ="Pending">Pending</option>
              <option value="Declined">Declined</option>
            </select><br>
        </label>
      </td>
      </tr>
      </table>
    </div>

      <table id='buttonTable' align="center">
        <tr  align='center'>
          <td> <input type='submit' name='filter' value='Filter'></td></td>
          <td><input type='submit'  name='approve' value='Approve'></td></td>
          <td><input type='submit' name='decline' value="Decline"></td></td>
          <td><input type='button' onclick="goBack()" value='back' ></td></td>
        </tr>
      </table>
     

</form>
 <div style="text-align: center;" id="div2"> 

<?php
      
  include ("../queries/db.php");
  echo " <table id='phpTable' align='center' class='class='display'>
  <thead>
          <tr> 
            <th></th>
            <th alighn='left'>Username</th>
            <th>Email Count</th>
            <th>User Type</th>
            <th>Status</th>
          </tr>
        </thead>
  <tbody>
  ";
  if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
       }
  //function to create table
    function buildTable($name, $count,$type,$stat){
      echo "<tr> 
                <td><input type='radio' onchange='change(this)' name='selectBox[]' value='$name'/></td>    
                <td class='col-username' value='$name'>$name</td>
                <td class='col-emailCount' value='$count'>$count</td>
                <td class='col-userType' value='$type'>$type</td>
                <td class='col-status' value='$stat'>$stat</td>
              </tr>";
    }//end clause for build table

if(isset($_GET["filter"])) {
      $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
      $user_type=$_GET['user_type'];//user can be all
      $user_status=$_GET['user_status'];
      
      $sort_type=$_GET['sort'];
      if($sort_type==''){
          $msg="you have to select the Sort BY by option!!!";
         }
      if($user_type==''){
          $msg="you have to select the user type option!!!";
         }
      $order=$_GET['order'];
      
      if(count($errors)==0){//create an array ; USE THIS array_search('green', $array);
        if($user_type=='User'){
            if($user_status=="all_status"){
              $sql="Select Username,Count(*) AS email_count ,is_visitor,Status 
                    from (
                    SELECT User.Username,User.Status,User.is_visitor,Email.email
                      FROM User 
                      JOIN Email on User.Username=Email.Username 
                    ) as T1 
                    group by T1.Username";
                if($sort_type=='user_type'){
                  $sql=$sql . ";";
                }
                if($sort_type!='user_type'){
                  $sql=$sql . " order by $sort_type $order;";
                }
                //echo $sql;
                if ($result = $db->query($sql)) {
                  while ($row = $result->fetch_array()){
                    buildTable($row['Username'],$row['email_count'],"User",$row['Status']); 
                  }//while cluase
                   $result->free();// free result set 
                }//end query
              } // if all status  

            if($user_status!="all_status"){
              $sql="Select Username,Count(*) AS email_count ,is_visitor,Status 
                    from (
                    SELECT User.Username,User.Status,User.is_visitor,Email.email
                      FROM User 
                      JOIN Email on User.Username=Email.Username and is_visitor='no' and is_employee='no'
                    ) as T1 
                    where Status='$user_status' ";

                if($sort_type=='user_type'){
                  $sql=$sql . "group by T1.Username ;";
                }
                if($sort_type!='user_type'){
                  $sql=$sql . " group by T1.Username order by $sort_type $order;";
                }
                //echo $sql;
                if ($result = $db->query($sql)) {
                  while ($row = $result->fetch_array()){
                    buildTable($row['Username'],$row['email_count'],"User",$row['Status']); 
                  }//while cluase
                   $result->free();// free result set 
                }//end query
             }//if status is approved,declined, pending
      
            } //end clause if usertype is User          
        if($user_type=='Visitor'){              
            if($user_status=="all_status"){
                $sql="Select Username,Count(*) AS email_count ,is_visitor,Status 
                    from (
                    SELECT User.Username,User.Status,User.is_visitor,Email.email
                      FROM User 
                      JOIN Email on User.Username=Email.Username and is_visitor='yes' and is_employee='no'
                    ) as T1 
                    group by T1.Username ";
                  if($sort_type=='user_type'){
                    $sql=$sql . ";";
                  }
                  if($sort_type!='user_type'){
                    $sql=$sql . " order by $sort_type $order;";
                  }
                  if ($result = $db->query($sql)) {
                    while ($row = $result->fetch_array()){
                      buildTable($row['Username'],$row['email_count'],"Visitor",$row['Status']); 
                    }//while cluase
                     $result->free();// free result set 
                  }//end query
                } // if all status  
            if($user_status!="all_status"){
              $sql="Select Username,Count(*) AS email_count ,is_visitor,Status 
                    from (
                    SELECT User.Username,User.Status,User.is_visitor,Email.email
                      FROM User 
                      JOIN Email on User.Username=Email.Username and is_visitor='yes' and is_employee='no'
                    ) as T1 
                    where Status='$user_status' ";
                  if($sort_type=='user_type'){
                    $sql=$sql . "group by T1.Username ;";
                  }
                  if($sort_type!='user_type'){
                    $sql=$sql . " group by T1.Username order by $sort_type $order;";
                  }
                  if ($result = $db->query($sql)) {
                    while ($row = $result->fetch_array()){
                      buildTable($row['Username'],$row['email_count'],"Visitor",$row['Status']); 
                    }//while cluase
                     $result->free();// free result set 
                  }//end query
            }// if status is approved,declined, pending
          } //end clause if usertype is Visitor          
        if($user_type=="Staff" ||$user_type=="Manager"){ //employee type
           $sql="Select Username,Count(*) AS email_count ,employee_type,Status 
              from (
              SELECT User.Username,User.Status,Email.email,Employee.employee_type 
              FROM User 
               JOIN Email on User.Username=Email.Username 
              JOIN Employee on User.Username=Employee.Username 
              ) as T2
              where employee_type <> 'Admin' and employee_type = '$user_type'
              group by T2.Username, T2.employee_type ";
            if($user_status=="all_status"){
              if($sort_type=='user_type'){
                    $sql=$sql . ";";
                  }
              if($sort_type!='user_type'){
                    $sql=$sql . " order by $sort_type $order;";
                  }
              if ($result = $db->query($sql)) {
                while ($row = $result->fetch_array()){
                    buildTable($row['Username'],$row['email_count'],$row['employee_type'],$row['Status']); 
                    }//while cluase
                     $result->free();// free result set 
                }//end query
             }//if all status

            if($user_status!="all_status"){//Pending,Approved,Declined
              $sql="Select Username,Count(*) AS email_count ,employee_type,Status 
              from (
              SELECT User.Username,User.Status,Email.email,Employee.employee_type 
              FROM User 
               JOIN Email on User.Username=Email.Username 
              JOIN Employee on User.Username=Employee.Username 
              ) as T2
              where employee_type <> 'Admin' and employee_type = '$user_type'
              and Status='$user_status' ";
                if($sort_type=='user_type'){
                    $sql=$sql . "group by T1.Username ;";
                  }
                if($sort_type!='user_type'){
                    $sql=$sql . " group by T2.Username order by $sort_type $order;";
                  }
                //echo $sql;
                if ($result = $db->query($sql)) {
                    while ($row = $result->fetch_array()){
                      buildTable($row['Username'],$row['email_count'],$row['employee_type'],$row['Status']); 
                    }//while cluase
                     $result->free();// free result set 
                  }//end query
            }//if status is Pending,Approved,Declined
         }////end clause is status is employee :manager or staff
     }//if no error
  } //end if clause if there are no errror, can proceed with filter
   
//end clause for if press filter
//IF APPROVE BUTTON IS HIT
if(isset($_GET["approve"],$_GET['selectBox'])){
  $errors=array();
  $username=mysqli_real_escape_string($db, $_GET['selectBox'][0]);//the value is username
  $sql="Select Status from User where Username='$username';";
  $res=mysqli_query($db,$sql);
  $stat=mysqli_fetch_array($res)['Status'];
  if($stat=="Approved"){
      //array_push($errors, 1);//push some thing in errors array;
      $msg= $username . "  has alread been approved. you cannot approve twice!!!";
  }
  else{
      $sql1="UPDATE User SET Status ='Approved' WHERE Username='$username';";
      $res1=mysqli_query($db,$sql1);
      if($res1){
        $msg="User ". $username ." is approved";
      }else{die("database cannot be updated");}//the else is redundatn
    }//else statement for approving declined and pending status  
}//if approve button is hit
  
//IF DECLINE BUTTON IS HIT
if(isset($_GET["decline"],$_GET['selectBox'])){
  $errors=array(); 
  $username=mysqli_real_escape_string($db, $_GET['selectBox'][0]);//the value is username
  $sql="Select Status from User where Username='$username';";
  $res=mysqli_query($db,$sql);
  $stat=mysqli_fetch_array($res)['Status'];
  if($stat=="Approved"){
      //array_push($errors, 1);//push some thing in errors array;
      $msg= $username. " has been already approved. You cannot decline this account!!!";
    }
    else{
        $sql1="UPDATE User SET Status ='Declined' WHERE Username='$username';";
        $res1=mysqli_query($db,$sql1);
        if($res1){
          $msg="User ". $username ." is declined";
        }else{die("database cannot be updated");}//the else is redundatn
      }//else statement for declined and pending status  
     
}//if approve button is hit

if (is_null($_GET['selectBox']) && isset($_GET["approve"])){
  $msg="Username needs to be selected to be approved!!!";
}
if (is_null($_GET['selectBox']) && isset($_GET["decline"])){
  $msg="Username needs to be selected to be approved!!!";
}


if (strlen($msg) >0){
    echo '<script language="javascript">';
    echo "alert('$msg')"; 
    echo '</script>';
    }


#mysqli_free_result($errors);
#mysqli_free_result($msg);
mysqli_close($db);
?>
</tbody>
</table>
</div>
</fieldset>
</body>
</html>


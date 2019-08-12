<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin_Employee Manage Profile</title>
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/screen17.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen17.css">
    <link rel="icon" href="data:;base64,=">

</head>
<script>
function goBack() {
  window.history.back()
}
</script>
<body>
  <fieldset>
   <legend>Manage Profile</legend>
    <div id="selectDiv">
      <!--<label for="dropdown" id="#labelDropDown">User Name</label>-->
      <select name="username" onchange="showDetails(this.value)">
        <option value="User Name"  >--select a username--</option> 
        <?php
        include ("../queries/db.php");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
            }
        $query1="SELECT Username FROM User WHERE is_employee='yes';";    
         if ($result = $db->query($query1)) {
            while ($row = $result->fetch_assoc()) {
              $username_array[]=$row['Username'];
              echo '<option value=" '.$row['Username'].' "> '.$row['Username'].' </option>';
             }
            /* free result set */
            $result->free();
          }  
      $db->close()
    ?> 
      </select>
      <button onclick="goBack()">Go Back</button>
    </div>
    <form method="POST" action="">
    <div id="txtHint"><b>User info will be listed here.</b>
    </div>

    </form>
  </fieldset>



</body>
</html>

<?php
session_start();
include ("../queries/db.php");    
    /* check connection */
    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    if(isset($_POST["submit"])) {
      $msg = "";
      $errors=array();
      $firstname = mysqli_real_escape_string($db, $_POST['firstname']); #POST more security
      $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
      $username = mysqli_real_escape_string($db, $_POST['username']);
      $phone = mysqli_real_escape_string($db, $_POST['phone']);
      $emails = array();
      
      if(empty($firstname) || empty($lastname) ||empty($phone)){
            $msg .="missing values ; ";
            array_push($errors, "Cannot update because of missing value(s)");
      }
      if(strlen($phone) != 10){
        array_push($errors, "phone error");
        $msg .="Cannot update; Phone number is a 10-digit number ;";
        
      }
      //check email
      foreach ($_POST["emails"] as $e) {
        //echo $e;
            //echo("<script>console.log('PHP: ".$email."');</script>");
            //$e = filter_var($e, FILTER_VALIDATE_EMAIL);
        if (!preg_match("/^[A-Z0-9a-z]+@[A-Z0-9a-z]+\.[A-Z0-9a-z]+$/", $e)) {
                array_push($errors, "invalid Email"); 
                $msg .= "Invalid Email... Please use another email to update ;"; 
              

            }
        else{
          $emails[]=$e;
           }
        }
        if (count($emails) != count(array_unique($emails))){
            array_push($errors, "duplicate emails"); 
            $msg .="duplicate emails are not allowed";
            
        }
        //var_dump(count($emails));
        $email_count=count($emails);
        //echo $email_count;
        if($email_count==0){
          array_push($errors, "zero emails");
          $msg .="Cannot update: User must have at least 1 email ;"; 
          
        }

        //check if visitor or not

      
      if(count($errors)==0 ){
        if(isset($_POST['is_visitor'])){
            $is_visitor="yes";//if it's checked
          }
        else{
            $is_visitor="no";
          }
       
        $checkQueries="SELECT * FROM User where Firstname='$firstname' AND Lastname='$lastname' ;";
        $res1=mysqli_query($db,$checkQueries);
        if (mysqli_num_rows($res1)==1 ){//first name and last name not changed
          $queries=""; 
        }else{ 
          $queries ="UPDATE User SET Firstname='$firstname', Lastname='$lastname' WHERE Username= '$username' ;";
        }
        //check email is changed
        $checkEmail="SELECT * FROM Email WHERE Username= '$username';";
        $res2=mysqli_query($db,$checkEmail);
        $emails_pre=array();
        while ($row = mysqli_fetch_array($res2)) {
            $e=$row['Email'];
            array_push($emails_pre, $e);
            //$emails_pre=$row['Email'];  
         }
        //print_r($emails_pre);
        //check if email is changed
        if (serialize($emails) === serialize($emails_pre)){//email is not changed
          $queries .="";
        }else{
          $queries .="DELETE FROM Email WHERE Username='$username';";
            foreach ($emails as $e){
              //echo "$e";
              $queries .= "UPDATE Email SET  Email = '$e' WHERE Username= '$username' ;";
            }
        }
        //take care when user deselect visitor account
        $check_visitor="Select * from User where Username='$username' ;";
        //echo $check_visitor;
        $res4=mysqli_query($db,$check_visitor) or die(mysqli_error());
        $row=mysqli_fetch_array($res4);
        $check_visitor_before=$row['is_visitor'];
        if($is_visitor=='no' and $check_visitor_before == 'yes'){
           //deselecting visitor account, delete their name in Visitor_Visit_Site,visitor_visit_event
          $queries .="DELETE from Visitor_Visit_Site where Username = '$username' ;" ;
          $queries .="DELETE from visitor_visit_event where Username = '$username' ; ";
          $queries.="UPDATE User SET is_visitor='no' WHERE Username= '$username' ;";
          
        }
        if($is_visitor=='yes' && $check_visitor_before == 'no'){
          $queries.="UPDATE User SET is_visitor='yes' WHERE Username= '$username' ;";
        }
        //check if phone is changed
        $phoneCheck="SELECT * FROM Employee WHERE Phone='$phone' ;";
        //echo $phoneCheck;
        $res3=mysqli_query($db,$phoneCheck) ;
        if (mysqli_num_rows($res3)==1 ){
           $queries .="";
        }
        else {
          $queries .="UPDATE Employee SET Phone='$phone' WHERE Username= '$username' ";
        }
        
        //echo $queries;
        if (strlen($queries)==0){ //leave it there, nothing is changed, nothing in the alert 
          //$msg .="Nothing is changed ! Profile is preserved";
        }
        else {
        //execute update, multiple queries
            if ($db->multi_query($queries)) {
                do {
                    //store first result set 
                    if ($result = $db->store_result()) {
                        while ($row = $result->fetch_row()) {
                            printf("%s\n", $row[0]);
                        }     
                    }
                    //print divider 
                    if ($db->more_results()) {
                        printf("");
                    }
                    if (!$db ->next_result()){
                        //echo 'errors: ' . mysqli_error($db);
                        break;
                    }
                } while (true); 
                mysqli_free_result($result); 
            }  //end if clause
                if(mysqli_error($db)){//delete cascade
                    $msg .= "error in database execution: cannot update";
                }
                else{//if not generate any errors
                    $msg .="Profile is successfully updated !";
                    
                }//end else clause if no error in mysqli execute
        }// end else cluase, if there is things to be changed*/
    }//end if clause count(errors)=0
   

}//end if cluse if update button is submitted 
if (strlen($msg) >0){
  echo '<script language="javascript">';
  echo "alert('$msg')"; 
  echo '</script>';
}
mysqli_close($db);
//mysqli_free_result($errors);
/*mysqli_free_result($res3);
mysqli_free_result($res1);
mysqli_free_result($res2);
;*/
//;
?>



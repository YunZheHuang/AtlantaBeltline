<?php

    $msg = "";
    include ("../queries/db.php");    
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $errors=array();
    $emails = array();
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']); #get more security
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];
    $confirm_pass=$_POST["confirmPassword"];
    $status="Pending";
    $is_employee="no";
    $is_visitor="yes";
    //printf(count($errors));
    function validateEMAIL($EMAIL) {
    $v = "/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
    return (bool)preg_match($v, $EMAIL);
    }
if(isset($_POST["submit"])) {
    //form validation
    if(empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm_pass) ){
            array_push($errors, "missing value(s)");
            $msg =" missing value(s) ;";
            header("Refresh:2");
        }
    if (strlen($password) <8 || strlen($confirm_pass) <8 ){
        array_push($errors, "password should have more than 8 characters");
        $msg .="Password should have more than 8 characters. Use a different password ;";
        header("Refresh:2");
    }
    $passwordHash=password_hash($password, PASSWORD_BCRYPT);
    $confirmPasswordHash=password_hash($confirm_pass, PASSWORD_BCRYPT);
    if($password != $confirm_pass){
        array_push($errors, "passwords does not match");
        $msg .="Passwords does not match. Please register again ;";
        header("Refresh:2");
        } 
    if (!password_verify($password, $passwordHash) ||  !password_verify($confirm_pass, $confirmPasswordHash)){
        array_push($errors, "invalid Password");
        $msg .="invalid Password. Please use a different password ;";
        header("Refresh:2");
    }
    
    foreach ($_POST["emails"] as $e) {
            //echo("<script>console.log('PHP: ".$email."');</script>");
            //$e = filter_var($e, FILTER_VALIDATE_EMAIL);
        if (!preg_match("/^[A-Z0-9a-z]+@[A-Z0-9a-z]+\.[A-Z0-9a-z]+$/", $e)) {
                array_push($errors, "invalid Email"); 
                $msg .= "Invalid Email... Please use another email to register ;"; 
                header("Refresh:2");
            }
            $sql1="SELECT Email from Email where Email='$e' ;";
            
            $result1=mysqli_query($db,$sql1);
            if(mysqli_num_rows($result1) > 0 ){
                array_push($errors, "Sorry...This email already exist"); 
                $msg .= "Sorry...This email already exist.... Please add another email to register ;"; 
                header("Refresh:2");
            }
            else{
                $emails[]=mysqli_real_escape_string($db,$e);
            }       
     }
    if (count($emails) != count(array_unique($emails))){
        array_push($errors, "duplicate emails"); 
        $msg .="duplicate emails are not allowed";
        header("Refresh:2");
     }
    //check db for existing values
    $sql2="SELECT username from User where username='$username' ;";
    //echo "$sql2";
    $result2=mysqli_query($db,$sql2); 
    //printf('$result2');
    if(mysqli_num_rows($result2) > 0 ){
        array_push($errors, "Sorry...This username already exist"); 
        $msg .= "Sorry...This username already exist... Please use another username to register ;"; 
        header("Refresh:2");
    }
    //$email_count=count($emails);
    //printf(count($errors));
    //foreach($errors as $er){echo "$er";}

    if(count($errors)==0){
        $query="INSERT INTO User(username,Status,Password,Firstname,Lastname,is_employee,is_visitor)
        VALUES('$username','$status','$password','$firstname','$lastname','$is_employee','$is_visitor') ;";
        foreach ($emails as $e){
            //echo "$e";
            $query .= "INSERT INTO Email(Username,Email) VALUES ('$username','$e') ;";
        }
        //echo "$query";
       
        if ($db->multi_query($query)) {
            do {
                //store first result set 
                if ($result = $db->store_result()) {
                    while ($row = $result->fetch_row()) {
                        printf("%s\n", $row[0]);
                    }     
                }
                //print divider 
                if ($db->more_results()) {
                    printf("-----------------\n");
                }
                if (!$db ->next_result()){
                    //echo 'errors: ' . mysqli_error($db);
                    break;
                }
            } while (true); 
            mysqli_free_result($result); 
        }  //end if clause
            if(mysqli_error($db)){//delete cascade
                $msg .= mysqli_error($db);
                $del="DELETE FROM User where Username= '$username';";
                mysqli_query($db,$del);
            }
            else{//if not generate any errors
                $msg .="Registration is successful. You are registered as visitor. Directing to home page";
                header("refresh:2;url= ../index.html"); 
                session_destroy();
            }//end else clause   
    }    
   
}
mysqli_free_result($result1);
mysqli_free_result($result2);
mysqli_free_result($msg);
mysqli_free_result($errors);
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <title>Atlanta Beltline - Add User</title>
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../assets/js/addEmail.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/registerPages.css">
</head>
<body>
    <form method="post" action="">
    <fieldset>
    <legend>REGISTER VISITOR</legend>
    <table id="table"  >
    <tr>
    <td colspan="3" align="center" class="error"><?php echo $msg;?></td>
    </tr>
    <tr>
    <td  style="font-weight: bold"><div align="right"><label for="name">First Name</label></div></td>
    <td><input name="firstname" type="text" class="input" size="25" required /></td>
    </tr>
    <tr>
    <td style="font-weight: bold"><div align="right"><label for="name">Last Name</label></div></td>
    <td><input name="lastname" type="text" class="input" size="25" required /></td>
    </tr>
    <tr>
    <td style="font-weight: bold"><div align="right"><label for="name">UserName</label></div></td>
    <td><input name="username" type="text" class="input" size="25" required /></td>
    </tr>

    

    <tr >
    <td height="23" style="font-weight: bold"><div align="right"><label for="password">Password</label></div></td>
    <td><input name="password" type="password" class="input" size="25" required /></td>
    </tr>
    <tr>
    <td height="23" style="font-weight: bold"><div align="right"><label for="password">Confirm Password</label></div></td>
    <td><input name="confirmPassword" type="password" class="input" size="25" required /></td>
    </tr>
    <tr class= "email_table" id="emailTable_1">
    <td style="font-weight: bold"><div align="right"><label for="email">Email</label></div></td>
    <td><input  name="emails[]" type="email" class="input" size="25"  id="email_1" required /></td>
    <!--<td><button onclick="addEmail()" value="addEmail" id="add1"  >add Email</button>-->
    <td><input type="button" onclick="addEmail(this)" value=" add " id="addButton_1"></td>
    <td><input type="button" onclick="removeEmail(this)" value="remove" id="removeButton_1"></td>
    </tr>
    <tr>
    <td height="23"></td>
    <td><div align="center">
       <input type="submit" onclick="window.location.href='register_navigation.php'" name="back" value="Back" />
       <input type="submit" name="submit" value="Register" />
      
    </div></td>

    </tr>
    </table>
    </fieldset>
    </form>
  </body>
</html>
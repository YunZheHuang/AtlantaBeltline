<?php

    $msg = "";
    include ("../queries/db.php");    
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $errors=array();
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']); #get more security
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $usertype=mysqli_real_escape_string($db,$_POST['usertype']); //employee type
    $password = $_POST['password'];
    $confirm_pass=$_POST["confirmPassword"];
    $phone=mysqli_real_escape_string($db,$_POST['phone']);
    $address=mysqli_real_escape_string($db,$_POST['address']);
    $city=mysqli_real_escape_string($db,$_POST['cityName']);
    $state=mysqli_real_escape_string($db,$_POST['state']);
    $zipcode=mysqli_real_escape_string($db,$_POST['zipcodeNumber']);
    $emails = array();

    
    $status="Pending";
    $is_employee="yes";
    $is_visitor="yes";
    //printf(count($errors));
    
    
if(isset($_POST["submit"])) {
    //handle missing values
    if(!isset($_POST['usertype']) || $_POST['usertype'] =='-----'){
        array_push($errors, "forgot to select your user type");
        $msg = "You forgot to select your user type! ;";
        header("Refresh:2");
    }
    if(!isset($_POST['state']) || $_POST['state'] =='-----'){
        array_push($errors, "forgot to select state");
        $msg .= "You forgot to select state! ;";
        header("Refresh:2");
    }  
    
    if(empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm_pass) || empty($zipcode) || empty($city)||empty($phone)||empty($address)){
            $msg .="missing values ; ";
            array_push($errors, "missing value(s)");
    }
    //validate phone number
    if(strlen($phone) != 10){
        array_push($errors, "phone error");
        $msg .="Phone number is a 10-digit number ;";
        header("Refresh:2");
    }
    //validate zipcode number
    if(strlen($zipcode) != 5){
        array_push($errors, "zipcode error");
        $msg .="zipcode is a 5-digit number ;";
        header("Refresh:2");
    }
    //validate city
    // if(preg_match("/[0-9]*/", $city)){
    //     array_push($errors, "city error");
    //     $msg .="city name cannot contain number ;";
    //     #header("Refresh:2");
    // }
    //validate password
    if (strlen($password) <8 || strlen($confirm_pass) <8 ){
        array_push($errors, "password should have more than 8 characters");
        $msg .="Password should have more than 8 characters. Use a different password ";
        header("Refresh:2");
    }
    $passwordHash=password_hash($password, PASSWORD_BCRYPT);
    $confirmPasswordHash=password_hash($confirm_pass, PASSWORD_BCRYPT);
    if($password != $confirm_pass){
        array_push($errors, "passwords does not match");
        $msg .="Passwords does not match. Please register again ; ";
        header("Refresh:2");
        } 
    if (!password_verify($password, $passwordHash) ||  !password_verify($confirm_pass, $confirmPasswordHash)){
        array_push($errors, "invalid Password");
        $msg .="invalid Password. Please use a different password ;";
        header("Refresh:2");
    }
    
    //validate email
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
                //echo "not exits this email";
                $emails[]=mysqli_real_escape_string($db,$e);
            }
            
    }//end check email clause
     //check if added email has duplicates
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
    $sql3="SELECT Phone from Employee where Phone='$phone' ;";
    $result3=mysqli_query($db,$sql3); 
    if(mysqli_num_rows($result3) > 0 ){
        array_push($errors, "This phone already exist"); 
        $msg .= "Sorry...This phone number already exist... Please use another phone number to register ;"; 
        header("Refresh:2");
    }
    //foreach($errors as $er){echo "$er";}

    if(count($errors)==0){
 
        $randID=uniqid();
        $query="INSERT INTO User(username,Status,Password,Firstname,Lastname,is_employee,is_visitor)
        VALUES('$username','$status','$password','$firstname','$lastname','$is_employee','$is_visitor') ;";
        //add to employee table, employee-id is not determined, it will be if admin approved
        $query .="INSERT INTO Employee(Phone,Address, City, State, Zipcode, EmployeeID, employee_type, Username)
        VALUES('$phone','$address','city','$state','$zipcode','$randID','$usertype','$username');";
        foreach ($emails as $e){

            $query .= "INSERT INTO Email(Username,Email) VALUES ('$username','$e') ;";
        }
       
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
                $msg .="Registration is successful. You are registered as an employee and visitor. Directing to home page";
                header("refresh:3;url= ../index.html"); 
               
            }//end else clause                      
    } //end if clause if register button is hit 
   
 }

mysqli_free_result($result1);
mysqli_free_result($result2);
mysqli_free_result($result3);
mysqli_free_result($msg);
mysqli_free_result($del);
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
    <script src="../assets/js/registerV2.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/registerPagesV2.css">
</head>
<body>
    <form method="post" action="">
    <fieldset>
    <legend>REGISTER EMPLOYEE</legend>
    <table id="table"  >
    <tr>
    <td colspan="4" align="center" class="error"><?php echo $msg;?></td>
    </tr >

    <tr >
    <td  style="font-weight: bold"><div align="right"><label for="name">First Name</label></div></td>
    <td><input name="firstname" type="text" class="input"  required /></td>
    <td style="font-weight: bold"><div align="right"><label for="name">Last Name</label></div></td>
    <td><input name="lastname" type="text" class="input"  required /></td>
    </tr>


    <!--<tr>
    <td style="font-weight: bold"><div align="right"><label for="name">Last Name</label></div></td>
    <td><input name="lastname" type="text" class="input" size="25" required /></td>
    </tr>-->

    <tr>
    <td style="font-weight: bold"><div align="right"><label for="username">UserName</label></div></td>
    <td><input name="username" type="text" class="input"  required /></td>
    <td style="font-weight: bold"><div align="right"><label for="usertype">User Type</label></div></td>
    <td><select id="usertype_" name="usertype" required>
        <option ></option>
        <option value="manager">Manager</option>
        <option value="staff">Staff</option>
    </select>
    </td>
    
    </tr>

    <tr >
    <td height="23" style="font-weight: bold"><div align="right"><label for="password">Password</label></div></td>
    <td><input name="password" type="password" class="input"  minlength="10" required /></td>
    <td height="23" style="font-weight: bold"><div align="right"><label for="password">Confirm Password</label></div></td>
    <td><input name="confirmPassword" type="password" minlength="10" class="input"  required /></td>
    </tr>

    <tr >
    <td height="23" style="font-weight: bold"><div align="right"><label for="phone">Phone</label></div></td>
    <td><input placeholder="Ex:8888888888" name="phone" type="tel"  pattern="[0-9]{10}" class="input"  required /></td>
    <td height="23" style="font-weight: bold"><div align="right"><label for="address">Address</label></div></td>
    <td><input name="address" type="text" class="input"  required /></td>
    </tr>

    <tr >
    <td  height="23"style="font-weight: bold"><div  align="right"><label for="city" >City</label></div></td>
    <td ><input id="city_" name="cityName" type="text" required /></td>

    <td  height="23" style="font-weight: bold"><div  align="right"><label for="zipcode">ZipCode</label></div></td>
    <td><input placeholder="5 digits" id="zipcode_" name="zipcodeNumber" type="text" inputmode="numeric" pattern="[0-9]{5}"  required /></td>
    </tr>

    <tr >
    <td  height="23" style="font-weight: bold"><div  align="right"><label for="state">State</label></div></td>
    <td  ><select id="state_" name="state" required>
        <option ></option>
        <option value="Alabama">Alabama</option>
        <option value="Alaska">Alaska</option>
        <option value="Arizona">Arizona</option>
        <option value="Arkansas">Arkansas</option>
        <option value="California">California</option>
        <option value="Colorado">Colorado</option>
        <option value="Connecticut">Connecticut</option>
        <option value="Delaware">Delaware</option>
        <option value="District of Columbia">District of Columbia</option>
        <option value="Florida">Florida</option>
        <option value="Georgia">Georgia</option>
        <option value="Guam">Guam</option>
        <option value="Hawaii">Hawaii</option>
        <option value="Idaho">Idaho</option>
        <option value="Illinois">Illinois</option>
        <option value="Indiana">Indiana</option>
        <option value="Iowa">Iowa</option>
        <option value="Kansas">Kansas</option>
        <option value="Kentucky">Kentucky</option>
        <option value="Louisiana">Louisiana</option>
        <option value="Maine">Maine</option>
        <option value="Maryland">Maryland</option>
        <option value="Massachusetts">Massachusetts</option>
        <option value="Michigan">Michigan</option>
        <option value="Minnesota">Minnesota</option>
        <option value="Mississippi">Mississippi</option>
        <option value="Missouri">Missouri</option>
        <option value="Montana">Montana</option>
        <option value="Nebraska">Nebraska</option>
        <option value="Nevada">Nevada</option>
        <option value="New Hampshire">New Hampshire</option>
        <option value="New Jersey">New Jersey</option>
        <option value="New Mexico">New Mexico</option>
        <option value="New York">New York</option>
        <option value="North Carolina">North Carolina</option>
        <option value="North Dakota">North Dakota</option>
        <option value="Northern Marianas Islands">Northern Marianas Islands</option>
        <option value="Ohio">Ohio</option>
        <option value="Oklahoma">Oklahoma</option>
        <option value="Oregon">Oregon</option>
        <option value="Pennsylvania">Pennsylvania</option>
        <option value="Puerto Rico">Puerto Rico</option>
        <option value="Rhode Island">Rhode Island</option>
        <option value="South Carolina">South Carolina</option>
        <option value="South Dakota">South Dakota</option>
        <option value="Tennessee">Tennessee</option>
        <option value="Texas">Texas</option>
        <option value="Utah">Utah</option>
        <option value="Vermont">Vermont</option>
        <option value="Virginia">Virginia</option>
        <option value="Virgin Islands">Virgin Islands</option>
        <option value="Washington">Washington</option>
        <option value="West Virginia">West Virginia</option>
        <option value="Wisconsin">Wisconsin</option>
        <option value="Wyoming">Wyoming</option>
        <option value="other">Other</option>
    </select></td>
    
    </tr>


    <tr class= "email_table" id="emailTable_1">
    <td style="font-weight: bold"><div align="right"><label for="email">Email</label></div></td>
    <td><input placeholder="Ex: joe@gatech.edu" name="emails[]" type="email" class="input"  id="email_1" required /></td>
    <!--<td><button onclick="addEmail()" value="addEmail" id="add1"  >add Email</button>-->
    <td><input type="button" onclick="addEmail(this)" value=" add " id="addButton_1"></td>
    <td><input type="button" onclick="removeEmail(this)" value="remove" id="removeButton_1"></td>
    </tr>

    <tr>
    <td height="23"></td>
    <td><div align="center">
       <input type="submit" onclick="window.location.href='register_navigation.php'" name="back" value="Back" />  
    </div></td>
    <td><div>
        <input type="submit" name="submit" value="Register" /></div></td>

    </tr>
    </table>
    </fieldset>
    </form>
  </body>
</html>
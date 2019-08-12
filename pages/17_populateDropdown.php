<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
  include ("../queries/db.php");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
    }
  // get the q parameter from URL
    $q = $_GET['q'];
    $q=trim($q );
    $sql="SELECT * FROM User WHERE Username = '$q' ;";
    $sql2=" SELECT * FROM Employee WHERE Username = '$q' ;";//getemployee id, address..
    $sql3=" SELECT * FROM Site WHERE Username = '$q' ;"; //
    $sql4=" SELECT * FROM Email WHERE Username = '$q' ;"; //
    //echo $sql4;
    $result = mysqli_query($db,$sql);
    $result2 = mysqli_query($db,$sql2);
    $result3 = mysqli_query($db,$sql3);
    $result4 = mysqli_query($db,$sql4);
    $sitename="";
    while($row = mysqli_fetch_array($result)) {
       $firstname= $row['Firstname'] ;
       $lastname=$row['Lastname'];
       $is_visitor=$row['is_visitor'];
    }
    //echo $is_visitor;
    if ($is_visitor=="yes"){
      $checkbox=" <input  name='is_visitor' type='checkbox'  value='$is_visitor' onchange='change(this)' checked >
      <label for='checkbox'>Visitor Account</label> ";
    }
    else{
      $checkbox="<input   type='checkbox'  value='$is_visitor' onchange='change(this)'>
      <label for='checkbox'>Visitor Account</label>";

    }
    while($row = mysqli_fetch_array($result2)) {
        $emp_id=$row['EmployeeID'];
        $address=$row['Address'] . ', ' .$row['City'] .', ' . $row['State'] . ' ' .$row['Zipcode'];
        $phone=$row['Phone'];
    }
    while($row = mysqli_fetch_assoc($result3)){
        $sitename=$row['Site_Name'];
    }

echo "
<table id='table1'>      
      <tr>
        <td  style='font-weight: bold'><div align='right'><label >First Name</label></div></td>
        <td><input name='firstname' type='text' class='input'  value = '$firstname' required /></td>
        <td  style='font-weight: bold'><div align='right'><label >Last Name</label></div></td>
        <td><input name='lastname' type='text' class='input' value='$lastname' required /></td>
      </tr>
      <tr >
        <td  style='font-weight: bold'><div align='right'><label >Username</label></div></td>
        <td><input name='username' type='text' value= $q class='input'   readonly='readonly' style='border:none'/></td>
        <td  style='font-weight: bold'><div align='right'><label >Site Name</label></div></td>
        <td>$sitename</td>
      </tr>

      <tr>
        <td  style='font-weight: bold'><div align='right'><label >EmployeeID</label></div></td>
        <td>$emp_id</td>
        <td  style='font-weight: bold'><div align='right'><label >Phone </label></div></td>
        <td><input name='phone' type='tel'  pattern='[0-9]{10}' value = $phone class='input' required /></td>
      </tr>  

      <tr>
        <td style='font-weight: bold'><div align='right'><label >Address </label></div></td>
        <td>$address</td>
    </tr>

        <tr class= 'email_table' id='emailTable_1'>
          
";   
$count=mysqli_num_rows($result4) ;
while($row = mysqli_fetch_array($result4)){

        //echo $row['Email'];
        $email=$row['Email'];
        echo "
          <td style='font-weight: bold'><div align='right'><label for='email'>Email</label></div></td> 
          <td><input value='$email' name='emails[]' type='email' size='25' id='email_1' required /></td> 
            <td><input type='button' onclick='addEmail(this)'  value='add' id=addButton_1 ></td>
            <td><input type='button' onclick='removeEmail(this)'  value='remove' id=removeButton_1></td>
            </tr>";
    }
echo "</table> ";
echo $checkbox;       
echo  "
<table id='table2'>
        <tr  align='center'>
          <td> <input type='submit' name='submit' value='update'></td></td>
          <td><input type='submit' onclick='history.go(-1)' value='back' ></td></td>
        </tr>
</table> 
";



mysqli_close($db);

        
?>
</body>
</html>
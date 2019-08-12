<!DOCTYPE html>
<html>
<head>
  <title>Screen19:admin manage site</title>
  <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdn.jsdelivr.net/script.js/0.1/script.js">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/screen19.css">
    <link rel="icon" href="data:;base64,=">
</head>
<body>
<fieldset>
  <legend>MANAGE SITE</legend>
    <form method="GET" action="">
  <div id="div1"  style="postion: relative;  width: 200px">
    <label id="siteLable" for ='site'>Site Name</label>
    <select id='siteDroptDown' name='selectedSite'>
      <option value="allSite" id="all">--All--</option>
        <?php
      include('../queries/db.php');
      if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } 
      $sql='SELECT Site_Name from Site;';
      if($result = $db->query($sql)){
          while($row=$result->fetch_assoc()){
            $sitename=$row['Site_Name'];
            echo "<option id='$sitename' value= '$sitename' >$sitename</option>";
          }
          $result->free();
        }
     ?>  
    </select>
    <label id="managerLabel" for ='managerName'>Manager</label>
    <select id='managerDroptDown' name='selectedManager' >
      <option value="allManager">--All--</option>
      <?php
      $sql='SELECT  U.Firstname, U.Lastname,U.Username
            FROM Site as S
            JOIN User as U 
            ON U.Username=S.Username;';
      if($result = $db->query($sql)){
          while($row=$result->fetch_assoc()){
            $name=$row['Firstname']. "   " .$row['Lastname'] ;
            $username=$row['Username'];
            echo "<option id='$username' value= '$username' >$name</option>";
          }
          $result->free();
        }
     ?>
    </select>
    
  </div >

  <div id="div2" >
      <label id ="labelO" for='ifOpen'>Open EveryDay</label> 
      <select name="openEveryday">
        <option value="yes"> Yes </option>
        <option value="no"> No </option>
      </select>
      
  </div>
  <div style="text-align: center;" id="div3">
    <label id="sortLabel" >Sort By</label>
    <select name='sort'  >
        <option></option>
        <option value='S.Site_Name'>Site Name</option>
        <option value='managerName'>Manager Name</option>
        <option value='OpenEveryday'>Open EveryDay</option>            
    </select>
    <label><input type="radio" name="order" value="asc" > Ascending</label>
    <label><input type="radio" name="order" value="desc"> Descending</label>
    <input type="submit"  name='filter' value='FILTER' ></input>
    </div >
  
  <table id="buttonTable" align="center">
    <tr>
      <td><input type="submit" name="create" value="CREATE" ></td>
      <td><input type="submit" name="edit" value="EDIT" ></td>
      <td> <input type='submit' name='delete' value='DELETE'></td></td>
      <td><input type='button' onclick='history.go(-1)' value='back' ></td></td> 
    </tr>
  </table>
<div style="postion: relative;  height: 200px; overflow-y: auto" id="div2" >
    <table id='resultTable' align="center" class="sortable" cellpadding="5" >
      <thead>
         <tr>
          <th></th>
          <th>Name</th>
          <th>Manager</th>
          <th>Open EveryDay</th>
         </tr>
      </thead>
      <tbody>
     <?php 
     session_start();
      function buildTable($sitename, $managerUserName,$openEveryday,$zip,$address,$firstname,$lastname){
          $managerFullName=$firstname. " ".$lastname;
          echo "<tr >   
                    <td><input type='radio'  name='chk' value='$managerUserName;$sitename;$openEveryday;$zip;$address;$firstname;$lastname' ></td> 
                    <td class='col-siteName' value='$sitename'>$sitename</td>
                    <td class='col-managerName' value='$managerUserName'>$managerFullName</td>
                    <td class='col-openEverDay' value='$openEveryday'>$openEveryday</td>
                  </tr>";
        }//end clause for build table
      $msg="";
      if(isset($_GET["filter"])){
        if($_GET['sort']==''){
          $msg .="you have to select the Sort by option";
        }
        else{
          $sort=mysqli_real_escape_string($db,$_GET['sort']);
          $order=mysqli_real_escape_string($db,$_GET['order']);
          $sitename=mysqli_real_escape_string($db,$_GET['selectedSite']);
          $username=mysqli_real_escape_string($db,$_GET['selectedManager']);//what user select
          $open_check=mysqli_real_escape_string($db,$_GET['openEveryday']);
          $sql="SELECT S.Site_Name, S.Address, S.Zipcode,S.OpenEveryday, U.Firstname, U.Lastname, U.Username,CONCAT(U.Firstname,' ', U.Lastname) as 'managerName'
              FROM Site as S
              JOIN User as U 
              ON U.Username=S.Username
              where U.Status='Approved' and U.is_employee='yes' and S.OpenEveryday='$open_check' ";
            if ($sitename=='allSite' && $username=='allManager' ){
              $sql=$sql . "order by $sort $order;";
              //echo $sql;
              if($result = $db->query($sql)){
                while($row=$result->fetch_assoc()){
                  buildTable($row['Site_Name'],$row['Username'],$row['OpenEveryday'],$row['Zipcode'],$row['Address'],$row['Firstname'],$row['Lastname']);  
                }
              }
            }// if chose all option in site name and manager
            if ($sitename !='allSite' && $username=='allManager' ){
              $sql = $sql . "and S.Site_Name= '$sitename' order by $sort $order;";
              if($result = $db->query($sql)){
                while($row=$result->fetch_assoc()){
                  buildTable($row['Site_Name'],$row['Username'],$row['OpenEveryday'],$row['Zipcode'],$row['Address'],$row['Firstname'],$row['Lastname']);  
                }
              }
            }// if site name is selected
            if ($sitename =='allSite' && $username!='allManager' ){
              $sql = $sql . "and U.Username= '$username' order by $sort $order;";
              if($result = $db->query($sql)){
                while($row=$result->fetch_assoc()){
                  buildTable($row['Site_Name'],$row['Username'],$row['OpenEveryday'],$row['Zipcode'],$row['Address'],$row['Firstname'],$row['Lastname']);  
                }
              }
            }//if manager name is selected
            if ($sitename !='allSite' && $username!='allManager' ){
              $sql = $sql . " and S.Site_Name= '$sitename' and U.Username= '$username' order by $sort $order;";
              if($result = $db->query($sql)){
                while($row=$result->fetch_assoc()){
                  buildTable($row['Site_Name'],$row['Username'],$row['OpenEveryday'],$row['Zipcode'],$row['Address'],$row['Firstname'],$row['Lastname']);  
                }
              }
            }
          }//else clause
        }//if filter button is hit
      //if hit create, direct to page 21
      if(isset($_GET["create"]) ){
          header("location: 21_admin_createSite.php");
      } 
      //if hit edit , direct to page 20 after select
      if(isset($_GET["edit"]) && count($_GET['chk'])==0){
        $msg .=" you need to select one row to edit!!!";
      } 
      if(isset($_GET["edit"]) && count($_GET['chk'])==1){
          $_SESSION['page19']=array();
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[0];//username
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[1];//sitename
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[2];//open
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[3];//zipcode
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[4];//address
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[5];//firstname
          $_SESSION['page19'][]=explode(";", $_GET['chk'])[6];//lastname
          header("location: 20_adminEditSite.php?");
      } 
      if(isset($_GET["delete"]) && $_GET['chk']==''){
        $msg .=" you need to select one row to delete!!!";

      } 
      if(isset($_GET["delete"]) && $_GET['chk']!=''){
        $sitename=explode(";", $_GET['chk'])[1];
        $sql="DELETE from Site where Site_Name='$sitename';";
        if($db->query($sql)=== TRUE){
          $msg .= $sitename . " was deleted from Site";
        }else{
          echo "Error deleting record: " .$db->error();
        }
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
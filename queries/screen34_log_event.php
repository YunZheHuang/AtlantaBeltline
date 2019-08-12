<?php
    $host="localhost";
    $port="3306";
    $user="root";
    $password="Database4400";
    $dbname="atlantabeltline";

    $link = mysqli_connect($host,$user,$password,$dbname);

    // Check connections
    if (mysqli_connect_errno())
      {
      echo "----Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $event_name = $_GET["event_name"];
    $site_name = $_GET["site_name"];
    $start_date = $_GET["start_date"];
    $visit_date = $_GET["visit_date"];
    $username = $_GET['username'];

    $sql1 = "select * from atlantabeltline.visitor_visit_event where Event_Name=$event_name and Site_Name=$site_name and StartDate=$start_date and Visit_date=$visit_date"
    $result1 = mysqli_query($link,$sql1);
    $row = mysqli_fetch_assoc($result1);
    if $row['Event_Name'] == null {
        echo "sameday";
    }
    

    $sql = "INSERT INTO visitor_visit_event(Visit_date,Username,Event_Name,StartDate, Site_Name)
                VALUES ('$visit_date','$username','$event_name','$start_date', '$site_name')";
    
    $result = mysqli_query($link,$sql);

    $num = mysqli_affected_rows($link);
    if($num <= 0){
            echo "error";
    }
    mysqli_free_result($result);
    
?>
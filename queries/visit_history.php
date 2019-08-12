<?php
  $host="127.0.0.1:3306";
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

  $site_name = mysqli_real_escape_string($link,$_GET["site_name"]);
  $event_name = $_GET["event_name"];
  $email = $_GET["email"];
  $start_date = $_GET["start_date"];
  $end_date = $_GET["end_date"];
  //$Date = $_GET["Date"];
  //$visit_date = $_GET["visit_date"];
  //$price = $_GET["Price"];
  
  if($site_name == "--ALL--") {
    $site_name = "";
  } else {
    $site_name = " AND B.Site_Name= '$site_name'";
  }

  if($event_name != "") {
    $event_name = " AND B.Event_Name= '$event_name'";
  }

  if($start_date == "YYYY-MM-DD" || $start_date == "") {
    $start_date = "";
  } else {
    $start_date = " AND B.visit_date >= '$start_date'";
  }

  if($end_date == "YYYY-MM-DD" || $end_date == "") {
    $end_date = "";
  } else {
    $end_date = " AND B.visit_date <= '$end_date'";
  }

  $sql = "SELECT Username FROM atlantabeltline.Email WHERE Email = '$email'";
  $result = mysqli_query($link,$sql);
  $row0 = mysqli_fetch_assoc($result);
  $username = $row0["Username"];
  // $username = "visitor1";

  $sql1 = "SELECT DISTINCT B.visit_date, B.Event_Name, B.Site_Name, B.Price FROM
  (SELECT A.Visit_date, A.Event_Name, A.Site_Name, Event.Price, A.Username FROM
  (SELECT visitor_visit_event.Visit_date, visitor_visit_event.Username, visitor_visit_event.Event_Name, visitor_visit_event.Site_Name
  FROM visitor_visit_event
  UNION
  SELECT Visitor_Visit_Site.visit_date, Visitor_Visit_Site.Username, NULL AS Event_Name, Visitor_Visit_Site.Site_Name 
  FROM Visitor_Visit_Site) AS A
  LEFT JOIN Event ON Event.Event_Name=A.Event_Name AND Event.Site_Name=A.Site_Name) AS B
  WHERE B.Username = '$username' $site_name $event_name $start_date $end_date ORDER BY B.visit_date";
  $result1 = mysqli_query($link, $sql1);

  //echo $username;
  $i = 0;
  // echo $site_name;
  while($row = mysqli_fetch_assoc($result1)) 
  {
    if($i == 0)
    {
        echo "{$row["Visit_date"]},{$row["Event_Name"]},{$row["Site_Name"]},{$row["Price"]}";
        $i++;
    }
    else
    {
      echo "|{$row["Visit_date"]},{$row["Event_Name"]},{$row["Site_Name"]},{$row["Price"]}";
    }
  }

  mysqli_free_result($result);
  mysqli_free_result($result1);
  mysqli_close($link);
?>
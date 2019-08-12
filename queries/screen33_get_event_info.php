<?php
    $host="127.0.0.1:3306";
    $port="3306";
    $user="root";
    $password="Database4400";
    $dbname="atlantabeltline";
    //include('db.php')
    $link = mysqli_connect($host,$user,$password,$dbname);

    // Check connections
    if (mysqli_connect_errno())
      {
      echo "----Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $site_name = $_GET["site_name"];
    $event_name = $_GET["event_name"];
    $desc_key = $_GET["desc_key"];
    $low_price = $_GET["low_price"];
    $high_price = $_GET["high_price"];
    $low_visit = $_GET["low_visit"];
    $high_visit = $_GET["high_visit"];
    $start_date = $_GET["start_date"];
    $end_date = $_GET["end_date"];
    $visited = $_GET["visited"];
    $sold_out = $_GET["sold_out"];
    $username = $_GET["username"];
    $sortBy = $_GET['sortBy'];
    $orderBy = $_GET['orderBy'];
    
    if ($sortBy == "eventName") {
        $sortBy= "order by x.Event_Name";
    } else if ($sortBy == "siteName") {
        $sortBy= "order by x.Site_Name";
    } else if ($sortBy == "ticketPrice") {
        $sortBy= "order by x.Price";
    } else if ($sortBy == "totalVisits") {
        $sortBy= "order by x.totalVisits";
    } else if ($sortBy == "myVisits") {
        $sortBy= "order by T.my_visits";
    } else {
        $sortBy="";
    }


    if ($site_name == "--"){
        $site_name = "";
    }
    else{
        $site_name = "and e.Site_name = '$site_name'";
    }
    $event_name = "e.Event_Name like '%$event_name%'";
    
    if ($desc_key != ""){
        $desc_key = "and e.Description like '%$desc_key%'";
    }
    if ($low_price == ""){
        $low_price = "0";
    }
    if ($low_visit == ""){
        $low_visit = "0";
    }
    $date ="";
    if ($start_date != "YYYY-MM-DD" and $start_date != ""  ) {
        $date = "and e.StartDate='$start_date'";
    }
    
    if ($end_date != "YYYY-MM-DD" and $end_date != "" ) {
        $date = $date . " and e.Enddate = '$end_date'";
    }
    
    
    if ($sold_out =="false"){
        $sold_out ="and w.remaining > 0";
    } else {
        $sold_out = "";
    }
    if ($low_visit == '0' and $high_visit == '999999')
        $visits = "";
    else {
        $visits = "where x.total_visits between $low_visit and $high_visit ";
    }
    
  
    $sql = "select x.StartDate, x.Event_Name, x.Site_Name, x.Price, x.Capacity, x.remaining, x.total_visits, T.my_visits from (SELECT e.StartDate, e.Event_Name, e.Site_Name, e.Price, e.capacity, e.Capacity - J.total_visits as 'remaining', J.total_visits From atlantabeltline.event as e left join (select Event_Name, Site_Name, StartDate, count(*) as 'total_visits' from atlantabeltline.visitor_visit_event group by Event_Name,StartDate,Site_Name) as J on J.Event_Name=e.Event_Name and J.StartDate = e.StartDate and J.Site_Name=e.Site_Name where $event_name $site_name $desc_key $date and e.Price between '$low_price' and '$high_price' ) as x left join (select Event_Name,StartDate, Site_Name, count(*) as 'my_visits' from atlantabeltline.visitor_visit_event where Username='$username' group by Event_Name,StartDate,Site_Name) as T on T.Event_Name=x.Event_Name and T.StartDate = x.StartDate and T.Site_Name=x.Site_Name $visits group by x.Event_Name, x.StartDate, x.Site_Name $sortBy $orderBy";

    $result = mysqli_query($link,$sql);
    
   while($row = mysqli_fetch_assoc($result))
   {    
        if ($row['remaining'] == null) {
            $row['remaining'] = $row['capacity'];
            $row['total_visits'] = '0';
        }
        if ($visited == "false"){
        #gonna have to check for value of checkbox
            if ($row['my_visits'] == 0) {
                echo "{$row['Event_Name']},{$row['Site_Name']}, {$row['Price']}, {$row['remaining']}, {$row['total_visits']}, {$row['my_visits']}, {$row['StartDate']} |";
            }
        } else {
            echo "{$row['Event_Name']},{$row['Site_Name']}, {$row['Price']}, {$row['remaining']}, {$row['total_visits']}, {$row['my_visits']}, {$row['StartDate']} |";
        }
        
    }
    mysqli_free_result($result);

?>
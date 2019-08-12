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
    $start_date = $_GET["start_date"];
    $username = $_GET["username"];
   
    $sql = "select *from (SELECT e.StartDate, e.Event_Name, e.Site_Name, e.Price, e.Capacity - count(*) as 'remaining', count(*) as 'total_visits', e.Description, e.EndDate From atlantabeltline.event as e group by e.Event_Name, e.StartDate, e.Site_Name) as w where w.remaining > 0 and w.StartDate= '$start_date' and w.Event_Name='$event_name' and w.site_name='$site_name'";
    
    $result = mysqli_query($link,$sql);
    
       while($row = mysqli_fetch_assoc($result))
       {
            
            {
                echo "{$row['Event_Name']},{$row['Site_Name']}, {$row['StartDate']}, {$row['EndDate']}, {$row['Price']}, {$row['remaining']},{$row['Description']}, {$row['EndDate']}";
                
            }
            
        }
    mysqli_free_result($result);

?>
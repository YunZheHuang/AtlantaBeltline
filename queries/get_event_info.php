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
    $sql = "select * from atlantabeltline.event";
    $result = mysqli_query($link,$sql);
    $i = 0;
       while($row = mysqli_fetch_assoc($result)) 
       {    
            if($i == 0)
            {
                echo "{$row['Event_Name']},{$row['Price']}";
                
                $i++;
            }
            else
            {
                echo "|{$row['Event_Name']}";
            }
        }
    mysqli_free_result($result);

    /*
    if($site_name == "--" and $trans_type == "--ALL--" and $low_price == 0 and $high_price == 10){
        $sql = "SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit JOIN atlantabeltline.Site_Connect_transit
            on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route
            GROUP BY Route,Type;";
        $result = mysqli_query($link,$sql);

    }
    elseif($trans_type == "--ALL--" and $low_price == 0 and $high_price == 10){
        $sql = "SELECT C.Type, C.Route, C.Price, C.number_of_sites FROM
                (SELECT A.Type, A.Route, A.Price, A.number_of_sites, B.Site_Name FROM
                (SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as number_of_sites FROM atlantabeltline.Transit
                JOIN atlantabeltline.Site_Connect_transit
                on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route
                GROUP BY Route,Type) AS A
                JOIN
                (SELECT * FROM atlantabeltline.Transit
                JOIN atlantabeltline.Site_Connect_transit
                USING(Type,Route)
                ) as B
                USING(Type,Route)) AS C
                WHERE C.Site_name = '$site_name'";
        $result = mysqli_query($link,$sql);
*/

?>
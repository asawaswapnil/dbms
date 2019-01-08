<?php
$sdate= $_POST["sdate"];
$edate = $_POST["edate"];
$servername = "localhost";
      $username = "root";
      $password = "mysql";
      $database = "mall";
      $conn = new mysqli($servername, $username, $password, $database);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 
      $sql = "";
      
      switch($_GET[action]){
        case 'annual': $sql = "select distinct substring(date,6,2) as n,sum(total_value) as t from invoice where date>CURRENT_TIMESTAMP - INTERVAL 6 month and date <CURRENT_TIMESTAMP group by substring(date,6,2) order by substring(date,6,2) ASC ";
        break;
 
        default:  $sql = "select distinct substring(date,6,2) as n,sum(total_value) as t from invoice where date>CURRENT_TIMESTAMP - INTERVAL 6 month and date <CURRENT_TIMESTAMP group by substring(date,6,2) order by substring(date,6,2) ASC ";
      }
      $result = $conn->query($sql);
      $output = "letter\tfrequency\n";
      if ($result){
        while($row = $result->fetch_assoc())
        {
            $output .= $row['n']."\t".$row['t']."\n"; 
        }
      }
      $result->free();
      echo $output;
      // Close connection
      mysqli_close($conn);
?>
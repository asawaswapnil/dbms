<?php
			$servername = "localhost";
			$username = "root";
			$password = "mysql";
			$database = "mall";
			$conn = new mysqli($servername, $username, $password, $database);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			
         	$start_date = $_POST["start_date"];
			$end_date = $_POST["end_date"];
			if ($start_date == "") { $start_date='1900-01-01';
			} 
			if ($end_date == "") { $end_date='2200-01-01';
			}
			if ($start_date>$end_date)
 			 {     echo "<a href='http://localhost/profit.html'>end date cannot be smaller than start date. Enter correctly</a>";
 			}
 			else{


			$sql ="call check_total_profit('".$start_date."', '".$end_date."')";
 			 

			$result = $conn->query($sql);
			
      		if($row=$result->fetch_assoc()){
     		 echo "The total profit from: ";
      		echo $start_date;
      		echo " to ";
      		echo $end_date;
      		echo " is ";
      		 foreach($row as $key=>$value)
              {
                echo $value; 
                } 
      		} 
      		else{
      		echo "Nothing found in the time range ";
          	echo $start_date;
          	echo " and ";
          	echo $end_date;
      		}
      	}
  
?>
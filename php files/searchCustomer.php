<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 </head>
 <body>
<?php
			$servername = "localhost";
			$username = "root";
			$password = "mysql";
			$dbname = "mall";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			echo "<p><font color=\"red\">Connected successfully</font></p>";
			// Run a sql
			$name = $_POST["name"];
      $gender = $_POST["Gender"];
if ($name != "") {
        
        $sql = "SELECT *  FROM Customer WHERE  Customer.name like '%$name%' and Customer.gender = '$gender'";
        $result = $conn->query($sql);
        $nrow = $result->num_rows;
        $output = '
                  <br />
                  <h3 align="center">Customer details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Customer Id</th>
                    <th width="10%">Name</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Birthday</th>
                    <th width="10%">Email</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for Customers are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editCustomer.php?ID='.$row["Customer_id"].'">Edit</a></td>
                              <td>'.$row["Customer_id"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["gender"].'</td>
                              <td>'.$row["birthday"].'</td>
                              <td>'.$row["email"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          }
           else {
            echo "no customer found";
          }
 }


 if ($name == "") {
        
        $sql = "SELECT *  FROM Customer order by Customer_id DESC Limit 10";
        $result = $conn->query($sql);
        $nrow = $result->num_rows;
        $output = '
                  <br />
                  <h3 align="center">Customer details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Customer Id</th>
                    <th width="10%">Name</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Birthday</th>
                    <th width="10%">Email</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for Customers are: ";
        echo "<br>";
        while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editCustomer.php?ID='.$row["Customer_id"].'">Edit</a></td>
                              <td>'.$row["Customer_id"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["gender"].'</td>
                              <td>'.$row["birthday"].'</td>
                              <td>'.$row["email"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          }
 }

?>
 </body>
</html>
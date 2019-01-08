
<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
  # code.
			$name = $_POST["name"];
if ($name != "") {
      $sql = "SELECT SUM(invoice.Total_value) as total_consumtion, invoice.Customer_id AS customer_id, customer.name AS name FROM invoice JOIN customer on invoice.Customer_id = customer.Customer_id WHERE customer.name LIKE '%$name%' GROUP by invoice.Customer_id ORDER BY SUM(invoice.Total_value)";
      $result = $conn->query($sql);
      $nrow = $result->num_rows;
      $output = '
                  <br />
                  <h3 align="center">Consumption details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">details</th>
                    <th width="10%">Spending amount</th>
                    <th width="10%">Customer_id</th>
                    <th width="10%">Name</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for customer are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/transactionDetail.php?ID='.$row["customer_id"].'">details</a></td>
                              <td>'.$row["total_consumtion"].'</td>
                              <td>'.$row["customer_id"].'</td>
                              <td>'.$row["name"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no customer is found";
        }
 }
 
 if ($name == "") {
      
        echo "Please enter valid customer name ";
 }
?>
 </body>
</html>
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
	$sql = "call check_productwise_profit('".$start_date."', '".$end_date."')";
	$result = $conn->query($sql);
			
  $output = '';
  if($result){
          $output = '
    <br />
    <h3 align="center">Products Profit</h3>
    <table class="table table-bordered table-striped">
    <tr>
 
      <th width="10%">Product ID</th>
      <th width="10%">Product Name</th>
      <th width="10%">Average Supply Price</th>
      <th width="20%">Average Selling Price</th>
      <th width="20%">Quantity</th>
      <th width="10%">Total Profit</th>
    </tr>
    ';
       while($row = $result->fetch_assoc())
        {

          $output .= '
        <tr>
    
        <td >'.$row["Product_id"].'</td>
        <td >'.$row["Product_name"].'</td>
        <td >'.$row["average_cost_price"].'</td>
        <td >'.$row["round(avg_selling_price,2)"].'</td>
        <td >'.$row["quantity_sold_between_given_date"].'</td>
        <td >'.$row["product_total_profit"].'</td>
    
     
        </tr>
      ';
         }
        $output .= '</table>';
        echo $output;
        } else {
          echo "no product found in the time range ";
          echo $start_date;
          echo " and ";
          echo $end_date;
        }

 
?>

 </body>
</html>
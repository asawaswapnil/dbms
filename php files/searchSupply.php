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
		
      $output = '';
			$content = $_POST["content"];
      $sql = "SELECT *  FROM Supply WHERE Product_id like '%$content%' or Supplier_id like '%$content%' or Supply.date like '%$content%'";
      $result = $conn->query($sql);
      if($result){
    $output = '
    <br />
    <h3 align="center">Supply</h3>
    <table class="table table-bordered table-striped">
    <tr>

      <th width="10%">Supply ID</th>
      <th width="20%">Supplier ID</th>
      <th width="10%">Product ID</th>
      <th width="20%">Supply Amount</th>
      <th width="20%">Price</th>
      <th width="10%">Date</th>
    </tr>
    ';
       while($row = $result->fetch_assoc())
        {

          $output .= '
        <tr>
 
        <td align="center">'.$row["Supply_id"].'</td>
        <td align="center">'.$row["Supplier_id"].'</td>
        <td align="center">'.$row["Product_id"].'</td>
        <td align="center">'.$row["Sup_amount"].'</td>
        <td align="center">'.$row["Price"].'</td>
        <td align="center">'.$row["date"].'</td>
        
        </tr>
      ';
         }
        $output .= '</table>';
        echo $output;




        } else {
          echo "no Supply found";
        }
 
?>
 </body>
</html>
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
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
      $output = '';
			
      $sql = "SELECT *  FROM supplier";
      $result = $conn->query($sql);
      if($result){
            $output = '
    <br />
    <h3 align="center">Supplier</h3>
    <table class="table table-bordered table-striped">
    <tr>
      <th width="10%"></th>
      <th width="10%">Product ID</th>
      <th align="center" width="20%">Name</th>
    </tr>
    ';
       while($row = $result->fetch_assoc())
        {

          $output .= '
        <tr>
        <td><a href="editSupplier.php?ID='.$row["id"].'"">Edit</a></td>
        <td >'.$row["id"].'</td>
        <td >'.$row["name"].'</td>
    
        
        </tr>
      ';
         }
        $output .= '</table>';
        echo $output;

      
        } else {
          echo "no supplier found";
        }
 
?>
 </body>
</html>
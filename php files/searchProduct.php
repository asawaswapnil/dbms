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
      $output = '';
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
		
			// Run a sql
			$content = $_POST["content"];
      echo $content;

      $sql = "SELECT *  FROM Product WHERE Product_name like '%$content%' or Brand like '%$content%'" ;
      $result = $conn->query($sql);
      if($result){
        $output = '
    <br />
    <h3 align="center">Products</h3>
    <table class="table table-bordered table-striped">
    <tr>
      <th width="10%"></th>
      <th width="10%">Product ID</th>
      <th align="center" width="20%">Name</th>
      <th width="10%">Inventory</th>
      <th width="20%">Price</th>
      <th width="20%">Brand</th>
      <th width="10%">Department ID</th>
    </tr>
    ';
       while($row = $result->fetch_assoc())
        {

          $output .= '
        <tr>
        <td><a href="editProduct.php?ID='.$row["Product_id"].'"">Edit</a></td>
        <td align="center">'.$row["Product_id"].'</td>
        <td align="center">'.$row["Product_name"].'</td>
        <td align="center">'.$row["Inventory"].'</td>
        <td align="center">'.$row["Price"].'</td>
        <td align="center">'.$row["Brand"].'</td>
        <td align="center">'.$row["Department_id"].'</td>
        
        </tr>
      ';
         }
        $output .= '</table>';
        echo $output;
    
             
        } else {
          echo "no Supplier found";
        }
?>
 </body>
</html>
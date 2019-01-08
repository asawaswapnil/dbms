<html>
	<body>
		Add new Product:
		<?php
			// Create connection
			$servername = "localhost";
			$username = "root";
			$password = "mysql";
			$database = "mall";
			$conn = new mysqli($servername, $username, $password, $database);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
		
         	
         	$name = $_POST["Product_name"];
			$inv = $_POST["Inventory"];
			$price = $_POST["Price"];
			$brand = $_POST["Brand"];
			$did = $_POST["Department_id"];
			// 

			$sql = "INSERT INTO Product (Product_name, Inventory, Price, Brand,Department_id)  VALUES ('$name', $inv , $price, '$brand', $did)";
			//product id is auto incremented in the database and doesnot need to be explicity mentioned.

			if (mysqli_query($conn, $sql)) {
    			echo "New  Product record created successfully";
    			echo "<br>";
      		    echo "<a href='mainpage.php'>return to main page</a>\n";
      			echo "<br>";
      			echo "<a href='productManagement.html'>Add more products</a>";
      			}else {
   				 echo "Error updating record: " . $conn->error;
   				 echo "<br>";}
			// Close connection
			mysqli_close($conn);
		?>
	</body>
</html>
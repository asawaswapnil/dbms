<html>
	<body>
		<h3>update product's information:</h3>
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
			$ID = $_GET["ID"];
			$sql = "SELECT * FROM Product WHERE Product_id = $ID";
			$result = $conn->query($sql);
			$output = $result->fetch_assoc();		
		?>

	<form name="editProductInput" action="updateProduct.php" method="POST">
			<input type="hidden" name="ID" value="<?php echo $output['Product_id'];?>"><br><br>
			Name:<br><input type="text" name="Name" value="<?php echo $output['Product_name'];?>"><br><br>
			Inventory:<br><input type="text" name="Inventory" value="<?php echo $output['Inventory'];?>"><br><br>
			<input type="hidden" name="brand" value="<?php echo $output['Brand'];?>"><br><br>
			Price:<br><input type="text" name="Price" value="<?php echo $output['Price'];?>"><br><br>
			<input type="hidden" name="Department_id" value="<?php echo $output['Department_id'];?>"><br><br>
			<input type="submit" value="submit">
		</form>
	</body>
</html>
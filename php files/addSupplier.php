<html>
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

			$Name = $_POST["name"];
			if ($Name == "") {
				echo "<a href='http://localhost/supplierManagement.html'>No name entered. Enter supplier name</a>";
				exit();
			} 
			// Generate sql
			$sql = "INSERT INTO supplier (name)  VALUES ('$Name')";
		
			
         
			// Run a sql
			#$result = $conn->query($sql);
			if (mysqli_query($conn, $sql)) {
    			echo "New  customer record created successfully";
    			echo "<br>";
			echo  "<td><a href='selectSupplier.php?'>See all the suppliers</a>";
			echo "<br>";
			echo "<td><a href='mainPage.php?'>Go to main page</a>";
			echo "<br>";
			echo "<td><a href='supplierManagement.HTML'>Go to Supplier Management</a>";}
			
			else {echo "something went wrong. Try again. If the problem persists, contact customer care. ";}
			mysqli_close($conn);
		?>
	</body>
</html>
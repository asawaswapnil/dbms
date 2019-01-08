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
			$ID = $_POST["ID"];
			$Name = $_POST["Name"];
			$sql = "UPDATE supplier set name = '$Name' where id = '$ID' ";
			
			if ($Name=="" )
			{ 
			echo "<a href='http://localhost/supplierManagement.html'>Enter Name correctly<br></a>";
			}
			
			 
			if (mysqli_query($conn, $sql)) {	
			echo "Record update successfully";
			echo "<br>";
			echo  "<td><a href='selectSupplier.php?'>See all the suppliers</a>";
			echo "<br>";
			echo "<td><a href='main_page.php?'>Go to main page</a>";
			echo "<br>";
			echo "<td><a href='supplierManagement.HTML'>Go to Supplier Management</a>";

			
			echo "<br>";
   			} else {
   				 echo "Error updating record: " . $conn->error;
   				 echo "<br>";}
   			
?>
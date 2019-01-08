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
			$department_id = $_POST["Department_id"];
			$Name = $_POST["Name"];
			$Inventory= $_POST["Inventory"];
			$Brand = $_POST["brand"];
			$Price = $_POST["Price"];
			if ($Price=="" )
			{ 
			echo "<a href='http://localhost/productManagement.html'>Enter Price correctly</a>";
			}
			if ($Inventory=="" )
			{ 
			echo "<a href='http://localhost/productManagement.html'>Enter Inventory correctly<br></a>";
			}
			 if ($Name=="" )
			{ 
			echo "<a href='http://localhost/productManagement.html'>Enter Name correctly<br> </a>";
			}
			 

			$sql = "UPDATE Product set Product_name = '$Name', Department_id = $department_id, Inventory=$Inventory , Brand = '$Brand', Price = $Price WHERE Product_id = '$ID'";
			
			if (mysqli_query($conn, $sql)) {	
			echo "Record update successfully";
			echo "<br>";
			echo  "<td><a href='searchProduct.php?'>See the products</a>";
						echo "<br>";

			echo "<td><a href='main_page.php?'>Go to main page</a>";
						echo "<br>";

			echo "<td><a href='productManagement.HTML'>Go to Product Management</a>";

			
			echo "<br>";
   			} else {
   				 echo "Error updating record: " . $conn->error;
   				 echo "<br>";}
   			
?>
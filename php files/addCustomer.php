<html>
	<body>
		Add new Customer:
		<?php
			$Name = $_POST["name"];
			$Gender = $_POST["Gender"];
			$Birthday = $_POST["Birthday"];
			$Email = $_POST["email"];
			if ($Name == "") {
				echo "<a href='http://localhost/Customer management.html'>reenter customer name</a>";
				exit();
			} 
			if ($Email != "" && (!strpos($Email, "@") || !strpos($Email, ".com"))) {
				echo "<a href='http://localhost/Customer management.html'>reenter valid email address</a>";
				exit();
			}
			// Generate sql
			$sql = "INSERT INTO Customer (name, gender, birthday, email)  VALUES ('$Name', '$Gender', '$Birthday', '$Email')";
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
			echo "<p><font color=\"red\">Connected successfully</font></p>";
         
			// Run a sql
			#$result = $conn->query($sql);
			if (mysqli_query($conn, $sql)) {
    			echo "New  customer record created successfully";
    			echo "<br>";
      		    echo "<a href='http://localhost/Customer management.html'>return to management page</a>";
      		}else{
      			echo "<a href='http://localhost/Customer management.html'>Try again</a>";
      			echo "<br>";
       		   	echo "Error: " . $sql . "<br>" . mysqli_error($conn);}
			// Close connection
			mysqli_close($conn);
		?>
	</body>
</html>
<html>
	<body>
		Add a new Department:
		<?php
			$Name = $_POST["name"];
			if ($Name == "") {
				echo "<a href='http://localhost/department_management.html'>reenter department's name</a>";
				exit();
			} 
			// Generate sql
			$sql = "INSERT INTO Department (name)  VALUES ('$Name')";
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
    			echo "New  Department record created successfully";
    			echo "<br>";
      		    echo "<a href='http://localhost/department_management.html'>return to management Department</a>";
      		}else{
      			echo "<a href='http://localhost/department_management.html'>Try again</a>";
      			echo "<br>";
       		   	echo "Error: " . $sql . "<br>" . mysqli_error($conn);}
			// Close connection
			mysqli_close($conn);
		?>
	</body>
</html>
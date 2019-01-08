<html>
	<body>
		Add new Salesman:
		<?php
			$Name = $_POST["name"];
			$department_id = $_POST["department_id"];
			$Gender = $_POST["Gender"];
			$Birthday = $_POST["birthday"];
			$Start_working_date = $_POST["start_working_date"];
			if ($Name == "") {
				echo "<a href='http://localhost/salesman_management.html'>reenter Salesman's name</a>";
				exit();
			} 
			if (!$department_id) {
				echo "<a href='http://localhost/Customer management.html'>reenter valid Department id</a>";
				exit();
			}
			// Generate sql
			$sql = "INSERT INTO Salesman (name, department_id, gender, birthday, start_working_date)  VALUES ('$Name', '$department_id', '$Gender', '$Birthday', '$Start_working_date')";
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
    			echo "New  salesman record created successfully";
    			echo "<br>";
      		    echo "<a href='http://localhost/salesman_management.html'>return to management page</a>";
      		}else{
      			echo "<a href='http://localhost/salesman_management.html'>Try again</a>";
      			echo "<br>";
       		   	echo "Please enter valid department ID";}
			// Close connection
			mysqli_close($conn);
		?>
	</body>
</html>
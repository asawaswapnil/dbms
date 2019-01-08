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
			$department_id = $_POST["department_id"];
			$Name = $_POST["Name"];
			$Gender = $_POST["gender"];
			$birthday = $_POST["birthday"];
			$start = $_POST["start_working_date"];
			echo "$ID";
			$sql = "UPDATE Salesman set name = '$Name', department_id = $department_id, gender = '$Gender', birthday = $birthday, start_working_date = $start WHERE id = '$ID'";
			
			if (mysqli_query($conn, $sql)) {	
			echo "Record update successfully";
			echo "<br>";
   			} else {
   				 echo "Error updating record: " . $conn->error;
   				 echo "<br>";}
   			
?>
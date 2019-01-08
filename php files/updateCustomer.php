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
			$Gender = $_POST["gender"];
			$birthday = $_POST["birthday"];
			$email = $_POST["email"];
			echo "$ID";
			$sql = "UPDATE Customer set name = '$Name', gender = '$Gender', birthday = $birthday, email = '$email' WHERE Customer_id = '$ID'";
			
			if (mysqli_query($conn, $sql)) {	
			echo "Record update successfully";
			echo "<br>";
   			} else {
   				 echo "Error updating record: " . $conn->error;
   				 echo "<br>";}
   			
?>
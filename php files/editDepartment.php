<html>
	<body>
		update Department's information:
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
			$sql = "SELECT * FROM Department WHERE id = $ID";
			$result = $conn->query($sql);
			$output = $result->fetch_assoc();		
		?>

	<form name="editDepartmentInput" action="updateDepartment.php" method="POST">
			<input type="hidden" name="ID" value="<?php echo $output['id'];?>"><br><br>
			Name:<input type="text" name="Name" value="<?php echo $output['name'];?>"><br><br>
			<input type="submit" value="submit">
		</form>
	</body>
</html>
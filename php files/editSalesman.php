<html>
	<body>
		update Saleman's information:
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
			$sql = "SELECT * FROM Salesman WHERE id = $ID";
			$result = $conn->query($sql);
			$output = $result->fetch_assoc();		
		?>

	<form name="editSalesmanrInput" action="updateSalesman.php" method="POST">
			<input type="hidden" name="ID" value="<?php echo $output['id'];?>"><br><br>
			department_id:<input type="int" name="department_id" value="<?php echo $output['department_id'];?>"><br><br>
			Name:<input type="text" name="Name" value="<?php echo $output['name'];?>"><br><br>
			Gender: <select name="gender"><br>
					<option value="<?php echo $output['gender'];?>"><?php echo $output['gender'];?></option>
  					<option value="Male">Male</option>
  					<option value="Female">Female</option>
					</select><br><br>
			Birthday:<input type="date" name="birthday" value="<?php echo $output['birthday'];?>"><br><br>
			start_working_date:<input type="date" name="start_working_date" value="<?php echo $output['start_working_date'];?>"><br><br>
			<input type="submit" value="submit">
		</form>
	</body>
</html>
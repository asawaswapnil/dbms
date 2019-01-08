<html>
	<body>
		<?php
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
			
         	


         	$sid = $_POST["Supplier_id"];
			$pid = $_POST["Product_id"];
			$qty = $_POST["Sup_amount"];
			$price = $_POST["Price"];
			$date = $_POST["date"];
			
			$sqls= "select * from supplier where id='$sid'";
			$sqlp= "select * from Product where Product_id='$pid'";
			if (!(mysqli_query($conn, $sqls)))
			{ echo "No Supplier_id found";
			echo "<a href='http://localhost/supplyManagement.html'>Reneter details correctly</a>";
			}
			else if ($sid=="")
			{ 
			echo "<a href='http://localhost/supplyManagement.html'>Enter Supplier_id correctly</a>";
			}
			 else if (!(mysqli_query($conn, $sqlp)))
			{ echo "No Product_id found";
			echo "<a href='http://localhost/supplyManagement.html'>Reneter details correctly</a>";
			}
			
			else if ($pid=="")
			{ 
			echo "<a href='http://localhost/supplyManagement.html'>Enter product_id correctly</a>";
			}
			else if ($qty=="")
			{ 
			echo "<a href='http://localhost/supplyManagement.html'>Enter qunatity correctly</a>";
			}
			else if ($price=="" or $price<'0')
			{ 
			echo "<a href='http://localhost/supplyManagement.html'>Enter correct price</a>";
			}
			else if ($date=="" )	
			{ 
			echo "<a href='http://localhost/supplyManagement.html'>Enter date correctly</a>";
			}
			else
			{
				$sql = "INSERT INTO Supply (Supplier_id, Product_id, Sup_amount, Price,date)  VALUES ($sid, $pid , $qty, $price, '$date')";
				//product id is auto incremented in the database and doesnot need to be explicity mentioned.

				if (mysqli_query($conn, $sql)) 
					{
	    			echo "New Supply record created successfully";
	    			echo "<br>";
	      		    echo "<a href='mainpage.php'>return to main page</a>\n";
	      			echo "<br>";
	      			echo "<a href='supplyManagement.html'>Add more Supplies</a>";
	      			}
	      		else {echo "something went wrong. Try again. If the problem persists, contact customer care. ";}
			}
			// Close connection
			mysqli_close($conn);
		?>
	</body>
</html>
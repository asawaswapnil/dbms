<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 </head>
 <body>
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
  # code.
			$name = $_POST["name"];
if ($name != "") {
      $sql = "SELECT *  FROM Department WHERE  Department.name like '%$name%'";
      $result = $conn->query($sql);
      $nrow = $result->num_rows;
      $output = '
                  <br />
                  <h3 align="center">Department details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Department Id</th>
                    <th width="10%">Name</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for department are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editDepartment.php?ID='.$row["id"].'">Edit</a></td>
                              <td>'.$row["id"].'</td>
                              <td>'.$row["name"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no deparment is found";
        }
 }
 
 if ($name == "") {
      $sql = "SELECT *  FROM Department ";
      $result = $conn->query($sql);
      $nrow = $result->num_rows;
      $output = '
                  <br />
                  <h3 align="center">Department details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Department Id</th>
                    <th width="10%">Name</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for departments are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editDepartment.php?ID='.$row["id"].'">Edit</a></td>
                              <td>'.$row["id"].'</td>
                              <td>'.$row["name"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no deparment is found";
        }
 }
?>
 </body>
</html>
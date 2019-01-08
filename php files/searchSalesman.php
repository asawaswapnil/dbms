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
			$name = $_POST["name"];
      $gender = $_POST["Gender"];
if ($name != "") {
        $sql = "SELECT *  FROM Salesman WHERE  Salesman.name like '%$name%' and Salesman.gender = '$gender'";
        $result = $conn->query($sql);
        $nrow = $result->num_rows;
        $output = '
                  <br />
                  <h3 align="center">Salesman details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Salesman Id</th>
                    <th width="10%">Name</th>
                    <th width="10%">Department Id</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Birthday</th>
                    <th width="10%">Start Working date</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for Salesmen are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editSalesman.php?ID='.$row["id"].'">Edit</a></td>
                              <td>'.$row["id"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["department_id"].'</td>
                              <td>'.$row["gender"].'</td>
                              <td>'.$row["birthday"].'</td>
                              <td>'.$row["start_working_date"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no salesman found";
        }
 }


 if ($name == "") {
        $sql = "SELECT *  FROM Salesman order by id DESC limit 10";
        $result = $conn->query($sql);
        $nrow = $result->num_rows;
        $output = '
                  <br />
                  <h3 align="center">Salesman details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">Edit</th>
                    <th width="10%">Salesman Id</th>
                    <th width="10%">Name</th>
                    <th width="10%">Department Id</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Birthday</th>
                    <th width="10%">Start Working date</th>
                   </tr>
                  ';
        if($nrow){
        echo "The details for Salesmen are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td><a href="http://localhost/editSalesman.php?ID='.$row["id"].'">Edit</a></td>
                              <td>'.$row["id"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["department_id"].'</td>
                              <td>'.$row["gender"].'</td>
                              <td>'.$row["birthday"].'</td>
                              <td>'.$row["start_working_date"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no salesman found";
        }
 }
?>
 </body>
</html>
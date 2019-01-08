<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>

  <div class="container">
   <br /> 
   <h3 align="left">Create New Transaction</h3>
   <br /> 
   <form name="addTransaction" action="transaction.php" method="POST"><br>
      CustomerID:<input type="text" name="Customer_ID"><span class="error">* </span><br><br>
      SalesmanID:<input type="text" name="Salesman_ID"><span class="error">* </span><br><br>
      <input type="submit" value="Create Order"><br><br><br><br>
    </form>

    <h3 align="left">Review Transacitons</h3>
    <form name="reviewTransaction" action="" method="POST"><br>
      Invoice:<input type="text" name="Invoice_ID">
      
      <input type="submit" value="Search Order"><br><br>
    </form>
    </html>
     <?php
      $servername = "localhost";
      $username = "root";
      $password = "mysql";
      $database = "mall";
      $conn = new mysqli($servername, $username, $password, $database);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 
      $invoiceid = $_POST["Invoice_ID"];

 
      if ($invoiceid=='' ){ }else{
      $sql2 = "SELECT * from invoice where Invoice_id=$invoiceid"; 
     

      $result2 = $conn->query($sql2);
      $nrow2 = $result2->num_rows;
      if ($nrow2==0){print "<script language=\"JavaScript\">\r\n";
print " alert(\"Invoice not exist!\");\r\n";
print " history.back();\r\n";
print "</script>";
exit;}
      else  
      {
       $output = '
    <br />
    <h3 align="left">Invoice Detail</h3>
    <table class="table table-bordered table-striped">
    <tr>
      <th width="20%">Invoice ID</th>
      <th width="20%">Customer</th>
      <th width="20%">Total value</th>
      <th width="20%">Salesman</th>
      <th width="20%">Date</th>
    </tr>
    ';
       while($row = $result2->fetch_assoc())
        {

          $output .= '
        <tr>
        <td align="center">'.$row["Invoice_id"].'</td>
        <td align="center">'.$row["Customer_id"].'</td>
        <td align="center">'.$row["Total_value"].'</td>
        <td align="center">'.$row["salesman_id"].'</td>
        <td align="center">'.$row["date"].'</td>
        <td><a href="http://localhost/ReviewTransaction.php?ID='.$row["Invoice_id"].'&page=1">View</a></td>
        </tr>
      ';
         }
        $output .= '</table>';
        echo $output;
       }
   }
    ?>


     

  
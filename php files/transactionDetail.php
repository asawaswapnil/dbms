
<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
			$ID = $_GET["ID"];
      $sql = "SELECT pro_invoice.product_id, Product.Product_name, Product.Brand, Product.Price, pro_invoice.Product_number, pro_invoice.Discount, Product.Price*pro_invoice.Product_number*pro_invoice.Discount as total ,invoice.date FROM Product, pro_invoice, customer, invoice WHERE customer.Customer_id = invoice.Customer_id AND invoice.Invoice_id = pro_invoice.invoice_id AND pro_invoice.product_id = Product.Product_id AND customer.Customer_id = $ID";
      $result = $conn->query($sql);
      $nrow = $result->num_rows;
      $output = '
                  <br />
                  <h3 align="center">Consumption details</h3>
                  <table class="table table-bordered table-striped">
                   <tr>
                    <th width="10%">product id</th>
                    <th width="10%">product name</th>
                    <th width="10%">brand</th>
                    <th width="10%">price</th>
                    <th width="10%">number</th>
                    <th width="10%">discount</th>
                    <th width="10%">total money</th>
                    <th width="10%">date</th>
                   </tr>
                  ';
        if($nrow){
        echo "The transaction details for customer are: ";
        echo "<br>";
          while($row =  mysqli_fetch_array($result))
              {  
                 $output .= '
                             <tr>
                              <td>'.$row["product_id"].'</td>
                              <td>'.$row["Product_name"].'</td>
                              <td>'.$row["Brand"].'</td>
                              <td>'.$row["Price"].'</td>
                              <td>'.$row["Product_number"].'</td>
                              <td>'.$row["Discount"].'</td>
                              <td>'.$row["total"].'</td>
                              <td>'.$row["date"].'</td>
                             </tr>';
            }
            $output .= '</table>';
            echo $output;
          } else {
            echo "no detail is found";
        }
 
?>
 </body>
</html>
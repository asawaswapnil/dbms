<!DOCTYPE html>
<html>
 <head>
  <title>welcome</title>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>

 <?php
 $rid=$_GET['ID'];
$connect = mysqli_connect("localhost", "root", "mysql", "mall");
$output = '';
$query = "SELECT * FROM pro_invoice where invoice_id=$rid";
$result = mysqli_query($connect, $query);

$output = '
<br />
<h3 align="center">Order Detail</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20">Invoice_id</th>
  <th width="20">Product_id</th>
  <th width="20">Quantity</th>
  <th width="20">Discount</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["invoice_id"].'</td>
  <td>'.$row["product_id"].'</td>
  <td>'.$row["Product_number"].'</td>
  <td>'.$row["Discount"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>



   <br><br><h3 align="left">Update Order</h3>
   <br /> 
   <form name="editTransaction" action="" method="POST"><br>
      Product ID:<input type="text" name="PID">  
      Quantity:<input type="text" name="QTY">  
      Discount:<input type="text" name="DIS">  
      <input type="submit" value="Add Transaction"><br><br><br><br>
    </form>
	<?php
 	$pid=$_POST['PID'];
 	$qty=$_POST['QTY'];
 	$dis=$_POST['DIS'];
	$connect = mysqli_connect("localhost", "root", "mysql", "mall");

	$query2 = "INSERT INTO pro_invoice(invoice_id, product_id, Product_number, Discount) VALUES($rid,$pid,$qty,$dis)";
	$result2 = mysqli_query($connect, $query2);
	$query3="update product set inventory=inventory-$qty where Product_id=$pid";
	$result3 = $connect->query($query3);

    $query4="select sum(pi.product_number*p.price*pi.discount) as total from pro_invoice pi join Product p on pi.product_id=p.product_id join invoice i on i.invoice_id=pi.invoice_id where pi.invoice_id=$rid";
    $result4 = $connect->query($query4);
    $data4 = $result4->fetch_assoc(); 
    $total=$data4['total'];
    $query7="update invoice set total_value=$total where invoice_id=$rid";
    $result7 = $connect->query($query7);
    $query6="select total_value from invoice where invoice_id=$rid";
    $result6 = $connect->query($query6);
    $data6 = $result6->fetch_assoc();
     
    echo "Total value of order NO.".$rid;
    echo " is " .$data6['total_value'];

?>



</html>
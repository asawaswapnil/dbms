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
$query = "call restock";
$result = mysqli_query($connect, $query);
$output = '
<br />
<h3 align="center">Restock</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="10%">Product_id</th>
  <th width="10%">Inventory level</th>
  <th width="10%">Safety Stock</th>
  <th width="20%"></th>
  <th width="50%">Replenshment</th>
 </tr>
';
$query2 = "update product set inventory=1001 where product_id=1";
$result2 = mysqli_query($connect, $query2);
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["product_id"].'</td>
  <td>'.$row["inventory"].'</td>
  <td>'.$row["safety_stock"].'</td>
  <td>low stock level</td>
  <td>'.$row["safety_stock"].'</td>
  <td></td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>
</html>
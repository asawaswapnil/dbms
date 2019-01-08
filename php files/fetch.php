<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "mysql", "mall");
$output = '';
$query = "SELECT * FROM pro_invoice ORDER BY invoice_id DESC limit 20";
$result = mysqli_query($connect, $query);
$output = '
<br />
<h3 align="center">Transaction History</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">Invoice_id</th>
  <th width="20%">Product_id</th>
  <th width="20%">Quantity</th>
  <th width="20%">Discount</th>
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
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
			$sdate= $_POST["sdate"];
			$edate = $_POST["edate"];
$connect = mysqli_connect("localhost", "root", "mysql", "mall");
$output = '';
$query = "call hottest('$sdate','$edate')";
$result = mysqli_query($connect, $query);
$count=1;
$nrow = $result->num_rows;
if($sdate=="" || $edate==""){print "<script language=\"JavaScript\">\r\n";
print " alert(\"Please input start date and end date.\");\r\n";
print " history.back();\r\n";
print "</script>";
exit;}else{
if($nrow>0){
$output = '
<br />
<h3 align="center">Best Seller from '.$sdate.' to '.$edate.'</h3>
<table class="table table-bordered table-striped">
 <tr>
   <th width="20%">Ranking</th>
  <th width="20%">Product</th>
  <th width="20%">Quantity of Sales</th>

 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
 <td>'.$count.'</td>
  <td>'.$row["product_name"].'</td>
  <td>'.$row["count"].'</td>
 </tr>
 ';
$count=$count+1;}
$output .= '</table>';
echo $output;
echo "<br><br><a href='http://localhost/mainPage.php'>Back</a>";
}else{echo "There is no sales record in period $sdate to $edate";echo "<br><br><a href='http://localhost/mainPage.php'>Back</a>";}
}
?>

 </body>
</html>
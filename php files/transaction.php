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

     <?php
      $servername = "localhost";
      $username = "root";
      $password = "mysql";
      $database = "mall";
      $conn = new mysqli($servername, $username, $password, $database);
     if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
     } 
     $customerid = $_POST["Customer_ID"];
     $salesmanid = $_POST["Salesman_ID"];
    $sql = "SELECT * from customer where Customer_id=$customerid"; 
    $result = $conn->query($sql);
    $nrow = $result->num_rows;
    $sql3 = "SELECT * from salesman where id=$salesmanid"; 
    $result3 = $conn->query($sql3);
    $nrow3 = $result3->num_rows;

  if ($customerid=='' or $salesmanid=='' ){ print "<script language=\"JavaScript\">\r\n";
print " alert(\"Please input Customer ID and Salesman ID.\");\r\n";
print " history.back();\r\n";
print "</script>";
exit;}elseif($nrow==0 or $nrow3==0){print "<script language=\"JavaScript\">\r\n";
print " alert(\"Customer ID or Salesman ID not exist!\");\r\n";
print " history.back();\r\n";
print "</script>";
exit;}
else{

      $sql2 = "Insert into invoice(Customer_id,total_value,salesman_id,date) values($customerid,0,$salesmanid,now() )";

      
      $result2 = $conn->query($sql2);
      $query5="select invoice_id from invoice order by invoice_id Desc limit 1";
      $result5 = $conn->query($query5);
      $data5 = $result5->fetch_assoc(); 
      $invoiceid=$data5['invoice_id'];

      
      if ($result)
      {
       $output = '
    <br />
    <h3 align="center">Customer Info</h3>
    <table class="table table-bordered table-striped">
    <tr>
      <th width="20%">Customer id</th>
      <th width="30%">name</th>
      <th width="10%">Gender</th>
      <th width="10%">birthday</th>
      <th width="30%">Email</th>
    </tr>
    ';
       while($row = $result->fetch_assoc())
        {

          $output .= '
      <tr>
        <td>'.$row["Customer_id"].'</td>
       <td>'.$row["name"].'</td>
        <td>'.$row["gender"].'</td>
        <td>'.$row["birthday"].'</td>
        <td>'.$row["email"].'</td>
      </tr>
      ';
         }
        $output .= '</table>';
    echo $output;
     $output2 = '
    <br />
    <h3 align="center">Salesman Info</h3>
    <table class="table table-bordered table-striped">
    <tr>
      <th width="20%">Salesman ID</th>
      <th width="20%">name</th>
      <th width="10%">Department ID</th>
      <th width="10%">Gender</th>
      <th width="20%">Birthday</th>
      <th width="20%">Start working from</th>
    </tr>
    ';
       while($row3 = $result3->fetch_assoc())
        {

          $output2 .= '
      <tr>
        <td>'.$row3["id"].'</td>
       <td>'.$row3["name"].'</td>
        <td>'.$row3["department_id"].'</td>
        <td>'.$row3["gender"].'</td>
        <td>'.$row3["birthday"].'</td>
        <td>'.$row3["start_working_date"].'</td>
      </tr>
      ';
         }
        $output2 .= '</table>';
    echo $output2;
       }
   }
    ?>

    <html>
    <div class="table-responsive">
    <table class="table table-bordered" id="crud_table">
      <br>
  <h3 align="center">Input Detail for Order No.<?php echo $invoiceid; ?></h3>
     <tr>

      <th width="10%">Product ID</th>
      <th width="30%">Quantity </th>
      <th width="10%">Discount</th>
      <th width="5%"></th>
     </tr>
     <tr>

      <td contenteditable="true" class="item_code"></td>
      <td contenteditable="true" class="item_desc"></td>
      <td contenteditable="true" class="item_price"></td>
      <td></td>
     </tr>
    </table>
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
    </div>
    <div align="center">
     <button type="button" name="save" id="save" class="btn btn-info">Save</button>
    </div>
    <br />

    <div id="inserted_item_data"></div>
   </div>
   
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";

   html_code += "<td contenteditable='true' class='item_code'></td>";
   html_code += "<td contenteditable='true' class='item_desc'></td>";
   html_code += "<td contenteditable='true' class='item_price' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>Delete</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){

  var item_code = [];
  var item_desc = [];
  var item_price = [];

  $('.item_code').each(function(){
   item_code.push($(this).text());
  });
  $('.item_desc').each(function(){
   item_desc.push($(this).text());
  });
  $('.item_price').each(function(){
   item_price.push($(this).text());
  });
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:{item_code:item_code, item_desc:item_desc, item_price:item_price},
   success:function(data){
    alert(data);
    $("td[contentEditable='true']").text("");
    for(var i=2; i<= count; i++)
    {
     $('tr#'+i+'').remove();
    }
    fetch_item_data();
   }
  });
 });



 function fetch_item_data()
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
 
});
</script>
<?php
//insert.php
$connect = mysqli_connect("localhost", "root", "mysql", "mall");


$count = 0;
 $item_code = $_POST["item_code"];
 $item_desc = $_POST["item_desc"];
 $item_price = $_POST["item_price"];
 $query = '';
 while($count<count($item_code))
 
{
  $item_code_clean = mysqli_real_escape_string($connect, $item_code[$count]);
  $item_desc_clean = mysqli_real_escape_string($connect, $item_desc[$count]);
  $item_price_clean = mysqli_real_escape_string($connect, $item_price[$count]);


  if($item_code_clean != '' && $item_desc_clean != '' && $item_price_clean != '')
  {
    $query3="select inventory from product where product_id=$item_code_clean";
    $result3 = $connect->query($query3);
    $data3 = $result3->fetch_assoc();

    if($item_desc_clean<=$data3['inventory'])
    {
    $query = '
    INSERT INTO pro_invoice(invoice_id, product_id, Product_number, Discount) 
    VALUES((select invoice_id from invoice order by invoice_id Desc limit 1), "'.$item_code_clean.'", "'.$item_desc_clean.'", "'.$item_price_clean.'"); 
    ';
      if($query != '')
      {
        if(mysqli_multi_query($connect, $query))
        {

        echo 'Product: '.$item_code_clean. ' Inserted
';
        
        $query4="update product set inventory=inventory-$item_desc_clean where Product_id=$item_code_clean";
        $result4 = $connect->query($query4);
        $query5="select invoice_id from invoice order by invoice_id Desc limit 1";
        $result5 = $connect->query($query5);
        $data5 = $result5->fetch_assoc(); 
        $invoiceid=$data5['invoice_id'];
        $query2="select sum(pi.product_number*p.price*pi.discount) as total from pro_invoice pi join Product p on pi.product_id=p.product_id join invoice i on i.invoice_id=pi.invoice_id where pi.invoice_id=$invoiceid";
        $result2 = $connect->query($query2);
        $data2 = $result2->fetch_assoc(); 
        $total=$data2['total'];
        $query7="update invoice set total_value=$total where invoice_id=$invoiceid";
        $result7 = $connect->query($query7);
        $query6="select total_value from invoice where invoice_id=$invoiceid";
        $result6 = $connect->query($query6);
        $data6 = $result6->fetch_assoc();
        if($count==count($item_code)-1)
          {echo "Total value of order NO.".$data5['invoice_id'];
        echo " is " .$data6['total_value'];}

        }
        else
        {
        echo 'Please input valid Product_ID';
        }
      }
    }
    else{
    echo "Inventory lower than request";
    }
  }
  else
  {
    $temp=$count+1;
  echo '
Product in line '.$temp;echo ':All Fields are Required';

  }
 
  $count++;
}




?>



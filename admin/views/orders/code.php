<?php
include('../../database/dbconfig.php');

//Call with AJAX to get modal data to edit
if(isset($_POST["id"])){

	$id = $_POST['id'];

	$getData = $db->collection('orders')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

if(isset($_POST['updateBtn'])){

    $status = $_POST['editStatus'];
    $order_id = $_POST['editOrder_id'];

    $queryDoc = $db->collection('orders');
    $updateInfo = [
        'order_status' => $status,
    ];

    try{
        $update = $queryDoc->document($order_id)->set($updateInfo, ['merge'=>true]);
        if($update){
            $_SESSION['success'] = 'Status Updated Successfully';
            header('Location: ../orders/');
            exit();
        }else{
            $_SESSION['success'] = 'Something went wrong. Please try again';
            header('Location: ../orders/');
            exit();
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["submit_Btn"])){

	$s = $_POST["status"];

	if($s == "All"){
		 header("Location: ../orders/");
	}else if($s == "Pending"){
		header("Location: index.php?status=".$s);
	}else if($s == "Delivered"){
		header("Location: index.php?status=".$s);
	}else if($s == "Completed"){
		header("Location: index.php?status=".$s);
	}else if($s == "Cancelled"){
		header("Location: index.php?status=".$s);
	}
}

/*$orderItemDocRef = $db->collection('order_item')->where('order_id', '=', "a57ff79ba4a14faba9d1");
$row_ordItem = $orderItemDocRef->documents();
foreach($row_ordItem as $x){
    print_r($x["product_id"]);
}*/
/*$odate = "20221003";
$orderDocRef = $db->collection('orders')->where('orderDate', '>=', $odate);
$orderSnapshot = $orderDocRef->documents();
$sumSales = 0;
foreach($orderSnapshot as $ord){
    echo $orderDate = date('d M Y', strtotime($ord['orderDate']));
    echo "<br>";
    $sumSales += $ord['sales'];
    echo $sumSales;
    echo "<br>";
    echo $odate;
    echo "<br>";
}*/
/*$docRef = $db->collection('orders')->orderBy('orderDate', 'DESC');
$snapshot = $docRef->documents();

foreach($snapshot as $s){
    $cust_id = $s['customer_id'];
    $custSnap = $db->collection('customers')->document($cust_id)->snapshot();
    //echo $s["orderDateTime"];
    ?>
    <table>
        <tbody>
            <tr>
                <td><?=$s["order_no"];?></td>
                <td><?=$custSnap["name"];?></td>
                <td><?=$s["orderDateTime"];?></td>
                <td><?=$s["sales"];?></td>
                <td><?=$s["order_status"];?></td>
            </tr>
        </tbody>
    </table>
    <?php
}*/

/*$orderItemDocRef = $db->collection('order_item')->where('order_id', '=', 'a57ff79ba4a14faba9d1');
$row_ordItem = $orderItemDocRef->documents();

$result = 0;
$numRow = [];
$i=0;
foreach($row_ordItem as $oi_row){
    $prod_data = $oi_row['stripe_product_id'];
    $prod_d= $oi_row['stripe_product_id'];
    if (is_array($prod_d) || is_object($prod_d)){
        foreach($prod_d as $prod){
            array_push($numRow, $prod);
            $result = count($numRow);
        }
    }

    $prod_data = $oi_row['stripe_product_id'];
    $oi_qtt = $oi_row["quantity"];
    $oi_price = $oi_row["price"];
    $oi_amo = $oi_row["amount"];
    foreach($prod_data as $pd => $p){
        $i++;
        $prodDoc = $db->collection('products')->where('stripe_product_id', '=', $p)->documents();
        foreach($prodDoc as $rowProd){
        ?>
        <tr>
            <td><?php echo '<img src="../../dist/img/productImage/'.$rowProd['image_url'].'" class="img-thumbnail-table" alt="'.$rowProd["name"].'" title="'.$rowProd["name"].'"/>'; ?></td>
            <td><?=$rowProd["sku"]?></td>
            <td><?=$rowProd["name"]?></td>
            <td><?= $oi_qtt[$i] ?></td>
            <td><?= number_format($oi_price[$i], 2); ?></td>
            <td><?= number_format($oi_amo[$i], 2); ?></td>
        </tr>
        <?php
        }
    }
}*/


?>
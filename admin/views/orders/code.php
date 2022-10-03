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

$docRef = $db->collection('orders')->orderBy('orderDate', 'DESC');
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
}

?>
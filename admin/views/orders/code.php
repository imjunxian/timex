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



?>
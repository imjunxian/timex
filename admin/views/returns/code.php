<?php
include('../../database/dbconfig.php');

//Call with AJAX to get modal data to edit
if(isset($_POST["id"])){

	$id = $_POST['id'];

	$getData = $db->collection('returns')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

if(isset($_POST['updateBtn'])){

    $status = $_POST['editStatus'];
    $id = $_POST['editReturn_id'];
    $order_id = $_POST['editOrder_id'];

    $queryDoc = $db->collection('returns');
    $orderDoc = $db->collection('orders');
    $updateInfo = [
        'status' => $status,
    ];

    try{
        $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
        if($update){
            if($status == "Approved"){
                $updateOrderInfo = [
                    'order_status' => 'Cancelled',
                ];
                $orderDoc->document($order_id)->set($updateOrderInfo, ['merge'=>true]);
            }elseif($status == "Rejected"){
                $updateOrderInfo = [
                    'order_status' => 'Completed',
                ];
                $orderDoc->document($order_id)->set($updateOrderInfo, ['merge'=>true]);
            }
            $_SESSION['success'] = 'Status Updated Successfully';
            header('Location: ../returns/');
            exit();
        }else{
            $_SESSION['success'] = 'Something went wrong. Please try again';
            header('Location: ../returns/');
            exit();
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
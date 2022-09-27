<?php
include('../../database/dbconfig.php');

if(isset($_POST['approvedBtn'])){

    $status = 'Approved';
    $id = $_POST['return_id'];
    $order_id = $_POST['order_id'];

    $queryDoc = $db->collection('returns');
    $updateInfo = [
        'status' => $status,
    ];

    $orderDoc = $db->collection('orders');
    $updateOrderInfo = [
        'order_status' => 'Cancelled',
    ];

    try{
        $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
        if($update){
            $orderDoc->document($order_id)->set($updateOrderInfo, ['merge'=>true]);
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

if(isset($_POST['rejectedBtn'])){
    $status = 'Rejected';
    $id = $_POST['return_id'];
    $order_id = $_POST['order_id'];

    $queryDoc = $db->collection('returns');

    $updateInfo = [
        'status' => $status,
    ];

    $orderDoc = $db->collection('orders');
    $updateOrderInfo = [
        'order_status' => 'Completed',
    ];

    try{
        $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
        if($update){
            $orderDoc->document($order_id)->set($updateOrderInfo, ['merge'=>true]);
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

if(isset($_POST['pendingBtn'])){
    $status = 'Pending';
    $id = $_POST['return_id'];
    $queryDoc = $db->collection('returns');

    $updateInfo = [
        'status' => $status,
    ];

    try{
        $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
        if($update){
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
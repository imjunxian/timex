<?php
include('../../database/dbconfig.php');

if (isset($_POST['viewBtn'])) {
    $id = $_POST['delete_id'];
    $_SESSION['viewid'] = $id;
    header("Location:detail.php?id={$id}");
}

if(isset($_POST['updateBtn'])){
	$status = $_POST['status'];
	$id = $_SESSION['viewid'];
	$updateInfo = [
        'status'=> $status,
    ];

    $queryDoc = $db->collection('contacts');
    $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);

    if($update){
        $_SESSION['success'] = 'Status Updated Successfully.';
        header('Location: ../services/');
        unset($_SESSION['viewid']);
        exit();
    }else{
        $_SESSION['danger'] = 'Status Update Failed. Please try again.';
        header('Location: ../services/detail.php?id={$id}');
        exit();
    }
}

//Delete Function
if(isset($_POST['recycleBtn'])){

    $id = $_POST['deleteid'];

    $deleteDoc = $db->collection('contacts')->document($id)->delete();

    try{
        if($deleteDoc){
            $_SESSION['success'] = 'Message Deleted Successfully.';
            header('Location: ../services/');
            exit();
        }else{
            $_SESSION['danger'] = 'Message Delete Failed. Please try again.';
            header('Location: ../services/');
            exit();
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["submit_Btn"])){

    $s = $_POST["status"];

    if($s == "All"){
        header("Location: ../services/");
    }else if($s == "Pending"){
        header("Location: index.php?status=".$s);
    }else if($s == "Solved"){
        header("Location: index.php?status=".$s);
    }else{
        header("Location: ../services/");
    }
}
?>
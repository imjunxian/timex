<?php
include '../../database/dbconfig.php';

if(isset($_POST['editCart'])){
    $id = $_POST['cartId'];
    $quantity = $_POST['quantity'];
    $qtt = $_POST['pquantity'];

    $updateInfo = [
        'quantity' => $quantity,
    ];

    $queryDoc = $db->collection('carts');

    try {
        if($quantity == 0){
            $_SESSION['danger'] = 'Your Product in cart cannot be 0.';
            header('Location: ../cart/');
            exit();
        }elseif($quantity > $qtt){
            $_SESSION['danger'] = 'Quantity exceed the number of stock available.';
            header('Location: ../cart/');
            exit();
        }else{
            $update = $queryDoc->document($id)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = 'Your Cart is Updated Successfully.';
	            header('Location: ../cart/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Update Failed. Please try again.';
	            header('Location: ../cart/');
	            exit();
	        }
        }

    } catch (Exception $e) {
        $_SESSION['danger'] = 'Something went wrong. Please try again.';
        header('Location: ../cart/');
        exit();
    }
}

if(isset($_POST['recycleBtn'])){

    $id = $_POST['deleteid'];

	$deleteDoc = $db->collection('carts')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Product Removed Successfully.';
            header('Location: ../cart/');
            exit();
		}else{
			$_SESSION['danger'] = 'Remove Failed. Please try again.';
            header('Location: ../cart/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}


//AJAX
if(isset($_POST["cartId"])){

	$id = $_POST['cartId'];

	$getData = $db->collection('carts')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

if(isset($_POST['updateBtn'])){
    $id = $_POST['cartid'];
    $quantity = $_POST['prodQuantity'];
    $updateInfo = [
        'quantity' => $quantity,
    ];

    $queryDoc = $db->collection('carts');

    try {
        if($quantity == 0){
            $_SESSION['danger'] = 'Your Product in cart cannot be 0.';
            header('Location: ../cart/');
            exit();
        }else{
            $update = $queryDoc->document($id)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = 'Your Cart is Updated Successfully.';
	            header('Location: ../cart/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Update Failed. Please try again.';
	            header('Location: ../cart/');
	            exit();
	        }
        }

    } catch (Exception $e) {
        $_SESSION['danger'] = 'Something went wrong. Please try again.';
        header('Location: ../cart/');
        exit();
    }
}

?>
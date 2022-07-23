<?php
include '../../database/dbconfig.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

	$deleteDoc = $db->collection('wishlists')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Product has been successfully removed from your wishlist.';
            header('Location: ../wishlist/');
            exit();
		}else{
			$_SESSION['danger'] = 'Remove Failed. Please try again.';
            header('Location: ../wishlist/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
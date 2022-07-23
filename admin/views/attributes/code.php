<?php
include('../../database/dbconfig.php');

//Call with AJAX to get modal data to edit
if(isset($_POST["attId"])){

	$id = $_POST['attId'];

	$getData = $db->collection('attributes')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

//Add function
if(isset($_POST['addBtn'])){

	$name = $_POST['attName'];
    $status = $_POST['status'];

    $addInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $queryDoc = $db->collection('attributes');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../attributes/');
            exit();
	    }else{
	    	//Check the existency of category name
	    	$queryRef = $queryDoc->where('name', '==', $name);
			$checkName = $queryRef->documents();
			if($checkName->isEmpty()){
				$addBrand = $queryDoc->add($addInfo);
		        if($addBrand){
		            $_SESSION['success'] = ''.$name.' Added Successfully.';
		            header('Location: ../attributes/');
		            exit();
		        }else{
		            $_SESSION['danger'] = ''.$name.' Add Failed. Please try again.';
		            header('Location: ../attributes/');
		            exit();
		        }
			}else{
				$_SESSION['danger'] = ''.$name.' already exists. Please try again.';
	            header('Location: ../attributes/');
	            exit();
			}
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Update Function
if(isset($_POST['updateBtn'])){
	$name = $_POST['editName'];
    $status = $_POST['editStatus'];
    $attId = $_POST['attId'];

    $updateInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $queryDoc = $db->collection('attributes');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../attributes/');
            exit();
	    }else{
	    	$update = $queryDoc->document($attId)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = ''.$name.' Updated Successfully.';
	            header('Location: ../attributes/');
	            exit();
	        }else{
	            $_SESSION['danger'] = ''.$name.' Update Failed. Please try again.';
	            header('Location: ../attributes/');
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Delete Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	$deleteDoc = $db->collection('attributes')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Attribute Deleted Successfully.';
            header('Location: ../attributes/');
            exit();
		}else{
			$_SESSION['danger'] = 'Attribute Delete Failed. Please try again.';
            header('Location: ../attributes/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
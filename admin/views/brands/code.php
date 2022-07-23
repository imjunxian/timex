<?php
include('../../database/dbconfig.php');

//Call with AJAX to get modal data to edit
if(isset($_POST["brandId"])){

	$id = $_POST['brandId'];

	$getData = $db->collection('brands')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

//Add function
if(isset($_POST['addBtn'])){

	$name = $_POST['brandName'];
    $status = $_POST['status'];

    $addInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $queryDoc = $db->collection('brands');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../brands/');
            exit();
	    }else{
	    	//Check the existency of name
	    	$queryRef = $queryDoc->where('name', '==', $name);
			$checkName = $queryRef->documents();
			if($checkName->isEmpty()){
				$addBrand = $queryDoc->add($addInfo);
		        if($addBrand){
		            $_SESSION['success'] = ''.$name.' Added Successfully.';
		            header('Location: ../brands/');
		            exit();
		        }else{
		            $_SESSION['danger'] = ''.$name.' Add Failed. Please try again.';
		            header('Location: ../brands/');
		            exit();
		        }
			}else{
				$_SESSION['danger'] = "".$name." already exists. Please try again.";
	            header('Location: ../brands/');
	            exit();
			}
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Update Function
if(isset($_POST['updateBtn'])){
	$name = $_POST['editBrandName'];
    $status = $_POST['editStatus'];
    $brandId = $_POST['brandid'];

    $updateInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $queryDoc = $db->collection('brands');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../brands/');
            exit();
	    }else{
	    	$update = $queryDoc->document($brandId)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = ''.$name.' Updated Successfully.';
	            header('Location: ../brands/');
	            exit();
	        }else{
	            $_SESSION['danger'] = ''.$name.' Update Failed. Please try again.';
	            header('Location: ../brands/');
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

	$deleteDoc = $db->collection('brands')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Brand Deleted Successfully.';
            header('Location: ../brands/');
            exit();
		}else{
			$_SESSION['danger'] = 'Brand Delete Failed. Please try again.';
            header('Location: ../brands/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
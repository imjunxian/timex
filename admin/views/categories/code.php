<?php
include('../../database/dbconfig.php');



//Call with AJAX to get modal data to edit
if(isset($_POST["catId"])){

	$id = $_POST['catId'];

	$getCategory = $db->collection('categories')->document($id)->snapshot();

	if ($getCategory->exists()) {
		echo json_encode($getCategory->data());
	}
}

//Add function
if(isset($_POST['addBtn'])){

	$name = $_POST['categoryName'];
    $status = $_POST['status'];

    $addCategoryInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $categoryDoc = $db->collection('categories');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../categories/');
            exit();
	    }else{
	    	//Check the existency of category name
	    	$queryRef = $categoryDoc->where('name', '==', $name);
			$checkName = $queryRef->documents();
			if($checkName->isEmpty()){
				$addCategory = $categoryDoc->add($addCategoryInfo);
		        if($addCategory){
		            $_SESSION['success'] = ''.$name.' Added Successfully.';
		            header('Location: ../categories/');
		            exit();
		        }else{
		            $_SESSION['danger'] = ''.$name.' Add Failed. Please try again.';
		            header('Location: ../categories/');
		            exit();
		        }
			}else{
				$_SESSION['danger'] = ''.$name.' already exists. Please try again.';
	            header('Location: ../categories/');
	            exit();
			}
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Update Function
if(isset($_POST['updateBtn'])){
	$name = $_POST['editCategoryName'];
    $status = $_POST['editStatus'];
    $catId = $_POST['categoryid'];

    $updateCategoryInfo = [
        'name'=> $name,
        'status' => $status,
    ];

    $categoryDoc = $db->collection('categories');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../categories/');
            exit();
	    }else{
	    	$updateCategory = $db->collection("categories")->document($catId)->set($updateCategoryInfo, ['merge' => true]);
	        if($updateCategory){
	            $_SESSION['success'] = ''.$name.' Updated Successfully.';
	            header('Location: ../categories/');
	            exit();
	        }else{
	            $_SESSION['danger'] = ''.$name.' Update Failed. Please try again.';
	            header('Location: ../categories/');
	            exit();
	        }
	    	/*$queryRef = $categoryDoc->where('name', '==', $name);
			$checkName = $queryRef->documents();
			if($checkName->isEmpty()){
				$updateCategory = $db->collection("categories")->document($catId)->set($updateCategoryInfo, ['merge' => true]);
		        if($updateCategory){
		            $_SESSION['success'] = ''.$name.' Updated Successfully.';
		            header('Location: ../categories/');
		            exit();
		        }else{
		            $_SESSION['danger'] = ''.$name.' Update Failed. Please try again.';
		            header('Location: ../categories/');
		            exit();
		        }
		    }else{
		    	$_SESSION['danger'] = ''.$name.' already exists. Please try again.';
	            header('Location: ../categories/');
	            exit();
		    }*/
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Delete Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	$deleteDoc = $db->collection('categories')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Category Deleted Successfully.';
            header('Location: ../categories/');
            exit();
		}else{
			$_SESSION['danger'] = 'Category Delete Failed. Please try again.';
            header('Location: ../categories/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
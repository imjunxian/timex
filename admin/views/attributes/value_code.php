<?php
include('../../database/dbconfig.php');

//Call with AJAX to get modal data to edit
if(isset($_POST["attvId"])){

	$id = $_POST['attvId'];

	$getData = $db->collection('attribute_values')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

//Add function
if(isset($_POST['addBtn'])){

	$name = $_POST['attValueName'];
    $status = $_POST['status'];
    $parent = $_POST['parentId'];

    $addInfo = [
        'name'=> $name,
        'status' => $status,
        'parent_id' => $parent,
    ];

    $queryDoc = $db->collection('attribute_values');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../attributes/value.php?id={$parent}");
            exit();
	    }else{
	    	//Check the existency of name
	    	$queryRef = $queryDoc->where('name', '==', $name);
			$checkName = $queryRef->documents();
			if($checkName->isEmpty()){
				$addValue = $queryDoc->add($addInfo);
		        if($addValue){
		            $_SESSION['success'] = ''.$name.' Added Successfully.';
		            header("Location: ../attributes/value.php?id={$parent}");
		            exit();
		        }else{
		            $_SESSION['danger'] = ''.$name.' Add Failed. Please try again.';
		            header("Location: ../attributes/value.php?id={$parent}");
		            exit();
		        }
			}else{
				$_SESSION['danger'] = ''.$name.' already exists. Please try again.';
	            header("Location: ../attributes/value.php?id={$parent}");
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
    $parent = $_POST['parentId'];
    $attvId = $_POST['attvId'];

    $updateInfo = [
        'name'=> $name,
        'status' => $status,
        'parent_id' => $parent,
    ];

    $queryDoc = $db->collection('attribute_values');

    try{
    	if(empty($name) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../attributes/value.php?id={$parent}");
            exit();
	    }else{
	    	$update = $queryDoc->document($attvId)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = ''.$name.' Updated Successfully.';
	            header("Location: ../attributes/value.php?id={$parent}");
	            exit();
	        }else{
	            $_SESSION['danger'] = ''.$name.' Update Failed. Please try again.';
	           	header("Location: ../attributes/value.php?id={$parent}");
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
	$parent = $_POST['parentId'];

	$deleteDoc = $db->collection('attribute_values')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Attribute Value Deleted Successfully.';
            header("Location: ../attributes/value.php?id={$parent}");
            exit();
		}else{
			$_SESSION['danger'] = 'Attribute Value Delete Failed. Please try again.';
            header("Location: ../attributes/value.php?id={$parent}");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
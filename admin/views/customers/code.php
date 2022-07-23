<?php
include('../../database/dbconfig.php');

//Add function
if(isset($_POST['addBtn'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];
	date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');
    //encrypt password then store it to database
    $hpassword = password_hash($password, PASSWORD_DEFAULT);

    $addInfo = [
        'name'=> $username,
        'email' => $email,
        'contact' => $contact,
        'status'=> $status,
        'password' => $hpassword,
        'address' => "",
        'gender' => "",
        'dob' => "",
		'date_joined' => $dateTime,
    ];

    $queryDoc = $db->collection('customers');

    $queryEmailRef = $queryDoc->where('email', '==', $email);
	$checkEmail = $queryEmailRef->documents();

	$queryContactRef = $queryDoc->where('contact', '==', $contact);
	$checkContact = $queryContactRef->documents();

    try{
    	if(!$checkEmail -> isEmpty()){
    		$_SESSION['danger'] = 'Email already exists. Please try again.';
            header('Location: ../customers/add.php');
    	}elseif(!$checkContact -> isEmpty()){
    		$_SESSION['danger'] = 'Phone Number already exists. Please try again.';
            header('Location: ../customers/add.php');
    	}else{
    		if(empty($username) || empty($status) || empty($email) || empty($contact) || empty($password) || empty($cpassword)){
	    		$_SESSION['danger'] = 'All fields are required.';
	            header('Location: ../customers/add.php');
	            exit();
		    }else{
				$add = $queryDoc->add($addInfo);
		        if($add){
		            $_SESSION['success'] = 'Customer Added Successfully.';
		            header('Location: ../customers/');
		            exit();
		        }else{
		            $_SESSION['danger'] = 'Customer Add Failed. Please try again.';
		            header('Location: ../customers/add.php');
		            exit();
		        }
		    }
    	}
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if (isset($_POST['editBtn'])) {
    $id = $_POST['edit_id'];
    $_SESSION['editid'] = $id;
    header("Location:edit.php?id={$id}");
}

//Update Function
if(isset($_POST['updateBtn'])){

    $id = $_POST['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $status=$_POST['status'];

    $oldpass = $_POST['oldpass'];
    $newpassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $newhpassword = password_hash($newpassword, PASSWORD_DEFAULT);

    $updateInfo = [
	    /*'name'=> $username,
	    //'email' => $email,
	    'dob' => $dob,
	    'gender' => $gender,
	    'contact' => $contact,
	    'address' => $address,*/
	    'status'=> $status,

    ];

    $queryDoc = $db->collection('customers');

    try{
		if(empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../customers/edit.php?id={$id}");
            exit();
	    }else{
			$update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
	        if($update){
	            $_SESSION['success'] = 'Customer Updated Successfully.';
	            header('Location: ../customers/');
	            unset($_SESSION['editid']);
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Customer Updated Failed. Please try again.';
	            header("Location: ../customers/edit.php?id={$id}");
	            exit();
	        }
	    }/*elseif ($newpassword != '' && $cpassword != '' && $newpassword == $cpassword && $oldpass != '' ) {

	        $getPassQuery = $queryDoc->document($id)->snapshot();

	        if($getPassQuery -> exist()){

	            $dbpass = $getPassQuery['password'];

	            if(!password_verify($oldpass, $dbpass)){
	                $_SESSION['danger'] = 'Password Not Match. Please try again';
	                header("Location: ../users/edit.php?id={$id}");
	            }else{
	            	$updatePassword = [
	            		'password' => $hpassword,
	            	];
	                $query_newpass_run = $queryDoc->document($id)->set($updatePassword, ['merge' => true]);
	                if ($query_newpass_run) {
	                    $_SESSION['success'] = 'Password Updated Successfully.';
	                    header("Location: index.php");
	                    unset($_SESSION['editid']);
	                } else {
						$_SESSION['danger'] = 'Password not Match.';
		                header("Location: ../users/edit.php?id={$id}");
	                }
	            }

	        }
	    }elseif(($oldpass != '' && $newpassword == '' && $cpassword == '') || ($oldpass == '' && $newpassword != '' && $cpassword != '')){
	        $_SESSION['danger'] = 'Failed to change password';
		    header("Location: ../users/edit.php?id={$id}");
	        exit();
	    }*/
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}


//Move to Recylce Bin Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	//$deleteDoc = $db->collection('customers')->document($id)->delete();
	$updateInfo = [
	    'status'=> "Closed",
    ];

    $queryDoc = $db->collection('customers');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Customer Account Closed Successfully.';
            header("Location: index.php");
            exit();
		}else{
			$_SESSION['danger'] = 'Customer Account Closed Failed. Please try again.';
            header("Location: index.php");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Activate Customer Account
if(isset($_POST['recoverBtn'])){

	$id = $_POST['recover_id'];

	$updateInfo = [
	    'status'=> "Active",
    ];

    $queryDoc = $db->collection('customers');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Customer Account Activated Successfully.';
            header("Location: ../recycle/customers.php");
            exit();
		}else{
			$_SESSION['danger'] = 'Customer Account Activate Failed. Please try again.';
            header("Location: ../recycle/customers.php");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
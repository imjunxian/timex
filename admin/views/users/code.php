<?php
include('../../database/dbconfig.php');

//Add function
if(isset($_POST['addBtn'])){

    $img = $_FILES["profile_image"]["name"];
    $storeName = $_FILES["profile_image"]["tmp_name"];
    $dir = "../../dist/img/profile/";
    $target_file = $dir . basename($img);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $error = $_FILES["profile_image"]["error"];
    $exist = file_exists($target_file);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $status = "Active";
    //encrypt password then store it to database
    //$hpassword = password_hash($password, PASSWORD_DEFAULT);
	$encPass = $rsa->privEncrypt($password);

	date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');

    $addInfo = [
        'name'=> $username,
        'email' => $email,
        'dob' => $dob,
        'gender' => $gender,
        'contact' => $contact,
        'role' => $role,
        'status'=> $status,
        'password' => $encPass,
        'image_url' => $img,
		'date_joined' => $dateTime,
    ];

    $queryDoc = $db->collection('admins');

    $queryEmailRef = $queryDoc->where('email', '==', $email);
	$checkEmail = $queryEmailRef->documents();

	$queryContactRef = $queryDoc->where('contact', '==', $contact);
	$checkContact = $queryContactRef->documents();

    try{
    	if(!$checkEmail -> isEmpty()){
    		$_SESSION['danger'] = 'Email already exists. Please try again.';
            header('Location: ../users/add.php');
    	}elseif(!$checkContact -> isEmpty()){
    		$_SESSION['danger'] = 'Phone Number already exists. Please try again.';
            header('Location: ../users/add.php');
    	}else{
    		if(empty($username) || empty($status) || empty($email) || empty($dob) || empty($gender) || empty($role) || empty($contact) || empty($password) || empty($cpassword) || empty($img)){
	    		$_SESSION['danger'] = 'All fields are required.';
	            header('Location: ../users/add.php');
	            exit();
		    }else{
				$add = $queryDoc->add($addInfo);
		        if($add){
		        	move_uploaded_file($storeName, $target_file);
		            $_SESSION['success'] = 'Admin Added Successfully.';
		            header('Location: ../users/');
		            exit();
		        }else{
		            $_SESSION['danger'] = 'Admin Add Failed. Please try again.';
		            header('Location: ../users/add.php');
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
	$image = $_POST["profile_image"];
    $img = $_FILES["profile_image"]["name"];
    $storeName = $_FILES["profile_image"]["tmp_name"];
    $dir = "../../dist/img/profile/";
    $target_file = $dir . basename($img);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $error = $_FILES["profile_image"]["error"];
    $exist = file_exists($target_file);

    $id = $_POST['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $status=$_POST['status'];

    $oldpass = $_POST['oldpass'];
    $newpassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $newhpassword = password_hash($newpassword, PASSWORD_DEFAULT);

    $updateInfo = [
	    'name'=> $username,
	    //'email' => $email,
	    'dob' => $dob,
	    'gender' => $gender,
	    'contact' => $contact,
	    'role' => $role,
	    'status'=> $status,

    ];

    $queryDoc = $db->collection('admins');

    try{
		if(empty($username) || empty($status) || empty($dob) || empty($gender) || empty($role) || empty($contact) || empty($status)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../users/edit.php?id={$id}");
            exit();
	    }else{
			$update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
			if($img != null){
		    	$updateImg = [
	        		'image_url' => $img,
	        	];
		        $query_img_run = $queryDoc->document($id)->set($updateImg, ['merge' => true]);
		    }
	        if($update || $query_img_run){
	        	unlink($target_file);
	            move_uploaded_file($storeName, $target_file);
	            $_SESSION['success'] = 'Admin Updated Successfully.';
	            header('Location: ../users/');
	            unset($_SESSION['editid']);
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Admin Updated Failed. Please try again.';
	            header("Location: ../users/edit.php?id={$id}");
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

//Delete Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	//$deleteDoc = $db->collection('customers')->document($id)->delete();
	$updateInfo = [
	    'status'=> "Closed",
    ];

    $queryDoc = $db->collection('admins');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Admin Account Closed Successfully.';
            header("Location: ../users/");
            exit();
		}else{
			$_SESSION['danger'] = 'Admin Account Closed Failed. Please try again.';
            header("Location: ../users/");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Activate Admin Account
if(isset($_POST['recoverBtn'])){

	$id = $_POST['recover_id'];

	$updateInfo = [
	    'status'=> "Active",
    ];

    $queryDoc = $db->collection('admins');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Admin Account Activated Successfully.';
            header("Location: ../recycle/admins.php");
            exit();
		}else{
			$_SESSION['danger'] = 'Admin Account Activate Failed. Please try again.';
            header("Location: ../recycle/admins.php");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}
?>
<?php
include('../../database/dbconfig.php');

if (isset($_POST['editpass_btn'])){

    $id = $_POST['userid'];
    $oldpass = $_POST['oldpass'];
    $newpassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $newhpassword = password_hash($newpassword, PASSWORD_DEFAULT);

    if($newpassword != '' && $cpassword != '' && $newpassword == $cpassword && $oldpass != ''){
        //get current user password from database
        $id = $_SESSION['user_id'];
        $docRef = $db->collection('admins');
        $row = $docRef->document($id)->snapshot();

        if($row -> exists()){
            $dbpass = $row['password'];
            //current password must corrent then update
            if(password_verify($oldpass, $dbpass)){
                $updatePassword = [
            		'password' => $newhpassword,
            	];
                $query_newpass_run = $db->collection('admins')->document($id)->set($updatePassword, ['merge' => true]);
                if ($query_newpass_run) {
                    $_SESSION['success'] = 'Password Updated Successfully.';
                    header("Location: changePassword.php");
                    unset($_SESSION['editid']);
                } else {
					$_SESSION['danger'] = 'Password Not Match.';
	                header("Location: changePassword.php");
                }
            }else{
                $_SESSION['danger'] = "Invalid Current Password. Please try again.";
                header("Location: changePassword.php");
            }
        }
    }
}

//Update Email Function
if (isset($_POST['editEmail_btn'])){

    $email = $_POST['email'];
    $id = $_SESSION['user_id'];

    $updateInfo = [
	    'email'=> $email,
    ];

    $queryDoc = $db->collection('admins');

    $queryEmailRef = $queryDoc->where('email', '==', $email);
	$checkEmail = $queryEmailRef->documents();

    try{
        if(!$checkEmail->isEmpty()){
    		$_SESSION['danger'] = 'Email already exists. Please try again.';
            header('Location: ../settings/changeEmail.php');
    	}else{
            if(empty($email)){
                $_SESSION['danger'] = 'All fields are required.';
                header("Location: ../settings/changeEmail.php");
                exit();
            }else{
                $updateEmail = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);

                if($updateEmail){
                    $_SESSION['success'] = 'Email Updated Successfully.';
                    header('Location: ../settings/');
                    exit();
                }else{
                    $_SESSION['danger'] = 'Email Updated Failed. Please try again.';
                    header("Location: ../settings/changeEmail.php");
                    exit();
                }
            }
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }

}

//Update Profile Function
if(isset($_POST['editprofile_btn'])){
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
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $status=$_POST['status'];

    $updateInfo = [
	    'name'=> $username,
	    'dob' => $dob,
	    'gender' => $gender,
	    'contact' => $contact,
    ];

    $queryDoc = $db->collection('admins');

    try{
		if(empty($username) || empty($dob) || empty($gender) || empty($contact)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../settings/edit.php");
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
	            $_SESSION['success'] = 'Profile Updated Successfully.';
	            header('Location: ../settings/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Profile Updated Failed. Please try again.';
	            header("Location: ../settings/edit.php");
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
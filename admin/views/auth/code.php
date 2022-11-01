<?php
include('../../../dbconfig.php');

//Login
if(isset($_POST['loginBtn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $docRef = $db->collection('admins')->where('email', '==', $email);
    $snapshots = $docRef->documents();

    try {
        //check user input
        if($email == "" || $email == null ){
            $_SESSION['danger'] = 'Email is required.';
            header('Location: ../auth/');
            exit();
        }else if($password == "" || $password == null ){
            $_SESSION['danger'] = 'Password is required.';
            header('Location: ../auth/');
            exit();
        }else{
			//Check whether user exists in database
			if($snapshots->rows() == Array()){
                $_SESSION['danger'] = 'Invalid Email or Password. Please try again';
                header('Location: ../auth/');
            }else{
				foreach($snapshots as $snapshot){
					$dbpass = $snapshot["password"];
					$status = $snapshot["status"];
					$id = $snapshot->id();
					//Check Password
					if(password_verify($password, $dbpass)){
						//Check Status
						if($status == "Active"){
							$_SESSION['user_email'] = $email;
							$_SESSION['user_id'] = $id;
							$_SESSION['user_name'] = $snapshot["name"];
							$_SESSION['user_role'] = $snapshot["role"];
							$_SESSION['success'] = 'Login as '.$_SESSION['user_role'].': '.$_SESSION['user_name'].'';
							$_SESSION['welcome'] = 'Welcome Back, '.$_SESSION['user_name'].'';
							header('Location: ../dashboard/');
                            //header('Location: ../settings/');
							exit();
						}elseif($status == "Inactive"){
							$_SESSION['danger'] = 'Access Denied due to Account had been Deactivated';
							header('Location: ../auth/');
						}elseif($status == "Closed"){
							$_SESSION['danger'] = 'Access Denied due to Account had been Closed';
							header('Location: ../auth/');
						}
					}else{
						$_SESSION['danger'] = 'Invalid Email or Password. Please try again';
						header('Location: ../auth/');
					}
				}
			}
        }
    } catch (Exception $e) {
        $_SESSION['danger'] = 'Invalid Email or Password. Please try again';
        header('Location: ../auth/');
        exit();
    }
}

//Logout
if (isset($_POST['logout_btn'])) {

    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);
    unset($_SESSION['editid']);
    unset($_SESSION['viewid']);
    /*$_SESSION['success'] = 'Logout Successfully';*/
    //session_destroy();
    header("Location: ../auth/index.php?logoutsuccess");
}

?>
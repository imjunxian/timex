<?php
include '../../database/dbconfig.php';

//Login
if(isset($_POST['loginBtn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $docRef = $db->collection('customers')->where('email', '==', $email);
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
                    $hashPass = $rsa->publicDecrypt($dbpass);
                    $status = $snapshot["status"];
                    $id = $snapshot->id();
                    //Check Password
                    if($hashPass === $password){
                        //Check Status
                        if($status == "Active"){
                            $_SESSION['client_user_email'] = $email;
                            $_SESSION['client_user_id'] = $id;
                            $_SESSION['client_user_name'] = $snapshot["name"];
                            $_SESSION['success'] = 'Login Successfully';
                            header('Location: ../home/');
                            ?><?php
                            exit();
                        }elseif($status == "Banned"){
                            $_SESSION['danger'] = 'Account had been Banned. Please contact admin to unban the account.';
                            header('Location: ../auth/');
                        }elseif($status == "Closed"){
                            $_SESSION['danger'] = 'Account had been Deactivated. Please contact admin to activate the account.';
                            header('Location: ../auth/');
                        }
                    }else{
                        $_SESSION['danger'] = 'Invalid Email or Password. Please try again.';
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

    /*unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);
    unset($_SESSION['editid']);
    $_SESSION['success'] = 'Logout Successfully';*/
    session_destroy();
    $_SESSION['success'] = 'Logout Successfully';
    header("Location: ../home/");
}

if(isset($_POST['registerBtn'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');
    //encrypt password then store it to database
    //$hpassword = password_hash($password, PASSWORD_DEFAULT);
    $encryptPassword = $rsa->privEncrypt($password);

    $addInfo = [
        'name'=> $username,
        'email' => $email,
        'contact' => $contact,
        'status'=> "Active",
        'password' => $encryptPassword,
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
            header('Location: ../auth/signup.php');
    	}elseif(!$checkContact -> isEmpty()){
    		$_SESSION['danger'] = 'Phone Number already exists. Please try again.';
            header('Location: ../auth/signup.php');
    	}else{
    		if(empty($username) || empty($email) || empty($contact) || empty($password) || empty($cpassword)){
	    		$_SESSION['danger'] = 'All fields are required.';
	            header('Location: ../auth/signup.php');
	            exit();
		    }else{
				$add = $queryDoc->add($addInfo);
		        if($add){
		            $_SESSION['success'] = 'Sign Up Successfully.';
		            header('Location: ../auth/');
		            exit();
		        }else{
		            $_SESSION['danger'] = 'Sign Up Failed. Please try again.';
		            header('Location: ../auth/signup.php');
		            exit();
		        }
		    }
    	}
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
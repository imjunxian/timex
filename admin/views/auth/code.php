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
    header("Location: ../auth/index.php?logout=success");
}

//Send Email
/*function send_email($email_sent,$url){
    $subject = "Reset Password";
    $message = "";
    if(file_exists("email.php")){
        $message = file_get_contents('email.php');
        $parts_to_mod = array("url");
        $replace_with = array($url);
        for($i=0; $i<count($parts_to_mod); $i++){
            $message = str_replace($parts_to_mod[$i], $replace_with[$i], $message);
        }
    }else{
        $message = "Something Wrong. Please try again.";
    }

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $headers .= 'From: noreply <no-reply@gmail.com>' . "\r\n";
    $headers .= "To: <".$email_sent.">\r\n";
    $header .= "Reply-To: no-reply@gmail.com\r\n";

    mail($email_sent,$subject,$message,$headers);
}
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$headers .= 'From: noreply <no-reply@gmail.com>' . "\r\n";
$headers .= "To: <".$email_sent.">\r\n";
mail('junxian010729@gmail.com','hello','test',$headers);


if (isset($_POST['sendBtn'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $email = $_POST['email'];
    $url = "http://localhost:8080/inv/views/auth/resetPassword.php?selector=".$selector."&validator=".bin2hex($token)."&email=".$email;
    $expires = date("U") + 1800; // 30 minutes will be expired
    $response = $_POST['g-recaptcha-response'];

    if(!$response){
        $_SESSION['danger'] = 'Please check the recaptcha in the form.';
        header('Location: ../auth/forgetPassword.php?error=verifyfailed');
    }else{
        $docRef = $db->collection('admins')->where('email', '==', $email)->limit(1);
        $snapshots = $docRef->documents();

        if($snapshots->rows() == Array()){
            $_SESSION['danger'] = 'Email Not Found. Please try again.';
            header('Location: ../auth/forgetPassword.php?error=emailnotfound');
            exit();
        }

        foreach($snapshots as $row){
            $status = $row['status'];

            if($status != "Active"){
                $_SESSION['danger'] = 'Account Banned. Please contact admin.';
                header('Location: ../auth/forgetPassword.php?error=accbanned');
                exit();
            }else{

                $docReset = $db->collection('password_reset');
                $hashToken = password_hash($token, PASSWORD_DEFAULT);
                $addInfo = [
                    'email'=> $email,
                    'selector' => $selector,
                    'token' => $hashToken,
                    'expires' => $expires,
                ];
                $add = $docReset->add($addInfo);

                if(send_email($email, $url)){
                    $_SESSION['danger'] = 'Email has been failed to send.';
                    header('Location: ../auth/forgetPassword.php?sendfailed');
                }else{
                    //email sent notification
                    $_SESSION['success'] = 'Email has been sent to '.$email.'';
                    header('Location: ../auth/forgetPassword.php?sendsuccess');
                }
            }
        }
    }
}*/

?>
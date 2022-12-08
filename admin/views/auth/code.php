<?php
include('../../../dbconfig.php');
include('../../../rsa/Rsa.php');

use encryption\Rsa;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../plugins/PHPMailer/src/Exception.php';
require '../../plugins/PHPMailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';


$privateKey = '../../../rsa/key/private_key.pem';
$publicKey = '../../../rsa/key/rsa_public_key.pem';

$rsa = new Rsa($privateKey, $publicKey);

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
                    $hashPass = $rsa->publicDecrypt($dbpass);
					$status = $snapshot["status"];
					$id = $snapshot->id();
					//Check Password
					if($hashPass === $password){
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

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'timexwatch01@gmail.com';
    $mail->Password   = 'qafnrifmdskupnkl';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->addAddress($email_sent);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}


if (isset($_POST['sendBtn'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $email = $_POST['email'];
    $url = "http://localhost/timex/admin/views/auth/resetPassword.php?selector=".$selector."&validator=".bin2hex($token)."&email=".$email;
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
}

if(isset($_POST['resetBtn'])){

    $email = $_POST["email"];
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $newpassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $newhpassword = $rsa->privEncrypt($newpassword);
    $currentDate = date("U");

    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";

    if($newpassword == ''){
        $_SESSION['status'] = "Password cannot be empty";
        header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
    }else if($cpassword == ''){
        $_SESSION['status'] = "Please confirm your password";
        header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
    }else if((!preg_match($pattern, $newpassword)) && (!preg_match($pattern, $cpassword))){
        $_SESSION['status'] = "Password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter";
        header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
    }else if($newpassword != $cpassword){
        $_SESSION['status'] = "Password not match";
        header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
    }else if($newpassword != '' && $cpassword != '' && $newpassword == $cpassword){


        $stmtSelector = $db->collection('password_reset')->where('selector', '==', $selector)->documents();

        foreach($stmtSelector as $row) {
            $token = $row["token"]; //token in database
            $tokenBin = hex2bin($validator); //encrypt the token that get from browser
            $exp = $row["expires"]; //get expires time in database
            $email = $row["email"];
            $docId = $row->id();

            if($currentDate >= $exp){
                $deleteDoc = $db->collection('password_reset')->document($docId)->delete();
                header("Location: ../error/404.php");

            }else if($currentDate < $exp){
                if(password_verify($tokenBin, $token)){
                    $updatePassword = [
                        'password' => $newhpassword,
                    ];
                    $query_newpass = $db->collection('admins')->where('email', '=', $email)->set($updatePassword, ['merge' => true]);

                    $delect_doc = $deleteDoc;

                    if($query_newpass && $query_dele){
                        $_SESSION['successStatus'] = "Password Updated Successfully.";
                        header("Location: index.php?passwordupdated");
                    }else{
                        $_SESSION['status'] = "Failed to Reset";
                        header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
                    }

                }else{
                    $_SESSION['status'] = "Something went wrong.";
                    header("Location: resetPassword.php?selector={$selector}&validator={$validator}&email={$email}");
                }
            }else{
                header("Location: ../error/404.php");
            }
        }
    }else{
        header("Location: ../error/404.php");
    }
}*/

?>
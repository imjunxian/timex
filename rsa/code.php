<?php
include '../../database/dbconfig.php';
include './Rsa.php';
use encryption\Rsa;

$privateKey = './key/private_key.pem';
$publicKey = './key/rsa_public_key.pem';

$rsa = new Rsa($privateKey, $publicKey);

//Login
if(isset($_POST['loginBtn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_en = $rsa->privEncrypt($email);
    $password_en = $rsa->privEncrypt($password);

    $docRef = $db->collection('customer_encrypt')->where('email', '==', $email_en);
    $snapshots = $docRef->documents();

    try {
        //check user input
        if($email == "" || $email == null ){
            $_SESSION['danger'] = 'Email is required.';
            header('Location: ../test/');
            exit();
        }else if($password == "" || $password == null ){
            $_SESSION['danger'] = 'Password is required.';
            header('Location: ../test/');
            exit();
        }else{
            //Check whether user exists in database
            if($snapshots->rows() == Array()){
                $_SESSION['danger'] = 'Invalid Email or Password. Please try again';
                header('Location: ../test/');
            }else{
                foreach($snapshots as $snapshot){
                    $dbpass = $snapshot["password"];
                    //Check Password
                    if($password_en == $dbpass){
                        $_SESSION['session_name'] = $rsa->publicDecrypt($snapshot["name"]);
                        header('Location: ../test/');
                        exit();
                    }else{
                        $_SESSION['danger'] = 'Invalid Email or Password. Please try again.';
                        header('Location: ../test/');
                    }
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['danger'] = 'Invalid Email or Password. Please try again';
        header('Location: ../test/');
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
    $_SESSION['danger'] = 'Logout Successfully';
    header("Location: ../test/");
}

?>
<?php
include '../../database/dbconfig.php';

//Login
if(isset($_POST[''])){


    try {

    } catch (Exception $e) {
        $_SESSION['danger'] = 'Something went wrong. Please try again.';
        header('Location: ../cart/checkout.php');
        exit();
    }
}



?>
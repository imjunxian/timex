<?php
include '../../database/dbconfig.php';

unset($_SESSION['client_user_email']);
unset($_SESSION['client_user_id']);
unset($_SESSION['client_user_name']);
$_SESSION['success'] = 'Logout Successfully';
header("Location: ../home/");

include('../../includes/script.php');
?>
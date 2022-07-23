<?php
include('../../../dbconfig.php');

if(!isset($_SESSION["client_user_name"]) || (trim($_SESSION['client_user_name']) == "")){
    header("Location: ../auth/");
    exit();
}

?>
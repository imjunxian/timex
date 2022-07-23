<?php
include('../../../dbconfig.php');

if($db){
    // echo "Database Connected";

}else{
    echo "Firebase not Connected.";
}

if(!isset($_SESSION["user_id"]) || (trim($_SESSION['user_id']) == "")){
    header("Location: ../auth/");
    exit();
}

?>
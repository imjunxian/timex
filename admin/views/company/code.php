<?php
include('../../database/dbconfig.php');

if (isset($_POST['editInfo_btn'])){

    $email = $_POST['email'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $fee = $_POST['shipping_fee'];
    $id = "Qwh7lii8yRbpD62j6u1R";

    $updateInfo = [
	    'email'=> $email,
        'name' => $name,
        'contact' => $contact,
        'address' => $address,
        'shipping_fee' => $fee,
    ];

    $queryDoc = $db->collection('company');

    try{
        if(empty($email) || empty($name) || empty($contact) || empty($address) || empty($fee)){
            $_SESSION['danger'] = 'All fields are required.';
            header("Location: ../company/");
            exit();
        }else{
            $updateCompany = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
            if($updateCompany){
                $_SESSION['success'] = 'Company Details Updated Successfully.';
                header("Location: ../company/");
                exit();
            }else{
                $_SESSION['danger'] = 'Company Details Updated Failed. Please try again.';
                header("Location: ../company/");
                exit();
            }
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }

}



?>
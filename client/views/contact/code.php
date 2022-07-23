<?php
include '../../database/dbconfig.php';

//Login
if(isset($_POST['sendBtn'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$status = "Pending";
	date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');

	$addInfo = [
        'name'=> $name,
        'email' => $email,
        'subject' => $subject,
        'status'=> $status,
        'message' => $message,
        'dateTime'=>$dateTime,
    ];

    $queryDoc = $db->collection('contacts');
    try{
		if(empty($name) || empty($email) || empty($subject) || empty($message)){
    		$_SESSION['danger'] = 'All fields are required.';
            header('Location: ../contact/');
            exit();
	    }else{
			$add = $queryDoc->add($addInfo);
	        if($add){
	            $_SESSION['success'] = 'Message sent successfully';
	            $_SESSION['contactMessage'] = 'Thank you. We had received your message and we will reply you as soon as possible.';
	            header('Location: ../contact/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Something went wrong. Please try again.';
	            header('Location: ../contact/');
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

?>
<?php
include '../../database/dbconfig.php';

//Update Profile
if(isset($_POST['updateProfileBtn'])){

    $id = $_SESSION['client_user_id'];
    $name = $_POST['username'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $queryDoc = $db->collection('customers');

    $updateInfo = [
	    'name'=> $name,
	    'dob' => $dob,
	    'gender' => $gender,
	    'contact' => $contact,
	    'address' => $address,
    ];

    try{
		if(empty($name) || empty($address) || empty($dob) || empty($gender) || empty($contact)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../profile/");
            exit();
	    }else{
			$update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);

	        if($update){
	            $_SESSION['success'] = 'Profile Updated Successfully.';
	            header('Location: ../profile/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Profile Updated Failed. Please try again.';
	            header("Location: ../profile/");
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }

}

//Update Email
if(isset($_POST['updateEmailBtn'])){

    $id = $_SESSION['client_user_id'];
    $email = $_POST['email'];

    $queryDoc = $db->collection('customers');

    $updateInfo = [
	    'email'=> $email,
    ];

    $queryEmailRef = $queryDoc->where('email', '==', $email);
	$checkEmail = $queryEmailRef->documents();

    try{
        if(!$checkEmail -> isEmpty()){
    		$_SESSION['danger'] = 'Email already exists. Please try again.';
            header('Location: ../profile/');
    	}else{
            if(empty($email)){
                $_SESSION['danger'] = 'Email are required.';
                header("Location: ../profile/");
                exit();
            }else{
                $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);

                if($update){
                    $_SESSION['success'] = 'Email Updated Successfully.';
                    header('Location: ../profile/');
                    exit();
                }else{
                    $_SESSION['danger'] = 'Email Updated Failed. Please try again.';
                    header("Location: ../profile/");
                    exit();
                }
            }
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Deactivate Account
if(isset($_POST['deactivateBtn'])){

    $id = $_SESSION['client_user_id'];
    $status = "Closed";

    $queryDoc = $db->collection('customers');

    $updateInfo = [
	    'status'=> $status,
    ];

    try{
        $update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
        if($update){
            $_SESSION['success'] = 'Account Deactivated.';
            header('Location: ../profile/');
            unset($_SESSION['editid']);
            exit();
        }else{
            $_SESSION['danger'] = 'Account Deactivate Failed. Please try again.';
            header("Location: ../profile/");
            exit();
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }

}

//Update Password
if (isset($_POST['updatePasswordBtn'])){

    $id = $_SESSION['client_user_id'];
    $oldpass = $_POST['currentPassword'];
    $newpassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    //$newhpassword = password_hash($newpassword, PASSWORD_DEFAULT);
    $encryptPassword = $rsa->privEncrypt($newpassword);

    if($newpassword != '' && $cpassword != '' && $newpassword == $cpassword && $oldpass != ''){
        //get current user password from database
        $docRef = $db->collection('customers');
        $row = $docRef->document($id)->snapshot();

        if($row -> exists()){
            $dbpass = $row['password'];
            $decrypt = $rsa->publicDecrypt($dbpass);
            //current password must corrent then update
            if($decrypt === $oldpass){
                $updatePassword = [
            		'password' => $encryptPassword,
            	];
                $query_newpass_run = $docRef->document($id)->set($updatePassword, ['merge' => true]);
                if ($query_newpass_run) {
                    $_SESSION['success'] = 'Password Updated Successfully.';
                    header("Location: ../profile/");
                } else {
					$_SESSION['danger'] = 'Password Not Match.';
	                header("Location: ../profile/");
                }
            }else{
                $_SESSION['danger'] = "Invalid Current Password. Please try again.";
                header("Location: ../profile/");
            }
        }
    }else{
        $_SESSION['danger'] = 'All fields are required.';
	    header("Location: ../profile/");
    }
}

if (isset($_POST['submitReturnBtn'])){

	$img = $_FILES["return_img"]["name"];
	$storeName = $_FILES["return_img"]["tmp_name"];
	$dir = "../../../admin/dist/img/return/";
	$target_file = $dir . basename($img);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$error = $_FILES["return_img"]["error"];
	$exist = file_exists($target_file);

    $orderid = $_POST["return_order_id"];
    $orderNum = $_POST["return_order_no"];
    $reason = $_POST["return_reason"];
    $cust_id = $_SESSION['client_user_id'];
    $status = "Pending";
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $datetime = date('d M Y H:i:s');

    $returnDocRef = $db->collection('returns');

    $addInfo = [
        'order_id' => $orderid,
        'order_no' => $orderNum,
        'customer_id' => $cust_id,
        'image_url' => $img,
        'reason' => $reason,
        'datetime' => $datetime,
        'status' => $status,
    ];

    try{
    	if($reason == ""){
            $_SESSION['danger'] = 'All fields are required.';
            header('Location: ../profile/');
            exit();
        }else{
            $add = $returnDocRef->add($addInfo);
            if($add){
                move_uploaded_file($storeName, $target_file);
                $_SESSION['success'] = 'Your Request is submitted successfully';
                header('Location: ../profile/');
                exit();
            }else{
                $_SESSION['danger'] = 'Something went wrong. Please try again.';
                header('Location: .../profile/');
                exit();
            }
    	}
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//ajax
if(isset($_POST["orderId"])){
	$id = $_POST['orderId'];
	$getData = $db->collection('orders')->document($id)->snapshot();
	if ($getData->exists()) {
        $order_id = $getData->id();
        $getOrderItem = $db->collection('order_item')->where("order_id", '=', $order_id)->documents();
        foreach($getOrderItem as $ordItem){
            $prod_id = $ordItem["product_id"];
            $getProductData = $db->collection('products')->document($prod_id)->snapshot();
            $product = $getProductData->data();
            $order=$getData->data();
            $orderItem=$ordItem->data();
            $data = array_merge($product, $orderItem, $order);
            echo json_encode($data);
        }
	}
}
?>
<?php
include('../../database/dbconfig.php');

//Delete Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	$deleteDoc = $db->collection('reviews')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Review Deleted Successfully.';
            header('Location: ../reviews/');
            exit();
		}else{
			$_SESSION['danger'] = 'Review Delete Failed. Please try again.';
            header('Location: ../reviews/');
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["action"])){
	$average_rating = 0;
	$total_review = 0;
	$five_star_review = 0;
	$four_star_review = 0;
	$three_star_review = 0;
	$two_star_review = 0;
	$one_star_review = 0;
	$total_user_rating = 0;
	$review_content = array();

    $recordReview= $db->collection('reviews')->where('status', '==', 'Approved');
    $record_review = $recordReview->documents();

	foreach($record_review as $row){

		if($row["rating"] == '5'){
			$five_star_review++;
		}
		if($row["rating"] == '4'){
			$four_star_review++;
		}
		if($row["rating"] == '3'){
			$three_star_review++;
		}
		if($row["rating"] == '2'){
			$two_star_review++;
		}
		if($row["rating"] == '1'){
			$one_star_review++;
		}

		$total_review++;
		$total_user_rating = $total_user_rating + $row["rating"];
	}
	$average_rating = $total_user_rating / $total_review;
	$output = array(
		'average_rating'	=>	number_format($average_rating, 1),
		'total_review'		=>	$total_review,
		'five_star_review'	=>	$five_star_review,
		'four_star_review'	=>	$four_star_review,
		'three_star_review'	=>	$three_star_review,
		'two_star_review'	=>	$two_star_review,
		'one_star_review'	=>	$one_star_review,
		'review_data'		=>	$review_content
	);
	echo json_encode($output);
}

//Call with AJAX to get modal data to edit
if(isset($_POST["reviewId"])){

	$id = $_POST['reviewId'];

	$getData = $db->collection('reviews')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

//Update Function
if(isset($_POST['updateBtn'])){
    $status = $_POST['editStatus'];
    $reviewId = $_POST['reviewId'];
	$replyMessage = $_POST['reply'];

    $updateInfo = [
        'status' => $status,
		'reply' => $replyMessage,
    ];

    $queryDoc = $db->collection('reviews');

    try{
    	if(empty($status)){
    		$_SESSION['danger'] = 'Status is required.';
            header('Location: ../reviews/');
            exit();
	    }else{
	    	$update = $queryDoc->document($reviewId)->set($updateInfo, ['merge' => true]);
	        if($update){
	            $_SESSION['success'] = 'Review Updated Successfully.';
	            header('Location: ../reviews/');
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Review Update Failed. Please try again.';
	            header('Location: ../reviews/');
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["submit_Btn"])){

    $s = $_POST["status"];

    if($s == "All"){
        header("Location: ../reviews/");
    }else if($s == "Pending"){
        header("Location: index.php?status=".$s);
    }else if($s == "Approved"){
        header("Location: index.php?status=".$s);
    }else if($s == "Rejected"){
        header("Location: index.php?status=".$s);
    }else{
        header("Location: ../reviews/");
    }
}

?>
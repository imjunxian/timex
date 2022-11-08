<?php
include '../../database/dbconfig.php';


/*$docRefCat = $db->collection('categories')->where('name', '=', 'Women');
$snapshotsCat = $docRefCat->documents();
foreach($snapshotsCat as $snapshot){
    $catId = $snapshot->id();
    //check whether $catId in array of which products
    $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available');
    $snapshotProd = $docRefProd->documents();
    foreach($snapshotProd as $row){
        $category_array = json_decode($row['category']);
        if(in_array($catId, $category_array)) {
            echo $row['name'];
        }
    }
}*/

if(isset($_POST["rating"])){
	$addInfo = [
        'rating'=> $_POST["rating"],
        'review' => $_POST["review"],
        'title' => $_POST["title"],
        'product_id' => $_POST["product_id"],
        'customer_id' => $_POST["customer_id"],
        'datetime' => $_POST["datetime"],
		'status' => 'Pending',
		'reply' => '',
    ];
    $queryDoc = $db->collection('reviews');
	$add = $queryDoc->add($addInfo);
    if($add){
        $_SESSION['success'] = 'Your review submitted successfully. Please kindly wait for admin to approve it.';
        header("Location: ../shop/detail.php?id={$_POST["product_id"]}");
        exit();
    }else{
        $_SESSION['danger'] = 'Your review submitted failed. Please try again.';
        header("Location: ../shop/detail.php?id={$_POST["product_id"]}");
        exit();
    }

    //echo 'Your review uploaded successfully.';
}

if(isset($_POST["review"])){
    $id = $_POST["review_id"];
    $product_id = $_POST["product_id"];
	$updateInfo = [
        'review' => $_POST["review"],
        'title' => $_POST["title"],
    ];
    $queryDoc = $db->collection('reviews');
    $update = $queryDoc->document($id)->set($updateInfo, ['merge' => true]);
    if($update){
        $_SESSION['success'] = 'Your Review Updated Successfully.';
        header("Location: ../shop/detail.php?id={$product_id}");
        exit();
    }else{
        $_SESSION['danger'] = 'Your Review Update Failed. Please try again.';
        header("Location: ../shop/detail.php?id={$product_id}");
        exit();
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

    $recordReview= $db->collection('reviews')->where('product_id', '==', $_POST['product_id'])->where('status', '==', 'Approved');
    $record_review = $recordReview->documents();

	foreach($record_review as $row){

		/*$review_content[] = array(
			'title'		=>	$row["title"],
			'review'	=>	$row["review"],
			'rating'	=>	$row["rating"],
			'datetime'	=>	date('l jS, F Y h:i:s A', $row["datetime"]),
		);*/

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

//Delete Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];
    $product_id = $_POST['product_id'];

	$deleteDoc = $db->collection('reviews')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Your Review has been Deleted Successfully.';
            header("Location: ../shop/detail.php?id={$product_id}");
        exit();
		}else{
			$_SESSION['danger'] = 'Your Review Failed to Delete. Please try again.';
            header("Location: ../shop/detail.php?id={$product_id}");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["reviewId"])){

	$id = $_POST['reviewId'];

	$getData = $db->collection('reviews')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

if(isset($_POST['searchBtn'])){
	$search = $_POST['searchResult'];
	if($search != ''){
		header("Location: ../shop/index.php?search_query={$search}");
    	exit();
	}else{
		$_SESSION['danger'] = 'Search Field is required.';
		header("Location: ../shop/");
		exit();
	}
}

if(isset($_POST['addToWishlist'])){
	$cust_id = $_SESSION['client_user_id'];
	$prod_id = $_POST['productIdOverview'];
	$stripe_prod = $_POST['stripe_id'];
	date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');

	$addInfo = [
        'product_id' => $prod_id,
        'customer_id' => $cust_id,
        'added_from' => $dateTime,
		'stripe_product_id' => $stripe_prod,
    ];
    $queryDoc = $db->collection('wishlists');

	$checkExist = $queryDoc->where('product_id', '==', $prod_id)->where('customer_id', '==', $cust_id)->documents();

	if($checkExist->isEmpty()){
		if(isset($_SESSION['client_user_id']) != ""){
			try{
				$add = $queryDoc->add($addInfo);
				if($add){
					$_SESSION['success'] = 'This product successfully added to your wishlist.';
					header("Location: ../shop/detail.php?id={$prod_id}");
					exit();
				}else{
					$_SESSION['danger'] = 'Added Fail. Please try again.';
					header("Location: ../shop/detail.php?id={$prod_id}");
					exit();
				}
			}catch(Exception $e){
				echo 'Exception: '.$e->getMessage();
			}
		}else{
			$_SESSION['danger'] = 'You need to login to complete this action.';
			header("Location: ../auth/");
			exit();
		}
	}else{
		$_SESSION['danger'] = 'You had already added this product to your wishlist.';
		header("Location: ../shop/detail.php?id={$prod_id}");
		exit();
	}
}

if(isset($_POST['addToCart'])){
	$cust_id = $_SESSION['client_user_id'];
	$prod_id = $_POST['productIdOverview'];
	$stripe_prod = $_POST['stripe_id'];
	$stripe_price = $_POST['stripe_price'];
	$quantity = $_POST['product-quantity'];
	date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateTime = date('d M Y H:i:s');

	$qtt = $_POST['quantity'];

	$addInfo = [
        'product_id' => $prod_id,
        'customer_id' => $cust_id,
        'added_from' => $dateTime,
		'quantity' => $quantity,
		'stripe_product_id' => $stripe_prod,
		'stripe_price_id' => $stripe_price,
    ];
    $queryDoc = $db->collection('carts');

	$checkExist = $queryDoc->where('product_id', '==', $prod_id)->where('customer_id', '==', $cust_id)->documents();

	if($checkExist->isEmpty()){
		if(isset($_SESSION['client_user_id']) != ""){
			if($quantity > $qtt){
				$_SESSION['danger'] = 'Quantity exceed the number of stock available.';
				header("Location: ../shop/detail.php?id={$prod_id}");
				exit();
			}elseif($qtt == 0){
				$_SESSION['danger'] = "Sorry, this product is currently out of stock.";
				header("Location: ../shop/detail.php?id={$prod_id}");
				exit();
			}else{
				try{
					$add = $queryDoc->add($addInfo);
					if($add){
						$_SESSION['success'] = 'This product successfully added to your cart.';
						header("Location: ../shop/detail.php?id={$prod_id}");
						exit();
					}else{
						$_SESSION['danger'] = 'Added Fail. Please try again.';
						header("Location: ../shop/detail.php?id={$prod_id}");
						exit();
					}
				}catch(Exception $e){
					echo 'Exception: '.$e->getMessage();
				}
			}
		}else{
			$_SESSION['danger'] = 'You need to login to complete this action.';
			header("Location: ../auth/");
			exit();
		}
	}else{
		$_SESSION['danger'] = 'You had already added this product to your cart.';
		header("Location: ../shop/detail.php?id={$prod_id}");
		exit();
	}
}
?>
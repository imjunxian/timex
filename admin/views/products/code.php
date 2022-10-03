<?php
include('../../database/dbconfig.php');

//add product
if(isset($_POST["addBtn"])){

	$image = $_POST["product_image"];
	$img = $_FILES["product_image"]["name"];
	$storeName = $_FILES["product_image"]["tmp_name"];
	$dir = "../../dist/img/productImage/";
	$target_file = $dir . basename($img);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$error = $_FILES["product_image"]["error"];
	$exist = file_exists($target_file);

	$name = $_POST["name"];
	$sku = $_POST["sku"];
	$qtt = $_POST["quantity"];
	$price = $_POST["price"];
	$cost = $_POST["cost"];
	$sdes = $_POST["sdescription"];
	$des = $_POST["description"];
	$status = $_POST["status"];
	$ava = $_POST["availability"];
	$brand = $_POST["brand"];

	date_default_timezone_set("Asia/Kuala_Lumpur");
    $datetime = date('d M Y H:i:s');
	$addDate = date('YmdHis');

	//category array
	$cat = array();
	foreach($_POST["category"] as $key => $value){
		$cat[$key] = $value;
	}
	$category = json_encode($cat);

	//attribute value array
	$attv = array();
	foreach($_POST["attvalue"] as $key => $value){
		$attv[$key] = $value;
	}
	$attvalue = json_encode($attv);

	$stripe_product = $stripe->products->create([
		'name' => $name,
		'description' => $sdes,
	]);

	$stripe_price = $stripe->prices->create([
		'unit_amount' => $price * 100,
		'currency' => 'myr',
		'product' => $stripe_product->id,
	]);

	$stripe_product_id = $stripe_product->id;
	$stripe_price_id = $stripe_price->id;

	$addInfo = [
        'name'=> $name,
        'sku' => $sku,
        'quantity' => $qtt,
        'price' => $price,
        'cost' => $cost,
		'short_description' => $sdes,
        'description' => $des,
        'status'=> $status,
        'availability' => $ava,
        'brand' => $brand,
        'attribute' => $attvalue,
        'category' => $category,
        'image_url' => $img,
		'datetime' => $datetime,
		'date' => $addDate,
		'stripe_product_id' => $stripe_product_id,
		'stripe_price_id' => $stripe_price_id,
    ];

    $queryDoc = $db->collection('products');

    $queryNameRef = $queryDoc->where('name', '==', $name);
	$checkName = $queryNameRef->documents();

	$querySKURef = $queryDoc->where('sku', '==', $sku);
	$checkSKU = $querySKURef->documents();

    try{
    	if(!$checkSKU -> isEmpty()){
    		$_SESSION['danger'] = 'Product SKU already exists. Please try again.';
            header('Location: ../products/add.php');
    	}elseif(!$checkName -> isEmpty()){
    		$_SESSION['danger'] = 'Product Name already exists. Please try again.';
            header('Location: ../products/add.php');
    	}else{
    		if(empty($name) || $qtt=="" || $price=="" || $cost=="" || empty($sdes) || empty($des) || empty($img)){
	    		$_SESSION['danger'] = 'All fields are required.';
	            header('Location: ../products/add.php');
	            exit();
		    }else{
				$add = $queryDoc->add($addInfo);
		        if($add){
		        	move_uploaded_file($storeName, $target_file);
		            $_SESSION['success'] = 'Product Added Successfully.';
		            header('Location: ../products/');
		            exit();
		        }else{
		            $_SESSION['danger'] = 'Product Add Failed. Please try again.';
		            header('Location: ../products/add.php');
		            exit();
		        }
		    }
    	}
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if (isset($_POST['editBtn'])) {
    $id = $_POST['edit_id'];
    $_SESSION['editid'] = $id;
    header("Location:edit.php?id={$id}");
}

//Update Function
if(isset($_POST['updateBtn'])){

	$img = $_FILES["product_image"]["name"];
	$storeName = $_FILES["product_image"]["tmp_name"];
	$dir = "../../dist/img/productImage/";
	$target_file = $dir . basename($img);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$error = $_FILES["product_image"]["error"];
	$exist = file_exists($target_file);

	$id = $_SESSION['editid'];
	$name = $_POST["name"];
	$sku = $_POST["sku"];
	$qtt = $_POST["quantity"];
	$price = $_POST["price"];
	$cost = $_POST["cost"];
	$sdes = $_POST["sdescription"];
	$des = $_POST["description"];
	$status = $_POST["status"];
	$ava = $_POST["availability"];
	$brand = $_POST["brand"];

	//category array
	$cat = array();
	foreach($_POST["category"] as $key => $value){
		$cat[$key] = $value;
	}
	$category = json_encode($cat);

	//attribute value array
	$attv = array();
	foreach($_POST["attvalue"] as $key => $value){
		$attv[$key] = $value;
	}
	$attvalue = json_encode($attv);

	$docRef = $db->collection('products');
	$row = $docRef->document($id)->snapshot();

	if($row->exists()){
		$stripe->products->update(
			$row['stripe_product_id'],
			['name' => $name, 'description' => $sdes],
		);
		/*$stripe->prices->update(
			$row['stripe_price_id'],
			['metadata' => ['order_id' => '6735']],
		);*/
	}

	$updateInfo = [
        'name'=> $name,
        'sku' => $sku,
        'quantity' => $qtt,
        'price' => $price,
        'cost' => $cost,
		'short_description' => $sdes,
        'description' => $des,
        'status'=> $status,
        'availability' => $ava,
        'brand' => $brand,
        'attribute' => $attvalue,
        'category' => $category,
    ];

    $queryDoc = $db->collection('products');

    try{
		if(empty($name) || $qtt=="" || $price=="" || $cost=="" || empty($des)){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../products/edit.php?id={$id}");
            exit();
	    }else{
	    	$update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
	    	if($img != null){
	        	$updateImg = [
        			'image_url' => $img,
	        	];
		        $query_img_run = $queryDoc->document($id)->set($updateImg, ['merge' => true]);
		    }
	        if($update || $query_img_run){
	        	unlink($target_file);
		        move_uploaded_file($storeName, $target_file);
	            $_SESSION['success'] = 'Product Updated Successfully.';
	            header('Location: ../products/');
	            unset($_SESSION['editid']);
	            exit();
	        }else{
	            $_SESSION['danger'] = 'Product Updated Failed. Please try again.';
	            header("Location: ../products/edit.php?id={$id}");
	            exit();
	        }
	    }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Recycle Bin Function
if(isset($_POST['recycleBtn'])){

	$id = $_POST['deleteid'];

	$updateInfo = [
	    'status'=> "Inactive",
    ];

    $queryDoc = $db->collection('products');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Product Moved to Recycle Bins';
            header("Location: ../products/");
            exit();
		}else{
			$_SESSION['danger'] = 'Product Update Failed. Please try again.';
            header("Location: ../products/");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST['recoverBtn'])){

	$id = $_POST['recover_id'];

	$updateInfo = [
	    'status'=> "Active",
    ];

    $queryDoc = $db->collection('products');
	try{
		$deleteDoc = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
		if($deleteDoc){
			$_SESSION['success'] = 'Product Recovered Successfully.';
            header("Location: ../recycle/products.php");
            exit();
		}else{
			$_SESSION['danger'] = 'Product Update Failed. Please try again.';
            header("Location: ../recycle/products.php");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Delete Function
/*if(isset($_POST['delete_btn'])){

	$id = $_POST['deleteid'];

	$deleteDoc = $db->collection('products')->document($id)->delete();
	$deleteImgDoc = $db->collection('product_images')->where('product_id', '==', $id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Product Deleted Successfully.';
            header("Location: ../recycle/products.php");
            exit();
		}else{
			$_SESSION['danger'] = 'Product Delete Failed. Please try again.';
            header("Location: ../recycle/products.php");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}*/

if(isset($_POST["submit_Btn"])){

	$s = $_POST["status"];

	if($s == "All"){
		 header("Location: ../products/");
	}else if($s == "Available"){
		header("Location: index.php?status=".$s);
	}else if($s == "Unavailable"){
		header("Location: index.php?status=".$s);
	}else if($s == "LowStock"){
		header("Location: index.php?status=".$s);
	}else if($s == "StockOut"){
		header("Location: index.php?status=".$s);
	}
}

if(isset($_POST["imgBtn"])){

	$image = $_POST["product_image2"];
	$img = $_FILES["product_image2"]["name"];
	$storeName = $_FILES["product_image2"]["tmp_name"];
	$dir = "../../dist/img/productImage/";
	$target_file = $dir . basename($img);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$error = $_FILES["product_image2"]["error"];
	$exist = file_exists($target_file);

	$id = $_SESSION['editid'];

	$alt = $_POST["alt"];
	$title = $_POST["title"];
	$status = $_POST["status"];

	$addInfo = [
        'product_id'=> $id,
        'image_url' => $img,
		'alt' => $alt,
		'title' => $title,
		'status' => $status,
	];

    $queryDoc = $db->collection('product_images');

	try{
		if(empty($img)){
			$_SESSION['danger'] = 'Image is required';
			header("Location: ../products/edit.php?id=$id");
			exit();
		}else{
			$add = $queryDoc->add($addInfo);
			if($add){
				move_uploaded_file($storeName, $target_file);
				$_SESSION['success'] = 'Image Added Successfully.';
				header("Location: ../products/edit.php?id=$id");
				exit();
			}else{
				$_SESSION['danger'] = 'Image Add Failed. Please try again.';
				header("Location: ../products/edit.php?id=$id");
				exit();
			}
		}
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

if(isset($_POST["deleteImgBtn"])){

	$id = $_POST['deleteid'];

	$deleteDoc = $db->collection('product_images')->document($id)->delete();

	try{
		if($deleteDoc){
			$_SESSION['success'] = 'Image Deleted Successfully.';
            header("Location: ../products/edit.php?id=$id");
            exit();
		}else{
			$_SESSION['danger'] = 'Image Delete Failed. Please try again.';
            header("Location: ../products/edit.php?id=$id");
            exit();
		}
	}catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }
}

//Call with AJAX to get modal data to edit
if(isset($_POST["imgId"])){

	$id = $_POST['imgId'];

	$getData = $db->collection('product_images')->document($id)->snapshot();

	if ($getData->exists()) {
		echo json_encode($getData->data());
	}
}

if(isset($_POST["updateImgBtn"])){

	$img = $_FILES["product_image3"]["name"];
	$storeName = $_FILES["product_image3"]["tmp_name"];
	$dir = "../../dist/img/productImage/";
	$target_file = $dir . basename($img);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$error = $_FILES["product_image3"]["error"];
	$exist = file_exists($target_file);

	$id = $_POST['imageId'];

	$prodId = $_SESSION['editid'];

	$alt = $_POST["editAlt"];
	$title = $_POST["editTitle"];
	$status = $_POST["editStatus"];

	$updateInfo = [
		'alt' => $alt,
		'title' => $title,
		'status' => $status,
	];

	$updateImg = [
		'image_url' => $img,
		'alt' => $alt,
		'title' => $title,
		'status' => $status,
	];

    $queryDoc = $db->collection('product_images');

	try{
		if($alt=="" || $title==""){
    		$_SESSION['danger'] = 'All fields are required.';
            header("Location: ../products/edit.php?id={$prodId}");
            exit();
	    }else{
	    	if($img != null){
		        $query_img_run = $queryDoc->document($id)->set($updateImg, ['merge' => true]);
				if($query_img_run){
					unlink($target_file);
					move_uploaded_file($storeName, $target_file);
					$_SESSION['success'] = 'Image Updated Successfully.';
					header("Location: ../products/edit.php?id={$prodId}");
					exit();
				}else{
					$_SESSION['danger'] = 'Image Updated Failed. Please try again.';
					header("Location: ../products/edit.php?id={$prodId}");
					exit();
				}
		    }else{
				$update = $queryDoc->document($id)->set($updateInfo, ['merge'=>true]);
				if($update){
					$_SESSION['success'] = 'Image Updated Successfully.';
					header("Location: ../products/edit.php?id={$prodId}");
					exit();
				}else{
					$_SESSION['danger'] = 'Image Updated Failed. Please try again.';
					header("Location: ../products/edit.php?id={$prodId}");
					exit();
				}
			}
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
?>
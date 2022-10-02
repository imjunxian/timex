<?php
include '../../database/dbconfig.php';

//Login
if(isset($_POST['codBtn'])){

    //Order
    $orderSubtotal = $_POST['orderSubtotal'];
    $orderSubcost = $_POST['orderSubcost'];
    $sales = $_POST['orderTotal'];
    $profit = $_POST['profit'];
    $note = $_POST['note'];
    $shipping_fee = $_POST['shipping_fee'];
    $orderNo = $_POST['orderNo'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $orderDateTime = date('d M Y H:i:s');
    $paymentMethods = "COD";
    $paymentStatus = "Pending";
    $orderStatus = "Pending";
    $customer_id = $_SESSION['client_user_id'];

    $addInfo = [
        'customer_id'=> $customer_id,
        'note' => $note,
        'orderDateTime' => $orderDateTime,
        'order_no' => $orderNo,
        'order_status' => $orderStatus,
		'payment_method' => $paymentMethods,
        'payment_status' => $paymentStatus,
        'profits'=> $profit,
        'shipping_fee' => $shipping_fee,
        'subcost' => $orderSubcost,
        'subtotal' => $orderSubtotal,
        'sales' => $sales,
		//'stripe_product_id' => $stripe_product_id,
		//'stripe_price_id' => $stripe_price_id,
    ];

    $orderQueryDoc = $db->collection('orders');
    $orderItemQueryDoc = $db->collection('order_item');
    $productQueryDoc = $db->collection('products');
    $cartQueryDoc = $db->collection('carts');

    try {
        $addOrder = $orderQueryDoc->add($addInfo);

        if($addOrder){
            $orderRecord =  $orderQueryDoc->where('order_no', '==', $orderNo);
            $orderRecordData = $orderRecord->documents();

            //$count= $_POST["countInput"];
            $prodID = $_POST["product_id"];
            $count = count($prodID);

            for($x = 0; $x < $count; $x++) {
                //OrderItem (need foreach loop) - use orderNo to get orderID in database
                foreach($orderRecordData as $ord){
                    $order_id = $ord->id();
                }
                $product_id = $_POST['product_id'][$x];
                $stripe_product_id = $_POST['stripe_product_id'][$x];
                $orderQtt = $_POST['orderQtt'][$x];
                $productPrice = $_POST['productPrice'][$x];
                $sumProductPrice = $_POST['sumProductPrice'][$x];
                $quantityDB = $_POST['quantityDB'][$x];

                $addItemInfo = [
                    'order_id'=> $order_id,
                    'product_id' => $product_id,
                    'stripe_product_id' => $stripe_product_id,
                    'quantity' => $orderQtt,
                    'price' => $productPrice,
                    'amount' => $sumProductPrice,
                ];
                $addOrderItem = $orderItemQueryDoc->add($addItemInfo);

                //update product quantity in database after checkout
                $latestQuantity = $quantityDB - $orderQtt;
                $updateQuantity = [
                    'quantity' => $latestQuantity,
                ];
                $updateQtt = $productQueryDoc->document($product_id)->set($updateQuantity, ['merge'=>true]);

                /*$clientCart = $cartQueryDoc->where("customer_id", "=", $customer_id)->documents();
                foreach($clientCart as $cc){
                    //delete cart after checkout
                    $deleteCart = $cartQueryDoc->document($cc->id())->delete();
                }*/

                if($addOrderItem){
                    $_SESSION['success'] = 'Your Order has Placed Successfully!';
                    header('Location: ../checkout/success.php');
                    exit();
                }else{
                    $_SESSION['danger'] = 'Something went wrong. Please try again.';
                    header('Location: ../checkout/');
                    exit();
                }
            }
        }else{
            $_SESSION['danger'] = 'Something went wrong. Please try again.';
            header('Location: ../checkout/');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['danger'] = 'Something went wrong. Please try again.';
        header('Location: ../checkout/');
        exit();
    }
}

?>
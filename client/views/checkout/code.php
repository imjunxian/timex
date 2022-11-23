<?php
include '../../database/dbconfig.php';

//Cod
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
    $orderDate = date('YmdHis');
    $orderDay = date('Ymd');
    $orderMonth = date('Ym');
    $paymentMethods = "COD";
    $paymentStatus = "Pending";
    $orderStatus = "Pending";
    $customer_id = $_SESSION['client_user_id'];

    $address = $_POST['address'];

    $count =  $_POST['countInput'];

    $addInfo = [
        'customer_id'=> $customer_id,
        'note' => $note,
        'orderDateTime' => $orderDateTime,
        'orderDate' => $orderDate,
        'orderMonth' => $orderMonth,
        'orderDay' => $orderDay,
        'order_no' => $orderNo,
        'order_status' => $orderStatus,
		'payment_method' => $paymentMethods,
        //'payment_status' => $paymentStatus,
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
    $custQueryDoc = $db->collection('customers');
    $cartQueryDoc = $db->collection('carts');

    try {

        if($address != ""){

            $updateAddressInfo = [
                'address' => $address,
            ];
            $updateAddress = $custQueryDoc->document($customer_id)->set($updateAddressInfo, ['merge'=>true]);

            $addOrder = $orderQueryDoc->add($addInfo);

            if($addOrder){
                $orderRecord =  $orderQueryDoc->where('order_no', '==', $orderNo);
                $orderRecordData = $orderRecord->documents();

                //$count= $_POST["countInput"];
                /*$prodID = $_POST["product_id"];
                $count = count($prodID);*/
                //$cartDoc = $cartQueryDoc->where("customer_id", "=", $customer_id)->documents();

                //for($x = 0; $x < $count; $x++) {
                //foreach($cartDoc as $x){
                    foreach($orderRecordData as $ord){
                        $order_id = $ord->id();
                    }
                    $product_id = $_POST['product_id'];
                    $stripe_product_id = $_POST['stripe_product_id'];
                    $orderQtt = $_POST['orderQtt'];
                    $productPrice = $_POST['productPrice'];
                    $sumProductPrice = $_POST['sumProductPrice'];
                    $quantityDB = $_POST['quantityDB'];
                    $latestQuantity = $_POST['quantityUpdate'];

                    /*$product_id = $_POST['product_id'][$x];
                    $stripe_product_id = $_POST['stripe_product_id'][$x];
                    $orderQtt = $_POST['orderQtt'][$x];
                    $productPrice = $_POST['productPrice'][$x];
                    $sumProductPrice = $_POST['sumProductPrice'][$x];
                    $quantityDB = $_POST['quantityDB'][$x];*/

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
                    $i=-1;
                    foreach($product_id as $pid){
                        $i++;
                        $updateQuantity = [
                            'quantity' => $latestQuantity[$i],
                        ];
                        $updateQtt = $productQueryDoc->document($pid)->set($updateQuantity, ['merge'=>true]);
                    }

                    $clientCart = $cartQueryDoc->where("customer_id", "=", $customer_id)->documents();
                    foreach($clientCart as $cc){
                        $deleteCart = $cartQueryDoc->document($cc->id())->delete();
                    }

                    if($addOrderItem){
                        $_SESSION['success'] = 'Your Order has Placed Successfully!';
                        header('Location: ../checkout/success.php');
                        exit();
                    }else{
                        $_SESSION['danger'] = 'Something went wrong. Please try again.';
                        header('Location: ../checkout/');
                        exit();
                    }
                //}
            }else{
                $_SESSION['danger'] = 'Something went wrong. Please try again.';
                header('Location: ../checkout/');
                exit();
            }
        }else{
            $_SESSION['danger'] = 'Address is required.';
            header('Location: ../checkout/');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['danger'] = 'Something went wrong. Please try again.';
        header('Location: ../checkout/');
        exit();
    }
}

// Stripe Payment
if(isset($_POST['stripeBtn'])){

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
    $orderDate = date('YmdHis');
    $orderDay = date('Ymd');
    $orderMonth = date('Ym');
    $paymentMethods = "Card";
    $paymentStatus = "Pending";
    $orderStatus = "Pending";
    $customer_id = $_SESSION['client_user_id'];

    $_SESSION['a'] = $customer_id;
    $_SESSION['b'] = $note;
    $_SESSION['c'] = $orderDateTime;
    $_SESSION['d'] = $orderDate;
    $_SESSION['e'] = $orderMonth;
    $_SESSION['f'] = $orderDay;
    $_SESSION['g'] = $orderNo;
    $_SESSION['h'] = $orderStatus;
    $_SESSION['i'] = $paymentMethods;
    $_SESSION['j'] = $profit;
    $_SESSION['k'] = $shipping_fee;
    $_SESSION['l'] = $orderSubcost;
    $_SESSION['m'] = $orderSubtotal;
    $_SESSION['n'] = $sales;

    $address = $_POST['address'];

    $line_items = [];

    //order_items
    $product_id = $_POST['product_id'];
    $stripe_product_id = $_POST['stripe_product_id'];
    $orderQtt = $_POST['orderQtt'];
    $productPrice = $_POST['productPrice'];
    $sumProductPrice = $_POST['sumProductPrice'];
    $latestQuantity = $_POST['quantityUpdate'];

    $_SESSION['o'] = $product_id;
    $_SESSION['p'] = $stripe_product_id;
    $_SESSION['q'] = $orderQtt;
    $_SESSION['r'] = $productPrice;
    $_SESSION['s'] = $sumProductPrice;
    $_SESSION['t'] = $latestQuantity;

    $addInfo = [
        'customer_id'=> $customer_id,
        'note' => $note,
        'orderDateTime' => $orderDateTime,
        'orderDate' => $orderDate,
        'orderMonth' => $orderMonth,
        'orderDay' => $orderDay,
        'order_no' => $orderNo,
        'order_status' => $orderStatus,
		'payment_method' => $paymentMethods,
        'profits'=> $profit,
        'shipping_fee' => $shipping_fee,
        'subcost' => $orderSubcost,
        'subtotal' => $orderSubtotal,
        'sales' => $sales,
    ];

    $custQueryDoc = $db->collection('customers');
    $cartQueryDoc = $db->collection('carts');

    try{
        if($address != ""){

            $updateAddressInfo = [
                'address' => $address,
            ];
            $updateAddress = $custQueryDoc->document($customer_id)->set($updateAddressInfo, ['merge'=>true]);

            $cartDocStripe = $cartQueryDoc->where("customer_id", "=", $customer_id)->documents();
            foreach($cartDocStripe as $cart){
                $line_item = [
                    'price' => $cart['stripe_price_id'],
                    'quantity' => $cart['quantity'],
                ];
                array_push($line_items, $line_item);
            }
            $shipDoc = $db->collection('company')->document('Qwh7lii8yRbpD62j6u1R')->snapshot();
            $fee = $shipDoc['shipping_fee'];
            $checkout_session = Stripe\Checkout\Session::create([
                /*'shipping_options' => [
                    [
                      'shipping_rate_data' => [
                        'fixed_amount' => ['amount' => $fee , 'currency' => 'myr'],
                        'display_name' => 'Shipping Fee',
                        'delivery_estimate' => [
                          'minimum' => ['unit' => 'business_day', 'value' => 5],
                          'maximum' => ['unit' => 'business_day', 'value' => 7],
                        ],
                      ],
                    ],
                  ],*/
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => 'http://localhost/timex/checkout/stripe.php?checkout=success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://localhost/timex/checkout/index.php?checkout=cancel',
                'payment_method_types' => ['card'],
            ]);
            header("Location: " . $checkout_session->url);
        }else{
            $_SESSION['danger'] = 'Address is required.';
            header('Location: ../checkout/');
            exit();
        }

    }catch(Exception $ex){
        $err_ex = $ex->getMessage();
    }
}

?>
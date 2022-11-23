<?php
include '../../database/security.php';
$title = "";
include('../../includes/header.php');
?>

<?php
if(isset($_GET['checkout']) == 'success' && !empty($_GET['session_id'])){

  $session_id = $_GET['session_id'];

  try{
    $session_checkout = $stripe->checkout->sessions->retrieve($session_id);
  }catch(Exception $e){
    $api_error = $e->getMessage();
  }

  if(empty($api_error) && $session_checkout){

    $orderQueryDoc = $db->collection('orders');
    $orderItemQueryDoc = $db->collection('order_item');
    $productQueryDoc = $db->collection('products');
    $custQueryDoc = $db->collection('customers');
    $cartQueryDoc = $db->collection('carts');

    $addInfo = [
      'customer_id'=> $_SESSION['a'],
      'note' => $_SESSION['b'],
      'orderDateTime' => $_SESSION['c'],
      'orderDate' => $_SESSION['d'],
      'orderMonth' => $_SESSION['e'],
      'orderDay' => $_SESSION['f'],
      'order_no' => $_SESSION['g'],
      'order_status' => $_SESSION['h'],
      'payment_method' => $_SESSION['i'],
      'profits'=> $_SESSION['j'],
      'shipping_fee' => $_SESSION['k'],
      'subcost' => $_SESSION['l'],
      'subtotal' => $_SESSION['m'],
      'sales' => $_SESSION['n'],
    ];

    $addOrder = $orderQueryDoc->add($addInfo);

    if($addOrder){

      $orderRecord =  $orderQueryDoc->where('order_no', '==', $_SESSION['g']);
      $orderRecordData = $orderRecord->documents();

      foreach($orderRecordData as $ord){
          $order_id = $ord->id();
      }

      $addItemInfo = [
          'order_id'=> $order_id,
          'product_id' => $_SESSION['o'],
          'stripe_product_id' => $_SESSION['p'],
          'quantity' => $_SESSION['q'],
          'price' => $_SESSION['r'],
          'amount' => $_SESSION['s'],
      ];
      $addOrderItem = $orderItemQueryDoc->add($addItemInfo);

      $clientCart = $cartQueryDoc->where("customer_id", "=", $_SESSION['a'])->documents();
      foreach($clientCart as $cc){
          $deleteCart = $cartQueryDoc->document($cc->id())->delete();
      }

      $i=-1;
      foreach($_SESSION['o'] as $pid){
          $i++;
          $updateQuantity = [
              'quantity' => $_SESSION['t'][$i],
          ];
          $updateQtt = $productQueryDoc->document($pid)->set($updateQuantity, ['merge'=>true]);
      }

    }
  }

  unset($_SESSION['a']);
  unset($_SESSION['b']);
  unset($_SESSION['c']);
  unset($_SESSION['d']);
  unset($_SESSION['e']);
  unset($_SESSION['f']);
  unset($_SESSION['g']);
  unset($_SESSION['h']);
  unset($_SESSION['i']);
  unset($_SESSION['j']);
  unset($_SESSION['k']);
  unset($_SESSION['l']);
  unset($_SESSION['m']);
  unset($_SESSION['n']);
  unset($_SESSION['o']);
  unset($_SESSION['p']);
  unset($_SESSION['q']);
  unset($_SESSION['r']);
  unset($_SESSION['s']);
  unset($_SESSION['t']);

  ?>
  <script>window.location.replace('../checkout/success.php?checkout=success')</script>
  <?php

}

?>
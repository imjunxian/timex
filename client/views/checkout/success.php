<?php
include '../../database/security.php';
$title = "Thank You";
include('../../includes/header.php');
include('../../includes/navbar.php');
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

}

?>

<style>
.card-category {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}
.card-category .card {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.card .card-body {
  flex: 0 50%;
  background: #fff;
  box-shadow: 0 2px 4px 0 rgba(136, 144, 195, 0.2),
    0 5px 15px 0 rgba(37, 44, 97, 0.15);
  border-radius: 15px;
  margin: 8px;
  padding: 10px 15px;
  position: relative;
  z-index: 1;
  overflow: hidden;
  min-height: 420px;
  transition: 0.7s;
}

.card .card-body:hover::before {
  background: rgb(85 108 214 / 10%);
}

.card .card-body:hover .solu_title h3,
.card .card-body:hover .solu_description p {
  color: #fff;
}

.card .card-body:before {
  content: "";
  position: absolute;
  background: rgb(85 108 214 / 5%);
  width: 170px;
  height: 400px;
  z-index: -1;
  transform: rotate(42deg);
  right: -56px;
  top: -23px;
  border-radius: 35px;
}

.card .card-body:hover .solu_description button {
  background: #fff !important;
  color: #309df0;
}

.card-body .solu_title h3 {
  color: #212121;
  font-size: 1.3rem;
  margin-top: 13px;
  margin-bottom: 13px;
}

.card .solu_description p {
  font-size: 15px;
  margin-bottom: 15px;
}

.card .solu_description button {
  border: 0;
  border-radius: 15px;
  background: linear-gradient(
    140deg,
    #42c3ca 0%,
    #42c3ca 50%,
    #42c3cac7 75%
  ) !important;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 5px 16px;
}

@media only screen and (max-width: 946px){
    .card .card-body {
        min-height: 360px;
    }
 }

 @media only screen and (max-width: 620px){
    .card .card-body {
        min-height: 430px;
    }
 }

 @media only screen and (max-width: 446px){
    .card .card-body {
        min-height: 480px;
    }
 }
</style>

<section class="page-wrapper success-msg">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="card-category">
            <div class="card">
                <div class="card-body">
                    <div class="block text-center" style="padding:5rem;">
                        <i class="tf-ion-android-checkmark-circle"></i>
                        <h2 class="text-center">Thank you! For Choosing Us.</h2>
                        <p>Your order has been placed! You'll receive your items soon.</p>
                        <a href="../shop/" class="btn btn-main mt-20">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>


<?php
include '../../database/security.php';
$title = "Checkout";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<?php
if(isset($_GET['checkout']) == 'cancel'){

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

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Checkout</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li><a href="../cart/">Cart</a></li>
            <li class="active">Checkout</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<form action="code.php" method="POST" id="billingForm">
    <div class="page-wrapper">
       <div class="checkout shopping">
          <div class="container">
             <div class="row">
                <div class="col-md-4">
                   <div class="product-checkout-details">
                    <div class="block">
                      <h4 class="widget-title">Order Summary</h4>
                      <?php
                      $docRefCart = $db->collection('carts')->where('customer_id', '=', $_SESSION['client_user_id']);
                      $snapshotCart = $docRefCart->documents();
                      $subtotal = 0;
                      $subcost = 0;
                      foreach($snapshotCart as $rowCart){
                        $docRefProd = $db->collection('products')->where('stripe_product_id', '==', $rowCart['stripe_product_id'])->where('status', '=', 'Active')->where('availability', '=', 'Available');
                        $snapshotProd = $docRefProd->documents();
                        foreach($snapshotProd as $row){
                          $total_price_per_prod = $row['price'] * $rowCart['quantity'];
                          $subtotal += $total_price_per_prod;

                          $total_cost_per_prod = $row['cost'] * $rowCart['quantity'];
                          $subcost += $total_cost_per_prod;

                          $quantityDB = $row['quantity'];
                          $latestQtt = $quantityDB - $rowCart['quantity'];
                          ?>
                          <div class="media product-card">
                            <span class="pull-left">
                              <img class="media-object" src="../admin/dist/img/productImage/<?=$row['image_url']?>" alt="Image" />
                            </span>
                            <div class="media-body" id="countProduct">
                                <input type="hidden" value="<?=$row->id()?>" name="product_id[]" id="product_id" required>
                                <input type="hidden" value="<?=$row['stripe_product_id']?>" name="stripe_product_id[]" id="stripe_product_id" required>
                                <input type="hidden" value="<?=$row['stripe_price_id']?>" name="stripe_price_id[]" id="stripe_price_id" required>
                                <input type="hidden" value="<?=$rowCart['quantity']?>" name="orderQtt[]" id="orderQtt" required>
                                <input type="hidden" value="<?=$total_price_per_prod?>" name="sumProductPrice[]" id="sumProductPrice" required>
                                <input type="hidden" value="<?=$row['price']?>" name="productPrice[]" id="productPrice" required>
                                <input type="hidden" value="<?=$quantityDB?>" name="quantityDB[]" id="quantityDB" required>
                                <input type="hidden" value="<?=$latestQtt?>" name="quantityUpdate[]" id="quantityUpdate" required>
                                <h4 class="media-heading"><?=$row['name']?></h4>
                                <p class="price"><?=$rowCart['quantity']?> x <?php echo "RM " . number_format($row['price'],2); ?></p>
                            </div>
                          </div>
                          <?php
                        }
                      }
                      ?>
                        <input type="hidden" name="countInput" id="countInput" value="" required>
                        <script>
                          var numItems = document.querySelectorAll('.media-body #product_id').length;
                          document.getElementById("countInput").value = numItems;
                        </script>
                        <hr>
                        <p><a class="btn btn-danger" href="../cart/">Back to cart</a></p><hr>
                        <!--<p>Have a discount ? <a data-toggle="modal" data-target="#coupon-modal" href="#!">enter it here</a></p>-->
                         <ul class="summary-prices">
                            <li>
                               <span>Subtotal:</span>
                               <span class="price"><?= "RM " . number_format($subtotal,2); ?></span>
                               <input type="hidden" value="<?=$subtotal?>" name="orderSubtotal" id="orderSubtotal" required>
                               <input type="hidden" value="<?=$subcost?>" name="orderSubcost" id="orderSubcost" required>
                            </li>
                            <li>
                               <span>Shipping:</span>
                               <span>
                                <?php
                                $id = "Qwh7lii8yRbpD62j6u1R";
                                $docRefFee = $db->collection('company')->document($id)->snapshot();
                                $shipping_fee = $docRefFee['shipping_fee'];
                                echo "RM " . number_format($shipping_fee,2);
                                ?>
                                <input type="hidden" name="shipping_fee" value="<?=$shipping_fee?>">
                               </span>
                            </li>
                         </ul>
                         <div class="summary-total">
                            <span>Total</span>
                            <?php
                            $total = $subtotal + $shipping_fee;
                            $profit = $total - $subcost;
                            ?>
                            <span><?= "RM " . number_format($total,2); ?></span>
                            <input type="hidden" value="<?=$total?>" name="orderTotal" id="orderTotal" required>
                            <input type="hidden" value="<?=$profit?>" name="profit" id="profit" required>
                         </div>
                      </div>
                   </div>
                   <div class="block">
                      <h4 class="widget-title">Notes</h4>
                      <div class="row">
                        <div class="col-md-12">
                        <textarea class="form-control rounded-0" id="note" name="note" placeholder="Write Your Note Here" rows="6"></textarea>
                        </div>
                      </div>
                   </div>
                </div>
                <div class="col-md-8">
                   <div class="block billing-details">
                      <h4 class="widget-title">Billing Details</h4>
                      <?php
                      $id = $_SESSION['client_user_id'];
                      $docRef = $db->collection('customers');
                      $row = $docRef->document($id)->snapshot();
                        if ($row->exists()) {
                        ?>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="username">Username</label>
                              <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?= $row['name'] ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                 <label for="email">Email</label>
                                 <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= $row['email'] ?>" required>
                               </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="contact">Phone Number</label>
                                 <input type="text" class="form-control" id="contact" placeholder="Phone Number, eg. +60123456789" name="contact" value="<?= $row['contact'] ?>" required>
                              </div>
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="address">Delivery Address</label>
                           <textarea class="form-control autosize" id="address" name="address" placeholder="Address" rows="6" required><?= $row['address'] ?></textarea>
                        </div>
                        <?php
                        }
                      ?>
                   </div>
                   <?php
                   $input = rand(1,9999999);
                   $orderNumber = str_pad($input, 10, "PO-", STR_PAD_LEFT);
                   ?>
                   <input type="hidden" name="orderNo" value="<?=$orderNumber?>" required>
                   <div class="block">
                      <h4 class="widget-title">Payment Method</h4>
                      <p>Select your payment method (COD / Card)</p>
                      <p class="text-danger">* Cash on Delivery only allowed for Total Price below RM 1,000.</p>
                      <div class="checkout-product-details">
                         <div class="payment">
                             <div class="card-details">
                                <?php if($total > 1000):?>
                                <button type="submit" class="btn btn-primary btn-round disabled" name="codBtn">Cash on Delivery (COD)</button>
                                <?php else: ?>
                                <button type="submit" class="btn btn-primary btn-round" name="codBtn">Cash on Delivery (COD)</button>
                                <?php endif;?>
                            </div>
                            <div class="card-details mt-10">
                            <p class="text-danger text-justify">* After clicking on the button, you will be directed to a secure gateway for payment. You will be redirected back to the website after completing the payment process.</p>
                                <button type="submit" class="btn btn-primary btn-round" name="stripeBtn">Pay by Card</button>
                            </div>
                            <!--<div class="card-details mt-10">
                                <button type="submit" class="btn btn-primary btn-round" name="paypalBtn">Payment with Paypal</button>
                            </div>-->
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</form>
   <!-- Modal -->
   <div class="modal fade" id="coupon-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body">
               <form>
                  <div class="form-group">
                     <input class="form-control" type="text" placeholder="Enter Coupon Code">
                  </div>
                  <button type="submit" class="btn btn-main">Apply Coupon</button>
               </form>
            </div>
         </div>
      </div>
   </div>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script type="text/javascript">
  $(function() {
    $('#cartTable').on('click', 'a.deleteBtn', function(e) {
      e.preventDefault();
      var link = this;
      var deleteModal = $("#deleteModal");
      // store the ID inside the modal's form
      deleteModal.find('input[name=deleteid]').val(link.dataset.id);
      // open modal
      deleteModal.modal();
    });
  });
  $(function() {
        $.validator.addMethod(
          "regex",
          function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
          },
          "Please check your input."
        );

        $('#billingForm').validate({
          rules: {
            fullname:{
              required: true,
            },
            username: {
              required: true,
            },
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            contact:{
              required: true,
              //can remove [\+]? => question mark, this means user must include + in input
              regex: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
            },
            address:{
              required: true,
            },
          },
          messages: {
            fullname:{
              required: "* Your full name is required",
            },
            username: {
              required: "* Username is required",
            },
            email: {
              required: "* Email is required",
              email: "* Invaild email",
              regex: "* Invalid email"
            },
            contact:{
              required: "* Contact is required",
              regex: "* Invalid Format. You must include your country code such as +60123456789",
            },
            address:{
              required: "* Address is required",
            },
          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
      });
</script>

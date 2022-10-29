<?php
include '../../database/security.php';
$title = "Cart";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
select.form-control:not([size]):not([multiple]) {
    height: 44px;
}
select.form-control {
    padding-right: 38px;
    background-position: center right 17px;
    background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNv…9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
    background-repeat: no-repeat;
    background-size: 9px 9px;
}
.form-control:not(textarea) {
    height: 44px;
}
.form-control {
    padding: 0 18px 3px;
    border: 1px solid #dbe2e8;
    border-radius: 22px;
    background-color: #fff;
    color: #606975;
    font-family: "Maven Pro",Helvetica,Arial,sans-serif;
    font-size: 14px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.shopping-cart,
.wishlist-table,
.order-table {
    margin-bottom: 20px
}

.shopping-cart .table,
.wishlist-table .table,
.order-table .table {
    margin-bottom: 0
}

.shopping-cart .btn,
.wishlist-table .btn,
.order-table .btn {
    margin: 0
}

.shopping-cart>table>thead>tr>th,
.shopping-cart>table>thead>tr>td,
.shopping-cart>table>tbody>tr>th,
.shopping-cart>table>tbody>tr>td,
.wishlist-table>table>thead>tr>th,
.wishlist-table>table>thead>tr>td,
.wishlist-table>table>tbody>tr>th,
.wishlist-table>table>tbody>tr>td,
.order-table>table>thead>tr>th,
.order-table>table>thead>tr>td,
.order-table>table>tbody>tr>th,
.order-table>table>tbody>tr>td {
    vertical-align: middle !important
}

.shopping-cart>table thead th,
.wishlist-table>table thead th,
.order-table>table thead th {
    padding-top: 17px;
    padding-bottom: 17px;
    border-width: 1px
}

.shopping-cart .remove-from-cart,
.wishlist-table .remove-from-cart,
.order-table .remove-from-cart {
    display: inline-block;
    color: #ff5252;
    font-size: 18px;
    line-height: 1;
    text-decoration: none
}

.shopping-cart .count-input,
.wishlist-table .count-input,
.order-table .count-input {
    display: inline-block;
    width: 100%;
    width: 86px
}

.shopping-cart .product-item,
.wishlist-table .product-item,
.order-table .product-item {
    display: table;
    width: 100%;
    min-width: 150px;
    margin-top: 5px;
    margin-bottom: 3px
}

.shopping-cart .product-item .product-thumb,
.shopping-cart .product-item .product-info,
.wishlist-table .product-item .product-thumb,
.wishlist-table .product-item .product-info,
.order-table .product-item .product-thumb,
.order-table .product-item .product-info {
    display: table-cell;
    vertical-align: top
}

.shopping-cart .product-item .product-thumb,
.wishlist-table .product-item .product-thumb,
.order-table .product-item .product-thumb {
    width: 130px;
    padding-right: 20px
}

.shopping-cart .product-item .product-thumb>img,
.wishlist-table .product-item .product-thumb>img,
.order-table .product-item .product-thumb>img {
    display: block;
    width: 100%
}

@media screen and (max-width: 860px) {
    .shopping-cart .product-item .product-thumb,
    .wishlist-table .product-item .product-thumb,
    .order-table .product-item .product-thumb {
        display: none
    }
}

.shopping-cart .product-item .product-info span,
.wishlist-table .product-item .product-info span,
.order-table .product-item .product-info span {
    display: block;
    font-size: 13px
}

.shopping-cart .product-item .product-info span>em,
.wishlist-table .product-item .product-info span>em,
.order-table .product-item .product-info span>em {
    font-weight: 500;
    font-style: normal
}

.shopping-cart .product-item .product-title,
.wishlist-table .product-item .product-title,
.order-table .product-item .product-title {
    margin-bottom: 6px;
    padding-top: 5px;
    font-size: 15px;
}

.shopping-cart .product-item .product-title>a,
.wishlist-table .product-item .product-title>a,
.order-table .product-item .product-title>a {
    transition: color .3s;
    color: #374250;
    line-height: 1.5;
    text-decoration: none
}

.shopping-cart .product-item .product-title>a:hover,
.wishlist-table .product-item .product-title>a:hover,
.order-table .product-item .product-title>a:hover {
    color: #0da9ef
}

.shopping-cart .product-item .product-title small,
.wishlist-table .product-item .product-title small,
.order-table .product-item .product-title small {
    display: inline;
    margin-left: 6px;
    font-weight: 500
}

.wishlist-table .product-item .product-thumb {
    display: table-cell !important
}

@media screen and (max-width: 576px) {
    .wishlist-table .product-item .product-thumb {
        display: none !important
    }
}

.shopping-cart-footer {
    display: table;
    width: 100%;
    padding: 10px 0;
    border-top: 1px solid #e1e7ec
}

.shopping-cart-footer>.column {
    display: table-cell;
    padding: 5px 0;
    vertical-align: middle
}

.shopping-cart-footer>.column:last-child {
    text-align: right
}

.shopping-cart-footer>.column:last-child .btn {
    margin-right: 0;
    margin-left: 15px
}

@media (max-width: 768px) {
    .shopping-cart-footer>.column {
        display: block;
        width: 100%
    }
    .shopping-cart-footer>.column:last-child {
        text-align: center
    }
    .shopping-cart-footer>.column .btn {
        width: 100%;
        margin: 12px 0 !important
    }
}

.coupon-form .form-control {
    display: inline-block;
    width: 100%;
    max-width: 235px;
    margin-right: 12px;
}

.form-control-sm:not(textarea) {
    height: 36px;
}


</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Cart</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">cart</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<form action="" method="">
  <div class="container padding-bottom-3x mb-1">
    <?php
      $docRefCart = $db->collection('carts')->where('customer_id', '=', $_SESSION['client_user_id']);
      $snapshotCart = $docRefCart->documents();
      $subtotal = 0;

      if($snapshotCart->rows() != Array()){
      ?>
      <h3 class="display-5 mb-2 text-center">Shopping Cart</h3>
      <p class="mb-5 text-center">
        <?php
        /*$result = 0;
        $numRow = [];
        foreach ($snapshotCart as $count) {
          array_push($numRow, $count->data()['product_id']);
          $result = count($numRow);
        }
        echo $result;*/
        $sum = 0;
        foreach($snapshotCart as $rowCart){
          $sum += $rowCart['quantity'];
        }
        echo $sum;
        ?>
        &nbsp;items in your cart
      </p>
      <br>
      <!-- Shopping Cart-->
      <div class="table-responsive shopping-cart">
        <table class="table" id="cartTable">
          <thead>
            <tr>
              <th>Product Image & Name</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Price per product</th>
              <th class="text-center">Subtotal</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($snapshotCart as $rowCart){
              $docRefProd = $db->collection('products')->where('stripe_product_id', '==', $rowCart['stripe_product_id'])->where('status', '=', 'Active')->where('availability', '=', 'Available');
              $snapshotProd = $docRefProd->documents();
              foreach($snapshotProd as $row){
                $total_price_per_prod = $row['price'] * $rowCart['quantity'];
                $subtotal += $total_price_per_prod;
              ?>
              <form></form>
              <tr>
                <td>
                  <input type="hidden" value="<?=$rowCart->id()?>" name="cartId" required>
                  <div class="product-item">
                    <span class="product-thumb"><img src="../admin/dist/img/productImage/<?=$row['image_url']?>" alt="Product"></span>
                    <div class="product-info">
                      <h4 class="product-title">
                        <span style="font-size:15px;"><?=$row['name']?></span>
                      </h4>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  <div class="count-input">
                    <input id="pquantity" type="hidden" value="<?=$row['quantity']?>" name="pquantity" required>
                    <input type="hidden" class="form-control" value="<?=$rowCart['quantity']?>" name="quantity" required>
                    <span class=""><?=$rowCart['quantity']?></span>
                  </div>
                </td>
                <td class="text-center text-lg text-medium"><?php echo "RM " . number_format($row['price'],2); ?></td>
                <td class="text-center text-lg text-medium"><?php echo "RM " . number_format($total_price_per_prod,2); ?></td>
                <td class="text-center">
                  <!--<button class="btn btn-primary bg-white btn-md mb-2" type="submit" name="editCart" data-toggle="tooltip" title="Edit Cart">-->
                  <a class="btn btn-primary bg-white btn-md mb-2 editBtn" data-toggle="tooltip" title="Edit Quantity" data-id="<?php echo $rowCart->id(); ?>">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" class="btn btn-danger deleteBtn" data-id="<?php echo $rowCart->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Remove Cart"></i></a>
                </td>
              </tr>
              <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <hr>
      <div class="text-right" style="margin-bottom: 30px;">
        <h4>Subtotal:</h4>
        <h3><?= "RM " . number_format($subtotal,2); ?></h3>
      </div>
      <div class="shopping-cart-footer">
        <div class="column"><a class="btn btn-outline-secondary" href="#"><a href="../shop/" class="pull-left"> <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a></div>
        <div class="column">
          <a href="../checkout/" class="btn btn-main btn-round pull-right">Checkout <i class="fas fa-arrow-right"></i></a>
          <!--<button type="submit" class="btn btn-main btn-round pull-right">Checkout</button>-->
        </div>
      </div>
      <?php
      }else{
        ?>
        <div class="row">
          <div class="col-sm-12 text-center empty-page mb-5">
              <i class="tf-ion-ios-cart-outline" style="font-size: 150px;color: #ebecee;"></i>
              <h2>Your Cart is empty!</h2>
              <p class="mb-3 pb-1">No products were added to the Cart.</p>
              <a href="../shop/" class="btn btn-main btn-medium btn-round text-center mt-20">Continue Shopping</a>
          </div>
        </div>
        <?php
      }
    ?>
  </div>
</form>
<br>
<br>
<br>

<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title pull-left" id="exampleModalLabel">Remove from Cart?</h5>
          <button class="close pull-right" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to remove it from cart.</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary pull-left" type="button" data-dismiss="modal">Cancel</button>
          <form action="code.php" method="POST">
            <input type="hidden" name="deleteid" id="deleteid" value="" />
            <button type="submit" name="recycleBtn" class="btn btn-primary pull-right">Confirm</button>
          </form>
        </div>
    </div>
  </div>
</div>

<!-- Edit Quantity Modal-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title pull-left" id="exampleModalLabel">Edit Quantity</h5>
          <button class="close pull-right" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="code.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="cartid" id="cartid" value="" />
            <div class="form-group">
              <label for="contact">Quantity</label>
              <input type="number" class="form-control" id="prodQuantity" placeholder="Quantity" name="prodQuantity" min=1 required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary pull-left" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" name="updateBtn" class="btn btn-primary pull-right">Update</button>
          </div>
        </form>
    </div>
  </div>
</div>

<!--<section class="empty-cart page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <i class="tf-ion-ios-cart-outline"></i>
            <h2 class="text-center">Your cart is currently empty.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, sed.</p>
            <a href="../shop/" class="btn btn-main btn-round mt-20">Return to shop</a>
      </div>
    </div>
  </div>
</section>-->

<!--<section class="empty-cart page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <i class="tf-ion-ios-cart-outline"></i>
            <h2 class="text-center">You need to login to view your cart.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, sed.</p>
            <a href="../auth/" class="btn btn-main btn-round mt-20">Login Now</a>
      </div>
    </div>
  </div>
</section>-->

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script type="text/javascript">
  $(document).on('click', '.deleteBtn', function() {
    let id = $(this).attr('data-id');
    $('#deleteid').val(id);
  });

  $(function () {
    var longLine = $('#product-title').text();
    $('product-title').text(longLine.slice(0,30) + '\n' + longLine.slice(100));
  });

  //AJAX for get data in modal
  $(document).ready(function(){
      $('.editBtn').on('click', function(){
          var cartId = $(this).attr("data-id");
          $.ajax({
              url:"code.php",
              type:"POST",
              data:{cartId:cartId},
              dataType: "json",
              success: function(data){
                  $('#cartid').val(cartId);
                  $('#prodQuantity').val(data.quantity);

                  $('#updateBtn').val('.editBtn');
                  $('#editForm').modal('show');
              },
              error: function (data) {
                  alert("Something went wrong");
              },
          });
      });
    });
</script>

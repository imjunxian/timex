<?php
include '../../database/security.php';
$title = "Wishlist";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Wishlist</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Wishlist</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="products section">
  <div class="container">
    <div class="row">

    <?php
		$docRefProdWish = $db->collection('wishlists')->where('customer_id', '=', $_SESSION['client_user_id']);
		$snapshotProdWish = $docRefProdWish->documents();

		foreach($snapshotProdWish as $rowWish){
      $docRefProd = $db->collection('products')->where('stripe_product_id', '==', $rowWish['stripe_product_id'])->where('status', '=', 'Active')->where('availability', '=', 'Available');
		  $snapshotProd = $docRefProd->documents();
      foreach($snapshotProd as $row){
      ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="product-item">
            <div class="product-thumb">
              <input type="hidden" value="<?= $row->id() ?>" id="wishlist_id" name="wishlist_id" required>
              <?php if($row['quantity'] == '0'): ?>
              <span class="bage">Out of Stock</span>
              <?php endif; ?>
              <img class="img-responsive" src="../admin/dist/img/productImage/<?= $row['image_url'] ?>" alt="product-img" />
              <div class="preview-meta">
                <ul>
                  <li>
                    <a href="../shop/detail.php?id=<?= $row->id() ?>" data-toggle="tooltip" title="View Details">
                      <i class="tf-ion-ios-search-strong"></i>
                    </a>
                  </li>
                  <!--<li>
                    <a href="#!" data-toggle="tooltip" title="Add to Cart"><i class="tf-ion-android-cart"></i></a>
                  </li>-->
                  <li>
                    <a href="code.php?id=<?= $rowWish->id() ?>" data-toggle="tooltip" title="Remove From Wishlist"><i class="tf-ion-ios-trash"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="product-content">
              <h4><a href="../shop/detail.php?id=<?= $row->id() ?>"><?= $row['name'] ?></a></h4>
              <p class="price"><?php echo "RM " . number_format($row['price'],2); ?></p>
            </div>
          </div>
        </div>
        <?php
        }
      }
      if($snapshotProdWish->rows() == Array()){
        ?>
        <div class="row">
          <div class="col-sm-12 text-center empty-page mb-5">
              <i class="icon tf-ion-ios-heart" style="font-size: 150px;color: #ebecee;"></i>
              <h2>Your Wishlist is empty!</h2>
              <p class="mb-3 pb-1">No products were added to the Wishlist.</p>
              <a href="../shop/" class="btn btn-main btn-medium btn-round text-center mt-20">Shop Now</a>
          </div>
        </div>
        <?php
      }
    ?>
    </div>
  </div>
</section>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

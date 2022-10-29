<?php
include '../../database/dbconfig.php';
$title = "Shop";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
.progress-label-left{
  float: left;
  margin-right: 0.5em;
  line-height: 1em;
}
.progress-label-right{
  float: right;
  margin-left: 0.3em;
  line-height: 1em;
}
.star-light{
	color:#e9ecef;
}
.text-warning {
  color: #ffc107;
}
.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}
.card-header {
  padding: 0.75rem 1.25rem;
  background-color: rgba(0,0,0,.03);
  border-bottom: 1px solid rgba(0,0,0,.125);
}
.card{
  position: relative;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0,0,0,.125);
  border-radius: 0.25rem;
}
.reply-box {
  margin-top: 0.75rem;
  background-color: #f5f5f5;
  padding: 0.875rem 0.75rem;
  position: relative;
  border-radius: 9px;
}
</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Product Details</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li><a href="../shop/">Shop</a></li>
            <li class="active">Product Details</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="single-product">
  <div class="container">
  <?php
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $docRef = $db->collection('products');
    $row = $docRef->document($id)->snapshot();

    if($row->exists()){
  ?>
    <div class="row mt-20">
      <div class="col-md-5">
        <div class="single-product-slider">
          <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
            <div class='carousel-outer'>
              <!-- me art lab slider -->
              <div class='carousel-inner '>
                <div class='item active'>
                  <img src='../admin/dist/img/productImage/<?= $row['image_url'] ?>' alt='' data-zoom-image="../admin/dist/img/productImage/<?= $row['image_url'] ?>" alt='<?=$row['name']?>' title='<?=$row['name']?>'/>
                </div>
                <?php
                $docRefImg = $db->collection('product_images')->where('product_id', '==', $_GET['id'])->where('status', '==', 'Active');
                $snapshotImg = $docRefImg->documents();
                foreach ($snapshotImg as $rowImg) {
                  if ($row->exists()) {
                    ?>
                      <div class='item'>
                        <img src='../admin/dist/img/productImage/<?= $rowImg['image_url'] ?>' alt='' data-zoom-image="../admin/dist/img/productImage/<?= $row['image_url'] ?>" alt="<?=$rowImg['alt']?>" title="<?=$rowImg['title']?>"/>
                      </div>
                    <?php
                  }
                }
                ?>
              </div>
              <!-- sag sol -->
              <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                <i class="tf-ion-ios-arrow-left"></i>
              </a>
              <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                <i class="tf-ion-ios-arrow-right"></i>
              </a>
            </div>

            <!-- thumb -->
            <ol class='carousel-indicators mCustomScrollbar meartlab'>
              <li data-target='#carousel-custom' data-slide-to='0' class='active'>
                <img src='../admin/dist/img/productImage/<?= $row['image_url'] ?>' alt='<?=$row['name']?>' title='<?=$row['name']?>'/>
              </li>
              <?php
                $docRefImg = $db->collection('product_images')->where('product_id', '==', $_GET['id'])->where('status', '==', 'Active');
                $snapshotImg = $docRefImg->documents();
                $i = 0;
                foreach ($snapshotImg as $rowImg) {
                  $i++;
                  if ($row->exists()) {
                    ?>
                      <li data-target='#carousel-custom' data-slide-to='<?= $i ?>'>
                        <img src='../admin/dist/img/productImage/<?= $rowImg['image_url'] ?>' alt='' alt="<?=$rowImg['alt']?>" title="<?=$rowImg['title']?>" />
                      </li>
                    <?php
                  }
                }
                ?>
            </ol>
          </div>
        </div>
      </div>
      <form action="code.php" method="post" id="addToForm">
        <div class="col-md-7">
          <div class="single-product-details">
            <input type="hidden" class="form-control" value="<?= $_GET["id"]?>" id="productIdOverview" name="productIdOverview">
            <input type="hidden" class="form-control" value="<?= $row["stripe_product_id"]?>" id="stripe_id" name="stripe_id">
            <h5><?= $row['sku'] ?></h5>
            <h2><?= $row['name'] ?></h2>
            <p class="product-price mt-20 h4"><?php echo "RM " . number_format($row['price'],2); ?></p>
            <p class="product-description mt-20">
              <?= $row['short_description'] ?>
            </p>

            <div class="product-category mt-20">
              <span>Brand:</span>
              <ul>
                <li style="width:100%;">
                <?php
                $brandId = $row['brand'];
                $recordB = $db->collection('brands');
                $recordBrand = $recordB->document($brandId)->snapshot();
                if($recordBrand->exists()) {
                    $brandName = $recordBrand['name'];
                    echo $brandName;
                }
                ?>
                </li>
              </ul>
            </div>

            <div class="product-category">
              <span>Category:</span>
              <ul>
                <li>
                    <?php
                    $category_data = json_decode($row['category']);
                    $recordC = $db->collection('categories')->where('status', '==', 'Active');
                    $recordCat = $recordC->documents();
                    foreach ($recordCat as $k => $v):
                        if(in_array($v->id(), $category_data)) {
                            ?>
                              <span><?= $v['name'] ?>, </span>
                            <?php
                        }
                    endforeach
                    ?>
                </li>
              </ul>
            </div>

            <div class="product-quantity">
              <span>Quantity:</span>
              <div class="product-quantity-slider">
                <input id="quantity" type="hidden" value="<?=$row['quantity']?>" name="quantity" required>
                <input id="product-quantity" type="number" min='1' max='<?=$row['quantity']?>' value="1" name="product-quantity" required>
              </div>
            </div>
            <div class="mt-20">
              <button type="submit" class="btn btn-main mt-20" name="addToWishlist"><i class="fa fa-heart"></i></button>
              <button type="submit" class="btn btn-main mt-20" name="addToCart">Add To Cart</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
			<div class="col-xs-12">
				<div class="tabCommon mt-20">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
						<li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews</a></li>
					</ul>
					<div class="tab-content patternbg">
						<div id="details" class="tab-pane fade active in">
							<h4>Product Description</h4>
							<p class="text-justify"><?= $row['description'] ?></p>
              <h4 class="mt-20">Product Specifications</h4>
              <div class="row">
                <div class="col-md-5">
                  <table class="table table-bordered mt-3">
                  <?php
                    $recordAtt = $db->collection('attributes')->where('status', '==', 'Active');
                    $record_att = $recordAtt->documents();
                    foreach($record_att as $attdata => $data_att){
                    ?>
                      <?php $attdata = json_decode($row['attribute']); ?>
                      <tbody>
                        <tr>
                          <td width="30%"><?php echo $data_att['name']?></span></td>
                          <td>
                          <?php
                            $recordAttv = $db->collection('attribute_values')->where('status', '==', 'Active')->where('parent_id', '==', $data_att->id());
                            $record_attv = $recordAttv->documents();
                            foreach($record_attv as $k => $v){
                              if(in_array($v->id(), $attdata)) {
                                echo ''.$v['name'].', ';
                              }
                            }
                          ?>
                          </td>
                        </tr>
                      </tbody>
                    <?php
                    }
                  ?>
                  </table>
                </div>
              </div>
						</div>

						<div id="reviews" class="tab-pane fade review-list">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
    		          <div class="card-header"><h4>Product Rating Overview</h4></div>
                  <br>
    		          <div class="card-body">
    			          <div class="row" style="margin:0.5em;">
                      <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                          <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                          <i class="fas fa-star star-light mr-1 main_star"></i>
                          <i class="fas fa-star star-light mr-1 main_star"></i>
                          <i class="fas fa-star star-light mr-1 main_star"></i>
                          <i class="fas fa-star star-light mr-1 main_star"></i>
                          <i class="fas fa-star star-light mr-1 main_star"></i>
                        </div>
    					          <h3><span id="total_review">0</span> Reviews</h3>
    				          </div>
    				          <div class="col-sm-4">
    					          <p>
                          <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                          <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                          <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                          </div>
                        </p>
    					          <p>
                          <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                          <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                          <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                          </div>
                        </p>
    					          <p>
                          <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                          <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                          <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                          </div>
                        </p>
    					          <p>
                          <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                          <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                          <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                          </div>
                        </p>
    					          <p>
                          <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                          <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                          <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                          </div>
                        </p>
    				          </div>
                      <?php
                        if(isset($_SESSION["client_user_name"])){
                          $resultCount = 0;
                          $numCustRow = [];
                          $recordReviewCust= $db->collection('reviews')->where('product_id', '==', $_GET['id'])->where('customer_id', '==', $_SESSION['client_user_id'])->where('status', '==', 'Approved');
                          $record_review_cust = $recordReviewCust->documents();
                          foreach ($record_review_cust as $countCust) {
                            array_push($numCustRow, $countCust->data()['customer_id']);
                            $resultCount = count($numCustRow);
                          }
                          if($resultCount == 0){
                            ?>
                            <div class="col-sm-4 text-center" style="margin-bottom:1em;">
                              <h4 class="">Write Review Here</h4>
                              <button class="btn btn-primary" data-toggle="modal" data-target="#review_modal" id="add_review" style="margin-top:3%;"><i class="fa fa-plus"></i> Review</button>
                            </div>
                            <?php
                          }elseif($resultCount >= 1){
                            echo "";
                          }
                        }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr style="border-top:2px solid #eee;">
              <h4>
                <?php
                $result = 0;
                $numRow = [];
                $recordReview= $db->collection('reviews')->where('product_id', '==', $_GET['id'])->where('status', '==', 'Approved');
                $record_review = $recordReview->documents();
                foreach ($record_review as $count) {
                  array_push($numRow, $count->data()['review']);
                  $result = count($numRow);
                }
                if($result == 0){
                  echo '<i class="tf-ion-chatbubbles"></i> No Review';
                }else{
                  echo '<i class="tf-ion-chatbubbles"></i> Product Reviews ('.$result.')';
                }
                ?>
              </h4>
              <hr style="border-top:2px solid #eee;">
							<div class="post-comments">
						    <ul class="media-list comments-list m-bot-50 clearlist">
                  <?php
                  foreach($record_review as $revdata){
                    ?>
                    <div class="review-list">
                      <div class="review-item">
                        <li class="media">
                          <div class="media-body">
                            <div class="comment-info">
                                <div class="comment-author">
                                    <span>
                                    <?php
                                    $customer_id = $revdata['customer_id'];
                                    $recordCust = $db->collection('customers');
                                    $recordCustomer = $recordCust->document($customer_id)->snapshot();
                                    if($recordCustomer->exists()) {
                                        ?><span style="font-size:16px;font-weight:450;"><?=$recordCustomer['name']?></span><?php
                                    }
                                    ?>
                                    </span>
                                </div>
                                <span class="text-justify"><?= $revdata['datetime']?></span>
                                <!--<a class="comment-button" href="#!">Reply</a>-->
                            </div>
                            <span style="font-weight:550;font-size:16px;"><?= $revdata['title']?></span>
                            <p class="text-justify" style="font-size:16px;">
                              <?= $revdata['review']?>
                              <br>
                              <span>
                                <?php
                                  for($star = 1; $star <= 5; $star++){
                                    $className = "";
                                    if($revdata['rating'] >= $star){
                                      $className = "text-warning";
                                    }else{
                                      $className = "star-light";
                                    }
                                    echo '<i class="fas fa-star '.$className.' mr-1"></i>';
                                  }
                                ?>
                              </span>
                              <?php
                                if(isset($_SESSION['client_user_id'])){
                                  if($_SESSION['client_user_id'] == $revdata['customer_id']){
                                    ?>
                                    <br><br>
                                    <a href="#" class="btn btn-primary editBtn" data-id="<?= $revdata->id() ?>" data-toggle="modal" data-target="#review_modal_edit"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit Review"></i></a>
                                    <a href="#" class="btn btn-danger deleteBtn" data-id="<?= $revdata->id()?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Delete Review"></i></a>
                                    <?php
                                  }
                                }
                              ?>
                            </p>
                            <?php
                            if($revdata['reply'] != ''){
                              ?>
                              <div class="reply-box">
                                <div style="margin-left:1%;margin-top:3px;">
                                  <span class="h5"><i class="fa fa-reply"></i> Reply from Timex Admin : </span><br>
                                  <div class="text-justify" style="font-size:16px;margin-left:1.5%;margin-top:8px;">
                                  <?= $revdata['reply']?>
                                  </div>
                                </div>
                              </div>
                              <?php
                            }
                            ?>
                          </div>
                          <hr style="border-top:2px solid #eee;">
                        </li>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </ul>
							</div>
              <?php
              if($record_review -> rows() != Array()){
                ?>
                <div class="row">
                  <div class="col-md-12" style="justify-content:center;display:flex;">
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                      </ul>
                    </nav>
                  </div>
                </div>
                <?php
              }
              ?>
						</div>

					</div>
				</div>
			</div>
		</div>
    <?php
    }else{
      ?>
      <script> location.replace("../error/404.php"); </script>
      <?php
    }
  }
  ?>
  </div>
</section>
<section class="products related-products section">
  <div class="container">
    <div class="row">
      <div class="title text-center">
        <h2>You May Also Like</h2>
      </div>
    </div>
    <div class="row">
    <?php
		$docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->where('brand', '=', $brandId)->limit(4);
		$snapshotProd = $docRefProd->documents();

		foreach($snapshotProd as $rowProd){
			if ($row->exists()) {
			?>
			<div class="col-lg-3 col-md-6 col-sm-12">
				<div class="product-item">
					<div class="product-thumb">
						<?php if($rowProd['quantity'] == '0'): ?>
						<span class="bage">Out of Stock</span>
						<?php endif; ?>
						<img class="img-responsive" src="../admin/dist/img/productImage/<?= $rowProd['image_url'] ?>" alt="product-img" />
						<div class="preview-meta">
							<ul>
								<li>
									<a href="../shop/detail.php?id=<?= $rowProd->id() ?>" data-toggle="tooltip" title="View Details">
										<i class="tf-ion-ios-search-strong"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="product-content">
						<h4><a href="../shop/detail.php?id=<?= $rowProd->id() ?>"><?= $rowProd['name'] ?></a></h4>
						<p class="price"><?php echo "RM " . number_format($rowProd['price'],2); ?></p>
					</div>
				</div>
			</div>
			<?php
			}
		}
		?>
    </div>
    <div class="col-12 text-center">
			<a href="../shop/index.php?brand=<?= $brandName ?>" class="btn btn-main btn-medium btn-round text-center mt-20">View More <?= $brandName ?> Watches</a>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="review_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Write A Review</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" id="reviewForm" method="post" >
          <div class="modal-body">
            <input type="hidden" value="<?= $_GET["id"]?>" id="product_id" name="product_id" required>
            <input type="hidden" value="<?= $_SESSION["client_user_id"]?>" id="customer_id" name="customer_id" required>
            <input type="hidden" value="<?php date_default_timezone_set("Asia/Kuala_Lumpur"); echo date('d M Y H:i:s');?>" id="datetime" name="datetime" required>
            <div class="form-group">
              <h4 class="text-center mt-3 mb-4">
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
              </h4>
            </div>
            <div class="form-group">
              <label> Title </label>
              <input type="text" class="form-control" placeholder="Title" name="title" id="title" required>
            </div>
            <div class="form-group">
              <label> Review </label>
              <textarea class="form-control" placeholder="Review" rows="5" name="review" id="review" required></textarea>
            </div>
            <div class="col-12 mt-10">
              <div class="g-recaptcha" data-sitekey="6LdBhb0dAAAAALymVbQF8NTZ7OA9pikagw7Elmwt" id="grecaptcha" data-callback="callback"></div>
            </div>
          </div>
          <!--Submit button-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" name="addBtn" id="addBtn" disabled>Submit</button>
          </div>
        </form><!--Form end-->
      </div>
  </div>
</div>

<!--Edit Modal -->
<div class="modal fade" id="review_modal_edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Your Review</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" id="editReviewForm" method="post" >
          <div class="modal-body">
            <input type="hidden" value="<?= $_GET["id"]?>" id="product_id" name="product_id" required>
            <!--<input type="hidden" value="<?= $_SESSION["client_user_id"]?>" id="customer_id" name="customer_id" required>
            <input type="hidden" value="<?php date_default_timezone_set("Asia/Kuala_Lumpur"); echo date('d M Y H:i:s');?>" id="datetime" name="datetime" required>-->
            <input type="hidden" value="" id="review_id" name="review_id" required>
            <div class="form-group">
              <label> Title </label>
              <input type="text" class="form-control" placeholder="Title" name="edit_title" id="edit_title" required>
            </div>
            <div class="form-group">
              <label> Review </label>
              <textarea class="form-control" placeholder="Review" rows="5" name="edit_review" id="edit_review" required></textarea>
            </div>
          </div>
          <!--Submit button-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" name="updateBtn" id="updateBtn">Update</button>
          </div>
        </form><!--Form end-->
      </div>
  </div>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Your Review?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to delete it.</p>
        </div>
        <form action="code.php" method="POST">
          <div class="modal-footer justify-content-between">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="deleteid" value="" id="deleteid"/>
            <input type="hidden" name="product_id" value="<?=$_GET["id"]?>" id=""/>
            <button type="submit" name="recycleBtn" class="btn btn-primary">Confirm</button>
          </div>
        </form>
    </div>
  </div>
</div>


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

<script>
  $(document).on('click', '.deleteBtn', function() {
    let id = $(this).attr('data-id');
    $('#deleteid').val(id);
  });

  if (window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }

  function callback() {
    const submitButton = document.getElementById("addBtn");
    submitButton.removeAttribute("disabled");
  }
  $(function() {
    $.validator.addMethod(
      "regex",
      function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "Please check your input."
    );

    $('#reviewForm').validate({
      rules: {
        title: {
          required: true,
        },
        review: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "* Title is required",
        },
        review: {
          required: "* Review is required",
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

<script type="text/javascript">
    function getPageList(totalPages, page, maxLength){
      function range(start, end){
        return Array.from(Array(end - start + 1), (_, i) => i + start);
      }

      var sideWidth = maxLength < 9 ? 1 : 2;
      var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
      var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

      if(totalPages <= maxLength){
        return range(1, totalPages);
      }

      if(page <= maxLength - sideWidth - 1 - rightWidth){
        return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
      }

      if(page >= totalPages - sideWidth - 1 - rightWidth){
        return range(1, sideWidth).concat(0, range(totalPages- sideWidth - 1 - rightWidth - leftWidth, totalPages));
      }

      return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
    }

    $(function(){
      var numberOfItems = $(".review-list .review-item").length;
      var limitPerPage = 5; //How many card items visible per a page
      var totalPages = Math.ceil(numberOfItems / limitPerPage);
      var paginationSize = 3; //How many page elements visible in the pagination
      var currentPage;

      function showPage(whichPage){
        if(whichPage < 1 || whichPage > totalPages) return false;

        currentPage = whichPage;

        $(".review-list .review-item").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

        $(".pagination li").slice(1, -1).remove();

        getPageList(totalPages, currentPage, paginationSize).forEach(item => {
          $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
          .toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
          .attr({href: "javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
        });

        $(".previous-page").toggleClass("disable", currentPage === 1);
        $(".next-page").toggleClass("disable", currentPage === totalPages);
        return true;
      }

      $(".pagination").append(
        $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("<<")),
        $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text(">>"))
      );

      $(".card-content").show();
      showPage(1);

      $(document).on("click", ".pagination li.current-page:not(.active)", function(){
        return showPage(+$(this).text());
      });

      $(".next-page").on("click", function(){
        return showPage(currentPage + 1);
      });

      $(".previous-page").on("click", function(){
        return showPage(currentPage - 1);
      });
    });
</script>

<script>
$(document).ready(function(){
  var rating_data = 0;

  $(document).on('mouseenter', '.submit_star', function(){
      var rating = $(this).data('rating');
      reset_background();
      for(var count = 1; count <= rating; count++){
        $('#submit_star_'+count).addClass('text-warning');
      }
  });

  function reset_background(){
    for(var count = 1; count <= 5; count++){
        $('#submit_star_'+count).addClass('star-light');
        $('#submit_star_'+count).removeClass('text-warning');
    }
  }

  $(document).on('mouseleave', '.submit_star', function(){
    reset_background();
    for(var count = 1; count <= rating_data; count++){
      $('#submit_star_'+count).removeClass('star-light');
      $('#submit_star_'+count).addClass('text-warning');
    }
  });

  $(document).on('click', '.submit_star', function(){
    rating_data = $(this).data('rating');
  });

  $('#addBtn').click(function(){
    var title = $('#title').val();
    var review = $('#review').val();
    var datetime = $('#datetime').val();
    var customer_id = $('#customer_id').val();
    var product_id = $('#product_id').val();
    if(title == '' || review == '' || rating_data == ''){
      alert("All Fields are required.");
      return false;
    }else{
      $.ajax({
        url:"code.php",
        method:"POST",
        data:{rating:rating_data, title:title, review:review, customer_id:customer_id, product_id:product_id, datetime:datetime},
        success:function(data){
          e.preventDefault();
          $('#review_modal').modal('hide');
          //load_rating_data();
          alert(data);
        }
      })
    }
  });

  $(document).ready(function(){
    $('.editBtn').on('click', function(){
      var reviewId = $(this).attr("data-id");
      $.ajax({
        url:"code.php",
        type:"POST",
        data:{reviewId:reviewId},
        dataType: "json",
        success: function(data){
            $('#review_id').val(reviewId);
            $('#edit_title').val(data.title);
            $('#edit_review').val(data.review);

            $('#updateBtn').val('.editBtn');
            $('#review_modal_edit').modal('show');
        },
      });
    });
  });

  $('#updateBtn').click(function(){
    var title = $('#edit_title').val();
    var review = $('#edit_review').val();
    var review_id = $('#review_id').val();
    var product_id = $('#product_id').val();
    if(title == '' || review == ''){
      alert("All Fields are required.");
      return false;
    }else{
      $.ajax({
        url:"code.php",
        method:"POST",
        data:{title:title, review:review, review_id:review_id, product_id:product_id},
        success:function(data){
          e.preventDefault();
          $('#editReviewForm')[0].reset();
          window.setTimeout(function(){
            window.location.reload();
          }, 1000);
        },
        error: function (data) {
          alert("Something went wrong");
        },
      })
    }
  });

  load_rating_data();

  function load_rating_data(){
    var product_id = $('#productIdOverview').val();
    $.ajax({
        url:"code.php",
        method:"POST",
        data:{action:'load_data', product_id:product_id},
        dataType:"json",
        success:function(data){
            $('#average_rating').text(data.average_rating);
            $('#total_review').text(data.total_review);

            var count_star = 0;
            $('.main_star').each(function(){
              count_star++;
              if(Math.ceil(data.average_rating) >= count_star){
                $(this).addClass('text-warning');
                $(this).addClass('star-light');
              }
            });

            $('#total_five_star_review').text(data.five_star_review);
            $('#total_four_star_review').text(data.four_star_review);
            $('#total_three_star_review').text(data.three_star_review);
            $('#total_two_star_review').text(data.two_star_review);
            $('#total_one_star_review').text(data.one_star_review);
            $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');
            $('#four_star_progress').css('width', (data.four_star_review/data.total_review) * 100 + '%');
            $('#three_star_progress').css('width', (data.three_star_review/data.total_review) * 100 + '%');
            $('#two_star_progress').css('width', (data.two_star_review/data.total_review) * 100 + '%');
            $('#one_star_progress').css('width', (data.one_star_review/data.total_review) * 100 + '%');

            /*if(data.review_data.length > 0){
            var html = '';
            for(var count = 0; count < data.review_data.length; count++){
              html += '<div class="row mb-3">';
              html += '<div class="col-sm-1"><div class="rounded-circle bg-danger text-white pt-2 pb-2"><h3 class="text-center">'+data.review_data[count].user_name.charAt(0)+'</h3></div></div>';
              html += '<div class="col-sm-11">';
              html += '<div class="card">';
              html += '<div class="card-header"><b>'+data.review_data[count].title+'</b></div>';
              html += '<div class="card-body">';
              for(var star = 1; star <= 5; star++){
                var class_name = '';
                if(data.review_data[count].rating >= star){
                  class_name = 'text-warning';
                }else{
                  class_name = 'star-light';
                }
                html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
              }
              html += '<br />';
              html += data.review_data[count].review;
              html += '</div>';
              html += '<div class="card-footer text-right">On '+data.review_data[count].datetime+'</div>';
              html += '</div>';
              html += '</div>';
              html += '</div>';
            }
          $('#review_content').html(html);
        }*/
      }
    })
  }

});

</script>
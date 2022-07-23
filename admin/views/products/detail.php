<?php
include('../../database/dbconfig.php');
$title = "Products";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
.product-description{
  text-align: justify;
}
.single-product {
  padding: 60px 0 40px;
}
.single-product .breadcrumb {
  background: transparent;
}
.single-product .breadcrumb li {
  color: #000;
  font-weight: 200;
}
.single-product .breadcrumb li a {
  color: #000;
  font-weight: 200;
}
.single-product .product-pagination li {
  display: inline-block;
  margin: 0 8px;
}
.single-product .product-pagination li + li:before {
  padding: 0 8px 0 0;
  color: #ccc;
  content: "/ ";
}
.single-product .product-pagination li a {
  color: #000;
  font-weight: 200;
}
.single-product .product-pagination li a i {
  vertical-align: middle;
}

.single-product-slider .carousel .carousel-inner .carousel-caption {
  text-shadow: none;
  text-align: left;
  top: 20%;
  bottom: auto;
}
.single-product-slider .carousel .carousel-inner .carousel-caption h1 {
  font-size: 50px;
  font-weight: 100;
  color: #000;
}
.single-product-slider .carousel .carousel-inner .carousel-caption p {
  width: 50%;
  font-weight: 200;
}
.single-product-slider .carousel .carousel-inner .carousel-caption .btn-main, .single-product-slider .carousel .carousel-inner .carousel-caption .btn-solid-border, .single-product-slider .carousel .carousel-inner .carousel-caption .btn-transparent, .single-product-slider .carousel .carousel-inner .carousel-caption .btn-small {
  margin-top: 20px;
}
.single-product-slider .carousel .carousel-control {
  bottom: auto;
  background: #fff;
  width: 6%;
  padding: 10px 0;
}
.single-product-slider .carousel .carousel-control i {
  font-size: 40px;
  text-shadow: none;
  color: #555;
}
.single-product-slider .carousel .carousel-indicators li img {
  height: auto;
  width: 60px;
}
.single-product-slider .carousel .carousel-control.right, .single-product-slider .carousel .carousel-control.left {
  background-image: none;
  top: 40%;
}

.single-product-slider .carousel-indicators {
  margin: 10px 0 0;
  overflow: auto;
  position: static;
  text-align: left;
  white-space: nowrap;
  width: 100%;
  overflow: hidden;
}
.single-product-slider .carousel-indicators li {
  background-color: transparent;
  border-radius: 0;
  display: inline-block;
  height: auto;
  margin: 0 !important;
  width: auto;
}
.single-product-slider .carousel-indicators li.active img {
  opacity: 1;
}
.single-product-slider .carousel-indicators li:hover img {
  opacity: 0.75;
}
.single-product-slider .carousel-indicators li img {
  display: block;
  opacity: 0.5;
}

.single-product-details .color-swatches {
  display: flex;
  align-items: center;
}
.single-product-details .color-swatches span {
  width: 100px;
  color: #000;
  font-size: 13px;
  font-weight: 600;
}
.single-product-details .color-swatches a {
  display: inline-block;
  width: 36px;
  height: 36px;
  margin-right: 5px;
}
.single-product-details .color-swatches li {
  display: inline-block;
}
.single-product-details .color-swatches .swatch-violet {
  background-color: #8da1cd;
}
.single-product-details .color-swatches .swatch-black {
  background-color: #000;
}
.single-product-details .color-swatches .swatch-cream {
  background-color: #e6e2d6;
}
.single-product-details .product-size {
  margin-top: 20px;
  display: flex;
  align-items: center;
}
.single-product-details .product-size span {
  width: 100px;
  color: #000;
  font-size: 13px;
  font-weight: 600;
  display: inline-block;
}
.single-product-details .product-size .form-control {
  display: inline-block;
  width: 130px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #000;
  font-size: 12px;
  border: 1px solid #e5e5e5;
  border-radius: 0px;
  box-shadow: none;
}
.single-product-details .product-category {
  margin-top: 20px;
}
.single-product-details .product-category > span {
  width: 100px;
  color: #000;
  font-size: 13px;
  font-weight: 600;
  display: inline-block;
}
.single-product-details .product-category ul {
  width: 140px;
  display: inline-block;
}
.single-product-details .product-category ul li {
  display: inline-block;
  margin: 5px;
}
.single-product-details .product-quantity {
  margin-top: 20px;
  display: flex;
  align-items: center;
}
.single-product-details .product-quantity > span {
  width: 100px;
  color: #000;
  font-size: 13px;
  font-weight: 600;
  display: inline-block;
}
.single-product-details .product-quantity .product-quantity-slider {
  width: 140px;
  display: inline-block;
}
.single-product-details .product-quantity .product-quantity-slider input {
  height: 34px;
}
.single-product-details .product-quantity .product-quantity-slider .input-group-btn:first-child > .btn, .single-product-details .product-quantity .product-quantity-slider .p-quantity .input-group-btn:first-child > .btn-group {
  margin-right: -2px;
}
.single-product-details .product-quantity .product-quantity-slider button {
  border-radius: 0;
}
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
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Product Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item"><a href="../products/">Products</a></li>
                <li class="breadcrumb-item active">Product Details</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <?php
          if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $docRef = $db->collection('products');
            $row = $docRef->document($id)->snapshot();

            if($row->exists()){
          ?>
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">View Product</h3>
              <span class="h6 float-right">Added From : <?php echo $row['datetime']?></span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                     <div class="images p-3">
                        <div class="">
                          <?php
                          echo '<a href="../../dist/img/productImage/'.$row['image_url'].'"><img src="../../dist/img/productImage/'.$row['image_url'].'" class="img-prod-detail img-fluid" alt="'.$row['name'].'" title="'.$row['name'].'" id="main-image"/></a>';
                          ?>
                        </div>
                        <div class="thumbnail mt-3">
                          <img onclick="change_image(this)" src="../../dist/img/productImage/<?=$row['image_url']?>" class="img-thumbnail" alt="<?=$row['name']?>" title="<?=$row['name']?>">
                          <?php
                          $docRefImg = $db->collection('product_images')->where('product_id', '==', $_GET['id'])->where('status', '==', 'Active');
                          $snapshotImg = $docRefImg->documents();
                          foreach ($snapshotImg as $rowImg) {
                            if ($row->exists()) {
                              ?>
                                <img onclick="change_image(this)" src="../../dist/img/productImage/<?=$rowImg['image_url']?>" class="img-thumbnail" alt="<?=$rowImg['alt']?>" title="<?=$rowImg['title']?>">
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                     <div class="col-md-6">
                      <div class="single-product-details">
                        <input type="hidden" class="form-control" value="<?= $_GET["id"]?>" id="productIdOverview" name="productIdOverview">
                        <h5><?php echo $row['sku']?></h5>
                        <br>
                        <h2><?php echo $row['name']?></h2>
                        <br>
                        <p class="product-price h5">RM <?php echo number_format($row['price'],2); ?></p>
                        <br>
                        <p class="product-description mt-20">
                        <?php $str = strip_tags($row["short_description"], ''); echo $str; ?>
                        </p>

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

                        <div class="product-category">
                          <span>Brand:</span>
                          <ul>
                              <li style="width:100%;">
                              <?php
                              $recordB = $db->collection('brands');
                              $recordBrand = $recordB->document($row['brand'])->snapshot();
                              if($recordBrand->exists()) {
                                  echo $recordBrand['name'];
                              }
                              ?>
                              </li>
                          </ul>
                        </div>

                        <div class="product-category">
                            <span>Quantity:</span>
                            <ul>
                                <li>
                                <?php echo $row['quantity']; ?>&nbsp;
                                <?php
                                    if($row['quantity'] == '1' && $row['quantity'] > '0'){
                                    ?>
                                    <span class="badge badge-warning">LowStock</span>
                                    <?php
                                    }else if($row['quantity'] == '0'){
                                    ?>
                                    <span class="badge badge-danger">StockOut</span>
                                    <?php
                                    }
                                ?>
                                </li>
                            </ul>
                        </div>
                        <div class="product-category">
                            <span>Availability:</span>
                            <ul>
                                <li>
                                <?php
                                  if($row['availability'] == 'Available'){
                                    ?>
                                    <span class="badge badge-success">Available</span>
                                    <?php
                                  }else if($row['availability'] == 'Unavailable'){
                                    ?>
                                    <span class="badge badge-warning">Unavailable</span>
                                    <?php
                                  }
                                ?>
                                </li>
                            </ul>
                        </div>

                        <br>
                        <span class="h6">Full Product Descriptions :</span>
                        <p class="mt-2 text-justify">
                        <?php $str = strip_tags($row["description"], ''); echo $str; ?>
                        </p>

                        <br>
                        <span class="h6">Product Specifications :</span>
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
            </div>
            <?php
              }else{
                ?>
                <script> location.replace("../products/index.php?idnotfound"); </script>
                <?php
              }
            }
            ?>
          </div>
          <!-- /.card -->
          <form action="code.php" method="post">
            <div class="card-footer">
              <a href="../products/" class="btn btn-secondary">Cancel</a>
              <input type="hidden" name="edit_id" value="<?php echo $row->id(); ?>">
              <button type="submit" name="editBtn" class="btn btn-primary" data-toggle="tooltip" title="Edit <?php echo $row["name"]; ?>">Edit</button>
              <a href="javascript:history.go(-1)" class="btn btn-dark float-right">Back</a>
            </div>
          </form>
        </div>
        <!--/.col (right) -->

        <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Overall Product Reviews</h2>
                <button type="button" class="btn btn-primary float-right" onclick='window.location.href="../reviews/"'>
                    <i class="fa fa-comments"></i> Reviews
                </button>
            </div>
            <div class="card-body">
              <div class="row">
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

              </div>
            </div>
          </div>
        </div>
      </div>

      </div>
      <!-- /.row -->



    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->




</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script>
  function change_image(image){
    var container = document.getElementById("main-image");
    container.src = image.src;
  }
  document.addEventListener("DOMContentLoaded", function(event) {});
</script>

<script>

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
</script>
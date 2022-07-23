<?php
include '../../database/dbconfig.php';
$title = "Shop";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Shop</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Shop</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<style type="text/css">
  .image-upload > input
{
    display: none;
}

.image-upload span
{
    width: 30px;
    font-size: 22px;
    margin-top: 5px;
    cursor: pointer;
}
</style>

<div class="container">
  <div class="row">
      <form method="POST" action="code.php">
        <div class="col-lg-6 col-md-12 col-sm-12" style="display: flex;">
          <div class="image-upload">
            <label for="file-input">
              <span class="fa fa-camera"></span>
            </label>
            <input id="file-input" type="file" />
          </div>
          <input type="search" class="form-control mx-auto" placeholder="Search..." id="searchResult" name="searchResult" required>
          <button type="submit" class="btn btn-main btn-small" name="searchBtn"><i class="fa fa-search"></i></button>
          <!--<a href="#" class="btn btn-info" onclick="startConverting();"><i class="fa fa-microphone"></i></a>-->
        </div>
      </form>
    </div>
  </div>

  <section class="products section">
    <div class="container">
      <div class="row">

        <div class="col-md-3">
          <div class="widget">
            <h4 class="widget-title">Categories</h4>
            <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <?php
                      if(isset($_GET['category']) != ""){
                        echo $_GET['category'];
                      }else{
                        echo "Select Category";
                      }
                    ?>
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <ul>
                    <?php
											$docRefBrand = $db->collection('categories')->where('status', '==', 'Active');
                      $snapshotsBrand = $docRefBrand->documents();
                      foreach($snapshotsBrand as $snapshot){
                        if ($snapshot->exists()) {
                          echo "<li><a href='../shop/index.php?category=". $snapshot['name'] ."'>" .$snapshot['name'] ."</a></li>";
                        }
                      }
										?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="widget product-category">
            <h4 class="widget-title">Brands</h4>
            <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <?php
                      if(isset($_GET['brand']) != ""){
                        echo $_GET['brand'];
                      }else{
                        echo "Select Brand";
                      }
                    ?>
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    <ul>
                    <?php
											$docRefBrand = $db->collection('brands')->where('status', '==', 'Active');
                      $snapshotsBrand = $docRefBrand->documents();
                      foreach($snapshotsBrand as $snapshot){
                        if ($snapshot->exists()) {
                          echo "<li><a href='../shop/index.php?brand=". $snapshot['name'] ."'>" .$snapshot['name'] ."</a></li>";
                        }
                      }
										?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="widget product-category">
            <h4 class="widget-title">Sort By</h4>
            <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                      <?php
                      if(isset($_GET['sort']) == "price_asc"){
                        echo "Price: Low to High";
                      }else if(isset($_GET["sort"]) == "price_desc"){
                        echo "Price: High to Low";
                      }else{
                        echo "Sort By";
                      }
                      ?>
                    </a>
                  </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                  <div class="panel-body">
                    <ul>
                      <li><a href='../shop/index.php?sort=price_asc'>Price: Low to High</a></li>
                      <li><a href='../shop/index.php?sort=price_desc'>Price: High to Low</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!--Product Lists-->
        <div class="col-md-9">
          <div class="row">
            <?php
              if(isset($_GET['brand']) != ""){
                $docRefBrand = $db->collection('brands')->where('name', '=', $_GET['brand']);
                $snapshotsBrand = $docRefBrand->documents();
                foreach($snapshotsBrand as $snapshot){
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->where('brand', '=', $snapshot->id());
                  $snapshotProd = $docRefProd->documents();
                }
              }elseif(isset($_GET['category']) != ""){
                $docRefCat = $db->collection('categories')->where('name', '=', $_GET['category']);
                $snapshotsCat = $docRefCat->documents();
                foreach($snapshotsCat as $snapshot){
                  $catId = $snapshot->id();
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available');
                  $snapshotProd = $docRefProd->documents();
                }
              }elseif(isset($_GET['sort']) != ""){
                /*if(isset($_GET['sort']) == 'price_asc'){
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->orderBy('price', 'asc');
                  $snapshotProd = $docRefProd->documents();
                }elseif(isset($_GET['sort']) == 'price_desc'){
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->orderBy('price', 'desc');
                  $snapshotProd = $docRefProd->documents();
                }*/
              }elseif(isset($_GET['search_query']) != ""){
                $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->where('name', 'array-contains', $_GET['search_query']);
                $snapshotProd = $docRefProd->documents();
              }else{
                $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available');
                $snapshotProd = $docRefProd->documents();
              }

              if(isset($_GET['category']) == ""){
                if($snapshotProd -> rows() == Array()){
                  ?>
                  <div class="row">
                    <div class="col-md-12" style="justify-content:center;display:flex;margin-top:">
                      <h3>No Product Found</h3>
                    </div>
                    <div class="col-12 text-center">
                      <a href="../shop/" class="btn btn-main btn-medium btn-round text-center mt-20">Back to Shop</a>
                    </div>
                  </div>
                  <?php
                }
                foreach($snapshotProd as $row){
                  if ($row->exists()) {
                  ?>
                  <div class="col-lg-4 col-md-8 col-sm-12 product-list">
                    <div class="product-item">
                      <div class="product-thumb">
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
                              <a href="#!" data-toggle="tooltip" title="Add to Wishlist"><i class="tf-ion-ios-heart"></i></a>
                            </li>
                            <li>
                              <a href="#!" data-toggle="tooltip" title="Add to Cart"><i class="tf-ion-android-cart"></i></a>
                            </li>-->
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
              }else{
                foreach($snapshotProd as $row){
                  $category_array = json_decode($row['category']);
                  if(in_array($catId, $category_array)) {
                    ?>
                    <div class="col-lg-4 col-md-8 col-sm-12 product-list">
                      <div class="product-item">
                        <div class="product-thumb">
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
                                <a href="#!" data-toggle="tooltip" title="Add to Wishlist"><i class="tf-ion-ios-heart"></i></a>
                              </li>
                              <li>
                                <a href="#!" data-toggle="tooltip" title="Add to Cart"><i class="tf-ion-android-cart"></i></a>
                              </li>-->
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
              }
            ?>
          </div>
          <?php if($snapshotProd -> rows() != Array()): ?>
          <div class="row">
            <div class="col-md-12" style="justify-content:center;display:flex;margin-top:3%;">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                </ul>
              </nav>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <!--Product List End-->
      </div>

    </div>
  </section>
</div>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script>
    var result = document.getElementById('searchResult');

    function startConverting () {

    if('webkitSpeechRecognition' in window) {
        var speechRecognizer = new webkitSpeechRecognition();
        speechRecognizer.continuous = true;
        speechRecognizer.interimResults = true;
        speechRecognizer.lang = 'en-US';
        speechRecognizer.start();

        var finalTranscripts = '';

        speechRecognizer.onresult = function(event) {
            var interimTranscripts = '';
            for(var i = event.resultIndex; i < event.results.length; i++){
                var transcript = event.results[i][0].transcript;
                transcript.replace("\n", "<br>");
                if(event.results[i].isFinal) {
                    finalTranscripts += transcript;
                }else{
                    interimTranscripts += transcript;
                }
            }
            result.innerHTML = finalTranscripts + '<span style="color: #999">' + interimTranscripts + '</span>';
        };
        speechRecognizer.onerror = function (event) {};
        }else {
            result.innerHTML = 'Your browser is not supported. Please download Google chrome or Update your Google chrome!!';
        }
    }
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
      var numberOfItems = $(".product-list .product-item").length;
      var limitPerPage = 9; //How many card items visible per a page
      var totalPages = Math.ceil(numberOfItems / limitPerPage);
      var paginationSize = 7; //How many page elements visible in the pagination
      var currentPage;

      function showPage(whichPage){
        if(whichPage < 1 || whichPage > totalPages) return false;

        currentPage = whichPage;

        $(".product-list .product-item").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

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
        $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Previous")),
        $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Next"))
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
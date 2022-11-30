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
      <!--<form method="POST" action="code.php">
        <div class="col-lg-6 col-md-12 col-sm-12" style="display: flex;">
          <input type="search" class="form-control mx-auto" placeholder="Search..." id="searchResult" name="searchResult" required>
          <button type="submit" class="btn btn-main btn-small" name="searchBtn"><i class="fa fa-search"></i></button>
        </div>
      </form>-->
    <div class="container">
      <form action="../shop/" method="get" id="search-form">
        <input name="search_query" onkeyup="this.value = this.value.toUpperCase();" type="text" placeholder="Search Product" autocomplete="off" autofocus>
        <!-- <button type="z  zbutton"><i class="fas fa-microphone"></i></button> --></div>
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

          <!--<div class="widget product-category">
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
          </div>-->

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
              }/*elseif(isset($_GET['sort']) != ""){
                if(isset($_GET['sort']) == 'price_asc'){
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available');
                  //$docRefProd = $db->collection('products')->orderBy('price', 'ASC');
                  $snapshotProd = $docRefProd->documents();
                }elseif(isset($_GET['sort']) == 'price_desc'){
                  $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available');
                  //$docRefProd = $db->collection('products')->orderBy('price', 'DESC');
                  $snapshotProd = $docRefProd->documents();
                }
              }*/elseif(isset($_GET['search_query']) != ""){
                $nameQueryStart = $_GET['search_query'];
                $nameQueryEnd = $_GET['search_query'].'~';
                $docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->where('name', '>=', $nameQueryStart)->where('name', '<=', $nameQueryEnd);
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
                        <?php if($row['quantity'] == '1'): ?>
                        <span class="bage">Low Stock Now</span>
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
                          <?php if($row['quantity'] == '1'): ?>
                          <span class="bage">Low Stock Now</span>
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
    //voice recognition
  const searchForm = document.querySelector("#search-form");
  const searchFormInput = searchForm.querySelector("input"); // <=> document.querySelector("#search-form input");
  const info = document.querySelector(".info");

  // The speech recognition interface lives on the browser’s window object
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition; // if none exists -> undefined

  if (SpeechRecognition) {
    console.log("Your Browser supports speech Recognition");

    const recognition = new SpeechRecognition();
    recognition.continuous = true;
    // recognition.lang = "en-US";

    searchForm.insertAdjacentHTML("beforeend", '<button class="btn btn-main" type="button"><i class="fas fa-microphone" style="font-size:15px;"></i></button>');

    const micBtn = searchForm.querySelector("button");
    const micIcon = micBtn.firstElementChild;

    micBtn.addEventListener("click", micBtnClick);

    function micBtnClick() {
      if (micIcon.classList.contains("fa-microphone")) { // Start Voice Recognition
        recognition.start(); // First time you have to allow access to mic!
      } else {
        recognition.stop();
      }
    }

    recognition.addEventListener("start", startSpeechRecognition); // <=> recognition.onstart = function() {...}
    function startSpeechRecognition() {
      micIcon.classList.remove("fa-microphone");
      micIcon.classList.add("fa-microphone-slash");
      searchFormInput.focus();
      console.log("Voice activated, SPEAK");
    }

    recognition.addEventListener("end", endSpeechRecognition); // <=> recognition.onend = function() {...}
    function endSpeechRecognition() {
      micIcon.classList.remove("fa-microphone-slash");
      micIcon.classList.add("fa-microphone");
      searchFormInput.focus();
      console.log("Speech recognition service disconnected");
    }

    recognition.addEventListener("result", resultOfSpeechRecognition); // <=> recognition.onresult = function(event) {...} - Fires when you stop talking
    function resultOfSpeechRecognition(event) {
      const current = event.resultIndex;
      transcript = event.results[current][0].transcript;
      transcript = transcript.toUpperCase();
      transcript = transcript.substr(0,transcript.length-1);

      if (transcript.toLowerCase().trim() === "stop recording") {
        recognition.stop();
      } else if (!searchFormInput.value) {
        searchFormInput.value = transcript;
      } else {
        if (transcript.toLowerCase().trim() === "go") {
          searchForm.submit();
        } else if (transcript.toLowerCase().trim() === "reset input") {
          searchFormInput.value = "";
        } else {
          searchFormInput.value = transcfript;
        }
      }
    }

    info.textContent = 'Voice Commands: "stop recording", "reset input", "go"';

  } else {
    console.log("Your Browser does not support speech Recognition");
    info.textContent = "Your Browser does not support Speech Recognition";
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
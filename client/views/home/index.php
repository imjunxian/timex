<?php
include '../../database/dbconfig.php';
$title = "Home";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<div class="hero-slider">
  <div class="slider-item th-fullpage hero-area" style="background-image: url('../client/dist/images/slider/slider2.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 text-center">
          <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">TIMEX</p>
          <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".3">The World of Time.</h1>
          <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5" class="btn" href="../shop/">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
  <div class="slider-item th-fullpage hero-area" style="background-image: url('../client/dist/images/slider/img5.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 text-left">
          <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">TIMEX</p>
          <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".3">Time with Perfection</h1>
          <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5" class="btn" href="../shop/">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
  <div class="slider-item th-fullpage hero-area" style="background-image: url('../client/dist/images/slider/img6.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 text-right">
          <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">TIMEX</p>
          <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".3">The Right Time <br>For Life</h1>
          <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5" class="btn" href="../shop/">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="product-category section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="title text-center">
					<h2>Watch Gallery</h2>
				</div>
			</div>
			<div class="col-md-6">
				<div class="category-box">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category1.png" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
				<div class="category-box">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category2.jpg" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="category-box category-box-2">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category3.jpg" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
			</div>
			<!--<div class="col-md-6">
				<div class="category-box category-box-2">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category-4.jpg" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="category-box">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category-5.jpg" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
				<div class="category-box">
					<a href="#!">
						<img src="../client/dist/images/shop/category/category-6.jpg" alt="" />
						<div class="content">
						</div>
					</a>
				</div>
			</div>
		</div>-->
	</div>
</section>

<section class="products section bg-gray">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Featured Products</h2>
			</div>
		</div>
		<div class="row">
		<?php
		$docRefProd = $db->collection('products')->where('status', '=', 'Active')->where('availability', '=', 'Available')->limit(4);
		$snapshotProd = $docRefProd->documents();

		foreach($snapshotProd as $row){
			if ($row->exists()) {
			?>
			<div class="col-lg-3 col-md-6 col-sm-12">
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
		?>
		</div>
		<div class="col-12 text-center">
			<a href="../shop/" class="btn btn-main btn-medium btn-round text-center mt-20">View More</a>
      	</div>
	</div>
</section>

<?php
include('../../includes/footer.php');
include('../../includes/script.php');
?>

<style>
.cookie-disclaimer {
  background: #000000;
  color: #FFF;
  opacity: 0.9;
  width: 100%;
  bottom: 0;
  left: 0;
  z-index: 1;
  height: 150px;
  position: fixed;
}
.cookie-disclaimer .container {
  text-align: center;
  padding-top: 20px;
  padding-bottom: 20px;
}

.cookie-disclaimer .cookie-close{
  float: right;
  padding: 10px;
  cursor: pointer;
}
</style>

<div class="cookie-disclaimer">
  <div class="cookie-close decline-cookie"><i class="fa fa-times"></i></div>
  <div class="container">
    <p>
	We use cookies on this website to distinguish you from other users. We use this data to enhance your experience and for targeted advertising. &nbsp; By continuing to use this website you consent to our use of cookies. For more information, please visit our
	<a href="../policy/privacy_policy.php" target="_blank" class="text-primary">privacy policy</a>.
	</p>
    <button type="button" class="btn btn-danger decline-cookie">Decline</button>
	<button type="button" class="btn btn-success accept-cookie">Accept</button>
  </div>
</div>

<script>
	$(document).ready(function() {
    var cookie = false;
    var cookieContent = $('.cookie-disclaimer');

    checkCookie();

    if (cookie === true) {
      cookieContent.hide();
    }

    function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toGMTString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
      }
      return "";
    }

    function checkCookie() {
      var check = getCookie("client_cookie");
      if (check !== "") {
        return cookie = true;
      } else {
          return cookie = false; //setCookie("acookie", "accepted", 365);
      }

    }
    $('.accept-cookie').click(function () {
      setCookie("client_cookie", "accepted", 365);
      cookieContent.hide(500);
    });
	$('.decline-cookie').click(function () {
      cookieContent.hide(500);
    });
});
</script>
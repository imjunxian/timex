<body id="body">

<!-- Start Top Header Bar -->
<section class="top-header">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-4">
				<div class="contact-number">
					<i class="tf-ion-ios-telephone"></i>
					<span>
						<?php
						$id = "Qwh7lii8yRbpD62j6u1R";
						$docRefInfo = $db->collection('company')->document($id)->snapshot();
						echo $docRefInfo['contact'];
						?>
					</span>
				</div>
				<div class="contact-number">
					<i class="tf-ion-ios-email"></i>
					<span><?= $docRefInfo['email'] ?></span>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<!-- Site Logo -->
				<div class="logo text-center">
					<a href="../home/">
						<!-- replace logo here -->
						<svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1" xmlns="http://www.w3.org/2000/svg"
							xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
								font-family="AustinBold, Austin" font-weight="bold">
								<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
									<text id="timex">
										<tspan x="108.94" y="325"><?= strtoupper($docRefInfo['name']) ?></tspan>
									</text>
								</g>
							</g>
						</svg>
					</a>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<!-- Cart -->
				<ul class="top-menu text-right list-inline">
					<li class="cart-nav">
						<a href="../cart/"><i class="tf-ion-android-cart"></i>Cart</a>
						<?php
						if(isset($_SESSION['client_user_id'])){
							$docRefCart = $db->collection('carts')->where('customer_id', '=', $_SESSION['client_user_id']);
							$snapshotCart = $docRefCart->documents();
							if($snapshotCart->rows() != Array()){
								$sum = 0;
								foreach($snapshotCart as $rowCart){
								  $sum += $rowCart['quantity'];
								}
								echo '('.$sum.')';
							}else{
								echo '(0)';
							}
						}else{
							echo '(0)';
						}
						?>
					</li><!-- / Cart -->

					<?php
						if(!isset($_SESSION["client_user_name"]) || (trim($_SESSION['client_user_name']) == "")){

						}else{
							?>
							<li class="cart-nav">
								<!--<form action="../../auth/code.php">
									<button type="submit" name="logout_btn"><i class="fa fa-sign-out-alt"></i> Logout</button>
								</form>-->
								<a href="../auth/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
							</li>
							<?php
						}
					?>
				</ul><!-- / .nav .navbar-nav .navbar-right -->
			</div>
		</div>
	</div>
</section><!-- End Top Header Bar -->


<!-- Main Menu Section -->
<section class="menu">
	<nav class="navbar navigation">
		<div class="container">
			<div class="navbar-header">
				<h2 class="menu-title">TIMEX</h2>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div><!-- / .navbar-header -->

			<!-- Navbar Links -->
			<div id="navbar" class="navbar-collapse collapse text-center">
				<ul class="nav navbar-nav">

					<!-- Home -->
					<li class="dropdown ">
						<a href="../home/">Home</a>
					</li><!-- / Home -->

					<li class="dropdown ">
						<a href="../about/">About</a>
					</li>

					<li class="dropdown dropdown-slide">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
							role="button" aria-haspopup="true" aria-expanded="false" onclick="window.location.href='../shop/';">Shop <span
								class="tf-ion-ios-arrow-down"></span></a>
						<div class="dropdown-menu">
							<div class="row">
								<div class="col-lg-4 col-md-4 mb-sm-3">
									<ul>
										<li class="dropdown-header">Categories</li>
										<li role="separator" class="divider"></li>
										<li><a href="../shop/">All</a></li>
										<?php
											$docRefCat = $db->collection('categories')->where('status', '==', 'Active');
					                        $snapshotsCat = $docRefCat->documents();
					                        foreach($snapshotsCat as $snapshot){
					                          if ($snapshot->exists()) {
					                            echo "<li><a href='../shop/index.php?category=". $snapshot['name'] ."'>" .$snapshot['name'] ."</a></li>";
					                          }
					                        }
										?>
									</ul>
								</div>
								<div class="col-lg-4 col-md-4 mb-sm-3">
									<ul>
										<li class="dropdown-header">Brands</li>
										<li role="separator" class="divider"></li>
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
								<div class="col-lg-4 col-sm-4 col-xs-12">
									<a href="shop.html">
										<img class="img-responsive" src="../client/dist/images/shop/gallery1.png" alt="menu image" />
									</a>
								</div>
							</div>
						</div>
					</li>

					<li class="dropdown ">
						<a href="../contact/">Contact</a>
					</li>

					<?php
						if(!isset($_SESSION["client_user_name"]) || (trim($_SESSION['client_user_name']) == "")){
						    ?>
					    	<li class="dropdown ">
								<a href="../auth/">Login</a>
							</li>
						    <?php
						}else{
							?>
							<li class="dropdown ">
								<a href="../wishlist/">Wishlist</a>
							</li>
							<li class="dropdown dropdown-slide">
								<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
									role="button" aria-haspopup="true" aria-expanded="false">
									<?php
						            echo $_SESSION['client_user_name'];
						            ?>
									<span class="tf-ion-ios-arrow-down"></span>
								</a>
								<div class="dropdown-menu">
									<div class="row">
										<!-- Basic -->
										<div class="col-lg-12 col-md-12 mb-sm-3">
											<ul>
												<li class="dropdown-header">Customer</li>
												<li role="separator" class="divider"></li>
												<li><a href="../wishlist/"><i class="fa fa-heart"></i> Wishlist</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="../profile/"><i class="fa fa-user"></i> Profile</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="../auth/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
											</ul>
										</div>
									</div><!-- / .row -->
								</div><!-- / .dropdown-menu -->
							</li><!-- / Elements -->
							<?php
						}
					?>
					<li class="dropdown ">
						<style type="text/css">
							.select {
								position: relative;
								min-width: 200px;
							}
							.select select {
								padding: 7px 40px 7px 12px;
								width: 100%;
								border: 1px solid #e8eaed;
								border-radius: 5px;
								background: #FCFCFC;
								box-shadow: 0 1px 3px -2px #9098a9;
								cursor: pointer;
								font-family: inherit;
								font-size: 16px;
								transition: all 150ms ease;
							}
							.select select:required:invalid {
								color: #5a667f;
							}
							.select select option {
								color: #223254;
							}
							.select select option[value=""][disabled] {
								display: none;
							}
							.select select:focus {
								outline: none;
								border-color: #07f;
								box-shadow: 0 0 0 2px rgba(0,0,0,0);
							}
							.select:hover {
								stroke: #07f;
							}
							#google_translate_element select {
								color: #333;
								border-style: none;
								border: 1px solid transparent;
								font-size: 13px;
								text-transform: uppercase;
								margin-top: 14px;
    							width: 95%;
							}
							.goog-logo-link {
								display: none !important;
							}
							.goog-te-gadget {
								color: transparent !important;
							}
						</style>
						<span>
							<div class="translate select" id="google_translate_element"></div>
							<script type="text/javascript">
								function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages : 'ms,zh-CN,en'}, 'google_translate_element');}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						</span>
					</li>
				</ul><!-- / .nav .navbar-nav -->

			</div>
			<!--/.navbar-collapse -->
		</div><!-- / .container -->
	</nav>
</section>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PLTSTLP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2X9N7SVVHJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2X9N7SVVHJ');
</script>
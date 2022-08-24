	<footer class="footer section text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="social-media">
						<li>
							<a href="https://www.facebook.com">
								<i class="tf-ion-social-facebook"></i>
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com">
								<i class="tf-ion-social-instagram"></i>
							</a>
						</li>
						<li>
							<a href="https://www.twitter.com">
								<i class="tf-ion-social-twitter"></i>
							</a>
						</li>
						<li>
							<a href="https://www.pinterest.com">
								<i class="tf-ion-social-pinterest"></i>
							</a>
						</li>
					</ul>
					<ul class="footer-menu">
						<li>
							<i class="tf-ion-ios-telephone"></i>
							<span><?= $docRefInfo['contact'] ?></span>
						</li>
						<li>
							<i class="tf-ion-ios-email"></i>
							<span><?= $docRefInfo['email'] ?></span>
						</li>
					</ul>
					<ul class="footer-menu text-uppercase">
						<li>
							<a href="../about/">ABOUT</a>
						</li>
						<li>
							<a href="../contact/">CONTACT</a>
						</li>
						<li>
							<a href="../shop/">SHOP</a>
						</li>
						<li>
							<a href="../policy/privacy_policy.php">Policy</a>
						</li>
						<li>
							<a href="../auth/signup.php">Create Account</a>
						</li>
						<li>
							<a href="../admin/views/auth/">Admin Login</a>
						</li>
					</ul>
					<p class="copyright-text">Copyright &copy; <?= strtoupper($docRefInfo['name']) ?> <?php echo date('Y') ?>. All rights reserved.</p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
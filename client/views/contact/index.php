<?php
include '../../database/dbconfig.php';
$title = "Contact";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Contact Us</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Contact</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="page-wrapper">
  <div class="contact-section">
    <div class="container">
      <?php
      if (isset($_SESSION['contactMessage']) && $_SESSION['contactMessage'] != '') {
            echo '
                  <div class="alert alert-success alert-common alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-check-circle"></i> ' . $_SESSION['contactMessage'] . '
                  </div>
                ';
            unset($_SESSION['contactMessage']);
        }
      ?>
      <div class="row mx-auto">
        <!-- Contact Form -->
        <div class="contact-form col-md-6 ">
          <form id="contact-form" method="post" action="code.php" role="form">

            <div class="form-group">
              <input type="text" placeholder="Your Name" class="form-control" name="name" id="name" required>
            </div>

            <div class="form-group">
              <input type="email" placeholder="Your Email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
              <input type="text" placeholder="Subject" class="form-control" name="subject" id="subject" required>
            </div>

            <div class="form-group">
              <textarea rows="6" placeholder="Message" class="form-control" name="message" id="message" required></textarea>
            </div>

            <div class="col-12 form-group">
              <div class="g-recaptcha" data-sitekey="6LdBhb0dAAAAALymVbQF8NTZ7OA9pikagw7Elmwt" id="grecaptcha" data-callback="callback"></div>
            </div>

            <div id="cf-submit">
              <button type="submit" class="btn btn-transparent btn-round" id="contact-submit" name="sendBtn" disabled>Send Message</button>
            </div>

          </form>
        </div>
        <!-- ./End Contact Form -->

        <!-- Contact Details -->
        <div class="contact-details col-md-6">
          <div class="leaflet-map">
            <div id="map" style="width:100%;height: 405px;"></div>
          </div>
          <ul class="contact-short-info mb-20">
            <li>
              <i class="tf-ion-ios-home"></i>
              <span>NoWhere, Middle of NoWhere, SomeWhere</span>
            </li>
            <li>
              <i class="tf-ion-android-phone-portrait"></i>
              &nbsp;<span>Phone: 04-3456 7890</span>
            </li>
            <li>
              <i class="tf-ion-android-mail"></i>
              <span>Email: infoTimex@demo.com</span>
            </li>
          </ul>
          <!-- Footer Social Links -->
          <div class="social-icon">
            <ul>
              <li><a class="fb-icon" href="https://www.facebook.com"><i class="tf-ion-social-facebook"></i></a></li>
              <li><a href="https://www.twitter.com"><i class="tf-ion-social-twitter"></i></a></li>
              <li><a href="https://www.instagram.com"><i class="tf-ion-social-instagram"></i></a></li>
              <li><a href="https://www.pinterest.com"><i class="tf-ion-social-pinterest-outline"></i></a></li>
            </ul>
          </div>
          <!--/. End Footer Social Links -->
        </div>
        <!-- / End Contact Details -->



      </div> <!-- end row -->
    </div> <!-- end container -->
  </div>
</section>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

<script type="text/javascript">
  var map = L.map('map').setView([5.438246026436634, 100.3100285616034], 16);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  L.marker([5.438246026436634, 100.3100285616034]).addTo(map)
      .bindPopup("This is our location.")
      .openPopup();

  function callback() {
    const submitButton = document.getElementById("contact-submit");
    submitButton.removeAttribute("disabled");
  }
</script>
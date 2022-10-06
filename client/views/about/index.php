<?php
include '../../database/dbconfig.php';
$title = "About";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">About Us</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">About</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about section">
  <div class="container">

    <div class="row">
      <div class="col-md-6">
        <img class="img-responsive" src="../client/dist/images/shop/category/img1.jpg">
      </div>
      <div class="col-md-6">
        <h2 class="">Welcome to the <?= strtoupper($docRefInfo['name']) ?>! Authentic Fashion Watches Online Store</h2>
        <p class="text-justify mt-20">
        On our site, you will find the latest and greatest timepieces from <?= strtoupper($docRefInfo['name']) ?>. Here you will discover the convenience of shopping with us and discovering that special watch you always wanted. You will also be able to skip the traffic and browse through our collection while relaxing at home or on the go with your mobile phone. We believe this is the best chance for you to learn about our newest collections of high quality and beautifully designed timepieces for yourself or your loved ones.
        </p>
        <!--<a href="../contact/" class="btn btn-main btn-round mt-20">Contact Us</a>
        <a href="../contact/" class="btn btn-main btn-round mt-20">Our Location</a>-->
      </div>
    </div>

    <br><br><br>
    <div class="row">
      <div class="col-md-6">
        <h2 class="">About <?= strtoupper($docRefInfo['name']) ?></h2>
        <p class="text-justify mt-20">
        <?= strtoupper($docRefInfo['name']) ?> is the online e-commerce which provides the best and stylish watches that suitable for all Malaysian. Our multiple decades of experience in retail and distribution of the finest quality timepieces have seen us grow tremendously. With our popularity, we would like to translate this success with the arrival of our new website. Our primary goal is to provide a 100% safe and reliable online environment for you to browse and purchase our brand new authentic watches with complete confidence.
        </p>
      </div>
      <div class="col-md-6">
        <img class="img-responsive" src="../client/dist/images/shop/category/img14.jpg">
      </div>
    </div>

    <br><br><br>
    <div class="row">
        <div class="col-md-12">
            <img class="img-responsive" src="../client/dist/images/shop/category/img8.jpg">
        </div>
    </div>

    <br><br><br>
    <div class="row">
      <div class="col-md-6">
        <img class="img-responsive" src="../client/dist/images/shop/category/img12.jpg">
      </div>
      <div class="col-md-6">
        <h2 class="">Words from Our Founders</h2>
        <p class="text-justify mt-20">
        Thank you for visiting and we hope you enjoy your online shopping experience with us. Feel free to reach us for further enquiries, servicing details, or if you can’t find the timepiece that you are looking for. We love to hear from you and are most happy to be of service.
        </p>
        <p class="text-justify">
        Please bear in mind that we wish to build a lifetime partnership with you as we work our hardest to reinforce our brand promise of lifelong support, understanding and trust with our products and our service.
        </p>
        <a href="../contact/" class="btn btn-main btn-round mt-20">Contact Us</a>
      </div>
    </div>

    <br><br><br>
    <div class="row">
      <div class="col-md-6">
        <h2 class="">Our Commitments</h2>
        <p class="text-justify mt-20">
        At <?= strtoupper($docRefInfo['name']) ?>, we are more than just a watch store, but we wanted our customers to be able in expressing their own unique personality through our product.
        </p>
        <p class="text-justify">
        <?= strtoupper($docRefInfo['name']) ?> comes up with new watch collections every now and then, providing you more choices to choose from.
        </p>
        <p class="text-justify">
        We hope <?= strtoupper($docRefInfo['name']) ?> will be part of your life’s journey in reaching your biggest dreams.
        </p>
        <a href="../shop/" class="btn btn-main btn-round mt-20" style="margin-bottom:3em;">Shop Now</a>
      </div>
      <div class="col-md-6">
        <img class="img-responsive" src="../client/dist/images/shop/category/img13.jpg">
      </div>
    </div>

    <br><br><br>
    <div class="row">
        <div class="col-md-12">
            <img class="img-responsive" src="../client/dist/images/shop/category/img4.jpg">
        </div>
    </div>

  </div>
</section>


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

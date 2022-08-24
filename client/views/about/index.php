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
        <img class="img-responsive" src="../client/dist/images/shop/gallery1.png">
      </div>
      <div class="col-md-6">
        <h2 class="">About TIMEX</h2>
        <p class="text-justify mt-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius enim, accusantium repellat ex autem numquam iure officiis facere vitae itaque.</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem.</p>
        <a href="../contact/" class="btn btn-main btn-round mt-20">Contact Us</a>
        <a href="../contact/" class="btn btn-main btn-round mt-20">Our Location</a>
      </div>
    </div>
  </div>
</section>


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

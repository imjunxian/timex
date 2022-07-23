<?php
include '../../database/dbconfig.php';
$title = "Error";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-404">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>404</h1>
          <h2>Page Not Found</h2>
          <a href="javascript:history.go(-1)" class="btn btn-main btn-round"><i class="tf-ion-android-arrow-back"></i> Go Home</a>
        </div>
      </div>
    </div>
  </section>


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

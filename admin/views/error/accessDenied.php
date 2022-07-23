<?php
include '../../database/dbconfig.php';
$title = "Access Denied";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header"></div>
  <br><br><br>
  <section class="content">     
    <h1 class="text-justify text-center"><i class="fa fa-exclamation-circle" style="color:red;"></i> Access Denied </h1><br>
    <h2 class="text-justify text-center">You have no permission to view this page.</h2><br>
    <h2 class="text-justify text-center">You may <a href="../dashboard/">CLICK HERE</a> to return. </h2>    
  </section>
</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

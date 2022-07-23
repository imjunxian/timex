 <!--
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="../client/plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.1 -->
    <script src="../client/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Touchpin -->
    <script src="../client/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- Instagram Feed Js -->
    <script src="../client/plugins/instafeed/instafeed.min.js"></script>
    <!-- Video Lightbox Plugin -->
    <script src="../client/plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <!-- Count Down Js -->
    <script src="../client/plugins/syo-timer/build/jquery.syotimer.min.js"></script>

    <!-- slick Carousel -->
    <script src="../client/plugins/slick/slick.min.js"></script>
    <script src="../client/plugins/slick/slick-animation.min.js"></script>

   <!--Validation-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <!-- Google Map -->
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="../client/plugins/google-map/gmap.js"></script>-->

    <!-- Main Js File -->
    <script src="../client/dist/js/script.js"></script>
    <script src="../client/plugins/bootstrap-filestyle-2.1.0/bootstrap-filestyle.min.js"></script>

    <!--Toast Notifications-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script type="text/javascript">
      $(":file").filestyle();
      //Prevent Content Move while Modal Pop Up
        $(document).ready(function () {
            $('.modal').on('show.bs.modal', function () {
                if ($(document).height() > $(window).height()) {
                    // no-scroll
                    $('body').addClass("modal-open-noscroll");
                }
                else {
                    $('body').removeClass("modal-open-noscroll");
                }
            });
            $('.modal').on('hide.bs.modal', function () {
                $('body').removeClass("modal-open-noscroll");
            });
        });


    </script>

    <?php
      if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
        ?>
        <script>
          toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
          }
          toastr.success("<?php echo $_SESSION['success']?>");
        </script>
        <?php
        unset($_SESSION['success']);
      }

      if(isset($_SESSION['danger']) && $_SESSION['danger'] != ''){
        ?>
        <script>
          toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
          }
          toastr.error("<?php echo $_SESSION['danger']?>");
        </script>
        <?php
        unset($_SESSION['danger']);
      }

      if(isset($_SESSION['warning']) && $_SESSION['warning'] != ''){
        ?>
        <script>
          toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
          }
          toastr.warning("<?php echo $_SESSION['warning']?>");
        </script>
        <?php
        unset($_SESSION['warning']);
      }
    ?>
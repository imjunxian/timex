<?php
include '../../database/dbconfig.php';
$title = "Login";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Forgot Password</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Forgot Password</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">

          <h2 class="text-center">Forgot Password</h2>
          <form class="text-left clearfix" action="./code.php" id="forgotpassForm">
            <div class="form-group">
              <input type="email" class="form-control"  placeholder="Email" name="email" id="email" erequired>
            </div>
            <div class="col-12 ">
              <div class="g-recaptcha" data-sitekey="6LdBhb0dAAAAALymVbQF8NTZ7OA9pikagw7Elmwt" id="grecaptcha" data-callback="callback"></div>
            </div>
            <div class="col-12 mt-10">
              <button type="submit" class="btn btn-main btn-medium btn-round" style="width: 100%;" id="sendBtn" disabled>Send</button>
            </div>
          </form>
          <p class="mt-20"><a href="../auth/"> Remember your password?</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

<script type="text/javascript">
   function callback() {
    const submitButton = document.getElementById("sendBtn");
    submitButton.removeAttribute("disabled");
  }

  $(function() {
        $.validator.addMethod(
          "regex",
          function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
          },
          "Please check your input."
        );

        $('#forgotpassForm').validate({
          rules: {
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },

          },
          messages: {
            email: {
              required: "* Email is required",
              email: "* Invaild email",
              regex: "* Invalid email"
            },

          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
      });
</script>
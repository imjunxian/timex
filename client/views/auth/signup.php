<?php
include '../../database/dbconfig.php';
$title = "Sign Up";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Sign Up</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Sign Up</li>
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
          <h2 class="text-center">Create an Account</h2>
          <form class="text-left clearfix mt-20" action="./code.php" id="signupForm" method="POST">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="UserName" name="username" id="username" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control"  placeholder="Email" name="email" id="email" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control"  placeholder="Contact" name="contact" id="contact" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control"  placeholder="Password" name="password" id="password" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control"  placeholder="Confirm Password" name="cpassword" id="cpassword" required>
            </div>
            <div class="col-12 ">
              <div class="g-recaptcha" data-sitekey="6LdBhb0dAAAAALymVbQF8NTZ7OA9pikagw7Elmwt" id="grecaptcha" data-callback="callback"></div>
            </div>
            <div class="col-12 mt-10">
              <button type="submit" class="btn btn-main btn-medium btn-round" style="width:100%;" id="registerBtn" name="registerBtn" disabled>Sign Up</button>
            </div>
          </form>
          <p class="mt-20">Already hava an account ?<a href="../auth/"> Login</a></p>
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
    const submitButton = document.getElementById("registerBtn");
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

        $('#signupForm').validate({
          rules: {
            contact:{
              required: true,
            },
            username: {
              required: true,
            },
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            password: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
              //minlength: 5
            },
            cpassword: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
              equalTo: "#password",
            },
          },
          messages: {
            contact:{
              required: "* Phone Number is required",
            },
            username: {
              required: "* Username is required",
            },
            email: {
              required: "* Email is required",
              email: "* Invaild email",
              regex: "* Invalid email"
            },
            password: {
              required: "* Password is required",
              regex: "* Minimum 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
            },
            cpassword: {
              required: "* Please confirm your password",
              regex: "* Minimum 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter",
              equalTo: "* Confirm Password must be same with password"
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
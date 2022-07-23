<?php
include '../../database/dbconfig.php';
$title = "Login";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style type="text/css">
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch .switch-class  { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Login</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Login</li>
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
          <h2 class="text-center">Welcome Back :)</h2>
          <form class="text-left clearfix mt-20" action="code.php" id="loginForm" method="POST">
            <div class="form-group">
              <input type="email" class="form-control"  placeholder="Email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
            </div>

            <div class="form-check mb-3">
               <input type="checkbox" name="showPassword" class="switch-class form-check-input toggle-password" toggle="#password-field">
              <label for="showPassword" class="form-check-label">
                Show Password
              </label>
            </div>

            <div class="col-12 mt-10">
              <div class="g-recaptcha" data-sitekey="6LdBhb0dAAAAALymVbQF8NTZ7OA9pikagw7Elmwt" id="grecaptcha" data-callback="callback"></div>
            </div>
            <div class="col-12 mt-10">
              <button type="submit" class="btn btn-main btn-medium btn-round" style="width: 100%;" id="loginBtn" name="loginBtn" disabled>Login</button>
            </div>
          </form>
          <p class="mt-20"><a href="../auth/forgotPassword.php"> Forgot your password?</a></p>
          <p>New in this site ?<a href="./signup.php"> Create New Account</a></p>
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
    const submitButton = document.getElementById("loginBtn");
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

        $('#loginForm').validate({
          rules: {
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            password: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
            },
          },
          messages: {
            email: {
              required: "* Email is required",
              email: "* Invalid email",
              regex: "* Invalid email"
            },
            password: {
              required: "* Password is required",
              regex: "* Minimum 8 characters that contained 1 number, 1 uppercase, 1 lowercase letter"
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

  if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

      $(".toggle-password").on("click", function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password");
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
</script>
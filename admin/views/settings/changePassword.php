<?php
include('../../database/dbconfig.php');
$title = "Settings";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Change Password</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item"><a href="../settings/">Account Settings</a></li>
                <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                      <form action="code.php" id="editForm" method="post">
                        <div class="card-body">

                          <input type="hidden" class="form-control" id="userid" value="<?php echo $_SESSION['user_id']; ?>" placeholder="Username" name="userid">


                          <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                <label for="exampleInputPassword1">Current Password</label>
                                <span class="fas fa-eye field-icon toggle-opassword" toggle="#password-field"></span>
                                <input type="password" class="form-control" id="opass" placeholder="Current Password" name="oldpass" value="">
                              </div>

                              <div class="form-group">
                                <label for="exampleInputPassword1">New Password</label>
                                <span class="fas fa-eye field-icon toggle-password" toggle="#password-field"></span>
                                <input type="password" class="form-control" id="pass" placeholder="New Password" name="password" value="">
                              </div>

                              <div class="form-group">
                                <label for="exampleInputPassword1">Confirm New Password</label>
                                <span class="fas fa-eye field-icon toggle-cpassword" toggle="#password-field"></span>
                                <input type="password" class="form-control" id="cpass" placeholder="Confirm New Password" name="cpassword" value="">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <p class="mb-2">Password requirements</p>
                              <p class="small text-muted mb-2">To change a new password, you have to meet all of the following requirements:</p>
                              <ul class="small text-muted pl-4 mb-0">
                                <li>Minimum 8 characters</li>
                                <li>At least One Uppercase</li>
                                <li>At least One Lowercase</li>
                                <li>At least One Number</li>
                              </ul>
                            </div>

                          </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">   
                              <a href="../settings/" class="btn btn-secondary">Cancel</a>
                              <button type="submit" name="editpass_btn" class="btn btn-primary">Update</button>
                              <input type="reset" name="resetBtn" class="btn btn-dark float-right">
                        </div>
                      </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->




</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script>
  $(function () {
  /*$.validator.setDefaults({
    submitHandler: function () {
      window.location.href = "profile.php";
    }
  });*/

  $.validator.addMethod(
      "regex",
      function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "Please check your input."
    );

  $('#editForm').validate({
    rules: {
      oldpass: {
          required: true,
          regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
        },
      password: {
        required: true,
        regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
      },
      cpassword: {
        required: true,
        regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
        equalTo : "#pass"
      },
   
    },
    messages: {
    
      oldpass: {
          required: "Please provide a current password",
        regex: "Your password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
        },
      password: {
        required: "Please provide a new password",
        regex: "Your password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
      },
      cpassword: {
        required: "Please confirm your new password",
        regex: "Your password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter",
        equalTo : "Confirm Password must be same with your password"
      },
  
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<script type="text/javascript">

    $(".toggle-password").on("click", function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass");
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
    });
    $(".toggle-cpassword").on("click", function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
        var cp = $("#cpass");
        if (cp.attr("type") == "password") {
          cp.attr("type", "text");
        } else {
          cp.attr("type", "password");
        }
    });
    $(".toggle-opassword").on("click", function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
        var op = $("#opass");
        if (op.attr("type") == "password") {
          op.attr("type", "text");
        } else {
          op.attr("type", "password");
        }
    });
                 
</script>
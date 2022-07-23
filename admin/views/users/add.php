<?php
include '../../database/dbconfig.php';
$title = "Admins";
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
          <h1 class="m-0">Add Admin</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../users/">Admins</a></li>
            <li class="breadcrumb-item active">Add Admin</li>
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

          <div class="alert alert-info alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <i class="fa fa-exclamation-triangle"></i> Notes: The maximum image attached file size is 5MB.
                  The only accepted format are png, jpg and jpeg.
              </div>

          <!-- general form elements -->
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Add Admin</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="code.php" id="addForm" method="post" enctype="multipart/form-data">
              <div class="card-body">
                 <div class="form-group">
                   <label for="product_image">Profile Image</label>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input class="profile_image" id="input-fas" name="profile_image" type="file">
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="name" placeholder="Username" name="username" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                      </div>                
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="contact" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Birthday</label>
                          <input type="date" id="dob" class="form-control" placeholder="Select Birthday" name="dob" onmouseover="(this.type='date')" required>
                        </div>  
                    </div>
                  </div>



                <div class="form-group">
                  <label>User Roles</label>
                  <select class="form-control" name="role" required>
                    <option value="" disabled selected>-- Select Role --</option>
                    <option value="SuperAdmin">SuperAdmin</option>
                    <option value="Admin">Admin</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">Gender</label>
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary1" name="gender" class="male" value="Male" required>
                      <label for="radioPrimary1">
                        Male
                      </label>
                    </div>
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary2" name="gender" class="female" value="Female" required>
                      <label for="radioPrimary2">
                        Female
                      </label>
                    </div>
                  </div>
                </div>

                <hr class="my-4" />

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <span class="fas fa-eye field-icon toggle-password" toggle="#password-field"></span>
                      <input type="password" class="form-control" id="pass" placeholder="Password" name="password">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Confirm Password</label>
                      <span class="fas fa-eye field-icon toggle-cpassword" toggle="#password-field"></span>
                      <input type="password" class="form-control" id="cpass" placeholder="Confirm Password" name="cpassword">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <p class="mb-2">Password requirements</p>
                    <p class="small text-muted mb-2">The password has to meet all of the following requirements:</p>
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
                <a href="../users/" class="btn btn-secondary">Cancel</a>
                <!--<button type="submit" class="btn btn-secondary">Cancel</button>-->

                <button type="submit" name="addBtn" class="btn btn-primary">Add</button>
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
  $(function() {

    $.validator.addMethod("valueNotEquals", function(value, element, arg) {
      return arg !== value;
    }, "Value must not equal arg.");

    $.validator.addMethod(
      "regex",
      function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "Please check your input."
    );

    $('#addForm').validate({
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
        cpassword: {
          required: true,
          regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
          equalTo: "#pass"
        },
        username: {
          required: true,
          minlength: 5
        },
        contact: {
          required: true,
          minlength: 10,
          digits: true
        },
        dob: {
          required: true,
        },
        gender: {
          required: true,
        },
        role: {
          required: true,
          valueNotEquals: 'default'
        },
      },
      messages: {
        email: {
          required: "Email is required",
          email: "Please enter a vaild email, eg demo@demo.com",
          regex: "Please enter a valid email, eg demo@demo.com"
        },
        password: {
          required: "Password is required",
          //minlength: "Your password must be at least 5 characters",
          regex: "Your password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
        },
        cpassword: {
          required: "Please confirm the password",
          //minlength: "Your password must be at least 5 characters",
          regex: "Your password must at least 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter",
          equalTo: "Confirm Password must be same with password"
        },
        username: {
          required: "Username is required",
          minlength: "Your username must be at least 5 characters"
        },
        contact: {
          required: "Phone number is required",
          minlength: "Please enter valid phone number eg. 0123456789",
          digits:"Only numbers is allowed"
        },
        gender: {
          required: "Gender is required",
        },
        dob: {
          required: "Birth Date is required",
        },
        role: {
          required: "Role is required",
          valueNotEquals: 'Please select user role'
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
      },
    });
  });
</script>

<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
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
                 
</script>

<script type="text/javascript">
  $(document).ready(function() {

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Just a button for decoration. &#128579;\')">' +
        '<i class="fa fa-tag"></i>' +
        '</button>'; 
    $(".profile_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: 'Profile',
        removeLabel: '',
        browseIcon: '<i class="fa fa-folder-open"></i>',
        removeIcon: '<i class="fa fa-times"></i>',
        removeTitle: 'Reset or Cancel Image',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif", "jpeg", "svg"]
    });

  });

</script>
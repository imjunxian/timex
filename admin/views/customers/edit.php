<?php
include '../../database/dbconfig.php';
$title = "Admins";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../customers/">Customers</a></li>
            <li class="breadcrumb-item active">Edit Customer</li>
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
              <h3 class="card-title">Edit Customer</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?php


            if (isset($_SESSION['editid'])) {
              $id = $_SESSION['editid'];
              $docRef = $db->collection('customers');
              $row = $docRef->document($id)->snapshot();

              if($row->exists()){

            ?>
                <form action="code.php" id="editForm" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <input type="hidden" class="form-control" id="userid" value="<?php echo $row->id(); ?>" placeholder="Username" name="userid">

                     <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="name" value="<?php echo $row['name']?>" placeholder="Username" name="username" disabled>
                                  </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo $row['email']?>" placeholder="Email" name="email" disabled>
                                  </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="phone" value="<?php echo $row['contact']?>" placeholder="Phone Number" name="contact" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Birthday</label>
                                    <input type="date" id="dob" class="form-control" value="<?php echo $row['dob']?>" placeholder="Enter Birthday" name="dob" disabled>
                                </div>
                            </div>
                        </div>

                    <div class="form-group">
                      <label>Address</label>
                      <textarea class="form-control" id="address" name="address" placeholder="Address" rows="6" disabled><?php echo $row['address']; ?></textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status">
                            <option value="Active" <?php if($row['status'] == "Active") echo "selected"; ?> >Active</option>
                            <option value="Banned" <?php if($row['status'] == "Banned") echo "selected"; ?>>Banned</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date Joined</label>
                          <input type="text" id="date_joined" class="form-control" value="<?php echo $row['date_joined']?>" placeholder="date_joined" name="date_joined" disabled>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Gender</label>
                      <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary1" name="gender" class="male" value="Male" <?php if ($row['gender'] == "Male") { echo "checked";} ?> disabled>
                          <label for="radioPrimary1">
                            Male
                          </label>
                        </div><br>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary2" name="gender" class="female" value="Female" <?php if ($row['gender'] == "Female") { echo "checked";} ?> disabled>
                          <label for="radioPrimary2">
                            Female
                          </label>
                        </div><br>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary3" name="gender" class="nottosay" value="Rather Not To Say" <?php if ($row['gender'] == "Unknown") { echo "checked";} ?> disabled>
                          <label for="radioPrimary3">
                            Rather Not To Say
                          </label>
                        </div>
                      </div>
                    </div>

                    <!--<hr class="my-4" />

                    <div class="form-group">
                      <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-comment"></i> Leave the password empty if you don't want to change.
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Current Password</label>
                          <span class="fas fa-eye field-icon toggle-opassword" toggle="#password-field"></span>
                          <input type="password" class="form-control" id="opass" placeholder="Current Password" name="oldpass" value="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <span class="fas fa-eye field-icon toggle-password" toggle="#password-field"></span>
                          <input type="password" class="form-control" id="pass" placeholder="New Password" name="password" value="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Confirm Password</label>
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

                    </div>-->

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <a href="../customers/" class="btn btn-secondary">Cancel</a>
                    <!--<button type="submit" class="btn btn-secondary">Cancel</button>-->
                    <button type="submit" name="updateBtn" class="btn btn-primary">Update</button>
                  </div>
                </form>
            <?php
              }

            }elseif(!isset($_SESSION['editid'])){
              ?>
              <script> location.replace("../users/index.php?idnotfound"); </script>
              <?php
            }

            ?>

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

    $('#editForm').validate({
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

<script type="text/javascript">
  $(document).ready(function() {

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
        'onclick="alert(\'Please dont click this &#128561;\')">' +
        '<i class="fa fa-tag"></i>' +
        '</button>';
    $("#profile_image").fileinput({
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
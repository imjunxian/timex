<?php
include '../../database/dbconfig.php';
$title = "Services";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Message Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../services/">Services</a></li>
            <li class="breadcrumb-item active">Message Details</li>
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
              <h3 class="card-title">Message Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?php


            if (isset($_SESSION['viewid'])) {
              $id = $_SESSION['viewid'];
              $docRef = $db->collection('contacts');
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact">Reported Date</label>
                                    <?php
                                      date_default_timezone_set("Asia/Kuala_Lumpur");
                                      $date = date_create($row['dateTime']);
                                      $reportedDate = date_format($date,"Y/m/d H:i:s");
                                    ?>
                                    <input type="text" class="form-control" id="phone" value="<?php echo $reportedDate; ?>" placeholder="Date" name="contact" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact">Subject</label>
                                    <input type="text" class="form-control" id="phone" value="<?php echo $row['subject']?>" placeholder="Phone Number" name="contact" disabled>
                                </div>
                            </div>
                        </div>

                    <div class="form-group">
                      <label>Message</label>
                      <textarea class="form-control" id="message" name="message" placeholder="Message" rows="6" disabled><?php echo $row['message']; ?></textarea>
                    </div>

                    <div class="form-group">
                      <label>Status</label>
                         <select class="form-control" name="status">
                          <option value="Solved" <?php if($row['status'] == "Solved") echo "selected"; ?> >Solved</option>
                          <option value="Pending" <?php if($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                        </select>
                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <a href="../services/" class="btn btn-secondary">Back</a>
                    <button type="submit" name="updateBtn" class="btn btn-primary">Update Status</button>
                    <a href="mailto:<?= $row['email'] ?>" class="btn btn-info float-right" data-toggle="tooltip" title="Reply to <?= $row['email']?>">Send Email</a>
                  </div>
                </form>
            <?php
              }

            }elseif(!isset($_SESSION['editid'])){
              ?>
              <script> location.replace("../services/index.php?idnotfound"); </script>
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
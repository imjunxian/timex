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
            <h1 class="m-0">Change Email</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
              <li class="breadcrumb-item"><a href="../settings/">Account Settings</a></li>
              <li class="breadcrumb-item active">Change Email</li>
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
                <h3 class="card-title">Change Email</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="code.php" id="editForm" method="post">
                <div class="card-body">
                    <input type="hidden" class="form-control" id="userid" value="<?php echo $_SESSION['user_id']; ?>" placeholder="Username" name="userid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newEmail">New Email</label>
                                <input type="email" class="form-control" id="email" placeholder="New Email" name="email" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">Email requirements</p>
                            <p class="small text-muted mb-2">To change your email, you have to meet all of the following requirements:</p>
                            <ul class="small text-muted pl-4 mb-0">
                                <li>Input Field is required</li>
                                <li>Email Format must be valid</li>
                                <li>Email cannot be same with others</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="../settings/" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="editEmail_btn" class="btn btn-primary">Update</button>
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
      },
    },
    messages: {
      email: {
        required: "Email is required",
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

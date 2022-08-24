<?php
include('../../database/dbconfig.php');
$title = "Company";
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
                <h1 class="m-0">Company Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Company</li>
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
                <h3 class="card-title">Edit Company Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                <form action="code.php" id="editForm" method="post" enctype="multipart/form-data">
                    <div class="card-body">

                        <input type="hidden" class="form-control" id="companyid" value="Qwh7lii8yRbpD62j6u1R" placeholder="companyid" name="companyid">

                        <div class="form-group">
                            <label for="username">Name</label>
                            <input type="text" class="form-control" id="name" value="<?php echo $docRefCompanyInfo['name']?>" placeholder="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $docRefCompanyInfo['email']?>" placeholder="Email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="text" class="form-control" id="phone" value="<?php echo $docRefCompanyInfo['contact']?>" placeholder="Phone Number" name="contact">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address" rows="5"><?php echo $docRefCompanyInfo['address']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="fee">Shipping Fee (RM)</label>
                            <input type="text" class="form-control" id="shipping_fee" value="<?php echo $docRefCompanyInfo['shipping_fee']?>" placeholder="shipping_fee" name="shipping_fee">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" name="editInfo_btn" class="btn btn-primary" >Update</button>
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
      email: {
        required: true,
        email: true,
        regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
      },
      name: {
        required: true,
      },
      contact: {
        required: true,
        minlength:10,
      },
      address: {
        required: true,
      },
      shipping_fee:{
        required: true,
      },
    },
    messages: {
      email: {
        required: "Email is required",
        email: "Please enter a vaild email",
        regex: "Please enter a valid email"
      },
      name: {
        required: "Name is required",
      },
      contact: {
        required: "Contact number is required",
        minlength: "Please enter valid phone number"
      },
      address: {
          required: "Address is required",
      },
      shipping_fee:{
        required: "Shipping fee is required",
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



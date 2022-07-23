<?php
include '../../database/dbconfig.php';
$title = "Products";
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
          <h1 class="m-0">Add Product</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../products/">Products</a></li>
            <li class="breadcrumb-item active">Add Product</li>
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
              <h3 class="card-title">Add Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="code.php" id="addForm" method="post" enctype="multipart/form-data">
              <div class="card-body">

                  <div class="form-group">
                   <label for="product_image">Product Image</label>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input id="product_image" name="product_image" type="file" required>
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                  <label for="name">Product SKU</label>
                  <input type="text" class="form-control" id="sku" placeholder="SKU" name="sku" required>
                </div>

                <div class="form-group">
                  <label for="name">Product Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                </div>

                <div class="form-group">
                  <label for="contact">Product Quantity</label>
                  <input type="number" class="form-control" id="qtt" placeholder="Quantity" name="quantity" min=0 max=99 oninput="validity.valid||(value='');" required>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Product Cost</label>
                      <input type="number" id="cost" class="form-control" placeholder="Cost" name="cost" min=0 max=9999999 oninput="validity.valid||(value='');" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Product Price</label>
                      <input type="number" id="price" class="form-control" placeholder="Price" name="price" min=0 max=9999999 oninput="validity.valid||(value='');" required>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Short Description</label>
                  <textarea class="form-control rounded-0" id="sdescription" name="sdescription" placeholder="Short Description" rows="3"></textarea>
                </div>

                <div class="form-group">
                  <label for="description">Full Product Description</label>
                  <textarea class="form-control rounded-0" id="description" name="description" placeholder="Full Description" rows="6"></textarea>
                </div>

                 <div class="row">
                  <div class="col-sm-6">
                       <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control multiselect" name="brand">
                          <option value="" disabled selected>-- Select Brand --</option>
                          <?php
                          $docRefBrand = $db->collection('brands')->where('status', '==', 'Active');
                          $snapshotsBrand = $docRefBrand->documents();
                          foreach($snapshotsBrand as $snapshot){
                            if ($snapshot->exists()) {
                                echo "<option value='". $snapshot->id() ."'>" .$snapshot['name'] ."</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>Category</label>
                        <select class="form-control multiselect" multiple="multiple" name="category[]" required>
                          <?php
                          $docRefCat = $db->collection('categories')->where('status', '==', 'Active');
                          $snapshotsCat = $docRefCat->documents();
                          foreach($snapshotsCat as $snapshot){
                            if ($snapshot->exists()) {
                                echo "<option value='". $snapshot->id() ."'>" .$snapshot['name'] ."</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                  </div>
                </div>

                <?php
                $docRefAtt = $db->collection('attributes')->where('status', '==', 'Active');
                $snapshotsAtt = $docRefAtt->documents();
                foreach($snapshotsAtt as $attdata => $data_att){
                  ?>
                   <div class="form-group">
                    <label><?php echo $data_att['name']?></label>
                    <select class="form-control multiselect" multiple="multiple" name="attvalue[]">
                      <?php
                      $docRefAttv = $db->collection('attribute_values')->where('status', '=', 'Active')->where('parent_id', '=', $data_att->id());
                      $snapshotsAttv = $docRefAttv->documents();
                        foreach($snapshotsAttv as $attvdata => $data_attv){
                            echo "<option value='". $data_attv->id() ."'>" .$data_attv['name'] ."</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <?php
                }
                ?>

                 <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Availability</label>
                      <select class="form-control" name="availability" placeholder="Availability" required>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status" placeholder="Status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="javascript:history.go(-1)" class="btn btn-secondary">Cancel</a>
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

    $.validator.addMethod("greaterThan",
    function (value, element, param) {
          var $otherElement = $(param);
          return parseInt(value, 10) >= parseInt($otherElement.val(), 10) || parseFloat(value, 10) >= parseFloat($otherElement.val(), 10);
    });

    $('#addForm').validate({
      rules: {
        product_image: {
          required: true,
        },
        name: {
          required: true,
        },
        sku: {
          required: true,
        },
        price: {
          required: true,
          greaterThan: "#cost",
        },
        cost: {
          required: true,
        },
        sdescription:{
          required: true,
        },
        description:{
          required: true,
        },
        quantity: {
          required: true,
          maxlength:3
        },
         status: {
          required: true,
        },
         availability: {
          required: true,
        },
        brand: {
          required: true,
        },
      },
      messages: {
        product_image: {
          required: "Product Image cannot be empty"
        },
        name: {
          required: "Product Name cannot be empty"
        },
        sku: {
          required: "Product SKU cannot be empty",
        },
        price: {
          required: "Price cannot be empty",
          numbers: "Price can be number or digits only",
          greaterThan: "Price must be greater or equal to Cost",
        },
        cost: {
          required: "Cost cannot be empty",
          numbers: "Cost can be number or digits only"
        },
        sdescription:{
          required: "Short description is required",
        },
        description:{
          required: "Full description is required",
        },
        quantity: {
          required: "Quantity cannot be empty",
          numbers: "Quantity can be number or digits only",
          maxlength:"Quantity too much",
        },
        status: {
          required: "Status is required",
        },
        availability: {
          required: "Availability is required",
        },
        brand:{
          required: "Brand is required",
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

<script>
  $(document).ready(function() {
    $('.multiselect').select2({
      theme: 'bootstrap4'
    });
});
</script>

<script type="text/javascript">

  $(document).ready(function() {

    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
        'onclick="alert(\'Please dont click this &#128561;\')">' +
        '<i class="fa fa-tag"></i>' +
        '</button>';
    $("#product_image").fileinput({
        overwriteInitial: false,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: 'Image',
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

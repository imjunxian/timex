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
          <h1 class="m-0">Edit Product</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../products/">Products</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
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

          <div class="alert alert-info alert-dismissible" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-exclamation-triangle"></i> Notes: The maximum image attached file size is 5MB.
              The only accepted format are png, jpg and jpeg.
          </div>

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Edit Product</h3>

            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?php


            if (isset($_SESSION['editid'])) {
              $id = $_SESSION['editid'];
              $docRef = $db->collection('products');
              $row = $docRef->document($id)->snapshot();

              if($row->exists()){

            ?>
                <form action="code.php" id="editForm" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <input type="hidden" class="form-control" id="prodid" value="<?php echo $row['productId'] ?>" placeholder="id" name="prodid">

                     <div class="form-group">
                        <label>Image Preview: </label>
                        <?php
                          echo '<a href="../../dist/img/productImage/'.$row['image_url'].'"><img src="../../dist/img/productImage/'.$row['image_url'].'" width="130" height="130" class="img-circle" alt="'.$row['name'].'" title="'.$row['name'].'" /></a>';
                        ?>
                      </div>

                  <div class="form-group">
                   <label for="product_image">Product Image</label>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input id="product_image" name="product_image" type="file" >
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                  <label for="name">Product SKU</label>
                  <input type="text" class="form-control" id="sku" placeholder="SKU" name="sku" value="<?php echo $row['sku']?>" required>
                </div>

                <div class="form-group">
                  <label for="name">Product Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $row['name']?>" required>
                </div>

                <div class="form-group">
                  <label for="contact">Product Quantity</label>
                  <input type="number" class="form-control" id="qtt" placeholder="Quantity" name="quantity" value="<?php echo $row['quantity']?>" min=0 max=99 oninput="validity.valid||(value='');" required>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Product Cost</label>
                      <input type="number" id="cost" class="form-control" placeholder="Cost" name="cost" value="<?php echo $row['cost']?>" min=0 max=9999999 oninput="validity.valid||(value='');" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Product Price</label>
                      <input type="number" id="price" class="form-control" placeholder="Price" name="price" value="<?php echo $row['price']?>" min=0 max=9999999 oninput="validity.valid||(value='');" required>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Short Description</label>
                  <textarea class="form-control rounded-0" id="sdescription" name="sdescription" placeholder="Short Description" rows="3"><?php $str = strip_tags($row["short_description"], ''); echo $str; ?></textarea>
                </div>

                <div class="form-group">
                  <label for="description">Full Product Description</label>
                   <textarea class="form-control" id="description" name="description" placeholder="Description" rows="6" required><?php $str = strip_tags($row["description"], ''); echo $str; ?></textarea>
                </div>

                 <div class="row">
                  <div class="col-sm-6">
                       <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control multiselect" name="brand">
                          <?php
                            $recordB = $db->collection('brands')->where('status', '==', 'Active');
                            $recordBrand = $recordB->documents();
                            foreach ($recordBrand as $k => $v):
                              ?>
                              <option value="<?php echo $v->id() ?>" <?php if($v->id() == $row['brand']) { echo 'selected="selected"'; } ?> ><?php echo $v['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>Category</label>
                        <?php
                        $category_data = json_decode($row['category']);
                        ?>
                        <select class="form-control multiselect" multiple="multiple" name="category[]" value="">
                            <?php
                            $recordC = $db->collection('categories')->where('status', '==', 'Active');
                            $recordCat = $recordC->documents();
                            foreach ($recordCat as $k => $v):
                              ?>
                              <option value="<?php echo $v->id() ?>" <?php if(in_array($v->id(), $category_data)) { echo 'selected="selected"'; } ?> ><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                      </div>
                </div>
              </div>

                <?php
                $recordAtt = $db->collection('attributes')->where('status', '==', 'Active');
                $record_att = $recordAtt->documents();
                foreach($record_att as $attdata => $data_att){
                    ?>
                     <div class="form-group">
                      <label><?php echo $data_att['name']?></label>
                       <?php
                        $attdata = json_decode($row['attribute']);
                        ?>
                        <select class="form-control multiselect" multiple="multiple" name="attvalue[]">
                          <?php
                            $recordAttv = $db->collection('attribute_values')->where('status', '==', 'Active')->where('parent_id', '==', $data_att->id());
                            $record_attv = $recordAttv->documents();
                            foreach($record_attv as $k => $v){
                            ?>
                              <option value="<?php echo $v->id() ?>" <?php if(in_array($v->id(), $attdata)) { echo 'selected="selected"'; } ?> ><?php echo $v['name'] ?></option>
                            <?php
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
                        <option value="Available" <?php if($row['availability'] == "Available") echo "selected"; ?>>Available</option>
                        <option value="Unavailable" <?php if($row['availability'] == "Unavailable") echo "selected"; ?>>Unavailable</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status" placeholder="Status" required>
                        <option value="Active" <?php if($row['status'] == "Active") echo "selected"; ?>>Active</option>
                        <option value="Inactive" <?php if($row['status'] == "Inactive") echo "selected"; ?>>Inactive</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="../products/" class="btn btn-secondary">Cancel</a>
                <a href="../products/detail.php?id=<?php echo $row->id(); ?>" class="btn btn-info">View</a>
                <button type="submit" name="updateBtn" class="btn btn-primary">Update</button>

                <a href="javascript:history.go(-1)" class="btn btn-dark float-right">Back</a>
              </div>
            </form>
            <?php
              }
            }elseif(!isset($_SESSION['editid'])){
              ?>
              <script> location.replace("../products/index.php?idnotfound"); </script>
              <?php
            }
            ?>

          </div>
          <!-- /.card -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product Images</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addForm">
                <i class="fa fa-plus"></i> Add Image
              </button>
              <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Images</th>
                      <th>Alt</th>
                      <th>Title</th>
                      <th>Status</th>
                      <th style="text-align:center;" width="150px"><i class="fa fa-cog"></i> Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $docRef = $db->collection('product_images')->where('product_id', '==', $_SESSION['editid']);
                  $snapshot = $docRef->documents();
                  foreach ($snapshot as $row) {
                    if ($row->exists()) {
                    ?>
                    <tr>
                      <td><?php  echo '<a href="../../dist/img/productImage/'.$row['image_url'].'"><img src="../../dist/img/productImage/'.$row['image_url'].'" class="img-thumbnail-table" alt="'.$row['alt'].'" title="'.$row['title'].'"/></a>'; ?></td>
                      <td><?= $row['alt'] ?></td>
                      <td><?= $row['title'] ?></td>
                      <td>
                      <?php
                          if($row['status'] == 'Active'){
                            ?>
                                <span class="badge badge-success">Active</span>
                            <?php
                          }else if($row['status'] == 'Inactive'){
                            ?>
                                <span class="badge badge-warning">Inactive</span>
                            <?php
                          }
                      ?>
                      </td>
                      <td style="text-align:center;">
                        <a href="#" class="btn btn-primary editBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit Image"></i></a>
                        <input type="hidden" name="delete_id" value="<?php echo $row->id(); ?>">
                        <a href="#deleteModal" class="btn btn-danger deleteBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Remove Image"></i></a>
                      </td>
                    </tr>
                    <?php
                    }
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="addForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="code.php" id="imageForm" method="post"  enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="product_image">Product Image</label>
              <div class="kv-avatar">
                  <div class="file-loading">
                      <input id="product_image2" name="product_image2" type="file" >
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label>Alt</label>
              <input type="text" class="form-control" id="alt" placeholder="Enter Alt" name="alt" >
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" >
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Status</label>
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" name="status" class="active" value="Active" checked>
                      <label for="radioPrimary1">
                      Active
                      </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" name="status" class="inactive" value="Inactive">
                      <label for="radioPrimary2">
                        Inactive
                      </label>
                  </div>
                </div>
            </div>
          </div>
          <!--Submit button-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="imgBtn">Add</button>
          </div>
        </form><!--Form end-->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="editImageForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="code.php" id="imageForm" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" class="form-control" id="imageId" value="" name="imageId">
            <div class="form-group">
              <label for="product_image">Product Image</label>
              <div id="productImg"></div><br>
              <div class="kv-avatar">
                  <div class="file-loading">
                      <input id="product_image3" name="product_image3" type="file" >
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label>Alt</label>
              <input type="text" class="form-control" id="editAlt" placeholder="Enter Alt" name="editAlt" >
            </div>
            <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" id="editTitle" placeholder="Enter Title" name="editTitle" >
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Status</label>
              <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                  <input type="radio" id="editRadioPrimary1" name="editStatus" class="status active" value="Active">
                    <label for="editRadioPrimary1">
                    Active
                    </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="editRadioPrimary2" name="editStatus" class="status inactive" value="Inactive">
                    <label for="editRadioPrimary2">
                      Inactive
                    </label>
                </div>
              </div>
            </div>
          </div>
          <!--Submit button-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="updateImgBtn">Update</button>
          </div>
        </form><!--Form end-->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Remove Image?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to remove the image.</p>

        </div>
        <div class="modal-footer justify-content-between">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="code.php" method="POST">
            <input type="hidden" name="deleteid" value="" />
            <button type="submit" name="deleteImgBtn" class="btn btn-primary">Confirm</button>
          </form>
        </div>
    </div>
  </div>
</div>


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script>
   $(function() {
    $('#dataTable').on('click', 'a.deleteBtn', function(e) {
      e.preventDefault();
      var link = this;
      var deleteModal = $("#deleteModal");
      // store the ID inside the modal's form
      deleteModal.find('input[name=deleteid]').val(link.dataset.id);
      // open modal
      deleteModal.modal();
    });
  });

  $(function() {

    $.validator.addMethod("valueNotEquals", function(value, element, arg) {
      return arg !== value;
    }, "Value must not equal arg.");

    $.validator.addMethod("greaterThan",
    function (value, element, param) {
          var $otherElement = $(param);
          return parseInt(value, 10) >= parseInt($otherElement.val(), 10) || parseFloat(value, 10) >= parseFloat($otherElement.val(), 10);
    });

    $('#editForm').validate({
      rules: {
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
        sdescription:{
          required: true,
        },
        description:{
          required: true,
        },
      },
      messages: {
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
        quantity: {
          required: "Quantity cannot be empty",
          numbers: "Quantity can be number or digits only",
          maxlength:"Quantity too much"
        },
        status: {
          required: "Status is required",
        },
        availability: {
          required: "Availability is required",
        },
        sdescription:{
          required: "Short description is required",
        },
        description:{
          required: "Full description is required",
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

    $('#imageForm').validate({
      rules: {
        product_image2: {
          required: true,
        },
        alt:{
          required: true,
        },
        title:{
          required:true,
        },
        status: {
          required: true,
        },
      },
      messages: {
        product_image2: {
          required: "Image is required"
        },
        alt:{
          required: "Alt is required",
        },
        title:{
          required: "Title is required",
        },
        status: {
          required: "Status is required",
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

    $('#editImageForm').validate({
      rules: {
        product_image3: {
          required: true,
        },
        editAlt:{
          required: true,
        },
        editTitle:{
          required:true,
        },
        editStatus: {
          required: true,
        },
      },
      messages: {
        product_image3: {
          required: "Image is required"
        },
        editAlt:{
          required: "Alt is required",
        },
        editTitle:{
          required: "Title is required",
        },
        editStatus: {
          required: "Status is required",
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

    $("#product_image, #product_image2, #product_image3").fileinput({
        overwriteInitial: true,
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

  //AJAX for get data in modal
  $(document).ready(function(){
    $('.editBtn').on('click', function(){
        var imgId = $(this).attr("data-id");
        $.ajax({
            url:"code.php",
            enctype: 'multipart/form-data',
            type:"POST",
            data:{imgId:imgId},
            dataType: "json",
            success: function(data){
                $('#imageId').val(imgId);
                $('#editAlt').val(data.alt);
                $('#editTitle').val(data.title);
                $('input[value="'+data.status+'"]').prop('checked', true);

                var baseUrl = "../../dist/img/productImage";
                var imagePath = baseUrl + '/' + data.image_url;
                $('#productImg').html("<img id='product_img' src='" + imagePath + "' class='img-thumbnail-table'/>");

                $('#updateBtn').val('.editBtn');
                $('#editImageForm').modal('show');
            },
            error: function (data) {
                alert("Something went wrong");
            },
        });
      });
    });

</script>

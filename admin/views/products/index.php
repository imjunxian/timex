<?php
include('../../database/dbconfig.php');
$title = "Products";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
  .btn-stripe {
    color: #fff;
    background-color: #6B71E3;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-4 col-md-6 col-sm-12">
                    <form action="code.php" method="POST" id="statusForm">
                    <div class="input-group" style="">
                    <select class="form-control multiselect" id="status" name="status">
                      <option value="" selected disabled>--- Select Stock Status ---</option>
                      <option value="All">All</option>
                      <option value="Available">Available</option>
                      <option value="Unavailable">Unavailable</option>
                      <option value="LowStock">LowStock</option>
                      <option value="StockOut">StockOut</option>
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="submit_Btn" style="display: inline-block;">Filter</button>
                    </span>
                  </div>
                </form>
                </div>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">

          <div class="card">
            <form action="">
              <div class="card-header">
                <h2 class="card-title">Product Records</h2>
                <button type="button" class="btn btn-primary float-right" onclick='window.location.href="add.php"'>
                    <i class="fa fa-plus"></i> Add
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <?php
                  if(isset($_GET["status"])){
                    if($_GET['status'] == "Available"){
                      $docRef = $db->collection('products')->where('status', '==', 'Active')->where('availability', '==', 'Available')->orderBy('date', 'DESC');
                      $snapshot = $docRef->documents();
                    }else if($_GET['status'] == "Unavailable"){
                      $docRef = $db->collection('products')->where('status', '==', 'Active')->where('availability', '==', 'Unavailable')->orderBy('date', 'DESC');
                      $snapshot = $docRef->documents();
                    }else if($_GET['status'] == "StockOut"){
                      $sta = "Active";
                      $docRef = $db->collection('products')->where('status', '==', 'Active')->where('quantity', '==', "0")->orderBy('date', 'DESC');
                      $snapshot = $docRef->documents();
                    }else if($_GET['status'] == "LowStock"){
                      $docRef = $db->collection('products')->where('status', '==', 'Active')->where('quantity', '==', "1")->orderBy('date', 'DESC');
                      $snapshot = $docRef->documents();
                    }
                  }else{
                    $docRef = $db->collection('products')->where('status', '==', 'Active')->orderBy('date', 'DESC');
                    $snapshot = $docRef->documents();
                  }

                  ?>

                  <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>SKU</th>
                        <th width="220px;">Name</th>
                        <th>Price (RM)</th>
                        <th>Cost (RM)</th>
                        <th>Quantity</th>
                        <th>Availability</th>
                        <th style="text-align:center;" width="140px"><i class="fa fa-cog"></i> Actions</th>
                      </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                    <tbody>
                    <?php
                    foreach ($snapshot as $row) {
                        if ($row->exists()) {
                    ?>
                        <tr>
                          <form></form>
                            <td>
                              <?php
                                echo '<a href="../../dist/img/productImage/'.$row['image_url'].'"><img src="../../dist/img/productImage/'.$row['image_url'].'" class="img-thumbnail-table" alt="'.$row['name'].'" title="'.$row['name'].'"/></a>';
                              ?>
                            </td>
                            <td><?php echo '<a href="../products/detail.php?id='.$row->id().'">'.$row['sku'].'</a>'; ?></td>
                            <td>
                              <?php echo $row['name'] ?><br>
                                <?php
                                  if($row['description'] != ""){
                                    ?>
                                      <span class="product-description" style="font-size:14px;color: #6C757D;">
                                        Description:
                                        <?php
                                        $str = $row['short_description'];
                                        $str = strlen($row['short_description']) > 50 ? substr($row['short_description'],0,50)."..." : $row['short_description'];
                                        echo $str;
                                        ?>
                                      </span>
                                    <?php
                                  }else{
                                    echo '<span class="product-description" style="font-size:14px;color: #6C757D;">No Description</span>';
                                  }
                                ?>
                              </td>
                            <td><?php echo number_format($row['price'],2); ?></td>
                            <td><?php echo number_format($row['cost'],2); ?></td>
                            <td>
                              <?php echo $row['quantity']; ?>&nbsp;
                              <?php
                                if($row['quantity'] == '1' && $row['quantity'] > '0'){
                                  ?>
                                  <span class="badge badge-warning">LowStock</span>
                                  <?php
                                }else if($row['quantity'] == '0'){
                                  ?>
                                  <span class="badge badge-danger">StockOut</span>
                                  <?php
                                }
                              ?>
                            </td>
                            <td>
                              <?php
                                if($row['availability'] == 'Available'){
                                  ?>
                                  <span class="badge badge-success">Available</span>
                                  <?php
                                }else if($row['availability'] == 'Unavailable'){
                                  ?>
                                  <span class="badge badge-warning">Unavailable</span>
                                  <?php
                                }
                              ?>
                            </td>

                              <td style="text-align:center;">
                                <form action="code.php" method="post">
                                  <div class="btn">
                                    <a href="../products/detail.php?id=<?php echo $row->id(); ?>" name="viewBtn" class="btn btn-info" data-toggle="tooltip" title="View <?php echo $row["name"]; ?>"><i class="fa fa-eye" style="font-size:14px;"></i></a>

                                    <input type="hidden" name="edit_id" value="<?php echo $row->id(); ?>">
                                    <button type="submit" name="editBtn" class="btn btn-primary" data-toggle="tooltip" title="Edit <?php echo $row["name"]; ?>"><i class="fa fa-pencil-alt" style="font-size:14px;"></i></button>

                                    <input type="hidden" name="delete_id" value="<?php echo $row->id(); ?>">
                                    <a href="#deleteModal" class="btn btn-danger deleteBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Remove <?php echo $row["name"]; ?>"></i></a>

                                  </div>
                                </form>
                              </td>
                          </tr>
                        <?php
                        }else{
                          echo "";
                        }
                      }

                      ?>
                    </tbody>
                  </table>
                </div>
                <!--Table responsive-->
              </div>
              <!-- /.card-body -->
            </form>
            <div class="card-footer">
                <a class="btn btn-secondary" href="../recycle/products.php">Recycle Bin</a>
                <a class="btn btn-stripe float-right" href="https://dashboard.stripe.com/test/products?active=true" target="_blank">Stripe Dashboard</a>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Move to Recycle Bin?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to move it to recycle bin.</p>

        </div>
        <div class="modal-footer justify-content-between">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="code.php" method="POST">
            <input type="hidden" name="deleteid" value="" />
            <button type="submit" name="recycleBtn" class="btn btn-primary">Confirm</button>
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
</script>

<script type="text/javascript">
    if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }


 $(function() {

    $('#statusForm').validate({
      rules: {
        status: {
          required: true,
        },
      },
      messages: {
        status: {
          required: "Status is required.",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
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
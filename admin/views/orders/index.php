<?php
include('../../database/dbconfig.php');
$title = "Orders";
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
                <h1 class="m-0">Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
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
                        <option value="" selected disabled>--- Select Order Status ---</option>
                        <option value="All">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
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
                  <h2 class="card-title">Order Records</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <?php
                     if(isset($_GET["status"])){
                      if($_GET['status'] == "Pending"){
                        $docRef = $db->collection('orders')->where('order_status', '=', $_GET['status']);
                        $snapshot = $docRef->documents();
                      }else if($_GET['status'] == "Delivered"){
                        $docRef = $db->collection('orders')->where('order_status', '=', $_GET['status']);
                        $snapshot = $docRef->documents();
                      }else if($_GET['status'] == "Completed"){
                        $docRef = $db->collection('orders')->where('order_status', '=', $_GET['status']);
                        $snapshot = $docRef->documents();
                      }else if($_GET['status'] == "Cancelled"){
                        $docRef = $db->collection('orders')->where('order_status', '=', $_GET['status']);
                        $snapshot = $docRef->documents();
                      }
                    }else{
                      $docRef = $db->collection('orders');
                      $snapshot = $docRef->documents();
                    }
                  ?>
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="13%">#OrderNo</th>
                          <th>Customer</th>
                          <th>Order DateTime</th>
                          <th>Sales (RM)</th>
                          <th width="15%">Payment Method</th>
                          <th>Status</th>
                          <th style="text-align:center;" width="150px"><i class="fa fa-cog"></i> Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach($snapshot as $row){
                          $order_id = $row->id();
                          $cust_id = $row['customer_id'];
                          $orderItemDocRef = $db->collection('order_item')->where('order_id','=',$order_id);
                          $orderItemSnapshot = $orderItemDocRef->documents();
                          foreach($orderItemSnapshot as $ordItem){
                            $custSnap = $db->collection('customers')->document($cust_id)->snapshot();
                            ?>
                            <tr>
                              <td>#<?=$row['order_no']?></td>
                              <td><?=$custSnap['name']?></td>
                              <td><?=$row['orderDateTime']?></td>
                              <td><?=number_format($row['sales'], 2)?></td>
                              <td><?=$row['payment_method']?></td>
                              <td>
                                <?php
                                if($row['order_status'] == "Pending"){
                                  ?><span class="badge badge-warning">Pending</span><?php
                                }elseif($row['order_status'] == "Delivered"){
                                  ?><span class="badge badge-info">Delivered</span><?php
                                }elseif($row['order_status'] == "Completed"){
                                  ?><span class="badge badge-success">Completed</span><?php
                                }elseif($row['order_status'] == "Cancelled"){
                                  ?><span class="badge badge-danger">Cancelled</span><?php
                                }
                                ?>
                              </td>
                              <td style="text-align:center;">
                                <a href="../orders/detail.php?id=<?=$row->id()?>" name="view" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-primary editBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit Status"></i></a>
                              </td>
                            </tr>
                            <?php
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

<!--Edit Toggles-->
<div class="modal fade" id="editForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="code.php" id="addF" method="post" >
          <div class="modal-body">
            <input type="hidden" class="form-control" name="editOrder_id" id="editOrder_id" value="">
            <div class="form-group">
              <label>Status</label>
                <select class="form-control" name="editStatus" id="editStatus">
                  <option value="Pending">Pending</option>
                  <option value="Delivered">Delivered</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <span class="testing"></span>
          </div>
          <!--Submit button-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
          </div>
        </form><!--Form end-->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script>
  //AJAX for get data in modal
  $(document).on('click', '.editBtn', function() {
    var id = $(this).attr("data-id");
    $.ajax({
        url:"code.php",
        type:"POST",
        data:{id:id},
        dataType: "json",
        success: function(data){
            $('#editOrder_id').val(id);
            $('option[value="'+data.order_status+'"]').prop('selected', true);

            $('#updateBtn').val('.editBtn');
            $('#editForm').modal('show');
        },
        error: function (data) {
            alert("Something went wrong");
        },
    });
  });
</script>
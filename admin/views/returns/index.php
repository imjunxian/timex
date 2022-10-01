<?php
include('../../database/dbconfig.php');
$title = "Returns";
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
                <h1 class="m-0">Returns</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Returns</li>
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
              <form action="code.php" method="post">
                <div class="card-header">
                  <h2 class="card-title">Returns Records</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <?php
                    $docRef = $db->collection('returns');
                    $snapshot = $docRef->documents();
                  ?>
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width=10>Images</th>
                          <th>#OrderNo</th>
                          <th>Reason</th>
                          <th>Return DateTime</th>
                          <th>Status</th>
                          <th style="text-align:center;" width="150px"><i class="fa fa-cog"></i> Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach($snapshot as $row){
                            ?>
                            <tr>
                              <td>
                                <?php
                                  echo '<a href="../../dist/img/return/'.$row['image_url'].'"><img src="../../dist/img/return/'.$row['image_url'].'" class="img-thumbnail-table" alt="'.$row['order_no'].'" title="'.$row['order_no'].'"/></a>';
                                ?>
                              </td>
                              <td>#<?=$row['order_no']?></td>
                              <td><?=$row['reason']?></td>
                              <td><?=$row['datetime']?></td>
                              <td>
                                <?php
                                if($row['status'] == "Pending"){
                                  ?><span class="badge badge-warning">Pending</span><?php
                                }elseif($row['status'] == "Rejected"){
                                  ?><span class="badge badge-danger">Rejected</span><?php
                                }elseif($row['status'] == "Approved"){
                                  ?><span class="badge badge-success">Approved</span><?php
                                }
                                ?>
                              </td>
                              <td style="text-align:center;">
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id']; ?>">
                                <a href="#" class="btn btn-primary editBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit Status"></i></a>
                              </td>
                            </tr>
                            <?php
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
            <input type="hidden" class="form-control" id="editReturn_id" value="" name="editReturn_id">
            <input type="hidden" class="form-control" name="editOrder_id" id="editOrder_id" value="">
            <div class="form-group">
              <label>Status</label>
                <select class="form-control" name="editStatus" id="editStatus">
                  <option value="Pending">Pending</option>
                  <option value="Approved">Approved</option>
                  <option value="Rejected">Rejected</option>
                </select>
            </div>

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
    var order_id = document.getElementById('order_id').value;
    $.ajax({
        url:"code.php",
        type:"POST",
        data:{id:id},
        dataType: "json",
        success: function(data){
            $('#editReturn_id').val(id);
            $('#editOrder_id').val(order_id);
            $('option[value="'+data.status+'"]').prop('selected', true);

            $('#updateBtn').val('.editBtn');
            $('#editForm').modal('show');
        },
        error: function (data) {
            alert("Something went wrong");
        },
    });
  });
</script>
<?php
include('../../database/dbconfig.php');
$title = "Customers";
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
            <h1 class="m-0">Customers</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
            <li class="breadcrumb-item active">Customers</li>
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
                  <form action="">
                    <div class="card-header">
                      <h2 class="card-title">Customers Records</h2>
                      <button type="button" class="btn btn-primary float-right" onclick='window.location.href="add.php"'>
                        <i class="fa fa-plus"></i> Add
                      </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <?php
                        $docRef = $db->collection('customers')->where("status", "!=", "Closed");
                        $snapshot = $docRef->documents();
                        ?>

                        <table id="dataTable" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th width="10">#No</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>Contact</th>
                              <th>Address</th>
                              <th>Status</th>
                              <th style="text-align:center;" width="150px;"><i class="fa fa-cog"></i> Actions</th>
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
                            </tr>
                          </tfoot>

                          <tbody>
                            <?php
                            $n = 0;
                            foreach ($snapshot as $row) {
                                $n++;
                                if ($row->exists()) {
                                ?>
                                    <tr>
                                      <form></form>
                                      <td><?php echo $n; ?></td>
                                      <td>
                                        <?php echo $row['name'];?>
                                      </td>
                                      <td><?php echo $row['email']; ?></td>
                                      <td>
                                        <?php
                                        if($row['contact'] != ""){
                                          echo $row['contact'];
                                        }else{
                                          echo "<span class=\"text-muted font-italic\">NULL</span>";
                                        }
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                        if($row['address'] != ""){
                                          echo $row['address'];
                                        }else{
                                          echo "<span class=\"text-muted font-italic\">NULL</span>";
                                        }
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                            if($row['status'] == 'Active'){
                                              ?>
                                                  <span class="badge badge-success">Active</span>
                                              <?php
                                            }else if($row['status'] == 'Banned'){
                                              ?>
                                                  <span class="badge badge-warning">Banned</span>
                                              <?php
                                            }
                                        ?>
                                      </td>
                                      <td style="text-align:center;">
                                        <form action="code.php" method="post">
                                          <div class="btn">
                                            <?php
                                              if($row['address'] != ''){
                                                ?>
                                                <a href="https://www.google.com/maps/place/<?= $row['address'] ?>" target="_blank" class="btn btn-info" data-toggle="tooltip" title="View Location"><i class="fa fa-compass" style="font-size:14px;"></i></a>
                                                <?php
                                              }else{
                                                echo "";
                                              }
                                            ?>
                                            <input type="hidden" name="edit_id" value="<?php echo $row->id(); ?>">
                                            <button type="submit" name="editBtn" class="btn btn-primary" data-toggle="tooltip" title="Edit <?php echo $row["name"]; ?>"><i class="fa fa-pencil-alt" style="font-size:14px;"></i></button>

                                            <input type="hidden" name="delete_id" value="<?php echo $row->id(); ?>">
                                            <a href="#deleteModal" class="btn btn-danger deleteBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Ban <?php echo $row["name"]; ?>"></i></a>
                                          </div>

                                        </form>
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
                  <div class="card-footer">
                    <a class="btn btn-secondary" href="../recycle/customers.php">Recycle Bin</a>
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
      // store the deleteID inside the modal's form
      deleteModal.find('input[name=deleteid]').val(link.dataset.id);
      // open modal
      deleteModal.modal();
    });
  });

</script>
<?php
include('../../database/dbconfig.php');
$title = "Recycle Bins";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<?php if($_SESSION['user_role'] == "SuperAdmin"){ ?>
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Closed Admins</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                  <li class="breadcrumb-item active">Recycle Bins</li>
                  <li class="breadcrumb-item active">Closed Admins</li>
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
                      <h2 class="card-title">Closed Admin Records</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <?php
                        $docRef = $db->collection('admins')->where("status", "==", "Closed");
                        $snapshot = $docRef->documents();
                        ?>

                        <table id="dataTable" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                            <th width="10">#No</th>
                              <th width="60px">Image</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Contact</th>
                              <th>Roles</th>
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
                                        <?php
                                            if($row["image_url"] == ""){
                                            ?>
                                            <img class="img-profile rounded-circle" src="../../dist/img/avatar9.png" height="80px;" width="80px;">
                                            <?php
                                            }else{
                                              echo '<a href="../../dist/img/profile/'.$row['image_url'].'"><img src="../../dist/img/profile/'.$row['image_url'].'" width="80px" height="80px" class="img-circle" alt="image" /></a>';
                                            }

                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                        echo $row['name'];
                                        ?>
                                      </td>
                                      <td><?php echo $row['email']; ?></td>
                                      <td><?php echo $row['contact']; ?></td>
                                      <td><span class="badge badge-info"><?php echo $row['role']; ?></span></td>
                                      <td>
                                        <?php
                                            if($row['status'] == 'Closed'){
                                              ?>
                                                  <span class="badge badge-danger">Closed</span>
                                              <?php
                                            }
                                        ?>
                                      </td>
                                      <td style="text-align:center;">
                                        <form action="../users/code.php" method="post">
                                          <div class="btn">
                                            <input type="hidden" name="recover_id" value="<?php echo $row->id(); ?>">
                                            <button type="submit" name="recoverBtn" class="btn btn-primary" data-toggle="tooltip" title="Recover <?php echo $row["name"]; ?>"><i class="fa fa-undo" style="font-size:14px;"></i></button>

                                            <!--<input type="hidden" name="delete_id" value="<?php echo $row->id(); ?>">
                                            <a href="#deleteModal" class="btn btn-danger deleteBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Ban <?php echo $row["name"]; ?>"></i></a>-->
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
                        <a class="btn btn-secondary" href="../users/">View</a>
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
        <?php }else{ ?>

<script> location.replace("../error/accessDenied.php"); </script>

<?php } ?>
</div>
<!-- /.content-wrapper -->

<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Delete" below if you want to delete user.</p>
          <p class="text-danger">*Caution: Changes cannot be made after delete successful.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="../users/code.php" method="POST">
            <input type="hidden" name="deleteid" value="" />
            <button type="submit" name="delete_btn" class="btn btn-primary">Delete</button>
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

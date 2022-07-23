<?php
include('../../database/dbconfig.php');
$title = "Admins";
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
            <h1 class="m-0">Admins</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
            <li class="breadcrumb-item active">Admins</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
        <section class="content">
          <div class="container-fluid">

            <!--<div class="row">

              <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card card-outline card-info shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">

                              <?php

                              /*$query_sp = "SELECT userId FROM users WHERE userRoles!='SuperUser' ORDER BY userId";
                              $query_sp_run = mysqli_query($connection, $query_sp);

                              $query_ac = "SELECT userId FROM users WHERE userRoles!='SuperUser' AND status='Active' ORDER BY userId";
                              $query_ac_run = mysqli_query($connection, $query_ac);

                              $query_ba = "SELECT userId FROM users WHERE userRoles!='SuperUser' AND status='Banned' ORDER BY userId";
                              $query_ba_run = mysqli_query($connection, $query_ba);

                              $query_cl = "SELECT userId FROM users WHERE userRoles!='SuperUser' AND status='Closed' ORDER BY userId";
                              $query_cl_run = mysqli_query($connection, $query_cl);

                              $row_ac = mysqli_num_rows($query_ac_run);
                              $row_ba = mysqli_num_rows($query_ba_run);
                              $row_sp = mysqli_num_rows($query_sp_run);
                              $row_cl = mysqli_num_rows($query_cl_run);
                              echo "
                              <div class=\"h6 font-weight-bold text-info text-uppercase mb-1\">Total Users: $row_sp</div>
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Active: $row_ac</div>
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Banned: $row_ba</div>
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Closed: $row_cl</div>
                              ";*/
                              ?>

                            </div>
                            <div class="col-auto">
                              <canvas id="donutChart" style=" max-height: 115px; max-width: 115%;"></canvas>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>


              <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card card-outline card-info shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="h6 font-weight-bold text-info text-uppercase mb-1">User Roles</div>
                              <?php
                              /*$query_a = "SELECT userId FROM users WHERE userRoles='Admin' ORDER BY userId";
                              $query_a_run = mysqli_query($connection, $query_a);

                              $query_s = "SELECT userId FROM users WHERE userRoles='Staff' ORDER BY userId";
                              $query_s_run = mysqli_query($connection, $query_s);

                              $query_su = "SELECT userId FROM users WHERE userRoles='SuperUser' ORDER BY userId";
                              $query_su_run = mysqli_query($connection, $query_su);

                              $row_a = mysqli_num_rows($query_a_run);
                              $row_s = mysqli_num_rows($query_s_run);
                              $row_su = mysqli_num_rows($query_su_run);
                              echo "
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Superuser: $row_su</div>
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Admin: $row_a</div>
                              <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Staff: $row_s</div>
                              ";*/
                              ?>

                            </div>
                            <div class="col-auto">
                              <canvas id="asChart" style=" max-height: 115px; max-width: 115%;"></canvas>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>


             <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card card-outline card-info shadow ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="h6 font-weight-bold text-info text-uppercase mb-1">User Login Status</div>
                              <?php
                              /*$query_n = "SELECT userId FROM users WHERE currentStatus='Online' AND userRoles!='SuperUser' ORDER BY userId";
                              $query_n_run = mysqli_query($connection, $query_n);

                              $query_f = "SELECT userId FROM users WHERE currentStatus='Offline' AND userRoles!='SuperUser' ORDER BY userId";
                              $query_f_run = mysqli_query($connection, $query_f);

                              $row_n = mysqli_num_rows($query_n_run);
                              $row_f = mysqli_num_rows($query_f_run);
                              echo "
                                  <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Online: $row_n</div>
                                  <div class=\"h6 mb-0 font-weight-bold text-gray-800\">Offline: $row_f</div>
                              ";*/
                              ?>
                            </div>
                            <div class="col-auto">
                              <canvas id="onOffChart" style=" max-height: 115px; max-width: 115%;"></canvas>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
            </div>-->

            <div class="row">
              <div class="col-12">

                <div class="card">
                  <form action="">
                    <div class="card-header">
                      <h2 class="card-title">Admins Records</h2>
                      <button type="button" class="btn btn-primary float-right" onclick='window.location.href="add.php"'>
                        <i class="fa fa-plus"></i> Add
                      </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <?php
                        $docRef = $db->collection('admins')->where("status", "!=", "Closed");
                        $snapshot = $docRef->documents();
                        ?>

                        <table id="dataTable" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th width="10">#No</th>
                              <th width="60px">Image</th>
                              <th>Name</th>
                              <th >Email</th>
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
                                        <form action="code.php" method="post">
                                          <div class="btn">
                                            <!--<input type="hidden" name="view_id" value="<?php echo $row->id(); ?>">
                                            <button type="submit" name="viewBtn" class="btn btn-info" data-toggle="tooltip" title="View <?php echo $row["name"]; ?>"><i class="fa fa-eye" style="font-size:14px;"></i></button>-->

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
                    <a class="btn btn-secondary" href="../recycle/admins.php">Recycle Bin</a>
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
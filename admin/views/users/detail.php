<?php
include '../../database/dbconfig.php';
$title = "Admins";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Admin</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="../users">Admins</a></li>
            <li class="breadcrumb-item active">Edit Admin</li>
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
              <h3 class="card-title">Edit Admin</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?php


            if (isset($_GET['id'])) {
              $id = $_GET['editid'];
              $docRef = $db->collection('admins');
              $row = $docRef->document($id)->snapshot();

              if($row->exists()){

            ?>
                <form action="code.php" id="editForm" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <input type="hidden" class="form-control" id="userid" value="<?php echo $row->id(); ?>" placeholder="Username" name="userid">

                     <div class="form-group">
                        <label>Image Preview: </label>
                        <?php
                          if($row["image_url"] == ""){
                            ?>
                            <img class="img-profile rounded-circle" src="../../dist/img/avatar9.png" height="112px;" width="112px;">
                            <?php
                          }else{
                            echo '<a href="../../dist/img/profile/'.$row['image_url'].'"><img src="../../dist/img/profile/'.$row['image_url'].'" width="112" height="112" class="img-circle" alt="image" /></a>';
                          }
                        ?>
                      </div>

                    <div class="form-group">
                   <label for="product_image">Profile Image</label>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input id="profile_image" name="profile_image" type="file">
                        </div>
                    </div>
                  </div>

                     <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="name" value="<?php echo $row['name']?>" placeholder="Username" name="username">
                                  </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo $row['email']?>" placeholder="Email" name="email" disabled>
                                  </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="phone" value="<?php echo $row['contact']?>" placeholder="Phone Number" name="contact">
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Birthday</label>
                                    <input type="date" id="dob" class="form-control" value="<?php echo $row['dob']?>" placeholder="Enter Birthday" name="dob">
                                </div>
                            </div>
                        </div>


                    <div class="form-group">
                      <label>User Roles</label>
                        <select class="form-control" name="role">
                          <option value="SuperAdmin" <?php if($row['role'] == "SuperAdmin") echo "selected"; ?>>SuperAdmin</option>
                          <option value="Admin" <?php if($row['role'] == "Admin") echo "selected"; ?>>Admin</option>
                        </select>
                    </div>

                     <div class="form-group">
                      <label>Status</label>
                         <select class="form-control" name="status">
                          <option value="Active" <?php if($row['status'] == "Active") echo "selected"; ?> >Active</option>
                          <option value="Inactive" <?php if($row['status'] == "Inactive") echo "selected"; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Gender</label>
                      <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary1" name="gender" class="male" value="Male" <?php if ($row['gender'] == "Male") { echo "checked";} ?> >
                          <label for="radioPrimary1">
                            Male
                          </label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary2" name="gender" class="female" value="Female" <?php if ($row['gender'] == "Female") { echo "checked";} ?> >
                          <label for="radioPrimary2">
                            Female
                          </label>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <a href="../users/" class="btn btn-secondary">Cancel</a>
                  </div>
                </form>
            <?php
              }

            }elseif(!isset($_GET['id'])){
              ?>
              <!--<br>
                <p class="text-justify text-center">
                  User Not Found! <br>
                  You may <a href="../users/">CLICK HERE</a> to return.
                </p>
              <br>-->
              <script> location.replace("../users/index.php?idnotfound"); </script>
              <?php
            }

            ?>

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
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

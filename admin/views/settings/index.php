<?php
include('../../database/dbconfig.php');
$title = "Settings";
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
                <h1 class="m-0">Account Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Account Settings</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
<style type="text/css">
    .card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
        margin-bottom: 10px; /* Added */
}
</style>
          <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-3">
                 <?php
                    $id = $_SESSION['user_id'];
                    $docRef = $db->collection('admins');
                    $row = $docRef->document($id)->snapshot();

                    if($row->exists()){
                        ?>
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                   <h2 class="card-title">Profile Card</h2>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5>
                                            <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <?php
                                                if($row["image_url"] == ""){
                                                    ?>
                                                    <img class="img-profile rounded-circle" src="../../dist/img/avatar9.png" height="112px;" width="112px;">
                                                    <?php
                                                }else{
                                                    echo '<a href="../../dist/img/profile/'.$row['image_url'].'"><img src="../../dist/img/profile/'.$row['image_url'].'" width="112" height="112" class="img-circle" alt="image" /></a>';
                                                }
                                            ?>
                                        </span>

                                            <p class="title mt-3">
                                                <b>
                                                <?php if($row['gender'] == "Male"){ echo 'Mr.';}elseif($row['gender'] == "Female"){ echo 'Ms.';}else{ echo "";}?>
                                                <?php echo $row["name"]; ?>

                                                </b>
                                            </p>
                                        </h5>
                                        <p class="description">
                                           <b><?php echo $row["role"]; ?></b>
                                        </p>
                                    </div>
                                    <p class="description text-center">
                                        Email : <b><?php echo $row['email']?></b><br>
                                        Contact : <b><?php echo $row['contact']?></b><br>
                                        BirthDate : <b><?php echo $row['dob']?></b>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                    ?>

            </div>


          <div class="col-xl-8 col-md-6 mb-3">
          <?php
            if($row->exists()){
                ?>
                    <form action="">
                        <div class="card">
                            <div class="card-header">

                                <h2 class="card-title">User Profile</h2>

                                <button type="button" class="btn btn-primary float-right" onclick="document.location='edit.php'">
                                Edit Profile <i class="fa fa-pencil-alt"></i>
                                </button>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="table" class="table table-hover">

                                        <tbody>
                                            <tr>
                                                <th><i class="fa fa-user"></i> Username</th>
                                                <td><?php echo $row['name']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-envelope"></i> Email</th>
                                                <td><?php echo $row['email']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-phone-alt"></i> Contact</th>
                                                <td><?php echo $row['contact']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-venus-mars"></i> Gender</th>
                                                <td><?php echo $row['gender']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-calendar"></i> Birth Date</th>
                                                <td><?php echo $row['dob']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-tag"></i> Roles</th>
                                                <td><?php echo $row['role']?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="fa fa-calendar-check"></i> Date Joined</th>
                                                <td>
                                                    <?php
                                                     $dateJoined = $row['date_joined'];
                                                     echo date('d M Y', strtotime($dateJoined));
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--table responsive-->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" onclick='window.location.href="../settings/changePassword.php"'>
                                Change Password <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default" onclick='window.location.href="../settings/changeEmail.php"'>
                                Change Email <i class="fa fa-pencil-alt"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </form>
                <?php
                }
            ?>
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


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>
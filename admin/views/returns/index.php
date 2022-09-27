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
              <form action="">
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
                          <th>Images</th>
                          <th>#OrderNo</th>
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
                                <a href="../returns/detail.php?id=<?=$row->id()?>" name="view" class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>
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


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>
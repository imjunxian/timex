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
              <form action="">
                <div class="card-header">
                  <h2 class="card-title">Order Records</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <?php
                    $docRef = $db->collection('orders')->where('order_status', '=', 'Pending');
                    $snapshot = $docRef->documents();
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
                                  ?><span class="badge badge-success">Delivered</span><?php
                                }elseif($row['order_status'] == "Cancelled"){
                                  ?><span class="badge badge-danger">Cancelled</span><?php
                                }
                                ?>
                              </td>
                              <td style="text-align:center;">
                                <a href="../orders/detail.php?id=<?=$ordItem->id()?>" name="view" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                <a href="../orders/edit.php?id=<?=$row->id()?>" name="view" class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a>
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


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>
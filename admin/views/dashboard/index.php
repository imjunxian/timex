<?php
include '../../database/dbconfig.php';
$title = "Dashboard";
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
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


<!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
        <?php
          if (isset($_SESSION['welcome']) && $_SESSION['welcome'] != '') {
            echo '
                <div class="alert alert-success alert-dismissible welcome" id="success-alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <p class="h5"><i class="fa fa-check-circle"></i> ' . $_SESSION['welcome'] . '</p>
                </div>
                ';
            unset($_SESSION['welcome']);
          }
        ?>
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <?php
                $result = 0;
                $numRow = [];
                $docValueRef = $db->collection('customers')->where('status', '==', 'Active');
                $countDoc = $docValueRef->documents();
                foreach ($countDoc as $count) {
                  array_push($numRow, $count->data()['name']);
                  $result = count($numRow);
                }
                echo "<h3>$result</h3>";
              ?>
              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="../customers/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <?php
                $result = 0;
                $numRow = [];
                $docValueRef = $db->collection('products')->where('status', '==', 'Active')->where('availability', '==', 'Available');
                $countDoc = $docValueRef->documents();
                foreach ($countDoc as $count) {
                  array_push($numRow, $count->data()['name']);
                  $result = count($numRow);
                }
                echo "<h3>$result</h3>";
              ?>
              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="fa fa-box"></i>
            </div>
            <a href="../products/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <?php
                $result = 0;
                $numRow = [];
                $docValueRef = $db->collection('orders')->where('order_status', '=', 'Completed');
                $countDoc = $docValueRef->documents();
                foreach ($countDoc as $count) {
                  array_push($numRow, $count->data()['order_no']);
                  $result = count($numRow);
                }
                echo "<h3>$result</h3>";
              ?>
              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-bag"></i>
            </div>
            <a href="../orders/index.php?status=Completed" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <?php
                $result = 0;
                $numRow = [];
                $docValueRef = $db->collection('contacts')->where('status', '==', 'Pending');
                $countDoc = $docValueRef->documents();
                foreach ($countDoc as $count) {
                  array_push($numRow, $count->data()['message']);
                  $result = count($numRow);
                }
                echo "<h3>$result</h3>";
              ?>
              <p>Customer Services</p>
            </div>
            <div class="icon">
              <i class="far fa-envelope"></i>
            </div>
            <a href="../services/index.php?status=Pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!--<div class="row">
        <div class="col-md-3">
          <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"></span>
            <div class="info-box-content">
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"></span>
            <div class="info-box-content">
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"></span>
            <div class="info-box-content">
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"></span>
            <div class="info-box-content">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <br>
            </div>
          </div>
        </div>
      </div>-->

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Activities</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
          </div>
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  Active Carts
                  <span class="float-right badge bg-info">
                    <?php
                     $result = 0;
                     $numRow = [];
                     $docValueRef = $db->collection('carts');
                     $countDoc = $docValueRef->documents();
                     foreach ($countDoc as $count) {
                       array_push($numRow, $count->data()['product_id']);
                       $result = count($numRow);
                     }
                     echo $result;
                    ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../reviews/index.php?status=Pending" class="nav-link">
                  Pending Reviews
                  <span class="float-right badge bg-success">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('reviews')->where('status', '==', 'Pending');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['review']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../orders/index.php?status=Pending" class="nav-link">
                  Pending Orders
                  <span class="float-right badge bg-warning">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('orders')->where('order_status', '=', 'Pending');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['order_no']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../returns/index.php?status=Pending" class="nav-link">
                  Return Requests
                  <span class="float-right badge bg-danger">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('returns')->where('status', '=', 'Pending');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['order_no']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Catalogs</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
          </div>
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a href="../brands/" class="nav-link">
                  Brands
                  <span class="float-right badge bg-info">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('brands')->where('status', '==', 'Active');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['name']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../categories/" class="nav-link">
                  Categories
                  <span class="float-right badge bg-success">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('categories')->where('status', '==', 'Active');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['name']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../products/index.php?status=LowStock" class="nav-link">
                  Low Stock Products
                  <span class="float-right badge bg-warning">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('products')->where('status', '==', 'Active')->where('quantity', '==', '1');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['name']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../products/index.php?status=StockOut" class="nav-link">
                  Out of Stock Products
                  <span class="float-right badge bg-danger">
                  <?php
                    $result = 0;
                    $numRow = [];
                    $docValueRef = $db->collection('products')->where('status', '==', 'Active')->where('quantity', '==', '0');
                    $countDoc = $docValueRef->documents();
                    foreach ($countDoc as $count) {
                      array_push($numRow, $count->data()['name']);
                      $result = count($numRow);
                    }
                    echo $result;
                  ?>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

      <!--Table-->
      <div class="row">
        <div class="col-md-8">
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Orders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                 <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="../orders/" class="dropdown-item">View Orders</a>
                    </div>
                  </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                      <table class="table m-0 table-striped">
                        <thead>
                          <tr>
                            <th>#Order No.</th>
                            <th>OrderDateTime</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th><i class="fa fa-cog"></i> Actions</th>
                          </tr>
                        </thead>

                        <tbody>
                        <?php
                          $docRef = $db->collection('orders')->orderBy('orderDate', 'DESC');
                          $snapshot = $docRef->documents();

                          if($snapshot == Array()){
                            ?>
                            <tr>
                              <td align="center" colspan="5">
                                <br>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 93 87" style="width: 120px;"><defs><rect id="defaultpage_nodata-a" width="45" height="33" x="44" y="32" rx="2"></rect><mask id="defaultpage_nodata-b" width="45" height="33" x="0" y="0" fill="#fff" maskContentUnits="userSpaceOnUse" maskUnits="objectBoundingBox"><use xlink:href="#defaultpage_nodata-a"></use></mask></defs><g fill="none" fill-rule="evenodd" transform="translate(-3 -4)"><rect width="96" height="96"></rect><ellipse cx="48" cy="85" fill="#F2F2F2" rx="45" ry="6"></ellipse><path fill="#FFF" stroke="#D8D8D8" d="M79.5,17.4859192 L66.6370555,5.5 L17,5.5 C16.1715729,5.5 15.5,6.17157288 15.5,7 L15.5,83 C15.5,83.8284271 16.1715729,84.5 17,84.5 L78,84.5 C78.8284271,84.5 79.5,83.8284271 79.5,83 L79.5,17.4859192 Z"></path><path fill="#DBDBDB" fill-rule="nonzero" d="M66,6 L67.1293476,6 L67.1293476,16.4294956 C67.1293476,17.1939227 67.7192448,17.8136134 68.4469198,17.8136134 L79,17.8136134 L79,19 L68.4469198,19 C67.0955233,19 66,17.849146 66,16.4294956 L66,6 Z"></path><g fill="#D8D8D8" transform="translate(83 4)"><circle cx="7.8" cy="10.28" r="3" opacity=".5"></circle><circle cx="2" cy="3" r="2" opacity=".3"></circle><path fill-rule="nonzero" d="M10.5,1 C9.67157288,1 9,1.67157288 9,2.5 C9,3.32842712 9.67157288,4 10.5,4 C11.3284271,4 12,3.32842712 12,2.5 C12,1.67157288 11.3284271,1 10.5,1 Z M10.5,7.10542736e-15 C11.8807119,7.10542736e-15 13,1.11928813 13,2.5 C13,3.88071187 11.8807119,5 10.5,5 C9.11928813,5 8,3.88071187 8,2.5 C8,1.11928813 9.11928813,7.10542736e-15 10.5,7.10542736e-15 Z" opacity=".3"></path></g><path fill="#FAFAFA" d="M67.1963269,6.66851903 L67.1963269,16.32 C67.2587277,17.3157422 67.675592,17.8136134 68.4469198,17.8136134 C69.2182476,17.8136134 72.735941,17.8136134 79,17.8136134 L67.1963269,6.66851903 Z"></path><use fill="#FFF" stroke="#D8D8D8" stroke-dasharray="3" stroke-width="2" mask="url(#defaultpage_nodata-b)" xlink:href="#defaultpage_nodata-a"></use><rect width="1" height="12" x="54" y="46" fill="#D8D8D8" rx=".5"></rect><rect width="1" height="17" x="62" y="40" fill="#D8D8D8" rx=".5"></rect><rect width="1" height="10" x="70" y="48" fill="#D8D8D8" rx=".5"></rect><rect width="1" height="14" x="78" y="43" fill="#D8D8D8" rx=".5"></rect></g></svg>
                                <p class=" text-center text-secondary">No Data</p>
                              </td>
                            </tr>
                            <?php
                          }else{
                            foreach($snapshot as $row){
                              $cust_id = $row['customer_id'];
                              $custSnap = $db->collection('customers')->document($cust_id)->snapshot();
                              ?>
                              <tr>
                                <td><?php echo "#".$row['order_no']; ?></td>
                                <td><?php echo $row['orderDateTime']; ?> </td>
                                <td><?php echo $custSnap['name']; ?></td>
                                <td>
                                  <?php
                                    if($row['order_status'] == 'Completed'){
                                      ?>
                                      <span class="badge badge-success">Completed</span>
                                      <?php
                                    }else if($row['order_status'] == 'Pending'){
                                      ?>
                                      <span class="badge badge-warning">Pending</span>
                                      <?php
                                    }else if($row['order_status'] == 'Delivered'){
                                      ?>
                                      <span class="badge badge-info">Delivered</span>
                                      <?php
                                    }else if($row['order_status'] == 'Cancelled'){
                                      ?>
                                      <span class="badge badge-danger">Cancelled</span>
                                      <?php
                                    }
                                  ?>
                                </td>
                                <td>
                                  <a href="../orders/detail.php?id=<?php echo $row->id() ?>" name="vi" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                        ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <a href="../orders/" class="btn btn-info float-left">All Orders</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Latest Added Products</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->

                <div class="card-body p-0">
                  <div class="table-responsive">
                  <ul class="products-list product-list-in-card pl-2 pr-2">
                    <?php
                    $docRefProd = $db->collection('products')->where('status', '=', 'Active')->limit(4);
                    $snapshotProd = $docRefProd->documents();

                    foreach($snapshotProd as $row){
                    if ($row->exists()) {
                    ?>
                      <li class="item">
                      <div class="product-img">
                        <?php
                        echo '<a href="../../dist/img/productImage/'.$row['image_url'].'"><img src="../../dist/img/productImage/'.$row['image_url'].'" class="img-thumbnail" alt="'.$row['name'].'" title="'.$row['name'].'"/></a>';
                        ?>
                      </div>
                      <div class="product-info">
                        <a href="../products/detail.php?id=<?php echo $row->id(); ?>" class="product-title" style="color: #007BFF;width: 50%;" data-toggle="tooltip" title="<?php echo $row["name"]; ?>">
                          <?php
                            $str = $row['name'];
                            $str = strlen($row['name']) > 23 ? substr($row['name'],0,23)."..." : $row['name'];
                            echo $str;
                          ?>
                        </a>
                          <?php
                            if($row['availability'] == 'Available'){
                              ?>
                              <span class="badge badge-success float-right">Available</span>
                              <?php
                            }else if($row['availability'] == 'Unavailable'){
                              ?>
                              <span class="badge badge-warning float-right">Unavailable</span>
                              <?php
                            }
                          ?>
                        <span class="product-description" style="width:80%;" data-toggle="tooltip" title="<?php echo $row["short_description"]; ?>">
                          <?php
                          $str = $row['short_description'];
                          $str = strlen($row['short_description']) > 35 ? substr($row['short_description'],0,35)."..." : $row['short_description'];
                          $strr = strip_tags($str, '');
                          if($row['short_description'] != ""){
                            echo $strr;
                          }else{
                            echo "No Description";
                          }
                          ?>
                          <br>
                          <b>RM <?php echo number_format($row['price'],2); ?></b>,
                           Qtt: <b><?php echo $row['quantity']; ?></b>&nbsp;
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
                        </span>
                      </div>
                    </li>
                    <?php
                    }else{
                      ?>
                      <br><br>
                      <div align="center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 93 87" style="width: 120px;">
                          <defs>
                            <rect id="defaultpage_nodata-a" width="45" height="33" x="44" y="32" rx="2"></rect>
                            <mask id="defaultpage_nodata-b" width="45" height="33" x="0" y="0" fill="#fff" maskContentUnits="userSpaceOnUse" maskUnits="objectBoundingBox">
                              <use xlink:href="#defaultpage_nodata-a"></use>
                            </mask>
                          </defs>
                          <g fill="none" fill-rule="evenodd" transform="translate(-3 -4)">
                            <rect width="96" height="96"></rect>
                            <ellipse cx="48" cy="85" fill="#F2F2F2" rx="45" ry="6"></ellipse>
                            <path fill="#FFF" stroke="#D8D8D8" d="M79.5,17.4859192 L66.6370555,5.5 L17,5.5 C16.1715729,5.5 15.5,6.17157288 15.5,7 L15.5,83 C15.5,83.8284271 16.1715729,84.5 17,84.5 L78,84.5 C78.8284271,84.5 79.5,83.8284271 79.5,83 L79.5,17.4859192 Z"></path>
                            <path fill="#DBDBDB" fill-rule="nonzero" d="M66,6 L67.1293476,6 L67.1293476,16.4294956 C67.1293476,17.1939227 67.7192448,17.8136134 68.4469198,17.8136134 L79,17.8136134 L79,19 L68.4469198,19 C67.0955233,19 66,17.849146 66,16.4294956 L66,6 Z"></path>
                            <g fill="#D8D8D8" transform="translate(83 4)"><circle cx="7.8" cy="10.28" r="3" opacity=".5"></circle>
                              <circle cx="2" cy="3" r="2" opacity=".3"></circle>
                              <path fill-rule="nonzero" d="M10.5,1 C9.67157288,1 9,1.67157288 9,2.5 C9,3.32842712 9.67157288,4 10.5,4 C11.3284271,4 12,3.32842712 12,2.5 C12,1.67157288 11.3284271,1 10.5,1 Z M10.5,7.10542736e-15 C11.8807119,7.10542736e-15 13,1.11928813 13,2.5 C13,3.88071187 11.8807119,5 10.5,5 C9.11928813,5 8,3.88071187 8,2.5 C8,1.11928813 9.11928813,7.10542736e-15 10.5,7.10542736e-15 Z" opacity=".3"></path>
                            </g>
                            <path fill="#FAFAFA" d="M67.1963269,6.66851903 L67.1963269,16.32 C67.2587277,17.3157422 67.675592,17.8136134 68.4469198,17.8136134 C69.2182476,17.8136134 72.735941,17.8136134 79,17.8136134 L67.1963269,6.66851903 Z"></path>
                            <use fill="#FFF" stroke="#D8D8D8" stroke-dasharray="3" stroke-width="2" mask="url(#defaultpage_nodata-b)" xlink:href="#defaultpage_nodata-a"></use>
                            <rect width="1" height="12" x="54" y="46" fill="#D8D8D8" rx=".5"></rect>
                            <rect width="1" height="17" x="62" y="40" fill="#D8D8D8" rx=".5"></rect>
                            <rect width="1" height="10" x="70" y="48" fill="#D8D8D8" rx=".5"></rect>
                            <rect width="1" height="14" x="78" y="43" fill="#D8D8D8" rx=".5"></rect>
                          </g>
                        </svg>
                      </div>
                      <p class=" text-center text-secondary">No Data</p>
                      <br>
                      <?php
                    }
                  }
                ?>
                </ul>
              </div>
              </div>
              <!-- /.card-body -->
               <div class="card-footer clearfix">
                 <a href="../products/add.php" class="btn btn-info float-left"><i class="fa fa-plus"></i> New Product </a>
                <a href="../products/" class="btn btn-info float-right">All Products</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          <!--HERE NEW TABLE FOR ADDED PRODUCT-->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row (main row) -->


        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Sales - <b><?php echo date("F Y");?></b></h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?php echo $base."orders/"; ?>" class="dropdown-item">View Orders</a>
                      <a href="<?php echo $base."reports/sales.php"; ?>" class="dropdown-item">View Sales Report</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div id="linediv"></div>
                  </div>
                </div>
              </div>
                <?php
                /*$date = date('d M Y');
                $query = "SELECT sum(sales) as sales, sum(profit) as profit, sum(subcost) as cost FROM orders WHERE orderStatus='Completed' AND orderDate = '$date'";
                $query_run = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($query_run)){*/
                  ?>
                  <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-4 col-6">
                      <div class="description-block border-right">
                        <!--<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>-->
                        <h5 class="description-header">RM <?php //echo number_format($row["sales"],2); ?></h5>
                        <span class="description-text">TODAY SALES</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                    <div class="col-sm-4 col-6">
                      <div class="description-block border-right">
                        <!--<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>-->
                        <h5 class="description-header">RM <?php //echo number_format($row["cost"],2); ?></h5>
                        <span class="description-text">SALES COST</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <div class="col-sm-4 col-6">
                      <div class="description-block border-right">
                        <!--<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>-->
                       <h5 class="description-header">RM <?php //echo number_format($row["profit"],2); ?></h5>
                        <span class="description-text">TODAY PROFIT</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->
              </div>
              <!-- ./card-body -->

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      <?php
    //}
    ?>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


<?php
/*$odate = date('Ymd');
$orderDocRef = $db->collection('orders')->where('order_status', '=', 'Completed')->where('orderDate', '<=', $odate)->where('orderDate', '>=', $odate);
$orderSnapshot = $orderDocRef->documents();
$sumSales = 0;*/
/*$query_li = "SELECT sum(sales) AS sumSales , orders.orderDate FROM orders WHERE orderStatus='Completed' AND orderMonth = '$oMonth' AND orderYear = '$oYear' GROUP BY orderDate";
$query_li_run = mysqli_query($connection, $query_li);*/
?>

<style>
#linediv {
  width: 100%;
  height: 400px;
}

</style>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("linediv", am4charts.XYChart);

// Add data
chart.data = [
  <?php
    /*foreach($orderSnapshot as $ord){
      $orderDate = date('d M Y', strtotime($ord['orderDate']));
      $sumSales += $ord['sales'];
      echo '
      {
        "date": "'.$orderDate.'",
        "value": "RM '.number_format($sumSales,2).'",
        "lineColor": chart.colors.next(),
      },
    ';
    }*/
  ?>
];


if (!chart.data || chart.data.length === 0){
  const noDataMessagecontainer = chart.chartContainer.createChild(am4core.Container);
  noDataMessagecontainer.align = 'center';
  noDataMessagecontainer.isMeasured = false;
  noDataMessagecontainer.x = am4core.percent(50);
  noDataMessagecontainer.horizontalCenter = 'middle';
  noDataMessagecontainer.y = am4core.percent(50);
  noDataMessagecontainer.verticalCenter = 'middle';
  noDataMessagecontainer.layout = 'vertical';

  const messageLabel = noDataMessagecontainer.createChild(am4core.Label);
  messageLabel.text = 'No Data Available';
  messageLabel.textAlign = 'middle';
  messageLabel.maxWidth = 300;
  messageLabel.wrap = true;
}

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.tooltipText = "{value}"
series.strokeWidth = 2;
series.minBulletDistance = 15;

// Drop-shaped tooltips
series.tooltip.background.cornerRadius = 20;
series.tooltip.background.strokeOpacity = 0;
series.tooltip.pointerOrientation = "vertical";
series.tooltip.label.minWidth = 40;
series.tooltip.label.minHeight = 40;
series.tooltip.label.textAlign = "middle";
series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "panXY";
chart.cursor.xAxis = dateAxis;
chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.parent = chart.leftAxesContainer;
chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(series);
chart.scrollbarX.parent = chart.bottomAxesContainer;

dateAxis.start = 0;
dateAxis.keepSelection = true;

// Enable export
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.menu.items = [
  {
    "label": "...",
    "menu": [
      {
        "label": "Images",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "type": "jpg", "label": "JPG" },
          { "type": "svg", "label": "SVG" },
        ]
      }, {
        "label": "Export",
        "menu": [
          { "type": "json", "label": "JSON" },
          { "type": "csv", "label": "CSV" },
          { "type": "xlsx", "label": "XLSX" },
          { "type": "html", "label": "HTML" },
          { "type": "pdfdata", "label": "PDF" }
        ]
      }, {
        "label": "Print", "type": "print"
      }
    ]
  }
];

}); // end am4core.ready()

</script>


<body class="hold-transition sidebar-mini layout-fixed">
<!--<body class="hold-transition sidebar-mini layout-navbar-fixed">-->

  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link"><i class="fa fa-clock"></i> <?php date_default_timezone_set("Asia/Kuala_Lumpur"); echo date('D, M d, h:ia'); ?></a>
        </li>

          <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-md">
                <input class="form-control form-control-navbar" type="search" placeholder="Search..." aria-label="Search" id="search_Bar">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
            <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size:14px;">

              <?php
              if (isset($_SESSION['user_name'])) {
                echo $_SESSION['user_name'];
              } else {
                echo "Please Login Again, Your Session is Ended";
              }
              ?>

            </span>

            <?php
              $docRef = $db->collection('admins');
              $snapshot = $docRef->document($_SESSION['user_id'])->snapshot();
              if($snapshot->exists()){
                  if($snapshot["image_url"] == ""){
                    ?>
                    <img class="img-profile rounded-circle" src="../../dist/img/avatar9.png" height="30px;" width="30px;" style="margin-top: -2px;">
                    <?php
                  }else{
                    echo '<img src="../../dist/img/profile/'.$snapshot['image_url'].'" width="30px" height="30px" class="img-circle" alt="image" style="margin-top: -2px;"/>';
                  }
              }
            ?>

          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="../settings/">
              <i class="fas fa-address-card fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- /.top navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->

      <a href="../dashboard/" class="brand-link" style="text-align:center;">
        <img src="../../dist/img/favicon.png" alt="INV" class="brand-image" style="opacity: .9;">
        <span class="brand-text font-weight-bold" style="font-size:20px;margin-right: 45px;">TIMEX Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <div class="mt-1 pb-1 mb-1 d-flex">


        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2" id="navTag">
          <!--Nav Bar class-->
          <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Dashboard</li>
              <li class="nav-item">
                <a href="../dashboard/" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>

            <li class="nav-header">Managements</li>

            <?php if($_SESSION['user_role'] == "SuperAdmin"){ ?>
              <li class="nav-item">
                <a href="../users/" class="nav-link">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Admins</p>
                </a>
              </li>
            <?php } ?>


                <li class="nav-item">
                  <a href="../customers/" class="nav-link">
                    <i class="nav-icon fa fa-users"></i>
                    <p>
                      Customers
                      <span class="badge badge-info right"></span>
                    </p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="../services/" class="nav-link">
                    <i class="nav-icon fa fa-comments"></i>
                    <p>
                      Customer Services
                      <span class="badge badge-info right"></span>
                    </p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="#" class="nav-link" id="prodManage">
                    <i class="nav-icon fas fa-fw fa-box"></i>
                    <p>
                      Catalog
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                          <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../products/add.php" class="nav-link" id="prodManage">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>
                              Add Product
                            </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="../products/" class="nav-link" id="prodManage">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>
                              Manage Product
                            </p>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <!--<li class="nav-item">
                      <a href="../attributes/" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Attributes
                          <span class="badge badge-info right"></span>
                        </p>
                      </a>
                    </li>-->
                     <li class="nav-item">
                      <a href="../attributes/" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Attributes
                          <span class="badge badge-info right"></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                    <a href="../brands/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Brands
                        <span class="badge badge-info right"></span>
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../categories/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Categories
                        <span class="badge badge-info right"></span>
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../reviews/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Reviews
                        <span class="badge badge-info right"></span>
                      </p>
                    </a>
                  </li>
                </ul>
            </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-shopping-bag"></i>
                  <p>
                    Orders
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                   <li class="nav-item">
                    <a href="../orders/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customer Orders</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../orders/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivery Orders</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../orders/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Return Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../orders/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cancelled Orders</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-header">Reports</li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-chart-bar"></i>
                  <p>
                    Sales & Profits
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../reports/sales.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sales Report</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="../reports/summarySales.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Sales Report</p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="../reports/summaryProfit.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Profit Report</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-item">
                <a href="../reports/analytics.php" class="nav-link">
                  <i class="nav-icon fa fa-chart-line"></i>
                  <p>
                    Analytics
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
              </li>

            <li class="nav-header">Settings</li>
            <!--Settings-->
                 <li class="nav-item">
                <a href="#" class="nav-link" onclick="rotate()">
                  <i class="nav-icon fa fa-cog rotate"></i>
                  <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../settings/" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Account Settings</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-header">Recycle Bin</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-trash"></i>
                <p>
                  Recycle Bin <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">

                  <?php if($_SESSION['user_role'] == "SuperAdmin"){ ?>
                  <li class="nav-item">
                    <a href="../recycle/admins.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Admins</p>
                    </a>
                  </li>
                  <?php } ?>

                  <li class="nav-item">
                    <a href="../recycle/customers.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customers</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="../recycle/products.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Products</p>
                    </a>
                  </li>

                </li>
              </ul>
            </li>


              <li class="nav-header">Sign Out</li>

                  <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="modal" data-target="#logoutModal">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

            <form action="../auth/code.php" method="POST">

              <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

            </form>


          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">

$(".nav-item a").on("click", function() {
  $(".nav-item a").removeClass("active");
  $(this).addClass("active");
});

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

<!--Scroll top button-->
<button onclick="topFunction()" id="scrollBtn" title="Scroll Top" class="btn btn-secondary">
  <i class="fa fa-angle-up" style="font-size: 18px;"></i>
</button>

<style>
  .btn-default{
    background-color: #f8f9fa;
    border-color: #ddd;
    color: #444;
  }

   #scrollBtn {
    display: none;
    position: fixed;
    width: 35px;
    height: 35px;
    bottom: 10px;
    right: 24px;
    line-height: 36px;
    opacity: 0.7;
    border: none;
    outline: none;
    color: #fff;
    cursor: pointer;
    padding: 0px;
    border-radius: 20%;
    text-align: center;
    background-color: #000;
  }

  #scrollBtn:hover {
    opacity: 0.6;
  }

  .rotate {
    -moz-transition: all .3s linear;
    -webkit-transition: all .3s linear;
    transition: all .3s linear;
}
.rotate.down {
    -moz-transform:rotate(90deg);
    -webkit-transform:rotate(90deg);
    transform:rotate(90deg);
}

</style>



<script>

  //Get the button
  var scrollbutton = document.getElementById("scrollBtn");

  window.onscroll = function() {
    scrollFunction()
  };

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollbutton.style.display = "block";
    } else {
    scrollbutton.style.display = "none";
    }
  }

  function topFunction() {
    $('html, body').animate({scrollTop : 0}, 300);
  }

  function rotate() {
    $('.rotate').toggleClass("down");
  }

</script>

    <script>
        $(".nav-item a").on("click", function (e) {
            $(".nav-item a").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
        });
    </script>
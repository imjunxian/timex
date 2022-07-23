<?php
include('../../database/dbconfig.php');
$title = "Reviews";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
.progress-label-left{
  float: left;
  margin-right: 0.5em;
  line-height: 1em;
}
.progress-label-right{
  float: right;
  margin-left: 0.3em;
  line-height: 1em;
}
.star-light{
	color:#e9ecef;
}
.text-warning {
  color: #ffc107;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Reviews</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Reviews</li>
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"><h2 class="card-title">Overall Shop Reviews</h2></div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-4 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                      <b><span id="average_rating">0.0</span> / 5</b>
                    </h1>
                    <div class="mb-3">
                      <i class="fas fa-star star-light mr-1 main_star"></i>
                      <i class="fas fa-star star-light mr-1 main_star"></i>
                      <i class="fas fa-star star-light mr-1 main_star"></i>
                      <i class="fas fa-star star-light mr-1 main_star"></i>
                      <i class="fas fa-star star-light mr-1 main_star"></i>
                    </div>
                    <h3>Total: <span id="total_review">0</span> Reviews</h3>
                  </div>
                  <div class="col-sm-4">
                    <p>
                      <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                      <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                      <div class="progress">
                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                      </div>
                    </p>
                    <p>
                      <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                      <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                      <div class="progress">
                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                      </div>
                    </p>
                    <p>
                      <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                      <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                      <div class="progress">
                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                      </div>
                    </p>
                    <p>
                      <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                      <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                      <div class="progress">
                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                      </div>
                    </p>
                    <p>
                      <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                      <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                      <div class="progress">
                          <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                      </div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="col-xl-4 col-md-6 col-sm-12">
                  <form action="code.php" method="POST" id="statusForm">
                    <div class="input-group" style="">
                      <select class="form-control multiselect" id="status" name="status">
                        <option value="" selected disabled>--- Select Status ---</option>
                        <option value="All">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                      </select>
                      <span class="input-group-btn">
                          <button class="btn btn-default" type="submit" name="submit_Btn" style="display: inline-block;">Filter</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <form action="">
                <div class="card-header">
                  <h2 class="card-title">Product Reviews</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <?php
                  if(isset($_GET["status"])){
                    if($_GET['status'] == "Pending"){
                      $docRef = $db->collection('reviews')->where("status", '==', 'Pending');
                      $snapshot = $docRef->documents();
                    }else if($_GET['status'] == "Approved"){
                      $docRef = $db->collection('reviews')->where("status", '==', 'Approved');
                      $snapshot = $docRef->documents();
                    }else if($_GET['status'] == "Rejected"){
                      $docRef = $db->collection('reviews')->where("status", '==', 'Rejected');
                      $snapshot = $docRef->documents();
                    }
                  }else{
                    $docRef = $db->collection('reviews');
                    $snapshot = $docRef->documents();
                  }
                  ?>
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5">#No</th>
                          <th width="120px">Product Name</th>
                          <th width="100px">Customer</th>
                          <th>Reviews</th>
                          <th>Ratings</th>
                          <th width="80px">DateTime</th>
                          <th>Status</th>
                          <th style="text-align:center;" width="120px"><i class="fa fa-cog"></i> Actions</th>
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
                        $n=0;
                        foreach ($snapshot as $row) {
                          $n++;
                            if ($row->exists()) {
                            ?>
                            <tr>
                                <td><?= $n ?></td>
                                <td>
                                    <?php
                                    $product_id = $row['product_id'];
                                    $recordProd = $db->collection('products');
                                    $recordProduct = $recordProd->document($product_id)->snapshot();
                                    if($recordProduct->exists()) {
                                        echo "<a href='../products/detail.php?id={$product_id}'>".$recordProduct['name']."</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $customer_id = $row['customer_id'];
                                    $recordCust = $db->collection('customers');
                                    $recordCustomer = $recordCust->document($customer_id)->snapshot();
                                    if($recordCustomer->exists()) {
                                        echo $recordCustomer['name'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo '<span style="font-weight:500;">'.$row['title'].'</span>'; ?><br>
                                    <?php echo '<span style="font-size:14px;color: #6C757D;">'.$row['review'].'</span>'; ?>
                                </td>
                                <td width='10'><?php echo $row['rating']; ?></td>
                                <td><?php echo $row['datetime']; ?></td>
                                <td width='10'>
                                <?php
                                    if($row['status'] == 'Approved'){
                                    ?>
                                    <span class="badge badge-success">Approved</span>
                                    <?php
                                    }else if($row['status'] == 'Rejected'){
                                    ?>
                                    <span class="badge badge-danger">Rejected</span>
                                    <?php
                                    }else if($row['status'] == 'Pending'){
                                      ?>
                                      <span class="badge badge-warning">Pending</span>
                                      <?php
                                      }
                                ?>
                                </td>
                                <td style="text-align:center;">
                                  <form action="code.php" method="post">
                                    <div class="btn">
                                      <a href="#" class="btn btn-primary editBtn"
                                        data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit Review Status"></i></a>
                                      <a href="#" class="btn btn-danger deleteBtn"
                                      data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Remove Review"></i></a>
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
          <h5 class="modal-title" id="exampleModalLabel">Delete Review?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to delete it.</p>

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

<!--Edit Toggles-->
<div class="modal fade" id="editForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reply Reviews & Review Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="code.php" id="replyForm" method="post" >
          <div class="modal-body">
            <input type="hidden" class="form-control" id="reviewId" value="" name="reviewId">
            <div class="form-group">
              <label> Reply to Customer </label>
              <textarea class="form-control" placeholder="Reply Messages" rows="5" name="reply" id="reply"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Review Status</label>
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="editRadioPrimary1" name="editStatus" class="status approved" value="Approved">
                      <label for="editRadioPrimary1">
                      Approved
                      </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="editRadioPrimary2" name="editStatus" class="status rejected" value="Rejected">
                      <label for="editRadioPrimary2">
                      Rejected
                      </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="editRadioPrimary3" name="editStatus" class="status pending" value="Pending">
                      <label for="editRadioPrimary3">
                      Pending
                      </label>
                  </div>
                </div>
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
    $(function () {
        $('#dataTable').on('click', 'a.deleteBtn', function(e) {
            e.preventDefault();
            var link = this;
            var deleteModal = $("#deleteModal");
            // store the ID inside the modal's form
            deleteModal.find('input[name=deleteid]').val(link.dataset.id);
            // open modal
            deleteModal.modal();
        });
    });

    //AJAX for get data in modal
    $(document).ready(function(){
      $('.editBtn').on('click', function(){
          var reviewId = $(this).attr("data-id");
          $.ajax({
              url:"code.php",
              type:"POST",
              data:{reviewId:reviewId},
              dataType: "json",
              success: function(data){
                  $('#reviewId').val(reviewId);
                  $('#reply').val(data.reply);
                  $('input[value="'+data.status+'"]').prop('checked', true);

                  $('#updateBtn').val('.editBtn');
                  $('#editForm').modal('show');
              },
              error: function (data) {
                  alert("Something went wrong");
              },
          });
      });
    });

    load_rating_data();

    function load_rating_data(){
      $.ajax({
          url:"code.php",
          method:"POST",
          data:{action:'load_data'},
          dataType:"json",
          success:function(data){
              $('#average_rating').text(data.average_rating);
              $('#total_review').text(data.total_review);

              var count_star = 0;
              $('.main_star').each(function(){
                count_star++;
                if(Math.ceil(data.average_rating) >= count_star){
                  $(this).addClass('text-warning');
                  $(this).addClass('star-light');
                }
              });

              $('#total_five_star_review').text(data.five_star_review);
              $('#total_four_star_review').text(data.four_star_review);
              $('#total_three_star_review').text(data.three_star_review);
              $('#total_two_star_review').text(data.two_star_review);
              $('#total_one_star_review').text(data.one_star_review);
              $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');
              $('#four_star_progress').css('width', (data.four_star_review/data.total_review) * 100 + '%');
              $('#three_star_progress').css('width', (data.three_star_review/data.total_review) * 100 + '%');
              $('#two_star_progress').css('width', (data.two_star_review/data.total_review) * 100 + '%');
              $('#one_star_progress').css('width', (data.one_star_review/data.total_review) * 100 + '%');

        }
      })
    }

</script>
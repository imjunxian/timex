<?php
include('../../database/dbconfig.php');
$title = "Services";
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
                <h1 class="m-0">Services</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
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
                      <div class="card-body">
                          <div class="col-xl-4 col-md-6 col-sm-12">
                          <form action="code.php" method="POST" id="statusForm">
                          <div class="input-group" style="">
                          <select class="form-control multiselect" id="status" name="status">
                            <option value="" selected disabled>--- Select Status ---</option>
                            <option value="All">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Solved">Solved</option>
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
                      <h2 class="card-title">Customer Services</h2>
                      <a class="btn btn-primary float-right" href="https://dashboard.kommunicate.io/conversations" target="_blank">
                        <i class="fa fa-comments"></i> ChatBot
                      </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="table-responsive">
                        <?php
                        if(isset($_GET["status"])){
                          if($_GET['status'] == "Pending"){
                            $docRef = $db->collection('contacts')->where("status", '==', 'Pending');
                            $snapshot = $docRef->documents();
                          }else if($_GET['status'] == "Solved"){
                            $docRef = $db->collection('contacts')->where("status", '==', 'Solved');
                            $snapshot = $docRef->documents();
                          }
                        }else{
                          $docRef = $db->collection('contacts');
                          $snapshot = $docRef->documents();
                        }
                        ?>

                        <table id="dataTable" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th width="10">#No</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>Subject</th>
                              <th>Reported Date</th>
                              <th>Status</th>
                              <th style="text-align:center;" width="20%"><i class="fa fa-cog"></i> Actions</th>
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
                                      <td><?php echo $row['subject']; ?></td>
                                      <td>
                                        <?php echo $row['dateTime']; ?>
                                      </td>
                                       <td>
                                        <?php
                                            if($row['status'] == 'Solved'){
                                              ?>
                                                  <span class="badge badge-success">Solved</span>
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

                                            <button type="submit" name="viewBtn" class="btn btn-info" data-toggle="tooltip" title="View Message"><i class="fa fa-eye" style="font-size:14px;"></i></button>

                                            <a href="mailto:<?= $row['email'] ?>" class="btn btn-primary" data-toggle="tooltip" title="Reply to <?= $row['email']?>"><i class="fa fa-envelope"></i></a>

                                            <input type="hidden" name="delete_id" value="<?php echo $row->id(); ?>">
                                            <a href="#deleteModal" class="btn btn-danger deleteBtn" data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Delete Message"></i></a>
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
          <h5 class="modal-title" id="exampleModalLabel">Delete this record?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you want to delete.</p>

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

  $(function() {
    $('#statusForm').validate({
      rules: {
        status: {
          required: true,
        },
      },
      messages: {
        status: {
          required: "Status is required.",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
    });
  });

</script>
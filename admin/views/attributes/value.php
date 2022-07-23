<?php
include('../../database/dbconfig.php');
$title = "Attribute Values";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<!--Add Toggles-->
    <div class="modal fade" id="addForm">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Attribute Value</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="value_code.php" id="addF" method="post" >
              <div class="modal-body">
                <div class="form-group">
                  <label> Attribute Value Name </label>
                  <input type="text" class="form-control" placeholder="Enter Attribute Value Name" name="attValueName" required>
                </div>
                 <div class="form-group">
                  <label for="exampleInputFile">Status</label>
                    <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary1" name="status" class="active" value="Active" checked>
                          <label for="radioPrimary1">
                          Active
                          </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary2" name="status" class="Deactive" value="Inactive">
                          <label for="radioPrimary2">
                              Inactive
                          </label>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <input class="form-control" type="hidden" name="parentId" value=<?php echo $_GET['id']?>>
                </div>

              </div>
              <!--Submit button-->
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addBtn">Add</button>
              </div>
            </form><!--Form end-->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

           <!--Edit Toggles-->
  <div class="modal fade" id="editForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Attribute Value</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="value_code.php" id="addF" method="post" >
          <div class="modal-body">
            <input type="hidden" class="form-control" id="attvId" value="" name="attvId">
            <div class="form-group">
                <label> Attribute Value Name </label>
                <input type="text" class="form-control" id="attName" placeholder="Enter Attribute Value Name" name="editName" >
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Status</label>
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="editRadioPrimary1" name="editStatus" class="status active" value="Active">
                      <label for="editRadioPrimary1">
                      Active
                      </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="editRadioPrimary2" name="editStatus" class="status inactive" value="Inactive">
                      <label for="editRadioPrimary2">
                        Inactive
                      </label>
                  </div>
                </div>
            </div>

             <div class="form-group">
                  <input class="form-control" type="hidden" name="parentId" value=<?php echo $_GET['id']?>>
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Attribute Values</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item"><a href="../attributes/">Attributes</a></li>
                <li class="breadcrumb-item active">Attribute Values</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <?php
                            $docNameRef = $db->collection('attributes');
                            $snapshotName = $docNameRef->document($_GET['id'])->snapshot();
                            if ($snapshotName->exists()) {
                                ?>
                                <h2 class="card-title">Attribute: <b><?php echo $snapshotName['name']; ?></b></h2>
                                 <button type="button" class="btn btn-secondary float-right" data-toggle="modal" onclick='window.location.href="../attributes/"'>
                                  Back
                                </button>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <form action="">
                <div class="card-header">
                  <h2 class="card-title">Attribute Value Records</h2>
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addForm">
                    <i class="fa fa-plus"></i> Add
                  </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <?php
                    $docRef = $db->collection('attribute_values')->where('parent_id', '==', $_GET['id']);
                    $snapshot = $docRef->documents();
                  ?>
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="10%">#No</th>
                          <th>Attribute Value Name</th>
                          <th>Status</th>
                          <th style="text-align:center;" width="250px;"><i class="fa fa-cog"></i> Actions</th>
                        </tr>
                      </thead>

                      <tfoot>
                              <tr>
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
                                <td><?php  echo $row['name']; ?></td>
                                <td width="25%">
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
                                  <form action="code.php" method="POST">
                                    <div class="btn">
                                        <a href="#" class="btn btn-primary editBtn"
                                        data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-alt" style="font-size:14px;" data-toggle="tooltip" title="Edit <?php echo $row["name"]; ?>"></i></a>

                                        <a href="#" class="btn btn-danger deleteBtn"
                                        data-id="<?php echo $row->id(); ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" data-toggle="tooltip" title="Remove <?php echo $row["name"]; ?>"></i></a>
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
          <form action="value_code.php" method="POST">
            <input type="hidden" name="deleteid" value="" />
            <input type="hidden" name="parentId" value="<?= $_GET['id']; ?>" />
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

    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }

    $(function () {

      $.validator.addMethod("valueNotEquals", function(value, element, arg){
          return arg !== value;
      }, "Value must not equal arg.");

      $('#addF').validate({
        rules: {
          attName: {
            required: true,
          },
          status: {
            required: true,
          },
        },
        messages: {
          attName: {
            required: "Attribute Name cannot be empty",
          },
           status: {
            required: "Status cannot be empty",
          },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
      });
    });

    //AJAX for get data in modal
    $(document).ready(function(){
      $('.editBtn').on('click', function(){
          var attvId = $(this).attr("data-id");
          $.ajax({
              url:"value_code.php",
              type:"POST",
              data:{attvId:attvId},
              dataType: "json",
              success: function(data){
                  $('#attvId').val(attvId);
                  $('#attName').val(data.name);
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

</script>
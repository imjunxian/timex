<?php
include('../../database/dbconfig.php');
$title = "Reports";
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
                <h1 class="m-0">Sales Report</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Sales Report</li>
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
                    <div class="card-header">
                      <h2 class="card-title">Report</h2>
                      <button type="button" class="btn btn-secondary float-right" onclick="window.print();">
                         <i class="fa fa-print"></i> Print
                      </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                 <form action="sales.php" method="POST">
                                    <div class="input-group">
                                        <div id="reportrange" class="form-control">
                                            <i class="fa fa-calendar"></i>
                                            <span></span> <i class="fa fa-caret-down"></i>
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" name="submit_Btn" style="display: inline-block;">Generate</button>
                                        </span>
                                    </div>
                                    <input type="hidden" name="sDate" id="sDate" class="form-control">
                                    <input type="hidden" name="eDate" id="eDate" class="form-control">
                                </form>
                            </div>
                        </div>

                        <br>
                      <div class="table-responsive">
                        <table id="dataTableRe" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                                <th width="10px;">No</th>
                                <th>#Invoice No</th>
                                <th>Name</th>
                                <th>DateTime</th>
                                <th>Status</th>
                                <th>Sales</th>
                                <th>Profits</th>
                            </tr>
                          </thead>
                          <tbody>
                                <?php
                                    if(isset($_POST["submit_Btn"])){
                                        $start = date_create($_POST["sDate"]);
                                        $startD = date_format($start, "Ymd");
                                        $end = date_create($_POST["eDate"]);
                                        $endD = date_format($end, "Ymd");

                                        $query_sum = $db->collection('orders')->where('order_status', '=', 'Completed')->where('orderDay', '>=', $startD)->where('orderDay', '<=', $endD)->orderBy('orderDay', 'DESC');
                                        $query_sum_run = $query_sum->documents();
                                        $n = 0;

                                        foreach($query_sum_run as $row){
                                            $n++;
                                            $cust_id = $row['customer_id'];
                                            $custSnap = $db->collection('customers')->document($cust_id)->snapshot();
                                            ?>
                                                <tr>
                                                   <td><?php echo $n; ?></td>
                                                  <td><?php $in = $row['order_no']; echo "#$in"; ?></td>
                                                  <td><?php echo $custSnap['name']; ?></td>
                                                  <td><?php echo $row['orderDateTime']; ?></td>
                                                  <td>
                                                    <?php
                                                    if($row['order_status'] == "Pending"){
                                                        ?>Pending<?php
                                                        }elseif($row['order_status'] == "Delivered"){
                                                        ?>Delivered<?php
                                                        }elseif($row['order_status'] == "Completed"){
                                                        ?>Completed<?php
                                                        }elseif($row['order_status'] == "Cancelled"){
                                                        ?>Cancelled<?php
                                                        }
                                                    ?>
                                                  </td>
                                                  <td> RM <?php echo number_format($row['sales'],2);?></td>
                                                  <td> RM <?php echo number_format($row['profits'],2); ?></td>
                                                </tr>
                                             <?php
                                        }

                                    }
                                ?>
                          </tbody>
                          <tfoot>
                            <?php
                                if(isset($_POST['submit_Btn'])){
                                    $start = date_create($_POST["sDate"]);
                                    $startD = date_format($start, "Ymd");
                                    $end = date_create($_POST["eDate"]);
                                    $endD = date_format($end, "Ymd");

                                    $query_sum_cal = $db->collection('orders')->where('order_status', '=', 'Completed')->where('orderDay', '>=', $startD)->where('orderDay', '<=', $endD)->orderBy('orderDay', 'DESC');
                                    $query_sum_cal_run = $query_sum_cal->documents();

                                    $sales = 0;
                                    $profits = 0;

                                    foreach($query_sum_cal_run as $row_cal){
                                        $sales += $row_cal['sales'];
                                        $profits += $row_cal['profits'];
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="5" style="text-align:right;">Total : </th>
                                        <th>RM <?php echo number_format($sales,2); ?></th>
                                        <th>RM <?php echo number_format($profits,2); ?></th>
                                    </tr>
                                    <?php
                                }
                            ?>
                          </tfoot>
                        </table>
                      </div>
                      <!--Table responsive-->
                    </div>
                    <!-- /.card-body -->

                    <!--<div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick='window.location.href="../reports/totalSales.php"'>
                            Total Sales Report <i class="fa fa-chart-pie"></i>
                        </button>
                        <button type="button" class="btn btn-primary" onclick='window.location.href="../reports/totalProfit.php"'>
                            Total Profit Report <i class="fa fa-chart-pie"></i>
                        </button>
                    </div>-->

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

<script type="text/javascript">
$(function() {

    var start = moment().subtract(0, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 14 Days': [moment().subtract(13, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        $('input#sDate').val(picker.startDate.format('DD-MM-YYYY'));
        $('input#eDate').val(picker.endDate.format('DD-MM-YYYY'));
    });

    cb(start, end);

});
</script>

<script type="text/javascript">
    if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

    $("#dataTableRe").DataTable({
      "dom":"l<'row'<'col-sm-3'B><'col-sm-9'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
       "oLanguage": {
          "sLengthMenu": "Show _MENU_ records",
      },
      "aLengthMenu": [[10, 15, 20, 50, 100, -1], [10, 15, 20, 50, 100, 'All']],
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "paginationType": 'full_numbers',
      buttons: [
            /*{
                extend: 'pageLength',
                titleAttr: 'pageLength',
                className: 'btn-default',
            },*/
            {
                extend: 'collection',
                text: '<i class="fas fa-list"></i>',
                className: 'btn-default',
                buttons: [
                  {
                      extend: 'excelHtml5',
                      text: '<i class="fas fa-file-excel text-green"></i> Excel',
                      titleAttr: 'Excel',
                      className: 'btn-info',
                      exportOptions: {
                            stripHtml: false
                      },
                  },
                  {
                      extend: 'csvHtml5',
                      text: '<i class="fas fa-file-csv text-olive"></i> CSV',
                      titleAttr: 'CSV',
                      className: 'btn-success',
                      exportOptions: {
                            stripHtml: false
                      },
                  },
                  {
                      extend: 'pdfHtml5',
                      text: '<i class="fas fa-file-pdf text-danger"></i> PDF',
                      titleAttr: 'PDF',
                      className: 'btn-danger',
                      exportOptions: {
                            stripHtml: false
                      },
                  },
                  {
                      extend: 'print',
                      text: '<i class="fas fa-print text-dark"></i> Print',
                      titleAttr: 'Print',
                      className: 'btn-secondary',
                      exportOptions: {
                              stripHtml : false,
                      },
                  },
                ],
            },
            {
              extend: 'colvis',
              text: '<i class="fas fa-columns"></i>',
              titleAttr: 'Colvis',
              className: 'btn-default ',
            },
            {
               extend:'',
               text: '<i class="fas fa-sync-alt"></i>',
               titleAttr: 'Refresh Table',
              className: 'btn-default',
            },
      ],
      infoCallback: function( settings, start, end, max, total, pre ) {
        return "Showing " + start +" to "+ end + " of " + total +" records ";
      }

    }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');

</script>
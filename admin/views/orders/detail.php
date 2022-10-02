<?php
include('../../database/dbconfig.php');
$title = "Orders";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<?php
if(isset($_GET["id"])){
    $oids = $_GET["id"];

    $docRef = $db->collection('orders');
    $row = $docRef->document($oids)->snapshot();

    if($row->exists()){
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../dashboard/">Home</a></li>
                    <li class="breadcrumb-item">Orders</li>
                    <li class="breadcrumb-item active">Order Details</li>
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
                        <a href="javascript:history.go(-1)" class="btn btn-secondary">Back</a>
                        <!--<a href="../orders/print.php?id=<?php echo $row->id();?>" class="btn btn-dark"><i class="fa fa-print"></i> Print</a>-->
                        </div>
                    </div>
                </div>
            </div>
        <!-- title row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                        <form action="code.php" id="addF" method="POST">
                            <div class="invoice p-3 mb-3">
                            <!-- title row -->

                                    <div class="row">
                                        <div class="col-lg-9 col-md-9 col-sm-9">
                                            <h4>Purchasing Invoice <br>
                                            <small style="font-size:18px;">DateTime: <?php echo $row["orderDateTime"];?></small>
                                            </h4><br>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <?php $billId = $row["order_no"];?>
                                            <h5>Invoice No : </h5>
                                            <small style="font-size:16px;"><b style="font-size:16px;"><?php echo "#$billId"; ?></b></small>
                                            <input type="hidden" class="form-control" name="invid" id="invid" placeholder="Invoice ID" autocomplete="off" value="<?php echo $billId; ?>" required>
                                        </div>
                                    </div>
                                    <!-- info row -->


                                    <div class="row invoice-info">
                                    <div class="col-sm-9 invoice-col">
                                        <br>
                                        <?php
                                        $companyDoc = $db->collection("company")->document("Qwh7lii8yRbpD62j6u1R")->snapshot();
                                        ?>
                                        <address >
                                        <h5><?=$companyDoc['name']?></h5>
                                        <span class="font-italic">
                                        <?=$companyDoc['address']?>
                                        </span><br><br>
                                        <b>Tel</b>: <?=$companyDoc['contact']?><br>
                                        <b>Email</b>: <?=$companyDoc['email']?><br>
                                        </address>
                                    </div>
                                    <!-- /.col -->


                            <div class="col-sm-3 invoice-col pull-right">
                                <br>
                                <h5>Customer Details:</h5>
                                <?php
                                $cust_id = $row['customer_id'];
                                $custSnap = $db->collection('customers')->document($cust_id)->snapshot();
                                ?>
                                <span class="h6"><b>Name: </b></span><br>
                                <span class="font-italic"><?php echo $custSnap['name']?></span><br>
                                <span class="h6"><b>Contact: </b></span><br>
                                <span class="font-italic"><?php echo $custSnap['contact']?></span><br>
                                <span class="h6"><b>Email: </b></span><br>
                                <span class="font-italic"><?php echo $custSnap['email']?></span><br>
                                <span class="h6"><b>Shipping Address: </b></span><br>
                                <span class="font-italic"><?php echo $custSnap['address']?></span><br>
                                <?php
                                ?>
                            </div>

                            </div>
                            <!-- /.row -->


                            <br><br>
                                <!-- Table row -->
                                <div class="row">
                                <?php
                                $orderItemDocRef = $db->collection('order_item')->where('order_id', '=', $oids);
                                $row_ordItem = $orderItemDocRef->documents();
                                ?>
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th width="12%">Images</th>
                                        <th width="12%">SKU</th>
                                        <th width="35%">Products</th>
                                        <th>Quantity</th>
                                        <th>Price (RM)</th>
                                        <th>Amount (RM)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($row_ordItem as $oi_row){
                                            $prodDoc = $db->collection('products')->where('stripe_product_id', '=', $oi_row['stripe_product_id'])->documents();
                                            foreach($prodDoc as $rowProd){
                                            ?>
                                            <tr>
                                                <td><?php echo '<img src="../../dist/img/productImage/'.$rowProd['image_url'].'" class="img-thumbnail-table" alt="'.$rowProd["name"].'" title="'.$rowProd["name"].'"/>'; ?></td>
                                                <td><?=$rowProd["sku"]?></td>
                                                <td><?=$rowProd["name"]?></td>
                                                <td><?=$oi_row["quantity"]?></td>
                                                <td><?=number_format($oi_row["price"], 2)?></td>
                                                <td><?=number_format($oi_row["amount"], 2)?></td>
                                            </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <br>
                                <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-lg-5 col-md-5 col-xs-12" style="margin-top:1%;">
                                    <p class=""><b>Notes:</b></p>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Noted Here" rows=6 name="orderNote" disabled=""><?php echo $row["note"]; ?></textarea>
                                    </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-xs-0" style="margin-top:1%;">

                                    </div>
                                <!-- /.col -->
                                <div class="col-lg-6 col-md-12">
                                    <p class="lead"></p>

                                    <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                        <th style="width:50%">Subtotal :</th>
                                        <td>RM <?php echo number_format($row["subtotal"],2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Shipping :</th>
                                        <td>RM <?php echo number_format($row["shipping_fee"],2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Payment Method :</th>
                                        <td>
                                            <?php
                                                if($row["payment_method"] == "COD"){
                                                    echo "<span>Cash on Delivery (COD)</span>";
                                                }
                                            ?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>Status :</th>
                                        <td>
                                            <?php
                                                if($row['order_status'] == 'Completed'){
                                                ?>
                                                    <span class="badge badge-success" style="font-size:14px;">Completed</span>
                                                <?php
                                                }else if($row['order_status'] == 'Pending'){
                                                ?>
                                                    <span class="badge badge-warning" style="font-size:14px;">Pending</span>
                                                <?php
                                                }else if($row['order_status'] == 'Cancelled'){
                                                ?>
                                                    <span class="badge badge-danger" style="font-size:14px;">Cancelled</span>
                                                <?php
                                                }else if($row['order_status'] == 'Delivered'){
                                                    ?>
                                                        <span class="badge badge-info" style="font-size:14px;">Delivered</span>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        </tr>
                                        <tr class="h5">
                                        <th>Total :</th>
                                        <td><b>RM <?php echo number_format($row["sales"],2); ?><b></td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.invoice -->

                        </form>


                </div>
            </div>

        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <?php
    }else{
        ?>
        <script> location.replace("../orders/index.php?idnotfound"); </script>
        <?php
    } // end else
} //end if GET
?>




</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>
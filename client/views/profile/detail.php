<?php
include '../../database/security.php';
$title = "Order";
include('../../includes/header.php');
//include('../../includes/navbar.php');
?>

<style>
.img-thumbnail-table{
  padding: 0.25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: 0.25rem;
  height: auto;
  width: 100px;
  height: 100px;
  object-fit: fill;
}
</style>

<?php
if(isset($_GET["id"])){
    $oids = $_GET["id"];

    $docRef = $db->collection('orders');
    $row = $docRef->document($oids)->snapshot();

    if($row -> exists()){
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="">


        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                        <form action="code.php" id="addF" method="POST">
                            <div class="invoice p-3 mb-3">
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
                                $result = 0;
                                $numRow = [];
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
                                            $prod_data = $oi_row['stripe_product_id'];
                                            $oi_qtt = $oi_row["quantity"];
                                            $oi_price = $oi_row["price"];
                                            $oi_amo = $oi_row["amount"];
                                            $i=-1;
                                            foreach($prod_data as $pd => $p){
                                                $i++;
                                                $prodDoc = $db->collection('products')->where('stripe_product_id', '=', $p)->documents();
                                                foreach($prodDoc as $rowProd){
                                                ?>
                                                <tr>
                                                    <td><?php echo '<img src="../../../../timex/admin/dist/img/productImage/'.$rowProd['image_url'].'" class="img-thumbnail-table" alt="'.$rowProd["name"].'" title="'.$rowProd["name"].'"/>'; ?></td>
                                                    <td><?=$rowProd["sku"]?></td>
                                                    <td><?=$rowProd["name"]?></td>
                                                    <td><?= $oi_qtt[$i] ?></td>
                                                    <td><?= number_format($oi_price[$i], 2); ?></td>
                                                    <td><?= number_format($oi_amo[$i], 2); ?></td>
                                                </tr>
                                                <?php
                                                }
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
                                <div class="col-lg-5 col-md-5 col-xs-5" style="margin-top:1%;">
                                    <p class=""><b>Notes:</b></p>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Noted Here" rows=6 name="orderNote" disabled=""><?php echo $row["note"]; ?></textarea>
                                    </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-xs-0" style="margin-top:1%;">

                                    </div>
                                <!-- /.col -->
                                <div class="col-lg-6 col-md-6">
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
                                                }elseif($row["payment_method"] == "Card"){
                                                    echo "<span>Card</span>";
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
                                                    <span class="label label-success" style="font-size:14px;">Completed</span>
                                                <?php
                                                }else if($row['order_status'] == 'Pending'){
                                                ?>
                                                    <span class="label label-warning" style="font-size:14px;">Pending</span>
                                                <?php
                                                }else if($row['order_status'] == 'Cancelled'){
                                                ?>
                                                    <span class="label label-danger" style="font-size:14px;">Cancelled</span>
                                                <?php
                                                }else if($row['order_status'] == 'Delivered'){
                                                    ?>
                                                        <span class="label label-info" style="font-size:14px;">Delivered</span>
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
        <script> location.replace("../profile/"); </script>
        <?php
    } // end else
} //end if GET
?>




</div>
<!-- /.content-wrapper -->


<?php
include('../../includes/script.php');
?>
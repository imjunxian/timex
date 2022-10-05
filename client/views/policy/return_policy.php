<?php
include '../../database/dbconfig.php';
$title = "Return Policy";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
.bs-callout {
    margin: 20px 0;
    padding: 15px 15px 15px 15px;
    border-left: 5px solid #eee;
}
.policy{
    text-align: justify;
}
</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Return Policy</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Return Policy</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="products section">
  <div class="container">

    <div class="bs-callout bs-callout">
        <h4>Thank you for shopping at Timex!</h4>
        <p class="policy">
        We offer refund and/or exchange within the first 7 days of your purchase, if 7 days have passed since your purchase, you will not be offered a refund and/or exchange of any kind.
        </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img class="img-responsive" src="../client/dist/images/shop/category/img6.jpg">
        </div>
    </div>

    <div class="bs-callout bs-callout">
        <h4>Eligibility for Refunds and Exchanges</h4>
        <p class="policy">
        (i) Your item must be unused and in the same condition that you received it.
        <br>
        (ii) The item must be in the original packaging.
        <br>
        (iii) To complete your return, we require a receipt or proof of purchase.
        <br>
        (iv) Only regular priced items may be refunded, sale items cannot be refunded.
        <br>
        (v) If the item in question was marked as a gift when purchased and shipped directly to you, you will receive a gift credit for the value of your return.
        </p>
        <br>
        <h4>Exchanges</h4>
        <p class="policy">
        We only replace items if they are defective or damaged. If you need to exchange it for the same item, send us an email at <b><?= $docRefInfo['email'] ?></b> or <a href="../contact/" target="_blank" class="text-primary">Contact Us</a> and send your item to our nearby store.
        </p>
    </div>

    <div class="bs-callout bs-callout">
        <h4>Exempt Goods</h4>
        <p class="policy">
        The following are exempt from refunds:
        <br>
        (i) Gift cards
        <br>
        (ii) Some health and personal care item
        </p>
        <br>
        <h4>Partial Refunds are Granted</h4>
        <p class="policy">
        (i) Any item not in its original condition, is damaged or missing parts for reasons not due to our error.
        <br>
        (ii) Any item that is returned more than 30 days after delivery.
        <br>
        Once your return is received and inspected, we will send you an email to notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund.
        <br>
        If you are approved, then your refund will be processed, and a credit will automatically be applied to your credit card or original method of payment, within a certain amount of days.
        </p>
        <br>
        <h4>Late or Missing Refunds</h4>
        <p class="policy">
        (i) If you have not received a refund yet, first check your bank account again. Then contact your credit card company, it may take some time before your refund is officially posted.
        <br>
        (ii) If you have done all of this and you still have not received your refund yet, please send us email <b><?= $docRefInfo['email'] ?></b> or <a href="../contact/" target="_blank" class="text-primary">Contact Us</a>
        </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img class="img-responsive" src="../client/dist/images/shop/category/img10.jpg">
        </div>
    </div>

    <div class="bs-callout bs-callout">
        <h4>Shipping</h4>
        <p class="policy">
        (i) Please do not send the product back to the manufacturer. It must be sent to our store.
        <br>
        (ii) You will be responsible for paying for your own shipping costs for returning your item.
        <br>
        (iii) Shipping costs are non-refundable! If you receive a refund, the cost of return shipping will be deducted from your refund.
        <br>
        (iv) Depending on where you live, the time it may take for your exchanged product to reach you, may vary.
        <br>
        (v) Please see, we cannot guarantee that we will receive your returned item.
        </p>
    </div>

    <div class="bs-callout bs-callout">
        <h4>Need Help?</h4>
        <p class="policy">
        Contact us by:
        <br>
        (i) Our Contact Us Page <a href="../contact/" target="_blank" class="text-primary">here</a>
        <br>
        (ii) Calling Us at <b><?= $docRefInfo['contact'] ?></b>
        <br>
        (iii) Email us at <b><?= $docRefInfo['email'] ?></b>
        <br>
        (iv) Visit our store: <b><?= $docRefInfo['address'] ?></b>
        </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img class="img-responsive" src="../client/dist/images/shop/category/img15.jpg">
        </div>
    </div>

</div>
</section>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

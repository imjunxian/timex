<?php
include '../../database/security.php';
$title = "Thank You";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style>
.card-category {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}
.card-category .card {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.card .card-body {
  flex: 0 50%;
  background: #fff;
  box-shadow: 0 2px 4px 0 rgba(136, 144, 195, 0.2),
    0 5px 15px 0 rgba(37, 44, 97, 0.15);
  border-radius: 15px;
  margin: 8px;
  padding: 10px 15px;
  position: relative;
  z-index: 1;
  overflow: hidden;
  min-height: 420px;
  transition: 0.7s;
}

.card .card-body:hover::before {
  background: rgb(85 108 214 / 10%);
}

.card .card-body:hover .solu_title h3,
.card .card-body:hover .solu_description p {
  color: #fff;
}

.card .card-body:before {
  content: "";
  position: absolute;
  background: rgb(85 108 214 / 5%);
  width: 170px;
  height: 400px;
  z-index: -1;
  transform: rotate(42deg);
  right: -56px;
  top: -23px;
  border-radius: 35px;
}

.card .card-body:hover .solu_description button {
  background: #fff !important;
  color: #309df0;
}

.card-body .solu_title h3 {
  color: #212121;
  font-size: 1.3rem;
  margin-top: 13px;
  margin-bottom: 13px;
}

.card .solu_description p {
  font-size: 15px;
  margin-bottom: 15px;
}

.card .solu_description button {
  border: 0;
  border-radius: 15px;
  background: linear-gradient(
    140deg,
    #42c3ca 0%,
    #42c3ca 50%,
    #42c3cac7 75%
  ) !important;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 5px 16px;
}

@media only screen and (max-width: 946px){
    .card .card-body {
        min-height: 360px;
    }
 }

 @media only screen and (max-width: 620px){
    .card .card-body {
        min-height: 430px;
    }
 }

 @media only screen and (max-width: 446px){
    .card .card-body {
        min-height: 480px;
    }
 }
</style>

<section class="page-wrapper success-msg">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="card-category">
            <div class="card">
                <div class="card-body">
                    <div class="block text-center" style="padding:5rem;">
                        <i class="tf-ion-android-checkmark-circle"></i>
                        <h2 class="text-center">Thank you! For Choosing Us.</h2>
                        <p>Your order has been placed! You'll receive your items soon.</p>
                        <a href="../home/" class="btn btn-main mt-20">Return Home</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>


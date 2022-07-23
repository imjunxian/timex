<?php
include '../../database/security.php';
$title = "Profile";
include('../../includes/header.php');
include('../../includes/navbar.php');
?>

<style type="text/css">
.profile-body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    margin-bottom: 5%;
    margin-top: 3%;
}
.main-body {
    padding: 15px;
}

.nav-link {
    color: #4a5568;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Profile</h1>
          <ol class="breadcrumb">
            <li><a href="../home/">Home</a></li>
            <li class="active">Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>



<div class="container profile-body">

  <!--<div class="alert alert-danger alert-common alert-dismissible " role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <i class="fa fa-times-circle"></i> Email already exists. Please try another :(
  </div>

  <div class="alert alert-success alert-common alert-dismissible " role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <i class="fa fa-check-circle"></i> Profile Updated :)
  </div>-->

      <div class="row gutters-sm">
        <div class="col-md-4 d-none d-md-block">
          <div class="card">
            <div class="card-body">
              <nav class="nav d-flex flex-column nav-pills nav-gap-y-1" style="display:flex;flex-direction: column;">
                <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active" style="padding: 2%;">
                 Profile Information
                </a>
                <a href="#account" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded" style="padding: 2%;">
                  Account Settings
                </a>
                <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded" style="padding: 2%;">
                  Security
                </a>
                <a href="#order" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded" style="padding: 2%;">
                  Order History
                </a>
              </nav>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card">
            <div class="card-header border-bottom mb-3 d-flex d-md-none">
              <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                <li class="nav-item">
                  <a href="#profile" data-toggle="tab" class="nav-link has-icon active">Profile</a>
                </li>
                <li class="nav-item">
                  <a href="#account" data-toggle="tab" class="nav-link has-icon">Account</a>
                </li>
                <li class="nav-item">
                  <a href="#security" data-toggle="tab" class="nav-link has-icon">Security</a>
                </li>
                <li class="nav-item">
                  <a href="#order" data-toggle="tab" class="nav-link has-icon">Order History</a>
                </li>
              </ul>
            </div>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6>PROFILE INFORMATION</h6>
                <hr>
                <?php
                $id = $_SESSION['client_user_id'];
                $docRef = $db->collection('customers');
                $row = $docRef->document($id)->snapshot();
                  if ($row->exists()) {
                  ?>
                  <form action="code.php" method="POST" id="profileForm">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?= $row['name'] ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="username">Email</label>
                          <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?= $row['email'] ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="contact">Phone Number</label>
                          <input type="text" class="form-control" id="contact" placeholder="Phone Number, eg. 0123456789" name="contact" value="<?= $row['contact'] ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="dob">Date of Birth</label>
                          <input type="date" class="form-control" id="dob" placeholder="Date of Birth" name="dob" value="<?= $row['dob'] ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Gender</label>
                      <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary1" name="gender" class="male" value="Male" <?php if ($row['gender'] == "Male") { echo "checked";} ?>>
                          <label for="radioPrimary1">Male</label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary2" name="gender" class="female" value="Female" <?php if ($row['gender'] == "Female") { echo "checked";} ?>>
                            <label for="radioPrimary2">Female</label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input type="radio" id="radioPrimary3" name="gender" class="unknown" value="Unknown" <?php if ($row['gender'] == "Unknown") { echo "checked";} ?>>
                            <label for="radioPrimary3">Rather Not To Say</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea class="form-control autosize" id="address" placeholder="Delivery Address" rows="5" name="address"><?= $row['address'] ?></textarea>
                    </div>
                    <a href="https://www.google.com/maps/place/<?= $row['address'] ?>" target="_blank" class="btn btn-main btn-small btn-round">Locations</a>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="updateProfileBtn">Update Profile</button>
                  </form>
                  <?php
                  }
                ?>
              </div>

              <div class="tab-pane" id="account">
                <h6>ACCOUNT SETTINGS</h6>
                <hr>
                <form action="code.php" method="POST" id="usernameForm">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="New Email" name="email" required>
                  </div>
                  <button type="submit" class="btn btn-primary" name="updateEmailBtn">Update Email</button>
                </form>
                  <hr>
                <form action="" method="POST" id="deactivateForm">
                  <div class="form-group">
                    <label class="d-block text-danger">Deactivate Account</label>
                    <p class="text-muted font-size-sm">Once you deactivate your account, you're not allow to login with this account.</p>
                    <p class="text-muted font-size-sm">To activate your account, you need to contact us.</p>
                  </div>
                  <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deactivateModal">
                    Deactivate Account
                  </a>
                </form>
              </div>
              <div class="tab-pane" id="security">
                <h6>SECURITY SETTINGS</h6>
                <hr>
                <form action="code.php" method="POST" id="passwordForm">
                  <label class="d-block">Change Password</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="Enter your current password" name="currentPassword" required>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="Enter your new password" name="password" id="password" required>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm your new password" name="cpassword" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <p class="mb-2">Password requirements</p>
                      <p class="small text-muted mb-2">To change a new password, you have to meet all of the following requirements:</p>
                      <ul class="small text-muted pl-4 mb-0">
                        <li>Minimum 8 characters</li>
                        <li>At least One Uppercase</li>
                        <li>At least One Lowercase</li>
                        <li>At least One Number</li>
                      </ul>
                    </div>
                  </div>
                  <hr>
                  <button type="submit" class="btn btn-primary" name="updatePasswordBtn">Update Password</button>
                </form>

              </div>


              <div class="tab-pane" id="order">
                <h6>ORDER HISTORY</h6>
                <hr>
                <!--<div class="row">
                  <div class="col-md-9">
                    <div class="block">
                        <h5 class="">Oops! Seems like there is no order found in your account.</h5>
                        <a href="../shop/" class="btn btn-main btn-small btn-round mt-20">Shop Now</a>
                    </div>
                  </div>
                </div>-->
                <div class="table-responsive">
                  <table class="table m-0 table-striped">
                    <thead>
                      <tr>
                        <th>#Order No.</th>
                        <th>OrderDateTime</th>
                        <th>Total (RM)</th>
                        <th>Status</th>
                        <th><i class="fa fa-cog"></i> Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>#PO-9118624</td>
                        <td>05 Jan 2022 21:44:19</td>
                        <td>999.00</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <a href="../orders/detail.php?id=<?php echo $row['orderId']; ?>" name="view" class="btn btn-info"><i class="fa fa-eye"></i></a>
                          <a href="#" name="return" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>#PO-9118624</td>
                        <td>05 Jan 2022 21:44:19</td>
                        <td>1699.00</td>
                        <td><span class="label label-success">Completed</span></td>
                        <td>
                          <a href="../orders/detail.php?id=<?php echo $row['orderId']; ?>" name="vi" class="btn btn-info"><i class="fa fa-eye"></i></a>
                          <a href="#" name="return" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

     <div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Confirm deactivate this account?
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </h4>
          </div>
          <div class="modal-body">Select "Confirm" below if you confirm to deactivate your account.</div>
          <div class="modal-footer justify-content-between">
            <form action="code.php" method="POST">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button type="submit" name="deactivateBtn" class="btn btn-primary">Confirm</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php
include('../../includes/script.php');
include('../../includes/footer.php');
?>

<script type="text/javascript">
   function callback() {
    const submitButton = document.getElementById("loginBtn");
    submitButton.removeAttribute("disabled");
  }
  $(function() {
        $.validator.addMethod(
          "regex",
          function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
          },
          "Please check your input."
        );

        $('#profileForm').validate({
          rules: {
            fullname:{
              required: true,
            },
            username: {
              required: true,
            },
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            contact:{
              required: true,
              //can remove [\+]? => question mark, this means user must include + in input
              regex: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
            },
            dob:{
              required: true,
            },
            gender:{
              required: true,
            },
            address:{
              required: true,
            },
          },
          messages: {
            fullname:{
              required: "* Your full name is required",
            },
            username: {
              required: "* Username is required",
            },
            email: {
              required: "* Email is required",
              email: "* Invaild email",
              regex: "* Invalid email"
            },
            contact:{
              required: "* Contact is required",
              regex: "* Invalid Format. You must include your country code such as +60123456789",
            },
            dob:{
              required: "* Date of Birth is required",
            },
            gender:{
              required: "* Gender is required",
            },
            address:{
              required: "* Address is required",
            },
          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
      });

      $('#usernameForm').validate({
          rules: {
            username: {
              required: true,
            },
            email: {
              required: true,
              email: true,
              regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
          },
          messages: {
            username: {
              required: "* Username is required",
            },
            email: {
              required: "* Email is required",
              email: "* Invaild email",
              regex: "* Invalid email"
            },
          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });

      $('#passwordForm').validate({
          rules: {
            currentPassword: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
            },
            password: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
            },
            cpassword: {
              required: true,
              regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
              equalTo: "#password",
            },
          },
          messages: {
            currentPassword: {
              required: "* Current Password is required",
              regex: "* Minimum 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
            },
            password: {
              required: "* Password is required",
              regex: "* Minimum 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter"
            },
            cpassword: {
              required: "* Please confirm your password",
              regex: "* Minimum 8 characters which is contained 1 number, 1 uppercase, 1 lowercase letter",
              equalTo: "* Confirm Password must be same with the new password"
            },
          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });

  if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

      $(".toggle-password").on("click", function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password");
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
</script>
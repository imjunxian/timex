<?php
include '../../database/dbconfig.php';
include './Rsa.php';
$title = "Test";

use encryption\Rsa;

$privateKey = './key/private_key.pem';
$publicKey = './key/rsa_public_key.pem';

$rsa = new Rsa($privateKey, $publicKey);

/*$email = "demo@demo.com";
$ecryptionData = $rsa->privEncrypt($email);
$decryptionData = $rsa->publicDecrypt($ecryptionData);

echo 'encrypt：' . $ecryptionData.PHP_EOL;
echo 'decrypt: ' . $decryptionData;*/

$docRef = $db->collection('customer_encrypt');
$row = $docRef->document('hUPd7QMMhVEom4jICtzr')->snapshot();

$email_en = $rsa->privEncrypt($row['email']);
$contact_en = $rsa->privEncrypt($row['contact']);
$name_en = $rsa->privEncrypt($row['name']);
$password_en = $rsa->privEncrypt($row['password']);

$email_de = $rsa->publicDecrypt($email_en);
$contact_de = $rsa->publicDecrypt($contact_en);
$name_de = $rsa->publicDecrypt($name_en);
$password_de = $rsa->publicDecrypt($password_en);

/*echo $name_en;
echo "<br>";
echo $contact_en;
echo "<br>";
echo $email_en;
echo "<br>";
echo $password_en;
echo "<br>";
echo '<br>';
echo $name_de;
echo "<br>";
echo $contact_de;
echo "<br>";
echo $email_de;
echo "<br>";
echo $password_de;
echo "<br>"*/
?>
<?php
    if(isset($_SESSION["danger"])){
        echo $_SESSION['danger'];
        unset($_SESSION["danger"]);
    }
?>
<?php
    if(isset($_SESSION["session_name"])){
        echo $_SESSION['session_name'];
        ?>
        <form action="code.php" method="post">
        <button type="submit" class="btn btn-main btn-medium btn-round" id="logout_btn" name="logout_btn">Logout</button>
        </form>
        <?php
    }
?>
<form action="code.php" method="post">
    <div class="form-group">
        <input type="email" class="form-control"  placeholder="Email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
    </div>

    <div class="col-12 mt-10">
        <button type="submit" class="btn btn-main btn-medium btn-round" id="loginBtn" name="loginBtn">Login</button>
    </div>
</form>
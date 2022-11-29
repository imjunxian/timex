<?php
include('../../../dbconfig.php');
include('../../../rsa/Rsa.php');

use encryption\Rsa;

$privateKey = '../../../rsa/key/private_key.pem';
$publicKey = '../../../rsa/key/rsa_public_key.pem';

$rsa = new Rsa($privateKey, $publicKey);

if($db)
{
    // echo "Database Connected";
}
else
{
    echo "Database Not Connected";
}

?>
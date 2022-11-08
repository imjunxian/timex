<?php
require __DIR__.'/vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;

session_start();

$projectID = 'timex-338211';
$keyFilePath = 'C:\xampp\htdocs\timex\timex-338211-firebase-adminsdk-frpng-8d427011d4.json';

Stripe::setApiKey('sk_test_51KFH6RCFJt3ZkTxSJLa9c20sVaxygf3CTqRqn0CHiJNB2rvpXdgQ2cjjlssfL8SAYu2aixWenp2XuhBRksiux2KA00NcSlkwkT');
$stripe = new \Stripe\StripeClient('sk_test_51KFH6RCFJt3ZkTxSJLa9c20sVaxygf3CTqRqn0CHiJNB2rvpXdgQ2cjjlssfL8SAYu2aixWenp2XuhBRksiux2KA00NcSlkwkT');

$db = new FirestoreClient([
    'projectId' => $projectID,
    'keyFilePath' => $keyFilePath,
]);

?>
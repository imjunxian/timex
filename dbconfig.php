<?php
require __DIR__.'/vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;

session_start();

$projectID = 'YOUR_FIREBASE_PROJECT_ID';
$keyFilePath = 'YOUR_KEY_FILE_PATH';

Stripe::setApiKey('YOUR_STRIPE_API_KEY');
$stripe = new \Stripe\StripeClient('YOUR_STRIPE_API_KEY');

$db = new FirestoreClient([
    'projectId' => $projectID,
    'keyFilePath' => $keyFilePath,
]);

?>
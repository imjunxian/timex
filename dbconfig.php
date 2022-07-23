<?php
require __DIR__.'/vendor/autoload.php';

/*use Kreait\Firebase\Factory;

$factory = (new Factory)
//Generate a new private key in firebase
->withServiceAccount('')
//Get the url link from real time database (firebase)
->withDatabaseUri('');

$database = $factory->createDatabase();*/


use Google\Cloud\Firestore\FirestoreClient;

session_start();

$projectID = 'timex-338211';
$keyFilePath = 'C:\xampp\htdocs\timex\timex-338211-firebase-adminsdk-frpng-8d427011d4.json';

$stripe = new \Stripe\StripeClient('sk_test_51KFH6RCFJt3ZkTxSJLa9c20sVaxygf3CTqRqn0CHiJNB2rvpXdgQ2cjjlssfL8SAYu2aixWenp2XuhBRksiux2KA00NcSlkwkT');

$db = new FirestoreClient([
    'projectId' => $projectID,
    'keyFilePath' => $keyFilePath,
]);

?>
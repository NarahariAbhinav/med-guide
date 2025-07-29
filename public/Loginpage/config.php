<?php
require_once('vendor/autoload.php');

$google_client = new Google_Client();

$google_client->setClientId('751693788443-mlpk1hcr1747jo79t45d2lsjetsnskra.apps.googleusercontent.com');

$google_client->setClientSecret('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');

$google_client->setRedirectUri('http://localhost/Homepage/');

$google_client->addScope('email');
$google_client->addScope('profile');

session_start();

?>
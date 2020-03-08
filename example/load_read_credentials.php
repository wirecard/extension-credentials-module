<?php

$basePath = dirname(dirname(__FILE__));
require_once $basePath. "/vendor/autoload.php";

$credentialFilePath = dirname(__FILE__) .DIRECTORY_SEPARATOR . "default_credentials.xml";

$module = new Credentials\Module($credentialFilePath);
$credentials = $module->getCredentials();

print_r("Credit Card Credentials\n");
/** @var Credentials\Config\CreditCardConfig $creditCardCredentialsConfig */
$creditCardCredentialsConfig = $credentials['creditcard'];
print_r($creditCardCredentialsConfig->getThreeDMerchantAccountId() . PHP_EOL);
print_r($creditCardCredentialsConfig->getThreeDSecret() . PHP_EOL);
print_r($creditCardCredentialsConfig->getWppUrl() . PHP_EOL);

print_r("Paypal Card Credentials\n");
/** @var Credentials\Config\DefaultConfig $paypalCredentialsConfig */
$paypalCredentialsConfig = $credentials['paypal'];
print_r($paypalCredentialsConfig->getMerchantAccountId() . PHP_EOL);
print_r($paypalCredentialsConfig->getBaseUrl() . PHP_EOL);

print_r("Iterate Credentials\n");
foreach ($credentials as $paymentMethod => $credentialsConfig) {
    print_r($paymentMethod . " => " . $credentialsConfig->getMerchantAccountId() . PHP_EOL);
    print_r($paymentMethod . " => " . $credentialsConfig->getBaseUrl() . PHP_EOL);
}
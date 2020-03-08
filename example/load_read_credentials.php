<?php

$basePath = dirname(dirname(__FILE__));
require_once $basePath . "/vendor/autoload.php";

$credentialFilePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "default_credentials.xml";

try {
    $module = new Credentials\Credentials($credentialFilePath);
} catch (Credentials\Exception\InvalidPaymentMethodException $e) {
    $credentials = [];
} catch (Credentials\Exception\InvalidXMLFormatException $e) {
    $credentials = [];
} catch (Credentials\Exception\MissedCredentialsException $e) {
    $credentials = [];
}

try {
    print_r("Paypal Card Credentials\n");
    if ($paypal = $module->getCredentialsByPaymentMethod(Credentials\Constants\PaymentMethod::TYPE_PAYPAL)) {
        print_r($paypal->getMerchantAccountId() . PHP_EOL);
        print_r($paypal->getBaseUrl() . PHP_EOL);
    }
    print_r("Credit Card Credentials\n");
    if ($creditCard = $module->getCredentialsByPaymentMethod(Credentials\Constants\PaymentMethod::TYPE_CREDIT_CARD)) {
        print_r($creditCard->getThreeDMerchantAccountId() . PHP_EOL);
        print_r($creditCard->getThreeDSecret() . PHP_EOL);
        print_r($creditCard->getWppUrl() . PHP_EOL);
    }
} catch (Credentials\Exception\InvalidPaymentMethodException $e) {
    print_r($e->getMessage() . PHP_EOL);
}

$credentials = $module->getCredentials();
print_r("Iterate Credentials\n");
foreach ($credentials as $paymentMethod => $credentialsConfig) {
    print_r($paymentMethod . " => " . $credentialsConfig->getMerchantAccountId() . PHP_EOL);
    print_r($paymentMethod . " => " . $credentialsConfig->getBaseUrl() . PHP_EOL);
}

$rawXML = file_get_contents($credentialFilePath);
$credentials = [];
try {
    $reader = new Credentials\Reader\XMLReader($rawXML);
    $credentials = $reader->toArray();
} catch (Credentials\Exception\InvalidXMLFormatException $e) {
    print_r($e->getMessage() . PHP_EOL);
}

$credentialsConfigFactory = new Credentials\Config\ConfigFactory();
if ($credentials[Credentials\Constants\PaymentMethod::TYPE_CREDIT_CARD]) {
    try {
        $creditCardConfig = $credentialsConfigFactory->createConfig(
            Credentials\Constants\PaymentMethod::TYPE_CREDIT_CARD,
            $credentials[Credentials\Constants\PaymentMethod::TYPE_CREDIT_CARD]
        );
        print_r("CreditCard => " . $creditCardConfig->getWppUrl() . PHP_EOL);
        print_r("CreditCard => " . $creditCardConfig->getThreeDMerchantAccountId() . PHP_EOL);
        print_r("CreditCard => " . $creditCardConfig->getThreeDSecret() . PHP_EOL);
    } catch (Credentials\Exception\InvalidPaymentMethodException $e) {
        print_r($e->getMessage() . PHP_EOL);
    } catch (Credentials\Exception\MissedCredentialsException $e) {
        print_r($e->getMessage() . PHP_EOL);
    }
}

if ($credentials[Credentials\Constants\PaymentMethod::TYPE_PAYPAL]) {
    try {
        $defaultConfig = $credentialsConfigFactory->createConfig(
            Credentials\Constants\PaymentMethod::TYPE_PAYPAL,
            $credentials[Credentials\Constants\PaymentMethod::TYPE_PAYPAL]
        );
        print_r("Paypal => " . $defaultConfig->getBaseUrl() . PHP_EOL);
        print_r("Paypal => " . $defaultConfig->getMerchantAccountId() . PHP_EOL);
        print_r("Paypal => " . $defaultConfig->getSecret() . PHP_EOL);
        print_r("Paypal => " . $defaultConfig->getHttpUser() . PHP_EOL);
        print_r("Paypal => " . $defaultConfig->getHttpPassword() . PHP_EOL);
    } catch (Credentials\Exception\InvalidPaymentMethodException $e) {
        print_r($e->getMessage() . PHP_EOL);
    } catch (Credentials\Exception\MissedCredentialsException $e) {
        print_r($e->getMessage() . PHP_EOL);
    }
}

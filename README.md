# Credentials Module

Read credentials from xml file based on schema.xsd schema template and generate configuration 
object per payment method.

## How to setup

Using composer install the package
````
composer require wirecard/extentions-credentials-module
````

### Directory Structure

```
example/             example of usage
src/                 source path
  Config/            credential configs
  Exception/         custom exceptions
  Reader/            reader [XMLReader]
tests/               unit tests
```

### src/Credentials.php

The ```Credentials.php``` file is Facade and entry point to project.

````
$xmlFilePath = "credentials.xml";
$credentials = Credentials\Credentials($xmlFilePath);
````

By initiating of ````Credentials```` facade we should pass in constructor path to 
credentials xml file based on schema.xsd provided in the root of the project.
It will bw generated list of config object with credentials per payment 
method provided in the file.
````Credentials```` facade provides to methods.
- getConfigByPaymentMethod(PaymentMethod $paymentMethod)
  - Gets credentials config by payment method. As parameter it should be used 
  `````PaymentMethod````` ValueObject
- getConfig()
  - Returns list of credentials configs in format
   ````
  [sepadirectdebit] => CredentialsConfigInterface | CredentialsCreditCardConfig
  ````

### Reader

The ````Reader```` folder contains the ```XMLReader``` to be able read XML format.
````validate()```` method as a part of the ````ReaderInterface```` and checks file through the ````schema.xsd````.
In the future it should be able implement ````ReaderInterface```` and adapt constructor 
of ````Credentials```` facade to read different formats like JSON / YAML and etc.

### Exception

The ````Exception```` folder contains all the defined exceptions used in the project.

### Config

The ````Config```` folder contains Config classes
(based on ````CredentialsConfigInterface````|````CredentialsCreditCardConfig```` interfaces) which will be generated based on data received 
from a reader or just an array of data.

* DefaultConfig
  * getBaseUrl()
  * getMerchantAccountId()
  * getSecret()
  * getHttpUser()
  * getHttpPassword()
* CreditCardConfig
  * getWppUrl()
  * getThreeDMerchantAccountId()
  * getThreeDSecret()

Usually you could have wrapped values of the object back in array format.
For this purposes you should use ````toArray```` method.
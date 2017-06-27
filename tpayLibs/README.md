# tpay.com

Library for all payment methods available in tpay.com

## Installation

Install via composer:
```php
composer require tpay-com/tpay-php
```
Install via git over ssh:
```php
git clone git@github.com:tpay-com/tpay-php.git
```

Install via git over https:
```php
git clone https://github.com/tpay-com/tpay-php.git
```
manual download:
https://github.com/tpay-com/tpay-php/archive/master.zip

## Configuration

Replace all occurrences of the following codes on real data from the Merchant panel (https://secure.tpay.com/panel)
or declare them dynamically (see examples):

### Basic / Basic with bank selection / eHat 

  * [MERCHANT_ID] - merchant id ex. 1010
  * [MERCHANT_SECRET] - merchant secret ex. demo
  
   Example of usages: [Basic](examples/BasicPaymentForm.php) [Basic with bank selection](examples/BankSelection.php) [eHat](examples/BasicEhatForm.php)
  
### Transaction API / create, get, refund, report 
  
   * [MERCHANT_ID] - merchant id ex. 14868
   * [MERCHANT_SECRET] - merchant secret ex. nd6u7duYeso4hrtc
   * [TR_API_KEY] - api merchantSecret ex. 
   * [TR_API_PASS] - api password ex. nd6u7duYeso4hrtc
    
   Example of usages: [Create transaction](examples/TransactionApiExample.php) [Refund Transaction](examples/TransactionRefund.php)
    
  
### Card Basic / Card On-Site

  * [CARD_API_KEY] - card API merchantSecret ex. 455ue12b1c26a9570vb852b31680ce6k3f706p9
  * [CARD_API_PASSWORD] - card API merchantSecret ex. od0ufdrYap343r0
  * [CARD_API_CODE] - card API code ex. i2128h0e6b17a78fn3c1adaod262o120
  * [CARD_RSA_KEY] - card RSA merchantSecret ex. S10tLS1CURdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUXCQVFVQUE0R05ERBNCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1GlDXNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJ11FRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ==
  * [CARD_HASH_ALG] - card hash algorithm ex. sha1
  
  Example of usages: [Card Basic Form](examples/CardBasicForm.php) [Card On-site Gateway](examples/CardGate.php)
  
### Szkwal / White Label

  * [MERCHANT_ID] - merchant id ex. 14868
  * [MERCHANT_SECRET] - merchant secret ex. nd6u7duYeso4hrtc
  * [SZKWAL_LOGIN] - szkwal API login ex. supershop
  * [SZKWAL_API_PASSWORD] - szkwal API password ex. igtht7i7m08tdsg4wsztrrgRDSHA
  * [SZKWAL_API_HASH] - szkwal API hash ex. fjk8IGjnh92TEcvfpo3usdZ
  * [SZKWAL_PARTNER_ADDRESS] - szkwal unique partner address ex. c_supershop
  * [SZKWAL_TITLE_FORMAT] - pattern of unique client title ex. KIR[0-9]{9}
  
  Example of usages: [Szkwal](examples/Szkwal.php) [White Label](examples/WhiteLabel.php)
  
### DAC / Masspayment / Transaction API requests

  * [MERCHANT_ID] - merchant id ex. 14868
  * [MERCHANT_SECRET] - merchant secret ex. nd6u7duYeso4hrtc
  * [TRANSACTION_API_KEY] - transaction API merchantSecret ex. c4fb9c5482e16a848e68dbb1488ed42ddcb82311
  * [TRANSACTION_API_PASS] - transaction API secret ex. bd6u7drYesa43rtw
  
 Example of usages: [DAC](examples/Dac.php) [Masspayment and Transaction API](examples/MassPayment.php)
 
Library has own logging system to save all confirmations and notifications sent by Tpay.com server
Be sure that file src/log is writable and add rule to htaccess to deny access to this file from browser

## Requirements

  * PHP > 5.6.0

## Language

For this moment library supports two languages (EN, PL). Default language is english.
Change language example:

```php
//All Tpay class constructors load Lang class
$tpay = new PaymentSzkwal();

//After this line all static messages (input labels, buttons titles) will be displayed in Polish
Lang::setLang('pl');
```

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT)
but uses third party libraries that are distributed under their own terms (see LICENSE-3RD-PARTY.md)

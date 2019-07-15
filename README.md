# Tpay

Library for all payment methods available in Tpay

## Requirements

  * PHP > 5.6.0

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

The only thing you need to do is to set your API access data via $this-> ([see examples](tpayLibs/examples))
You can generate access keys in tpay merchant panel (https://secure.tpay.com/panel)

The [loader.php](tpayLibs/examples/BasicPaymentForm.php) file handles all required class loading, so you can include this file to any file you are editing
(remember to configure your current working path correctly).

All methods described in [tpay documentation](https://docs.tpay.com) can be easily executed by extending required class in main [src](tpayLibs/src) folder ([see examples](tpayLibs/examples))
  
###Example configuration data should look like this:

  merchantId - merchant id ex. 1010
  
  merchantSecret - merchant secret ex. demo

##### Basic Payments and bank selection forms: 
  
   Example of usages: [Basic](tpayLibs/examples/BasicPaymentForm.php), [Bank selection html form](tpayLibs/examples/BankSelection.php), [Bank selection API form](tpayLibs/examples/BankSelectionAPI.php), [Blik form](tpayLibs/examples/BlikTransactionExample.php)
  
##### Transaction API / create, get, refund, report 
    
   Example of usages: [Create transaction](tpayLibs/examples/TransactionApiExample.php), [Refund Transaction](tpayLibs/examples/TransactionRefund.php), [Refund Transaction Status](tpayLibs/examples/TransactionRefundStatus.php)
  
##### Card Basic / Card On-Site

  Example of usages: [Card basic form](tpayLibs/examples/CardBasic.php), [Card On-site Gateway](tpayLibs/examples/CardGate.php), [Card payment links builder](tpayLibs/examples/CardPaymentLinkBuilder.php), [Card On-site Gateway with saved cards](tpayLibs/examples/CardGateExtended.php)

## Logs
Library has own logging system to save all confirmations and notifications sent by Tpay.com server, outgoing requests and exceptions.
Be sure that file src/Logs directory is writable and add rule to Apache htaccess or NGINX to deny access to this area from browser.
The log files are created for each day separately under 'Logs' directory.

The logging is enabled by default but you can switch this feature by command:
 
 ```php
Util::$loggingEnabled = false;
 ```

You can also set your own logging path by this command:

 ```php
Util::$customLogPatch = '/my/own/path/Logs/';
 ```
 The logs file names will be assigned automatically.

## Custom templates path

You can set your own templates path so you can copy and modify the phtml template files from this library.

 ```php
Util::$customTemplateDirectory = '/my/own/templates/path/';
 ```

## Language

For this moment library supports two languages (EN, PL). Default language is english.
Change language example:

```php
//All Tpay class constructors load Lang class
$tpay = new BankSelectionExample();

//After this line all static messages (input labels, buttons titles) will be displayed in Polish
(new Util())->setLanguage('pl');

If you want to access translations manually, use:
$language = new Lang()
$language->setLang('pl'); for setting language
$language->l('pay'); to echo translated key
```

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT)
but uses third party libraries that are distributed under their own terms (see LICENSE-3RD-PARTY.md)

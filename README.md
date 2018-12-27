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

The only thing you need to do is to set your API access data via $this-> ([see examples](tpayLibs/examples))
You can generate access keys in tpay merchant panel (https://secure.tpay.com/panel)

The [loader.php](tpayLibs/examples/BasicPaymentForm.php) file handles all required class loading, so you can include this file to any file you are editing
(remember to configure your current working path correctly).

All methods described in [tpay documentations](https://tpay.com/en/documentation) can be easily executed by extending required class in main [src](tpayLibs/src) folder ([see examples](tpayLibs/examples))
  
###Example configuration data should look like this:

  merchantId - merchant id ex. 1010
  
  merchantSecret - merchant secret ex. demo

##### Basic Payments and bank selection forms: 
  
   Example of usages: [Basic](tpayLibs/examples/BasicPaymentForm.php), [Bank selection html form](tpayLibs/examples/BankSelection.php), [Bank selection API form](tpayLibs/examples/BankSelectionAPI.php)
  
##### Transaction API / create, get, refund, report 
    
   Example of usages: [Create transaction](tpayLibs/examples/TransactionApiExample.php), [Refund Transaction](tpayLibs/examples/TransactionRefund.php)
  
##### Card Basic / Card On-Site

  Example of usages: [Card basic form](tpayLibs/examples/CardBasicForm.php), [Card On-site Gateway](tpayLibs/examples/CardGate.php)
  
##### Szkwal / White Label

  Example of usages: [Szkwal](tpayLibs/examples/Szkwal.php), [White Label](tpayLibs/examples/WhiteLabel.php)
  
##### DAC / Masspayment / Transaction API requests

 Example of usages: [DAC](tpayLibs/examples/Dac.php), [Masspayment and Transaction API](tpayLibs/examples/MassPayment.php)
 
Library has own logging system to save all confirmations and notifications sent by Tpay.com server
Be sure that file src/log is writable and add rule to htaccess to deny access to this file from browser

## Requirements

  * PHP > 5.6.0

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

##Logs
This library provides automatic logging mechanism. The log files are created for each day separately under 'Logs' directory.

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT)
but uses third party libraries that are distributed under their own terms (see LICENSE-3RD-PARTY.md)

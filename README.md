# Tpay

Library for all payment methods available in [Tpay](https://tpay.com).

[![Latest stable version](https://img.shields.io/packagist/v/tpay-com/tpay-php.svg?label=current%20version)](https://packagist.org/packages/tpay-com/tpay-php)
[![PHP version](https://img.shields.io/packagist/php-v/tpay-com/tpay-php.svg)](https://php.net)
[![License](https://img.shields.io/github/license/tpay-com/tpay-php.svg)](LICENSE)
[![CI status](https://github.com/tpay-com/tpay-php/actions/workflows/ci.yaml/badge.svg?branch=master)](https://github.com/tpay-com/tpay-php/actions)
[![Type coverage](https://shepherd.dev/github/tpay-com/tpay-php/coverage.svg)](https://shepherd.dev/github/tpay-com/tpay-php)

[Polish version :poland: wersja polska](./README_PL.md)

## Installation

Install via [Composer](https://getcomposer.org):
```console
composer require tpay-com/tpay-php
```

Install via [Git](https://git-scm.com) over SSH:
```console
git clone git@github.com:tpay-com/tpay-php.git
```

Install via [Git](https://git-scm.com) over HTTPS:
```console
git clone https://github.com/tpay-com/tpay-php.git
```

Manual download:
https://github.com/tpay-com/tpay-php/archive/master.zip

## Configuration

The only thing you need to do is to set your API access data via `$this->` ([see examples](tpayLibs/examples)).
You can generate access keys in [Tpay's merchant panel](https://secure.tpay.com/panel).

The [`loader.php`](tpayLibs/examples/BasicPaymentForm.php) file handles all required class loading, so you can include this file to any file you are editing.
(remember to configure your current working path correctly).

All methods described in [Tpay documentation](https://docs.tpay.com) can be easily executed by extending required class in main [`src`](tpayLibs/src) directory ([see examples](tpayLibs/examples)).

##### Basic Payments and bank selection forms

Example of usages: [basic](tpayLibs/examples/BasicPaymentForm.php), [bank selection HTML form](tpayLibs/examples/BankSelection.php), [bank selection API form](tpayLibs/examples/BankSelectionAPI.php), [BLIK form](tpayLibs/examples/BlikTransactionExample.php).

##### Transaction API / create, get, refund, report

Example of usages: [create transaction](tpayLibs/examples/TransactionApiExample.php), [refund transaction](tpayLibs/examples/TransactionRefund.php), [refund transaction status](tpayLibs/examples/TransactionRefundStatus.php).

##### Card Basic / Card On-Site

Example of usages: [card basic form](tpayLibs/examples/CardBasic.php), [card on-site gateway](tpayLibs/examples/CardGate.php), [card payment links builder](tpayLibs/examples/CardPaymentLinkBuilder.php), [card on-site gateway with saved cards](tpayLibs/examples/CardGateExtended.php).

## Logs

Library has own logging system to save all confirmations and notifications sent by Tpay.com server, outgoing requests and exceptions.
Be sure that file `src/Logs` directory is writable and add rule to Apache `.htaccess` or NGINX to deny access to this area from browser.
The log files are created for each day separately under `Logs` directory.

The logging is enabled by default, but you can disable this feature with:
 ```php
Util::$loggingEnabled = false;
 ```

You can also set your own logging path by this command:
 ```php
Util::$customLogPatch = '/my/own/path/Logs/';
 ```

The logs file names will be assigned automatically.

## Custom templates path

You can set your own templates path, so you can copy and modify the `phtml` template files from this library.
 ```php
Util::$customTemplateDirectory = '/my/own/templates/path/';
 ```

## Language

Currently, the library supports two languages (English and Polish). Default language is English.
Changing language example:
```php
// All Tpay class constructors load Lang class
$tpay = new BankSelectionExample();

// After this line all static messages (input labels, buttons titles etc.) will be displayed in Polish
(new Util())->setLanguage('pl');

// If you want to access translations manually, use:
$language = new Lang();
$language->setLang('pl'); // for setting language
$language->l('pay'); // to echo translated key
```

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT),
but uses third party libraries that are distributed under their own terms ([see `LICENSE-3RD-PARTY.md`](LICENSE-3RD-PARTY.md)).

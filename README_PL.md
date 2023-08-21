# Tpay

Biblioteka dla wszystkich metod płatności dostępnych w [Tpay](https://tpay.com).

[![Najnowsza stabilna wersja](https://img.shields.io/packagist/v/tpay-com/tpay-php.svg?label=obecna%20wersja)](https://packagist.org/packages/tpay-com/tpay-php)
[![Wersja PHP](https://img.shields.io/packagist/php-v/tpay-com/tpay-php.svg)](https://php.net)
[![Licencja](https://img.shields.io/github/license/tpay-com/tpay-php.svg?label=licencja)](LICENSE)
[![CI status](https://github.com/tpay-com/tpay-php/actions/workflows/ci.yaml/badge.svg?branch=master)](https://github.com/tpay-com/tpay-php/actions)
[![Pokrycie typami](https://shepherd.dev/github/tpay-com/tpay-php/coverage.svg)](https://shepherd.dev/github/tpay-com/tpay-php)

[English version :gb: wersja angielska](./README.md)

## Instalacja

Instalacja poprzez [Composer](https://getcomposer.org):
```console
composer require tpay-com/tpay-php
```

Instalacja poprzez [Git](https://git-scm.com) z SSH:
```console
git clone git@github.com:tpay-com/tpay-php.git
```

Instalacja poprzez [Git](https://git-scm.com) z HTTPS:
```console
git clone https://github.com/tpay-com/tpay-php.git
```

Ręczne pobieranie:
https://github.com/tpay-com/tpay-php/archive/master.zip

## Konfiguracja

Jedyne, co musisz zrobić, to ustawić dane dostępu do API za pomocą `$this->` ([zobacz przykłady](examples)).
Klucze dostępu możesz wygenerować w [panelu sprzedawcy Tpay](https://secure.tpay.com/panel).

Plik [`loader.php`](examples/BasicPaymentForm.php) obsługuje ładowanie wszystkich wymaganych klas, więc możesz dołączyć ten plik do dowolnego pliku, który edytujesz.
(pamiętaj o poprawnym skonfigurowaniu bieżącej ścieżki roboczej).

Wszystkie metody opisane w [dokumentacji Tpay](https://docs.tpay.com) można łatwo wykonać poprzez rozszerzenie wymaganej klasy z katalogu głównego [`src`](src) ([zobacz przykłady](examples)).

##### Podstawowe płatności i formularze wyboru banku

Przykłady użycia: [podstawowy](examples/BasicPaymentForm.php), [formularz HTML wyboru banku](examples/BankSelection.php), [formularz API wyboru banku](examples/BankSelectionAPI.php), [formularz BLIK](examples/BlikTransactionExample.php).

##### API transakcji / tworzenie, odbieranie, zwrot, zgłoszenie

Przykład użycia: [utwórz transakcję](examples/TransactionApiExample.php), [zwrot transakcji](examples/TransactionRefund.php), [zwrot statusu transakcji](examples/TransactionRefundStatus.php).

##### Karta podstawowa / Karta On-Site

Przykłady użycia: [podstawowy formularz karty](examples/CardBasic.php), [bramka na stronie karty](examples/CardGate.php), [konstruktor linków do płatności kartą](examples/CardPaymentLinkBuilder.php ), [bramka karty na stronie z zapisanymi kartami](examples/CardGateExtended.php).

## Logi

Biblioteka posiada własny system logowania do zapisywania wszystkich potwierdzeń i powiadomień wysyłanych przez serwer Tpay.com, zapytań wychodzących oraz wyjątków.
Upewnij się, że katalog `src/Logs` jest zapisywalny i dodaj regułę do Apache `.htaccess` lub NGINX, aby zabronić dostępu do tego obszaru z przeglądarki.
Pliki logów są tworzone dla każdego dnia oddzielnie w katalogu `Logs`.

Logowanie jest domyślnie włączone, ale możesz wyłączyć tę funkcję za pomocą:
 ```php
Util::$loggingEnabled = false;
 ```

Możesz także ustawić własną ścieżkę logowania za pomocą tego polecenia:
 ```php
Util::$customLogPatch = '/my/own/path/Logs/';
 ```

Nazwy plików dzienników zostaną przypisane automatycznie.

## Niestandardowa ścieżka szablonów

Możesz ustawić własną ścieżkę szablonów, dzięki czemu możesz kopiować i modyfikować pliki szablonów `phtml` z tej biblioteki.
 ```php
Util::$customTemplateDirectory = '/my/own/templates/path/';
 ```

## Język

Obecnie biblioteka obsługuje dwa języki (angielski i polski). Domyślnym językiem jest angielski.
Przykład zmiany języka:
```php
// Wszystkie konstruktory klas Tpay ładują klasę Lang
$tpay = new BankSelectionExample();

// Po tej linii wszystkie komunikaty statyczne (etykiety, tytuły przycisków itp.) będą wyświetlane w języku polskim
(new Util())->setLanguage('pl');

// Jeśli chcesz ręcznie uzyskać dostęp do tłumaczeń, użyj:
$language = new Lang();
$language->setLang('pl'); // do ustawienia języka
$language->l('pay'); // aby wyświetlić przetłumaczony klucz
```

## Licencja

Ta biblioteka jest udostępniana na [licencji MIT](http://www.opensource.org/licenses/MIT),
ale korzysta z zewnętrznych bibliotek, które są rozpowszechniane na ich własnych warunkach ([zobacz `LICENSE-3RD-PARTY.md`](LICENSE-3RD-PARTY.md)).

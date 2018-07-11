<?php
/**
 * Created by tpay.com.
 * Date: 28.09.2017
 * Time: 12:02
 */

namespace tpayLibs\src\Translations;


class Polish
{
    public $translations = [

        // GLOBALS
        'fee_info'      => 'Za korzystanie z płatności online sprzedawca dolicza: ',
        'pay'           => 'Zapłać z tpay.com',
        'merchant_info' => 'Dane sprzedawcy',
        'amount'        => 'Kwota',
        'order'         => 'Zamówienie',
        // BLIK
        'blik_info'              => 'Wpisz 6 cyfrowy kod i naciśnij "Kupuję i płacę" aby powiązać transakcję blik.',
        'blik_info2'             => 'Jeśli chcesz dokonać tradycyjnej płatności, pozostaw to pole puste.',
        'blik_accept'            => 'Korzystając z tej metody płatności oświadczasz, że akceptujesz',

        // BANK SELECTION
        'cards_and_transfers'    => 'Karty płatnicze i przelewy',
        'other_methods'          => 'Pozostałe',
        'accept'                 => 'Akceptuję',
        'regulations_url'        => 'regulamin',
        'regulations'            => 'serwisu tpay.com',
        'acceptance_is_required' => 'Akceptacja regulaminu jest obowiązkowa, przed rozpoczęciem płatności',

        // CARD

        'card_number'        => 'Numer karty',
        'expiration_date'    => 'Termin ważności',
        'signature'          => 'Dla MasterCard, Visa lub Discover, są to przy ostatnie
             cyfry umieszczone przy podpisie karty.',
        'name_on_card'       => 'Właściciel karty',
        'name_surname'       => 'Imię i nazwisko',
        'save_card'          => 'Zapisz moją kartę',
        'save_card_info'     => 'Zezwolenie na szybszą płatność w przyszłości.
             Dane karty zostaną zapisane na serwerze tpay',
        'processing'         => 'Przetwarzanie danych, proszę czekać...',
        'card_payment'       => 'Zapłać',
        'debit'              => 'Proszę obciążyć moje konto',
        'not_supported_card' => 'Przepraszamy, wprowadzony numer karty jest niepoprawny lub ten typ karty nie jest obecnie obsługiwany. Prosimy skorzystać z innej karty lub wybrać inną metodę płatności.',

        // DAC

        'transfer_details'   => 'Szczegóły przelewu',
        'payment_amount'     => 'Kwota przelewu',
        'disposable_account' => 'Jednorazowy numer konta dla tej transakcji',

        // SZKWAL

        'account_number' => 'Numer konta',
        'payment_title'  => 'Tytuł przelewu',
        'payment_method' => 'Sposób płatności',
        'szkwal_info'    => 'Twój tytuł przelewu jest dedykowany dla Ciebie i bardzo ważny dla identyfikacji wpłaty.
             Możesz stworzyć przelew zdefiniowany w swoim banku, aby wygodnie i szybko zasilić swoje
              konto w przyszłości.',

        // WHITE LABEL

        'go_to_bank' => 'Przejdź do banku',
    ];

}

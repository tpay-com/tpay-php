<?php

/*
 * Created by tpay.com.
 * Date: 09.06.2017
 * Time: 17:56
 */
namespace tpayLibs\src\Dictionaries\ErrorCodes;

class TransactionApiErrors
{
    const ERROR_CODES = [
        'ERR4' => 'The CSV file has not been uploaded',
        'ERR6' => 'Invalid control sum (sign)',
        'ERR7' => 'Invalid line format',
        'ERR8' => 'Invalid bank account format',
        'ERR9' => 'Receiver name can not be empty',
        'ERR10' => 'Receiver name 1 is too long. max - 35 characters',
        'ERR11' => 'Receiver name 2 is too long. max - 35 characters',
        'ERR12' => 'Receiver name 3 is too long. max - 35 characters',
        'ERR13' => 'Receiver name 4 is too long. max - 35 characters',
        'ERR14' => 'Invalid amount format',
        'ERR15' => 'Field title 1 can not be empty',
        'ERR16' => 'Field title 1 is too long. max - 35 characters',
        'ERR17' => 'Field title 2 is too long. max - 35 characters',
        'ERR18' => 'Internal error',
        'ERR19' => 'Failed to load the CSV file',
        'ERR20' => 'Transfer processing error',
        'ERR21' => 'Incorrect pack_id or the package has not been found',
        'ERR22' => 'Package authorization error',
        'ERR23' => 'Insufficient funds for package autorization',
        'ERR24' => 'Package has already been authorized',
        'ERR31' => 'Access disabled',
        'ERR32' => 'Access denied (via Merchant Panel settings)',
        'ERR41' => 'Cannot create refund for this payment channel',
        'ERR42' => 'Invalid refund amount',
        'ERR43' => 'Insufficient funds to create refund',
        'ERR44' => 'Incorrect transaction title',
        'ERR45' => 'Refund amount is too high',
        'ERR51' => 'Cannot create transaction for this channel',
        'ERR52' => 'Error while creating transaction, try again later',
        'ERR53' => 'Input data error',
        'ERR54' => 'No such transaction',
        'ERR55' => 'Incorrect date format or value',
        'ERR61' => 'Invalid BLIK code or alias data format',
        'ERR62' => 'Error connecting BLIK system',
        'ERR63' => 'Invalid BLIK six-digit code',
        'ERR64' => 'Can not pay with BLIK code or alias for non BLIK transaction Transaction was not created with BLIK
         (150) group parameter',
        'ERR65' => 'Incorrect transaction status - should be pending',
        'ERR66' => 'BLIK POS is not available. Try to send type parameter 0 - web purchase',
        'ERR82' => 'Given alias is non-unique',
        'ERR84' => 'Given alias has not been registered or has been deregistered',
        'ERR85' => 'Given alias section is incorrect. See BLIK examples section to check correct parameters set.',
        'ERR96' => 'Cannot create refund for this payment channel',
        'ERR97' => 'No such method',
        'ERR98' => 'Authorisation error (wrong api_key or api_password)',
        'ERR99' => 'General error',
    ];

}

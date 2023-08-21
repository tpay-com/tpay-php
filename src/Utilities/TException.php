<?php

namespace Tpay\OriginApi\Utilities;

use Exception;

class TException extends Exception
{
    /**
     * @param string $message error message
     * @param int    $code    error code
     */
    public function __construct($message, $code = 0)
    {
        $message .= ' in file '.$this->getFile().' line: '.$this->getLine();
        Util::log('TException', $message."\n\n".$this->getTraceAsString());
        $this->message = $code.' : '.$message;

        return $code.' : '.$message;
    }
}

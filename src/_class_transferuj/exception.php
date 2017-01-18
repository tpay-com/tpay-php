<?php
namespace Transferuj;

/**
 * Class TException
 *
 * @package Transferuj
 */
class TException extends \Exception
{
    /**
     * @param string $message error message
     * @param int $code error code
     */
    public function __construct($message, $code = 0)
    {
        require_once(dirname(__FILE__) . '/util.php');

        $message .= ' in file ' . $this->getFile() . ' line: ' . $this->getLine();
        Util::log('TException', $message . "\n\n" . $this->getTraceAsString());

        $this->message = $code . ' : ' . $message;
        return $code . ' : ' . $message;
    }
}

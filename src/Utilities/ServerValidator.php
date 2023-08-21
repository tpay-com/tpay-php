<?php

namespace Tpay\OriginApi\Utilities;

class ServerValidator
{
    const REMOTE_ADDRESS = 'REMOTE_ADDR';
    const FORWARDER_ADDRESS = 'HTTP_X_FORWARDED_FOR';

    /**
     * @var bool
     */
    private $validateForwardedIP;

    /**
     * @var bool
     */
    private $validateServerIP;

    /**
     * @var bool
     */
    private $secureIP;

    public function __construct($validateServerIP, $validateForwardedIP, array $secureIP)
    {
        $this->validateServerIP = $validateServerIP;
        $this->validateForwardedIP = $validateForwardedIP;
        $this->secureIP = $secureIP;
    }

    /**
     * Check if request is called from secure tpay server
     *
     * @return bool
     */
    public function isValid()
    {
        if (!$this->validateServerIP) {
            return true;
        }

        $remoteIP = $this->getServerValue(static::REMOTE_ADDRESS);
        $forwarderIP = $this->getServerValue(static::FORWARDER_ADDRESS);

        if (is_null($remoteIP) && is_null($forwarderIP)) {
            return false;
        }

        if ($this->checkIP($remoteIP)) {
            return true;
        }

        return (bool)($this->validateForwardedIP && $this->checkIP($forwarderIP));
    }

    /**
     * Get value from $_SERVER array if exists
     *
     * @param string $name
     *
     * @return null|string
     */
    private function getServerValue($name)
    {
        if (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        }
    }

    /**
     * Validate if $ip is secure
     *
     * @return bool
     */
    private function checkIP($ip)
    {
        return in_array($ip, $this->secureIP, true);
    }
}

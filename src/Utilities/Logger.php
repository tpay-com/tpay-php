<?php

namespace Tpay\OriginApi\Utilities;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Logger
{
    /** @var LoggerInterface */
    private static $logger;

    /** @var string */
    private static $customLogPath;

    public static function disableLogging()
    {
        self::$logger = new NullLogger();
    }

    /**
     * @param mixed $logger
     *
     * @throws TException
     */
    public static function setLogger($logger)
    {
        if (false === assert($logger instanceof LoggerInterface)) {
            throw new TException(sprintf('%s is not instance of LoggerInterface', get_class($logger)));
        }

        self::$logger = $logger;
    }

    /** @param string $logPath */
    public static function setLogPath($logPath)
    {
        self::$customLogPath = $logPath;
    }

    /** @return FileLogger|LoggerInterface */
    public static function getLogger()
    {
        if (null === self::$logger) {
            self::$logger = new FileLogger(self::$customLogPath);
        }

        return self::$logger;
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $logLevel
     */
    public static function log($title, $text, $logLevel = 'info')
    {
        $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'Empty server REMOTE_ADDR';
        $content = [
            'ip' => $ip,
            'title' => $title,
            'date' => date('Y-m-d H:i:s'),
            'message' => $text,
            'logLevel' => $logLevel,
        ];

        self::getLogger()->log($logLevel, json_encode($content));
    }

    /** @param string $text */
    public static function logLine($text)
    {
        self::$logger->info((string) $text);
    }
}

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

    /**
     * @return void
     */
    public static function disableLogging()
    {
        self::$logger = new NullLogger();
    }

    /**
     * @throws TException
     */
    public static function setLogger($logger)
    {
        if (false === assert($logger instanceof LoggerInterface)) {
            throw new TException(sprintf("%s is not instance of LoggerInterface", get_class($logger)));
        }

        self::$logger = $logger;
    }

    /**
     * @param string $logPath
     *
     * @return void
     */
    public static function setLogPath($logPath)
    {
        self::$customLogPath = $logPath;
    }

    /**
     * @return LoggerInterface|FileLogger
     */
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
     *
     * @return void
     */
    public static function log($title, $text)
    {
        $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'Empty server REMOTE_ADDR';
        $logText = PHP_EOL.'===========================';
        $logText .= PHP_EOL.$title;
        $logText .= PHP_EOL.'===========================';
        $logText .= PHP_EOL.date('Y-m-d H:i:s');
        $logText .= PHP_EOL.'ip: '.$ip;
        $logText .= PHP_EOL;
        $logText .= $text;
        $logText .= PHP_EOL;

        self::getLogger()->info($logText);
    }

    /**
     * @param string $text
     *
     * @return void
     */
    public static function logLine($text)
    {
        self::$logger->info((string) $text);
    }
}

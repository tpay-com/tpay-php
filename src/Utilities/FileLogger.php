<?php

namespace Tpay\OriginApi\Utilities;

class FileLogger
{
    /** @var null|string */
    private $logFilePath;

    /** @param null|string $logFilePath */
    public function __construct($logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    /**
     * @param string $message
     * @throws TException
     */
    public function info($message)
    {
        $this->checkLogFile();
        file_put_contents($this->getLogPath(), $message, FILE_APPEND);
    }

    /** @return string */
    private function getLogPath()
    {
        $logFileName = sprintf("log_%s.log", date('Y-m-d'));

        if (null !== $this->logFilePath) {
            $logPath = $this->logFilePath.$logFileName;
        } else {
            $logPath = sprintf('%s/../Logs/%s', __DIR__, $logFileName);
        }

        return $logPath;
    }

    /**
     * @throws TException
     */
    private function checkLogFile()
    {
        $logFilePath = $this->getLogPath();

        if (!file_exists($logFilePath)) {
            file_put_contents($logFilePath, '<?php exit; ?> '.PHP_EOL);
            chmod($logFilePath, 0644);
        }

        if (!file_exists($logFilePath) || !is_writable($logFilePath)) {
            throw new TException('Unable to create or write the log file');
        }
    }
}

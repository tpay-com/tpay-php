<?php

namespace Tpay\OriginApi\Tests\Utilities;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Tpay\OriginApi\Utilities\Logger;
use Tpay\OriginApi\Utilities\TException;

class LoggerTest extends TestCase
{
    public function testLogged()
    {
        Logger::log('test', 'test');

        $this->assertFileExists($this->logFilename());

        // tearDown
        $this->deleteTestLog();
    }

    public function testDisableLogging()
    {
        Logger::disableLogging();

        Logger::log('test', 'test');

        $this->assertInstanceOf(NullLogger::class, Logger::getLogger());
    }

    public function testCustomLogPath()
    {
        $logPath = __DIR__.'/';
        Logger::setLogPath($logPath);

        Logger::log('test', 'test');

        $this->assertFileExists($this->logFilename($logPath));

        // tearDown
        $this->deleteTestLog($logPath);
    }

    public function testCannotEnableLoggingTwice()
    {
        $this->expectException(TException::class);
        $this->expectExceptionMessage('Logging is already enabled');

        Logger::getLogger();
        Logger::setLogPath();

        Logger::enableLogging();

        $this->deleteTestLog();
    }

    protected function logFilename($logPath = null)
    {
        $logFileName = sprintf('log_%s.log', date('Y-m-d'));

        if ($logPath) {
            return sprintf('%s%s', $logPath, $logFileName);
        }

        return sprintf('%s/../../src/Logs/%s', __DIR__, $logFileName);
    }

    protected function deleteTestLog($logPath = null)
    {
        unlink($this->logFilename($logPath));
    }
}

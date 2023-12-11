<?php

namespace Tpay\OriginApi\Tests\Utilities;

use PHPUnit\Framework\TestCase;
use Tpay\OriginApi\Utilities\Util;

class UtilTest extends TestCase
{
    public function testLogged()
    {
        Util::$loggingEnabled = true;
        Util::$customLogPatch = null;

        Util::log('test', 'test');

        $this->assertFileExists($this->logFilename());

        $this->deleteTestLog();
    }

    public function testDisableLogging()
    {
        Util::$loggingEnabled = false;

        Util::log('test', 'test');

        $this->assertFileDoesNotExist($this->logFilename());
    }

    public function testCustomLogPath()
    {
        Util::$loggingEnabled = true;
        Util::$customLogPatch = __DIR__.'/../';

        Util::log('test', 'test');

        $this->assertSame(__DIR__.'/../', Util::$customLogPatch);
        $this->assertFileExists($this->logFilename());

        $this->deleteTestLog();
    }

    protected function logFilename()
    {
        $logFileName = sprintf('log_%s.log', date('Y-m-d'));

        if (Util::$customLogPatch) {
            return sprintf('%s%s', Util::$customLogPatch, $logFileName);
        }

        return sprintf('%s/../../src/Logs/%s', __DIR__, $logFileName);
    }

    protected function deleteTestLog()
    {
        unlink($this->logFilename());
    }
}

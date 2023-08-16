<?php

namespace Tpay\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class LegacyNamespaceTest extends TestCase
{
    public function testClassesHaveUniqueNames()
    {
        $legacyClassShortNames = array_map(
            function ($className) {
                return (new \ReflectionClass($className))->getShortName();
            },
            self::getLegacyClassNames()
        );

        self::assertSame(
            array_unique($legacyClassShortNames),
            $legacyClassShortNames
        );
    }

    private static function getLegacyClassNames()
    {
        $modelDirectory = realpath(__DIR__.'/../tpayLibs/src');

        $legacyClassNames = [];

        /** @var \SplFileInfo $fileInfo */
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($modelDirectory)) as $fileInfo) {
            if (!$fileInfo->isFile()) {
                continue;
            }
            if ('php' !== $fileInfo->getExtension()) {
                continue;
            }

            $className = 'tpayLibs\\src\\'.substr(
                $fileInfo->getRealPath(),
                strlen($modelDirectory) + 1,
                -4
            );
            $className = str_replace('/', '\\', $className);

            $legacyClassNames[] = $className;
        }

        return $legacyClassNames;
    }
}

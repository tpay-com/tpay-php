<?php

require __DIR__.'/vendor/tpay-com/coding-standards/bootstrap.php';

return Tpay\CodingStandards\PhpCsFixerConfigFactory::createWithLegacyRules()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(false)
            ->in(__DIR__.'/..')
    );

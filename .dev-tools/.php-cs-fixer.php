<?php

require __DIR__.'/vendor/autoload.php';

return Tpay\CodingStandards\PhpCsFixerConfigFactory::createWithLegacyRules()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(false)
            ->in(__DIR__.'/..')
    );

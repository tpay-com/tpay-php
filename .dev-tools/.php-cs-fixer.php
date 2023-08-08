<?php

return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(false)
            ->in(__DIR__ . '/..')
    )
    ->setRules([
        '@PSR12'    =>    true,
        'array_indentation '=> true,
        'visibility_required'=>['elements' => ['method']],
    ]);

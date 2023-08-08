<?php

return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(false)
            ->in(__DIR__ . '/..')
    )
    ->setRules([
        '@PSR12' => true,
        'array_indentation' => true,
        'array_syntax' => true,
        'binary_operator_spaces' => true,
        'visibility_required' => ['elements' => ['method']],
    ]);

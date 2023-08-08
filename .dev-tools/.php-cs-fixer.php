<?php

return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(false)
            ->in(__DIR__.'/..')
    )
    ->setRules([
        '@PSR12' => true,
        'array_indentation' => true,
        'array_syntax' => true,
        'binary_operator_spaces' => true,
        'cast_spaces' => ['space' => 'none'],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
            'space_before_parenthesis' => true,
        ],
        'concat_space' => true,
        'visibility_required' => ['elements' => ['method']],
    ]);

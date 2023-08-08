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
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'none',
                'method' => 'one',
                'property' => 'none',
                'trait_import' => 'none',
            ],
        ],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
            'space_before_parenthesis' => true,
        ],
        'concat_space' => true,
        'header_comment' => ['header' => ''],
        'multiline_whitespace_before_semicolons' => true,
        'no_alias_language_construct_call' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_extra_blank_lines' => ['tokens' => ['attribute', 'break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return', 'square_brace_block', 'switch', 'throw', 'use']],
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_trailing_whitespace' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_useless_concat_operator' => true,
        'no_useless_else' => true,
        'operator_linebreak' => true,
        'ordered_imports' => true,
        'phpdoc_align' => true,
        'phpdoc_no_package' => true,
        'phpdoc_order' => true,
        'phpdoc_param_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types_order' => true,
        'phpdoc_var_annotation_correct_order' => true,
        'return_assignment' => true,
        'simplified_if_return' => true,
        'single_quote' => true,
        'single_space_around_construct' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'trim_array_spaces' => true,
        'visibility_required' => ['elements' => ['method']],
        'yoda_style' => true,
    ]);

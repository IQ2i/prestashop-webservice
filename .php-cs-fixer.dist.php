<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src')
;

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@PSR1' => true,
            '@PSR2' => true,
            '@Symfony' => true,
            'binary_operator_spaces' => ['operators' => ['=>' => 'align']],
            'phpdoc_order' => true,
            'general_phpdoc_annotation_remove' => ['annotations' => ["author", "package"]],
            'align_multiline_comment' => true,
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'compact_nullable_typehint' => true,
            'linebreak_after_opening_tag' => true,
            'method_chaining_indentation' => true,
            'multiline_comment_opening_closing' => true,
            'multiline_whitespace_before_semicolons' => true,
            'no_superfluous_elseif' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'phpdoc_add_missing_param_annotation' => true,
            'phpdoc_types_order' => true,
        ]
    )
    ->setFinder($finder);
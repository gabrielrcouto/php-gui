<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor',
    ])
    ->in([
        __DIR__.'/src/',
        __DIR__.'/test/',
    ])
;

return PhpCsFixer\Config::create()
    ->setRules([
        // Enabled rules
        '@PSR2'                           => true,
        '@PhpCsFixer'                     => true,
        '@Symfony'                        => true,
        '@Symfony:risky'                  => true,
        '@PHP56Migration'                 => true,
        'linebreak_after_opening_tag'     => true,
        'logical_operators'               => true,
        'mb_str_functions'                => true,
        'native_function_invocation'      => true,
        'no_php4_constructor'             => true,
        'simplified_null_return'          => true,
        'strict_param'                    => true,
        'no_superfluous_phpdoc_tags'      => [
            'allow_mixed' => true,
        ],
        'array_syntax'                    => [
            'syntax' => 'short',
        ],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],

        // Disabled rules
        'increment_style' => false,
        'non_printable_character' => false,
        'declare_strict_types' => false
    ])
    ->setRiskyAllowed(true)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setUsingCache(true)
    ->setFinder($finder)
;

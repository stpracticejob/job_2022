<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('.')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();

return $config->setRules([
        '@PSR12' => true,
        'cast_spaces' => true,
	'binary_operator_spaces' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
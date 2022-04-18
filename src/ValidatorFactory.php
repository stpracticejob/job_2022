<?php

namespace Job;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;

class ValidatorFactory
{
    private $factory;

    public function __construct()
    {
        $this->factory = new Validation\Factory(
            $this->loadTranslator()
        );
    }

    protected function loadTranslator()
    {
//        $filesystem = new Filesystem();
        //
        //       $loader = new Translation\FileLoader(
        //           $filesystem, dirname(dirname(__FILE__)) . '/lang');
        //           $loader->addNamespace(
        //               'lang',
        //               dirname(dirname(__FILE__)) . '/lang'
        //           );
        //       $loader->load('en', 'validation', 'lang');
        $loader = new Translation\ArrayLoader();
        $loader->load('en', 'validation', 'lang');
        return new Translation\Translator($loader, 'en');
    }

    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }
}

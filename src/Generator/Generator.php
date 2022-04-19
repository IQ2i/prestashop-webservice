<?php

namespace IQ2i\PrestashopWebservice\Generator;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;

class Generator
{
    private Inflector $inflector;

    public function __construct()
    {
        $this->inflector = InflectorFactory::create()->build();
    }

    public function generate(): void
    {

    }
}
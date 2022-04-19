<?php

namespace IQ2i\PrestashopWebservice\Generator;

class Field
{
    public function __construct(
        private string $name,
        private string $type,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
<?php

namespace IQ2i\PrestashopWebservice\Http\Query;

abstract class Attribute
{
    abstract public function getField(): string;

    abstract public function getValue(): string;

    public function normalize(): array
    {
        return [$this->getField() => $this->getValue()];
    }
}

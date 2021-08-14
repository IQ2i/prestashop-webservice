<?php

declare(strict_types=1);

/*
 * This file is part of the PrestashopWebservice package.
 *
 * (c) Loïc Sapone <loic@sapone.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

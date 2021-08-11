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

class Limit extends Attribute
{
    private $number;
    private $index;

    public function __construct(int $number, int $index = null)
    {
        $this->number = $number;
        $this->index = $index;
    }

    public function getField(): string
    {
        return 'limit';
    }

    public function getValue(): string
    {
        if (null !== $this->index) {
            return sprintf('%d,%d', $this->index, $this->number);
        }

        return (string) $this->number;
    }
}

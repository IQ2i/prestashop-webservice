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

namespace IQ2i\PrestashopWebservice\Http\QueryAttribute;

class Display extends QueryAttribute
{
    public const FULL = 'full';

    public function __construct(
        private array|string $fields
    ) {
    }

    public function getField(): string
    {
        return 'display';
    }

    public function getValue(): string
    {
        if (is_array($this->fields)) {
            return sprintf('[%s]', implode(',', $this->fields));
        }

        return $this->fields;
    }
}

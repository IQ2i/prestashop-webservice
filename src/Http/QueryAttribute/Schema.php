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

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;

class Schema extends QueryAttribute
{
    public const BLANK = 'blank';
    public const SYNOPSIS = 'synopsis';

    private const AVAILABLE_TYPES = [
        self::BLANK,
        self::SYNOPSIS,
    ];

    public function __construct(
        private string $type
    ) {
        if (!in_array($type, self::AVAILABLE_TYPES)) {
            throw new InvalidArgument(sprintf('Unknown schema type %s.', $type));
        }
    }

    public function getField(): string
    {
        return 'schema';
    }

    public function getValue(): string
    {
        return $this->type;
    }
}

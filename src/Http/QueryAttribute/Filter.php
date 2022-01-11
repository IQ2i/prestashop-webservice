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

class Filter extends QueryAttribute
{
    public const OR = 'or';
    public const INTERVAL = 'interval';
    public const LITERAL = 'literal';
    public const BEGIN = 'begin';
    public const END = 'end';
    public const CONTAINS = 'contains';

    private const AVAILABLE_OPERATORS = [
        self::OR,
        self::INTERVAL,
        self::LITERAL,
        self::BEGIN,
        self::END,
        self::CONTAINS,
    ];

    private const SINGLE_VALUE_OPERATORS = [
        self::LITERAL,
        self::BEGIN,
        self::END,
        self::CONTAINS,
    ];

    public function __construct(
        private string $field,
        private array|string $values,
        private string $operator
    ) {
        if (!in_array($operator, self::AVAILABLE_OPERATORS)) {
            throw new InvalidArgument(sprintf('Unknown operator %s.', $operator));
        }

        if (in_array($operator, self::SINGLE_VALUE_OPERATORS) && is_array($values)) {
            throw new InvalidArgument(sprintf('`values` must be a string when using %s operator.', $operator));
        }
    }

    public function getField(): string
    {
        return sprintf('field[%s]', $this->field);
    }

    public function getValue(): string
    {
        return match ($this->operator) {
            self::OR       => sprintf('[%s]', implode('|', $this->values)),
            self::INTERVAL => sprintf('[%s]', implode(',', $this->values)),
            self::LITERAL  => sprintf('[%s]', $this->values),
            self::BEGIN    => sprintf('[%s]%%', $this->values),
            self::END      => sprintf('%%[%s]', $this->values),
            self::CONTAINS => sprintf('%%[%s]%%', $this->values),
            default        => throw new InvalidArgument(\sprintf('Unknown operator "%s" used in filter.". ', $this->values)),
        };
    }
}

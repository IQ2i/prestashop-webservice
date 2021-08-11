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

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;

class Filter extends Attribute
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

    private $field;
    private $values;
    private $operator;

    /**
     * @param array|string $values
     */
    public function __construct(string $field, $values, string $operator)
    {
        if (!in_array($operator, self::AVAILABLE_OPERATORS)) {
            throw new InvalidArgument(sprintf('Unknown operator %s.', $operator));
        }

        if (in_array($operator, self::SINGLE_VALUE_OPERATORS) && is_array($values)) {
            throw new InvalidArgument(sprintf('`values` must be a string when using %s operator.', $operator));
        }

        $this->field = $field;
        $this->values = $values;
        $this->operator = $operator;
    }

    public function getField(): string
    {
        return sprintf('field[%s]', $this->field);
    }

    public function getValue(): string
    {
        switch ($this->operator) {
            case self::OR:
                return sprintf('[%s]', implode('|', $this->values));

            case self::INTERVAL:
                return sprintf('[%s]', implode(',', $this->values));

            case self::LITERAL:
                return sprintf('[%s]', $this->values);

            case self::BEGIN:
                return sprintf('[%s]%%', $this->values);

            case self::END:
                return sprintf('%%[%s]', $this->values);

            case self::CONTAINS:
                return sprintf('%%[%s]%%', $this->values);

            default:
                throw new InvalidArgument(\sprintf('Unknown operator "%s" used in filter.". ', $this->values));
        }
    }
}

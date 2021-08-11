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

class Sort extends Attribute
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    private const AVAILABLE_ORDER_BY = [
        self::ASC,
        self::DESC,
    ];

    private $fields;

    public function __construct(array $fields)
    {
        if (0 < count($invalidOrderBys = array_diff(array_values($fields), self::AVAILABLE_ORDER_BY))) {
            throw new InvalidArgument(sprintf('Unknown order by(s) `%s`.', implode('`, `', array_keys($invalidOrderBys))));
        }

        $this->fields = $fields;
    }

    public function getField(): string
    {
        return 'sort';
    }

    public function getValue(): string
    {
        $values = [];
        foreach ($this->fields as $name => $orderBy) {
            $values[] = sprintf('%s_%s', $name, strtoupper($orderBy));
        }

        return sprintf('[%s]', implode(',', $values));
    }
}

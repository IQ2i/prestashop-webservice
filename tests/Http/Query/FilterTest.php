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

namespace IQ2i\PrestashopWebservice\Tests\Http\Query;

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;
use IQ2i\PrestashopWebservice\Http\Query\Filter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testOr()
    {
        $filter = new Filter('id', [1, 2], Filter::OR);
        $this->assertEquals(['field[id]' => '[1|2]'], $filter->normalize());
    }

    public function testInterval()
    {
        $filter = new Filter('id', [1, 5], Filter::INTERVAL);
        $this->assertEquals(['field[id]' => '[1,5]'], $filter->normalize());
    }

    public function testLiteral()
    {
        $filter = new Filter('name', 'John', Filter::LITERAL);
        $this->assertEquals(['field[name]' => '[John]'], $filter->normalize());
    }

    public function testBegin()
    {
        $filter = new Filter('name', 'Jo', Filter::BEGIN);
        $this->assertEquals(['field[name]' => '[Jo]%'], $filter->normalize());
    }

    public function testEnd()
    {
        $filter = new Filter('name', 'hn', Filter::END);
        $this->assertEquals(['field[name]' => '%[hn]'], $filter->normalize());
    }

    public function testContains()
    {
        $filter = new Filter('name', 'oh', Filter::CONTAINS);
        $this->assertEquals(['field[name]' => '%[oh]%'], $filter->normalize());
    }

    public function testUnknownOperator()
    {
        $this->expectException(InvalidArgument::class);
        $filter = new Filter('name', 'John', 'wrongoperator');
    }

    public function testWrongValueType()
    {
        $this->expectException(InvalidArgument::class);
        $filter = new Filter('id', [1, 5], Filter::LITERAL);
    }
}
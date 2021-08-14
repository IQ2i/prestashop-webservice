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
use IQ2i\PrestashopWebservice\Http\Query\Sort;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    public function testSingle()
    {
        $sort = new Sort(['field1' => Sort::ASC]);
        $this->assertEquals(['sort' => '[field1_ASC]'], $sort->normalize());
    }

    public function testMultiple()
    {
        $sort = new Sort(['field1' => Sort::ASC, 'field2' => Sort::DESC]);
        $this->assertEquals(['sort' => '[field1_ASC,field2_DESC]'], $sort->normalize());
    }

    public function testUnknownOrderBy()
    {
        $this->expectException(InvalidArgument::class);
        new Sort(['field1' => 'test']);
    }
}
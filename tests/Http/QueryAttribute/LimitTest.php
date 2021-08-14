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

namespace IQ2i\PrestashopWebservice\Tests\Http\QueryAttribute;

use IQ2i\PrestashopWebservice\Http\QueryAttribute\Limit;
use PHPUnit\Framework\TestCase;

class LimitTest extends TestCase
{
    public function testNumber()
    {
        $limit = new Limit(10);
        $this->assertEquals(['limit' => '10'], $limit->normalize());
    }

    public function testNumberAndIndex()
    {
        $limit = new Limit(10, 20);
        $this->assertEquals(['limit' => '20,10'], $limit->normalize());
    }
}
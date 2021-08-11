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

use IQ2i\PrestashopWebservice\Http\Query\Display;
use PHPUnit\Framework\TestCase;

class DisplayTest extends TestCase
{
    public function testSingle()
    {
        $display = new Display('full');
        $this->assertEquals(['display' => 'full'], $display->normalize());
    }

    public function testMultiple()
    {
        $display = new Display(['field1', 'field2']);
        $this->assertEquals(['display' => '[field1,field2]'], $display->normalize());
    }
}
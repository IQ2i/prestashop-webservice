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

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;
use IQ2i\PrestashopWebservice\Http\QueryAttribute\Schema;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    public function testKnownType()
    {
        $schema = new Schema(Schema::BLANK);
        $this->assertEquals(['schema' => 'blank'], $schema->normalize());
    }

    public function testUnknownType()
    {
        $this->expectException(InvalidArgument::class);
        new Schema('wrongtype');
    }
}
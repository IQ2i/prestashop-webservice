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

namespace IQ2i\PrestashopWebservice\Tests\Util;

use IQ2i\PrestashopWebservice\Util\PropertyFormatGuesser;
use PHPUnit\Framework\TestCase;

class PropertyFormatGuesserTest extends TestCase
{
    public function testGuessType()
    {
        $this->assertEquals('string', PropertyFormatGuesser::guessType('isEmail'));
        $this->assertEquals('float', PropertyFormatGuesser::guessType('isFloat'));
    }

    public function testGuessUnknownType()
    {
        $this->assertNull(PropertyFormatGuesser::guessType('unknownFormat'));
    }
}

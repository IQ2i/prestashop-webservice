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

namespace IQ2i\PrestashopWebservice\Tests\Http;

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;
use IQ2i\PrestashopWebservice\Http\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private const OPTION_URL = 'https://my-domain.com/api/';
    private const OPTION_KEY = '3FDXTL3PBBBUSBYLCPAMLAEF9E598PPS';

    public function testCreate()
    {
        $configuration = Configuration::create(['url' => self::OPTION_URL, 'key' => self::OPTION_KEY]);

        $this->assertEquals(self::OPTION_URL, $configuration->get('url'));
        $this->assertEquals(self::OPTION_KEY, $configuration->get('key'));
    }

    public function testCreateWithMissingOption()
    {
        $this->expectException(InvalidArgument::class);

        Configuration::create(['url' => self::OPTION_URL]);
    }

    public function testCreateWithUnknownOption()
    {
        $this->expectException(InvalidArgument::class);

        Configuration::create(['url' => self::OPTION_URL, 'foo' => self::OPTION_KEY]);
    }

    public function testHas()
    {
        $configuration = Configuration::create(['url' => self::OPTION_URL, 'key' => self::OPTION_KEY]);

        $this->assertTrue($configuration->has('url'));
    }

    public function testHasWithUnknownOption()
    {
        $this->expectException(InvalidArgument::class);

        $configuration = Configuration::create(['url' => self::OPTION_URL, 'key' => self::OPTION_KEY]);

        $this->assertTrue($configuration->has('foo'));
    }

    public function testGet()
    {
        $configuration = Configuration::create(['url' => self::OPTION_URL, 'key' => self::OPTION_KEY]);

        $this->assertEquals(self::OPTION_URL, $configuration->get('url'));
    }

    public function testGetWithUnknownOption()
    {
        $this->expectException(InvalidArgument::class);

        $configuration = Configuration::create(['url' => self::OPTION_URL, 'key' => self::OPTION_KEY]);

        $this->assertEquals(self::OPTION_KEY, $configuration->get('foo'));
    }
}

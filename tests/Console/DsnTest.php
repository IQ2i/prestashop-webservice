<?php

namespace IQ2i\PrestashopWebservice\Tests\Console;

use IQ2i\PrestashopWebservice\Console\Dsn;
use PHPUnit\Framework\TestCase;

class DsnTest extends TestCase
{
    public function testNew()
    {
        $dsn = new Dsn('https://6MBWZM37S6XCZXYT81GD6XD41SKZ14TP@localhost:8080/api');

        $this->assertEquals('https://localhost:8080/api', $dsn->getUrl());
        $this->assertEquals('6MBWZM37S6XCZXYT81GD6XD41SKZ14TP', $dsn->getKey());
    }
}
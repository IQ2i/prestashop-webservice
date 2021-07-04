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

use IQ2i\PrestashopWebservice\Http\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client([
            'url' => 'http://localhost:8080/api/',
            'key' => '6MBWZM37S6XCZXYT81GD6XD41SKZ14TP',
        ]);
    }

    public function testList()
    {
        $response = $this->client->list('categories');

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertArrayHasKey('categories', $response->getContent());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());
    }

    public function testCreate()
    {
        $response = $this->client->create('categories', file_get_contents(__DIR__.'/../fixtures/xml/create_category.xml'));

        $this->assertEquals('201', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals('Futuristic clothes', $content['category']['name']['language']['#']);
    }

    public function testGet()
    {
        $response = $this->client->get('categories', 2);

        $this->assertEquals('200', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals('Home', $content['category']['name']['language']['#']);
    }

    public function testUpdate()
    {
        $response = $this->client->update('categories', 3, file_get_contents(__DIR__.'/../fixtures/xml/update_category.xml'));

        $this->assertEquals('200', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals('Vintage clothes', $content['category']['name']['language']['#']);
    }

    public function testUpdateInvalidResource()
    {
        $response = $this->client->update('categories', 99, file_get_contents(__DIR__.'/../fixtures/xml/update_invalid_resource.xml'));

        $this->assertEquals('404', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals('Invalid ID', $content['errors']['error']['message']);
    }

    public function testDelete()
    {
        $response = $this->client->delete('categories', 6);

        $this->assertEquals('200', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals([], $content);
    }

    public function testDeleteInvalidResource()
    {
        $response = $this->client->delete('categories', 99);

        $this->assertEquals('404', $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEquals('Id(s) not exists: 99', $content['errors']['error']['message']);
    }
}
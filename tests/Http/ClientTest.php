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
use IQ2i\PrestashopWebservice\Http\QueryAttribute\Schema;
use IQ2i\PrestashopWebservice\Http\Request\CreateRequest;
use IQ2i\PrestashopWebservice\Http\Request\DeleteRequest;
use IQ2i\PrestashopWebservice\Http\Request\GetRequest;
use IQ2i\PrestashopWebservice\Http\Request\ListRequest;
use IQ2i\PrestashopWebservice\Http\Request\SchemaRequest;
use IQ2i\PrestashopWebservice\Http\Request\UpdateRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;

class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client(
            ['url' => '', 'key' => ''],
            new MockHttpClient(new MockClientCallback())
        );
    }

    public function testSchema()
    {
        $request = (new SchemaRequest('categories'))
            ->addQueryAttribute(new Schema(Schema::SYNOPSIS));
        $response = $this->client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('true', $content['category']['name']['@required']);
    }

    public function testList()
    {
        $request = new ListRequest('categories');
        $response = $this->client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertArrayHasKey('categories', $content);
    }

    public function testCreate()
    {
        $request = (new CreateRequest('categories'))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/create_category.xml'));
        $response = $this->client->execute($request);

        $this->assertEquals('201', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Futuristic clothes', $content['category']['name']['language']['#']);
    }

    public function testGet()
    {
        $request = new GetRequest('categories', 2);
        $response = $this->client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Home', $content['category']['name']['language']['#']);
    }

    public function testUpdate()
    {
        $request = (new UpdateRequest('categories', 10))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/update_category.xml'));
        $response = $this->client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Vintage clothes', $content['category']['name']['language']['#']);
    }

    public function testUpdateInvalidResource()
    {
        $request = (new UpdateRequest('categories', 99))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/update_invalid_resource.xml'));
        $response = $this->client->execute($request);

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Invalid ID', $content['errors']['error']['message']);
    }

    public function testDelete()
    {
        $request = new DeleteRequest('categories', 10);
        $response = $this->client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals([], $content);
    }

    public function testDeleteInvalidResource()
    {
        $request = new DeleteRequest('categories', 99);
        $response = $this->client->execute($request);

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Id(s) not exists: 99', $content['errors']['error']['message']);
    }
}
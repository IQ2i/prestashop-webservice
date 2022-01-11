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
use Symfony\Component\HttpClient\Response\MockResponse;

class ClientTest extends TestCase
{
    public function testSchema()
    {
        $client = $this->initClient('schema_categories.xml');

        $request = (new SchemaRequest('categories'))
            ->addQueryAttribute(new Schema(Schema::SYNOPSIS));
        $response = $client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('true', $content['category']['name']['@required']);
    }

    public function testList()
    {
        $client = $this->initClient('list_categories.xml');

        $request = new ListRequest('categories');
        $response = $client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertArrayHasKey('categories', $content);
    }

    public function testCreate()
    {
        $client = $this->initClient('create_category.xml', 201);

        $request = (new CreateRequest('categories'))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/create_category.xml'));
        $response = $client->execute($request);

        $this->assertEquals('201', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Futuristic clothes', $content['category']['name']['language']['#']);
    }

    public function testGet()
    {
        $client = $this->initClient('get_category.xml');

        $request = new GetRequest('categories', 2);
        $response = $client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Home', $content['category']['name']['language']['#']);
    }

    public function testUpdate()
    {
        $client = $this->initClient('update_category.xml');

        $request = (new UpdateRequest('categories', 10))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/update_category.xml'));
        $response = $client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Vintage clothes', $content['category']['name']['language']['#']);
    }

    public function testUpdateInvalidResource()
    {
        $client = $this->initClient('update_invalid_category.xml', 404);

        $request = (new UpdateRequest('categories', 99))
            ->setBody(file_get_contents(__DIR__ . '/../fixtures/http/request/update_invalid_resource.xml'));
        $response = $client->execute($request);

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Invalid ID', $content['errors']['error']['message']);
    }

    public function testDelete()
    {
        $client = $this->initClient('delete_category.xml');

        $request = new DeleteRequest('categories', 10);
        $response = $client->execute($request);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals([], $content);
    }

    public function testDeleteInvalidResource()
    {
        $client = $this->initClient('delete_invalid_category.xml', 404);

        $request = new DeleteRequest('categories', 99);
        $response = $client->execute($request);

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertContains('X-Powered-By: PrestaShop Webservice', $response->getHeaders());

        $content = $response->getContent();
        $this->assertEquals('Id(s) not exists: 99', $content['errors']['error']['message']);
    }

    private function initClient(string $bodyFilename, int $statusCode = 200): Client
    {
        $mockResponse = new MockResponse(file_get_contents(__DIR__.'/../fixtures/http/response/'.$bodyFilename), [
            'http_code' => $statusCode,
            'response_headers' => [
                'PSWS-Version: 1.7.7.5',
                'X-Powered-By: PrestaShop Webservice'
            ],
        ]);

        return new Client([
                'url' => 'http://localhost:8080/api/',
                'key' => '6MBWZM37S6XCZXYT81GD6XD41SKZ14TP',
            ],
            new MockHttpClient($mockResponse, 'http://localhost:8080/api/')
        );
    }
}
<?php

namespace IQ2i\PrestashopWebservice\Tests\Http;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MockClientCallback
{
    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        $body = '';
        $headers = [
            'response_headers' => [
                'PSWS-Version: 1.7.7.5',
                'X-Powered-By: PrestaShop Webservice'
            ]
        ];

        if (str_ends_with($url, '/categories?schema=synopsis')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/schema_categories.xml');
        }

        if ('GET' === $method && str_ends_with($url, '/categories')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/list_categories.xml');
        }

        if ('POST' === $method && str_ends_with($url, '/categories')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/create_category.xml');
            $headers = array_merge($headers, ['http_code' => 201]);
        }

        if ('GET' === $method && str_ends_with($url, '/categories/2')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/get_category.xml');
        }

        if ('PUT' === $method && str_ends_with($url, '/categories/10')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/update_category.xml');
        }

        if ('PUT' === $method && str_ends_with($url, '/categories/99')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/update_invalid_category.xml');
            $headers = array_merge($headers, ['http_code' => 404]);
        }

        if ('DELETE' === $method && str_ends_with($url, '/categories/10')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/delete_category.xml');
        }

        if ('DELETE' === $method && str_ends_with($url, '/categories/99')) {
            $body = file_get_contents(__DIR__.'/../fixtures/http/response/delete_invalid_category.xml');
            $headers = array_merge($headers, ['http_code' => 404]);
        }

        return new MockResponse($body, $headers);
    }
}
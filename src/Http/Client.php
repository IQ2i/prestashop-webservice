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

namespace IQ2i\PrestashopWebservice\Http;

use IQ2i\PrestashopWebservice\Exception\NetworkException;
use IQ2i\PrestashopWebservice\Exception\SerializationException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client
{
    /** @var Configuration */
    private $configuration;

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(array $options = [], ?HttpClientInterface $httpClient = null, ?LoggerInterface $logger = null)
    {
        $this->configuration = Configuration::create($options);

        if (null === $httpClient) {
            $httpClient = HttpClient::createForBaseUri($this->configuration->get('url'), [
                'auth_basic' => [$this->configuration->get('key'), ''],
                'headers'    => [
                    'Accept'       => 'text/xml',
                    'Content-Type' => 'text/xml',
                ],
            ]);
        }
        $this->httpClient = $httpClient;

        if (null === $logger) {
            $logger = new NullLogger();
        }
        $this->logger = $logger;
    }

    public function list(?string $resource = '', array $headers = [], array $query = []): Response
    {
        return $this->execute(new Request(
            'GET',
            $resource,
            null,
            $headers,
            $query
        ));
    }

    public function create(string $resource, string $body = null, array $headers = [], array $query = []): Response
    {
        return $this->execute(new Request(
            'POST',
            $resource,
            $body,
            $headers,
            $query
        ));
    }

    public function get(string $resource, int $identifier, array $headers = [], array $query = []): Response
    {
        return $this->execute(new Request(
            'GET',
            $resource.'/'.$identifier,
            null,
            $headers,
            $query
        ));
    }

    public function update(string $resource, int $identifier, string $body = null, array $headers = [], array $query = []): Response
    {
        return $this->execute(new Request(
            'PUT',
            $resource.'/'.$identifier,
            $body,
            $headers,
            $query
        ));
    }

    public function delete(string $resource, int $identifier, array $headers = [], array $query = []): Response
    {
        return $this->execute(new Request(
            'DELETE',
            $resource.'/'.$identifier,
            null,
            $headers,
            $query
        ));
    }

    private function execute(Request $request): Response
    {
        try {
            $response = $this->httpClient->request(
                $request->getMethod(),
                $request->getUri(),
                [
                    'body'    => $request->getBody(),
                    'headers' => $request->getHeaders(),
                    'query'   => $request->getQueryAttributes(),
                ]
            );

            $this->logger->info('HTTP request sent: {method} {uri}', [
                'method' => $request->getMethod(),
                'uri'    => $request->getUri(),
            ]);
        } catch (TransportExceptionInterface $e) {
            throw new NetworkException('Could not contact remote server.', 0, $e);
        }

        return $this->parseResponse($response);
    }

    private function parseResponse(ResponseInterface $response): Response
    {
        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new NetworkException('Could not contact remote server.', 0, $e);
        }

        try {
            $content = $response->getContent(false);

            $data = [];
            if (!empty($content)) {
                $serializer = new Serializer([], [new XmlEncoder()]);
                $data = $serializer->decode($content, 'xml');
            }
        } catch (UnexpectedValueException $e) {
            throw new SerializationException($e->getMessage());
        }

        $responseHeaders = $response->getInfo('response_headers');

        return new Response($statusCode, $data, $responseHeaders);
    }
}

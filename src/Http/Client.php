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
use IQ2i\PrestashopWebservice\Http\Request\Request;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private Configuration $configuration;
    private HttpClientInterface $httpClient;
    private LoggerInterface $logger;

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

    public function execute(Request $request): Response
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

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new NetworkException('Could not contact remote server.', 0, $e);
        }

        $content = $response->getContent(false);

        try {
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

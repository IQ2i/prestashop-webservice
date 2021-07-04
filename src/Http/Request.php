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

class Request
{
    /** @var string */
    private $method;

    /** @var string */
    private $uri;

    /** @var null|string */
    private $body;

    /** @var array */
    private $headers;

    /** @var array */
    private $query;

    public function __construct(string $method, string $uri, ?string $body = null, ?array $headers = [], ?array $query = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        $this->headers = [];
        foreach ($headers as $key => $value) {
            $this->headers[strtolower($key)] = (string) $value;
        }
        $this->query = $query;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function hasHeader(string $name): bool
    {
        return \array_key_exists(strtolower($name), $this->headers);
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[strtolower($name)] ?? null;
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[strtolower($name)] = $value;
    }

    public function removeHeader(string $name): void
    {
        unset($this->headers[strtolower($name)]);
    }

    public function getQueryAttributes(): array
    {
        return $this->query;
    }

    public function setQueryAttributes(array $query): void
    {
        $this->query = $query;
    }

    public function hasQueryAttribute(string $name): bool
    {
        return \array_key_exists($name, $this->query);
    }

    public function getQueryAttribute(string $name): ?string
    {
        return $this->query[$name] ?? null;
    }

    public function addQueryAttribute(string $name, string $value): void
    {
        $this->query[$name] = $value;
    }

    public function removeQueryAttribute(string $name): void
    {
        unset($this->query[$name]);
    }
}

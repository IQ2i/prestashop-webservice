<?php

namespace IQ2i\PrestashopWebservice\Http\Request;

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;
use IQ2i\PrestashopWebservice\Http\Query\Attribute;

abstract class Request
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    private $body;
    private $headers = [];
    private $queryAttributes = [];

    abstract public function getMethod(): string;

    abstract public function getUri(): string;

    abstract public function getAvailableQueryAttributes(): array;

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[strtolower($name)] = $value;

        return $this;
    }

    public function getQueryAttributes(): array
    {
        return $this->queryAttributes;
    }

    public function addQueryAttribute(Attribute $queryAttribute): self
    {
        if (!in_array(get_class($queryAttribute), $this->getAvailableQueryAttributes())) {
            throw new InvalidArgument(sprintf('Forbidden %s query attribute in %s.', get_class($queryAttribute), __CLASS__));
        }

        $this->queryAttributes = array_merge($this->queryAttributes, $queryAttribute->normalize());

        return $this;
    }
}

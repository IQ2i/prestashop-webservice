<?php

namespace IQ2i\PrestashopWebservice\Console;

use IQ2i\PrestashopWebservice\Exception\InvalidArgumentException;

final class Dsn
{
    private string $url;
    private string $key;

    public function __construct(string $dsn)
    {
        if (false === $parsedDsn = parse_url($dsn)) {
            throw new InvalidArgumentException(sprintf('The "%s" DSN is invalid.', $dsn));
        }

        if (!isset($parsedDsn['scheme'])) {
            throw new InvalidArgumentException(sprintf('The "%s" DSN must contain a scheme.', $dsn));
        }

        if (!isset($parsedDsn['user'])) {
            throw new InvalidArgumentException(sprintf('The "%s" DSN must contain a user.', $dsn));
        }

        if (!isset($parsedDsn['host'])) {
            throw new InvalidArgumentException(sprintf('The "%s" DSN must contain a host.', $dsn));
        }

        $this->url = $parsedDsn['scheme'].'://'.$parsedDsn['host'].($parsedDsn['port'] ? ':'.$parsedDsn['port'] : '').$parsedDsn['path'];
        $this->key = urldecode($parsedDsn['user']);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
